<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        // TODO: implement update
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        // TODO: implement delete
    }
}