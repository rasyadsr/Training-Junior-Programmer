<?php

namespace App\Controller;

use App\Core\Request;
use App\Model\Snippet;

class SnippetController extends Controller
{
    public Snippet $snippetModel;

    public function __construct()
    {
        $this->snippetModel = new Snippet;
    }

    public function index()
    {
        $data = $this->snippetModel->findAll();
        return respone()->json($data);
    }

    public function create(array $payload)
    {
        $response = $this->snippetModel->insert($payload);

        if (!$response) {
            return respone()->apiResponse("Gagal Menyimpan Snippet", 400, "error", []);
        }

        return respone()->apiResponse("Berhasil Menyimpan Snippet", 201, "success", $payload);
    }

    public function store()
    {
        $payload = $this->getPayload();
        $payload['created_by'] = 1;

        if (!$payload['snippet_id']) {
            $this->create($payload);
        } else {
            $this->update($payload);
        }
    }

    public function show()
    {
    }

    public function update()
    {
    }

    public function destroy()
    {
        # code...
    }
}
