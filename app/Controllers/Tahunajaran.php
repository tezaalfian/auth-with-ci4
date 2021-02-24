<?php

namespace App\Controllers;

class Tahunajaran extends BaseController
{
    private $TahunModel;

    public function __construct()
    {
        $this->TahunModel = new \App\Models\TahunModel();
    }

    public function index()
    {
        $data['tahun'] = $this->TahunModel->orderBy("tingkat", "asc")->find();
        // dd($data['tahun']);
        return view('admin/tahun_ajaran/index', $data);
    }

    public function setAktif()
    {
        if ($this->request->getPost()) {
            try {
                $this->TahunModel->setAktif($this->request->getPost('ta_id'));
                session()->setFlashdata('success', 'Data berhasil diubah!');
            } catch (\Throwable $th) {
                session()->setFlashdata('error', $th->getMessage());
            }
            return redirect()->to('/tahunajaran');
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    // public function save($id = "")
    // {
    //     $input = $this->request->getVar();
    //     if ($input) {
    //         $menu = $this->menuModel->orderBy('num_order', 'desc')->first();
    //         $data = [
    //             'menu' => $input['menu'],
    //             'nama_menu' => empty($input['nama_menu']) ? null : $input['nama_menu'],
    //             'url' => empty($input['url']) ? null : $input['url'],
    //             'icon' => $input['icon'],
    //             'num_order' => (int)$menu['num_order'] + 1
    //         ];
    //         if (!empty($id)) $data['id'] = $id;
    //         $this->menuModel->save($data);
    //         session()->setFlashdata("success", "Data berhasil disimpan!");
    //         return redirect()->to("/menu");
    //     } else {
    //         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    //     }
    // }
}
