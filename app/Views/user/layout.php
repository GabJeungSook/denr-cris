<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>CHAINSAW REGISTRATION INFORMATION SYSTEM</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css">

    <!-- FontAwesome CSS (Only include once) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- Custom Styles -->
    <style>
        #userTable th, #userTable td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #userTable th:nth-child(8), 
        #userTable td:nth-child(8) {
            width: 150px;  /* Adjust action column width */
        }
    </style>

    <!-- jQuery (Ensure jQuery is loaded first) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

    <!-- Render the main content from other views -->
    <?= $this->renderSection('container') ?>

    <!-- Bootstrap JS -->
    <script src="<?= base_url() ?>public/assets/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>
