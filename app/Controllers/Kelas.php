<?php

namespace App\Controllers;

class Kelas extends BaseController
{
    private $KelasModel;

    public function __construct()
    {
        $this->KelasModel = new \App\Models\KelasModel();
    }

    public function index()
    {
        $data['kelas'] = $this->KelasModel->orderBy("tingkat", "asc")->find();
        return view('admin/kelas/index', $data);
    }

    public function save($id = null)
    {
        $input = $this->request->getPost();
        if ($input) {
            $data = [
                'nama_kelas' => $input['nama_kelas'],
                'tingkat' => $input['tingkat']
            ];
            if (!empty($id)) $data['id'] = $id;
            // dd($data);
            $this->KelasModel->save($data);
            session()->setFlashdata("success", "Data berhasil disimpan!");
            return redirect()->to("/kelas");
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function delete($id)
    {
        if ($this->request->getPost()) {
            $cek = $this->KelasModel->isUsed($id);
            if (is_null($cek)) {
                $this->KelasModel->delete($id);
                session()->setFlashdata("success", "Data berhasil dihapus!");
            } else {
                session()->setFlashdata("error", "Tidak bisa dihapus");
            }
            return redirect()->to('/kelas');
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}
