<?php

namespace App\Http\Controllers;

use App\Models\BantuanProgram;
use Illuminate\Http\Request;

class BantuanProgramController extends Controller
{
    public function index()
    {
        $programs = BantuanProgram::latest()->get();
        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.programs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_program' => 'required',
            'deskripsi' => 'required',
            'kuota' => 'required|integer',
            'deadline' => 'required|date',
        ]);

        BantuanProgram::create($request->all());
        return redirect()->route('admin.programs.index')->with('success', 'Program bantuan ditambahkan.');
    }

    public function edit(BantuanProgram $program)
    {
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, BantuanProgram $program)
    {
        $request->validate([
            'nama_program' => 'required',
            'deskripsi' => 'required',
            'kuota' => 'required|integer',
            'deadline' => 'required|date',
        ]);

        $program->update($request->all());
        return redirect()->route('admin.programs.index')->with('success', 'Program diupdate.');
    }

    public function destroy(BantuanProgram $program)
    {
        $program->delete();
        return redirect()->route('admin.programs.index')->with('success', 'Program dihapus.');
    }
}