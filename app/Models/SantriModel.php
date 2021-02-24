<?php

namespace App\Models;

use CodeIgniter\Model;

class SantriModel extends Model
{
    protected $table      = 'santri';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $allowedFields = ['id', 'nama', 'email', 'username', 'password', 'foto', 'no_hp', 'status'];

    private function _get_datatables_query()
    {
        helper("my_helper");
        $ta_aktif = tahun_aktif();
        // dd($ta_aktif);
        $column_order = array(null, 'nis', 'nama', null, null); //field yang ada di table user
        $column_search = array('nis', 'nama');
        $select = "santri.nama, santri.nis, santri.nisn, santri.tgl_lahir, santri.tempat_lahir, santri.nik, santri.jk, santri.id, santri.foto, santri.password, concat(kelas.nama_kelas,'-',rombel.nama_rombel) as kelas";
        if (isset($_GET['select'])) $select = $_GET['select'];
        $this->select($select);
        $this->join("rombel_detail", "rombel_detail.santri_id = santri.id", 'left');
        $this->join("rombel", "rombel.id = rombel_detail.rombel_id", 'left');
        $this->join("kelas", "rombel.kelas_id = kelas.id", 'left');
        if (isset($_GET['status'])) {
            $this->where(['santri.status' => $_GET['status']]);
        }
        if (isset($_GET['rombel_lama'])) {
            // "`kelas`.`tingkat` = (SELECT `kelas`.`tingkat` FROM `rombel` JOIN `kelas` ON `kelas`.`id` = `rombel`.`kelas_id` WHERE `rombel`.`id` = " . $_GET['rombel_id'] . " ORDER BY `kelas`.`tingkat` DESC LIMIT 1)-1"
            $this->where("`kelas`.`tingkat` = (SELECT `kelas`.`tingkat` FROM `rombel` JOIN `kelas` ON `kelas`.`id` = `rombel`.`kelas_id` WHERE `rombel`.`id` = " . $_GET['rombel_id'] . " ORDER BY `kelas`.`tingkat` DESC LIMIT 1)-1");
            $this->where("`rombel`.`ta_id` = (SELECT `tahun_ajaran`.`id` FROM `tahun_ajaran` WHERE `tahun_ajaran`.`tingkat` < " . $ta_aktif['tingkat'] . " ORDER BY `tahun_ajaran`.`tingkat` DESC LIMIT 1)");
            $this->where("`rombel_detail`.`santri_id` NOT IN (SELECT `rombel_detail`.`santri_id` FROM `rombel_detail` JOIN `rombel` ON `rombel`.`id` = `rombel_detail`.`rombel_id` WHERE `rombel`.`ta_id` = '" . $ta_aktif['id'] . "')");
        } else {
            if (isset($_GET['rombel_id'])) {
                // var_dump($_GET['rombel_id']);die;
                $_GET['rombel_id'] = empty($_GET['rombel_id']) ? null : $_GET['rombel_id'];
                $this->where(["rombel_detail.rombel_id" => $_GET['rombel_id']]);
            }
        }
        $i = 0;
        foreach ($column_search as $item) {
            if (isset($_GET['search']['value'])) {
                if ($i === 0) {
                    $this->groupStart();
                    $this->like($item, $_GET['search']['value']);
                } else {
                    $this->orLike($item, $_GET['search']['value']);
                }
                if (count($column_search) - 1 == $i)
                    $this->groupEnd();
            }
            $i++;
        }
        if (isset($_GET['pencarian'])) {
            $this->like($_GET['pencarian']['key'], $_GET['pencarian']['value']);
            $this->limit(10);
        }
        if (isset($_GET['order'])) {
            $this->orderBy($column_order[$_GET['order']['0']['column']], $_GET['order']['0']['dir']);
        } else {
            $this->orderBy("santri.nama", "asc");
        }
    }
    public function get_datatables($id = null)
    {
        $this->_get_datatables_query();
        if (isset($_GET['length']) || isset($_GET['start'])) {
            if ($_GET['length'] != -1)
                $this->limit($_GET['length'], $_GET['start']);
        }
        return $this->find($id);
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        return $this->countAllResults();
    }

    public function count_all()
    {
        $this->_get_datatables_query();
        return $this->countAll();
    }
}
