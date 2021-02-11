<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'nama', 'email', 'username', 'password', 'foto', 'no_hp', 'status'];
    protected $useTimestamps = true;

    public function getRole($id = null)
    {
        if (is_null($id))
            return $this->db->table("users_role")->get()->getResultArray();
        else
            return $this->db->table("users_role")->getWhere(['id' => $id])->getRowArray();
    }

    public function addRole($data)
    {
        $this->db->table("users_role_access")->insert($data);
    }

    public function deleteRole($id)
    {
        $this->db->table("users_role_access")->delete(['user_id' => $id]);
    }

    public function getUser($id = "")
    {
        $data = $this->where(['id' => $id])->first();
        $data['role'] = [];
        $role = $this->db->table("users_role_access")->getWhere(['user_id' => $id])->getResultArray();
        foreach ($role as $key) {
            $data['role'][] = $key['role_id'];
        }
        return $data;
    }

    public function cekUser($id)
    {
        return $this->db->table("program")->getWhere(['created_by' => $id])->getRowArray();
    }

    public function saveRole($data)
    {
        if (isset($data['id'])) {
            $this->db->table("users_role")->update($data, ['id' => $data['id']]);
        } else {
            $this->db->table("users_role")->insert($data);
        }
    }

    public function is_accessed($role_id, $menu_id)
    {
        $data = $this->db->table("users_access_menu")
            ->getWhere(['role_id' => $role_id, 'menu_id' => $menu_id])
            ->getRowArray();
        if (!is_null($data)) {
            return 'checked=checked';
        } else {
            return '';
        }
    }

    public function setAkses($id, $data)
    {
        $this->db->table("users_access_menu")->delete(['role_id' => $id]);
        if (isset($data['menu'])) {
            foreach ($data['menu'] as $key) {
                $this->db->table("users_access_menu")->insert(['role_id' => $id, 'menu_id' => $key]);
            }
        }
    }

    // cek akses user 
    public function isAccessed()
    {
        $uri = new \CodeIgniter\HTTP\URI(base_url(uri_string()));
        $role_id = session()->get('role_id');
        $menu = $uri->getSegment(1) != "" ? $uri->getSegment(1) : "dashboard";
        $q_menu = $this->db->table("users_menu")
            ->getWhere(['menu' => $menu])->getRowArray();
        $data = $this->db->table("users_access_menu")
            ->getWhere(['menu_id' => $q_menu['id'], 'role_id' => $role_id])
            ->getResultArray();
        return $data;
    }

    public function cekRole($id, $role_id)
    {
        return $this->db->table("users_role_access")->getWhere(['role_id' => $role_id, 'user_id' => $id])->getRowArray();
    }

    private function _get_datatables_query()
    {
        $column_order = [null, 'users.username', 'users.nama', 'users.email', 'users.no_hp', null];
        $column_search = ['users.username', 'users.nama', 'users.email', 'users.no_hp'];
        $this->select("users.*, users_role_access.role_id");
        $this->join("users_role_access", "users_role_access.user_id = users.id", "left");
        $this->groupBy("users.id");
        if (isset($_GET['role_id'])) {
            if ($_GET['role_id'] == null) {
                $this->where("users.username", null);
            } else {
                $this->where("users_role_access.role_id", $_GET['role_id']);
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
        if (isset($_GET['order'])) {
            $this->orderBy($column_order[$_GET['order']['0']['column']], $_GET['order']['0']['dir']);
        } else {
            // $order = $this->by_order;
            // $this->orderBy(key($order), $order[key($order)]);
            $this->orderBy("users.nama", "asc");
        }
    }
    public function get_datatables()
    {
        $this->_get_datatables_query();
        if (isset($_GET['length']) || isset($_GET['start'])) {
            if ($_GET['length'] != -1)
                $this->limit($_GET['length'], $_GET['start']);
        }
        return $this->getWhere(['users.deleted_at' => null])->getResultArray();
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
