<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    protected UserService $user_service;

    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }

    /**
     * List all users.
     */
    public function index(Request $request)
    {
        try {
            $per_page = $request->integer('per_page', 15);
            $users = $this->user_service->getPaginated($per_page);

            return view('admin.users.index', compact('users'));
        } catch (\Throwable $e) {
            Log::error('UserController@index failed', [
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Erro ao carregar a lista de usuários.');
        }
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a new user.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|max:255|unique:users,email',
                'password' => ['required', 'confirmed', Password::min(8)],
            ], [
                'name.required'     => 'O nome é obrigatório.',
                'email.required'    => 'O email é obrigatório.',
                'email.email'       => 'Formato de email inválido.',
                'email.unique'      => 'Este email já está cadastrado.',
                'password.required' => 'A senha é obrigatória.',
                'password.confirmed' => 'As senhas não coincidem.',
                'password.min'      => 'A senha deve ter no mínimo 8 caracteres.',
            ]);

            $this->user_service->create($validated);

            return redirect()->route('admin.users.index')->with('success', 'Usuário criado com sucesso!');

        } catch (\Throwable $e) {
            Log::error('UserController@store failed', [
                'data'  => $request->all(),
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->withInput()->with('error', 'Erro ao criar usuário.');
        }
    }

    /**
     * Show edit form.
     */
    public function edit(int $id)
    {
        try {
            $user = $this->user_service->getById($id);

            return view('admin.users.edit', compact('user'));

        } catch (\Throwable $e) {
            Log::error('UserController@edit failed', [
                'id'    => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('admin.users.index')->with('error', 'Usuário não encontrado.');
        }
    }

    /**
     * Update a user by ID.
     */
    public function update(Request $request, int $id)
    {
        try {
            $validated = $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|max:255|unique:users,email,' . $id,
                'password' => ['nullable', 'confirmed', Password::min(8)],
            ], [
                'name.required'      => 'O nome é obrigatório.',
                'email.required'     => 'O email é obrigatório.',
                'email.email'        => 'Formato de email inválido.',
                'email.unique'       => 'Este email já está cadastrado.',
                'password.confirmed' => 'As senhas não coincidem.',
                'password.min'       => 'A senha deve ter no mínimo 8 caracteres.',
            ]);

            // Remove password do array se estiver vazio
            if (empty($validated['password'])) {
                unset($validated['password']);
                unset($validated['password_confirmation']);
            }

            $this->user_service->update($id, $validated);

            return redirect()->route('admin.users.index')->with('success', 'Usuário atualizado com sucesso!');

        } catch (\Throwable $e) {
            Log::error('UserController@update failed', [
                'id'    => $id,
                'data'  => $request->all(),
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->withInput()->with('error', 'Erro ao atualizar usuário.');
        }
    }

    /**
     * Delete a user by ID.
     */
    public function destroy(int $id)
    {
        try {
            // Prevenir que o usuário delete a si mesmo
            if ($id == auth()->id()) {
                return redirect()->back()->with('error', 'Você não pode deletar seu próprio usuário.');
            }

            $this->user_service->delete($id);

            return redirect()->route('admin.users.index')->with('success', 'Usuário removido com sucesso!');

        } catch (\Throwable $e) {
            Log::error('UserController@destroy failed', [
                'id'    => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Erro ao remover usuário.');
        }
    }
}