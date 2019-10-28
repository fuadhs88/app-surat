<div class="main-panel">
    <div class="content-wrapper">

        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between flex-wrap">
                    <div class="d-flex align-items-end flex-wrap">
                        <div class="d-flex">
                            <i class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Data Surat Keluar&nbsp;&nbsp;</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?= $this->session->flashdata('message'); ?>

        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-10 mx-auto grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">FORM TAMBAH SURAT</h4>
                            <form class="forms-sample" action="<?= base_url('Surat_Keluar/create_action') ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-3 col-form-label">Nama Surat</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nama_surat" name="nama_surat" placeholder="Nama Surat">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-3 col-form-label">Jenis Surat</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="tipe" name="tipe">
                                            <option>Pilih Salah Satu</option>
                                            <?php foreach ($surat as $row) :  ?>
                                                <option value="<?= $row->id ?>"><?= $row->nama_surat ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleFormControlFile1" class="col-sm-3 col-form-label">Upload Dokument</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control-file" name="surat" id="surat">
                                        <small>Max Ukuran File 2 MB</small>
                                    </div>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary mr-2">Tambah</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>