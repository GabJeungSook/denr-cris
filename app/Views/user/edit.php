<?= $this->extend('user/layout') ?>

<?= $this->section('container') ?>
<div class="container d-lg-flex d-xxl-flex justify-content-lg-center justify-content-xxl-center">
    <div>
        <h1 class="text-center mt-3">Edit User</h1>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <div class="card" style="width: 50rem;">
            <div class="card-body">
                <form action="<?= base_url(); ?> user/edit?id=<?= set_value('UserID'); ?>" method="POST">
                    <input type="hidden" name="UserID" value="<?= set_value('UserID'); ?>">
                    <div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group m-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="LastName" value="<?= set_value('LastName'); ?>">
                                    <p class="text-danger"><?= validation_show_error('LastName') ?></p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group m-3">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" name="FirstName" value="<?= set_value('FirstName'); ?>">
                                    <p class="text-danger"><?= validation_show_error('FirstName') ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          <!--   <div class="col">
                                <div class="form-group m-3">
                                    <label class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" name="MiddleName" value="<?= set_value('MiddleName'); ?>">
                                </div>
                            </div> -->
                            <div class="col">
                                <div class="form-group m-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" name="Username" value="<?= set_value('Username'); ?>">
                                    <p class="text-danger"><?= validation_show_error('Username') ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group m-3"><label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="Password">
                                </div>
                                <p class="text-danger"><?= validation_show_error('Password') ?></p>
                            </div>
                            <div class="col">
                                <div class="form-group m-3"><label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="ConfirmPassword">
                                </div>
                                <p class="text-danger"><?= validation_show_error('ConfirmPassword') ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="d-lg-flex d-xl-flex justify-content-lg-center justify-content-xl-center align-items-xl-center mt-3">
                        <button class="btn btn-primary text-bg-warning m-1" type="submit">Save Changes</button>
                        <a class="btn btn-primary text-bg-danger m-1" href="<?= base_url() ?>user">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>