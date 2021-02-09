<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Users extends ResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';
    // ...
    public function getRole($id = null)
    {
        return $this->respond($this->model->getRole($id));
    }
}
