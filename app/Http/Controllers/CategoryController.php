<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        return response([
            'categories' => Category::orderBy('created_at', 'desc')->with('user:id,name')->get(),
        ], 200);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = DB::transaction(function () use ($request) {
            $category = Category::firstOrCreate([
                'name' => $request->validated('name'),
                'slug' => $request->validated('slug'),
                'description' => $request->validated('description') ?? null,
                'user_id' => auth()->user()->id,
            ]);

            if ($request->hasfile('image_url')) {
                foreach ($request->file('image_url') as $file) {
                    $name = $file->getClientOriginalName();
                    $file->move(public_path() . '/Category/', $name);
                    $imgData[] = $name;
                }

                $ImageModal = new Image();
                $ImageModal->parentable_id = $category->id;
                $ImageModal->parentable_type = Category::class;
                $ImageModal->name = json_encode($imgData);
                $ImageModal->image_path = json_encode($imgData);

                $ImageModal->save();
            }

            return $category;
        });

        return response([
            'message' => 'Category created successfully.',
            'category' => $category,
        ], 200);
    }

    public function show(Category $id)
    {
        return response([
            'category' => Category::where('id', $id)->with('articles:id,title')->get(),
        ], 200);
    }

    public function update(UpdateCategoryRequest $request, Category $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response([
                'message' => 'Category not found.',
            ], 403);
        }

        if ($category->user_id != auth()->user()->id) {
            return response([
                'message' => 'Permission denied.',
            ], 403);
        }

        $category = DB::transaction(function () use ($request, $category) {
            $category->update([
                'name' => $request->validated('name'),
                'slug' => $request->validated('slug'),
                'description' => $request->validated('description') ?? null,
                'user_id' => auth()->user()->id,
            ]);
        });

        return response([
            'message' => 'Category updated successfully.',
            'category' => $category,
        ], 200);
    }

    public function destroy(Category $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response([
                'message' => 'Category not found.',
            ], 403);
        }

        if ($category->user_id != auth()->user()->id) {
            return response([
                'message' => 'Permission denied.',
            ], 403);
        }

        $category->forceDelete();

        return response([
            'message' => 'category deleted successfully.',
        ], 200);
    }
}
