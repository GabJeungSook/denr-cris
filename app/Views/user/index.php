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
                    <!-- Personnel -->
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="<?= base_url(); ?>user">
                            <i class="fas fa-users"></i> Manage User
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
                    <a class="navbar-brand" href="#">Manage User</a>
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

            <!-- Modal for Adding User -->
            <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="addUserForm">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="firstName" class="form-label">First Name <span class="text-danger">*</label>
                                    <input type="text" class="form-control" id="FirstName" name="FirstName" required>
                                </div>

                                <div class="mb-3">
                                    <label for="lastName" class="form-label">Last Name <span class="text-danger">*</label>
                                    <input type="text" class="form-control" id="LastName" name="LastName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="MiddleName" class="form-label">Middle Name <span class="text-danger">*</label>
                                    <input type="text" class="form-control" id="MiddleName" name="MiddleName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="contactNo" class="form-label">Contact No <span class="text-danger">*</label>
                                    <input type="text" class="form-control" id="ContactNo" name="ContactNo" required>
                                </div>
                                <!-- Office Dropdown -->
                                <div class="mb-3">
                                    <label for="OfficeName" class="form-label">Office Name <span class="text-danger">*</span></label>
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
                                <input type="hidden" id="UserID" name="UserID" readonly>
                                <!-- UserRole Dropdown -->
                                <div class="mb-3">
                                    <label for="userRole" class="form-label">User Role <span class="text-danger">*</label>
                                    <select class="form-select" id="UserRole" name="UserRole" required>
                                        <option value="" disabled selected>Select Role</option>
                                        <option value="RPS Chief">System Administrator</option>
                                        <option value="RPS Chief">RPS Chief</option>
                                        <option value="Cashier">Cashier</option>
                                        <option value="Patroller">Patroller</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Username <span class="text-danger">*</label>
                                    <input type="text" class="form-control" id="Username" name="Username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</label>
                                    <input type="password" class="form-control" id="Password" name="Password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Confirm Password <span class="text-danger">*</label>
                                    <input type="password" class="form-control" id="ConfirmPassword" name="ConfirmPassword" required>
                                </div>
                                <div class="alert alert-danger d-none" id="passwordMismatch">Passwords do not match!</div>
                                <div class="alert d-none" id="flashMessage"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

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

            <!-- User Table -->
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-12">
                        <!-- Title and Add User Button Container -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-0">List of Users</h4>
                            <!-- Trigger modal with button -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                <i class="fas fa-user-plus"></i> Add User
                            </button>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive table table-bordered">
                                    <table id="userTable" class="table display">
                                        <thead>
                                            <tr>
                                                <th>User ID</th>
                                                <th>Last Name</th>
                                                <th>First Name</th>
                                                <th>User Role</th>
                                                <th>OfficeName</th>
                                                <th>Username</th>
                                                <th>Date Registered</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($UserData as $User): ?>
                                                <tr>
                                                    <td><?= $User->UserID; ?></td>
                                                    <td><?= $User->LastName; ?></td>
                                                    <td><?= $User->FirstName; ?></td>
                                                    <td><?= $User->UserRole; ?></td>
                                                    <td><?= $User->OfficeName; ?></td>
                                                    <td><?= $User->Username; ?></td>
                                                    <td><?= $User->CreatedDate; ?></td>
                                                    <td>
                                                        <a class="btn btn-warning edit-user-btn" data-id="<?= $User->UserID; ?>" href="#">
                                                            <i class="fas fa-pencil-alt"></i> Edit
                                                        </a>
                                                        <a class="btn btn-danger delete-user-btn"
                                                            data-id="<?= $User->UserID; ?>"
                                                            data-lastname="<?= $User->LastName; ?>"
                                                            href="#">
                                                            <i class="fas fa-trash-alt"></i> Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the user with the last name: <strong id="deleteUserLastName"></strong>?</p>
                <input type="hidden" id="deleteUserIDForm"> <!-- Hidden field for UserID -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="successMessage"></p>
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
                                <label for="FullName" class="form-label">Full Name <span class="text-danger">*</label>
                                <input type="text" class="form-control" id="FullName" name="FullName" required>
                            </div>
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

