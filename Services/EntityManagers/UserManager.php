<?php

declare(strict_types=1);

namespace Services\EntityManagers;

use Entities\User;
use Repositories\CredentialsFileRepository;

class UserManager 
{
    private CredentialsFileRepository $credentialRepository;
    
    public function __construct() 
    {
        $this->credentialRepository = new CredentialsFileRepository();
    }

    public function isUserExists($login): bool
    {
        $credentials = $this->credentialRepository->getCredentials();
        
        if (count($credentials) > 0) {    
            foreach($credentials as $credential) {
                if ($credential->login === $login) {
                    return true;
                }
            }    
        }  

        return false;
    }

    public function isValidUserCredentials(string $login, string $password): bool
    {
        $credentials = $this->credentialRepository->getCredentials();

        if (count($credentials) > 0) {
            foreach($credentials as $credential) {
                if (($credential->login === $login) && ($credential->password === User::securePassword($password))) {
                    return true;
                }
            }            
        }

        return false;
    }

    public function createUser(string $login, string $password): User|bool {
        
        $new_user = new User();
        $new_user->setLogin($login);
        $new_user->setPassword($password);
        
        if ($new_user->is_valid()) {
            $this->credentialRepository->saveCredentials($new_user->getLogin(), $new_user->getPassword());

            return $new_user;
        }

        return false;
    }

}