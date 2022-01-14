<?php

namespace App\Http\Controllers;

use App\Services\EarthService;
use App\Services\Position;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EarthController extends Controller
{

    protected $earthService;

    public function index(EarthService $earthService)
    {
        // generate a list of movements between 5 and 7 elements of the array with values: UP, DOWN, LEFT, RIGHT
        return $earthService->generateMovements();
    }

    public function position(Request $request, EarthService $earthService)
    {
        $movements = $request->input('items');

        // get the initial position from the request, example: [0,0]
        $initial = $request->input('initial');

        // return the final position
        return response()->json(['movements'=> $earthService->getFinalPosition($movements, $initial)]);
    }

}
