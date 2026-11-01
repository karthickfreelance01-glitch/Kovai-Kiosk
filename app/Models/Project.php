<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'title', 'slug', 'description', 'client_name',
        'location', 'completed_date', 'primary_image', 'is_featured',
        'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'completed_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }

    public function getHasImageAttribute(): bool
    {
        return !empty($this->primary_image) || ($this->images && $this->images->isNotEmpty());
    }

    public function getPrimaryImageUrlAttribute()
    {
        if (!empty($this->primary_image)) {
            if (str_starts_with($this->primary_image, 'http://') || str_starts_with($this->primary_image, 'https://')) {
                return $this->primary_image;
            }
            return asset('storage/' . ltrim($this->primary_image, '/'));
        }

        // Fallback to first image in images relation if available
        $first = $this->images ? $this->images->first() : null;
        if ($first && !empty($first->image_path)) {
            if (str_starts_with($first->image_path, 'http://') || str_starts_with($first->image_path, 'https://')) {
                return $first->image_path;
            }
            return asset('storage/' . ltrim($first->image_path, '/'));
        }

        return asset('images/placeholder-project.jpg');
    }

    public function resolveRouteBinding($value, $field = null)
    {
        if ($field) {
            return $this->where($field, $value)->firstOrFail();
        }

        if (is_numeric($value)) {
            return $this->where('id', $value)->firstOrFail();
        }

        return $this->where('slug', $value)->firstOrFail();
    }
}
