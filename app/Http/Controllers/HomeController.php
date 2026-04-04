<?php

namespace App\Http\Controllers;

use App\Models\AsHomepageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        $btcCheckUrl = rtrim(config('app.btc_check_url'), '/');
        $placeholders = [
            'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=800&h=500&fit=crop',
            'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=800&h=500&fit=crop',
            'https://images.unsplash.com/photo-1592982537447-7440770cbfc9?w=800&h=500&fit=crop',
        ];

        $posts = DB::table('as_blogs')
            ->where('deleteStatus', 'active')
            ->where('blogStatus', 'published')
            ->whereNotNull('publishedAt')
            ->orderByDesc('isFeatured')
            ->orderByDesc('viewCount')
            ->limit($limit)
            ->get();

        return $posts->map(function ($post, $index) use ($btcCheckUrl, $placeholders) {
            return [
                'slug' => $post->blogSlug,
                'title' => $post->blogTitle,
                'category' => $post->blogCategory,
                'category_color' => $post->blogCategoryColor ?? 'brand-green',
                'image' => $post->blogFeaturedImage
                    ? $btcCheckUrl . '/' . ltrim($post->blogFeaturedImage, '/')
                    : $placeholders[$index % count($placeholders)],
                'excerpt' => $post->blogExcerpt,
                'read_time' => ($post->readingTime ?: 1) . ' min read',
                'date' => Carbon::parse($post->publishedAt)->format('M j, Y'),
            ];
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
