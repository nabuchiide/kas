<?php

class KegiatanModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllData()
    {
        $allData = [];
        $this->db->query(" SELECT * FROM kegiatan ORDER BY tanggal DESC ");
        $allData = $this->db->resultset();
        for ($i = 0; $i < count($allData); $i++) {
            $status_loop = $allData[$i]['status'];
            if ($status_loop == WAITING) {
                $status_loop = "Menunggu";
            } else  if ($status_loop == PROCESS) {
                $status_loop = "Prosess";
            } else if ($status_loop == FINISH) {
                $status_loop = "Selesai";
            }  else {
                $status_loop = " - ";
            }
            $allData[$i]['status'] = $status_loop;
        }
        return $allData;
    }

    public function getAllDataStatusWiting()
    {
        $allData = [];
        $this->db->query(" SELECT * FROM kegiatan WHERE status = '" . WAITING . "' ORDER BY tanggal DESC ");
        $allData = $this->db->resultset();
        for ($i = 0; $i < count($allData); $i++) {
            $status_loop = $allData[$i]['status'];
            if ($status_loop == WAITING) {
                $status_loop = "Menunggu";
            } else  if ($status_loop == PROCESS) {
                $status_loop = "Prosess";
            } else if ($status_loop == FINISH) {
                $status_loop = "Selesai";
            } else {
                $status_loop = " - ";
            }
            $allData[$i]['status'] = $status_loop;
        }
        return $allData;
    }


    public function tambahData($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";

        $query = " INSERT INTO kegiatan
                    VALUES
                    ('', :nama_kegiatan, :organisasi, :tanggal, :keterangan, :status)
                ";
        $this->db->query($query);
        $this->db->bind('nama_kegiatan', $data['nama_kegiatan']);
        $this->db->bind('organisasi', $data['organisasi']);
        $this->db->bind('tanggal', $data['tanggal']);
        $this->db->bind('keterangan', $data['keterangan']);
        $this->db->bind('status', '0');

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function ubahData($data)
    {

        $query = " UPDATE kegiatan
                    SET
                        nama_kegiatan   =:nama_kegiatan, 
                        organisasi          =:organisasi, 
                        tanggal         =:tanggal, 
                        keterangan      =:keterangan
                    WHERE
                        id =:id
                ";
        $this->db->query($query);
        $this->db->bind('nama_kegiatan', $data['nama_kegiatan']);
        $this->db->bind('organisasi', $data['organisasi']);
        $this->db->bind('tanggal', $data['tanggal']);
        $this->db->bind('keterangan', $data['keterangan']);
        $this->db->bind('id', $data['id']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function ubahStatus($id, $status)
    {
        $query = " UPDATE kegiatan
                    SET
                        status   =:status
                    WHERE
                        id =:id
                ";
        $this->db->query($query);
        $this->db->bind('status', $status);
        $this->db->bind('id', $id);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getOneData($id)
    {
        $this->db->query(" SELECT * from kegiatan WHERE id =:id ");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function hapusData($id)
    {
        $query = " DELETE FROM kegiatan WHERE id =:id;
                 ";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getKegiatanStatusAnggaran()
    {
        $allData = [];
        $this->db->query(" SELECT * FROM kegiatan WHERE status = 0 ORDER BY tanggal DESC ");
        $allData = $this->db->resultset();
        return $allData;
    }

    public function getDataByDate($month)
    {
        $allData = [];
        $this->db->query(" SELECT * FROM kegiatan WHERE tanggal Like :month ");
        $this->db->bind('month', $month . '%');
        $allData = $this->db->resultset();
        return $allData;
    }

    public function getCountKegiatan()
    {
        $query = "
                SELECT 
                    count(*) as total_count 
                FROM kegiatan k
                ";
        $this->db->query($query);
        $allData = $this->db->single();
        return $allData;
    }
}
