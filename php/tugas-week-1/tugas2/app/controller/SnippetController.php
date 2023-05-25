<?php

namespace App\Controller;

use App\Core\Auth;
use App\Core\Request;
use App\Model\Snippet;

class SnippetController extends Controller
{
    public Snippet $snippetModel;

    public Auth $authService;

    public function __construct()
    {
        $this->snippetModel = new Snippet;
        $this->authService = new Auth;
    }

    public function index()
    {
        $get = $this->getQueryParam();

        $params = [];

        if (!empty($get)) {

            if (array_key_exists('keyword', $get)) {
                $params['whereLike']['title'] = $get['keyword'];
            }

            if (array_key_exists('snippet_type_id', $get)) {
                $params['where']['snippet_type_id'] = $get['snippet_type_id'];
            }

            if (array_key_exists('snippet_id', $get)) {
                $params['where']['snippet_id'] = $get['snippet_id'];
            }
        }

        $params['where']['created_by'] = $this->authService->user()->id;

        $response = $this->snippetModel->loadList($params);

        if (!$response) {
            return response()->apiResponse("Snippet tidak ditemukan", 404, "error", []);
        }

        return response()->apiResponse("Snippet ditemukan", 200, "success", $response);
    }

    public function store()
    {
        $payload = $this->getPayload();
        $payload['created_by'] = $this->authService->user()->id;

        $response = $this->snippetModel->insert($payload);

        if (!$response) {
            return response()->apiResponse("Snippet gagal disimpan", 400, "error", []);
        }

        return response()->apiResponse("Snippet berhasil disimpan", 201, "success", $payload);
    }

    public function show(string $id)
    {
        $response = $this->snippetModel->load([
            'where' => [
                'snippet_id' => $id
            ]
        ]);

        if (!$response) {
            return response()->apiResponse("Snippet tidak ditemukan", 404, "error", []);
        }

        return response()->apiResponse("Snippet ditemukan", 200, "success", $response);
    }

    public function update()
    {
        $payload = $this->getPayload();
        $payload['created_by'] = $this->authService->user()->id;
        $response = $this->snippetModel->update($payload);

        if (!$response) {
            return response()->apiResponse("Snippet gagal diupdate", 404, "error", []);
        }

        return response()->apiResponse("Snippet berhasil diupdate", 200, "success", $payload);
    }

    public function destroy(string $id)
    {
        $response = $this->snippetModel->delete($id);

        if (!$response) {
            return response()->apiResponse("Snippet gagal dihapus ", 404, "error", []);
        }

        return response()->apiResponse("Snippet berhasil dihapus", 200, "success", []);
    }
}
