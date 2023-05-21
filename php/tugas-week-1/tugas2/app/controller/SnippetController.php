<?php

namespace App\Controller;

class SnippetController extends Controller
{
    public function index()
    {
        $get = $this->getQueryParam();
    }
}
