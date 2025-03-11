<?= $this->extend('user/layout') ?>

<?= $this->section('container') ?>
<div class="container-fluid d-flex min-vh-100 p-0 justify-content-center align-items-center" style="background-color: #153b24;">
    <div class="login-container text-white" style="width: 100%; max-width: 400px;">
        <h1 class="text-center">Verify OTP</h1>
        <p class="text-center">Enter the OTP sent to your mobile number.</p>

        <!-- Error Message -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url(); ?>/verifyOTPU" method="POST">
            <!-- Hidden ContactNo Field -->
            <input type="hidden" name="ContactNo" value="<?= esc($contactNo); ?>">

            <!-- OTP Input -->
            <div class="form-group mb-3">
                <label class="form-label text-white">OTP</label>
                <input type="text" class="form-control" name="OTP" placeholder="Enter OTP" required>
            </div>

            <!-- Submit Button -->
            <button class="btn btn-success w-100 mb-2" type="submit" style="background-color: #28a745; border: none;">Verify OTP</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
