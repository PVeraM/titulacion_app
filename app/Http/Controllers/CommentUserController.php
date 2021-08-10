<?php

namespace App\Http\Controllers;

use App\Models\CommentUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CommentUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkClient', ['except' => ['index', 'show']]);
    }

    public function store(Request $request)
    {
        $like = CommentUser::where('comment_id', '=', $request->comment_id)
            ->where('user_id', '=', auth()->user()->id)
            ->first();
//        var_dump($like);

        if( !$like ){
            $data = $request->all();
            $data['user_id'] = strval(auth()->user()->id);
            CommentUser::create($data);

            return response()->json([
                'message' => 'Like creado.',
            ], Response::HTTP_CREATED);
        }

        $like->like = $request->like;
        $like->save();

        return response()->json([
            'message' => 'Like actualizado.',
        ], Response::HTTP_CREATED);

    }
}
