<?php

class AnggaranModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllDataByStatus($status)
    {
        $query = "
                SELECT 
                    sum(p.biaya) as total_sum 
                FROM anggaran p 
                    WHERE p.status =:status
                ";
        $this->db->query($query);
        $this->db->bind('status', $status);
        $allData = $this->db->single();
        return $allData;
    }

    public function getAllData()
    {
        $allData = [];
        $this->db->query(" SELECT * FROM anggaran ");
        $allData = $this->db->resultset();
        return $allData;
    }

    public function getDataPemasukan()
    {
        $allData = [];
        $this->db->query(" SELECT * FROM anggaran WHERE type_anggaran = '" . UANG_MASUK . "'");
        $allData = $this->db->resultset();
        return $allData;
    }

    public function getDataByIdKegiatan($id_kegiatan, $type_anggaran)
    {
        $allData = [];
        $this->db->query(" SELECT * FROM anggaran WHERE id_kegiatan =:id_kegiatan && type_anggaran =:type_anggaran");
        $this->db->bind('id_kegiatan', $id_kegiatan);
        $this->db->bind('type_anggaran', $type_anggaran);
        $allData = $this->db->resultset();
        return $allData;
    }

    public function tambahData($data)
    {
        $query = " INSERT INTO 
                anggaran(id, tanggal, nominal, no_rekening, keterangan, type_anggaran, id_kegiatan, status)  
                VALUES ('', :tanggal, :nominal, :no_rekening, :keterangan, :type_anggaran, :id_kegiatan, :status)
            ";
        $this->db->query($query);
        $this->db->bind('tanggal', $data['tanggal']);
        $this->db->bind('nominal', $data['nominal']);
        $this->db->bind('no_rekening', $data['no_rekening']);
        $this->db->bind('keterangan', $data['keterangan']);
        $this->db->bind('type_anggaran', $data['type_anggaran']);
        $this->db->bind('id_kegiatan', $data['id_kegiatan']);
        $this->db->bind('status', $data['status']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function ubahData($data)
    {
        $query = "  UPDATE anggaran SET 
                        tanggal         =:tanggal,
                        nominal         =:nominal,
                        no_rekening     =:no_rekening,
                        keterangan      =:keterangan,
                        type_anggaran   =:type_anggaran,
                        id_kegiatan     =:id_kegiatan,
                        status          =:status 
                    WHERE 
                        id =:id
            ";
        $this->db->query($query);
        $this->db->bind('id', $data['id']);
        $this->db->bind('tanggal', $data['tanggal']);
        $this->db->bind('nominal', $data['nominal']);
        $this->db->bind('no_rekening', $data['no_rekening']);
        $this->db->bind('keterangan', $data['keterangan']);
        $this->db->bind('type_anggaran', $data['type_anggaran']);
        $this->db->bind('id_kegiatan', $data['id_kegiatan']);
        $this->db->bind('status', $data['status']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function ubahStatusByIdKegiatan($id_kegiatan, $status)
    {

        $query = " UPDATE anggaran
                   SET
                       status      =:status 
                   WHERE 
                       id_kegiatan =:id_kegiatan
           ";
        $this->db->query($query);
        $this->db->bind('status', $status);
        $this->db->bind('id_kegiatan', $id_kegiatan);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function ubahStatusById($id, $status)
    {

        $query = " UPDATE anggaran
                   SET
                       status      =:status 
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
        $this->db->query(" SELECT * FROM anggaran WHERE id =:id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function cekingData($id)
    {
        $allData = [];
        $query = " SELECT count(*) AS CountData FROM anggaran WHERE id =:id ";

        $this->db->query($query);
        $this->db->bind('id', $id);
        $allData = $this->db->single();
        return $allData;
    }

    public function hapusData($id)
    {
        $query = " DELETE FROM anggaran WHERE id =:id ";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapusDataByKegiatan($id_kegiatan)
    {
        $query = " DELETE FROM anggaran WHERE id_kegiatan =:id_kegiatan ";
        $this->db->query($query);
        $this->db->bind('id_kegiatan', $id_kegiatan);
        $this->db->execute();
        return $this->db->rowCount();
    }
}

/* define('WAITING','0');
define('PROCESS','1');
define('FINISH','2');
define('APPROVE','3'); */