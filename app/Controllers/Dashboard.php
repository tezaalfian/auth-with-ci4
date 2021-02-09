<?php 

namespace App\Controllers;

class Dashboard extends BaseController
{
	public function index()
	{
		return view('admin/template');
	}

	public function set_role($id)
	{
		session()->set('role_id',$id);
		return redirect()->to('/dashboard');
	}
}
