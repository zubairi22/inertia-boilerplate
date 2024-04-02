<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\RoleCreateRequest;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class UtilityController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Master/Utility/Index', [
            'roles' => Role::paginate(10),
            'menus' => Menu::whereNull('parent_id')->get()
        ]);
    }

    public function storeRole(RoleCreateRequest $request): RedirectResponse
    {
        Role::create($request->only('name'));

        return Redirect::route('master.utility.index')->with('success', 'Tambah Pengguna Berhasil.');
    }

    public function destroyRole(Role $role): RedirectResponse
    {
        $role->delete();

        return Redirect::back()->with('success', 'Hapus Role Berhasil.');
    }
}
