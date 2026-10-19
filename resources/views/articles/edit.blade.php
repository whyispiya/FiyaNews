<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Article - {{ $article->title }}</title>
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 font-sans text-gray-800">
    @include('layouts.navbar')

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <a href="{{ route('articles.show', $article->id) }}" class="text-sm text-red-600 hover:underline font-medium">
                    ← Back to Article Detail
                </a>
                <h1 class="text-3xl font-bold text-gray-900 mt-2">Edit Article</h1>
                <p class="text-sm text-gray-500 mt-1">Modify the fields below to update the article content.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg text-sm text-red-700">
                    <p class="font-bold mb-1">Please correct the following errors:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT') <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Article Title <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $article->title) }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-hidden focus:border-red-500 focus:ring-3 focus:ring-red-100 font-medium transition text-gray-900">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="author" class="block text-sm font-semibold text-gray-700 mb-2">Author Name <span class="text-red-500">*</span></label>
                        <input type="text" id="author" name="author" value="{{ old('author', $article->author) }}" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-hidden focus:border-red-500 focus:ring-3 focus:ring-red-100 transition text-gray-900">
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Category <span class="text-red-500">*</span></label>
                        <select id="category" name="category" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white focus:outline-none focus:border-teal-500 focus:ring-3 focus:ring-teal-100 transition text-gray-900">
                            @php 
                                // Ambil data dari input lama jika ada error, jika tidak ambil dari database
                                $currentCategory = old('category', $article->category); 
                            @endphp
                            <option value="Sport" {{ $currentCategory == 'Sport' ? 'selected' : '' }}>Sport</option>
                            <option value="Business" {{ $currentCategory == 'Business' ? 'selected' : '' }}>Business</option>
                            <option value="Technology" {{ $currentCategory == 'Technology' ? 'selected' : '' }}>Technology</option>
                            <option value="Health" {{ $currentCategory == 'Health' ? 'selected' : '' }}>Health</option>
                            <option value="Culture" {{ $currentCategory == 'Culture' ? 'selected' : '' }}>Culture</option>
                            <option value="Travel" {{ $currentCategory == 'Travel' ? 'selected' : '' }}>Travel</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="source" class="block text-sm font-semibold text-gray-700 mb-2">Source</label>
                        <input type="text" id="source" name="source" value="{{ old('source', $article->source) }}" placeholder="e.g., Cartoon Networks"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-hidden focus:border-teal-500 focus:ring-3 focus:ring-teal-100 transition text-gray-900">
                    </div>

                    <div>
                        <label for="created_at" class="block text-sm font-semibold text-gray-700 mb-2">Publish Date <span class="text-red-500">*</span></label>
                        <input type="datetime-local" id="created_at" name="created_at" 
                            value="{{ old('created_at', $article->created_at ? $article->created_at->format('Y-m-d\TH:i') : '') }}" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-hidden focus:border-teal-500 focus:ring-3 focus:ring-teal-100 transition text-gray-700">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Cover Image</label>
                    @if($article->image)
                        <div class="mb-3 w-48 h-28 rounded-lg overflow-hidden border border-gray-200 bg-gray-100">
                            <img src="{{ asset('storage/' . $article->image) }}" alt="Current Cover" class="w-full h-full object-cover">
                        </div>
                        <p class="text-xs text-gray-400 mb-2">Current image preview. Upload a new file below to change it.</p>
                    @endif
                    <input type="file" id="image" name="image" accept="image/*"
                        class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-500 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition">
                </div>

                <div>
                    <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">Article Content <span class="text-red-500">*</span></label>
                    <textarea id="content" name="content" rows="10" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-hidden focus:border-red-500 focus:ring-3 focus:ring-red-100 transition text-gray-900 leading-relaxed">{{ old('content', $article->content) }}</textarea>
                </div>

                <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                    <a href="{{ route('articles.show', $article->id) }}" class="px-5 py-2.5 text-sm font-semibold text-gray-500 hover:bg-gray-100 rounded-xl transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl text-sm shadow-xs transition cursor-pointer">
                        Save
                    </button>
                </div>

            </form>
        </div>
    </main>
</body>
</html>