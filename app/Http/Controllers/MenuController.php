<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::orderBy('order')->get();
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'url' => 'required',
            'order' => 'integer',
        ]);
        Menu::create($request->all());
        return redirect()->route('admin.menus.index')->with('success', 'Menu ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'title' => 'required',
            'url' => 'required',
            'order' => 'integer',
        ]);
        $menu->update($request->all());
        return redirect()->route('admin.menus.index')->with('success', 'Menu diupdate.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success', 'Menu dihapus.');
    }
}