<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title"><?= ucwords($data['judul']) ?></h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= BASEURL ?>"><?= APL_NAME; ?></a></li>
                    <li class="breadcrumb-item"><a href="<?= BASEURL ?>/user"><?= $data['judul'] ?></a></li>
                </ol>
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
        <div class="col-lg-5 ">
            <div class="card m-b-30">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Input Data Pegawai</h4>
                    <!-- SELECT `id`, `nama_pegawai`, `alamat`, `no_pegawai`, `agama` FROM `pegawai` WHERE 1 -->
                    <form action="<?= BASEURL; ?>/pegawai/tambah" method="post" class="form-enter" id="formInputData">
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="hidden" value="" id="id_pegawai" name="id" placeholder="">
                                <input class="form-control" type="text" value="" id="nama_pegawai" name="nama_pegawai" placeholder="nama pegawai">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">NIP</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" value="" id="no_pegawai" name="no_pegawai" placeholder="nomor pegawai">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Jabatan</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="jabatan" id="jabatan">
                                    <option value="">Select Jabatan</option>
                                    <option value="<?= KEPALA ?>">Kepala Bagian</option>
                                    <option value="<?= BENDAHARA ?>">Bendahara</option>
                                    <option value="<?= STAF ?>">Staff</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-5">
                                <a href="#" class="btn btn-primary waves-effect waves-light" onclick="saveData()"> Save </a>
                                <button class="btn btn-danger waves-effect waves-light" type="reset" onclick="reload_location('pegawai')"> Reset </button>
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
                    <!-- <pre>
                        <?php print_r($data['pegawai']); ?>
                    </pre> -->
                    <table id="datatable2" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No Pegawai</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['pegawai'] as $data) : ?>
                                <tr>
                                    <td><?= $data['no_pegawai']; ?></td>
                                    <td><?= $data['nama_pegawai']; ?></td>
                                    <td><?= $data['jabatan']; ?></td>
                                    <td>
                                        <a href="<?= BASEURL; ?>/pegawai/hapus/<?= $data['id']; ?>/<?= $data['jabatan'] ?>" class="btn btn-danger waves-effect waves-light" onclick="return confirm('Yakin?');">
                                            <span>
                                                Hapus
                                            </span>
                                        </a>
                                        <a href="#" class="getUbah btn btn-primary waves-effect waves-light" data-id="<?= $data['id']; ?>">
                                            <span>
                                                Ubah
                                            </span>
                                        </a>
                                        <!-- <a href="<?= BASEURL; ?>/pegawai/detail/<?= $data['id']; ?>" class="">
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
<script>
    $(document).ready(function() {
        $('.form-enter').on('keypress', function(e) {
            return e.which !== 13;
        });

        $('#datatable2').DataTable();

        $('.getUbah').on('click', function() {

            const id = $(this).data('id')
            $.ajax({
                url: '<?= BASEURL; ?>/pegawai/getUbah/',
                data: {
                    id: id
                },
                method: 'post',
                dataType: 'json',
                success: function(data) {
                    $("#id_pegawai").val(data.id);
                    $("#nama_pegawai").val(data.nama_pegawai);
                    $("#no_pegawai").val(data.no_pegawai);
                    $("#jabatan").val(data.jabatan);

                    $(".card-body form").attr('action', '<?= BASEURL; ?>/pegawai/ubah')
                    $('.card-body form button[type=submit]').html('Ubah Data')

                }
            });
        });
    });

    function saveData() {
        if ($('#nama_pegawai').val() == "") {
            $("#message").html(message('gagal', 'diubah atau ditambahkan, data yang di isi harus lengkap', 'danger', 'Pegawai'));
            return
        }
        if ($('#no_pegawai').val() == "") {
            $("#message").html(message('gagal', 'diubah atau ditambahkan, data yang di isi harus lengkap', 'danger', 'Pegawai'));
            return
        }
        if ($('#bidang').val() == "") {
            $("#message").html(message('gagal', 'diubah atau ditambahkan, data yang di isi harus lengkap', 'danger', 'Pegawai'));
            return
        }
        if ($('#jabatan').val() == "") {
            $("#message").html(message('gagal', 'diubah atau ditambahkan, data yang di isi harus lengkap', 'danger', 'Pegawai'));
            return
        }

        $('#formInputData').submit();
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