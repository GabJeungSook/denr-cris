<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">List of Users</h4>
                    <a class="btn btn-primary" href="<?= base_url() ?>user/add">Add User</a>
                </div>

                <!-- Search Box -->
                <div class="mb-3">
                    <form class="d-flex" method="GET" action="<?= base_url('user/search'); ?>">
                        <input 
                            class="form-control me-2" 
                            type="search" 
                            placeholder="Search by Last Name" 
                            aria-label="Search" 
                            name="search" 
                            value="<?= isset($search) ? htmlspecialchars($search) : ''; ?>"
                        >
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </form>
                </div>

                <!-- Table -->
                <div class="table-responsive table table-bordered">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
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
                                    <td><?= $User->MiddleName; ?></td>
                                    <td><?= $User->Username; ?></td>
                                    <td><?= $User->EntryDate; ?></td>
                                    <td>
                                        <a class="btn btn-warning" href="<?= base_url(); ?>user/edit?id=<?= md5($User->UserID . 'edit'); ?>">Edit</a>
                                        <a class="btn btn-danger" href="<?= base_url(); ?>user/delete?id=<?= md5($User->UserID . 'delete'); ?>">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
