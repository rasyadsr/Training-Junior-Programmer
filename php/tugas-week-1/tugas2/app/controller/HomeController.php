<?php

namespace App\Controller;

use App\Core\Auth;
use App\Model\SnippetType;

class HomeController
{
    public function index()
    {
        $authService = new Auth();

        return view('home/index', [
            'user'          => $authService->user(),
            'title'         => "Home",
        ]);
    }
}
