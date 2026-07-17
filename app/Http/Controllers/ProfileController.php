<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        return response()->json(['message' => 'Profile page is not implemented yet.']);
    }

    public function update(Request $request)
    {
        return response()->json(['message' => 'Profile update is not implemented yet.']);
    }

    public function destroy(Request $request)
    {
        return response()->json(['message' => 'Profile deletion is not implemented yet.']);
    }
}
