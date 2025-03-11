<?= $this->extend('user/layout') ?>

<?= $this->section('container') ?>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
            <div class="position-sticky pt-3">
                <!-- Logo -->
                <div class="text-center mb-6">
                    <img src="<?= base_url('public/assets/images/logo.png') ?>" alt="Logo" class="img-fluid" style="width: 120px;">
                </div>
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
                    <!-- Supplies -->
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="<?= base_url(); ?>supplies">
                            <i class="fas fa-boxes"></i> Supplies
                        </a>
                    </li>
                    <!-- Property -->
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="<?= base_url(); ?>property">
                            <i class="fas fa-building"></i> Property
                        </a>
                    </li>
                    <!-- Issuance -->
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="<?= base_url(); ?>issuance">
                            <i class="fas fa-file-alt"></i> Issuance
                        </a>
                    </li>
                    <!-- Reports -->
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="<?= base_url(); ?>reports">
                            <i class="fas fa-chart-line"></i> Reports
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

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
            <div class="row mt-4">
                <div class="col-12">
                    <!-- Title and Add User Button Container -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">Issuance Information</h4>
                        <a class="btn btn-primary" href="<?= base_url() ?>user/add">Add Issuance</a>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <!-- Search Box -->
                            <div class="mb-3">
                                <form class="d-flex" method="GET" action="<?= base_url('user/search'); ?>">
                                    <input
                                        class="form-control me-2"
                                        type="search"
                                        placeholder="Search by Item Description"
                                        aria-label="Search"
                                        name="search"
                                        value="<?= isset($search) ? htmlspecialchars($search) : ''; ?>">
                                    <button class="btn btn-outline-primary" type="submit">Search</button>
                                </form>
                            </div>

                            <div class="table-responsive table table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Issuance No</th>
                                            <th>Item Description</th>
                                            <th>Quantity</th>
                                            <th>Received By</th>
                                            <th>Issued By</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($UserData1 as $Supplier): ?>
                                            <tr>
                                                <td><?= $Supplier->IssuanceNo; ?></td>
                                                <td><?= $Supplier->ItemDescription; ?></td>
                                                <td><?= $Supplier->Quantity; ?></td>
                                                <td><?= $Supplier->ReceivedBy; ?></td>
                                                <td><?= $Supplier->IssuedBy; ?></td>
                                                <td><?= $Supplier->Date; ?></td>
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
            </div>
        </main>
    </div>
</div>

</script>

<style>
    #sidebar {
        height: 120vh;
        width: 280px;
    }

    #main-content {
        margin-left: 180px;
    }

    #sidebar .nav-link {
        font-size: 14px;
        padding: 10px 15px;
    }
</style>

<?= $this->endSection() ?>