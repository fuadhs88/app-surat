<div class="main-panel">
    <div class="content-wrapper">

        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between flex-wrap">
                    <div class="d-flex align-items-end flex-wrap">
                        <div class="d-flex">
                            <i class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Data Surat&nbsp;&nbsp;</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?= $this->session->flashdata('message'); ?>

        <div class="row">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">Data Surat</p>
                        <a href="<?= base_url('User/create'); ?>" class="btn btn-primary btn-sm">Tambah Data</a>
                        <br>
                        <br>
                        <div class="table-responsive">
                            <table id="user" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Surat</th>
                                        <th>File Surat</th>
                                        <th>Keterangan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($surat as $surat2) : ?>
                                        <tr>
                                            <td width="50px"><?= $i++; ?></td>
                                            <td><?= $surat2->nama_surat; ?></td>
                                            <td>
                                                <a href="<?= base_url('surat_user/' . $surat2->filename . '.pdf'); ?>" target="_BLANK">View Surat</a>
                                            </td>
                                            <td><?= $surat2->keterangan; ?></td>
                                            <td>
                                                <form action="<?= base_url('User/delete'); ?>" method="post">
                                                    <a href="<?= site_url('User/update/' . $surat2->id); ?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                                    |
                                                    <input type="hidden" name="id" value="<?= $surat2->id; ?>">
                                                    <button onclick="return confirm('Apakah Anda Yakin?')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                                </form>
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
    </div>