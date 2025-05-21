@extends('layouts.app')

@section('title', 'Novo Depoimento')

@section('content')
<section class="max-w-3xl mx-auto py-8 px-4">
  <h2 class="text-2xl font-semibold mb-6 text-center">Cadastrar Novo Depoimento</h2>

  <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <div>
      <label for="name" class="block font-medium">Nome</label>
      <input type="text" name="name" id="name" class="w-full border rounded p-2" required>
    </div>

    <div>
      <label for="message" class="block font-medium">Mensagem</label>
      <textarea name="message" id="message" rows="4" class="w-full border rounded p-2" required></textarea>
    </div>

    <div>
      <label for="image" class="block font-medium">Foto (opcional)</label>
      <input type="file" name="image" id="image" class="w-full border rounded p-2">
    </div>

    <div class="text-center">
      <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Salvar</button>
    </div>
  </form>
</section>
@endsection