<?php

namespace Database\Seeders;

use App\Models\Lecture;
use App\Models\Student;
use App\Models\StudyClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        Student::factory(100)->create();
        StudyClass::factory(10)->create();
        Lecture::factory(20)->create();

        //Сгенерим учебные планы
        foreach (StudyClass::all() as $class) {
            for ($sequence = 1; $sequence < 7; $sequence++) {
                foreach (Lecture::all() as $lecture) {
                    if (!$class->isLectureAlreadyInCurrentStudyClass($lecture->id)
                        && !$lecture->isLectureAlreadyInCurrentSequence($sequence)) {
                        $class->lectures()->attach($lecture->id, ['sequence' => $sequence]);
                        print_r('class--' . $class->id . '-lectid-' . $lecture->id . '-seq-' . $sequence . "\n");
                        break;
                    }
                }
            }
        }
    }
}
