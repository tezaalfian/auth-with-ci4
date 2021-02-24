<?php

namespace App\Models;

use CodeIgniter\Model;

class TahunModel extends Model
{
    protected $table      = 'tahun_ajaran';
    protected $allowedFields = ['id', 'status'];

    public function setAktif($id)
    {
        $this->where(['status' => 1])
            ->set(['status' => 0])
            ->update();
        $this->where(['id' => $id])
            ->set(['status' => 1])
            ->update();
    }
}
