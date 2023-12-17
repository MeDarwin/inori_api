<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VisitorCount;
use Illuminate\Http\Request;

class VisitCountController extends Controller
{
    public function logVisit(Request $request)
    {
        $validated = $request->validate([
            'view_url'  => ['required', 'string', 'max:255'],
            'view_type' => ['required', 'string', 'max:255'],
        ]);
        return VisitorCount::query()->create(array_merge($validated, ['visitor' => auth()->user()->username ?? null]))->save()
            ? response()->json('view is recorded')
            : response()->json('view is failed to record', 500);
    }
    public function getVisitLog(Request $request)
    {
        $visit = VisitorCount::query();
        $all_view_type = $visit->groupBy('view_type')->get('view_type')->pluck('view_type');
        $retVal = [];
        foreach ($all_view_type as $view) {
            $retVal[$view] = VisitorCount::query()->where('view_type', $view)->count();
        }
        return response()->json($retVal);
    }
}
