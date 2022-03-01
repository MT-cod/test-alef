<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Lecture extends Model
{
    use HasFactory;

    protected $fillable = ['theme', 'description', 'updated_at'];

    public function studyClasses(): BelongsToMany
    {
        return $this->belongsToMany(
            StudyClass::class,
            'study_classes_lectures',
            'lecture_id',
            'study_class_id'
        )->withPivot('sequence');
    }

    public function getLectureData(): array
    {
        $data['theme'] = $this->theme;
        $data['description'] = $this->description;
        $data['studyClasses'] = $this->studyClasses()->with('students')->get()->toArray();
        return $data;
    }

    public function isLectureAlreadyHasCurrentSequence(int $sequence, int $excludedStudyClassId = 0): bool
    {
        $check = DB::table('study_classes_lectures')
            ->where('lecture_id', $this->id)
            ->where('study_class_id', '<>', $excludedStudyClassId)
            ->where('sequence', $sequence)
            ->first();
        if ($check) {
            return true;
        }
        return false;
    }
}
