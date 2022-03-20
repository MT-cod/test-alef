<?php

namespace App\Services;

abstract class Service
{
    /**
     * Шаблон вывода success
     *
     * @param string $text
     * @return array
     */
    public function successResp(string $text): array
    {
        return [['success' => $text], 200];
    }

    /**
     * Шаблон вывода errors
     *
     * @param string $text
     * @return array
     */
    public function errorsResp(string $text): array
    {
        return [['errors' => $text], 400];
    }
}
