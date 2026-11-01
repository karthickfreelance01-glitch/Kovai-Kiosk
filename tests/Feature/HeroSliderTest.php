<?php

namespace Tests\Feature;

use App\Models\HeroSlider;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HeroSliderTest extends TestCase
{
    protected function getAdminUser()
    {
        return User::where('is_admin', true)->first() ?? User::factory()->create([
            'is_admin' => true,
            'email'    => 'admin@kovaikiosk.com',
        ]);
    }

    public function test_homepage_renders_hero_slider_with_active_slides()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('hero-slider-viewport');
        $response->assertSee('hero-slider-prev-btn');
        $response->assertSee('hero-slider-next-btn');
    }

    public function test_guests_cannot_access_hero_slider_admin()
    {
        $response = $this->get('/admin/hero-sliders');
        $response->assertRedirect('/admin/login');
    }

    public function test_admin_can_view_hero_sliders_index()
    {
        $admin = $this->getAdminUser();

        $response = $this->actingAs($admin)->get('/admin/hero-sliders');

        $response->assertStatus(200);
        $response->assertSee('Homepage Hero Sliders');
        $response->assertSee('Add New Slide');
    }

    public function test_admin_can_view_create_page()
    {
        $admin = $this->getAdminUser();

        $response = $this->actingAs($admin)->get('/admin/hero-sliders/create');

        $response->assertStatus(200);
        $response->assertSee('Add New Hero Slide');
        $response->assertSee('Smart Kiosk');
        $response->assertSee('Push Cart');
        $response->assertSee('EV Vehicles');
    }

    public function test_admin_can_create_hero_slide_with_image()
    {
        Storage::fake('public');
        $admin = $this->getAdminUser();

        $uniqueTitle = 'Automated Test Slide ' . uniqid();
        $image = UploadedFile::fake()->image('test-kiosk.jpg', 800, 600);

        $response = $this->actingAs($admin)->post('/admin/hero-sliders', [
            'title'         => $uniqueTitle,
            'subtitle'      => 'Testing Subtitle',
            'description'   => 'A full description of the test kiosk',
            'category'      => 'Smart Kiosk',
            'button_text'   => 'Learn More',
            'button_url'    => '/products/smart-kiosk',
            'display_order' => 5,
            'is_active'     => '1',
            'image'         => $image,
        ]);

        $response->assertRedirect('/admin/hero-sliders');
        $response->assertSessionHas('success');

        $slide = HeroSlider::where('title', $uniqueTitle)->first();
        $this->assertNotNull($slide);
        $this->assertEquals('Smart Kiosk', $slide->category);
        $this->assertEquals(5, $slide->display_order);
        $this->assertTrue($slide->is_active);

        Storage::disk('public')->assertExists($slide->image);

        // Clean up
        $slide->delete();
    }

    public function test_admin_can_toggle_hero_slide_status()
    {
        $admin = $this->getAdminUser();
        $slide = HeroSlider::first();
        $initialStatus = $slide->is_active;

        $response = $this->actingAs($admin)->post("/admin/hero-sliders/{$slide->id}/toggle-status");

        $response->assertRedirect();
        $slide->refresh();
        $this->assertEquals(!$initialStatus, $slide->is_active);

        // Toggle back
        $this->actingAs($admin)->post("/admin/hero-sliders/{$slide->id}/toggle-status");
        $slide->refresh();
        $this->assertEquals($initialStatus, $slide->is_active);
    }

    public function test_admin_can_update_slide_and_replace_image()
    {
        Storage::fake('public');
        $admin = $this->getAdminUser();

        // Create a temporary slide
        $oldImage = UploadedFile::fake()->image('initial.jpg')->store('hero-sliders', 'public');
        $slide = HeroSlider::create([
            'title'         => 'Old Title',
            'subtitle'      => 'Old Subtitle',
            'image'         => $oldImage,
            'category'      => 'Push Cart',
            'display_order' => 1,
            'is_active'     => true,
        ]);

        Storage::disk('public')->assertExists($oldImage);

        // Replace with new image
        $newImage = UploadedFile::fake()->image('updated.png');

        $response = $this->actingAs($admin)->put("/admin/hero-sliders/{$slide->id}", [
            'title'         => 'Updated Title',
            'subtitle'      => 'Updated Subtitle',
            'category'      => 'EV Vehicles',
            'display_order' => 2,
            'is_active'     => '1',
            'image'         => $newImage,
        ]);

        $response->assertRedirect('/admin/hero-sliders');
        $slide->refresh();

        $this->assertEquals('Updated Title', $slide->title);
        $this->assertEquals('EV Vehicles', $slide->category);
        $this->assertEquals(2, $slide->display_order);

        // Assert new image exists and old image was deleted
        Storage::disk('public')->assertExists($slide->image);
        Storage::disk('public')->assertMissing($oldImage);

        // Delete test slide
        $imageToDelete = $slide->image;
        $this->actingAs($admin)->delete("/admin/hero-sliders/{$slide->id}");
        Storage::disk('public')->assertMissing($imageToDelete);
    }

    public function test_inactive_slide_is_not_displayed_on_homepage()
    {
        $slide = HeroSlider::create([
            'title'         => 'Secret Inactive Prototype Kiosk',
            'image'         => 'hero-sliders/placeholder.jpg',
            'category'      => 'Smart Kiosk',
            'display_order' => 99,
            'is_active'     => false,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertDontSee('Secret Inactive Prototype Kiosk');

        $slide->delete();
    }

    public function test_image_validation_rejects_oversized_file_and_invalid_mimes()
    {
        $admin = $this->getAdminUser();

        // 1. Oversized file (> 5MB)
        $largeImage = UploadedFile::fake()->create('huge.jpg', 6000); // 6MB

        $response = $this->actingAs($admin)->post('/admin/hero-sliders', [
            'title' => 'Oversized Slide',
            'image' => $largeImage,
        ]);
        $response->assertSessionHasErrors(['image']);

        // 2. Invalid mime type (e.g. PDF/text)
        $invalidFile = UploadedFile::fake()->create('document.pdf', 500, 'application/pdf');

        $response = $this->actingAs($admin)->post('/admin/hero-sliders', [
            'title' => 'Invalid Mime Slide',
            'image' => $invalidFile,
        ]);
        $response->assertSessionHasErrors(['image']);
    }
}
