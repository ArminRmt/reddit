<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Community;
use App\Models\Post;
use App\Models\PostVote;
use App\Notifications\PostReportNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;

use function Symfony\Component\String\b;

class CommunityPostController extends Controller
{

    //   Display a listing of the resource.

    public function index(Community $community)
    {
        $posts = $community->posts()->latest('id')->paginate(10);
    }


    //  Show the form for creating a new resource.

    public function create(Community $community)
    {
        return view('posts.create', compact('community'));
    }


    //  Store a newly created resource in storage.

    public function store(StorePostRequest $request, Community $community)
    {
        $post = $community->posts()->create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'post_text' => $request->post_text ?? null,
            'post_url' => $request->post_url ?? null,
        ]);

        if ($request->hasFile('post_image')) {

            $image = $request->file('post_image')->getClientOriginalName();

            $request->file('post_image')
                ->storeAs('public/posts/' . $post->id, $image);

            $post->update(['post_image' => $image]);

            $file = Image::make(storage_path('app/public/posts/' . $post->id . '/' . $image));


            $file->fit(740, 400);


            // $file->resize(600, null, function ($constraint) {
            //     $constraint->aspectRatio();
            // });


            $file->save(storage_path('app/public/posts/' . $post->id . '/thumbnail_' . $image));
        }


        return redirect()->route('communities.show', $community);
    }


    //   Display the specified resource.

    public function show($postId)
    {
        $post = Post::with('comments.user', 'community')->findOrFail($postId);

        return view('posts.show', compact('post'));
    }



    //   Show the form for editing the specified resource.


    public function edit(Community $community, Post $post)
    {
        if (Gate::denies('edit-post', $post)) {
            abort(403);
        }

        return view('posts.edit', compact('community', 'post'));
    }


    //   Update the specified resource in storage.


    public function update(StorePostRequest $request, Community $community, Post $post)
    {
        if (Gate::denies('edit-post', $post)) {
            abort(403);
        }

        $post->update($request->validated());

        if ($request->hasFile('post_image')) {
            $image = $request->file('post_image')->getClientOriginalName();
            $request->file('post_image')
                ->storeAs('public/posts/' . $post->id, $image);

            if ($post->post_image != '' && $post->post_image != $image) {
                unlink(storage_path('app/public/posts/' . $post->id . '/' . $post->post_image));
            }

            $post->update(['post_image' => $image]);

            $file = Image::make(storage_path('app/public/posts/' . $post->id . '/' . $image));
            $file->fit(740, 400);
            $file->save(storage_path('app/public/posts/' . $post->id . '/thumbnail_' . $image));
        }

        return redirect()->route('communities.posts.show', [$post->id]);
    }



    //   Remove the specified resource from storage.


    public function destroy(Community $community, Post $post)
    {
        if (Gate::denies('delete-post', $post)) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('communities.show', [$community]);
    }



    public function report($post_id)
    {
        $post = Post::with('community.user')->findOrFail($post_id);

        $post->community->user->notify(new PostReportNotification($post));


        return redirect()->route('communities.posts.show', [$post->id])
            ->with('message', 'Your report has been sent.');
    }
}
