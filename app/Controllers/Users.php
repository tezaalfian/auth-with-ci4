<?php

namespace App\Controllers;

class Users extends BaseController
{
	private $userModel;
	private $menuModel;

	public function __construct() {
		$this->userModel = new \App\Models\UserModel();
		$this->menuModel = new \App\Models\MenuModel();
	}
	public function index()
	{
		$data['users'] = $this->userModel->findAll();
		return view('admin/users/list', $data);
	}

	public function add()
	{
		$data['role'] = $this->userModel->getRole();
		// dd($data['role']);
		$data['validation'] = $this->validation;
		return view('admin/users/add', $data);
	}

	public function delete($id)
	{
		if ($this->request->getVar()) {
			$cek = $this->userModel->cekUser($id);
			if (is_null($cek)) {
				$this->userModel->delete($id);
				$this->userModel->deleteRole($id);
				session()->setFlashdata("success", "Data berhasil dihapus!");
				return redirect()->to('/users');
			}else{
				session()->setFlashdata("error", "Data tidak bisa dihapus!");
				return redirect()->to('/users');
			}
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}

	public function edit($id)
	{
		$data = [
			'validation' => $this->validation,
			'users' => $this->userModel->getUser($id),
			'role' => $this->userModel->getRole()
		];
		return view("admin/users/edit", $data);
	}

	public function update($id)
	{
		$input = $this->request->getVar();
		if(!$input) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

		$userLama = $this->userModel->getUser($id);
		if ($userLama['username'] == $input['username']) $role_username = 'required|alpha_dash';
		else $role_username = 'required|is_unique[users.username]|alpha_dash';
		$rules = [
			'username' => $role_username,
			'nama' => 'required',
			'foto' => 'is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]'
		];
		if (!empty($input['email'])) $rules['email'] = "valid_email";
		if (!empty($input['no_hp'])) $rules['no_hp'] = "numeric";
		if (!$this->validate($rules)) {
			return redirect()->to("/users/edit/$id")->withInput();
		}
		//Insert to database
		$data = [
			'id' => $id,
			'username' => $input['username'],
			'nama' => $input['nama'],
			'email' => $input['email'],
			'no_hp' => $input['no_hp']
		];
		// cek foto
		$file = $this->request->getFile("foto");
		if ($file->getError() == 4) {
			
		} else {
			$fotoLama = explode("/",$userLama['foto']);
			unset($fotoLama[0]);
			$fotoLama = implode("/",$fotoLama);
			\Cloudinary\Uploader::destroy($fotoLama);
			$foto = \Cloudinary\Uploader::upload(
				$file->getTempName(),
				array("public_id" => $fotoLama)
			);
			$data['foto'] = "v" . $foto['version'] . "/" . $foto['public_id'];
		}
		// dd($data);
		$this->userModel->save($data);
		foreach ($input['role'] as $key) {
			$this->userModel->deleteRole($id);
			$this->userModel->addRole(['role_id' => $key, 'user_id' => $id]);
		}

		session()->setFlashdata("success", "Data berhasil disimpan!");
		return redirect()->to("/users/edit/$id");
	}

	public function save()
	{
		$input = $this->request->getVar();
		$rules = [
			'username' => 'required|is_unique[users.username]|alpha_dash',
			'nama' => 'required',
			'password' => 'required|min_length[5]',
			'pass_confirm' => 'required|matches[password]',
			'foto' => 'is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]'
		];
		if (!empty($input['email'])) $rules['email'] = "valid_email";
		if (!empty($input['no_hp'])) $rules['no_hp'] = "numeric";
		if (!$this->validate($rules)) {
			return redirect()->to("/users/add")->withInput();
		}
		//Insert to database
		$id = time();
		$data = [
			'id' => (string)$id,
			'username' => $input['username'],
			'nama' => $input['nama'],
			'password' => password_hash($input['password'], PASSWORD_DEFAULT),
			'email' => $input['email'],
			'no_hp' => $input['no_hp']
		];
		// cek foto
		$file = $this->request->getFile("foto");
		if ($file->getError() == 4) {
			$data['foto'] = "v1605594452/spu-app/users/default.png";
		} else {
			// dd($file->getTempName());
			$foto = \Cloudinary\Uploader::upload(
				$file->getTempName(),
				array("public_id" => "spu-app/users/$id")
			);
			// dd($foto);
			$data['foto'] = "v" . $foto['version'] . "/" . $foto['public_id'];
		}
		// dd($data);
		$this->userModel->insert($data);
		foreach ($input['role'] as $key) {
			$this->userModel->addRole(['role_id' => $key, 'user_id' => $id]);
		}

		session()->setFlashdata("success", "Data berhasil disimpan!");
		return redirect()->to("/users/add");
	}

	// USERS ROLE
	public function role()
	{
		$data['role'] = $this->userModel->getRole();
		return view("admin/role/list",$data);
	}

	public function saveRole($id = null)
	{
		if($this->request->getVar()){
			$data = [
				'role' => $this->request->getVar("role"),
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			];
			if (!is_null($id)) {
				$data['id'] = $id;
				unset($data['created_at']);
			}
			$this->userModel->saveRole($data);
			session()->setFlashdata("success","Data berhasil disimpan!");
			return redirect()->to('/users/role');
		}else{
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}

	public function user_akses($id)
	{
		if($this->request->getVar()){
			$this->userModel->setAkses($id,$this->request->getVar());
			session()->setFlashdata("success","Data berhasil disimpan!");
			return redirect()->to("/users/user_akses/".$id);
		}
		$data = [
			'menu' => $this->menuModel->findAll(),
			'role' => $this->userModel->getRole($id)
		];
		return view("admin/role/akses",$data);
	}
}
