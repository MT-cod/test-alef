<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return Response::json(Student::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreStudentRequest $request
     * @return JsonResponse
     */
    public function store(StoreStudentRequest $request): JsonResponse
    {
        try {
            Student::create($request->validated());
            return Response::json(['success' => 'Студент успешно создан.']);
        } catch (\Throwable $e) {
            return Response::json(['errors' => 'Не удалось создать студента.'], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Student $student
     * @return JsonResponse
     */
    public function show(Student $student): JsonResponse
    {
        return Response::json($student->getStudentData());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateStudentRequest $request
     * @param Student $student
     * @return JsonResponse
     */
    public function update(UpdateStudentRequest $request, Student $student): JsonResponse
    {
        try {
            $student->update($request->validated());
            return Response::json(['success' => 'Студент успешно обновлён.']);
        } catch (\Throwable $e) {
            return Response::json(['errors' => 'Не удалось обновить студента.'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Student $student
     * @return JsonResponse
     */
    public function destroy(Student $student): JsonResponse
    {
        try {
            $student->delete();
            return Response::json(['success' => 'Студент успешно удалён.']);
        } catch (\Throwable $e) {
            return Response::json(['errors' => 'Не удалось удалить студента.'], 400);
        }
    }
}
