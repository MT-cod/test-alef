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
}
