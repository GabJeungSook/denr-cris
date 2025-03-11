<?= $this->extend('user/layout') ?>

<?= $this->section('container') ?>
<div class="container-fluid d-flex min-vh-100 p-0 justify-content-center align-items-center" style="background-color: #153b24;">
    <div class="login-container text-white" style="width: 100%; max-width: 400px;">
        <h1 class="text-center">Reset Password</h1>
        <p class="text-center">Enter your new password below.</p>

        <!-- Error Message -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <!-- Success Message -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success'); ?>
            </div>
        <?php endif; ?>

        <!-- Reset Password Form -->
        <form action="<?= base_url(); ?>/updatePassword" method="POST">
            <!-- Hidden ContactNo Field -->
            <input type="hidden" name="ContactNo" value="<?= esc($contactNo); ?>">

            <!-- New Password Input -->
            <div class="form-group mb-3">
                <label class="form-label text-white">New Password</label>
                <input type="password" class="form-control" name="NewPassword" placeholder="Enter new password" required minlength="6" maxlength="10">
            </div>

            <!-- Confirm Password Input -->
            <div class="form-group mb-3">
                <label class="form-label text-white">Confirm Password</label>
                <input type="password" class="form-control" name="ConfirmPassword" placeholder="Confirm new password" required minlength="6" maxlength="10">
            </div>

            <!-- Submit Button -->
            <button class="btn btn-success w-100 mb-2" type="submit" style="background-color: #28a745; border: none;">Reset Password</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
