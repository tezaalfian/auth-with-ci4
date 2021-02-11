<?php

namespace App\Controllers;

class Auth extends BaseController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
    }

    public function login()
    {
        if (session()->get("isloggedin")) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function cekLogin()
    {
        if (!$this->request->getPost()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $password = $this->request->getPost("password");
        $username = $this->request->getPost("username");
        $user = $this->userModel->where(['username' => $username])->first();
        if (!is_null($user)) {
            // d(password_hash($password, PASSWORD_DEFAULT));
            // d($user['password']);
            // dd(password_verify($password, $user['password']));
            if (password_verify($password, $user['password'])) {
                $user = $this->userModel->getUser($user['id']);
                if (count($user['role']) > 0) {
                    $data = [
                        'id_user' => $user['id'],
                        'isloggedin' => true,
                        'role_id' => $user['role'][0]
                    ];
                    session()->set($data);
                    session()->setFlashdata('success', 'Anda Berhasil Login!');
                    if (!is_null(session()->get("prevUrl"))) {
                        if (session()->get("prevUrl") != "logout" && session()->get("prevUrl") != "") {
                            return redirect()->to(base_url(session()->get("prevUrl")));
                        }
                    }
                    return redirect()->to('/dashboard');
                } else {
                    session()->setFlashdata('error', 'Akun anda tidak terdaftar!');
                    return redirect()->to('/login');
                }
            } else {
                session()->setFlashdata('error', 'Password anda salah!');
                return redirect()->to('/login')->withInput();
            }
        } else {
            session()->setFlashdata('error', 'Akun anda tidak terdaftar!');
            return redirect()->to('/login');
        }
    }

    public function set_role($id)
    {
        $cekRole = $this->userModel->cekRole(session()->get("id_user"), $id);
        if (!is_null($cekRole)) {
            session()->set('role_id', $id);
            return redirect()->to('/dashboard');
        } else {
            session()->setFlashdata('error', 'Not Allowed!');
            return redirect()->to('/dashboard');
        }
    }

    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'Anda berhasil logout!');
        return redirect()->to('/login')->withInput();
    }
}
