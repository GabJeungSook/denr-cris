<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order of Collection</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            /* Page margin */
        }

        /* Header Section */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
        }

        /* Logo and Text in Center */
        .left-content {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
        }

        /* Logo Styling */
        .left-content img {
            width: 130px;
            height: 130px;
        }

        /* Center Header Text */
        .text-content {
            text-align: center;
            width: 100%;
        }

        .text-content p {
            margin: 0;
            font-size: 12px;
        }

        /* QR Code Styling */
        .qr-code img {
            width: 80px;
            height: 80px;
        }

        /* Centered Heading */
        h2 {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        td,
        th {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer-section {
            margin-top: 30px;
        }

        .signature {
            text-align: center;
            margin-top: 30px;
        }

        .bold {
            font-weight: bold;
        }

        .right {
            text-align: right;
        }

        /* Custom Table Styling */
        .custom-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 20px 0;
        }

        .custom-table th,
        .custom-table td {
            border: 1px solid black;
            padding: 10px;
            position: relative;
            /* Allows pseudo-elements for borders */
        }

        /* Header Styling */
        .custom-table thead th {
            background-color: #f2f2f2;
            border-bottom: 2px solid black;
        }

        /* Footer Styling for Total Row */
        .custom-table tfoot td {
            border-top: 2px solid black;
        }

        /* Add a thick vertical line between columns */
        .custom-table td:not(:last-child)::after,
        .custom-table th:not(:last-child)::after {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 3px;
            /* Adjust width of the vertical border */
            height: 100%;
            background-color: black;
            /* Vertical line color */
        }

        /* Align amounts to the right */
        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        /* Print Styling */
        @media print {
            body {
                margin: 10mm;
            }

            @page {
                margin: 0;
            }

            header,
            title {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- Header Section -->
    <div class="header">
        <div class="left-content">
            <img src="<?= base_url('public/assets/images/logo.png') ?>" alt="Office Logo">
        </div>

        <div class="text-content">
            <p>Republic of the Philippines</p>
            <p><strong>Department of Environment and Natural Resources</strong></p>
            <p><strong style="color: green;">COMMUNITY ENVIRONMENT AND NATURAL RESOURCES OFFICE</strong></p>
            <p>Barangay <?= $payment->OfficeAddress; ?></p>
            <p>Telefax: <?= $payment->Telefax; ?></p>
            <p>Email Address: <?= $payment->EmailAdd; ?></p>
        </div>

        <div class="qr-code">
            <img id="qrCode" alt="QR Code">
        </div>
    </div>
    <br>
    <!-- Centered Heading -->
    <h2>ORDER OF COLLECTION</h2>
    <br>
    <table>
        <tr>
            <td class="bold">BFD FORM NO.</td>
            <td><?= $payment->PaymentNo; ?></td>
            <td class="bold">TO: CASHIER</td>
            <td><?= $payment->Cashier; ?></td>
        </tr>
        <tr>
            <td class="bold">AMOUNT</td>
            <td class="left"><?= number_format($payment->TotalFees, 2); ?></td>
            <td class="bold">NAME</td>
            <td><?= $payment->Fullname; ?></td>
        </tr>
        <tr>
            <td class="bold">ADDRESS</td>
            <td><?= $payment->Barangay; ?>, <?= $payment->Municipality; ?></td>
            <td class="bold">OFFICE</td>
            <td><?= $payment->OfficeName; ?></td>
        </tr>
    </table>

    <table class="styled-table">
        <thead>
            <tr>
                <th>PAYMENT/DEPOSIT</th>
                <th class="right">AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Chainsaw Registration</td>
                <td class="right"><?= number_format($payment->TotalFees, 2); ?></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td class="bold">TOTAL</td>
                <td class="right bold"><?= number_format($payment->TotalFees, 2); ?></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer-section">
        <table>
            <tr>
                <td class="bold">Assessed by:</td>
                <td style="text-align: center; padding-top: 60px;">
                    <span class="bold"><?= strtoupper($payment->RPSChief); ?></span> <br>
                    Chief, Permitting and Licensing Unit
                </td>
            </tr>
            <tr>
                <td class="bold" style="text-align: left;">Approved by:</td>
                <td style="text-align: center; padding-top: 60px;">
                    <span class="bold"><?= strtoupper($payment->HeadOfOffice); ?></span> <br>
                    <?= $payment->Position; ?>
                </td>
            </tr>
            <tr>
                <td class="bold" style="text-align: left;">Collected by:</td>
                <td style="text-align: center; padding-top: 60px;">
                    <span class="bold"><?= strtoupper($payment->Cashier); ?></span> <br>
                    Cashier (Designate)
                </td>
            </tr>
        </table>

        <table class="no-border">
            <tr>
                <td class="no-border bold">OR NO.</td>
                <td class="no-border">________________________</td>
            </tr>
            <tr>
                <td class="no-border bold">Date:</td>
                <td class="no-border"><?= date('F d, Y'); ?></td>
            </tr>
        </table>
    </div>

    <div class="signature">
        <p style="color: green; font-weight: bold;">GO GREEN, Protect Environment!</p>
    </div>

    <script>
        // Generate QR Code dynamically
        document.addEventListener('DOMContentLoaded', function() {
            const registrationNo = '<?= $payment->RegistrationNo; ?>';

            const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(registrationNo)}`;

            document.getElementById('qrCode').src = qrCodeUrl;
        });
        window.onload = function() {
            window.print();
        };

        window.onafterprint = function() {
            window.close(); // Close the window after printing
        };
    </script>

</body>

</html>