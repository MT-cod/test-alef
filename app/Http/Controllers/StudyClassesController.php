<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudyClassRequest;
use App\Http\Requests\StorUpdPlanForStudyClassRequest;
use App\Http\Requests\UpdateStudyClassRequest;
use App\Models\StudyClass;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class StudyClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return Response::json(StudyClass::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreStudyClassRequest $request
     * @return JsonResponse
     */
    public function store(StoreStudyClassRequest $request): JsonResponse
    {
        try {
            StudyClass::create($request->validated());
            return Response::json(['success' => 'Класс успешно создан.']);
        } catch (\Throwable $e) {
            return Response::json(['errors' => 'Не удалось создать класс.'], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param StudyClass $studyClass
     * @return JsonResponse
     */
    public function show(StudyClass $studyClass): JsonResponse
    {
        return Response::json($studyClass->getStudyClassData());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateStudyClassRequest $request
     * @param StudyClass $studyClass
     * @return JsonResponse
     */
    public function update(UpdateStudyClassRequest $request, StudyClass $studyClass): JsonResponse
    {
        try {
            $studyClass->update($request->validated());
            return Response::json(['success' => 'Класс успешно обновлён.']);
        } catch (\Throwable $e) {
            return Response::json(['errors' => 'Не удалось обновить класс.'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param StudyClass $studyClass
     * @return JsonResponse
     */
    public function destroy(StudyClass $studyClass): JsonResponse
    {
        try {
            $studyClass->destroyWithoutStudents();
            return Response::json(['success' => 'Класс успешно удалён.']);
        } catch (\Throwable $e) {
            return Response::json(['errors' => 'Не удалось удалить класс.'], 400);
        }
    }

    /**
     * получить учебный план (список лекций) для конкретного класса.
     *
     * @param StudyClass $studyClass
     * @return JsonResponse
     */
    public function getPlan(StudyClass $studyClass): JsonResponse
    {
        return Response::json($studyClass->getPlan());
    }

    /**
     * создать/обновить учебный план (очередность и состав лекций) для конкретного класса.
     * (ожидается передача массива с номерами очерёдности [sequence] и id лекций для учебного класса).
     *
     * @param StorUpdPlanForStudyClassRequest $request
     * @param StudyClass $studyClass
     * @return JsonResponse
     */
    public function setPlan(StorUpdPlanForStudyClassRequest $request, StudyClass $studyClass): JsonResponse
    {
        try {
            $studyClass->setPlan($request->validated());
            return Response::json(['success' => 'Учебный план успешно утверждён.']);
        } catch (\Throwable $e) {
            return Response::json(['errors' => 'Не удалось утвердить учебный план.'], 400);
        }
    }
}
