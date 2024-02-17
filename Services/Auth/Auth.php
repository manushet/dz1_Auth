<?php

declare(strict_types=1);

namespace Services\Auth;

use \Exception;
use Entities\User;
use Services\EntityManagers\UserManager;

class Auth 
{
    private UserManager $userManager;

    public function __construct(private string $login, private string $password)
    {
        $this->userManager = new UserManager();
    }
    
    public function login(): bool
    {  
        if (!$this->userManager->isUserExists($this->login)) {
            throw new Exception("Пользователь с указанным логином не существует.");    
        } 
        
        if (!$this->userManager->isValidUserCredentials($this->login, $this->password)) {
            throw new Exception("Указанный пароль для учетной записи неверный.");    
        }

        return true;
    }

    public function register(): User|bool
    {
        if ($this->userManager->isUserExists($this->login)) {
            throw new Exception("Пользователь с указанным логином уже существует.");    
        }

        return $this->userManager->createUser($this->login, $this->password);
    }
}