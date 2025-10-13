<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * List the user’s favorites with live product details from the 3rd-party API.
     */
    public function index(\App\Services\ExternalProductsService $extSvc)
    {
        $extIds = Favorite::where('user_id', Auth::id())
            ->orderByDesc('id')
            ->pluck('external_id')
            ->map(fn($v) => (int)$v)
            ->all();

        // Ask your service to hydrate details from the API
        $products = !empty($extIds) ? $extSvc->fetchByIds($extIds) : [];

        return view('favorites.index', [
            'products' => $products,     // array keyed by id or a list
            'extIds'   => $extIds,       // for quick checks
        ]);
    }

    /**
     * Toggle favorite status (AJAX-friendly).
     * Request: POST /favorites/toggle { external_id, title?, sku?, image_url? }
     */
    public function toggle(Request $r)
    {
        $data = $r->validate([
            'external_id' => 'required|string|max:64',
            'title'       => 'nullable|string|max:255',
            'sku'         => 'nullable|string|max:255',
            'slug'         => 'nullable|string|max:255',
            'prefix'         => 'nullable|string|max:255',
            'image_url'   => 'nullable|string|max:2048',
        ]);

        $fav = Favorite::where('user_id', Auth::id())
            ->where('external_id', $data['external_id'])
            ->first();
        $userId = Auth::id();

        if ($fav) {
            $fav->delete();
            $count = Favorite::where('user_id', $userId)->count();
            return response()->json([
                    'status' => 'removed',
                    'count'  => $count
                ]);
        }

        $fav = Favorite::create([
            'user_id'    => Auth::id(),
            'slug' => $data['slug'],
            'prefix' => $data['prefix'],
            'external_id' => $data['external_id'],
            'title'      => $data['title']     ?? null,
            'sku'        => $data['sku']       ?? null,
            'image_url'  => $data['image_url'] ?? null,
        ]);
        $count = Favorite::where('user_id', $userId)->count();
        return response()->json(['status' => 'added', 'id' => $fav->id,'count' => $count]);
    }

    /**
     * Explicit unfavorite.
     */
    public function destroy(string $externalId)
    {
        Favorite::where('user_id', Auth::id())
            ->where('external_id', $externalId)
            ->delete();

        return back()->with('success', 'Removed from favorites.');
    }



    public function unfav($id)
    {
        Favorite::where('user_id', Auth::id())
        ->where('id', $id)
        ->delete();

        return response()->json(['success' => true]);
    }
}
