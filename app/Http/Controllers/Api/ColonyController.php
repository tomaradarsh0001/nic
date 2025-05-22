<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OldColony;

class ColonyController extends Controller
{
    public function getAllcolonies()
    {
        $colonies = OldColony::all(['name', 'code']);

        $colonyList = $colonies->map(function ($colony) {
            return [
                'name' => $colony->name,
                'code' => $colony->code,
            ];
        });

        if ($colonyList->isNotEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Colony list fetched successfully',
                'colony_list' => $colonyList
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to fetch Colonies list! Something went wrong.',
                'colony_list' => [],
            ], 400);
        }
    }
}
