<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    private const ROLES = ['admin', 'venta', 'cocina'];

    public function index()
    {
        $users = User::orderBy('id')->get();
        return view('usuarios.index', compact('users'));
    }

    public function create()
    {
        $roles = self::ROLES;
        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'role' => ['required','in:' . implode(',', self::ROLES)],
            'phone' => ['nullable','string','max:50'],
            'is_active' => ['nullable','boolean'],
        ]);

        $tempPassword = str()->random(10);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'is_active' => $request->boolean('is_active', true),
            'password' => Hash::make($tempPassword),
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', "Usuario creado. Password temporal: {$tempPassword}");
    }

    public function edit(User $user)
    {
        $roles = self::ROLES;
        return view('usuarios.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email,' . $user->id],
            'role' => ['required','in:' . implode(',', self::ROLES)],
            'phone' => ['nullable','string','max:50'],
            'is_active' => ['nullable','boolean'],
        ]);

        // Admin no puede desactivarse a sí mismo
        $isActive = auth()->id() === $user->id
            ? true
            : $request->boolean('is_active');

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'is_active' => $isActive,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado.');
    }

    public function toggleActive(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('success', 'No puedes desactivar tu propia cuenta.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        return back()->with(
            'success',
            $user->is_active ? 'Usuario activado.' : 'Usuario desactivado.'
        );
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('success', 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
