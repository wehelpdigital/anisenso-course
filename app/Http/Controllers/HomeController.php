<?php

namespace App\Http\Controllers;

use App\Models\AsHomepageSection;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage with dynamic content from settings
     */
    public function index()
    {
        // Fetch all enabled sections with their items
        $sections = AsHomepageSection::enabled()
            ->with('activeItems')
            ->orderBy('sectionOrder')
            ->get()
            ->keyBy('sectionKey');

        // Get latest blog posts for homepage
        $blogPosts = $this->getLatestBlogPosts(3);

        // Pass sections to the view
        return view('home', compact('sections', 'blogPosts'));
    }

    /**
     * Get latest blog posts for homepage display
     */
    private function getLatestBlogPosts($limit = 3)
    {
        // Temporary blog data (same as routes/web.php)
        $articles = [
            'how-to-maximize-your-rice-yield-this-planting-season' => [
                'title' => 'How to Maximize Your Rice Yield This Planting Season',
                'category' => 'Farming Tips',
                'category_color' => 'brand-green',
                'image' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=800&h=500&fit=crop',
                'excerpt' => 'Discover the proven techniques and best practices that have helped thousands of Filipino farmers achieve up to 50% increase in their rice yields.',
                'read_time' => '8 min read',
                'date' => 'Feb 28, 2026',
            ],
            'from-struggling-to-thriving-a-farmers-journey-with-rhizocote' => [
                'title' => "From Struggling to Thriving: A Farmer's Journey",
                'category' => 'Success Stories',
                'category_color' => 'brand-yellow',
                'image' => 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=800&h=500&fit=crop',
                'excerpt' => "Meet Pedro, a rice farmer from Nueva Ecija who transformed his farm's productivity using AniSenso's innovative farming techniques.",
                'read_time' => '6 min read',
                'date' => 'Feb 25, 2026',
            ],
            '5-essential-soil-preparation-techniques-for-better-harvest' => [
                'title' => '5 Essential Soil Preparation Techniques',
                'category' => 'Farming Tips',
                'category_color' => 'brand-green',
                'image' => 'https://images.unsplash.com/photo-1592982537447-7440770cbfc9?w=800&h=500&fit=crop',
                'excerpt' => 'Proper soil preparation is the foundation of a successful harvest. Learn the five techniques that every farmer should know.',
                'read_time' => '7 min read',
                'date' => 'Feb 22, 2026',
            ],
        ];

        return collect($articles)->take($limit)->map(function ($article, $slug) {
            $article['slug'] = $slug;
            return $article;
        });
    }

    /**
     * Helper method to get a section by key
     */
    private function getSection($sections, $key)
    {
        return $sections->get($key);
    }
}
