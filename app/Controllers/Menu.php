<?php

namespace App\Controllers;

class Menu extends BaseController
{
	private $menuModel;

	public function __construct()
	{
		$this->menuModel = new \App\Models\MenuModel();
	}

	public function index()
	{
		$data['menu'] = $this->menuModel->orderBy("menu", "asc")->findAll();
		return view('admin/menu/menu', $data);
	}

	public function save($id = "")
	{
		$input = $this->request->getVar();
		if ($input) {
			$data = [
				'menu' => $input['menu'],
				'icon' => $input['icon']
			];
			if (!empty($id)) $data['id'] = $id;
			$this->menuModel->save($data);
			session()->setFlashdata("success", "Data berhasil disimpan!");
			return redirect()->to("/menu");
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}

	public function delete($id)
	{
		if ($this->request->getVar()) {
			$this->menuModel->delete($id);
			$this->menuModel->deleteSub(['menu_id' => $id]);
			session()->setFlashdata("success", "Data berhasil dihapus!");
			return redirect()->to('/menu');
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}

	// sub menu
	public function subMenu()
	{
		$data['menu'] = $this->menuModel->findAll();
		$data['submenu'] = $this->menuModel->getSubMenu();
		return view("admin/menu/submenu", $data);
	}

	public function saveSubmenu($id = null)
	{
		$input = $this->request->getVar();
		if ($input) {
			$data = [
				'menu_id' => $input['menu'],
				'icon' => $input['icon'],
				'title' => $input['title'],
				'url' => $input['url'],
				'is_active' => $input['status']
			];
			if (!is_null($id)) $data['id'] = $id;
			$this->menuModel->saveSubMenu($data);
			session()->setFlashdata("success", "Data berhasil disimpan!");
			return redirect()->to("/menu/submenu");
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}

	public function deleteSub($id)
	{
		if ($this->request->getVar()) {
			$this->menuModel->deleteSub(['id' => $id]);
			session()->setFlashdata("success", "Data berhasil dihapus!");
			return redirect()->to('/menu/submenu');
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}
}
