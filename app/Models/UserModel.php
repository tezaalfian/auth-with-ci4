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
        $menu = $uri->getSegment(1);
        $q_menu = $this->db->table("users_menu")
            ->getWhere(['menu' => $menu])->getRowArray();
        $data = $this->db->table("users_access_menu")
            ->getWhere(['menu_id' => $q_menu['id'], 'role_id' => $role_id])
            ->getResultArray();
        return $data;
    }
}
