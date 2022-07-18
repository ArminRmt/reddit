<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{


    //  Store a newly created resource in storage.

    public function store(Request $request, Post $post)
    {
        $post->load('community');

        $post->comments()->create([
            'user_id' => auth()->id(),
            'comment_text' => $request->comment_text
        ]);

        return redirect()->route('communities.posts.show', [$post->id]);
    }



    //  Display the specified resource.

    public function show($id)
    {
        //
    }


    //  Show the form for editing the specified resource.

    public function edit($id)
    {
        //
    }


    //  Update the specified resource in storage.

    public function update(Request $request, $id)
    {
        //
    }


    // Remove the specified resource from storage.

    public function destroy($id)
    {
        //
    }
}
