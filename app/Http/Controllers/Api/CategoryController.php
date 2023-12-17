<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * get all categories.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request): JsonResponse
    {
        return response()->json(Category::query()->get());
    }

    public function getOne(Request $request)
    {
        return response()->json(Category::with('magazine')->findOrFail($request->id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        return Category::query()->create($request->validated())->save()
            ? response()->json(['message' => "Category `$request->name` created successfully"])
            : response()->json(['message' => "Category `$request->name` failed to create"], 500);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request): JsonResponse
    {
        return Category::query()->findOrFail($request->id)->fill($request->validated())->save()
            ? response()->json(['message' => "Category `$request->id` updated successfully to `$request->name`"])
            : response()->json(['message' => "Category `$request->id` failed to update"], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): JsonResponse
    {
        return Category::query()->findOrFail($request->id)->delete()
            ? response()->json(['message' => "Category `$request->id` deleted successfully"])
            : response()->json(['message' => "Category `$request->id` failed to delete"], 500);
    }
}
