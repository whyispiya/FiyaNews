<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * 💬 Fungsi untuk menyimpan komentar baru dari user
     */
    public function store(Request $request, $articleId)
    {
        // 1. Validasi inputan komentar (wajib diisi, minimal 2 karakter)
        $request->validate([
            'body' => 'required|string|min:2',
        ]);

        // 2. Simpan data komentar ke tabel comments di database
        Comment::create([
            'article_id' => $articleId,
            'user_id' => auth()->id(), // Mengambil ID user yang sedang login
            'body' => $request->body,
        ]);

        // 3. Kembalikan user ke halaman artikel tadi dengan pesan sukses
        return redirect()->back()->with('success', 'Komentar kamu berhasil dikirim!');
    }
}