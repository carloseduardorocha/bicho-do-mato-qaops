@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<section class="max-w-6xl mx-auto p-6">
  <h1 class="text-2xl font-bold mb-6">Painel Administrativo</h1>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded shadow p-4 text-center">
      <p class="text-sm text-gray-500">Total de Acessos</p>
      <p class="text-2xl font-bold">{{ $totalAcessos }}</p>
    </div>
    <div class="bg-white rounded shadow p-4 text-center">
      <p class="text-sm text-gray-500">Páginas Acessadas</p>
      <p class="text-2xl font-bold">{{ $totalUrls }}</p>
    </div>
    <div class="bg-white rounded shadow p-4 text-center">
      <p class="text-sm text-gray-500">Usuários Diferentes</p>
      <p class="text-2xl font-bold">{{ $totalUsers }}</p>
    </div>
  </div>

  <div class="bg-white rounded shadow p-4">
    <h2 class="text-lg font-semibold mb-2">Gráfico de Acessos por Dia</h2>
    <canvas id="graficoAcessos" height="100"></canvas>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('graficoAcessos').getContext('2d');
  const chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: @json($labels),
      datasets: [{
        label: 'Acessos por dia',
        data: @json($data),
        backgroundColor: 'rgba(34, 197, 94, 0.6)',
        borderColor: 'rgba(34, 197, 94, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
</script>
@endsection