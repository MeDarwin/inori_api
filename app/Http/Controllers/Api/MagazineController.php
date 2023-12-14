<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Magazine\MagazineRequest;
use App\Models\Magazine;
use App\Models\MagazineCategory;
use Illuminate\Http\Request;

//TODO: Add update thumbnail method
class MagazineController extends Controller
{
    /**
     * Get all the Magazines
     */
    public function get(Request $request)
    {
        return response()->json(Magazine::query()->get());
    }

    public function getOne(Request $request)
    {
        return response()->json(Magazine::query()->findOrFail($request->id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MagazineRequest $request)
    {
        //TODO: Upload file upon creating
        $magazine = Magazine::query()->create(
            array_merge(
                $request->validated(),
                ['creator_username' => $request->user()->username]
            ));

        return $magazine->save()
            ? response()->json([
                'message' => "Magazine `$request->title` created successfully",
                'created' => $magazine
            ])
            : response()->json(['message' => "Magazine `$request->title` failed to create"], 500);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MagazineRequest $request)
    {
        $magazine = Magazine::query()->findOrFail($request->id);
        if ($magazine->creator_username !== $request->user()->username && $request->user()->role !== 'admin') {
            return response()->json(['message' => "Unable to update magazine as it is not yours"], 403);
        }
        return $magazine->fill($request->validated())->save()
            ? response()->json([
                'message' => "Magazine `$request->id` updated successfully",
                'updated' => $magazine->getChanges()
            ])
            : response()->json(['message' => "Magazine `$request->id` failed to update"], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $magazine = Magazine::query()->findOrFail($request->id);
        if ($magazine->creator_username !== $request->user()->username && $request->user()->role !== 'admin') {
            return response()->json(['message' => "Unable to update magazine as it is not yours"], 403);
        }
        return $magazine->delete()
            ? response()->json(['message' => "Category `$request->id` deleted successfully"])
            : response()->json(['message' => "Category `$request->id` failed to delete"], 500);
    }

    /**
     * Add category to magazine
     */
    public function addCategory(Request $request)
    {
        // Validate is category exists
        $validated = $request->validate([
            'category_name' => ['required', 'string', 'exists:category,name'],
        ]);
        // Validate is magazine exists
        $magazine = Magazine::query()->findOrFail($request->id);

        // Is user the creator of the magazine and bypass admin
        if ($magazine->creator_username !== $request->user()->username && $request->user()->role !== 'admin') {
            return response()->json(['message' => "Unable to update magazine as it is not yours"], 403);
        }
        // Prevent duplication
        $isExist = MagazineCategory::query()
            ->where('magazine_id', $request->id)
            ->where('category_name', $validated['category_name'])
            ->count('id');
        if ($isExist) {
            return response()->json(['message' => "Category `" . $validated['category_name'] . "` already added to this magazine"], 403);
        }

        // Define magazine category model to save
        $magCategory = MagazineCategory::query()->create(array_merge(['magazine_id' => $request->id], $validated));
        return $magCategory->save()
            ? response()->json(['message' => "Category `" . $validated['category_name'] . "` added successfully",])
            : response()->json(['message' => "Category `" . $validated['category_name'] . "` failed to add"], 500);
    }

    /**
     * Remove category from magazine
     */
    public function removeCategory(Request $request)
    {
        // Validate is category exists
        $validated = $request->validate([
            'category_name' => ['required', 'string', 'exists:category,name'],
        ]);
        // Validate is magazine exists
        $magazine = Magazine::query()->findOrFail($request->id);

        // Is user the creator of the magazine and bypass admin
        if ($magazine->creator_username !== $request->user()->username && $request->user()->role !== 'admin') {
            return response()->json(['message' => "Unable to update magazine as it is not yours"], 403);
        }

        // Define magazine category model to delete
        $magCategory = MagazineCategory::query()->create(array_merge(['magazine_id' => $request->id], $validated));
        return $magCategory->delete()
            ? response()->json(['message' => "Category `" . $validated['category_name'] . "` deleted successfully"])
            : response()->json(['message' => "Category `" . $validated['category_name'] . "` failed to delete"], 500);
    }
}
