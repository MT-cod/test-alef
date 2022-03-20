<?php

namespace Database\Seeders;

use App\Models\Lecture;
use App\Models\Student;
use App\Models\StudyClass;
use App\Services\StudyClassService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected StudyClassService $stClassService;

    public function __construct(StudyClassService $service)
    {
        $this->stClassService = $service;
    }

    /**
     * Seed the application's database.
     *
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        Student::factory(100)->create();
        StudyClass::factory(10)->create();
        Lecture::factory(20)->create();

        //Сгенерим учебные планы
        foreach (StudyClass::all() as $class) {
            for ($sequence = 1; $sequence < 7; $sequence++) {
                foreach (Lecture::all() as $lecture) {
                    if (!$this->isLectureAlreadyInStudyClass($lecture, $class->id)
                        && !$this->stClassService->isLectureAlreadyHasCurrentSequence($lecture->id, $sequence, $class->id)) {
                        $class->lectures()->attach($lecture->id, ['sequence' => $sequence]);
                        break;
                    }
                }
            }
        }
    }

    public function isLectureAlreadyInStudyClass(Lecture $lecture, int $classId): bool
    {
        return (bool) $lecture->whereHas('studyClasses', function (Builder $query) use ($lecture, $classId) {
                $query->where('study_class_id', $classId);
                $query->where('lecture_id', $lecture->id);
            })->get('id')->toArray();
    }
}
