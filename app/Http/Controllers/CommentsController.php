<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentPostRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkClient', ['except' => ['index', 'show', 'update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $comments = Comment::with('enterprise')
            ->with('store')
            ->with('service')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        if (!auth()->user()->is_admin) {
            foreach ($comments as $c){
                if( !$c->description_enable )
                    $c->description = null;
            }
        }

        return $comments;
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
        $data = $comment;
        $data["user"] = $comment->user;
        $data["enterprise"] = $comment->enterprise;
        $data["store"] = $comment->store;
        $data["service"] = $comment->service;

        return $data;
    }

    public function update(Request $request, Comment $comment)
    {
        if( auth()->user()->is_admin ){
            $comment->description_enable = $request->description_enable;
            $comment->description_locked = !$comment->description_enable;
        }

        if(!$comment->description_locked && !auth()->user()->is_admin){
            $comment->description_enable = $request->description_enable;
            $comment->description_locked = auth()->user()->is_admin;
        }

        if (!$comment->save()) {
            return response()->json([
                'message' => "Error al actualizar comentario."
            ], 500);
        }

        return response()->json([
            'message' => "El comentario ha sido actualizado con éxito."
        ]);
    }

    public function destroy(Comment $comment)
    {
        //
    }
}