<!-- JavaScript Validation and Form Submission -->
<script>
    document.getElementById('addUserForm').addEventListener('submit', function(event) {
        event.preventDefault();

        // Determine whether this is for adding or editing
        var userID = document.getElementById('UserID').value;
        var url = userID ? '<?= base_url("user/updateUser") ?>' : '<?= base_url("user/addUser") ?>';

        // Perform AJAX request to add or update user
        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(new FormData(this))
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    $('#addUserModal').modal('hide');
                    location.reload(); // Reload page to refresh user list
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error submitting form:', error);
                alert('Error submitting form.');
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

    //Datatable User Table
    $(document).ready(function() {
        // Initialize the DataTable
        var table = $('#userTable').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "searching": true,
            "autoWidth": false
        });

        // Change the placeholder of the default search box to 'Input Lastname'
        $('#userTable_filter input').attr('placeholder', 'Please input Lastname');

        // Override the default search behavior to search only in the Last Name column (index 1)
        $('#userTable_filter input').unbind().on('keyup', function() {
            table.column(1).search(this.value).draw(); // Targets only the "Last Name" column (index 1)
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

    //Fetch the user detatils to edit
    document.addEventListener('DOMContentLoaded', function() {
        // Listen for clicks on Edit buttons
        document.querySelectorAll('.edit-user-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                var userID = this.getAttribute('data-id');

                // Fetch user details via AJAX
                fetch('<?= base_url("user/getUserDetails") ?>/' + userID)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            var user = data.user;

                            // Populate the modal fields with user data
                            document.getElementById('UserID').value = user.UserID; // Set UserID
                            document.getElementById('FirstName').value = user.FirstName;
                            document.getElementById('LastName').value = user.LastName;
                            document.getElementById('ContactNo').value = user.ContactNo;
                            document.getElementById('OfficeName').value = user.OfficeName;
                            document.getElementById('UserRole').value = user.UserRole;
                            document.getElementById('Username').value = user.Username;

                            // Handle password fields (optionally)
                            document.getElementById('Password').value = ''; // Clear password field
                            document.getElementById('ConfirmPassword').value = ''; // Clear confirm password field

                            // Change modal title and button for editing
                            document.querySelector('#addUserModalLabel').textContent = 'Edit User';
                            document.querySelector('#addUserForm button[type="submit"]').textContent = 'Update User';

                            // Show the modal for editing
                            $('#addUserModal').modal('show');
                        } else {
                            alert('Failed to load user details.');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching user details:', error);
                        alert('Error fetching user details.');
                    });
            });
        });

        // For Add User button, reset the form and adjust modal settings
        document.querySelector('.add-user-btn').addEventListener('click', function() {
            // Reset the form
            document.getElementById('addUserForm').reset();
            document.getElementById('UserID').value = ''; // Clear UserID for new user

            // Change modal title and button for adding
            document.querySelector('#addUserModalLabel').textContent = 'Add New User';
            document.querySelector('#addUserForm button[type="submit"]').textContent = 'Add User';

            // Show the modal for adding
            $('#addUserModal').modal('show');
        });
    });

    //Fetch the user detatils to Delete
    document.addEventListener('DOMContentLoaded', function() {
        // Get the delete modal and confirm button references
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteUserModal'));
        var confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

        // When the delete button is clicked, open the modal
        document.querySelectorAll('.delete-user-btn').forEach(function(deleteBtn) {
            deleteBtn.addEventListener('click', function() {
                var userID = this.getAttribute('data-id'); // Get the UserID from the data attribute
                var lastName = this.getAttribute('data-lastname'); // Get the last name from the data attribute

                // Set the last name and user ID in the modal
                document.getElementById('deleteUserLastName').textContent = lastName;
                document.getElementById('deleteUserIDForm').value = userID; // Set for the form submission

                // Show the delete modal
                deleteModal.show();
            });
        });

        // Handle the delete action with AJAX
        confirmDeleteBtn.addEventListener('click', function() {
            var userID = document.getElementById('deleteUserIDForm').value; // Get the UserID from the hidden input

            // Send the delete request via AJAX
            fetch('<?= base_url("user/delete") ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'UserID': userID
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data); // For debugging

                    if (data.success) {
                        alert(data.message); // Show success message

                        // Optionally, remove the row from the table
                        var row = document.querySelector('tr[data-id="' + userID + '"]');
                        if (row) {
                            row.remove(); // Remove the row if it exists
                        }

                        // Close the modal
                        deleteModal.hide();
                    } else {
                        alert(data.message); // Show error message
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the user.');
                });
        });

    });

    $(document).ready(function() {
        // Handle the delete action when the "Confirm Delete" button is clicked
        $('#confirmDeleteBtn').on('click', function() {
            var userID = $('#deleteUserIDForm').val(); // Get UserID from hidden input

            $.ajax({
                url: '<?= base_url('user/delete') ?>', // Adjust the URL to your delete action
                type: 'POST',
                data: {
                    UserID: userID
                },
                success: function(response) {
                    // Handle success based on response from the server
                    if (response.success) {
                        // Close the delete modal
                        $('#deleteUserModal').modal('hide');

                        // Show success modal or message
                        $('#successMessage').text(response.message);
                        $('#successModal').modal('show');

                        // Optionally, refresh the table or redirect after deletion
                        setTimeout(function() {
                            location.reload(); // Reload the page to reflect changes
                        }, 2000); // Adjust timeout as needed
                    } else {
                        // Show error message if the delete failed (based on the server response)
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // This block will run if there's an actual error (e.g., network issue, server error)
                    console.error('Error occurred:', error); // Log the error for debugging
                    alert('An error occurred while deleting the user.');
                }
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