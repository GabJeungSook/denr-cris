<?= $this->extend('user/layout') ?>

<?= $this->section('container') ?>
<div class="container-fluid">
    <div class="row">

        <!-- Sidebar Navigation -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar collapse" style="background-color: #153b24;">
            <div class="position-sticky pt-3">
                <!-- Logo -->
                <div class="text-center mb-6">
                    <img src="<?= base_url('public/assets/images/logo3.png') ?>" alt="Logo" class="img-fluid" style="width: 200px;">
                </div>

                <!-- Retrieve UserRole -->
                <?php
                $userRole = session()->get('userData')['UserRole'] ?? '';
                ?>

                <!-- Sidebar Navigation -->
                <ul class="nav flex-column">
                    <!-- Dashboard -->
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="<?= base_url(); ?>dashboard">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>

                    <?php if ($userRole === 'System Administrator') : ?>
                        <!-- System Administrator -->
                        <li class="nav-item mb-2">
                            <a class="nav-link text-white" href="<?= base_url(); ?>user">
                                <i class="fas fa-users"></i> Manage User
                            </a>
                        </li>

                    <?php elseif ($userRole === 'RPS Chief') : ?>
                        <!-- RPSChief -->
                        <li class="nav-item mb-2">
                            <a class="nav-link text-white" href="<?= base_url(); ?>confirmation">
                                <i class="fas fa-check-circle"></i> Confirmation
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link text-white" href="<?= base_url(); ?>releasing">
                                <i class="fas fa-share-square"></i> Releasing
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link text-white" href="<?= base_url(); ?>print">
                                <i class="fas fa-print"></i> Print COR
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link text-white" href="<?= base_url(); ?>reports">
                                <i class="fas fa-file-alt"></i> Reports
                            </a>
                        </li>

                        <?php elseif ($userRole === 'Cashier') : ?>
                        <!-- Cashier -->
                        <li class="nav-item mb-2">
                            <a class="nav-link text-white" href="<?= base_url(); ?>printCashier">
                                <i class="fas fa-print"></i> Print OC
                            </a>
                        </li>

                    <?php elseif ($userRole === 'Patroller') : ?>
                        <!-- Patroller -->
                        <!-- Only Dashboard is shown -->

                    <?php elseif ($userRole === 'Client') : ?>
                        <!-- Client -->
                        <li class="nav-item mb-2">
                            <a class="nav-link text-white" href="#" data-bs-toggle="modal" data-bs-target="#registrationModal">
                                <i class="fas fa-user-plus"></i> Registration
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link text-white" href="#" data-bs-toggle="modal" data-bs-target="#paymentModal">
                                <i class="fas fa-credit-card"></i> Payment
                            </a>
                        </li>

                    <?php else : ?>
                        <!-- Default UserRole (e.g., Admin, Manager, etc.) -->
                        <li class="nav-item mb-2">
                            <a class="nav-link text-white" href="<?= base_url(); ?>user">
                                <i class="fas fa-users"></i> Manage User
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link text-white" href="#" data-bs-toggle="modal" data-bs-target="#registrationModal">
                                <i class="fas fa-user-plus"></i> Registration
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link text-white" href="#" data-bs-toggle="modal" data-bs-target="#paymentModal">
                                <i class="fas fa-credit-card"></i> Payment
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link text-white" href="<?= base_url(); ?>confirmation">
                                <i class="fas fa-check-circle"></i> Confirmation
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link text-white" href="<?= base_url(); ?>releasing">
                                <i class="fas fa-share-square"></i> Releasing
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link text-white" href="<?= base_url(); ?>print">
                                <i class="fas fa-print"></i> Print COR/OC
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link text-white" href="<?= base_url(); ?>reports">
                                <i class="fas fa-file-alt"></i> Reports
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>


        <!-- Toggle Sidebar Button for Mobile -->
        <button class="btn btn-primary d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-expanded="false" aria-controls="sidebar">
            <i class="fas fa-bars"></i> Menu
        </button>


        <!-- Main Dashboard Content -->
        <div class="col-md-10">
            <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #153b24; margin-bottom: 1rem;">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Welcome <?= session()->get('userData')['FirstName']; ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url(); ?>logout">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Dashboard Statistics Section -->
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card text-dark bg-warning mb-3" id="pendingCard">
                        <div class="card-body text-center">
                            <h5 class="card-title">Pending</h5>
                            <p class="card-text">
                                <strong id="pendingCount"><?= $pendingCount; ?></strong> item/s
                            </p>
                            <a href="#" class="btn btn-dark">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3" id="confirmedForPaymentCard">
                        <div class="card-body text-center">
                            <h5 class="card-title">Confirmed</h5>
                            <p class="card-text">
                                <strong id="confirmedForPaymentCount"><?= $confirmedForPaymentCount; ?></strong> item/s
                            </p>
                            <a href="#" class="btn btn-light">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3" id="confirmedPaidCard">
                        <div class="card-body text-center">
                            <h5 class="card-title">Paid</h5>
                            <p class="card-text">
                                <strong id="confirmedPaidCount"><?= $confirmedPaidCount; ?></strong> item/s
                            </p>
                            <a href="#" class="btn btn-light">View Details</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-white bg-secondary mb-3" id="releasedCard">
                        <div class="card-body text-center">
                            <h5 class="card-title">Released</h5>
                            <p class="card-text">
                                <strong id="releasedCount"><?= $releasedCount; ?></strong> item/s
                            </p>
                            <a href="#" class="btn btn-light">View Details</a>
                        </div>
                    </div>
                </div>
                <!-- First Chart: Statistics by Office -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Transactions per Office</h5>
                            <canvas id="officeStatisticsChart" width="400" height="340"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Second Chart: Released Clients (2024-2030) -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Released Clients (2024-2030)</h5>
                            <div style="display: flex; justify-content: center; align-items: center; height: 625px; width: 640px;">
                                <canvas id="releasedClientsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Client Details Modal -->
    <div class="modal fade" id="clientDetailsModal" tabindex="-1" aria-labelledby="clientDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clientDetailsModalLabel">Client Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Registration No</th>
                                <th>Full Name</th>
                                <th>Contact No</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>Status</th>
                                <th>Payment Status</th>
                            </tr>
                        </thead>
                        <tbody id="clientDetailsTable">
                            <!-- Client data will be dynamically populated here -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Registration -->
    <div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registrationModalLabel">Client Registration Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="registrationForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <!-- Registration Type Dropdown (Moved Here) -->
                            <div class="mb-3">
                                <label for="RegsType" class="form-label">Type of Transaction <span class="text-danger">*</label>
                                <select class="form-select" id="RegsType" name="RegsType" required>
                                    <option value="" disabled selected>Select type of transaction</option>
                                    <option value="New">New Registration</option>
                                    <option value="Old">Renewal</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <!-- Full Name -->
                                <div class="mb-3">
                                    <label for="Fullname" class="form-label">Full Name <span class="text-danger">*</label>
                                    <input type="text" class="form-control" id="Fullname" name="Fullname" required>
                                </div>
                                <!-- Hidden Fields -->
                                <input type="hidden" id="ContactNo" name="ContactNo" value="<?= $contactNo; ?>" readonly> <!-- Hidden ContactNo -->
                                <input type="hidden" id="UserID" name="UserID" value="<?= $userID; ?>" readonly> <!-- Hidden UserID -->
                                <input type="hidden" id="OfficeName" name="OfficeName" value="<?= $officeName; ?>" readonly>
                                <input type="hidden" id="HeadOfOffice" name="HeadOfOffice" value="<?= $headOfOffice; ?>" readonly>
                                <input type="hidden" id="Position" name="Position" value="<?= $position; ?>" readonly>

                                <input type="hidden" id="OfficeAddress" name="OfficeAddress" value="<?= $address; ?>" readonly>
                                <input type="hidden" id="Telefax" name="Telefax" value="<?= $telefax; ?>" readonly>
                                <input type="hidden" id="EmailAdd" name="EmailAdd" value="<?= $emailadd; ?>" readonly>
                                <!-- Barangay -->
                                <div class="mb-3">
                                    <label for="Barangay" class="form-label">Barangay <span class="text-danger">*</label>
                                    <input type="text" class="form-control" id="Barangay" name="Barangay" required>
                                </div>
                                <!-- Municipality -->
                                <div class="mb-3">
                                    <label for="Municipality" class="form-label">Municipality <span class="text-danger">*</label>
                                    <input type="text" class="form-control" id="Municipality" name="Municipality" required>
                                </div>
                                <!-- Province -->
                                <div class="mb-3">
                                    <label for="Province" class="form-label">Province</label>
                                    <input type="text" class="form-control" id="Province" name="Province" value="Sultan Kudarat" readonly>
                                </div>
                                <!-- Brand -->
                                <div class="mb-3">
                                    <label for="Brand" class="form-label">Brand <span class="text-danger">*</label>
                                    <input type="text" class="form-control" id="Brand" name="Brand" required>
                                </div>
                                <!-- Model -->
                                <div class="mb-3">
                                    <label for="Model" class="form-label">Model <span class="text-danger">*</label>
                                    <input type="text" class="form-control" id="Model" name="Model" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Engine Capacity -->
                                <div class="mb-3">
                                    <label for="EngineCapacity" class="form-label">Engine Capacity <span class="text-danger">*</label>
                                    <input type="text" class="form-control" id="EngineCapacity" name="EngineCapacity" required>
                                </div>
                                <!-- Serial No -->
                                <div class="mb-3">
                                    <label for="SerialNo" class="form-label">Serial No <span class="text-danger">*</label>
                                    <input type="text" class="form-control" id="SerialNo" name="SerialNo" required>
                                </div>
                                <!-- Date of Acquisition -->
                                <div class="mb-3">
                                    <label for="DateOfAcquisition" class="form-label">Date of Acquisition <span class="text-danger">*</label>
                                    <input type="date" class="form-control" id="DateOfAcquisition" name="DateOfAcquisition" required>
                                </div>
                                <!-- Max Length Guide Bar -->
                                <div class="mb-3">
                                    <label for="MaxLengthGuideBar" class="form-label">Max Length Guide Bar <span class="text-danger">*</label>
                                    <input type="text" class="form-control" id="MaxLengthGuideBar" name="MaxLengthGuideBar" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Horsepower" class="form-label">Horsepower <span class="text-danger">*</label>
                                    <input type="text" class="form-control" id="Horsepower" name="Horsepower" required>
                                </div>
                                <!-- Purpose -->
                                <div class="mb-3">
                                    <label for="Purpose" class="form-label">Purpose <span class="text-danger">*</label>
                                    <input type="text" class="form-control" id="Purpose" name="Purpose" required>
                                </div>
                            </div>
                        </div>
                        <!-- Additional Document Upload Fields -->
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Capture Image / Upload Image -->
                                <div class="mb-3">
                                    <label for="Image" class="form-label">Upload Photo (2x2) <span class="text-danger">*</label>
                                    <input type="file" class="form-control" id="Image" name="Image" accept="image/*" required>
                                </div>
                                <!-- Proof of Ownership -->
                                <div class="mb-3">
                                    <label for="ProfOwnShip">Proof of Ownership <span class="text-danger">*</label>
                                    <input type="file" id="ProfOwnShip" name="ProfOwnShip" accept="application/pdf,image/*" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Certificate from Barangay Captain -->
                                <div class="mb-3">
                                    <label for="CertBrgy">Certificate from Barangay <span class="text-danger">*</label>
                                    <input type="file" id="CertBrgy" name="CertBrgy" accept="application/pdf,image/*" required>
                                </div>
                                <!-- Certificate of Registration -->
                                <div class="mb-3">
                                    <label for="CertRegs">Registration Certificate <span class="text-danger">*</label>
                                    <input type="file" id="CertRegs" name="CertRegs" accept="application/pdf,image/*" required>
                                </div>
                            </div>
                        </div>
                        <!-- Flash Messages -->
                        <div class="alert d-none" id="flashMessage"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Hidden UserID -->
    <input type="text" id="hiddenUserID" value="<?= session()->get('userData')['UserID']; ?>">
    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Client Payment Transaction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="paymentForm">
                    <div class="modal-body">
                        <!-- Registration No -->
                        <div class="mb-3">
                            <label for="RegistrationNo" class="form-label">Registration No</label>
                            <input type="text" class="form-control" id="RegistrationNo" name="RegistrationNo" readonly>
                        </div>

                        <!-- Office Name (Hidden Field) -->
                        <input type="text" id="hiddenUserID" value="<?= session()->get('userData')['UserID']; ?>">
                        <input type="hidden" class="form-control" id="OfficeName" name="OfficeName" value="<?= $officeName; ?>" readonly>
                        <!-- RPS Chief (Hidden Field) -->
                        <input type="hidden" class="form-control" id="RPSChief" name="RPSChief" value="<?= $rpsChief; ?>" readonly>
                        <!-- Cashier (Hidden Field) -->
                        <input type="hidden" class="form-control" id="Cashier" name="Cashier" value="<?= $cashier; ?>" readonly>

                        <!-- Total Fees -->
                        <div class="mb-3">
                            <label for="TotalFees" class="form-label">Total Fees</label>
                            <input type="text" class="form-control" id="TotalFees" value="500" readonly>
                        </div>

                        <!-- QR Code Image -->
                        <div class="mb-3 text-center">
                            <label for="QRCode" class="form-label">Please Scan the QR Code</label>
                            <div>
                                <img src="<?= base_url('public/assets/images/GCashQR.jpg') ?>" alt="QR Code" id="QRCodeImage" class="img-fluid" style="max-width: 250px;">
                            </div>
                        </div>

                        <!-- GCash Reference No -->
                        <div class="mb-3">
                            <label for="GCashReferenceNo" class="form-label">GCash Reference No <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="GCashReferenceNo" name="GCashReferenceNo" placeholder="Please input GCash Reference Number after sending Payment" required maxlength="20" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        </div>

                        <!-- QR Code Schedule -->
                        <div class="mb-3">
                            <label for="QRCodeSchedule" class="form-label">QR Code Schedule <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="QRCodeSchedule" name="QRCodeSchedule" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Save Registration -->
        document.getElementById('registrationForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            const flashMessage = document.getElementById('flashMessage');

            // Clear any previous messages
            flashMessage.classList.add('d-none');
            flashMessage.classList.remove('alert-success', 'alert-danger');

            // AJAX request to submit the form
            fetch('<?= base_url('client/register') ?>', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => {
                    // Check if response is OK (status 200-299)
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.statusText);
                    }
                    // Return JSON data
                    return response.json();
                })
                .then(data => {
                    // Log the response data for debugging
                    console.log("Response data:", data);

                    if (data.success) {
                        flashMessage.innerHTML = data.message || 'Registration successful!';
                        flashMessage.classList.remove('d-none');
                        flashMessage.classList.add('alert-success');

                        // Reset form and close modal
                        document.getElementById('registrationForm').reset();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('registrationModal'));
                        modal.hide();
                    } else {
                        let errorMessages = '';
                        if (data.errors) {
                            for (const key in data.errors) {
                                if (data.errors.hasOwnProperty(key)) {
                                    errorMessages += `<p>${data.errors[key]}</p>`;
                                }
                            }
                            flashMessage.innerHTML = errorMessages;
                        } else {
                            flashMessage.innerHTML = data.message || 'An error occurred.';
                        }
                        flashMessage.classList.remove('d-none');
                        flashMessage.classList.add('alert-danger');
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    flashMessage.innerHTML = 'Error submitting registration. Please try again later. Error: ' + error.message;
                    flashMessage.classList.remove('d-none');
                    flashMessage.classList.add('alert-danger');
                });
        });

        // Disabled Enabled Navigation Buttons
        document.addEventListener('DOMContentLoaded', function() {
            // Get values from hidden inputs
            const userRole = document.getElementById('hiddenUserRole').value;
            const status = document.getElementById('hiddenStatus').value;

            // Get the Payment link element
            const paymentLink = document.querySelector('a.nav-link[href*="property"]');

            // Define other links to be disabled for Client with specific statuses
            const otherLinksToDisable = [
                'a.nav-link[href*="dashboard"]',
                'a.nav-link[href*="user"]',
                'a.nav-link[href*="confirmation"]',
                'a.nav-link[href*="releasing"]',
                'a.nav-link[href*="reports"]'
            ];

            // Check if user is a client
            if (userRole === 'Client') {
                // If the status is Pending, disable the Payment link and other navigation buttons
                if (status === 'Pending') {
                    // Disable the payment link
                    paymentLink.classList.add('disabled');
                    paymentLink.setAttribute('aria-disabled', 'true');
                    paymentLink.setAttribute('tabindex', '-1');
                    paymentLink.href = 'javascript:void(0);'; // Prevent navigation

                    // Disable other navigation links
                    otherLinksToDisable.forEach(function(selector) {
                        const link = document.querySelector(selector);
                        if (link) {
                            link.classList.add('disabled');
                            link.setAttribute('aria-disabled', 'true');
                            link.setAttribute('tabindex', '-1');
                            link.href = 'javascript:void(0);'; // Prevent navigation
                        }
                    });
                } else if (status === 'Confirmed') {
                    // Enable the Payment link
                    paymentLink.classList.remove('disabled');
                    paymentLink.removeAttribute('aria-disabled');
                    paymentLink.removeAttribute('tabindex');
                    paymentLink.href = '<?= base_url('#paymentModal') ?>'; // Set proper link

                    // Disable other navigation links
                    otherLinksToDisable.forEach(function(selector) {
                        const link = document.querySelector(selector);
                        if (link) {
                            link.classList.add('disabled');
                            link.setAttribute('aria-disabled', 'true');
                            link.setAttribute('tabindex', '-1');
                            link.href = 'javascript:void(0);'; // Prevent navigation
                        }
                    });
                }
            }

            // Add event listener to prevent navigation if the link is disabled
            document.querySelectorAll('a.disabled').forEach(function(link) {
                link.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent the default action
                });
            });
        });

        // Payment modal only for confirmed clients
        /*  document.addEventListener('DOMContentLoaded', function() {
             var userID = document.getElementById('hiddenUserID').value;

             document.querySelector('.payment-btn').addEventListener('click', function() {
                 fetch('<?= base_url("client/getClientInfoByUserID") ?>/' + userID)
                     .then(response => response.json())
                     .then(data => {
                         if (data.success) {
                             var client = data.client;

                             // Populate modal fields with client information
                             document.getElementById('RegistrationNo').value = client.RegistrationNo;
                             document.getElementById('TotalFees').value = client.TotalFees;

                             console.log('Client Info:', client); // Log client info for debugging

                             // Show the payment modal
                             $('#paymentModal').modal('show');
                         } else {
                             console.error('Error:', data.message);
                             alert(data.message);
                             $('#paymentModal').modal('hide');
                         }
                     })
                     .catch(error => {
                         console.error('Error fetching client information:', error);
                         alert('Error fetching client information.');
                         $('#paymentModal').modal('hide');
                     });
             });
         }); */

        document.addEventListener('DOMContentLoaded', function() {
            var userID = document.getElementById('hiddenUserID').value;

            document.querySelector('.payment-btn').addEventListener('click', function() {
                const apiUrl = '<?= base_url("client/getClientInfoByUserID") ?>/' + userID;

                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        console.log('API Response:', data); // Log API response

                        if (data.success) {
                            var client = data.client;

                            console.log('RegistrationNo:', client.RegistrationNo); // Debug RegistrationNo
                            console.log('TotalFees:', client.TotalFees); // Debug TotalFees

                            // Populate fields
                            document.getElementById('RegistrationNo').value = client.RegistrationNo || '';
                            document.getElementById('TotalFees').value = client.TotalFees || '';

                            // Show modal
                            $('#paymentModal').modal('show');
                        } else {
                            console.error('Error:', data.message);
                            alert(data.message || 'An error occurred.');
                            $('#paymentModal').modal('hide');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error fetching client information.');
                        $('#paymentModal').modal('hide');
                    });
            });
        });


        // Save Payment Transaction
        document.getElementById('paymentForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            var registrationNo = document.getElementById('RegistrationNo').value;
            var totalFees = document.getElementById('TotalFees').value;
            var qrCodeSchedule = document.getElementById('QRCodeSchedule').value;
            var gcashReferenceNo = document.getElementById('GCashReferenceNo').value;
            var officename = document.getElementById('OfficeName').value;
            var rpsChief = document.getElementById('RPSChief').value;
            var cashier = document.getElementById('Cashier').value;

            // Log the payload before sending the request
            console.log('Payload:', {
                'RegistrationNo': registrationNo,
                'TotalFees': totalFees,
                'QRCodeSchedule': qrCodeSchedule,
                'GCashReferenceNo': gcashReferenceNo,
                'OfficeName': officename,
                'RPSChief': rpsChief,
                'Cashier': cashier
            });

            fetch('<?= base_url("client/savePayment") ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'RegistrationNo': registrationNo,
                        'TotalFees': totalFees,
                        'QRCodeSchedule': qrCodeSchedule,
                        'GCashReferenceNo': gcashReferenceNo,
                        'OfficeName': officename,
                        'RPSChief': rpsChief,
                        'Cashier': cashier
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Response:', data); // Log the backend response for debugging
                    if (data.success) {
                        alert(data.message);
                        $('#paymentModal').modal('hide');
                        document.getElementById('paymentForm').reset();
                    } else {
                        alert(data.message || 'Failed to save payment.');
                    }
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                    alert('An error occurred while saving payment. Please try again.');
                });
        });

        //QR Code dispaly per Office
        document.addEventListener('DOMContentLoaded', function() {
            // Listen for the modal show event
            $('#paymentModal').on('show.bs.modal', function() {
                var officeName = document.getElementById('OfficeName').value; // Get OfficeName value
                var qrCodeImage = document.getElementById('QRCodeImage'); // Get QR Code image element

                // Set the QR code image based on OfficeName value
                if (officeName === 'CENRO Tacurong') {
                    qrCodeImage.src = '<?= base_url("public/assets/images/TacQRCOde.png") ?>'; // Tacurong QR code
                } else if (officeName === 'CENRO Kalamansig') {
                    qrCodeImage.src = '<?= base_url("public/assets/images/KalQRCode.jpg") ?>'; // Kalamansig QR code
                } else {
                    qrCodeImage.src = '<?= base_url("public/assets/images/defaultQR.jpg") ?>'; // Default QR code if no match
                }
            });
        });

        // Function to load client data based on status and payment status
        document.addEventListener('DOMContentLoaded', function() {
            // Function to load client data based on status and payment status
            function loadClientDetails(status, paymentStatus) {
                fetch(`<?= base_url("client/getClientDetailsByStatusAndPayment") ?>/${status}/${paymentStatus}`)
                    .then(response => response.json())
                    .then(data => {
                        const clientDetailsTable = document.getElementById('clientDetailsTable');
                        clientDetailsTable.innerHTML = ''; // Clear existing rows

                        if (data.success) {
                            data.clients.forEach(client => {
                                const row = `<tr>
                            <td>${client.RegistrationNo}</td>
                            <td>${client.Fullname}</td>
                            <td>${client.ContactNo}</td>
                            <td>${client.Brand}</td>
                            <td>${client.Model}</td>
                            <td>${client.Status}</td>
                            <td>${client.PaymentStatus}</td>
                        </tr>`;
                                clientDetailsTable.insertAdjacentHTML('beforeend', row);
                            });

                            // Show the modal
                            const clientDetailsModal = new bootstrap.Modal(document.getElementById('clientDetailsModal'));
                            clientDetailsModal.show();
                        } else {
                            alert('No clients found.');
                        }
                    })
                    .catch(error => {
                        console.error('Error loading client details:', error);
                        alert('An error occurred while loading client details.');
                    });
            }

            // When the Pending card is clicked
            document.querySelector('#pendingCard').addEventListener('click', function() {
                loadClientDetails('Pending', ''); // No payment status for pending
            });

            // When the Confirmed (For Payment) card is clicked
            document.querySelector('#confirmedForPaymentCard').addEventListener('click', function() {
                loadClientDetails('Confirmed', 'For Payment');
            });

            // When the Paid card is clicked
            document.querySelector('#confirmedPaidCard').addEventListener('click', function() {
                loadClientDetails('Confirmed', 'Paid');
            });

            // When the Released card is clicked
            document.querySelector('#releasedCard').addEventListener('click', function() {
                loadClientDetails('Released', '');
            });
        });


       // First Chart: Statistics by Office
