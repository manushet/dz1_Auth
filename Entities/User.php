<?php

declare(strict_types=1);

namespace Entities;
use Services\Validators\UserValidator;

class User 
{
    private string $login;
    
    private string $password;   
    
    public function setLogin(string $login): void 
    {
        $this->login = $login;
    }

    public function getLogin(): string 
    {
        return $this->login;
    }
    
    public function setPassword(string $raw_password): void 
    {
        $this->password = self::securePassword($raw_password);
    }

    public function getPassword(): string 
    {
        return $this->password;
    }

    public static function securePassword(string $password): string 
    {
        return md5($password);
    } 

    public function is_valid(): bool 
    {       
        $userValidator = new UserValidator($this);
        
        return $userValidator->validate();
    }
}