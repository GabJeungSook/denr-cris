<?= $this->extend('user/layout') ?>

<?= $this->section('container') ?>
<div class="container d-lg-flex d-xxl-flex justify-content-lg-center justify-content-xxl-center">
    <div>
        <h1 class="text-center mt-3">Delete User</h1>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <div class="card" style="width: 50rem;">
            <div class="card-body">
                <form action="<?= base_url(); ?> user/delete?id=<?= set_value('UserID'); ?>" method="POST">
                    <input type="hidden" name="UserID" value="<?= set_value('UserID'); ?>">
                    <div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group m-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="LastName" value="<?= set_value('LastName'); ?>" readonly>
                                    <p class="text-danger"><?= validation_show_error('LastName') ?></p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group m-3">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" name="FirstName" value="<?= set_value('FirstName'); ?>" readonly>
                                    <p class="text-danger"><?= validation_show_error('FirstName') ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group m-3">
                                    <label class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" name="MiddleName" value="<?= set_value('MiddleName'); ?>" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group m-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" name="Username" value="<?= set_value('Username'); ?>" readonly>
                                    <p class="text-danger"><?= validation_show_error('Username') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-lg-flex d-xl-flex justify-content-lg-center justify-content-xl-center align-items-xl-center mt-3">
                        <p class="text-danger">Do you want to delete this user?</p>
                        <button class="btn btn-primary text-bg-success m-1" type="submit">Yes</button>
                        <a class="btn btn-primary text-bg-danger m-1" href="<?= base_url() ?>user">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>