const officeStatisticsData = <?= json_encode($officeStatistics); ?>;
const officeNames = officeStatisticsData.map(stat => stat.OfficeName);
const pendingCounts = officeStatisticsData.map(stat => stat.Pending);
const confirmedCounts = officeStatisticsData.map(stat => stat.Confirmed);
const paidCounts = officeStatisticsData.map(stat => stat.Paid);
const releasedCounts = officeStatisticsData.map(stat => stat.Released);

const ctxOffice = document.getElementById('officeStatisticsChart').getContext('2d');
new Chart(ctxOffice, {
    type: 'bar',
    data: {
        labels: officeNames,
        datasets: [
            {
                label: 'Pending',
                data: pendingCounts,
                backgroundColor: 'yellow'
            },
            {
                label: 'Confirmed',
                data: confirmedCounts,
                backgroundColor: 'blue'
            },
            {
                label: 'Paid',
                data: paidCounts,
                backgroundColor: 'green'
            },
            {
                label: 'Released',
                data: releasedCounts,
                backgroundColor: 'gray'
            },
        ]
    },
    options: {
        responsive: true
    }
});

// Second Chart: Released Clients (2024-2030)
// Use the releasedCounts and officeNames from the first chart
const ctxReleased = document.getElementById('releasedClientsChart').getContext('2d');

