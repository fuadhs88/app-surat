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

        <div class="row">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">Data User</p>
                        <div class="table-responsive">
                            <table id="user" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Level</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($list_user as $user) : ?>
                                        <tr>
                                            <td width="50px"><?= $i++; ?></td>
                                            <td><?= $user->nama; ?></td>
                                            <td><?= $user->email; ?></td>
                                            <td>
                                                <?php
                                                    if ($user->blokir == 'N') {
                                                        echo "<span class='badge badge-success'>Active</span>";
                                                    } else if ($user->blokir == 'Y') {
                                                        echo "<span class='badge badge-danger'>Not Active </span>";
                                                        ?>
                                                <?php
                                                    }
                                                    ?>
                                            </td>
                                            <td><?= $user->level; ?></td>
                                            <td>
                                                <form action="<?= base_url('Data_user/delete'); ?>" method="post">
                                                    <a href="<?= site_url('Data_user/update/' . $user->id); ?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                                    |
                                                    <input type="hidden" name="id" value="<?= $user->id; ?>">
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