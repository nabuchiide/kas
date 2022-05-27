<?php
class Pengeluaran extends Controller
{
    public function index()
    {
        $data['judul'] = 'Pengeluaran';
        $data['kegiatan'] = $this->model("KegiatanModel")->getAllDataStatusWiting();
        $this->view('templates/header', $data);
        $this->view('templates/sidemenu');
        $this->view('anggaran/pengeluaran/index', $data);
        $this->view('templates/footer');
    }

    public function getByKegitanAnggaran()
    {
        $allData = [];
        $allData = $this->model("AnggaranModel")->getDataByIdKegiatan($_POST['id'], UANG_KELUAR);
        echo json_encode($allData);
    }

    public function tambah()
    {
        $_POST['type_anggaran'] = UANG_KELUAR;
        $_POST['status'] = WAITING;
        $saveData = $_POST;
        if ($this->model("AnggaranModel")->tambahData($saveData) > 0) {
            Flasher::setFlash('berhasil', 'ditambahkan', 'success', 'pengeluaran');
            header('Location: ' . BASEURL . '/pengeluaran');
            exit;
        } else {
            Flasher::setFlash('gagal', 'ditambahkan', 'danger', 'pengeluaran');
            header('Location: ' . BASEURL . '/pengeluaran');
            exit;
        }
    }

    public function ubah()
    {
        $_POST['type_anggaran'] = UANG_KELUAR;
        $_POST['status'] = WAITING;
        $updateData = $_POST;
        if ($this->model("AnggaranModel")->ubahData($updateData) > 0) {
            Flasher::setFlash('berhasil', 'ditambahkan', 'success', 'pengeluaran');
            header('Location: ' . BASEURL . '/pengeluaran');
            exit;
        } else {
            Flasher::setFlash('gagal', 'ditambahkan', 'danger', 'pengeluaran');
            header('Location: ' . BASEURL . '/pengeluaran');
            exit;
        }
    }

    public function hapus()
    {
        $id = $_POST['id'];
        $result = $this->model("AnggaranModel")->hapusData($id);
        echo json_encode($result);
    }
}
