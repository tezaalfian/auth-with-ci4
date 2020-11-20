<?php

function is_accessed($role_id, $menu_id)
{
    $userModel = new \App\Models\UserModel();
    return $userModel->is_accessed($role_id, $menu_id);
}
