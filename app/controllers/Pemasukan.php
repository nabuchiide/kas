<?php
class Pemasukan extends Controller
{
    public function index()
    {
        $data['judul'] = 'Pemasukan';
        $data['anggaran'] = $this->model("AnggaranModel")->getDataPemasukan();
        $this->view('templates/header', $data);
        $this->view('templates/sidemenu');
        $this->view('anggaran/pemasukan/index', $data);
        $this->view('templates/footer');
    }

    public function tambah()
    {
        $_POST['type_anggaran'] = UANG_MASUK;
        $_POST['id_kegiatan'] = 0;
        $_POST['status'] = WAITING;
        $saveData = $_POST;

        if ($this->model("AnggaranModel")->tambahData($saveData) > 0) {
            Flasher::setFlash('berhasil', 'ditambahkan', 'success', 'Pemasukan');
            header('Location: ' . BASEURL . '/pemasukan');
            exit;
        } else {
            Flasher::setFlash('gagal', 'ditambahkan', 'danger', 'Pemasukan');
            header('Location: ' . BASEURL . '/pemasukan');
            exit;
        }
    }

    public function ubah()
    {
        $_POST['type_anggaran'] = UANG_MASUK;
        $_POST['id_kegiatan'] = 0;
        $_POST['status'] = WAITING;
        $updateData = $_POST;

        if ($this->model("AnggaranModel")->ubahData($updateData) > 0) {
            Flasher::setFlash('berhasil', 'ditambahkan', 'success', 'Pemasukan');
            header('Location: ' . BASEURL . '/pemasukan');
            exit;
        } else {
            Flasher::setFlash('gagal', 'ditambahkan', 'danger', 'Pemasukan');
            header('Location: ' . BASEURL . '/pemasukan');
            exit;
        }
    }

    public function hapus($id){
        if ($this->model("AnggaranModel")->hapusData($id) > 0) {
            Flasher::setFlash('berhasil', 'dihapus', 'success', 'Pemasukan');
            header('Location: ' . BASEURL . '/pemasukan');
            exit;
        } else {
            Flasher::setFlash('gagal', 'dihapus', 'danger', 'Pemasukan');
            header('Location: ' . BASEURL . '/pemasukan');
            exit;
        }
    }

    public function getUbah()
    {
        echo json_encode($this->model('AnggaranModel')->getOneData($_POST['id']));
    }
}
