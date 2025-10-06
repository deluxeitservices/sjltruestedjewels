<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class BlogController extends Controller
{

    /**
     * Display the Blog index.
     */
    public function index(Request $request): View
    {
        $perPage = (int) $request->integer('per_page', 10);
        $perPage = max(10, min(24, $perPage));
        $blog_data = DB::table('blog_posts')
            ->paginate($perPage)
            ->appends($request->query());
        return view('blog.index', [
            'user' => $request->user(),
            'blog_data' => $blog_data
        ]);
    }

    /**
     * Display the Blog detail
     */
    // app/Http/Controllers/BlogController.php

    public function detail(Request $request, string $slug)
    {
        $post = DB::table('blog_posts')
            ->where('slug', $slug)
            ->first();

        abort_if(!$post, 404);

        // Build a small excerpt if you want it in the view/meta
        $text = $post->content ?? $post->content ?? $post->body ?? '';
        $excerpt = Str::limit(strip_tags($text), 160);

        // Recent posts (exclude current)
        $recent = DB::table('blog_posts')
            ->select('id', 'title', 'slug','content', 'added_date','cover_image')
            ->where('slug', '!=', $slug)
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        return view('blog.blog_detail', [
            'user'    => $request->user(),
            'post'    => $post,
            'excerpt' => $excerpt,
            'recent'  => $recent,
        ]);
    }
}
