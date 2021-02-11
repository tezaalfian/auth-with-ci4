<?php

namespace App\Controllers;

class Profil extends BaseController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
    }
    public function index()
    {
        $data['user'] = $this->userModel->getUser(session()->get("id_user"));
        return view('admin/profil/index', $data);
    }

    // public function edit()
    // {
    //     $data['user'] = $this->userModel->getUser(session()->get("id_user"));
    //     return view('admin/profil/edit', $data);
    // }

    public function changePassword()
    {
        return view('admin/profil/change_password');
    }

    public function setPassword()
    {
        if ($this->request->getPost()) {
            // dd($this->request->getPost());
            $post = $this->request->getPost();
            $user = $this->userModel->getUser(session()->get("id_user"));
            if (!password_verify($post['pass_old'], $user['password'])) {
                session()->setFlashdata('error', "Password lama salah!");
                return redirect()->to('/profil/changePassword');
            }
            if (strlen($post['pass_new']) < 8) {
                session()->setFlashdata('error', "Minimal 8 karakter");
                return redirect()->to('/profil/changePassword');
            }
            if ($post['pass_new'] !== $post['pass_confirm']) {
                session()->setFlashdata('error', "Password baru tidak sesuai!");
                return redirect()->to('/profil/changePassword');
            }
            if ($post['pass_new'] === $post['pass_old']) {
                session()->setFlashdata('error', "Password baru sama seperti password lama!");
                return redirect()->to('/profil/changePassword');
            }
            try {
                $this->userModel->save(['id' => $user['id'], 'password' => password_hash($post['pass_new'], PASSWORD_DEFAULT)]);
                session()->setFlashdata('success', "Password berhasil diubah!");
                return redirect()->to('/profil/changePassword');
            } catch (\Throwable $th) {
                session()->setFlashdata('error', $th->getMessage());
                return redirect()->to('/profil/changePassword');
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}
