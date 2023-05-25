<?php

namespace App\Controller;

use App\Model\SnippetType;

class SnippetTypeController extends Controller
{
    private SnippetType $snippetTypeModel;

    public function __construct()
    {
        $this->snippetTypeModel = new SnippetType;
    }

    public function index()
    {
        $data = $this->snippetTypeModel->loadList();
        return response()->apiResponse("Snippet Type berhasil diload", 200, "success", $data);
    }

    public function store()
    {
        $post = $this->getPayload();

        $exist = $this->snippetTypeModel->load([
            'where' => [
                'snippet_type_name' => $post['snippet_type_name']
            ]
        ]);

        if ($exist) {
            return response()->apiResponse("Snippet Type {$post['snippet_type_name']} sudah ada", 400, "error", []);
        }

        $this->snippetTypeModel->insert([
            'snippet_type_name' => $post['snippet_type_name']
        ]);

        return response()->apiResponse("Snippet Type berhasil dibuat", 201, "success", $post);
    }
}
