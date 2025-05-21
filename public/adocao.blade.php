@extends('layouts.app')

@section('title', 'Adote um Pet')

@section('content')
<section class="max-w-6xl mx-auto py-8 px-4">
  <h2 class="text-2xl font-semibold mb-6 text-center">Adote um Pet</h2>

  <form method="GET" action="{{ route('adote') }}" class="mb-6 flex flex-wrap gap-4 justify-center">
    <select name="type" class="border p-2 rounded">
      <option value="">Tipo</option>
      <option value="Cachorro" {{ request('type') == 'Cachorro' ? 'selected' : '' }}>Cachorro</option>
      <option value="Gato" {{ request('type') == 'Gato' ? 'selected' : '' }}>Gato</option>
    </select>
    <select name="gender" class="border p-2 rounded">
      <option value="">Sexo</option>
      <option value="Macho" {{ request('gender') == 'Macho' ? 'selected' : '' }}>Macho</option>
      <option value="Fêmea" {{ request('gender') == 'Fêmea' ? 'selected' : '' }}>Fêmea</option>
    </select>
    <select name="size" class="border p-2 rounded">
      <option value="">Porte</option>
      <option value="Pequeno" {{ request('size') == 'Pequeno' ? 'selected' : '' }}>Pequeno</option>
      <option value="Médio" {{ request('size') == 'Médio' ? 'selected' : '' }}>Médio</option>
      <option value="Grande" {{ request('size') == 'Grande' ? 'selected' : '' }}>Grande</option>
    </select>
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Filtrar</button>
  </form>

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    @forelse ($pets as $pet)
      <div class="bg-white rounded shadow p-4">
        @if ($pet->image_path)
          <img src="{{ asset('storage/' . $pet->image_path) }}" alt="{{ $pet->name }}" class="w-full h-48 object-cover rounded">
        @else
          <div class="w-full h-48 bg-gray-100 text-center flex items-center justify-center text-sm text-gray-500 rounded">Sem imagem</div>
        @endif
        <h3 class="text-xl font-bold mt-2 text-green-700">
          {{ $pet->name }}
          @if($pet->status === 'Adotado')
            <span class="ml-2 inline-block bg-gray-300 text-gray-700 text-xs px-2 py-1 rounded">Adotado</span>
          @endif
        </h3>
        <p class="text-sm text-gray-600">{{ $pet->type }} | {{ $pet->gender }} | {{ $pet->age_group }} | Porte {{ $pet->size }}</p>
        <ul class="flex flex-wrap gap-1 text-xs mt-2">
          @foreach (json_decode($pet->tags, true) as $tag)
            <li class="bg-green-100 text-green-800 px-2 py-1 rounded font-medium">{{ $tag }}</li>
          @endforeach
        </ul>
        <div class="flex justify-between items-center mt-3">
          <a href="https://wa.me/559999999999?text=Quero%20adotar%20o%20pet%20{{ urlencode($pet->name) }}" target="_blank" class="text-sm text-green-700 font-semibold hover:underline">Quero Adotar</a>
          <button onclick="reportPet('{{ $pet->name }}')" class="text-xs text-red-600 hover:underline underline-offset-2" aria-label="Reportar problema com o pet {{ $pet->name }}">
            Reportar
          </button>
        </div>
      </div>
    @empty
      <p class="col-span-3 text-center text-gray-500">Nenhum pet disponível no momento.</p>
    @endforelse
  </div>

  @if(session('success'))
    <div id="toast" class="fixed bottom-4 right-4 bg-green-100 border border-green-400 text-green-800 px-4 py-2 rounded shadow">
      {{ session('success') }}
    </div>
    <script>setTimeout(() => document.getElementById('toast')?.remove(), 4000);</script>
  @endif
</section>

<script>
function reportPet(name) {
  const url = `https://wa.me/559999999999?text=Gostaria%20de%20reportar%20um%20problema%20com%20o%20pet%20${encodeURIComponent(name)}`;
  window.open(url, '_blank');
}
</script>
@endsection
