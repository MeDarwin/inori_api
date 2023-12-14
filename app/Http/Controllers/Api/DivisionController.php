<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Division\DivisionRequest;
use App\Models\Division;
use App\Models\UserDivision;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function __construct()
    {
        if (auth()->user()->role !== 'admin')
            $this->middleware(['is.club.leader'])->only(['addMember', 'removeMember']);
    }
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

    public function addMember(Request $request)
    {
        $validated = $request->validate([
            'user_username' => ['required', 'string', 'exists:user,username'],
        ]);
        // Validate is division exists
        Division::query()->findOrFail($request->id);

        // Prevent duplication
        $isExist = UserDivision::query()
            ->where('division_name', $request->id)
            ->where('user_username', $validated['user_username'])
            ->count('id');
        if ($isExist) {
            return response()->json(['message' => $validated['user_username'] . "` already in this division"], 403);
        }

        // Perform add member and save
        return UserDivision::query()->create(array_merge($validated, ['division_name' => $request->id]))->save()
            ? response()->json(['message' => $validated['user_username'] . " added to division successfully"])
            : response()->json(['message' => $validated['user_username'] . " failed to add to division"], 500);
    }
    public function removeMember(Request $request)
    {
        //Validate is user exists
        $validated = $request->validate([
            'user_username' => ['required', 'string', 'exists:user,username'],
        ]);
        // Validate is division exists
        Division::query()->findOrFail($request->id);
        $userDivision = UserDivision::query()
            ->where('division_name', $request->id)
            ->where('user_username', $validated['user_username']);
        $userDivision->firstOrFail();
        
        // Perform remove member and save
        return
            $userDivision->delete()
            ? response()->json(['message' => $validated['user_username'] . " removed from division successfully"])
            : response()->json(['message' => $validated['user_username'] . " failed to be removed from division"], 500);
    }
}
