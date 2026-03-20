<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    /**
     * Display a listing of blog posts.
     */
    public function index(Request $request)
    {
        $query = DB::table('as_blogs')
            ->where('deleteStatus', 'active')
            ->where('blogStatus', 'published')
            ->whereNotNull('publishedAt')
            ->where('publishedAt', '<=', now());

        // Filter by category if provided
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('blogCategory', $request->category);
        }

        // Get featured posts for hero section
        $featuredPosts = DB::table('as_blogs')
            ->where('deleteStatus', 'active')
            ->where('blogStatus', 'published')
            ->where('isFeatured', true)
            ->whereNotNull('publishedAt')
            ->where('publishedAt', '<=', now())
            ->orderBy('publishedAt', 'desc')
            ->limit(3)
            ->get();

        // Get all posts with pagination
        $posts = $query->orderBy('publishedAt', 'desc')
            ->paginate(9);

        // Get categories for filter
        $categories = $this->getCategories();

        return view('blog.index', compact('posts', 'featuredPosts', 'categories'));
    }

    /**
     * Display a single blog post.
     */
    public function show($slug)
    {
        $post = DB::table('as_blogs')
            ->where('blogSlug', $slug)
            ->where('deleteStatus', 'active')
            ->where('blogStatus', 'published')
            ->first();

        if (!$post) {
            abort(404);
        }

        // Increment view count
        DB::table('as_blogs')
            ->where('id', $post->id)
            ->increment('viewCount');

        // Get related posts (same category, excluding current)
        $relatedPosts = DB::table('as_blogs')
            ->where('deleteStatus', 'active')
            ->where('blogStatus', 'published')
            ->where('blogCategory', $post->blogCategory)
            ->where('id', '!=', $post->id)
            ->whereNotNull('publishedAt')
            ->where('publishedAt', '<=', now())
            ->orderBy('publishedAt', 'desc')
            ->limit(3)
            ->get();

        // If not enough related posts in same category, get from other categories
        if ($relatedPosts->count() < 3) {
            $additionalPosts = DB::table('as_blogs')
                ->where('deleteStatus', 'active')
                ->where('blogStatus', 'published')
                ->where('id', '!=', $post->id)
                ->whereNotIn('id', $relatedPosts->pluck('id')->toArray())
                ->whereNotNull('publishedAt')
                ->where('publishedAt', '<=', now())
                ->orderBy('publishedAt', 'desc')
                ->limit(3 - $relatedPosts->count())
                ->get();

            $relatedPosts = $relatedPosts->concat($additionalPosts);
        }

        return view('blog.show', compact('post', 'relatedPosts'));
    }

    /**
     * Get available categories with their colors.
     */
    protected function getCategories()
    {
        return [
            'News' => 'blue',
            'Farming Tips' => 'brand-green',
            'Success Stories' => 'brand-yellow',
            'Product Updates' => 'purple',
            'Events' => 'orange',
            'Guides' => 'teal',
            'Announcements' => 'red',
        ];
    }

    /**
     * Get Tailwind color class for a category.
     */
    public static function getCategoryColorClass($color)
    {
        $colorMap = [
            'blue' => 'bg-blue-500',
            'brand-green' => 'bg-brand-green',
            'brand-yellow' => 'bg-brand-yellow text-brand-dark',
            'purple' => 'bg-purple-500',
            'orange' => 'bg-orange-500',
            'teal' => 'bg-teal-500',
            'red' => 'bg-red-500',
        ];

        return $colorMap[$color] ?? 'bg-gray-500';
    }

    /**
     * API endpoint for fetching posts (AJAX).
     */
    public function apiIndex(Request $request)
    {
        $query = DB::table('as_blogs')
            ->where('deleteStatus', 'active')
            ->where('blogStatus', 'published')
            ->whereNotNull('publishedAt')
            ->where('publishedAt', '<=', now());

        // Filter by category if provided
        if ($request->has('category') && $request->category !== 'all' && $request->category !== '') {
            $query->where('blogCategory', $request->category);
        }

        // Get paginated posts
        $posts = $query->orderBy('publishedAt', 'desc')
            ->paginate($request->get('per_page', 9));

        // Add full image URL to each post
        $btcCheckUrl = rtrim(config('app.btc_check_url'), '/');
        $placeholders = [
            'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=600&h=400&fit=crop',
            'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=600&h=400&fit=crop',
            'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=600&h=400&fit=crop',
            'https://images.unsplash.com/photo-1592982537447-6e2bd1b5d0f2?w=600&h=400&fit=crop',
            'https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=600&h=400&fit=crop',
            'https://images.unsplash.com/photo-1523348837708-15d4a09cfac2?w=600&h=400&fit=crop',
        ];

        $posts->getCollection()->transform(function ($post, $index) use ($btcCheckUrl, $placeholders) {
            $post->imageUrl = $post->blogFeaturedImage
                ? $btcCheckUrl . '/' . ltrim($post->blogFeaturedImage, '/')
                : $placeholders[$index % count($placeholders)];
            $post->url = route('blog.show', $post->blogSlug);
            $post->formattedDate = $post->publishedAt
                ? \Carbon\Carbon::parse($post->publishedAt)->format('M j, Y')
                : null;
            return $post;
        });

        return response()->json([
            'posts' => $posts->items(),
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem(),
            ]
        ]);
    }
}
