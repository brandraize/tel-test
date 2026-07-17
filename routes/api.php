<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')->get('/_health', function () {
    return response()->json(['ok' => true]);
});
