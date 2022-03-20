<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLectureRequest;
use App\Http\Requests\UpdateLectureRequest;
use App\Models\Lecture;
use App\Services\LectureService;
use Illuminate\Http\JsonResponse;
use \Illuminate\Support\Facades\Response;

class LectureController extends Controller
{
    protected LectureService $service;

    public function __construct(LectureService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return Response::json(Lecture::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLectureRequest $request
     * @return JsonResponse
     */
    public function store(StoreLectureRequest $request): JsonResponse
    {
        [$result, $status] = $this->service->store($request->validated());
        return Response::json($result, $status);
    }

    /**
     * Display the specified resource.
     *
     * @param Lecture $lecture
     * @return JsonResponse
     */
    public function show(Lecture $lecture): JsonResponse
    {
        return Response::json($lecture->getLectureData());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLectureRequest $request
     * @param Lecture $lecture
     * @return JsonResponse
     */
    public function update(UpdateLectureRequest $request, Lecture $lecture): JsonResponse
    {
        [$result, $status] = $this->service->update($request->validated(), $lecture);
        return Response::json($result, $status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Lecture $lecture
     * @return JsonResponse
     */
    public function destroy(Lecture $lecture): JsonResponse
    {
        [$result, $status] = $this->service->destroy($lecture);
        return Response::json($result, $status);
    }
}
