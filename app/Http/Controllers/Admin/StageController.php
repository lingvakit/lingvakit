<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LMS\Course;
use App\Models\LMS\Stage;
use Illuminate\Http\Request;

class StageController extends Controller
{

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        Stage::add($request->all(), $course);

        return back();
    }

    public function update(Request $request, Course $course, Stage $stage)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $stage->update($validated);

        return back();
    }

    public function destroy(Course $course, Stage $stage)
    {
        $stage->delete();
        return back();
    }
}
