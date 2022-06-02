<?php
class Anggaran extends Controller
{
    public function index()
    {
        $data['judul'] = 'Anggaran';
        $data['kegiatan'] = $this->model("KegiatanModel")->getAllDataStatusWiting();
        $this->view('templates/header', $data);
        $this->view('templates/sidemenu');
        $this->view('anggaran/index', $data);
        $this->view('templates/footer');
    }

    public function getByKegitanAnggaran()
    {
        $allData = [];
        $allData = $this->model("AnggaranModel")->getDataByIdKegiatan($_POST['id']);
        echo json_encode($allData);
    }

    public function tambah()
    {
        $_POST['status'] = WAITING;
        $saveData = $_POST;
        echo "<pre>";
        print_r($saveData);
        echo "</pre>";
        if ($this->model("AnggaranModel")->tambahData($saveData) > 0) {
            Flasher::setFlash('berhasil', 'ditambahkan', 'success', 'anggaran');
            header('Location: ' . BASEURL . '/anggaran');
            exit;
        } else {
            Flasher::setFlash('gagal', 'ditambahkan', 'danger', 'anggaran');
            header('Location: ' . BASEURL . '/anggaran');
            exit;
        }
    }

    public function ubah()
    {
        $_POST['status'] = WAITING;
        $updateData = $_POST;
        if ($this->model("AnggaranModel")->ubahData($updateData) > 0) {
            Flasher::setFlash('berhasil', 'ditambahkan', 'success', 'anggaran');
            header('Location: ' . BASEURL . '/anggaran');
            exit;
        } else {
            Flasher::setFlash('gagal', 'ditambahkan', 'danger', 'anggaran');
            header('Location: ' . BASEURL . '/anggaran');
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
