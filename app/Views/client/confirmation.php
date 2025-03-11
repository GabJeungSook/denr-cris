<?= $this->extend('user/layout') ?>

<?= $this->section('container') ?>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Navigation -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar collapse" style="background-color: #153b24;">
            <div class="position-sticky pt-3">
                <!-- Logo -->
                <div class="text-center mb-6">
                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo" class="img-fluid" style="width: 200px;">
                </div>
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
                    <a class="navbar-brand" href="#">Confirmation</a>
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
                        <h4 class="card-title mb-0">Client Registration Information</h4>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive table table-bordered">
                                <table id="clientTable" class="table">
                                    <thead>
                                        <tr>
                                            <th style="width: 170px;">RegistrationNo</th> <!-- Set fixed width for RegistrationNo -->
                                            <th style="width: 190px;">Fullname</th> <!-- Set fixed width for Fullname -->
                                            <th style="width: 100px;">ContactNo</th> <!-- Set fixed width for Fullname -->
                                            <!--  <th style="width: 130px;">Municipality</th> Set fixed width for Model -->
                                            <th style="width: 130px;">Brand</th> <!-- Set fixed width for Model -->
                                            <th style="width: 130px;">Model</th> <!-- Set fixed width for Model -->
                                            <th style="width: 120px;">EngineCapacity</th> <!-- Set fixed width for Model -->
                                            <th style="width: 130px;">SerialNo</th> <!-- Set fixed width for SerialNo -->
                                            <th style="width: 142px;">RegisteredDate</th> <!-- Set fixed width for CreatedDate -->
                                            <th style="width: 270px;">Actions</th> <!-- Set fixed width for Actions -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($clientData)): ?>
                                            <?php foreach ($clientData as $Client): ?>
                                                <tr>
                                                    <td><?= $Client->RegistrationNo; ?></td>
                                                    <td><?= $Client->Fullname; ?></td>
                                                    <td><?= $Client->ContactNo; ?></td>
                                                    <!--   <td><?= $Client->Municipality; ?></td> -->
                                                    <td><?= $Client->Brand; ?></td>
                                                    <td><?= $Client->Model; ?></td>
                                                    <td><?= $Client->EngineCapacity; ?></td>
                                                    <td><?= $Client->SerialNo; ?></td>
                                                    <td><?= $Client->CreatedDate; ?></td>
                                                    <td>
                                                        <a class="btn btn-info view-files-btn" href="#" data-id="<?= md5($Client->RegistrationNo . 'View Files'); ?>" data-bs-toggle="modal" data-bs-target="#viewFilesModal">
                                                            <i class="fas fa-file-alt"></i> View Files
                                                        </a>
                                                        <a class="btn btn-success confirm-btn" href="#" data-id="<?= md5($Client->RegistrationNo . 'Confirm'); ?>" data-bs-toggle="modal" data-bs-target="#confirmModal">
                                                            <i class="fas fa-check-circle"></i> Confirm
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
        </main>
    </div>
</div>

<!-- Modal for Viewing Files -->
<div class="modal fade" id="viewFilesModal" tabindex="-1" aria-labelledby="viewFilesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewFilesModalLabel">View Attached Files</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Full Name Display -->
                <p id="clientFullName" style="font-weight: bold;"></p> <!-- Full Name will be injected here -->

                <!-- Table to display files -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>File Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="fileTableBody">
                        <!-- Files will be dynamically loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Confirming Client and Sending SMS -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Client Registration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Client Information Form -->
                <form id="confirmForm">
                    <input type="hidden" id="RegistrationNoHash" name="RegistrationNoHash" /> <!-- Hidden field for RegistrationNo -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="Fullname" class="form-label">Fullname</label>
                            <input type="text" class="form-control" id="Fullname" name="Fullname" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="Brand" class="form-label">Brand</label>
                            <input type="text" class="form-control" id="Brand" name="Brand" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="Model" class="form-label">Model</label>
                            <input type="text" class="form-control" id="Model" name="Model" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="EngineCapacity" class="form-label">Engine Capacity</label>
                            <input type="text" class="form-control" id="EngineCapacity" name="EngineCapacity" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="SerialNo" class="form-label">Serial No</label>
                            <input type="text" class="form-control" id="SerialNo" name="SerialNo" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="CreatedDate" class="form-label">Registered Date</label>
                            <input type="text" class="form-control" id="CreatedDate" name="CreatedDate" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ContactNo" class="form-label">ContactNo</label>
                            <input type="text" class="form-control" id="ContactNo" name="ContactNo" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="Status" class="form-label">Status</label>
                            <select class="form-select" id="Status" name="Status" required>
                                <option value="" disabled selected>Select Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Confirmed">Confirmed</option>
                            </select>
                        </div>
                        <!-- QR Code Section in Modal -->
                        <div class="col-md-6 mb-3">
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="" alt="QR Code" id="qrCodeImage">
                            </div>
                        </div>
                        <!-- Remarks for SMS Notification -->
                        <div class="col-md-6 mb-3">
                            <div class="form-group mb-3">
                                <label for="remarks" class="form-label">Remarks</label>
                                <textarea class="form-control" id="remarks" rows="6" placeholder="Enter your remarks..."></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="sendSmsBtn">Submit</button>
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

