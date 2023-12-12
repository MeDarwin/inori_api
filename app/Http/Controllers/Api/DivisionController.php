<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Division\DivisionRequest;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Get all the divisions
     */
    public function get(Request $request)
    {
        return response()->json(Division::query()->get());
    }

    /**
     * Get one division
     */
    public function getOne(Request $request)
    {
        return response()->json(Division::query()->findOrFail($request->id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DivisionRequest $request)
    {
        $division = Division::query()->create($request->validated());
        return $division->save()
            ? response()->json([
                'message' => "Division `$request->name` created successfully",
                'created' => $division
            ])
            : response()->json(['message' => "Division `$request->name` failed to create"], 500);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DivisionRequest $request)
    {
        $division = Division::query()->findOrFail($request->id);
        return $division->fill($request->validated())->save()
            ? response()->json([
                'message' => "Division `$request->id` updated successfully",
                'updated' => $division->getChanges()
            ])
            : response()->json(['message' => "Division `$request->id` failed to update"], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return Division::query()->findOrFail($request->id)->delete()
            ? response()->json(['message' => "Category `$request->id` deleted successfully"])
            : response()->json(['message' => "Category `$request->id` failed to delete"], 500);
    }
}
