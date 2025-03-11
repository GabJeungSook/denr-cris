<?= $this->extend('user/layout') ?>

<?= $this->section('container') ?>
<div class="container-fluid d-flex min-vh-100 p-0 justify-content-center align-items-center" style="background-color: #153b24;">

    <!-- Login Section with Logo Above -->
    <div class="login-container text-white" style="width: 100%; max-width: 400px;">

        <!-- Welcome Heading -->
        <h1 class="text-center">Welcome</h1>
        <p class="text-center">Please Log in</p>

        <!-- Error Message -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="<?= base_url(); ?>login" method="POST">

            <!-- Username Input -->
            <div class="form-group mb-3">
                <label class="form-label text-white">Username</label>
                <input type="text" class="form-control" name="Username" placeholder="Enter your username" value="<?= old('Username') ?>">
                <?php if (isset($validation)): ?>
                    <p class="text-danger"><?= $validation->getError('Username') ?></p>
                <?php endif; ?>
            </div>

            <!-- Password Input with Show/Hide Toggle -->
            <div class="form-group mb-3">
                <label class="form-label text-white">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="Password" placeholder="Enter your password">
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" style="background-color: white; width: 40px; text-align: center;">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>
                <?php if (isset($validation)): ?>
                    <p class="text-danger"><?= $validation->getError('Password') ?></p>
                <?php endif; ?>
            </div>

            <!-- Remember Me and Forgot Password -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <input type="checkbox" name="remember"> <label>Remember Me</label>
                </div>
                <div>
                    <a href="<?= base_url() ?>forgotpassword" class="text-white">Forgot Your Password?</a>
                </div>
            </div>

            <!-- Login Button -->
            <button class="btn btn-success w-100 mb-2" type="submit" style="background-color: #28a745; border: none;">Login</button>

            <!-- Sign Up Link -->
            <p class="text-center">Don't have an account? <a href="<?= base_url() ?>register" class="text-warning">Sign Up</a></p>
        </form>
    </div>
</div>

<!-- JavaScript for Show/Hide Password -->
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function(e) {
        // Toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        // Toggle the eye icon
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
</script>

<?= $this->endSection() ?>