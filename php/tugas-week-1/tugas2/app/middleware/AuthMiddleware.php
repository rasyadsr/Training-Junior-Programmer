<?php

namespace App\Middleware;

use App\Core\Auth;

class AuthMiddleware implements IMiddleware
{
    private Auth $authService;

    public function __construct()
    {
        $this->authService = new Auth;
    }

    public function action()
    {
        $user = $this->authService->user();

        if (!$user) {
            return response()->redirect("/login");
        }
    }
}
