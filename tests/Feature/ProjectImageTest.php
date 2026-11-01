<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectImageTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    private function createAdmin(): User
    {
        return User::firstOrCreate(
            ['email' => 'admin@kovaikiosk.com'],
            ['name' => 'Admin', 'password' => bcrypt('password')]
        );
    }

    public function test_homepage_renders_project_delivered_images()
    {
        $category = Category::firstOrCreate(['slug' => 'test-cat'], ['name' => 'Test Cat', 'is_active' => true]);

        $project = Project::create([
            'title' => 'Flagship Test Kiosk ' . uniqid(),
            'slug' => 'flagship-test-kiosk-' . uniqid(),
            'category_id' => $category->id,
            'primary_image' => 'projects/test-flagship.jpg',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => -999,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee($project->title);
        $response->assertSee('storage/projects/test-flagship.jpg');
    }

    public function test_admin_can_upload_images_on_update_and_sets_primary_if_null()
    {
        $admin = $this->createAdmin();

        $project = Project::create([
            'title' => 'Null Primary Kiosk ' . uniqid(),
            'slug' => 'null-primary-kiosk-' . uniqid(),
            'primary_image' => null,
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 0,
        ]);

        $file1 = UploadedFile::fake()->image('photo1.jpg', 600, 400);
        $file2 = UploadedFile::fake()->image('photo2.jpg', 600, 400);

        $response = $this->actingAs($admin)->put(route('admin.projects.update', $project), [
            'title' => 'Null Primary Kiosk Updated',
            'images' => [$file1, $file2],
            'is_active' => 1,
            'is_featured' => 1,
        ]);

        $response->assertRedirect(route('admin.projects.index'));

        $project->refresh();
        $this->assertNotNull($project->primary_image);
        $this->assertCount(2, $project->images);
        $this->assertTrue(Storage::disk('public')->exists($project->primary_image));
    }

    public function test_admin_can_set_primary_photo()
    {
        $admin = $this->createAdmin();

        $project = Project::create([
            'title' => 'Multi Photo Project ' . uniqid(),
            'slug' => 'multi-photo-project-' . uniqid(),
            'primary_image' => 'projects/old-main.jpg',
            'is_active' => true,
        ]);

        $image1 = ProjectImage::create([
            'project_id' => $project->id,
            'image_path' => 'projects/old-main.jpg',
            'sort_order' => 0,
        ]);

        $image2 = ProjectImage::create([
            'project_id' => $project->id,
            'image_path' => 'projects/new-main.jpg',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.projects.images.set-primary', $image2));
        $response->assertSessionHas('success');

        $project->refresh();
        $this->assertEquals('projects/new-main.jpg', $project->primary_image);
    }

    public function test_admin_can_delete_photo_and_primary_is_reassigned()
    {
        $admin = $this->createAdmin();

        $path1 = 'projects/delete-me.jpg';
        $path2 = 'projects/next-inline.jpg';

        Storage::disk('public')->put($path1, 'image-data-1');
        Storage::disk('public')->put($path2, 'image-data-2');

        $project = Project::create([
            'title' => 'Delete Photo Project ' . uniqid(),
            'slug' => 'delete-photo-project-' . uniqid(),
            'primary_image' => $path1,
            'is_active' => true,
        ]);

        $image1 = ProjectImage::create([
            'project_id' => $project->id,
            'image_path' => $path1,
            'sort_order' => 0,
        ]);

        $image2 = ProjectImage::create([
            'project_id' => $project->id,
            'image_path' => $path2,
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.projects.images.delete', $image1));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('project_images', ['id' => $image1->id]);
        $this->assertFalse(Storage::disk('public')->exists($path1));

        $project->refresh();
        $this->assertEquals($path2, $project->primary_image);
    }
}
