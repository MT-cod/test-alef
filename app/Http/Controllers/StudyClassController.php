<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudyClassRequest;
use App\Http\Requests\StorUpdPlanForStudyClassRequest;
use App\Http\Requests\UpdateStudyClassRequest;
use App\Models\StudyClass;
use App\Services\StudyClassService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class StudyClassController extends Controller
{
    protected StudyClassService $service;

    public function __construct(StudyClassService $service)
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
        [$result, $status] = $this->service->store($request->validated());
        return Response::json($result, $status);
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
        [$result, $status] = $this->service->update($request->validated(), $studyClass);
        return Response::json($result, $status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param StudyClass $studyClass
     * @return JsonResponse
     */
    public function destroy(StudyClass $studyClass): JsonResponse
    {
        [$result, $status] = $this->service->destroy($studyClass);
        return Response::json($result, $status);
    }

    /**
     * Получить учебный план (список лекций) для конкретного класса.
     *
     * @param StudyClass $studyClass
     * @return JsonResponse
     */
    public function getPlan(StudyClass $studyClass): JsonResponse
    {
        return Response::json($this->service->getPlan($studyClass));
    }

    /**
     * Создать/обновить учебный план (очередность и состав лекций) для конкретного класса.
     * (ожидается массив типа: plan[id лекции => порядковый номер лекции в плане]).
     *
     * @param StorUpdPlanForStudyClassRequest $request
     * @param StudyClass $studyClass
     * @return JsonResponse
     */
    public function setPlan(StorUpdPlanForStudyClassRequest $request, StudyClass $studyClass): JsonResponse
    {
        [$result, $status] = $this->service->setPlan($studyClass, $request->validated('plan'));
        return Response::json($result, $status);
    }
}
