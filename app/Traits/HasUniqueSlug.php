<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUniqueSlug
{
    /**
     * Boot the trait to automatically generate unique slugs.
     */
    public static function bootHasUniqueSlug(): void
    {
        static::creating(function ($model) {
            $source = !empty($model->slug) ? $model->slug : $model->slugSourceValue();
            $model->slug = static::generateUniqueSlug($source, $model->id);
        });

        static::updating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = static::generateUniqueSlug($model->slugSourceValue(), $model->id);
            } elseif ($model->isDirty('slug')) {
                $model->slug = static::generateUniqueSlug($model->slug, $model->id);
            }
        });
    }

    /**
     * Determine the source attribute used to generate the slug.
     */
    public function slugSourceValue(): string
    {
        return (string) ($this->name ?? $this->title ?? 'item');
    }

    /**
     * Generate a unique slug for this model.
     * Appends -1, -2, -3... if the slug is already taken.
     */
    public static function generateUniqueSlug(string $name, int|string|null $ignoreId = null): string
    {
        $slug = Str::slug($name);
        if (empty($slug)) {
            $slug = strtolower(class_basename(static::class)) ?: 'item';
        }

        $originalSlug = $slug;
        $softDelete = in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive(static::class));

        // 1. Check if the base slug itself is available
        $query = static::where('slug', $originalSlug);
        if ($softDelete) {
            $query->withTrashed();
        }
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        if (!$query->exists()) {
            return $originalSlug;
        }

        // 2. Base slug is taken. Query existing slugs matching $originalSlug or $originalSlug-%
        $escaped = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $originalSlug);
        $existingQuery = static::where(function ($q) use ($originalSlug, $escaped) {
            $q->where('slug', $originalSlug)
              ->orWhere('slug', 'like', $escaped . '-%');
        });

        if ($softDelete) {
            $existingQuery->withTrashed();
        }
        if ($ignoreId) {
            $existingQuery->where('id', '!=', $ignoreId);
        }

        $existingSlugs = $existingQuery->pluck('slug')->flip()->toArray();

        // 3. Find the lowest unused suffix: -1, -2, -3 ...
        $count = 1;
        while (isset($existingSlugs["{$originalSlug}-{$count}"])) {
            $count++;
        }

        return "{$originalSlug}-{$count}";
    }
}

