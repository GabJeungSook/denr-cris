<?= $this->extend('user/layout') ?>

<?= $this->section('container') ?>
<div class="container-fluid d-flex min-vh-100 p-0 justify-content-center align-items-center" style="background-color: #153b24;">

    <!-- Sign Up Section with Logo Above -->
    <div class="signup-container text-white" style="width: 100%; max-width: 400px;">

        <!-- Privacy Consent Modal -->
        <div class="modal fade" id="privacyConsentModal" tabindex="-1" aria-labelledby="privacyConsentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #153b24;">
                        <h5 class="modal-title" id="privacyConsentModalLabel">Data Privacy Consent</h5>
                    </div>
                    <div class="modal-body" style="background-color: #153b24;">
                        <p>By using this service, you agree to our <strong>Data Privacy Policy</strong>. We are committed to protecting your personal data in compliance with the applicable data privacy regulations.</p>
                        <p>Please review the terms of our privacy policy before proceeding with your registration.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cancelConsentBtn">Cancel</button>
                        <button type="button" class="btn btn-success" id="acceptConsentBtn">I Agree</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Welcome Heading -->
        <h1 class="text-center">Sign Up Here</h1>
        <p class="text-center">Create your account</p>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Signup Form (Hidden Initially) -->
        <div id="registrationForm" style="display: none;">
            <form action="<?= base_url(); ?>register" method="POST">

                <!-- First Name Input -->
                <div class="mb-3">
                    <label for="FirstName" class="form-label text-white">First Name <span class="text-danger">*</label>
                    <input type="text" class="form-control" id="FirstName" name="FirstName" placeholder="Enter your first name" value="<?= old('FirstName') ?>" required>
                    <p class="text-danger"><?= validation_show_error('FirstName') ?></p>
                </div>

                <!-- Last Name Input -->
                <div class="mb-3">
                    <label for="LastName" class="form-label text-white">Last Name <span class="text-danger">*</label>
                    <input type="text" class="form-control" id="LastName" name="LastName" placeholder="Enter your last name" value="<?= old('LastName') ?>" required>
                    <p class="text-danger"><?= validation_show_error('LastName') ?></p>
                </div>

                <!-- Contact Number Input -->
                <!-- <div class="mb-3">
                    <label for="ContactNo" class="form-label text-white">Contact No <span class="text-danger">*</label>
                    <input type="text" class="form-control" id="ContactNo" name="ContactNo" placeholder="Enter your contact number" value="<?= old('ContactNo') ?>" required>
                    <p class="text-danger"><?= validation_show_error('ContactNo') ?></p>
                </div> -->
                <!-- Contact Number Input -->
                <div class="mb-3">
                    <label for="ContactNo" class="form-label text-white">Contact No <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="ContactNo" name="ContactNo"
                        placeholder="Enter your contact number"
                        value="<?= old('ContactNo') ?>"
                        pattern="\d{11}" maxlength="11"
                        inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                        title="Contact number must be 11 digits" required>
                    <p class="text-danger"><?= validation_show_error('ContactNo') ?></p>
                </div>
                <!-- Office Dropdown -->
                <div class="mb-3">
                    <label for="OfficeName" class="form-label text-white">Office Name <span class="text-danger">*</span></label>
                    <select class="form-select" id="OfficeName" name="OfficeName" required>
                        <option value="" disabled selected>Select Office Name</option>
                        <!-- Options will be populated dynamically via JavaScript -->
                    </select>
                </div>

                <!-- Hidden Fields -->
                <input type="hidden" class="form-control" id="HeadOfOffice" name="HeadOfOffice" readonly>
                <input type="hidden" class="form-control" id="Position" name="Position" readonly>
                <input type="hidden" class="form-control" id="Address" name="Address" readonly>
                <input type="hidden" class="form-control" id="Telefax" name="Telefax" readonly>
                <input type="hidden" class="form-control" id="EmailAdd" name="EmailAdd" readonly>

                <!-- Username Input -->
                <div class="mb-3">
                    <label for="Username" class="form-label text-white">Username <span class="text-danger">*</label>
                    <input type="text" class="form-control" id="Username" name="Username" placeholder="Choose a username" value="<?= old('Username') ?>" required>
                    <p class="text-danger"><?= validation_show_error('Username') ?></p>
                </div>

                <!-- Password Input -->
                <div class="mb-3">
                    <label for="Password" class="form-label text-white">Password <span class="text-danger">*</label>
                    <input type="password" class="form-control" id="Password" name="Password" placeholder="Create a password" required>
                    <p class="text-danger"><?= validation_show_error('Password') ?></p>
                </div>

                <!-- Confirm Password Input -->
                <div class="mb-3">
                    <label for="ConfirmPassword" class="form-label text-white">Confirm Password <span class="text-danger">*</label>
                    <input type="password" class="form-control" id="ConfirmPassword" name="ConfirmPassword" placeholder="Confirm your password" required>
                    <p class="text-danger"><?= validation_show_error('ConfirmPassword') ?></p>
                </div>
                <hr>
                <!-- Sign Up Button -->
                <button class="btn btn-success w-100 mb-2" type="submit" style="background-color: #28a745; border: none;">Sign Up</button>
                <!-- Already have an account Link -->
                <p class="text-center">Already have an account? <a href="<?= base_url() ?>login" class="text-warning">Log in</a></p>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    // Show the modal on page load
    document.addEventListener("DOMContentLoaded", function() {
        var consentModal = new bootstrap.Modal(document.getElementById('privacyConsentModal'));
        consentModal.show();

        // When user clicks "I Agree", hide modal and show the registration form
        document.getElementById('acceptConsentBtn').addEventListener('click', function() {
            consentModal.hide();
            document.getElementById('registrationForm').style.display = 'block';
        });
        // Redirect to login when "Cancel" is clicked
        document.getElementById('cancelConsentBtn').addEventListener('click', function() {
            window.location.href = "<?= base_url(); ?>login";
        });
    });

    // Fetch and populate the OfficeName dropdown
    document.addEventListener('DOMContentLoaded', function() {
        // Fetch and populate the OfficeName dropdown
        fetch('<?= base_url("user/getOffices") ?>')
            .then(response => response.json()) // Parse JSON response
            .then(data => {
                const officeDropdown = document.getElementById('OfficeName');

                // Clear any existing options
                officeDropdown.innerHTML = '<option value="" disabled selected>Select Office Name</option>';

                // Loop through the returned office data and add them to the dropdown
                data.forEach(office => {
                    const option = document.createElement('option');
                    option.value = office.OfficeName; // Set the value to OfficeName
                    option.textContent = office.OfficeName; // Display OfficeName in the dropdown
                    officeDropdown.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching offices:', error);
                alert('Could not load office names. Please try again later.');
            });

        // Event listener for OfficeName dropdown
        document.getElementById('OfficeName').addEventListener('change', function() {
            const selectedOffice = this.value;

            // Fetch the HeadOfOffice and Position based on the selected OfficeName
            fetch('<?= base_url("user/getOfficeDetails") ?>/' + encodeURIComponent(selectedOffice))
                .then(response => response.json())
                .then(data => {
                    if (!data.error) {
                        // Populate the HeadOfOffice and Position fields
                        document.getElementById('HeadOfOffice').value = data.HeadOfOffice;
                        document.getElementById('Position').value = data.Position;
                        document.getElementById('Address').value = data.Address;
                        document.getElementById('Telefax').value = data.Telefax;
                        document.getElementById('EmailAdd').value = data.EmailAdd;
                    } else {
                        alert('Office details not found');
                    }
                })
                .catch(error => {
                    console.error('Error fetching office details:', error);
                    alert('Could not fetch office details.');
                });
        });
    });
</script>

<?= $this->endSection() ?>