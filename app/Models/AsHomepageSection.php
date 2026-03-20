<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsHomepageSection extends Model
{
    protected $table = 'as_homepage_sections';

    protected $fillable = [
        'sectionKey',
        'sectionName',
        'sectionIcon',
        'isEnabled',
        'sectionOrder',
        'settings'
    ];

    protected $casts = [
        'isEnabled' => 'boolean',
        'sectionOrder' => 'integer',
        'settings' => 'array'
    ];

    /**
     * Get items for this section
     */
    public function items()
    {
        return $this->hasMany(AsHomepageItem::class, 'sectionId')
            ->where('deleteStatus', 'active')
            ->orderBy('itemOrder');
    }

    /**
     * Get active items
     */
    public function activeItems()
    {
        return $this->hasMany(AsHomepageItem::class, 'sectionId')
            ->where('deleteStatus', 'active')
            ->where('isActive', true)
            ->orderBy('itemOrder');
    }

    /**
     * Scope for enabled sections
     */
    public function scopeEnabled($query)
    {
        return $query->where('isEnabled', true);
    }

    /**
     * Get section by key
     */
    public static function getByKey(string $key)
    {
        return static::where('sectionKey', $key)->first();
    }

    /**
     * Get setting value
     */
    public function getSetting(string $key, $default = null)
    {
        $settings = $this->settings ?? [];
        return $settings[$key] ?? $default;
    }

    /**
     * Get image setting value with proper URL transformation
     */
    public function getImageSetting(string $key, $default = null)
    {
        $value = $this->getSetting($key, $default);

        if (!$value) {
            return $default;
        }

        $btcUrl = rtrim(config('app.btc_check_url'), '/');

        // Handle URLs stored with test domains - replace with current btc_check_url
        if (str_starts_with($value, 'http://anisenso.test') ||
            str_starts_with($value, 'http://btc-check.test') ||
            str_starts_with($value, 'https://anisenso.test') ||
            str_starts_with($value, 'https://btc-check.test')) {
            // Extract path after domain and append to btc_check_url
            $path = preg_replace('#^https?://[^/]+#', '', $value);
            return $btcUrl . $path;
        }

        // If it's already a full URL with a different domain, return it
        if (str_starts_with($value, 'http')) {
            return $value;
        }

        // For local paths, prepend btc_check_url
        return $btcUrl . $value;
    }

    /**
     * Set setting value
     */
    public function setSetting(string $key, $value)
    {
        $settings = $this->settings ?? [];
        $settings[$key] = $value;
        $this->settings = $settings;
        return $this;
    }
}
