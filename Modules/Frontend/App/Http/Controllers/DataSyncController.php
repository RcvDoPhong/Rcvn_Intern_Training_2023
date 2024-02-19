<?php

namespace Modules\Frontend\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DataSyncController extends Controller
{
    public function syncRandomPersonData(Request $request){

        return response()->json(['message' => 'success']);
    }
}
