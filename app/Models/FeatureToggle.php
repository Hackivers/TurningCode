<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class FeatureToggle extends Model
{
    protected $primaryKey = 'feature_name';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['feature_name', 'is_enabled'];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    /**
     * Check if a feature is enabled. Uses cache to prevent frequent DB hits.
     */
    public static function isActive(string $featureName): bool
    {
        return Cache::rememberForever("feature_toggle_{$featureName}", function () use ($featureName) {
            $feature = self::find($featureName);
            // Default to true if not found in database yet
            return $feature ? $feature->is_enabled : true;
        });
    }

    /**
     * Clear cache when a feature toggle is updated or deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            Cache::forget("feature_toggle_{$model->feature_name}");
        });

        static::deleted(function ($model) {
            Cache::forget("feature_toggle_{$model->feature_name}");
        });
    }
}
