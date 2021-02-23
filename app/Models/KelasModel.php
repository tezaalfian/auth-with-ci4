<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table      = 'kelas';
    protected $allowedFields = ['nama_kelas', 'tingkat'];

    public function isUsed($id)
    {
        return $this->db->table("rombel")->getWhere(['kelas_id' => $id])->getRowArray();
    }
}
