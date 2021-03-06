<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'study_class_id', 'updated_at'];

    public function getStudentData(): array
    {
        $data['name'] = $this->name;
        $data['email'] = $this->email;
        $data['lectures'] = ($this->study_class_id) ? StudyClass::find($this->study_class_id)->lectures()->get() : [];
        return $data;
    }
}
