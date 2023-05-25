<?php

namespace App\Controller;

use App\Core\Auth;
use App\Model\User;

class AuthController extends Controller
{
    public User $userModel;

    public Auth $authService;

    public function __construct()
    {
        $this->userModel = new User;
        $this->authService = new Auth;
    }

    public function login()
    {
        return view('auth/login', [
            'title' => 'Login'
        ]);
    }

    public function register()
    {
        return view('auth/register', [
            'title' => 'Register'
        ]);
    }

    public function loginStore()
    {
        $post = $this->getPayload();

        $params['where']['email'] = $post['email'];

        $user = $this->userModel->load($params);

        if (!$user || !password_verify($post['password'], $user['password'])) {
            return response()->apiResponse("Email atau Password salah", 400, "error", []);
        }

        // bikin cookie
        $this->authService->regenerate($user);

        unset($user['password']);
        return response()->apiResponse("Login berhasil", 200, "success", $user);
    }


    public function registerStore()
    {
        $post = $this->getPayload();

        if ($post['password'] != $post['password_confirm']) {
            return response()->apiResponse("Password dan password konfirmasi tidak sesuai", 400, "error", []);
        }

        $params['where']['email'] = $post['email'];
        $user = $this->userModel->load($params);
        if ($user) {
            return response()->apiResponse("Email tersebut telah digunakan", 400, "error", []);
        }

        $createdUser = $this->userModel->insert([
            'email' => $post['email'],
            'fullname' => $post['fullname'],
            'password' => password_hash($post['password'], PASSWORD_DEFAULT)
        ]);

        return response()->apiResponse("Registrasi berhasil", 201, "success", $createdUser);
    }

    public function logout()
    {
        $this->authService->destroy();
        return response()->redirect("/login");
    }
}
