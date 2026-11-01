<?php

namespace Tests\Feature;

use App\Models\AboutShowcaseProduct;
use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class AboutShowcaseTest extends TestCase
{
    protected function getAdminUser()
    {
        return User::where('is_admin', true)->first();
    }

    public function test_about_page_renders_query_loop_3d_product_carousel()
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertSee('about-showcase');
        $response->assertSee('queryloop-stage');
        $response->assertSee('queryloop-prev');
        $response->assertSee('queryloop-next');
        $response->assertSee('queryloop-card');
        $response->assertSee('Premium Retail Kiosk');
    }

    public function test_guests_cannot_access_about_showcase_admin()
    {
        $response = $this->get('/admin/about-showcase');
        $response->assertRedirect('/admin/login');
    }

    public function test_admin_can_view_about_showcase_management()
    {
        $admin = $this->getAdminUser();

        $response = $this->actingAs($admin)->get('/admin/about-showcase');

        $response->assertStatus(200);
        $response->assertSee('About Pathy – Query Loop 3D Product Carousel');
        $response->assertSee('Add Product to Showcase');
        $response->assertSee('--admin-bg: #F8FAFC');
        $response->assertSee('admin-theme-toggle');
    }

    public function test_admin_can_add_product_to_showcase()
    {
        $admin = $this->getAdminUser();

        // Create a new product to add
        $newProduct = Product::create([
            'category_id'       => 1,
            'name'              => 'Special Showcase Prototype Kiosk',
            'slug'              => 'special-showcase-prototype-kiosk',
            'short_description' => 'A cutting-edge showcase kiosk.',
            'description'       => 'Full kiosk description.',
            'is_active'         => true,
            'sort_order'        => 99,
        ]);

        $response = $this->actingAs($admin)->post('/admin/about-showcase', [
            'product_id'    => $newProduct->id,
            'display_order' => 10,
            'custom_badge'  => 'New Innovation',
            'is_active'     => '1',
        ]);

        $response->assertRedirect('/admin/about-showcase');
        $response->assertSessionHas('success');

        $item = AboutShowcaseProduct::where('product_id', $newProduct->id)->first();
        $this->assertNotNull($item);
        $this->assertEquals('New Innovation', $item->custom_badge);
        $this->assertEquals(10, $item->display_order);

        // Verify it appears on the public /about page
        $aboutResponse = $this->get('/about');
        $aboutResponse->assertSee('Special Showcase Prototype Kiosk');
        $aboutResponse->assertSee('New Innovation');

        // Cleanup
        $item->delete();
        $newProduct->delete();
    }

    public function test_admin_can_toggle_showcase_item_status()
    {
        $admin = $this->getAdminUser();
        $item = AboutShowcaseProduct::first();
        $initialStatus = $item->is_active;

        $response = $this->actingAs($admin)->post("/admin/about-showcase/{$item->id}/toggle-status");
        $response->assertRedirect();

        $item->refresh();
        $this->assertEquals(!$initialStatus, $item->is_active);

        // Toggle back to original
        $this->actingAs($admin)->post("/admin/about-showcase/{$item->id}/toggle-status");
        $item->refresh();
        $this->assertEquals($initialStatus, $item->is_active);
    }

    public function test_admin_can_update_showcase_item_order_and_badge()
    {
        $admin = $this->getAdminUser();
        $item = AboutShowcaseProduct::first();

        $response = $this->actingAs($admin)->put("/admin/about-showcase/{$item->id}", [
            'display_order' => 88,
            'custom_badge'  => 'Updated Badge',
            'is_active'     => '1',
        ]);

        $response->assertRedirect('/admin/about-showcase');
        $item->refresh();

        $this->assertEquals(88, $item->display_order);
        $this->assertEquals('Updated Badge', $item->custom_badge);
    }

    public function test_admin_can_remove_product_from_showcase_without_deleting_product()
    {
        $admin = $this->getAdminUser();

        // Create temporary product and showcase item
        $product = Product::create([
            'category_id' => 1,
            'name'        => 'Temporary Product For Removal Test',
            'slug'        => 'temporary-product-removal-test',
            'is_active'   => true,
        ]);

        $item = AboutShowcaseProduct::create([
            'product_id'    => $product->id,
            'display_order' => 50,
            'is_active'     => true,
        ]);

        $response = $this->actingAs($admin)->delete("/admin/about-showcase/{$item->id}");
        $response->assertRedirect('/admin/about-showcase');

        // Assert showcase item is deleted from showcase table
        $this->assertDatabaseMissing('about_showcase_products', ['id' => $item->id]);

        // Assert actual product STILL EXISTS in products table!
        $this->assertDatabaseHas('products', ['id' => $product->id]);

        // Cleanup
        $product->delete();
    }
}

