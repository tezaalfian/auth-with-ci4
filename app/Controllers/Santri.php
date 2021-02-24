<?php

namespace App\Controllers;

class Santri extends BaseController
{
    private $santriModel;
    private $rombelModel;

    public function __construct()
    {
        $this->santriModel = new \App\Models\SantriModel();
        $this->rombelModel = new \App\Models\RombelModel();
    }
    public function search($id = null)
    {
        $data = ['santri' => null];
        $data['rombel'] = $this->rombelModel->rombelAktif();
        if (!is_null($id)) {
            $data['santri'] = $this->santriModel->get_datatables($id);
        }
        return view("admin/santri/search", $data);
    }

    public function listSantri($all = true)
    {
        $list = $this->santriModel->get_datatables();
        $data = [];
        $no = isset($_GET['start']) ? $_GET['start'] : 0;
        foreach ($list as $key) {
            $no++;
            $row = [];
            $row[] = $no;
            if (!isset($_GET['column'])) {
                $row[] = "<img src='" . $key['foto'] . "' alt='foto santri' loading='lazy' width='50px'>";
                $row[] = $key['nis'];
                $row[] = $key['nama'];
                $row[] = $key['nisn'];
                $row[] = $key['nik'];
                $row[] = $key['jk'];
                $row[] = $key['tempat_lahir'];
                $row[] = !empty($key['tgl_lahir']) ? my_date_format("d-M-Y", $key['tgl_lahir']) : "";
                $row[] = "<a href='/santri/edit/" . $key['id'] . "' class='btn btn-sm btn-success'><i class='fa fa-edit'></i></a>";
            } else {
                foreach ($_GET['column'] as $val) {
                    if ($val == 'foto') {
                        $row[] = "<img src='" . $key[$val] . "' alt='foto santri' loading='lazy' width='50px'>";
                    } else {
                        $row[] = $key[$val];
                    }
                }
            }
            $data[] = $row;
        }
        // dd($data);
        // var_dump($data);
        // die;
        if ($all) {
            $output = [
                "draw" => $_GET['draw'],
                "recordsTotal" => $this->santriModel->count_all(),
                "recordsFiltered" => $this->santriModel->count_filtered(),
                "data" => $data,
            ];
            echo json_encode($output);
        } else {
            return $data;
        }
    }

    public function report($type = null)
    {
        if (!is_null($type)) {
            $_GET['column'] = ['nama', 'nis', 'jk', 'password'];
            $list = $this->listSantri(false);
            $data = [
                'header' => [],
                'data' => [
                    'title' => ['No', 'Nama', 'Username / No. Induk', 'Jenis Kelamin', 'Password'],
                    'row' => $list
                ],
                'footer' => []
            ];
            $title = "DATA AKUN SANTRI";
            try {
                if (isset($_GET['rombel_id'])) {
                    $rombel = $this->rombelModel->rombelAktif($_GET['rombel_id']);
                    array_push($data['header'], 'Data Kelas : ' . $rombel['kelas']);
                }
                // foreach ($list as $key) {
                //     $data['data']['row'][] = [
                //         $key['id'],
                //         $key['title'],
                //         date("d-M-Y H:i:s", strtotime($key['timestamp'])),
                //         $key['donatur'],
                //         my_currency($key['nominal']),
                //         my_currency($key['biaya_admin']),
                //         my_currency($key['biaya_dpd']),
                //         my_currency($key['dana_bersih']),
                //         // badge_status($key['status'])
                //         $key['status']
                //     ];
                //     if (empty($nama_program))
                //         $nama_program = "'" . ucwords($key['nama_program']) . "'";
                //     $total['nominal'] += (int)$key['nominal'];
                //     $total['biaya_admin'] += (int)$key['biaya_admin'];
                //     $total['biaya_dpd'] += (int)$key['biaya_dpd'];
                //     $total['dana_bersih'] += (int)$key['dana_bersih'];
                // }
                // if (isset($_GET['program_id'])) {
                //     array_push($data['header'], $nama_program);
                // }
                // $data['footer'] = [
                //     'Total Donasi :' => my_currency($total['nominal']),
                //     'Biaya Admin :' => my_currency($total['biaya_admin']),
                //     'Biaya DPD :' => my_currency($total['biaya_dpd']),
                //     'Total Donasi Bersih :' => my_currency($total['dana_bersih'])
                // ];
                // dd($data);
                // call Library Report 
                $myReport = new \App\Libraries\Report();
                // dd($myReport);
                if ($type == "pdf") {
                    $myReport->pdf($title, $data);
                } elseif ($type == "excel") {
                    $myReport->excel($title, $data);
                } else {
                    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
                }
            } catch (\Throwable $th) {
                var_dump($th->getMessage());
                die;
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}
