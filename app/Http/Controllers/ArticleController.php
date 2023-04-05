<?php

namespace App\Http\Controllers;

use App\Events\ArticlePublished;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Image;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function index()
    {
        return response([
            'articles' => Article::orderBy('created_at', 'desc')->with('tags:id,name')->get(),
        ], 200);
    }

    public function store(StoreArticleRequest $request)
    {
        $article = DB::transaction(function () use ($request) {
            $article = Article::firstOrCreate([
                'title' => $request->validated('title'),
                'detail' => $request->validated('detail') ?? null,
                'category_id' => $request->validated('category_id'),
            ]);

            if ($request->hasfile('image_url')) {
                foreach ($request->file('image_url') as $file) {
                    $name = $file->getClientOriginalName();
                    $file->move(public_path() . '/Article/', $name);
                    $imgData[] = $name;
                }

                $ImageModal = new Image();
                $ImageModal->parentable_id = $article->id;
                $ImageModal->parentable_type = Article::class;
                $ImageModal->name = json_encode($imgData);
                $ImageModal->image_path = json_encode($imgData);

                $ImageModal->save();
            }

            $article->tags()->sync($request->validated('tag_id'));

            return $article;
        });

        event(new ArticlePublished('Article is Published'));

        return response([
            'message' => 'Article Published successfully.',
            'article' => $article,
        ], 200);
    }

    public function show(Article $id)
    {
        return response([
            'article' => Article::where('id', $id)->with('tags:id,name')->get(),
        ], 200);
    }

    public function update(UpdateArticleRequest $request, Article $id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response([
                'message' => 'Article not found.',
            ], 403);
        }

        $article = DB::transaction(function () use ($request, $article) {
            $article->update([
                'title' => $request->validated('title'),
                'detail' => $request->validated('detail') ?? null,
                'category_id' => $request->validated('category_id'),
            ]);

            $article->tags()->sync($request->validated('tag_id'));

            return $article;
        });

        return response([
            'message' => 'Article updated successfully.',
            'article' => $article,
        ], 200);
    }

    public function destroy(Article $id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response([
                'message' => 'Article not found.',
            ], 403);
        }

        $article->forceDelete();

        return response([
            'message' => 'article successfully.',
        ], 200);
    }
}
