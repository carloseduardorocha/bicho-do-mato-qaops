@extends('layouts.app')

@section('title', 'Nova Notícia')

@section('content')
<section class="max-w-3xl mx-auto py-8 px-4">
  <h2 class="text-2xl font-semibold mb-6 text-center">Cadastrar Nova Notícia</h2>

  <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <div>
      <label for="title" class="block font-medium">Título</label>
      <input type="text" name="title" id="title" class="w-full border rounded p-2" required>
    </div>

    <div>
      <label for="author" class="block font-medium">Autor</label>
      <input type="text" name="author" id="author" class="w-full border rounded p-2" required>
    </div>

    <div>
      <label for="content" class="block font-medium">Conteúdo</label>
      <textarea name="content" id="content" rows="6" class="w-full border rounded p-2" required></textarea>
    </div>

    <div>
      <label for="image" class="block font-medium">Imagem (opcional)</label>
      <input type="file" name="image" id="image" class="w-full border rounded p-2">
    </div>

    <div class="text-center">
      <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Salvar</button>
    </div>
  </form>
</section>
@endsection