<?php

namespace App\Controllers;

class Users extends BaseController
{
	private $userModel;
	private $menuModel;

	public function __construct()
	{
		$this->userModel = new \App\Models\UserModel();
		$this->menuModel = new \App\Models\MenuModel();
	}
	public function index()
	{
		$data['role'] = $this->userModel->getRole();
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
		// if ($this->request->getPost()) {
		// 	$cek = $this->userModel->cekUser($id);
		// 	if (is_null($cek)) {
		// 		$this->userModel->delete($id);
		// 		$this->userModel->deleteRole($id);
		// 		session()->setFlashdata("success", "Data berhasil dihapus!");
		// 		return redirect()->to('/users');
		// 	} else {
		// 		session()->setFlashdata("error", "Data tidak bisa dihapus!");
		// 		return redirect()->to('/users');
		// 	}
		// } else {
		throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		// }
	}

	public function edit($id = null)
	{
		if (!is_null($id)) {
			$data = [
				'validation' => $this->validation,
				'users' => $this->userModel->getUser($id),
				'role' => $this->userModel->getRole()
			];
			if (count($data['users']) > 1) {
				return view("admin/users/edit", $data);
			} else {
				throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			}
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}

	public function update($id)
	{
		$input = $this->request->getVar();
		if (!$input) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

		$userLama = $this->userModel->getUser($id);
		if ($userLama['username'] == $input['username']) $role_username = 'required|alpha_dash';
		else $role_username = 'required|is_unique[users.username]|alpha_dash';
		$rules = [
			'username' => $role_username,
			'nama' => 'required',
			'foto' => 'is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
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
			'no_hp' => $input['no_hp'],
			'status' => $input['status']
		];
		// cek foto
		$file = $this->request->getFile("foto");
		if ($file->getError() != 4) {
			try {
				$fotoLama = "spu-app/users/$id";
				if ($userLama['foto'] != FOTO_USER) {
					$fotoLama = explode("/", $userLama['foto']);
					unset($fotoLama[0]);
					$fotoLama = implode("/", $fotoLama);
					\Cloudinary\Uploader::destroy($fotoLama);
				}
				$foto = \Cloudinary\Uploader::upload(
					$file->getTempName(),
					array("public_id" => $fotoLama)
				);
				$data['foto'] = "v" . $foto['version'] . "/" . $foto['public_id'];
			} catch (\Throwable $th) {
				session()->setFlashdata("message", "Upload foto gagal! silahkan coba beberapa saat lagi!");
			}
		}
		// dd($data);
		try {
			$this->userModel->save($data);
			$this->userModel->deleteRole($id);
			if (isset($input['role'])) {
				foreach ($input['role'] as $key) {
					$this->userModel->addRole(['role_id' => $key, 'user_id' => $id]);
				}
			}
		} catch (\Throwable $th) {
			dd($th->getMessage());
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
		$data['foto'] = FOTO_USER;
		if ($file->getError() != 4) {
			try {
				$foto = \Cloudinary\Uploader::upload(
					$file->getTempName(),
					array("public_id" => "spu-app/users/$id")
				);
				// dd($foto);
				$data['foto'] = "v" . $foto['version'] . "/" . $foto['public_id'];
			} catch (\Throwable $th) {
				session()->setFlashdata("message", "Upload foto gagal! silahkan coba beberapa saat lagi!");
			}
		}
		try {
			$this->userModel->insert($data);
			if (isset($input['role'])) {
				foreach ($input['role'] as $key) {
					$this->userModel->addRole(['role_id' => $key, 'user_id' => $id]);
				}
			}
		} catch (\Throwable $th) {
			dd($th->getMessage());
		}

		session()->setFlashdata("success", "Data berhasil disimpan!");
		return redirect()->to("/users/add");
	}

	// USERS ROLE
	public function role()
	{
		$data['role'] = $this->userModel->getRole();
		return view("admin/role/list", $data);
	}

	public function saveRole($id = null)
	{
		if ($this->request->getPost()) {
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
			session()->setFlashdata("success", "Data berhasil disimpan!");
			return redirect()->to('/users/role');
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}

	public function user_akses($id = null)
	{
		if (!is_null($id)) {
			if ($this->request->getPost()) {
				$this->userModel->setAkses($id, $this->request->getVar());
				session()->setFlashdata("success", "Data berhasil disimpan!");
				return redirect()->to("/users/user_akses/" . $id);
			}
			$data = [
				'menu' => $this->menuModel->findAll(),
				'role' => $this->userModel->getRole($id)
			];
			if (!is_null($data['role'])) {
				return view("admin/role/akses", $data);
			} else {
				throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			}
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}

	public function listUsers()
	{
		$list = $this->userModel->get_datatables();
		$data = [];
		$no = $_GET['start'];
		foreach ($list as $key) {
			$no++;
			$row = [];
			$row[] = $no;
			$row[] = $key['username'];
			$row[] = $key['nama'];
			$row[] = $key['email'];
			$row[] = $key['no_hp'];
			$row[] = $key['status'] == 1 ? "<span class='badge badge-primary'>Aktif</span>" : "<span class='badge badge-danger'>Non-Aktif</span>";
			$row[] = "<a href='/users/edit/" . $key['id'] . "' class='btn btn-sm btn-success'><i class='fa fa-edit'></i></a>
			<button style='display:inline;' type='button' class='btn btn-sm btn-danger btn-delete' data-nilai='" . $key['id'] . "' data-toggle='modal' data-target='#modal-delete'><i class='fa fa-trash'></i></button>";
			$data[] = $row;
		}
		// dd($data);
		$output = [
			"draw" => $_GET['draw'],
			"recordsTotal" => $this->userModel->count_all(),
			"recordsFiltered" => $this->userModel->count_filtered(),
			"data" => $data,
		];
		echo json_encode($output);
	}
}
