<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class StudyClass extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'updated_at'];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'students', 'study_class_id', 'id');
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
}
