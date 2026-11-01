<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UniqueSlugTest extends TestCase
{
    use DatabaseTransactions;

    protected function getAdminUser()
    {
        return User::where('is_admin', true)->first() ?? User::factory()->create(['is_admin' => true]);
    }

    public function test_product_generates_unique_slug_with_numeric_suffixes()
    {
        $category = Category::first() ?? Category::create(['name' => 'General Kiosks']);

        $product1 = Product::create([
            'category_id' => $category->id,
            'name' => 'Smart Kiosk Test Slug',
        ]);
        $this->assertEquals('smart-kiosk-test-slug', $product1->slug);

        $product2 = Product::create([
            'category_id' => $category->id,
            'name' => 'Smart Kiosk Test Slug',
        ]);
        $this->assertEquals('smart-kiosk-test-slug-1', $product2->slug);

        $product3 = Product::create([
            'category_id' => $category->id,
            'name' => 'Smart Kiosk Test Slug',
        ]);
        $this->assertEquals('smart-kiosk-test-slug-2', $product3->slug);

        // Generate up to 10
        for ($i = 3; $i <= 10; $i++) {
            $prod = Product::create([
                'category_id' => $category->id,
                'name' => 'Smart Kiosk Test Slug',
            ]);
            $this->assertEquals("smart-kiosk-test-slug-{$i}", $prod->slug);
        }
    }

    public function test_admin_can_store_multiple_products_with_the_same_name()
    {
        $admin = $this->getAdminUser();
        $category = Category::first() ?? Category::create(['name' => 'General Kiosks']);

        $response1 = $this->actingAs($admin)->post(route('admin.products.store'), [
            'name' => 'Duplicate Test Kiosk',
            'category_id' => $category->id,
            'short_description' => 'Test 1',
        ]);
        $response1->assertRedirect(route('admin.products.index'));

        $response2 = $this->actingAs($admin)->post(route('admin.products.store'), [
            'name' => 'Duplicate Test Kiosk',
            'category_id' => $category->id,
            'short_description' => 'Test 2',
        ]);
        $response2->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'Duplicate Test Kiosk',
            'slug' => 'duplicate-test-kiosk',
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Duplicate Test Kiosk',
            'slug' => 'duplicate-test-kiosk-1',
        ]);
    }

    public function test_updating_product_preserves_its_slug()
    {
        $category = Category::first() ?? Category::create(['name' => 'General Kiosks']);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Unique Update Product',
        ]);
        $initialSlug = $product->slug;

        $product->update([
            'short_description' => 'Updated short description',
        ]);

        $this->assertEquals($initialSlug, $product->fresh()->slug);
    }

    public function test_project_generates_unique_slug()
    {
        $project1 = Project::create([
            'title' => 'Sample Project Unique',
        ]);
        $this->assertEquals('sample-project-unique', $project1->slug);

        $project2 = Project::create([
            'title' => 'Sample Project Unique',
        ]);
        $this->assertEquals('sample-project-unique-1', $project2->slug);
    }
}

