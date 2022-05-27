<?php
class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllData()
    {
        $allData = [];
        $this->db->query(" SELECT u.id, u.user_name, u.user_type, p.nama_pegawai 
            from user u, pegawai p WHERE u.no_pegawai = p.no_pegawai and u.user_type != 0  ORDER BY u.id DESC ");
        $allData = $this->db->resultset();
        for ($i = 0; $i < count($allData); $i++) {
            $user_type_loop = $allData[$i]["user_type"];
            if ($user_type_loop == ADMIN_USR) {
                $user_type_loop = "Admin";
            } else if ($user_type_loop == BENDAHARA_USR) {
                $user_type_loop = "Bendahara";
            } else if ($user_type_loop == KEPALA_USR) {
                $user_type_loop = "PPTK";
            } else if ($user_type_loop == MASTER_USR) {
                $user_type_loop = "Master";
            } else {
                $user_type_loop = "Invalid Format";
            }
            $allData[$i]["user_type"] = $user_type_loop;
        }
        return $allData;
    }

    public function getOneDataById($id)
    {
        $this->db->query(" SELECT * from user WHERE id =:id  ");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tambahData($data)
    {
        $query = " INSERT INTO user 
                    (id, user_name, password, user_type, no_pegawai)
                    VALUES
                    ('', :user_name, :password, :user_type, :no_pegawai)
                ";
        $this->db->query($query);
        $this->db->bind('user_name', $data['user_name']);
        $this->db->bind('password', $data['password']);
        $this->db->bind('user_type', $data['user_type']);
        $this->db->bind('no_pegawai', $data['no_pegawai']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function ubahData($data)
    {
        $query = " UPDATE user SET 
                        user_name   =:user_name,
                        password    =:password,
                        user_type   =:user_type,
                        no_pegawai  =:no_pegawai 
                    WHERE 
                        id  =:id
                ";

        $this->db->query($query);
        $this->db->bind('user_name', $data['user_name']);
        $this->db->bind('password', $data['password']);
        $this->db->bind('user_type', $data['user_type']);
        $this->db->bind('no_pegawai', $data['no_pegawai']);
        $this->db->bind('id', $data['id']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapusData($id)
    {
        $query = " DELETE FROM user WHERE id=:id ";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function prosessLogin($data)
    {
        $allData = [];
        $query = " SELECT count(*) AS CountData FROM user WHERE user_name =:user_name AND password =:password ";
        // $query = " SELECT * FROM user WHERE user_name =:user_name AND password =:password ";

        $this->db->query($query);
        $this->db->bind('user_name', $data['user_name']);
        $this->db->bind('password', $data['password']);
        $allData = $this->db->single();
        return $allData;
    }

    public function prosessLoginGetData($data)
    {
        $allData = [];
        // $query = " SELECT count(*) AS CountData FROM user WHERE user_name =:user_name AND password =:password ";
        $query = " SELECT * FROM user WHERE user_name =:user_name AND password =:password ";

        $this->db->query($query);
        $this->db->bind('user_name', $data['user_name']);
        $this->db->bind('password', $data['password']);
        $allData = $this->db->single();
        return $allData;
    }
}
