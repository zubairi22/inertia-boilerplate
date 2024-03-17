<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class UsersController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Master/User/Index', [
            'users' => User::filter(Request::only('search'))->paginate(15)
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Master/User/Create');
    }

    public function store(UserCreateRequest $request): RedirectResponse
    {
        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ]);

        return Redirect::route('users.index')->with('success', 'Tambah Pengguna Berhasil.');
    }


    public function edit(User $user): Response
    {
        return Inertia::render('Master/User/Edit', [
            'user' => $user,
        ]);
    }

    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $user->update($request->only('name', 'email'));

        if ($request->filled('password')) {
            $user->update(['password' => $request->input('password')]);
        }

        return Redirect::route('users.index')->with('success', 'Update Pengguna Berhasil.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return Redirect::back()->with('success', 'Hapus Pengguna Berhasil.');
    }
}
