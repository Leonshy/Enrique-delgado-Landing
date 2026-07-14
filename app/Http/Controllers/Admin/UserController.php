<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::orderBy('name')->get();
        return view('admin.usuarios.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.usuarios.form', ['user' => new User()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'confirmed', $this->passwordRule()],
        ], $this->messages());

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado.');
    }

    public function edit(User $usuario): View
    {
        return view('admin.usuarios.form', ['user' => $usuario]);
    }

    public function update(Request $request, User $usuario): RedirectResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($usuario->id)],
            'password' => ['nullable', 'confirmed', $this->passwordRule()],
        ], $this->messages());

        $usuario->name  = $data['name'];
        $usuario->email = $data['email'];
        if (!empty($data['password'])) {
            $usuario->password = Hash::make($data['password']);
        }
        $usuario->save();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado.');
    }

    public function destroy(Request $request, User $usuario): RedirectResponse
    {
        if ($usuario->id === $request->user()->id) {
            return back()->with('error', 'No podés eliminar tu propio usuario.');
        }

        if (User::count() <= 1) {
            return back()->with('error', 'Tiene que quedar al menos un usuario.');
        }

        $usuario->delete();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado.');
    }

    private function passwordRule(): Password
    {
        return Password::min(10)->letters()->mixedCase()->numbers()->symbols()->uncompromised();
    }

    private function messages(): array
    {
        return [
            'name.required'     => 'El nombre es obligatorio.',
            'name.max'          => 'El nombre no puede superar los 100 caracteres.',
            'email.required'    => 'El email es obligatorio.',
            'email.email'       => 'Ingresá un email válido.',
            'email.unique'      => 'Ya existe un usuario con ese email.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'La confirmación no coincide con la contraseña.',
            'password.min'       => 'La contraseña tiene que tener al menos 10 caracteres.',
            'password.letters'   => 'La contraseña tiene que incluir letras.',
            'password.mixed'     => 'La contraseña tiene que incluir mayúsculas y minúsculas.',
            'password.numbers'   => 'La contraseña tiene que incluir al menos un número.',
            'password.symbols'   => 'La contraseña tiene que incluir al menos un símbolo (ej: # ! $ %).',
            'password.uncompromised' => 'Esa contraseña apareció en filtraciones de datos conocidas. Elegí otra.',
        ];
    }
}
