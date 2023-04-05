<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        return response([
            'tags' => Tag::orderBy('created_at', 'desc')->with('user:id,name')->get(),
        ], 200);
    }

    public function store(StoreTagRequest $request)
    {
        $tag = Tag::create([
            'name' => $request->validated('name'),
            'user_id' => auth()->user()->id,
        ]);

        return response([
            'message' => 'Tag created.',
            'tag' => $tag,
        ], 200);
    }

    public function show(Tag $id)
    {
        return response([
            'tag' => Tag::where('id', $id)->get(),
        ], 200);
    }

    public function update(UpdateTagRequest $request, Tag $id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return response([
                'message' => 'Tag not found.',
            ], 403);
        }

        if ($tag->user_id != auth()->user()->id) {
            return response([
                'message' => 'Permission denied.',
            ], 403);
        }

        $tag->update([
            'name' => $request->validated('name'),
            'user_id' => auth()->user()->id,
        ]);

        return response([
            'message' => 'Tag updated.',
            'tag' => $tag,
        ], 200);
    }

    public function destroy(Tag $id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return response([
                'message' => 'Tag not found.',
            ], 403);
        }

        if ($tag->user_id != auth()->user()->id) {
            return response([
                'message' => 'Permission denied.',
            ], 403);
        }

        $tag->forceDelete();

        return response([
            'message' => 'tag deleted.',
        ], 200);
    }
}
