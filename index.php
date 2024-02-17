<?php 

use Services\Auth\Auth;

$auth = new Auth('user1', 'password1');

//trying to log in
if ($auth->login()) {
    echo "Logged in successfully";
}
else {
    echo "Log in failed";
}

//trying to register
if ($user = $auth->register()) {
    echo "New user created: ";
    print_r($user);
}