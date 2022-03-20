<?php

namespace App\Services;

use App\Models\Student;

class StudentService extends Service
{
    public function store(array $data): array
    {
        try {
            Student::create($data);
            return $this->successResp('Студент успешно создан.');
        } catch (\Throwable $e) {
            return $this->errorsResp('Не удалось создать студента.');
        }
    }

    public function update(array $data, Student $student): array
    {
        try {
            $student->update($data);
            return $this->successResp('Студент успешно обновлён.');
        } catch (\Throwable $e) {
            return $this->errorsResp('Не удалось обновить студента.');
        }
    }

    public function destroy(Student $student): array
    {
        try {
            $student->delete();
            return $this->successResp('Студент успешно удалён.');
        } catch (\Throwable $e) {
            return $this->errorsResp('Не удалось удалить студента.');
        }
    }
}
