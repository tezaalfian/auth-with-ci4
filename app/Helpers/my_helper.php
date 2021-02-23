<?php

function is_accessed($role_id, $menu_id)
{
    $userModel = new \App\Models\UserModel();
    return $userModel->is_accessed($role_id, $menu_id);
}

function is_admin()
{
    $userModel = new \App\Models\UserModel();
    return $userModel->cekRole(session()->get('id_user'), 1);
}

function my_currency($data)
{
    $money = number_format($data, 0, ",", ".");
    return 'Rp ' . $money;
}

function currency_to_int($str)
{
    return (int)preg_replace("/[^0-9]/", "", $str);
}

function my_date_format($format, $str)
{
    return date($format, strtotime($str));
}
function random_code()
{
    return strtoupper(base_convert(microtime(false), 8, 16));
}
function tahun_aktif()
{
    $db = \Config\Database::connect();
    return $db->table("tahun_ajaran")->getWhere(['status' => 1])->getRowArray();
}
