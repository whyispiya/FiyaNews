<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Like; // ⚙️ Ditambahkan agar fungsi like bisa mengenali model Like
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the articles (Dashboard / Index + Global Search)
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // search nya jg nyari di source
        $articles = Article::latest()
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%")
                      ->orWhere('source', 'like', "%{$search}%");
                });
            })
            ->get();

        return view('articles.index', compact('articles'));
    }

    /**
     * Filter articles based on Category + Fitur Search di dalam Kategori tersebut
     */
    public function category(Request $request, $category)
    {
        $search = $request->input('search');

        // 💡 Sekarang kalau kamu cari sesuatu pas lagi buka kategori tertentu,
        // hasilnya ga bakal nyasar ke kategori lain!
        $articles = Article::where('category', $category)
            ->latest()
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%")
                      ->orWhere('source', 'like', "%{$search}%");
                });
            })
            ->get();

        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new article
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created article in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string', 
            'source' => 'nullable|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
            'created_at' => 'nullable|date', 
        ]);

        $data = $request->only(['title', 'author', 'category', 'source', 'content']);

        // Otomatis buat excerpt dari content (ambil 150 karakter pertama)
        $data['excerpt'] = \Str::limit(strip_tags($request->content), 150);

        if ($request->filled('created_at')) {
            $data['created_at'] = $request->created_at;
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
            $data['image'] = $imagePath;
        }

        Article::create($data);

        return redirect()->route('articles.index')->with('success', 'New article published successfully!');
    }

    /**
     * Display the specified article (Show Page)
     */
    public function show($id)
    {
        $article = Article::with(['comments.user', 'likes'])->findOrFail($id);
        
        // Ambil data artikel lain untuk mengisi barisan sidebar kanan
        $articles = Article::latest()->get(); 

        // Kirim kedua variabel ini ke dalam view show
        return view('articles.show', compact('article', 'articles'));
    }

    /**
     * Show the form for editing the specified article
     */
    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified article in storage
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string',
            'source' => 'nullable|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'created_at' => 'required|date',
        ]);

        $data = $request->only(['title', 'author', 'category', 'source', 'content', 'created_at']);

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($data);

        return redirect()->route('articles.show', $article->id)
                         ->with('success', 'Article updated successfully!');
    }

    /**
     * Remove the specified article from storage
     */
    public function destroy(Article $article)
    {
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()->route('articles.index')
                         ->with('success', 'Article deleted successfully!');
    }

    /**
     * ❤️ Fungsi Baru: Mengolah klik Like / Berbatal Like pada Artikel
     */
    public function like($id)
    {
        // 1. Pastikan user sudah login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Kamu harus login terlebih dahulu!');
        }

        $userId = auth()->id();

        // 2. Cek apakah user ini sudah pernah like artikel ini
        $existingLike = Like::where('article_id', $id)
                            ->where('user_id', $userId)
                            ->first();

        if ($existingLike) {
            // Kalau sudah ada, pas diklik lagi maka statusnya jadi Unlike (hapus data)
            $existingLike->delete();
        } else {
            // Kalau belum ada, buat baris data baru di tabel likes
            Like::create([
                'article_id' => $id,
                'user_id' => $userId
            ]);
        }

        // 3. Balikin ke halaman tempat dia klik tadi
        return redirect()->back();
    }
}