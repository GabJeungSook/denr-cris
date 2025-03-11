<?= $this->extend('user/layout') ?>

<?= $this->section('container') ?>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Navigation -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar collapse" style="background-color: #153b24;">
            <div class="position-sticky pt-3">
                <!-- Logo -->
                <div class="text-center mb-6">
                    <img src="<?= base_url('public/assets/images/logo.png') ?>" alt="Logo" class="img-fluid" style="width: 200px;">
                </div>

                <!-- Change the hidden inputs to text inputs for debugging -->
                <input type="hidden" id="hiddenUserRole" value="<?= session()->get('userData')['UserRole'] ?? ''; ?>">
                <input type="hidden" id="hiddenStatus" value="<?= session()->get('userData')['Status'] ?? ''; ?>">

                <!-- Sidebar Navigation -->
                <ul class="nav flex-column">
                    <!-- Dashboard -->
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="<?= base_url(); ?>dashboard">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>

                    <!-- Confirmation -->
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="<?= base_url(); ?>confirmation">
                            <i class="fas fa-check-circle"></i> Confirmation
                        </a>
                    </li>

                    <!-- Releasing -->
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="<?= base_url(); ?>releasing">
                            <i class="fas fa-share-square"></i> Releasing
                        </a>
                    </li>

                     <!--Print COR/CR -->
                     <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="<?= base_url(); ?>print">
                            <i class="fas fa-print"></i> Print COR
                        </a>
                    </li>

                    <!-- Reports -->
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="<?= base_url(); ?>reports">
                            <i class="fas fa-file-alt"></i> Reports
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-1">
            <!-- Navigation Bar -->
            <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #153b24; margin-bottom: 1rem;">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Releasing</a>
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

            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success'); ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>

            <!-- Client Table -->
            <div class="row mt-4">
                <div class="col-12">
                    <!-- Title and Add Client Button Container -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">Client Releasing Information</h4>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive table table-bordered">
                                <table id="clientTable" class="table">
                                    <thead>
                                        <tr>
                                            <th style="width: 190px;">RegistrationNo</th>
                                            <th style="width: 250px;">Fullname</th>
                                            <th style="width: 170px;">Brand</th>
                                            <th style="width: 170px;">Model</th>
                                            <th style="width: 120px;">EngineCapacity</th>
                                            <th style="width: 170px;">SerialNo</th>
                                            <th style="width: 130px;">Horsepower</th>
                                            <th style="width: 150px;">Status</th>
                                            <th style="width: 150px;">RegisteredDate</th>
                                            <th style="width: 170px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($clientData)): ?>
                                            <?php foreach ($clientData as $Client): ?>
                                                <tr>
                                                    <td><?= $Client->RegistrationNo; ?></td>
                                                    <td><?= $Client->Fullname; ?></td>
                                                    <td><?= $Client->Brand; ?></td>
                                                    <td><?= $Client->Model; ?></td>
                                                    <td><?= $Client->EngineCapacity; ?></td>
                                                    <td><?= $Client->SerialNo; ?></td>
                                                    <td><?= $Client->Horsepower; ?></td>
                                                    <td><?= $Client->Status; ?></td>
                                                    <td><?= $Client->CreatedDate; ?></td>
                                                    <td>
                                                        <a class="btn btn-success confirm-btn" href="#"
                                                            data-id="<?= md5($Client->RegistrationNo . 'Confirm'); ?>"
                                                            data-fullname="<?= $Client->Fullname; ?>"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#confirmModal">
                                                            <i class="fas fa-share-square"></i> Release
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="11" class="text-center">No clients found</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirm Release Modal -->
            <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmModalLabel">Confirm Release</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Release Client: <span id="clientFullname" style="font-weight: bold;"></span>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button id="confirmReleaseBtn" type="button" class="btn btn-success">Release</button>
                        </div>
                    </div>
                </div>
            </div>

        </main>
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
                            <label for="RegsType" class="form-label">Type of Transaction</label>
                            <select class="form-select" id="RegsType" name="RegsType" required>
                                <option value="" disabled selected>Select type of transaction</option>
                                <option value="New">New Registration</option>
                                <option value="Old">Renewal</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <!-- Full Name -->
                            <div class="mb-3">
                                <label for="Fullname" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="Fullname" name="Fullname" required>
                            </div>
                            <!-- Hidden ContactNo Field -->

                            <!-- Barangay -->
                            <div class="mb-3">
                                <label for="Barangay" class="form-label">Barangay</label>
                                <input type="text" class="form-control" id="Barangay" name="Barangay" required>
                            </div>
                            <!-- Municipality -->
                            <div class="mb-3">
                                <label for="Municipality" class="form-label">Municipality</label>
                                <input type="text" class="form-control" id="Municipality" name="Municipality" required>
                            </div>
                            <!-- Province -->
                            <div class="mb-3">
                                <label for="Province" class="form-label">Province</label>
                                <input type="text" class="form-control" id="Province" name="Province" required>
                            </div>
                            <!-- Brand -->
                            <div class="mb-3">
                                <label for="Brand" class="form-label">Brand</label>
                                <input type="text" class="form-control" id="Brand" name="Brand" required>
                            </div>
                            <!-- Model -->
                            <div class="mb-3">
                                <label for="Model" class="form-label">Model</label>
                                <input type="text" class="form-control" id="Model" name="Model" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Engine Capacity -->
                            <div class="mb-3">
                                <label for="EngineCapacity" class="form-label">Engine Capacity</label>
                                <input type="text" class="form-control" id="EngineCapacity" name="EngineCapacity" required>
                            </div>
                            <!-- Serial No -->
                            <div class="mb-3">
                                <label for="SerialNo" class="form-label">Serial No</label>
                                <input type="text" class="form-control" id="SerialNo" name="SerialNo" required>
                            </div>
                            <!-- Date of Acquisition -->
                            <div class="mb-3">
                                <label for="DateOfAcquisition" class="form-label">Date of Acquisition</label>
                                <input type="date" class="form-control" id="DateOfAcquisition" name="DateOfAcquisition" required>
                            </div>
                            <!-- Max Length Guide Bar -->
                            <div class="mb-3">
                                <label for="MaxLengthGuideBar" class="form-label">Max Length Guide Bar</label>
                                <input type="text" class="form-control" id="MaxLengthGuideBar" name="MaxLengthGuideBar" required>
                            </div>
                            <!-- Purpose -->
                            <div class="mb-3">
                                <label for="Purpose" class="form-label">Purpose</label>
                                <input type="text" class="form-control" id="Purpose" name="Purpose" required>
                            </div>
                            <!-- Office Name Dropdown -->
                            <div class="mb-3">
                                <label for="OfficeName" class="form-label">Office Name</label>
                                <select class="form-select" id="OfficeName" name="OfficeName" required>
                                    <option value="" disabled selected>Select Office</option>
                                    <option value="CENRO Tacurong">CENRO Tacurong</option>
                                    <option value="CENRO Kalamansig">CENRO Kalamansig</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Additional Document Upload Fields -->
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Capture Image / Upload Image -->
                            <div class="mb-3">
                                <label for="Image" class="form-label">Upload Photo (2x2)</label>
                                <input type="file" class="form-control" id="Image" name="Image" accept="image/*" required>
                            </div>
                            <!-- Proof of Ownership -->
                            <div class="mb-3">
                                <label for="ProfOwnShip">Proof of Ownership</label>
                                <input type="file" id="ProfOwnShip" name="ProfOwnShip" accept="application/pdf,image/*" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Certificate from Barangay Captain -->
                            <div class="mb-3">
                                <label for="CertBrgy">Certificate from Barangay</label>
                                <input type="file" id="CertBrgy" name="CertBrgy" accept="application/pdf,image/*" required>
                            </div>
                            <!-- Certificate of Registration -->
                            <div class="mb-3">
                                <label for="CertRegs">Registration Certificate</label>
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
<input type="hidden" id="hiddenUserID" value="<?= session()->get('userData')['UserID']; ?>">
<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Client Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="paymentForm">
                <div class="modal-body">
                    <!-- Registration No -->
                    <div class="mb-3">
                        <label for="RegistrationNo" class="form-label">Registration No</label>
                        <input type="text" class="form-control" id="RegistrationNo" name="RegistrationNo" readonly>
                    </div>

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

                    <!-- GCash Reference No (with placeholder and number-only validation) -->
                    <div class="mb-3">
                        <label for="GCashReferenceNo" class="form-label">GCash Reference No</label>
                        <input type="text" class="form-control" id="GCashReferenceNo" name="GCashReferenceNo" placeholder="Please input GCash Reference No after Payment" required maxlength="20" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    </div>

                    <!-- QR Code Schedule -->
                    <div class="mb-3">
                        <label for="QRCodeSchedule" class="form-label">QR Code Schedule</label>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Assuming the UserID is stored in a hidden input
        var userID = document.getElementById('hiddenUserID').value;

        // Open the payment modal when the "Payment" button is clicked
        document.querySelector('.payment-btn').addEventListener('click', function() {
            console.log("Fetching client info for UserID:", userID); // Log UserID for debugging

            // Fetch client info via AJAX using UserID
            fetch('<?= base_url("client/getClientInfoByUserID") ?>/' + userID)
                .then(response => response.json())
                .then(data => {
                    console.log("Response from server:", data); // Log the server response

                    if (data.success) {
                        var client = data.client;

                        // Log fetched RegistrationNo for debugging
                        console.log("RegistrationNo fetched: ", client.RegistrationNo);

                        // Populate modal fields with client information
                        document.getElementById('RegistrationNo').value = client.RegistrationNo || '';
                        document.getElementById('TotalFees').value = client.TotalFees || '500'; // Default to 500 if missing
                    } else {
                        alert('Client information not found.');
                    }
                })
                .catch(error => {
                    console.error('Error fetching client information:', error);
                    alert('Error fetching client information.');
                });
        });
    });

    // Save Payment Transaction
    document.getElementById('paymentForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Collect form data
        var registrationNo = document.getElementById('RegistrationNo').value;
        var totalFees = document.getElementById('TotalFees').value;
        var qrCodeSchedule = document.getElementById('QRCodeSchedule').value;
        var gcashReferenceNo = document.getElementById('GCashReferenceNo').value;

        // Send the data via AJAX to the backend for processing
        fetch('<?= base_url("client/savePayment") ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'RegistrationNo': registrationNo,
                    'TotalFees': totalFees,
                    'QRCodeSchedule': qrCodeSchedule,
                    'GCashReferenceNo': gcashReferenceNo
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // Log the response from the server
                if (data.success) {
                    alert(data.message); // Show success message
                    // Optionally, you can close the modal or reset the form
                    $('#paymentModal').modal('hide');
                    document.getElementById('paymentForm').reset();
                } else {
                    alert('Failed to save payment');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving payment');
            });
    });

    //Datatable Client Table
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#clientTable').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "searching": true // Enables the default search box
        });

        // Change the placeholder of the default search box to 'Search by Fullname'
        $('#clientTable_filter input').attr('placeholder', 'Please input Fullname');

        // Override the default search behavior to search only in the Fullname column (index 1)
        $('#clientTable_filter input').unbind().on('keyup', function() {
            table.column(1).search(this.value).draw(); // Search by Fullname column only (index 1)
        });
    });


    //Release Client Status
    document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.confirm-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const fullname = this.getAttribute('data-fullname');
            const registrationNoHash = this.getAttribute('data-id'); // Hashed RegistrationNo

            // Display the client name in the modal message
            document.getElementById('clientFullname').textContent = fullname;

            // Confirm Release Button inside the modal
            document.getElementById('confirmReleaseBtn').addEventListener('click', function() {
                fetch('<?= base_url("client/releaseClient") ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ registrationNoHash: registrationNoHash })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Client released successfully!');
                        location.reload(); // Reload the page to reflect the updated status
                    } else {
                        alert('Failed to release client. ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });

                // Close the modal
                const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
                confirmModal.hide();
            });
        });
    });
});

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
</style>
<?= $this->endSection() ?>