@extends('layouts.app')

@section('title', 'Logs de Acesso')

@section('content')
<section class="max-w-6xl mx-auto p-6">
  <h1 class="text-2xl font-bold mb-4">Registros de Acesso</h1>

  <form method="GET" action="{{ route('admin.acessos.index') }}" class="flex flex-wrap gap-4 mb-6">
    <input type="date" name="data" value="{{ request('data') }}" class="border p-2 rounded" />
    <input type="text" name="ip" placeholder="IP" value="{{ request('ip') }}" class="border p-2 rounded" />
    <input type="text" name="url" placeholder="URL" value="{{ request('url') }}" class="border p-2 rounded" />
    <button class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">Filtrar</button>
    <a href="{{ route('admin.acessos.export') }}" class="text-sm text-blue-600 hover:underline">Exportar CSV</a>
  </form>

  <table class="table-auto w-full text-sm bg-white rounded shadow overflow-hidden">
    <thead>
      <tr class="bg-gray-100">
        <th class="p-2 text-left">Data</th>
        <th class="p-2 text-left">IP</th>
        <th class="p-2 text-left">URL</th>
        <th class="p-2 text-left">Usuário</th>
      </tr>
    </thead>
    <tbody>
      @forelse($acessos as $acesso)
        <tr class="border-t">
          <td class="p-2">{{ $acesso->created_at->format('d/m/Y H:i') }}</td>
          <td class="p-2">{{ $acesso->ip }}</td>
          <td class="p-2">{{ $acesso->url }}</td>
          <td class="p-2">{{ $acesso->user_id ?? 'Visitante' }}</td>
        </tr>
      @empty
        <tr><td colspan="4" class="p-4 text-center text-gray-500">Nenhum acesso registrado.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div class="mt-4">
    {{ $acessos->appends(request()->query())->links() }}
  </div>
</section>
@endsection