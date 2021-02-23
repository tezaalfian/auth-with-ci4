<?php

namespace App\Controllers;

class Santri extends BaseController
{
    private $santriModel;

    public function __construct()
    {
        $this->santriModel = new \App\Models\SantriModel();
    }
    public function search($id = null)
    {
        $data = ['santri' => null];
        if (!is_null($id)) {
            $data['santri'] = $this->santriModel->get_datatables($id);
        }
        return view("admin/santri/search", $data);
    }
}
