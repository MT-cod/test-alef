<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    /*public function isLectureInStudyClasses(int $id): bool
    {
        if (empty($this->studyClasses()->where('id', $id)->first())) {
            return false;
        }
        return true;
    }*/

    public function isLectureAlreadyInCurrentSequence(int $sequence): bool
    {
        $check = DB::table('study_classes_lectures')
            ->where('lecture_id', $this->id)
            ->where('sequence', $sequence)
            ->first();
        if ($check) {
            return true;
        }
        return false;
    }
}
