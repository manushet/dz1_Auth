<?php

declare(strict_types=1);

namespace Repositories;

use \Exception;
use Repositories\CredentialsRepositoryInterface;

class CredentialsFileRepository implements CredentialsRepositoryInterface
{    
    private const SOURCE_FILE = "/data/id-login-pass.txt";
    
    public function __construct() 
    {
        if (!file_exists(self::SOURCE_FILE)) { 
            throw new Exception("Ошибка открытия файла.");   
        }      
    }
    
    public function getCredentials(): array
    {
        if (!$file_handle = fopen(self::SOURCE_FILE, "r")) { 
            throw new Exception("Ошибка открытия файла.");   
        }  

        $users = [];
        
        while(!feof($file_handle)) {
            $user_line = fgets($file_handle);
            
            if (!empty($user_line)) {
                $account_data = explode(";", $user_line);
                
                if (!empty($account_data[0]) && !empty($account_data[1])) {
                    $users[] = (object)array(
                        "login" => trim($account_data[0]),
                        "password" => trim($account_data[1]),
                    );
                }
            }
        }

        fclose($file_handle);

        return $users;
    }

    public function saveCredentials(string $login, string $password): bool
    {
        try {
            if (!$file_handle = fopen(self::SOURCE_FILE, "a")) { 
                throw new Exception("Ошибка открытия файла.");   
            }  
        
            $new_credentials = "$login; $password\n\r";
            
            fwrite($file_handle, $new_credentials);

            fclose($file_handle);

            return true;
        }
        catch (Exception $e) {
            return false;
        }      
    }
}