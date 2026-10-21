<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuthorController extends Controller
{
    public function index()
    {
        return response()->json(Author::withCount('books')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:authors,email',
            'bio' => 'nullable|string',
        ]);

        return response()->json(Author::create($validated), 201);
    }

    public function show(Author $author)
    {
        return response()->json($author->load('books'));
    }

    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes', 'email', Rule::unique('authors')->ignore($author->id)],
            'bio' => 'nullable|string',
        ]);

        $author->update($validated);

        return response()->json($author);
    }

    public function destroy(Request $request, Author $author)
    {
        $jumlahBuku = $author->books()->count();

        // Konfirmasi: jika punya buku, wajib kirim confirm=true
        if ($jumlahBuku > 0 && ! $request->boolean('confirm')) {
            return response()->json([
                'message' => "Penulis memiliki {$jumlahBuku} buku yang akan ikut terhapus. Kirim confirm=true untuk melanjutkan.",
            ], 409);
        }

        $author->delete();

        return response()->json([
            'message' => "Penulis dan {$jumlahBuku} buku terkait berhasil dihapus",
        ]);
    }
}