@extends('layouts.app')

@section('title', 'Novo Pet para Adoção')

@section('content')
<section class="max-w-3xl mx-auto py-8 px-4">
  <h2 class="text-2xl font-semibold mb-6 text-center">Cadastrar Novo Pet</h2>

  <form method="POST" action="{{ route('admin.pets.store') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <div>
      <label for="name" class="block font-medium">Nome</label>
      <input type="text" name="name" id="name" class="w-full border rounded p-2" required>
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label for="type" class="block font-medium">Tipo</label>
        <select name="type" id="type" class="w-full border rounded p-2" required>
          <option value="Cachorro">Cachorro</option>
          <option value="Gato">Gato</option>
        </select>
      </div>
      <div>
        <label for="gender" class="block font-medium">Sexo</label>
        <select name="gender" id="gender" class="w-full border rounded p-2" required>
          <option value="Fêmea">Fêmea</option>
          <option value="Macho">Macho</option>
        </select>
      </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label for="age_group" class="block font-medium">Faixa Etária</label>
        <select name="age_group" id="age_group" class="w-full border rounded p-2" required>
          <option value="Filhote">Filhote</option>
          <option value="Adulto">Adulto</option>
        </select>
      </div>
      <div>
        <label for="size" class="block font-medium">Porte</label>
        <select name="size" id="size" class="w-full border rounded p-2" required>
          <option value="Pequeno">Pequeno</option>
          <option value="Médio">Médio</option>
          <option value="Grande">Grande</option>
        </select>
      </div>
    </div>

    <div>
      <label for="tags" class="block font-medium">Tags (separadas por vírgula)</label>
      <input type="text" name="tags" id="tags" class="w-full border rounded p-2" placeholder="Dócil, Brincalhão, Castrado...">
    </div>

    <div>
      <label for="image" class="block font-medium">Foto</label>
      <input type="file" name="image" id="image" class="w-full border rounded p-2">
    </div>

    <div class="text-center">
      <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Salvar</button>
    </div>
  </form>
</section>
@endsection