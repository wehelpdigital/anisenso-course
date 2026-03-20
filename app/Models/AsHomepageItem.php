<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsHomepageItem extends Model
{
    protected $table = 'as_homepage_items';

    protected $fillable = [
        'sectionId',
        'itemType',
        'title',
        'subtitle',
        'description',
        'image',
        'image2',
        'icon',
        'linkUrl',
        'linkText',
        'extraData',
        'itemOrder',
        'isActive',
        'deleteStatus'
    ];

    protected $casts = [
        'extraData' => 'array',
        'itemOrder' => 'integer',
        'isActive' => 'boolean'
    ];

    /**
     * Get the section this item belongs to
     */
    public function section()
    {
        return $this->belongsTo(AsHomepageSection::class, 'sectionId');
    }

    /**
     * Scope for active items
     */
    public function scopeActive($query)
    {
        return $query->where('deleteStatus', 'active');
    }

    /**
     * Scope for enabled items
     */
    public function scopeEnabled($query)
    {
        return $query->where('isActive', true);
    }

    /**
     * Get items by type
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('itemType', $type);
    }

    /**
     * Get extra data value
     */
    public function getExtra(string $key, $default = null)
    {
        $data = $this->extraData ?? [];
        return $data[$key] ?? $default;
    }

    /**
     * Set extra data value
     */
    public function setExtra(string $key, $value)
    {
        $data = $this->extraData ?? [];
        $data[$key] = $value;
        $this->extraData = $data;
        return $this;
    }

    /**
     * Get the image URL attribute
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        $btcUrl = rtrim(config('app.btc_check_url'), '/');

        // Handle URLs stored with test domains - replace with current btc_check_url
        if (str_starts_with($this->image, 'http://anisenso.test') ||
            str_starts_with($this->image, 'http://btc-check.test') ||
            str_starts_with($this->image, 'https://anisenso.test') ||
            str_starts_with($this->image, 'https://btc-check.test')) {
            // Extract path after domain and append to btc_check_url
            $path = preg_replace('#^https?://[^/]+#', '', $this->image);
            return $btcUrl . $path;
        }

        // If it's already a full URL with a different domain, return it
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        // For local images from the admin system, use config
        return $btcUrl . $this->image;
    }

    /**
     * Get the image2 URL attribute (for before/after comparisons)
     */
    public function getImage2UrlAttribute()
    {
        if (!$this->image2) {
            return null;
        }

        $btcUrl = rtrim(config('app.btc_check_url'), '/');

        // Handle URLs stored with test domains - replace with current btc_check_url
        if (str_starts_with($this->image2, 'http://anisenso.test') ||
            str_starts_with($this->image2, 'http://btc-check.test') ||
            str_starts_with($this->image2, 'https://anisenso.test') ||
            str_starts_with($this->image2, 'https://btc-check.test')) {
            // Extract path after domain and append to btc_check_url
            $path = preg_replace('#^https?://[^/]+#', '', $this->image2);
            return $btcUrl . $path;
        }

        // If it's already a full URL with a different domain, return it
        if (str_starts_with($this->image2, 'http')) {
            return $this->image2;
        }

        // For local images from the admin system, use config
        return $btcUrl . $this->image2;
    }
}
