<?php

namespace App\Models\Traits;

use Illuminate\Validation\ValidationException;
use App\Services\SlugService;

trait HasSlug
{
    public static function bootHasSlug(): void
    {
        static::creating(function ($model) {
            if (blank($model->slug)) {
                $model->slug = $model->generateSlug($model->name);
            }
        });

        static::updating(function ($model) {
            if (! $model->isDirty('slug')) {
                if ($model->isDirty('name')) {
                    $model->slug = $model->generateSlug($model->name, $model->getKey());
                }

                return;
            }

            if (blank($model->slug)) {
                $model->slug = $model->isDirty('name')
                    ? $model->generateSlug($model->name, $model->getKey())
                    : $model->getOriginal('slug');
            }
        });
    }

    protected function generateSlug(?string $name, ?int $ignoreId = null): string
    {
        $slug = SlugService::createSlug(static::class, $name, $ignoreId);

        if (blank($slug)) {
            throw ValidationException::withMessages([
                'slug' => 'Unable to generate a valid slug. Please provide a valid name.',
            ]);
        }

        return $slug;
    }
}