<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
    public function search(Request $request, $entity){
        $data = null;
        $word = $request->input('word');

        switch ($entity){
            case 'users':
                $data = $this->searchUsers($word);
                break;
            default:
                $data = $this->searchGeneric($entity, $word);
        }

        return response()->json([
            'data' => $data
        ], Response::HTTP_OK);
    }

    private function searchGeneric( $entity, $word ){
        return DB::table($entity)
        ->where('name', 'LIKE', '%'.$word.'%')
        ->orderBy('name')
        ->get();
    }

    private function searchUsers( $word ){
        return User::where('first_name', 'LIKE', '%'.$word.'%')
        ->orWhere('last_name', 'LIKE', '%'.$word.'%')
        ->orderBy('first_name')
        ->orderBy('last_name')
        ->get();
    }
}
