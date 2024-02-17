<?php

declare(strict_types=1);

namespace Services\Validators;

interface ValidatableInterface 
{   
    public function validate(): bool;
}