<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Settings page is not implemented yet.']);
    }

    public function update(Request $request)
    {
        return response()->json(['message' => 'Settings update is not implemented yet.']);
    }
}
