<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table      = 'users_menu';
    protected $allowedFields = ['id', 'menu', 'icon'];

    public function deleteSub($id)
    {
        $this->db->table("users_sub_menu")->delete($id);
    }

    public function getSubMenu($id = null)
    {
        if (is_null($id)) {
            return $this->db->table("users_sub_menu")
                ->select("users_menu.menu, users_sub_menu.*")
                ->join("users_menu", "users_menu.id = users_sub_menu.menu_id")
                ->orderBy("users_sub_menu.title", "asc")
                ->get()->getResultArray();
        } else {
            return $this->db->table("users_sub_menu")->getWhere(['id' => $id])->getRowArray();
        }
    }

    public function saveSubMenu($data)
    {
        if (isset($data['id'])) {
            $this->db->table("users_sub_menu")->update($data, ['id' => $data['id']]);
        } else {
            $this->db->table("users_sub_menu")->insert($data);
        }
    }

    public function listMenu()
    {
        $menu = $this->db->table("users_access_menu")
            ->select("users_menu.*")->join("users_menu","users_menu.id = users_access_menu.menu_id")
            ->where(['users_access_menu.role_id' => session()->get("role_id")])
            ->get()->getResultArray();
        $data = [];
        $i = 0;
        foreach ($menu as $key) {
            $subMenu = $this->db->table("users_sub_menu")->getWhere(['menu_id' => $key['id']])->getResultArray();
            $data[$i] = $key;
            $data[$i]['sub_menu'] = $subMenu;
            $i++;
        }
        return $data;
    }
}
