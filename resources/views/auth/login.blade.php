@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
  <h2 class="text-xl font-bold mb-4 text-center">Entrar</h2>

  @if (session('status'))
    <div class="bg-green-100 text-green-800 text-sm p-2 rounded mb-4">
      {{ session('status') }}
    </div>
  @endif

  <form method="POST" action="{{ route('login') }}" class="space-y-4">
    @csrf

    <div>
      <label for="email" class="block text-sm font-medium">Email</label>
      <input type="email" name="email" id="email" class="w-full border p-2 rounded" required autofocus>
  </div>

    <div>
      <label for="password" class="block text-sm font-medium">Senha</label>
      <input type="password" name="password" id="password" class="w-full border p-2 rounded" required>
    </div>

    <div class="text-right">
      <a href="{{ route('password.request') }}" class="text-xs text-blue-600 hover:underline">Esqueceu a senha?</a>
    </div>

    <div class="text-center">
      <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">Acessar</button>
    </div>
  </form>
</div>
@endsection