// Dynamically assign colors for each office
const officeColors = ['#1e3a8a', '#34d399', '#facc15', '#f87171']; // Add more colors if needed

new Chart(ctxReleased, {
    type: 'doughnut',
    data: {
        labels: officeNames, // Use office names as labels
        datasets: [{
            data: releasedCounts, // Use released counts from the first chart
            backgroundColor: officeColors.slice(0, officeNames.length), // Match colors to offices
            hoverBackgroundColor: officeColors.map(color => shadeColor(color, -10)), // Slightly darker hover colors
            borderColor: ['#ffffff'], // White border for contrast
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // Ensures chart resizes properly
        plugins: {
            legend: {
                display: true,
                position: 'top', // Positions the legend at the top
                labels: {
                    color: '#333', // Legend text color
                    font: {
                        size: 14 // Font size for legend labels
                    }
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `${context.label}: ${context.raw} Released Clients`;
                    }
                }
            }
        }
    }
});

/**
 * Utility function to slightly darken or lighten colors
 * @param {string} color - Hex color code
 * @param {number} percent - Percentage to lighten/darken (-100 to 100)
 * @returns {string} - Modified color
 */
function shadeColor(color, percent) {
    const num = parseInt(color.slice(1), 16),
        amt = Math.round(2.55 * percent),
        R = (num >> 16) + amt,
        G = (num >> 8 & 0x00FF) + amt,
        B = (num & 0x0000FF) + amt;
    return `#${(0x1000000 + (R < 255 ? (R < 1 ? 0 : R) : 255) * 0x10000 + (G < 255 ? (G < 1 ? 0 : G) : 255) * 0x100 + (B < 255 ? (B < 1 ? 0 : B) : 255)).toString(16).slice(1)}`;
}


    </script>

    <style>
        #sidebar {
            height: 100vh;
            width: 310px;
        }

        #main-content {
            margin-left: 180px;
        }

        #sidebar .nav-link {
            font-size: 17px;
            padding: 10px 45px;
        }


        #releasedClientsChart {
            display: block;
            margin: 0 auto;
            /* Centers the chart horizontally */
            max-width: 100%;
            max-height: 100%;
        }

        .card-body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            /* Ensures title and chart are stacked */
        }
    </style>
    <?= $this->endSection() ?>