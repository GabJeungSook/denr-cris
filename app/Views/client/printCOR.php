<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px 70px;
            padding: 0;
            color: #000;
        }

        /* CSS to hide the default print headers and footers */
        @page {
            size: auto;
            margin: 1.5;
            /* Remove margins for the print page */
        }

        @media print {
            body {
                margin: 3;
                padding: 3;
                -webkit-print-color-adjust: exact;
            }

            /* Hide the browser's default header and footer */
            @page {
                margin: 0;
            }

            .btn,
            a {
                display: none;
            }
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header .left-content {
            display: flex;
            align-items: center;
        }

        .header img {
            max-width: 120px;
            height: auto;
            margin-right: 15px;
        }

        .header .text-content {
            text-align: center;
        }

        .header .text-content p {
            margin: 2px 0;
            font-size: 14px;
        }

        .header .qr-code img {
            width: 70px;
            height: 70px;
        }

        .qr-code img {
            width: 80px;
            height: 80px;
        }

        .certificate-title {
            text-align: center;
            font-weight: bold;
            font-size: 24px;
            margin: 10px 0;
            text-transform: uppercase;
        }

        .centered-info {
            text-align: center;
            margin: 10px 0;
        }

        .centered-info p {
            margin: 5px 0;
            font-weight: bold;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .info-table td {
            padding: 8px 12px;
            vertical-align: top;
        }

        .info-table td:first-child {
            font-weight: bold;
        }

        .signature {
            margin-top: 30px;
            text-align: left;
        }

        .signature p {
            margin: 0;
            font-weight: normal;
            /* Ensures plain text for "APPROVED BY" */
            font-style: normal;
            /* Removes any italic styling */
        }

        .signature-area {
            margin-top: 20px;
            text-align: center;
            /* Center-aligns the name and position */
        }

        .signature-line {
            width: 250px;
            border-top: 1px solid #000;
            margin: 0 auto 10px auto;
            /* Centers the signature line */
        }

        .signature-area p.head-of-office {
            margin: 5px 0;
            font-weight: bold;
            /* Bold text for Head of Office */
        }

        .signature-area p.position {
            margin: 5px 0;
            font-weight: normal;
            /* Plain text for Position */
        }

        .terms {
            margin-top: 20px;
            line-height: 1.5;
        }

        .footer {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-top: 1.5px solid #000;
            padding-top: 10px;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 80%;
            /* Adjust width as needed */
        }

        .qr-container img,
        .photo-container img {
            width: 100px;
            height: 100px;
            border: 1px solid #000;
            object-fit: cover;
        }

        .owner-info {
            margin-left: 10px;
            text-align: left;
        }

        .owner-info p {
            margin: 5px 0;
        }

        .qr-container img,
        .photo-container img {
            width: 100px;
            height: 100px;
            border: 1px solid #000;
            object-fit: cover;
        }

        @media print {

            .btn,
            a {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- Header Section -->
    <div class="header">
        <div class="left-content">
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="Office Logo">
            <div class="text-content">
                <p>Republic of the Philippines</p>
                <p><strong>Department of Environment and Natural Resources</strong></p>
                <p><strong style="color: green;">COMMUNITY ENVIRONMENT AND NATURAL RESOURCES OFFICE</strong></p>
                <p>Barangay <?= $OfficeAddress; ?></p>
                <p>Telefax: <?= $Telefax; ?></p>
                <p>Email Address: <?= $EmailAdd; ?></p>

            </div>
        </div>

        <!-- QR Code -->
        <div class="qr-code">
            <img id="qrCode" alt="QR Code">
        </div>
    </div>

    <!-- Certificate Title -->
    <div class="certificate-title">
        Certificate of Registration<br>
        <span>No. <?= $RegistrationNo; ?></span>
    </div>
    <br>

    <p style="text-align: justify; line-height: 1.5; margin-top: 10px; margin-bottom: 10px;">
        After having complied with the provision of DENR Administrative Order No. 2003-24, Series of 2003,
        this Certificate of Registration to possess, own, or use a chainsaw is hereby issued to:
    </p>
    <br>

    <!-- Centered Owner Information -->
    <div class="centered-info">
        <p><?= strtoupper($Fullname); ?></p>
        <small>(Name of Owner)</small>
        <p><?= ucwords(strtolower($Barangay)) . ', ' . ucwords(strtolower($Municipality)) . ', ' . ucwords(strtolower($Province)); ?></p>
        <small>(Address)</small>
    </div>

    <!-- Chainsaw Information -->
    <h4>Bearing the following information and descriptions:</h4>
    <table class="info-table">
        <tr>
            <td><strong>Brand:</strong></td>
            <td><?= $Brand; ?></td>
            <td><strong>Date of Acquisition:</strong></td>
            <td><?= $DateOfAcquisition; ?></td>
        </tr>
        <tr>
            <td><strong>Model:</strong></td>
            <td><?= $Model; ?></td>
            <td><strong>Max. Length of Guide Bar:</strong></td>
            <td><?= $MaxLengthGuideBar; ?> cm</td>
        </tr>
        <tr>
            <td><strong>Serial No.:</strong></td>
            <td><?= $SerialNo; ?></td>
            <td><strong>Issued On:</strong></td>
            <td><?= $IssuedDate; ?></td>
        </tr>
        <tr>
            <td><strong>Horsepower:</strong></td>
            <td><?= $Horsepower; ?></td>
            <td><strong>Expiry Date:</strong></td>
            <td><?= $ExpiryDate; ?></td>
        </tr>

    </table>
    <br>
    <!-- Signature Section -->
    <div class="signature">
        <p>APPROVED BY:</p> <!-- Plain text for "APPROVED BY" -->

        <div class="signature-area">
            <div class="signature-line"></div> <!-- Signature line -->
            <p class="head-of-office"><?= strtoupper($HeadOfOffice); ?></p> <!-- Bold for Head of Office -->
            <p class="position"><?= $Position; ?></p> <!-- Plain text for Position -->
        </div>
    </div>

    <!-- Terms and Conditions -->
    <div class="terms">
        <p>1. The registered chainsaw shall be used for legitimate purposes only. Unauthorized use shall be grounds for cancellation of this certificate.</p>
        <p>2. Inform the nearest DENR office within 3 calendar days if lost.</p>
        <p>3. Report unserviceable chainsaw for revocation of registration.</p>
        <p>4. An authenticated copy must accompany the chainsaw at all times.</p>
        <p>5. Chainsaw use requires a valid permit from DENR.</p>
    </div>
    <br>
    <!-- Footer Section -->
    <div class="footer">
        <div class="footer-content">
            <div class="qr-container">
                <img id="footerQRCode" alt="QR Code">
            </div>
            <div class="photo-container">
                <img src="<?= base_url('uploads/images/' . $Image); ?>" alt="Owner Photo">
            </div>
            <div class="owner-info">
                <p><strong><?= strtoupper($Fullname); ?></strong></p>
                <p><?= ucfirst(strtolower($Brand)); ?></p>
                <p><?= $SerialNo; ?></p>
                <p><?= $ExpiryDate; ?></p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const regsNo = '<?= $RegistrationNo; ?>'; // Replace this with dynamic PHP variable or static value for testing
            const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(regsNo)}`;

            // Ensure both IDs exist in the HTML
            const mainQRCode = document.getElementById('qrCode');
            const footerQRCode = document.getElementById('footerQRCode');

            if (mainQRCode) {
                mainQRCode.src = qrCodeUrl;
            } else {
                console.error('Main QR Code element not found!');
            }

            if (footerQRCode) {
                footerQRCode.src = qrCodeUrl;
            } else {
                console.error('Footer QR Code element not found!');
            }
        });
        window.onload = function() {
            window.print();
        };

        window.onafterprint = function() {
            window.close(); // Close the window only after printing completes
        };
    </script>

</body>

</html>