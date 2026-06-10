<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tpu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('tpu')
            ->latest()
            ->paginate(10);

        return view(
            'users.index',
            compact('users')
        );
    }

    public function create()
    {
        $tpus = Tpu::all();

        return view(
            'users.create',
            compact('tpus')
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required',

            'email' => 'required|email|unique:users',

            'password' => 'required|min:6',

            'role' => 'required',
        ]);

        User::create([

            'name' => $request->name,

            'email' => $request->email,

            'password' => Hash::make(
                $request->password
            ),

            'role' => $request->role,

            'tpu_id' => $request->tpu_id,
        ]);

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'User berhasil ditambahkan'
            );
    }

    public function edit(User $user)
    {
        $tpus = Tpu::all();

        return view(
            'users.edit',
            compact('user', 'tpus')
        );
    }

    public function update(
    Request $request,
    User $user
    ) {

        $request->validate([

            'name' => 'required',

            'email' => 'required|email|unique:users,email,' . $user->id,

            'role' => 'required',

        ]);

        $user->update([

            'name' => $request->name,

            'email' => $request->email,

            'role' => $request->role,

            'tpu_id' => $request->tpu_id,

        ]);

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'User berhasil diperbarui'
            );
    }

    public function destroy(User $user)
    {
        if ($user->id == Auth::id()) {

            return back()->with(
                'error',
                'Anda tidak dapat menghapus akun sendiri.'
            );
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'User berhasil dihapus.'
            );
    }
}