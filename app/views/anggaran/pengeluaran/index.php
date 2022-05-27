<?php
$dataKegiatan       = $data['kegiatan'];
?>
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
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title"></h4>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Nama Kegiatan</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="text" value="" id="nama_kegiatan" placeholder="nama kegiatan" readonly>
                            <input class="form-control" type="hidden" value="" id="nama_kegiatan_hide" name="nama_kegiatan">
                            <input class="form-control" type="hidden" value="" id="id_kegiatan">
                            <input class="form-control" type="hidden" value="" id="tanggal_kegiatan">
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-primary waves-effect waves-light" type="button" data-toggle="modal" data-target="#dataModal"> search </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row container-fluid" id="cardAnggaran" style="display: none;">
        <div class="col-lg">
            <div id="message"></div>
            <div class="card">
                <div class="card-body">
                    <div class="col-sm-2">
                        <button class="btn btn-success waves-effect waves-light" id="button_tambah" onclick="tambahDataElement('0')" type="button"> Tambah Data </button>
                    </div>
                    <br>
                    <table class="table table-bordered data-table-format" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nomor Rekening</th>
                                <th>Uraian</th>
                                <th>Kredit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <!-- <tbody> -->
                        <tbody id="resultAnggaran">

                        </tbody>
                        <tbody id="resultAnggaranEmpty">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row d-flex justify-content-start formSubmitData" style="display: none;" id="formSubmitData"></div>
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
                <table class="table table-bordered data-table-format" width="100%">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Tanggal</th>
                            <th>Nama Kegiatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($dataKegiatan as $data) : ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $data['tanggal']; ?></td>
                                <td>
                                    <a href="#" class="getNamaKegiatan" data-kegiatan="<?= $data['nama_kegiatan']; ?>" data-id="<?= $data['id']; ?>" data-tanggal="<?= $data['tanggal']; ?>" data-status="<?= $data['status']; ?>" data-dismiss="modal">
                                        <span>
                                            <?= $data['nama_kegiatan']; ?>
                                        </span>
                                    </a>

                                </td>
                            </tr>
                        <?php
                            $no++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.getNamaKegiatan').on('click', function() {
            const kegiatan = $(this).data('kegiatan');
            const id = $(this).data('id');
            const tanggal = $(this).data('tanggal');
            const status = $(this).data('status');

            $("#nama_kegiatan").val(kegiatan);
            $("#nama_kegiatan_hide").val(kegiatan);
            $("#id_kegiatan").val(id);
            $("#tanggal_kegiatan").val(tanggal);
            $("#tanggal_table_anggaran").html(tanggal);

            reloadTabelAnggaran(id);

            if (status != 0) {
                $("#form-anggaran").hide();
                $(".generate-status").hide();
            } else {
                $("#form-anggaran").show();
                $(".generate-status").show();
            }

            $("#cardAnggaran").show();
        })
    });

    function reloadTabelAnggaran(id) {
        $.ajax({
            url: '<?= BASEURL; ?>/pengeluaran/getByKegitanAnggaran',
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
                var data_load = '';
                num = 0;
                console.log(data);
                if (data.length != 0) {

                    for (let index = 0; index < data.length; index++) {
                        num++;
                        const element = data[index];
                        var inner_data = "save_" + index;
                        var function_save = "saveDataElement('" + inner_data + "')";
                        var function_connfirmation = "hapusData(" + element.id + ");"
                        data_load += '<tr>'
                        data_load += '    <td><input class="form-control" value="' + element.id + '" type="hidden" name="id" id="" >' + num + '</td>'
                        data_load += '    <td class="dataInput"><input class="form-control" value="' + element.tanggal + '" type="date" name="tanggal" id="" placeholder="tanggal" readonly="readonly"></td>'
                        data_load += '    <td class="dataInput"><input class="form-control" value="' + element.no_rekening + '" type="text" name="no_rekening" id="" placeholder="nomor rekening"></td>'
                        data_load += '    <td class="dataInput"><input class="form-control" value="' + element.keterangan + '" type="text" name="keterangan" id="" placeholder="keterangan" required ></td>'
                        data_load += '    <td class="dataInput"><input class="form-control" value="' + element.nominal + '" type="number" name="nominal" id="" placeholder="nominal" required ></td>'
                        data_load += '    <td class="dataInput">'
                        data_load += '          <button class="getHapus btn btn-danger waves-effect waves-light" data-id="' + element.id + '" onclick="' + function_connfirmation + '"><span>Hapus</span></button>'
                        data_load += '          <button class="save btn btn-primary waves-effect waves-light" id="' + inner_data + '" onclick="' + function_save + '">Simpan</button>'
                        data_load += '    </td>'
                        data_load += '</tr>'
                    }
                }

                $('#resultAnggaran').html(data_load);
            },
            error: function() {
                console.log("ERROR");
            }
        });
    }

    function hapusData(id) {
        let isExecuted = confirm("Yakin?");
        console.log(isExecuted);
        if (isExecuted) {
            $.ajax({
                url: '<?= BASEURL ?>/pengeluaran/hapus',
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
                    if (data > 0) {
                        $("#message").html(message('berhasil', 'dihapus', 'success', 'pengeluaran'));
                    } else {
                        $("#message").html(message('gagal', 'dihapus', 'danger', 'pengeluaran'));
                    }
                    reloadTabelAnggaran($("#id_kegiatan").val());

                },
                error: function(data) {
                    console.log("GAGAL");
                }
            })
        }
    }

    function saveDataElement(id) {
        var data_id = document.getElementById(id).parentElement.parentElement;
        // console.log(data);
        const dataLength = document.getElementById(id).parentElement.parentElement.firstChild;
        const dataLength1 = document.getElementById(id).parentElement.parentElement.childNodes;
        isEdit = false;
        var form_costume = document.createElement("form");
        form_costume.setAttribute("id", "insert-pengeluaran");
        form_costume.setAttribute("method", "post");

        for (let i = 0; i < dataLength1.length; i++) {
            const element = dataLength1[i];
            if (element.children != undefined) {
                if (element.children.length != 0) {

                    for (let j = 0; j < element.children.length; j++) {
                        const element01 = element.children[j];
                        if (element01.tagName == "INPUT") {
                            element01_name = element01.name;
                            element01_value = element01.value;
                            console.log("element name :: => " + element01_name + "   ||| element_value :: => " + element01_value);

                            var inp = document.createElement('input')
                            inp.setAttribute('type', 'text');
                            inp.setAttribute('name', element01_name)
                            inp.setAttribute('value', element01_value)
                            form_costume.append(inp)
                            if ((element01_name == 'id') && (parseInt(element01_value) > 0)) {
                                isEdit = true;
                            }
                            if (!validationData(element01_name, element01_value)) return;
                        }
                    }
                }
            }
        }

        if (!isEdit) {
            url_send_data = "<?= BASEURL ?>/pengeluaran/tambah";
        } else {
            url_send_data = "<?= BASEURL ?>/pengeluaran/ubah";
        }
        // form_costume.setAttribute("action", url_send_data);
        console.log(url_send_data);

        var inp = document.createElement('input')
        inp.setAttribute('type', 'text');
        inp.setAttribute('name', 'id_kegiatan')
        inp.setAttribute('value', $("#id_kegiatan").val())
        form_costume.append(inp)

        $('#formSubmitData').append(form_costume)

        $.ajax({
            url: url_send_data,
            data: $('#insert-pengeluaran').serialize(),
            method: 'post',
            beforeSend: function() {
                $.blockUI({
                    message: null,
                });
            },
            complete: function() {
                $.unblockUI();
            },
            success: function(result) {
                $("#message").html(message('sukses', 'diubah atau ditambahkan', 'success', 'pemasukan'));
                $('#insert-pengeluaran').remove();
                data_id.remove();
                reloadTabelAnggaran($("#id_kegiatan").val());
            },
            error: function() {
                console.log("GAGAL");
            }
        });

    }

    function removeElement(id) {
        var data_id = document.getElementById(id).parentElement.parentElement;
        data_id.remove();
        $("#message").html(message('berhasil', 'dihapus', 'success', 'pengeluaran'));
    }

    function validationData(elementName, elementValue) {
        if (elementName == 'keterangan' && elementValue == '') {
            $("#message").html(message('gagal', 'diubah atau ditambahkan, Keterangan harus di isi', 'danger', 'pengeluaran'));
            return false;

        } else if (elementName == 'nominal' && (elementValue == '' || elementValue < 1)) {
            $("#message").html(message('gagal', 'diubah atau ditambahkan, Kredit harus di isi', 'danger', 'pengeluaran'));
            return false;

        } else {
            return true;
        }
    }

    function tambahDataElement(id) {
        id = parseInt(id) + 1
        var inner_data = "tambah_" + id;
        var function_save = "saveDataElement('" + inner_data + "')";
        var function_remove = "removeElement('" + inner_data + "')";
        var data_load = '';
        data_load += '<tr>'
        data_load += '    <td bgcolor="SteelBlue"><input class="form-control" value="0" type="hidden" name="id" id="" placeholder="tanggal"></td>'
        data_load += '    <td class="dataInput"><input class="form-control" value="' + $("#tanggal_kegiatan").val() + '" type="date" name="tanggal" id="" placeholder="tanggal" readonly="readonly"></td>'
        data_load += '    <td class="dataInput"><input class="form-control" value="" type="text" name="no_rekening" id="" placeholder="nomor rekening"></td>'
        data_load += '    <td class="dataInput"><input class="form-control" value="" type="text" name="keterangan" id="" placeholder="keterangan" required></td>'
        data_load += '    <td class="dataInput"><input class="form-control" value="" type="number" name="nominal" id="" placeholder="nominal" required></td>'
        data_load += '    <td class="dataInput">'
        data_load += '          <button class="btn btn-danger waves-effect waves-light"  onclick="' + function_remove + '"><span>Hapus</span></button>'
        data_load += '          <button class="save btn btn-primary waves-effect waves-light" id="' + inner_data + '" onclick="' + function_save + '">Simpan</button>'
        data_load += '    </td>'
        data_load += '</tr>'
        $('#button_tambah').attr('onclick', "tambahDataElement('" + id + "')");
        $('#resultAnggaranEmpty').append(data_load);
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