<script>
    // View Files Modal
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.view-files-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                var fileId = this.getAttribute('data-id');

                // Clear the existing table rows and full name
                document.getElementById('fileTableBody').innerHTML = '<tr><td colspan="2">Loading files...</td></tr>';
                document.getElementById('clientFullName').innerHTML = ''; // Clear full name

                // Make an AJAX request to fetch the file paths and client's full name
                fetch('<?= base_url("client/getFiles") ?>/' + fileId)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            var files = data.files;
                            var fileTableBody = '';

                            // Display client's full name
                            document.getElementById('clientFullName').innerHTML = 'Fullname: ' + data.fullName; // Assuming fullName is part of the response

                            // Loop through the files and create table rows
                            for (var fileType in files) {
                                if (files.hasOwnProperty(fileType)) {
                                    fileTableBody += '<tr>';
                                    fileTableBody += '<td>' + fileType + '</td>';
                                    fileTableBody += '<td><a href="' + files[fileType] + '" target="_blank" class="btn btn-primary">Open ' + fileType + '</a></td>';
                                    fileTableBody += '</tr>';
                                }
                            }

                            // Update the table body with the files
                            document.getElementById('fileTableBody').innerHTML = fileTableBody;
                        } else {
                            document.getElementById('fileTableBody').innerHTML = '<tr><td colspan="2">' + data.message + '</td></tr>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching files:', error);
                        document.getElementById('fileTableBody').innerHTML = '<tr><td colspan="2">Unable to load files.</td></tr>';
                    });
            });
        });
    });

    // Confirm Button Modal
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.confirm-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                var confirmId = this.getAttribute('data-id'); // Fetch the RegistrationNo
                console.log('RegistrationNo being sent:', confirmId); // Log it for debugging

                // Make an AJAX request to fetch the client info
                fetch('<?= base_url("client/getClientInfo") ?>/' + confirmId)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Data received:', data); // Log the response for debugging

                        if (data.success) {
                            var client = data.client;

                            // Populate the input fields with client information
                            document.getElementById('Fullname').value = client.Fullname;
                            document.getElementById('ContactNo').value = client.ContactNo;
                            document.getElementById('Brand').value = client.Brand;
                            document.getElementById('Model').value = client.Model;
                            document.getElementById('EngineCapacity').value = client.EngineCapacity;
                            document.getElementById('SerialNo').value = client.SerialNo;
                            document.getElementById('CreatedDate').value = client.CreatedDate;
                            document.getElementById('RegistrationNoHash').value = client.HashedRegistrationNo; // Display hashed RegistrationNo

                            // Generate and set the QR code based on SerialNo
                            const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${client.RegistrationNo}`;
                            document.querySelector('#confirmModal img').setAttribute('src', qrCodeUrl);

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
    });

    // Handle sending SMS notification with validation of status and remarks
    document.getElementById('sendSmsBtn').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent form from submitting the default way

        // Get the form data
        var registrationNo = document.getElementById('RegistrationNoHash').value;
        var status = document.getElementById('Status').value;
        var remark = document.getElementById('remarks').value;
        var contactNo = document.getElementById('ContactNo').value; // ContactNo for sending SMS

        // Form validation: Ensure that Status and Remarks are not empty
        if (!status) {
            alert('Please select a status.');
            return;
        }

        if (!remark.trim()) {
            alert('Please enter remarks.');
            return;
        }

        console.log('RegistrationNo being sent:', registrationNo); // Log RegistrationNo for debugging
        console.log('Status being sent:', status); // Log Status for debugging
        console.log('Remark being sent:', remark); // Log Remark for debugging

        // Send the data via AJAX to the backend for processing the update
        fetch('<?= base_url("client/updateRegistration") ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'RegistrationNo': registrationNo,
                    'Status': status,
                    'Remark': remark
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // Log the response from the server for debugging
                if (data.success) {
                    alert(data.message);

                    // Send an SMS after the registration is successfully updated
                    fetch('<?= base_url("client/sendSms") ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                'ContactNo': contactNo, // Contact number for SMS
                                'Remarks': remark // Remarks to be sent in SMS
                            })
                        })
                        .then(smsResponse => smsResponse.json())
                        .then(smsData => {
                            console.log('SMS sent:', smsData); // Log the response from the SMS API
                            alert('SMS has been sent to the client.');
                        })
                        .catch(error => {
                            console.error('Error sending SMS:', error);
                            alert('SMS has been sent to the client.');
                        });

                    // Optionally close the modal
                    $('#confirmModal').modal('hide');
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error updating registration:', error);
                alert('An error occurred while updating the registration.');
            });
    });


    // Registration Modal
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
                console.log("Raw Response:", response); // Log the raw response

                // Temporarily remove the "if (!response.ok)" block
                // return response.json();
                return response.json(); // Always try to parse JSON
            })
            .then(data => {
                // Log the response data to see the full object
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
                flashMessage.innerHTML = 'Error submitting registration. Please try again later.';
                flashMessage.classList.remove('d-none');
                flashMessage.classList.add('alert-danger');
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

    .btn i {
        margin-right: 5px;
        /* Adds space between icon and text */
    }
</style>
<?= $this->endSection() ?>