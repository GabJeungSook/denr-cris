<?= $this->extend('user/layout') ?>

<?= $this->section('container') ?>
<div class="container-fluid d-flex min-vh-100 p-0 justify-content-center align-items-center" style="background-color: #153b24;">
    <div class="login-container text-white" style="width: 100%; max-width: 400px;">
        <h1 class="text-center">Forgot Password</h1>
        <p class="text-center">Enter your Last Name and Contact Number</p>

        <!-- Error Message -->
        <div id="error-message" class="alert alert-danger d-none"></div>

        <!-- Success Message -->
        <div id="success-message" class="alert alert-success d-none"></div>

        <!-- Forgot Password Form -->
        <form id="forgotPasswordForm">
            <!-- Last Name Input -->
            <div class="form-group mb-3">
                <label class="form-label text-white">Last Name</label>
                <input type="text" class="form-control" id="LastName" placeholder="Enter your Last Name">
            </div>

            <!-- Contact Number Input -->
            <!--  <div class="form-group mb-3">
                <label class="form-label text-white">Contact Number</label>
                <input type="text" class="form-control" id="ContactNo" placeholder="Enter your Contact Number">
            </div> -->
            <div class="form-group mb-3">
                <label class="form-label text-white">Contact Number</label>
                <input type="text" class="form-control" id="ContactNo"
                    placeholder="Enter your Contact Number"
                    pattern="\d{11}" maxlength="11"
                    inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                    title="Contact number must be 11 digits" required>
            </div>

            <!-- Submit Button -->
            <button type="button" id="sendOtpButton" class="btn btn-success w-100 mb-2" style="background-color: #28a745; border: none;">Send OTP</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('sendOtpButton').addEventListener('click', function() {
        const lastName = document.getElementById('LastName').value;
        const contactNo = document.getElementById('ContactNo').value;

        // Clear previous messages
        const errorMessage = document.getElementById('error-message');
        const successMessage = document.getElementById('success-message');
        errorMessage.classList.add('d-none');
        successMessage.classList.add('d-none');

        // Validate inputs
        if (!lastName || !contactNo) {
            errorMessage.innerHTML = 'Both Last Name and Contact Number are required.';
            errorMessage.classList.remove('d-none');
            return;
        }

        // Send OTP request
        fetch('<?= base_url(); ?>/sendOTP', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    LastName: lastName,
                    ContactNo: contactNo
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message and redirect to Verify OTP page with ContactNo
                    successMessage.innerHTML = data.message;
                    successMessage.classList.remove('d-none');
                    setTimeout(() => {
                        window.location.href = `<?= base_url(); ?>/verify_otp?contactNo=${data.contactNo}`;
                    }, 2000);
                } else {
                    // Show error message
                    errorMessage.innerHTML = data.message;
                    errorMessage.classList.remove('d-none');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorMessage.innerHTML = 'An error occurred. Please try again.';
                errorMessage.classList.remove('d-none');
            });
    });
</script>
<?= $this->endSection() ?>