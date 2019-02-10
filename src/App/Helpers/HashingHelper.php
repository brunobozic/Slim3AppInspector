<?php

namespace App\Helpers;

class HashingHelper extends BaseHelper
{
    public function password($password)
    {
        return password_hash(
            $password,
            $this->settings['hash']['algo'],
            ['cost' => $this->settings['hash']['cost']]
        );
    }

    public function passwordCheck($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public function hash($input)
    {
        return hash('sha256', $input);
    }

    public function hashCheck($known, $user)
    {
        return hash_equals($known, $user);
    }

}