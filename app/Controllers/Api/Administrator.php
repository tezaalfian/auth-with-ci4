<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Administrator extends ResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';
    protected $helper = ['my_helper'];
    private $santriModel;

    public function cariSantri()
    {
        $this->santriModel = new \App\Models\SantriModel();
        return $this->respond($this->santriModel->get_datatables());
    }

    public function listSantriRombel()
    {
        $this->santriModel = new \App\Models\SantriModel();
        // dd($this->santriModel->get_datatables());
        return $this->respond($this->santriModel->get_datatables());
    }

    public function listWalasRombel()
    {
        $userModel = new \App\Models\UserModel();
        // dd($this->santriModel->get_datatables());
        return $this->respond($userModel->get_datatables());
    }

    public function kelasDetail($id = null)
    {
        $kelasModel = new \App\Models\KelasModel();
        return $this->respond($kelasModel->find($id));
    }

    public function rombelDetail($id = null)
    {
        $rombelModel = new \App\Models\RombelModel();
        return $this->respond($rombelModel->find($id));
    }
}
