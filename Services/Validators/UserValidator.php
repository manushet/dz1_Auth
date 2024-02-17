<?php

declare(strict_types=1);

namespace Services\Validators;

use \Exception;
use Entities\User;
use Services\Validators\ValidatableInterface;

class UserValidator implements ValidatableInterface 
{
    private const PASSWORD_MINIMUM_LENGTH = 6;

    private const LOGIN_MINIMUM_LENGTH = 3;    
    
    private const ERRORS = [
        "login_empty" => "Логин не может быть пустым",
        "login_too_short" => "Логин должен быть не менее {self::LOGIN_MINIMUM_LENGTH} символов",
        "login_incorrect_format" => "Логин может содержать только буквы и цифры",
        "password_empty" => "Пароль не может быть пустым",
        "password_too_short" => "Пароль должен быть не менее {self::PASSWORD_MINIMUM_LENGTH} символов",
        "password_incorrect_format" => "Пароль должен содержать как минимум 1 заглавную букву и 1 специальный символ",
    ];
   
    public function __construct(private User $user) 
    {
        $this->validate();
    }

    public function validate(): bool {
        $error_msgs = [];

        if (empty($this->user->getLogin())) {
            $error_msgs[] = self::ERRORS['login_empty'];
        }

        if (strlen($this->user->getLogin()) < self::LOGIN_MINIMUM_LENGTH) {
            $error_msgs[] = self::ERRORS['login_too_short'];
        }

        if (!preg_match('/^[a-zA-Z0-9]+$/', $this->user->getLogin())) {
            $error_msgs[] = self::ERRORS['login_incorrect_format'];
        }

        if (empty($this->user->getPassword())) {
            $error_msgs[] = self::ERRORS['password_empty'];
        }

        if (strlen($this->user->getPassword()) < self::PASSWORD_MINIMUM_LENGTH) {
            $error_msgs[] = self::ERRORS['password_too_short'];
        }

        if (!empty($error_msgs)) {
            throw new Exception(implode(". ", $error_msgs));
        }

        return true;
    }
}