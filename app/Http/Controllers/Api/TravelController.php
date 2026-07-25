<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Travel;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    public function index(Request $request)
    {
        $travels = Travel::with('armada')->latest()->get();
        return response()->json($travels);
    }

    public function show(string $id)
    {
        $travel = Travel::with(['armada', 'destinasis'])->findOrFail($id);
        return response()->json($travel);
    }
}
