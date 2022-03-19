<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class StudyClass extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'updated_at'];

    public function students(): hasMany
    {
        return $this->hasMany(Student::class, 'study_class_id', 'id');
    }

    public function lectures(): BelongsToMany
    {
        return $this->belongsToMany(
            Lecture::class,
            'study_classes_lectures',
            'study_class_id',
            'lecture_id'
        )->withPivot('sequence');
    }

    public function getStudyClassData(): array
    {
        $data['name'] = $this->name;
        $data['students'] = $this->students()->get();
        return $data;
    }

    public function destroyWithoutStudents(): void
    {
        $this->students()->update(['study_class_id' => 0]);
        $this->delete();
    }

    public function isLectureAlreadyInCurrentStudyClass(int $lecture_id): bool
    {
        $check = DB::table('study_classes_lectures')
            ->where('study_class_id', $this->id)
            ->where('lecture_id', $lecture_id)
            ->first();
        if ($check) {
            return true;
        }
        return false;
    }

    public function getPlan(): array
    {
        $prep = $this->lectures()->orderBy('sequence')->get()->toArray();
        return array_map(static fn ($lec) => ['sequence' => $lec['pivot']['sequence'], 'theme' => $lec['theme']], $prep);
    }

    public function setPlan(array $data): array
    {
        try {
            foreach ($data as $lecId => $seq) {
                if (Lecture::findOrFail($lecId)->isLectureAlreadyHasCurrentSequence($seq['sequence'], $this->id)) {
                    return [['errors' => 'Лекция уже имеет такую позицию в учебном плане.'], 400];
                }
            }
            $this->lectures()->sync($data);
            return [['success' => 'Учебный план успешно утверждён.'], 200];
        } catch (\Throwable $a) {
            return [['errors' => 'Не удалось утвердить учебный план.'], 400];
        }

    }
}
