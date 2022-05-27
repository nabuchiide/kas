<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title"><?= $data['judul'] ?></h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= BASEURL ?>"><?= APL_NAME; ?></a></li>
                    <li class="breadcrumb-item"><a href="<?= BASEURL ?>/user"><?= $data['judul'] ?></a></li>
                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="widgetbar">
                <button class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>Actions</button>
            </div>
        </div>
    </div>
</div>

<div class="contentbar">
    <?php Flasher::flash(); ?>
    <div id="message"></div>
</div>

<div class="contentbar">
    <div class="row">
        <div class="col-lg-12 col-xl-6">
            <div class="card m-b-30">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Input Data User</h4>
                    <form action="<?= BASEURL; ?>/user/tambah" method="post" class="form-enter" onsubmit="" id="formInsertData">
                        <!-- SELECT `id`, `user_name`, `password`, `user_type`, `no_pegawai` FROM `user` WHERE 1 -->
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">User Name</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="hidden" value="" id="id_user" name="id" placeholder="user name">
                                <input class="form-control" type="text" value="" id="user_name" name="user_name" placeholder="user name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" value="" id="password" name="password" placeholder="password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">User Type</label>
                            <div class="col-sm-10">
                                <!-- <input class="form-control" type="text" value="" id="user_type" name="user_type"> -->
                                <select class="form-control" id="user_type" name="user_type">
                                    <option value="">Select Type</option>
                                    <option value="<?= KEPALA_USR ?>">Kepala Bagian</option>
                                    <option value="<?= BENDAHARA_USR ?>">Bendahara</option>
                                    <option value="<?= ADMIN_USR ?>">Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">No Pegawai</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" value="" id="no_pegawai" placeholder="nomor pegawai" readonly>
                                <input class="form-control" type="hidden" value="" id="no_pegawai_hide" name="no_pegawai" placeholder="nomor pegawai">
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-primary waves-effect waves-light" type="button" data-toggle="modal" data-target="#dataModal"> search </button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-5">
                                <a href="#" class="btn btn-primary waves-effect waves-light" onclick="save_data();">
                                    Save </a>
                                <button class="btn btn-danger waves-effect waves-light" type="reset" onclick="reload_location('user')"> Reset </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-10">
            <div class="card m-b-30">
                <div class="card-body">
                    <table class="table table-bordered data-table-format">
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>User Type</th>
                                <th>Nama Pegawai</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $dataPegawai    = $data['pegawai'];
                            $dataUser       = $data['user'];
                            foreach ($dataUser as $data) : ?>
                                <tr>
                                    <td><?= $data['user_name']; ?></td>
                                    <td><?= $data['user_type']; ?></td>
                                    <td><?= $data['nama_pegawai']; ?></td>
                                    <td>
                                        <a href="<?= BASEURL; ?>/user/hapus/<?= $data['id']; ?>" class="btn btn-danger waves-effect waves-light" onclick="return confirm('Yakin?');">
                                            <span>
                                                Hapus
                                            </span>
                                        </a>
                                        <a href="#" class="getUbah btn btn-primary waves-effect waves-light" data-id="<?= $data['id']; ?>">
                                            <span>
                                                Ubah
                                            </span>
                                        </a>
                                        <!-- <a href="<?= BASEURL; ?>/user/detail/<?= $data['id']; ?>" class="">
                                        <span>
                                            Detail
                                        </span>
                                    </a>  -->
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>


<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">Data Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-bordered data-table-format " width="100%">

                    <thead>
                        <tr>
                            <td>NO</td>
                            <td>Nomor Pegawai</td>
                            <td>Nama Pegawai</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($dataPegawai as $data) : ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td>
                                    <a href="#" class="getNomorPegawai" data-nomor="<?= $data['no_pegawai']; ?>" data-dismiss="modal">
                                        <span>
                                            <?= $data['no_pegawai']; ?>
                                        </span>
                                    </a>
                                </td>
                                <td><?= $data['nama_pegawai']; ?></td>
                            </tr>
                            <?php $no++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.form-enter').on('keypress', function(e) {
            return e.which !== 13;
        });

        $('.data-table-format').DataTable();

        $('.getUbah').on('click', function() {
            const id = $(this).data('id')
            console.log(id);
            $.ajax({
                url: '<?= BASEURL; ?>/user/getUbah/',
                data: {
                    id: id
                },
                method: 'post',
                dataType: 'json',
                beforeSend: function() {
                    $.blockUI({
                        message: null
                    });
                },
                complete: function() {
                    $.unblockUI();
                },
                success: function(data) {
                    console.log(data);
                    $('#id_user').val(data.id);
                    $('#user_name').val(data.user_name);
                    $('#password').val(data.password);
                    $('#user_type').val(data.user_type);
                    $('#no_pegawai').val(data.no_pegawai);
                    $('#no_pegawai_hide').val(data.no_pegawai);

                    $(".card-body form").attr('action', '<?= BASEURL; ?>/user/ubah')
                    $('.card-body form button[type=submit]').html('Ubah Data')
                },
                error: function() {
                    console.log("GAGAL");
                }
            })
        })

        $('.getNomorPegawai').on('click', function() {
            const nomor = $(this).data('nomor');
            $('#no_pegawai').val(nomor)
            $('#no_pegawai_hide').val(nomor)
            $('#dataModal').modal('no_pegawai');
            $('#dataModal').modal('no_pegawai_hide');
        })
    })

    function save_data() {
        if ($('#user_name').val() == "") {
            $("#message").html(message('gagal', 'diubah atau ditambahkan, data yang di isi harus lengkap', 'danger',
                'User'));
            return

        }
        if ($('#password').val() == "") {
            $("#message").html(message('gagal', 'diubah atau ditambahkan, data yang di isi harus lengkap', 'danger',
                'User'));

            return

        }
        if ($('#user_type').val() == "") {
            $("#message").html(message('gagal', 'diubah atau ditambahkan, data yang di isi harus lengkap', 'danger',
                'User'));
            return

        }
        if ($('#no_pegawai_hide').val() == "") {
            $("#message").html(message('gagal', 'diubah atau ditambahkan, data yang di isi harus lengkap', 'danger',
                'User'));
            return
        }

        $('#formInsertData').submit();
    }

    function message(pesan, aksi, tipe, data) {
        allert_load = "";
        allert_load += '<div class="alert alert-' + tipe + ' alert-dismissible fade show" role="alert">'
        allert_load += 'Data ' + data + ' <strong>' + pesan + ' </strong> ' + aksi
        allert_load += '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
        allert_load += '<span aria-hidden="true">&times;</span>'
        allert_load += '</button>'
        allert_load += '</div>'
        return allert_load
    }
</script>