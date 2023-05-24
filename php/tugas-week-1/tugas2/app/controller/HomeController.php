<?php

namespace App\Controller;

use App\Model\SnippetType;

class HomeController
{
    public function index()
    {
        $snippetTypes = new SnippetType();
        $dataSnippetTypes = $snippetTypes->loadList();

        return view('home/index', [
            'snippet_types' => $dataSnippetTypes
        ]);
    }
}
