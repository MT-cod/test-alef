<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLectureRequest;
use App\Http\Requests\UpdateLectureRequest;
use App\Models\Lecture;
use Illuminate\Http\JsonResponse;
use \Illuminate\Support\Facades\Response;

class LecturesController extends Controller
{
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
        try {
            Lecture::create($request->validated());
            return Response::json(['success' => 'Лекция успешно создана.']);
        } catch (\Throwable $e) {
            return Response::json(['errors' => 'Не удалось создать лекцию.'], 400);
        }
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
        try {
            $lecture->update($request->validated());
            return Response::json(['success' => 'Лекция успешно обновлена.']);
        } catch (\Throwable $e) {
            return Response::json(['errors' => 'Не удалось обновить лекцию.'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Lecture $lecture
     * @return JsonResponse
     */
    public function destroy(Lecture $lecture): JsonResponse
    {
        try {
            $lecture->studyClasses()->detach();
            $lecture->delete();
            return Response::json(['success' => 'Лекция успешно удалена.']);
        } catch (\Throwable $e) {
            return Response::json(['errors' => 'Не удалось удалить лекцию.'], 400);
        }
    }
}
