<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Released Clients</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Released Clients</h5>
                        <button class="btn btn-success" id="printAllButton">Print All</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Registration No</th>
                                    <th>Fullname</th>
                                    <th>Barangay</th>
                                    <th>Municipality</th>
                                    <th>Province</th>
                                    <th>Brand</th>
                                    <th>Model</th>
                                    <th>Serial No</th>
                                    <th>Registered Date</th>
                                </tr>
                            </thead>
                            <tbody id="clientTableBody">
                                <tr>
                                    <td colspan="9" class="text-center">No data available</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        
        // Populate the table with client data
        function populateClientTable(clients) {
            const tableBody = document.getElementById('clientTableBody');
            tableBody.innerHTML = ''; // Clear existing content

            if (clients.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="9" class="text-center">No data available</td></tr>`;
            } else {
                clients.forEach(client => {
                    const row = `
                        <tr>
                            <td>${client.RegistrationNo}</td>
                            <td>${client.Fullname}</td>
                            <td>${client.Barangay}</td>
                            <td>${client.Municipality}</td>
                            <td>${client.Province}</td>
                            <td>${client.Brand}</td>
                            <td>${client.Model}</td>
                            <td>${client.SerialNo}</td>
                            <td>${client.CreatedDate}</td>
                        </tr>`;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });
            }
        }

        // Print function to print the entire table
        document.getElementById('printAllButton').addEventListener('click', function () {
            const printContent = document.querySelector('.table-responsive').innerHTML;
            const originalContent = document.body.innerHTML;

            document.body.innerHTML = printContent;
            window.print();

            document.body.innerHTML = originalContent;
            window.location.reload(); // Reload the page after printing
        });

        // Populate the table with example data (replace with real data)
        populateClientTable(exampleClients);
    </script>
</body>

</html>
