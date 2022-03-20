<?php

namespace App\Services;

use App\Models\Lecture;
use App\Models\StudyClass;
use Illuminate\Database\Eloquent\Builder;

class StudyClassService extends Service
{
    public function store(array $data): array
    {
        try {
            StudyClass::create($data);
            return $this->successResp('Класс успешно создан.');
        } catch (\Throwable $e) {
            return $this->errorsResp('Не удалось создать класс.');
        }
    }

    public function update(array $data, StudyClass $studyClass): array
    {
        try {
            $studyClass->update($data);
            return $this->successResp('Класс успешно обновлён.');
        } catch (\Throwable $e) {
            return $this->errorsResp('Не удалось обновить класс.');
        }
    }

    public function destroy(StudyClass $studyClass): array
    {
        try {
            $studyClass->students()->update(['study_class_id' => 0]);
            $studyClass->delete();
            return $this->successResp('Класс успешно удалён.');
        } catch (\Throwable $e) {
            return $this->errorsResp('Не удалось удалить класс.');
        }
    }

    public function isLectureAlreadyHasCurrentSequence(int $lecId, int $sequence, int $excludedStudyClassId = 0): bool
    {
        return (bool) Lecture::findOrFail($lecId)
            ->whereHas('studyClasses', function (Builder $query) use ($lecId, $sequence, $excludedStudyClassId) {
            $query->where('lecture_id', $lecId);
            $query->where('study_class_id', '<>', $excludedStudyClassId);
            $query->where('sequence', $sequence);
        })->get('id')->toArray();
    }

    public function getPlan(StudyClass $studyClass): array
    {
        $prep = $studyClass->lectures()->orderBy('sequence')->get()->toArray();
        return array_map(static fn ($lec) => ['sequence' => $lec['pivot']['sequence'], 'theme' => $lec['theme']], $prep);
    }

    public function setPlan(StudyClass $studyClass, array $data): array
    {
        try {
            foreach ($data as $lecId => $seq) {
                if ($this->isLectureAlreadyHasCurrentSequence($lecId, $seq['sequence'], $studyClass->id)) {
                    return $this->errorsResp('Лекция уже имеет такую позицию в учебном плане.');
                }
            }
            $studyClass->lectures()->sync($data);
            return $this->successResp('Учебный план успешно утверждён.');
        } catch (\Throwable $a) {
            return $this->errorsResp('Не удалось утвердить учебный план.');
        }
    }
}
