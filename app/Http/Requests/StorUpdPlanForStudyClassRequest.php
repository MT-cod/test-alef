<?php

namespace App\Http\Requests;

use App\Models\Lecture;
use Illuminate\Foundation\Http\FormRequest;

class StorUpdPlanForStudyClassRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            '*' => [
                function ($attr, $val, $fail): void {
                    if (Lecture::findOrFail($val['id'])->isLectureAlreadyHasCurrentSequence(
                        $val['sequence'],
                        request()->study_class->id
                    )) {
                        $fail('Лекция уже имеет такую позицию в учебном плане.');
                    }

                    $checkDub = 0;
                    foreach (request()->toArray() as $row) {
                        if ($row['id'] === $val['id']) {
                            $checkDub ++;
                            if ($checkDub > 1) {
                                $fail('В переданном учебном плане имеются дубликаты лекций.');
                            }
                        }
                    }
                }
            ]
        ];
    }

    /**
     * Остановить валидацию после первой неуспешной проверки.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;
}
