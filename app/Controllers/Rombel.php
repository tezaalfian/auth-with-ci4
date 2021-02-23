<?php

namespace App\Controllers;

class Rombel extends BaseController
{
    private $RombelModel;
    private $KelasModel;

    public function __construct()
    {
        $this->RombelModel = new \App\Models\RombelModel();
        $this->KelasModel = new \App\Models\KelasModel();
    }

    public function index()
    {
        $data['rombel'] = $this->RombelModel->listRombel();
        $data['kelas'] = $this->KelasModel->orderBy('tingkat', 'asc')->find();
        return view('admin/rombel/index', $data);
    }

    public function aktif()
    {
        $data['rombel'] = $this->RombelModel->rombelAktif();
        // dd($data['rombel']);
        $data['kelas'] = $this->KelasModel->orderBy('tingkat', 'asc')->find();
        return view('admin/rombel/aktif', $data);
    }

    public function save($id = null)
    {
        $input = $this->request->getPost();
        if ($input) {
            $data = [
                'nama_rombel' => $input['nama_rombel'],
                'kelas_id' => $input['kelas_id'],
                'ta_id' => tahun_aktif()['id']
            ];
            if (!empty($id)) $data['id'] = $id;
            // dd($data);
            $this->RombelModel->save($data);
            session()->setFlashdata("success", "Data berhasil disimpan!");
            return redirect()->to("/rombel");
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function delete($id)
    {
        if ($this->request->getPost()) {
            $cek = $this->RombelModel->isUsed($id);
            if (is_null($cek)) {
                try {
                    $this->RombelModel->delete($id);
                    session()->setFlashdata("success", "Data berhasil dihapus!");
                } catch (\Throwable $th) {
                    session()->setFlashdata("error", "Data gagal dihapus!");
                }
            } else {
                session()->setFlashdata("error", "Data tidak bisa dihapus!");
            }
            return redirect()->to('/rombel');
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function setSantri($id = null)
    {
        if (!is_null($id)) {
            $data['rombel'] = $this->RombelModel->rombelAktif($id);
            if (!is_null($data['rombel'])) {
                return view('admin/rombel/set_santri', $data);
            } else {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function addSantri()
    {
        if ($this->request->getPost()) {
            try {
                foreach ($this->request->getPost('santri_id') as $key) {
                    $data = [
                        'santri_id' => $key,
                        'rombel_id' => $this->request->getPost('rombel_id')
                    ];
                    $cek = $this->RombelModel->isInserted($data);
                    if (is_null($cek)) {
                        $this->RombelModel->addSantri($data);
                    }
                }
                echo json_encode(['status' => 'success', 'message' => 'Data berhasil ditambahkan!']);
            } catch (\Throwable $th) {
                echo json_encode(['status' => 'error', 'message' => 'Data gagal ditambahkan!']);
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function removeSantri()
    {
        if ($this->request->getPost()) {
            try {
                $this->RombelModel->removeSantri();
                echo json_encode(['status' => 'success', 'message' => 'Data berhasil dihapus!']);
            } catch (\Throwable $th) {
                echo json_encode(['status' => 'error', 'message' => 'Data gagal dihapus!']);
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}
