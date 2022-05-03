<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class SearchSuggestionsController extends Controller
{
    public function getSuggestions($term)
    {
        return response()->json(
            DB::table('cities')
                ->where('name','like','%'.$term.'%')
                ->take(2)->get()
        );
    }

}
