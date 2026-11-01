<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('category')->orderBy('sort_order')->paginate(20);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.projects.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'category_id'    => 'nullable|exists:categories,id',
            'description'    => 'nullable|string',
            'client_name'    => 'nullable|string|max:255',
            'location'       => 'nullable|string|max:255',
            'completed_date' => 'nullable|date',
            'images.*'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        DB::transaction(function () use ($request) {
            $data = $request->except(['images', '_token']);
            $data['slug'] = Str::slug($request->title);
            $project = Project::create($data);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('projects', 'public');
                    ProjectImage::create([
                        'project_id' => $project->id,
                        'image_path' => $path,
                        'sort_order' => $index,
                    ]);
                    if ($index === 0) {
                        $project->update(['primary_image' => $path]);
                    }
                }
            }
        });

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully!');
    }

    public function edit(Project $project)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $project->load('images');
        return view('admin.projects.edit', compact('project', 'categories'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'category_id'    => 'nullable|exists:categories,id',
            'description'    => 'nullable|string',
            'client_name'    => 'nullable|string|max:255',
            'location'       => 'nullable|string|max:255',
            'completed_date' => 'nullable|date',
            'images.*'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        DB::transaction(function () use ($request, $project) {
            $project->update($request->except(['images', '_token', '_method']));

            if ($request->hasFile('images')) {
                $maxOrder = $project->images()->max('sort_order') ?? -1;
                $hasPrimary = !empty($project->primary_image);
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('projects', 'public');
                    ProjectImage::create([
                        'project_id' => $project->id,
                        'image_path' => $path,
                        'sort_order' => $maxOrder + $index + 1,
                    ]);
                    if (!$hasPrimary && $index === 0) {
                        $project->update(['primary_image' => $path]);
                        $hasPrimary = true;
                    }
                }
            }
        });

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully!');
    }

    public function deleteImage(ProjectImage $image)
    {
        $project = $image->project;
        $wasPrimary = ($project->primary_image === $image->image_path);

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        if ($wasPrimary) {
            $next = $project->images()->first();
            $project->update(['primary_image' => $next ? $next->image_path : null]);
        }

        return back()->with('success', 'Photo deleted successfully.');
    }

    public function setPrimaryImage(ProjectImage $image)
    {
        $project = $image->project;
        $project->update(['primary_image' => $image->image_path]);

        return back()->with('success', 'Primary photo updated.');
    }

    public function destroy(Project $project)
    {
        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        if ($project->primary_image) {
            Storage::disk('public')->delete($project->primary_image);
        }
        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted.');
    }
}
