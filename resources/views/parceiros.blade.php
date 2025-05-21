@extends('layouts.app')

@section('title', 'Parceiros')

@section('content')
<section class="max-w-4xl mx-auto py-8 px-4 text-center">
  <h2 class="text-2xl font-semibold mb-6">Nossos Parceiros</h2>

  <div class="grid grid-cols-2 md:grid-cols-4 gap-6 items-center">
    @forelse($parceiros as $parceiro)
      <div>
        @if($parceiro->logo)
          <a href="{{ $parceiro->link }}" target="_blank">
            <img src="{{ asset('storage/' . $parceiro->logo) }}" alt="{{ $parceiro->name }}" class="max-h-20 mx-auto">
          </a>
        @endif
        <p class="mt-2 text-sm">{{ $parceiro->name }}</p>
      </div>
    @empty
      <p class="col-span-4 text-gray-500">Nenhum parceiro cadastrado ainda.</p>
    @endforelse
  </div>
</section>
@endsection