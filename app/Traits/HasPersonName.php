<?php

namespace App\Traits;

trait HasPersonName
{
    public function getFullNameAttribute(): ?string
    {
        $name = trim(($this->first_name ?? '').' '.($this->last_name ?? ''));

        return $name !== '' ? $name : null;
    }
}
