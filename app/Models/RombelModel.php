<?php

namespace App\Models;

use CodeIgniter\Model;

class RombelModel extends Model
{
    protected $table      = 'rombel';
    protected $allowedFields = ['nama_rombel', 'kelas_id', 'ta_id'];
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;

    public function rombelAktif($id = null)
    {
        if (isset($_GET['kelas_id'])) {
            $this->where(['kelas_id' => $_GET['kelas_id']]);
        }
        return $this->select("kelas.nama_kelas, rombel.*, count(rombel_detail.santri_id) as jumlah")
            ->join("kelas", "kelas.id = rombel.kelas_id")
            ->join("rombel_detail", "rombel_detail.rombel_id = rombel.id", "left")
            ->groupBy("rombel.id")
            ->where(['ta_id' => tahun_aktif()['id']])
            ->orderBy('kelas.tingkat asc, nama_rombel asc')
            ->find($id);
    }
    public function listRombel($id = null)
    {
        return $this->select("kelas.nama_kelas, rombel.*, count(*) over (partition by rombel.kelas_id) as jumlah")
            ->join("kelas", "kelas.id = rombel.kelas_id")
            ->where(['ta_id' => tahun_aktif()['id']])
            ->orderBy('kelas.tingkat asc, nama_rombel asc')
            ->find($id);
    }

    public function addSantri($data)
    {
        // $this->db->table("rombel_detail")->insertBatch($data);
        $this->db->table("rombel_detail")->insert($data);
    }

    public function removeSantri($data)
    {
        // $this->db->table("rombel_detail")->insertBatch($data);
        $this->db->table("rombel_detail")->delete($data);
    }

    public function isInserted($data)
    {
        return $this->db->table("rombel_detail")->getWhere($data)->getRowArray();
    }

    public function isUsed($id)
    {
        return $this->db->table("rombel_detail")->getWhere(['id' => $id])->getRowArray();
    }
}
