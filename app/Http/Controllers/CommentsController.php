<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentPostRequest;
use App\Models\Comment;
use App\Models\comments;
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
        //
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function show(comments $comments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, comments $comments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function destroy(comments $comments)
    {
        //
    }
}
