<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Domain\Course\Handlers\CourseHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class CourseController extends Controller
{
    public function __construct(
        private readonly CourseHandler $courseHandler
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $perPage = (int)$request->query('per_page', 5);
        $sortBy = $request->query('sort_by', 'title');
        $orderBy = $request->query('order_by', 'asc');
        $page = (int)$request->query('page', 1);
        $courses = $this->courseHandler->getAll($sortBy, $orderBy, $perPage, $page);

        return response()->json($courses);
    }

    public function show(int $id): JsonResponse
    {
        $courseData = $this->courseHandler->getById($id);

        return response()->json($courseData);
    }
}

