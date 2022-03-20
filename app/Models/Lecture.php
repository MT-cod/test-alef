<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
}
