<?php

namespace App\Services;

use App\Models\Lecture;

class LectureService extends Service
{
    public function store(array $data): array
    {
        try {
            Lecture::create($data);
            return $this->successResp('Лекция успешно создана.');
        } catch (\Throwable $e) {
            return $this->errorsResp('Не удалось создать лекцию.');
        }
    }

    public function update(array $data, Lecture $lecture): array
    {
        try {
            $lecture->update($data);
            return $this->successResp('Лекция успешно обновлена.');
        } catch (\Throwable $e) {
            return $this->errorsResp('Не удалось обновить лекцию.');
        }
    }

    public function destroy(Lecture $lecture): array
    {
        try {
            $lecture->delete();
            return $this->successResp('Лекция успешно удалена.');
        } catch (\Throwable $e) {
            return $this->errorsResp('Не удалось удалить лекцию.');
        }
    }
}
