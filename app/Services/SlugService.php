<?php

namespace App\Services;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

class SlugService
{
    public static function createSlug(string $model, ?string $name, ?int $ignoreId = null, bool $withTrashed = true): ?string 
    {
        try {
            if (blank($name)) {
                throw new Exception('Name is required to generate slug.');
            }

            $slug = Str::slug($name);

            if (blank($slug)) {
                $slug = 'item';
            }

            $originalSlug = $slug;
            $counter = 1;

            while (self::checkSlugExists($model, $slug, $ignoreId, $withTrashed)) {
                $slug = $originalSlug . '-' . $counter++;
            }

            return $slug;
        } catch (Exception $e) {
            Log::error('SlugService Error: ' . $e->getMessage());

            return null;
        }
    }

    private static function checkSlugExists(string $model, string $slug, ?int $ignoreId, bool $withTrashed): bool 
    {
        $instance = new $model();

        $query = $instance->newQuery();

        if ($withTrashed && in_array(SoftDeletes::class, class_uses_recursive($instance))) {
            $query->withTrashed();
        }

        return $query->where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))
            ->exists();
    }
}