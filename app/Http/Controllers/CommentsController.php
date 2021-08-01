<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentPostRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentsController extends Controller
{
    public function __construct() {
        $this->middleware('checkClient', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( auth()->user()->is_admin ){
            return Comment::with('enterprise')
                ->with('store')
                ->with('service')
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return Comment::with('enterprise')
            ->with('store')
            ->with('service')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function store(CommentPostRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = strval(auth()->user()->id);
        $comment = Comment::create($data);

        return response()->json([
            'message' => 'Comentario creado con éxito.',
            'comment' => $comment
        ], Response::HTTP_CREATED);
    }

    public function show(Comment $comment)
    {
        $data               = $comment;
        $data["user"]       = $comment->user;
        $data["enterprise"] = $comment->enterprise;
        $data["store"]      = $comment->store;
        $data["service"]    = $comment->service;

        return $data;
    }

    public function update(Request $request, Comment $comment)
    {
        //
    }

    public function destroy(Comment $comment)
    {
        //
    }
}
