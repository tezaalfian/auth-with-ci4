<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Menu extends ResourceController
{
    protected $modelName = 'App\Models\MenuModel';
    protected $format    = 'json';
    // ...
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        return $this->respond($this->model->find($id));
    }

    public function subMenu($id = null)
    {
        return $this->respond($this->model->getSubMenu($id));
    }
}
