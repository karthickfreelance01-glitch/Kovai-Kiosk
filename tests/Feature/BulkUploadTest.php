<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BulkUploadTest extends TestCase
{
    use DatabaseTransactions;

    protected function getAdminUser()
    {
        return User::where('is_admin', true)->first() ?? User::factory()->create(['is_admin' => true]);
    }

    public function test_admin_can_view_bulk_upload_page()
    {
        $admin = $this->getAdminUser();

        $response = $this->actingAs($admin)->get(route('admin.products.bulk-create'));
        $response->assertStatus(200);
        $response->assertSee('Bulk Product');
    }

    public function test_admin_can_bulk_upload_item_as_individual_product()
    {
        Storage::fake('public');
        $admin = $this->getAdminUser();
        $category = Category::first() ?? Category::create(['name' => 'Smart Kiosk']);

        $file1 = UploadedFile::fake()->image('kiosk1.jpg');
        $response1 = $this->actingAs($admin)->postJson(route('admin.products.bulk-upload-item'), [
            'image' => $file1,
            'category_id' => $category->id,
            'mode' => 'individual_products',
            'base_name' => 'Smart Kiosk',
            'naming_mode' => 'base_name',
        ]);
        $response1->assertStatus(200);
        $response1->assertJson(['success' => true]);

        $file2 = UploadedFile::fake()->image('kiosk2.jpg');
        $response2 = $this->actingAs($admin)->postJson(route('admin.products.bulk-upload-item'), [
            'image' => $file2,
            'category_id' => $category->id,
            'mode' => 'individual_products',
            'base_name' => 'Smart Kiosk',
            'naming_mode' => 'base_name',
        ]);
        $response2->assertStatus(200);
        $response2->assertJson(['success' => true]);

        $this->assertDatabaseHas('products', [
            'category_id' => $category->id,
            'name' => 'Smart Kiosk',
            'slug' => 'smart-kiosk',
        ]);

        $this->assertDatabaseHas('products', [
            'category_id' => $category->id,
            'name' => 'Smart Kiosk',
            'slug' => 'smart-kiosk-1',
        ]);
    }

    public function test_bulk_import_artisan_command()
    {
        Storage::fake('public');
        $category = Category::where('name', 'Smart Kiosk')->first() ?? Category::create(['name' => 'Smart Kiosk']);

        // Create temporary folder with 3 test images
        $tempDir = storage_path('framework/testing/test_import_images_' . uniqid());
        File::makeDirectory($tempDir, 0755, true);

        file_put_contents($tempDir . '/img1.jpg', 'dummy image content');
        file_put_contents($tempDir . '/img2.png', 'dummy image content');
        file_put_contents($tempDir . '/img3.webp', 'dummy image content');

        $this->artisan('products:bulk-import', [
            'category' => $category->id,
            'folder' => $tempDir,
        ])->assertExitCode(0);

        File::deleteDirectory($tempDir);
    }
}
