<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="<?= BASEURL ?>"><?= APL_NAME; ?></a></li>
                            <li class="breadcrumb-item active"><?= $data['judul']; ?></li>
                        </ol>
                    </div>
                    <h4 class="page-title"><?= ucwords($data['judul']); ?></h4>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <?php Flasher::flash(); ?>
    <div id="message"></div>

    <div class="row container-fluid">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Input Data Pemasukan</h4>
                    <form action="<?= BASEURL; ?>/pemasukan/tambah" method="post" class="form-enter" id="formInputData">
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Tanggal</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="hidden" value="" id="id_anggaran" name="id">
                                <input class="form-control" type="date" value="" id="tanggal" name="tanggal" placeholder="tanggal">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Nominal (Rp)</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="number" value="" id="nominal" name="nominal" placeholder="nominal" maxlength="20">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">No. Rekening</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" value="" id="no_rekening" name="no_rekening" placeholder="no rekening" maxlength="20">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Keterangan</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-5">
                                <a href="#" class="btn btn-primary waves-effect waves-light" onclick="save_data()"> Save </a>
                                <button class="btn btn-danger waves-effect waves-light" type="reset" onclick="reload_location('pegawai')"> Reset </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-lg-10">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered data-table-format">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>No Rekening</th>
                                <th>Uraian</th>
                                <th>Debit</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $dataPemasukan = $data['anggaran'];
                            $no = 0;
                            foreach ($dataPemasukan as $pemasukan) :
                                $no++;
                            ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= $pemasukan['tanggal']; ?></td>
                                    <td><?= $pemasukan['no_rekening']; ?></td>
                                    <td><?= $pemasukan['keterangan']; ?></td>
                                    <td><?= $pemasukan['nominal']; ?></td>
                                    <td>
                                        <a href="<?= BASEURL; ?>/pemasukan/hapus/<?= $pemasukan['id']; ?>" class="btn btn-danger waves-effect waves-light" onclick="return confirm('Yakin?');">
                                            <span>
                                                Hapus
                                            </span>
                                        </a>
                                        <a href="#" class="getUbah btn btn-primary waves-effect waves-light" data-id="<?= $pemasukan['id']; ?>">
                                            <span>
                                                Ubah
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <br>
</div>
<script>
    $(document).ready(function() {
        $('.data-table-format').DataTable();

        $('.getUbah').on('click', function() {
            const id = $(this).data('id')
            console.log(id);
            $.ajax({
                url: '<?= BASEURL; ?>/pemasukan/getUbah/',
                data: {
                    id: id
                },
                method: 'post',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    $('#id_anggaran').val(data.id);
                    console.log(data.id);
                    $('#tanggal').val(data.tanggal);
                    $('#nominal').val(data.nominal);
                    $('#no_rekening').val(data.no_rekening);
                    $('#keterangan').val(data.keterangan);

                    $(".card-body form").attr('action', '<?= BASEURL; ?>/pemasukan/ubah')
                    $('.card-body form button[type=submit]').html('Ubah Data')
                },
                error: function() {
                    console.log("GAGAL");
                }
            })
        })

    });

    function save_data() {
        if ($('#tanggal').val() == "") {
            $("#message").html(message('gagal', 'diubah atau ditambahkan, Tanggal harus di isi', 'danger','Pemasukan'));
            return

        }
        if ($('#nominal').val() == "") {
            $("#message").html(message('gagal', 'diubah atau ditambahkan, nominal harus di isi', 'danger','Pemasukan'));
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