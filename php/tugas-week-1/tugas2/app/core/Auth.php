<?php

namespace App\Core;

use App\Model\User;

class Auth
{
    private ?User $userModel = null;

    public const COOKIE_NAME = "MY-SNIPPET";

    public function __construct()
    {
        $this->userModel = new User;
    }

    public function user(): User | bool
    {

        $email = base64_decode($_COOKIE[self::COOKIE_NAME] ?? "");

        $userData = $this->userModel->load([
            'where' => [
                'email' => $email
            ]
        ]);

        if (!$userData) {
            return false;
        }

        $user = new User();
        $user->id = $userData['id'];
        $user->email = $userData['email'];
        $user->fullname = $userData['fullname'];
        $user->password = $userData['password'];

        return $user;
    }

    public function regenerate($user)
    {
        setcookie(self::COOKIE_NAME, base64_encode($user['email']), time() + (86400 * 1), "/");
    }

    public function destroy()
    {
        setcookie(self::COOKIE_NAME, "", -1, "/");
    }
}
