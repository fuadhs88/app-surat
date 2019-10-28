<div class="main-panel">
    <div class="content-wrapper">

        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between flex-wrap">
                    <div class="d-flex align-items-end flex-wrap">
                        <div class="d-flex">
                            <i class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Data User&nbsp;&nbsp;</p>
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
                            <h4 class="card-title">FORM EDIT USER</h4>
                            <form class="forms-sample" action="<?= base_url('Data_user/update_action') ?>" method="post">
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-3 col-form-label">ID</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="id" name="id" value="<?= $id; ?>" placeholder="Id" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nama" name="nama" value="<?= $nama; ?>" placeholder="Nama">
                                    </div>
                                </div>
                                <?php
                                $admin = ($level == "Admin") ? "selected" : "";
                                $user = ($level == "User") ? "selected" : "";
                                ?>
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-3 col-form-label">Level</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="level" name="level">
                                            <option>Pilih Salah Satu</option>
                                            <option value="Admin" <?= $admin; ?>>Admin</option>
                                            <option value="User" <?= $user; ?>>User</option>
                                        </select>
                                    </div>
                                </div>
                                <?php
                                $n = ($blokir == "N") ? "selected" : "";
                                $y = ($blokir == "Y") ? "selected" : "";
                                ?>
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-3 col-form-label">Status</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="blokir" name="blokir">
                                            <option>Pilih Salah Satu</option>
                                            <option value="N" <?= $n; ?>>Active</option>
                                            <option value="Y" <?= $y; ?>>Not Active</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mr-2">Ubah</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>