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

    <div class="row container-fluid">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title"></h4>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="month" value="" id="month_data" name="month_data">
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-primary waves-effect waves-light setByMonth" type="button" data-toggle="modal" data-target="#dataModal"> search </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-10">
        <div class="card" style="display: none;" id="card-tabel-summary">
            <div class="card-body">
                <hr>
                <div class="row">
                    <label for="example-text-input" class="col-sm-3 col-form-label">SKPD</label>
                    <label for="example-text-input" class="col-sm-7 col-form-label">: DINAS KOPERASI DAN UMKM KABUPATEN KARAWANG</label>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-sm-3 col-form-label">Pengguna Anggaran (PA)</label>
                    <label for="example-text-input" class="col-sm-2 col-form-label">: <?= $data['nama_KPA']['nama_pegawai'] ?></label>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-sm-3 col-form-label">Bendahara (Penerimaan/Pengeluaran)</label>
                    <label for="example-text-input" class="col-sm-2 col-form-label">: <?= $data['nama_Bendahara']['nama_pegawai'] ?></label>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-sm-3 col-form-label">Bendahara Pembantu</label>
                    <label for="example-text-input" class="col-sm-2 col-form-label">: - </label>
                </div>
                <!--  <div class="row">
                    <label for="example-text-input" class="col-sm-3 col-form-label">Kegiatan</label>
                    <label for="example-text-input" class="col-sm-3 col-form-label">: </label>
                </div> -->
                <div class="row">
                    <label for="example-text-input" class="col-sm-3 col-form-label">Bulan</label>
                    <label for="example-text-input" class="col-sm-2 col-form-label">: <span id="bulan_search"></span></label>
                </div>
                <hr>
                <table class="table table-bordered data-table-format">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>No Rekening</th>
                            <th>Nama Kegiatan</th>
                            <th>Uraian</th>
                            <th>Debit</th>
                            <th>Kredit</th>
                        </tr>
                    </thead>
                    <tbody id="summaryResult">

                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5">Jumlah Bulan Ini</th>
                            <th><span id="total-pemasukan-bulan-ini"></span></th>
                            <th><span id="total-pengeluaran-bulan-ini"></span></th>
                        </tr>
                        <tr>
                            <th colspan="5">Jumlah s/d Bulan Lalu</th>
                            <th><span id="total-pemasukan-sampai-bulan-lalu"></th>
                            <th><span id="total-pengeluaran-sampai-bulan-lalu"></th>
                        </tr>
                        <tr>
                            <th colspan="5">Jumlah s/d Bulan Ini</th>
                            <th><span id="total-pemasukan-keseluruhan"></th>
                            <th><span id="total-pengeluaran-keseluruhan"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <a href="#" class="print_data col-sm-1 col-form-label btn btn-success" id="" onclick="func_print_pdf();" style="display: none;"> Print</a>
            </div>
        </div>
        <br>

    </div>
    <br>

</div>

<script>
    $(document).ready(function() {

        $('.setByMonth').on('click', function() {

            $.ajax({
                url: '<?= BASEURL; ?>/laporan/getDataByMonth',
                data: {
                    month: $('#month_data').val()
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
                success: function(result) {
                    console.log(result)
                    data_load = ''
                    num = 0;
                    if (result.length != 0) {
                        console.log(result.anggaran.length);
                        if (result.anggaran.length != 0) {
                            for (let i = 0; i < result.anggaran.length; i++) {
                                element_data = result.anggaran[i];
                                num++
                                data_load += '<tr>'
                                data_load += '    <td>' + num + '</td>'
                                data_load += '    <td>' + element_data.tanggal + '</td>'
                                data_load += '    <td>' + element_data.no_rekening_result + '</td>'
                                data_load += '    <td>' + element_data.nama_kegiatan_result + '</td>'
                                data_load += '    <td>' + element_data.keterangan + '</td>'
                                data_load += '    <td>' + numberWithCommas(element_data.debit) + '</td>'
                                data_load += '    <td>' + numberWithCommas(element_data.kredit) + '</td>'
                                data_load += '</tr>'
                            }
                        } else {
                            data_load += '<tr>'
                            data_load += '    <td> - </td>'
                            data_load += '    <td> - </td>'
                            data_load += '    <td> - </td>'
                            data_load += '    <td> - </td>'
                            data_load += '    <td> - </td>'
                            data_load += '    <td> - </td>'
                            data_load += '    <td> - </td>'
                            data_load += '    <td> - </td>'
                            data_load += '    <td> - </td>'
                            data_load += '</tr>'
                        }
                        pemasukanBulanIni = result.totalPemasukanBulanIni.totalAnggaran
                        pengeluaranBulanIni = result.totalPengeluaranBulanIni.totalAnggaran
                        totalSaldobulanIni = parseInt(pemasukanBulanIni) - parseInt(pengeluaranBulanIni)
                        $('#total-pemasukan-bulan-ini').html(numberWithCommas(pemasukanBulanIni))
                        $('#total-pengeluaran-bulan-ini').html(numberWithCommas(pengeluaranBulanIni))

                        pemasukanSampaiBulanLalu = result.totalPemasukanSampaiBulanLalu.totalAnggaran
                        pengeluaranSampaiBulanLalu = result.totalPengeluaranSampaiBulanLalu.totalAnggaran
                        totalSaldoBulanLau = parseInt(pemasukanSampaiBulanLalu) - parseInt(pengeluaranSampaiBulanLalu)
                        $('#total-pemasukan-sampai-bulan-lalu').html(numberWithCommas(pemasukanSampaiBulanLalu))
                        $('#total-pengeluaran-sampai-bulan-lalu').html(numberWithCommas(pemasukanSampaiBulanLalu))

                        totalPemasukanKeseluruhan = parseInt(pemasukanBulanIni) + parseInt(pemasukanSampaiBulanLalu)
                        totalPengeluranKeseluruhan = parseInt(pengeluaranBulanIni) + parseInt(pengeluaranSampaiBulanLalu)
                        totalSaldoKeseluruhan = parseInt(totalPemasukanKeseluruhan) - parseInt(totalPengeluranKeseluruhan)
                        $('#total-pemasukan-keseluruhan').html(numberWithCommas(totalPemasukanKeseluruhan))
                        $('#total-pengeluaran-keseluruhan').html(numberWithCommas(totalPengeluranKeseluruhan))

                        $('#summaryResult').html(data_load)
                        $('#bulan_search').html(convertMonth($('#month_data').val()))
                        $('#card-tabel-summary').show()
                        $('.print_data').show()
                    }
                },
                error: function(data) {
                    console.log("ERROR");
                    console.log(data);
                }
            })
        });
    });

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function func_print_pdf() {
        const month = $('#month_data').val();
        if (month == "") {
            alert("data Kosong ");
        } else {
            var loaction_url = "<?= BASEURL; ?>/laporan/printLaporanpdf/" + month
            window.open(loaction_url)
        }

    }

    function convertMonth(month) {
        monthArr = month.split("-");
        const months = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Augustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ]

        return months[parseInt(monthArr[1] - 1)] + " " + monthArr[0]
    }
</script>