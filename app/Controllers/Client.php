<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\ClientModel1;
use App\Models\UserModel;
use App\Models\PaymentModel;
use CodeIgniter\Controller;
use Exception;
use \DateTime;

class Client extends Controller
{

    public function register() //Php Client Chainsaw Registration
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'UserID' => 'required',
            'Fullname' => 'required',
            'ContactNo' => 'required',
            'Barangay' => 'required',
            'Municipality' => 'required',
            'Province' => 'required',
            'Brand' => 'required',
            'Model' => 'required',
            'EngineCapacity' => 'required',
            'SerialNo' => 'required',
            'DateOfAcquisition' => 'required',
            'MaxLengthGuideBar' => 'required',
            'Horsepower' => 'required',
            'Purpose' => 'required',
            'OfficeName' => 'required',
            'RegsType' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,2048]|is_image[Image]',
            'ProfOwnShip' => 'uploaded[ProfOwnShip]|max_size[ProfOwnShip,2048]|mime_in[ProfOwnShip,application/pdf,image/jpeg,image/png,image/gif]',
            'CertBrgy' => 'uploaded[CertBrgy]|max_size[CertBrgy,2048]|mime_in[CertBrgy,application/pdf,image/jpeg,image/png,image/gif]',
            'CertRegs' => 'uploaded[CertRegs]|max_size[CertRegs,2048]|mime_in[CertRegs,application/pdf,image/jpeg,image/png,image/gif]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $validation->getErrors(),
            ]);
        }

        // Ensure directories for file uploads exist
        $this->ensureDirectoriesExist();

        try {
            $imageName = $this->handleFileUpload('Image', 'uploads/images');
            $profownName = $this->handleFileUpload('ProfOwnShip', 'uploads/files');
            $barangayCertName = $this->handleFileUpload('CertBrgy', 'uploads/files');
            $certRegsName = $this->handleFileUpload('CertRegs', 'uploads/files');

            if (!$imageName || !$profownName || !$barangayCertName || !$certRegsName) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'File upload failed. Please check file sizes and formats.',
                ]);
            }

            // Get the current date and time
            $createdDate = new DateTime();

            // Clone the created date to modify for expiry
            $expiryDate = (clone $createdDate)->modify('+24 months')->format('Y-m-d');

            // Generate the month and year from the current date
            $month = $createdDate->format('F');
            $year = $createdDate->format('Y');

            // Get the last RegistrationNo
            $clientModel = new ClientModel();
            $lastClient = $clientModel->orderBy('RegistrationNo', 'DESC')->first();

            // Generate the next RegistrationNo
            $nextNumber = 1;
            if ($lastClient && !empty($lastClient->RegistrationNo)) {
                $lastNumber = (int) substr($lastClient->RegistrationNo, -10);
                $nextNumber = $lastNumber + 1;
            }

            // Format the new RegistrationNo
            $registrationNo = $year . 'REGS' . str_pad($nextNumber, 10, '0', STR_PAD_LEFT);

            // Prepare data for database insertion
            $clientData = [
                'UserID'               => $this->request->getPost('UserID'),
                'Fullname'             => $this->request->getPost('Fullname'),
                'ContactNo'            => $this->request->getPost('ContactNo'),
                'Barangay'             => $this->request->getPost('Barangay'),
                'Municipality'         => $this->request->getPost('Municipality'),
                'Province'             => $this->request->getPost('Province'),
                'Brand'                => $this->request->getPost('Brand'),
                'Model'                => $this->request->getPost('Model'),
                'EngineCapacity'       => $this->request->getPost('EngineCapacity'),
                'SerialNo'             => $this->request->getPost('SerialNo'),
                'DateOfAcquisition'    => $this->request->getPost('DateOfAcquisition'),
                'MaxLengthGuideBar'    => $this->request->getPost('MaxLengthGuideBar'),
                'Horsepower'           => $this->request->getPost('Horsepower'),
                'Purpose'              => $this->request->getPost('Purpose'),
                'OfficeName'           => $this->request->getPost('OfficeName'),
                'HeadOfOffice'         => $this->request->getPost('HeadOfOffice'),
                'Position'             => $this->request->getPost('Position'),
                'OfficeAddress'        => $this->request->getPost('OfficeAddress'),
                'Telefax'              => $this->request->getPost('Telefax'),
                'EmailAdd'             => $this->request->getPost('EmailAdd'),
                'Status'               => 'Pending',
                'PaymentStatus'        => 'For Payment',
                'RegsType'             => $this->request->getPost('RegsType'),
                'Image'                => $imageName,
                'ProfOwnShip'          => $profownName,
                'ProfOwnShipFilePath'  => 'uploads/files/' . $profownName,
                'CertBrgy'             => $barangayCertName,
                'CertBrgyFilePath'     => 'uploads/files/' . $barangayCertName,
                'CertRegs'             => $certRegsName,
                'CertRegsFilePath'     => 'uploads/files/' . $certRegsName,
                'Month'                => $month,
                'Year'                 => $year,
                'ExpiryDate'           => $expiryDate,
                'CreatedDate'          => $createdDate->format('Y-m-d H:i:s'),  // Correct current date
                'RegistrationNo'       => $registrationNo,  // Generated RegistrationNo
                'Remarks'              => 'For evaluation',
            ];

            $clientModel = new ClientModel();

            // Perform the insert operation
            $insertResult = $clientModel->insert($clientData);

            // Check if insertion was successful
            if ($insertResult !== false) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Registration successful!',
                ]);
            } else {
                // Throw an exception if insert returns false
                throw new \Exception('Database insertion failed.');
            }
        } catch (\Exception $e) {
            // Log the error and return it in the JSON response
            log_message('error', 'Exception caught during registration: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to save registration. Exception occurred: ' . $e->getMessage(),
            ]);
        }
    }

    public function registerC() //Flutter Client Chainsaw Registration
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'UserID'           => 'required',
            'Fullname'           => 'required',
            'Barangay'           => 'required',
            'Municipality'       => 'required',
            'Province'           => 'required',
            'Brand'              => 'required',
            'Model'              => 'required',
            'EngineCapacity'     => 'required',
            'SerialNo'           => 'required',
            'DateOfAcquisition'  => 'required',
            'MaxLengthGuideBar'  => 'required',
            'Horsepower'         => 'required',
            'Purpose'            => 'required',
            'RegsType'           => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,2048]|is_image[Image]',
            'ProfOwnShip' => 'uploaded[ProfOwnShip]|max_size[ProfOwnShip,2048]|mime_in[ProfOwnShip,application/pdf,image/jpeg,image/png,image/gif]',
            'CertBrgy' => 'uploaded[CertBrgy]|max_size[CertBrgy,2048]|mime_in[CertBrgy,application/pdf,image/jpeg,image/png,image/gif]',
            'CertRegs' => 'uploaded[CertRegs]|max_size[CertRegs,2048]|mime_in[CertRegs,application/pdf,image/jpeg,image/png,image/gif]',
        ]);

        //Flutter
        if (!$validation->withRequest($this->request)->run()) {
            log_message('error', 'Validation Errors: ' . json_encode($validation->getErrors()));
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validation->getErrors(),
            ]);
        }

        // Ensure directories for file uploads exist
        $this->ensureDirectoriesExist();

        try {
            $imageName = $this->handleFileUpload('Image', 'uploads/images');
            $profownName = $this->handleFileUpload('ProfOwnShip', 'uploads/files');
            $barangayCertName = $this->handleFileUpload('CertBrgy', 'uploads/files');
            $certRegsName = $this->handleFileUpload('CertRegs', 'uploads/files');

            if (!$imageName || !$profownName || !$barangayCertName || !$certRegsName) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'File upload failed. Please check file sizes and formats.',
                ]);
            }

            // Get the current date and time
            $createdDate = new DateTime();

            // Clone the created date to modify for expiry
            $expiryDate = (clone $createdDate)->modify('+24 months')->format('Y-m-d');

            // Generate the month and year from the current date
            $month = $createdDate->format('F');
            $year = $createdDate->format('Y');

            // Get the last RegistrationNo
            $clientModel = new ClientModel();
            $lastClient = $clientModel->orderBy('RegistrationNo', 'DESC')->first();

            // Generate the next RegistrationNo
            $nextNumber = 1;
            if ($lastClient && !empty($lastClient->RegistrationNo)) {
                $lastNumber = (int) substr($lastClient->RegistrationNo, -10);
                $nextNumber = $lastNumber + 1;
            }

            // Format the new RegistrationNo
            $registrationNo = $year . 'REGS' . str_pad($nextNumber, 10, '0', STR_PAD_LEFT);

            // Prepare data for database insertion
            $clientData = [
                'UserID'             => $this->request->getPost('UserID'),
                'Fullname'             => $this->request->getPost('Fullname'),
                'ContactNo'            => $this->request->getPost('ContactNo'),
                'Barangay'             => $this->request->getPost('Barangay'),
                'Municipality'         => $this->request->getPost('Municipality'),
                'Province'             => $this->request->getPost('Province'),
                'Brand'                => $this->request->getPost('Brand'),
                'Model'                => $this->request->getPost('Model'),
                'EngineCapacity'       => $this->request->getPost('EngineCapacity'),
                'SerialNo'             => $this->request->getPost('SerialNo'),
                'DateOfAcquisition'    => $this->request->getPost('DateOfAcquisition'),
                'MaxLengthGuideBar'    => $this->request->getPost('MaxLengthGuideBar'),
                'Horsepower'           => $this->request->getPost('Horsepower'),
                'Purpose'              => $this->request->getPost('Purpose'),
                'OfficeName'           => $this->request->getPost('OfficeName'),
                'HeadOfOffice'         => $this->request->getPost('HeadOfOffice'),
                'Position'             => $this->request->getPost('Position'),
                'OfficeAddress'        => $this->request->getPost('OfficeAddress'),
                'Telefax'              => $this->request->getPost('Telefax'),
                'EmailAdd'             => $this->request->getPost('EmailAdd'),
                'Status'               => 'Pending',
                'PaymentStatus'        => 'For Payment',
                'RegsType'             => $this->request->getPost('RegsType'),
                'Image'                => $imageName,
                'ProfOwnShip'          => $profownName,
                'ProfOwnShipFilePath'  => 'uploads/files/' . $profownName,
                'CertBrgy'             => $barangayCertName,
                'CertBrgyFilePath'     => 'uploads/files/' . $barangayCertName,
                'CertRegs'             => $certRegsName,
                'CertRegsFilePath'     => 'uploads/files/' . $certRegsName,
                'Month'                => $month,
                'Year'                 => $year,
                'ExpiryDate'           => $expiryDate,
                'CreatedDate'          => $createdDate->format('Y-m-d H:i:s'),
                'RegistrationNo'       => $registrationNo,
                'Remarks'              => 'For evaluation',
            ];

            $clientModel = new ClientModel();

            // Perform the insert operation
            $insertResult = $clientModel->insert($clientData);

            // Check if insertion was successful
            if ($insertResult !== false) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Registration successful!',
                ]);
            } else {
                // Throw an exception if insert returns false
                throw new \Exception('Database insertion failed.');
            }
        } catch (\Exception $e) {
            // Log the error and return it in the JSON response
            log_message('error', 'Exception caught during registration: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to save registration. Exception occurred: ' . $e->getMessage(),
            ]);
        }
    }

    public function registerEdit() // Flutter Client Chainsaw Registration Update
    {
        $validation = \Config\Services::validation();
    
        $validation->setRules([
            'RegistrationNo'      => 'required',
            'UserID'              => 'required',
            'Fullname'            => 'required',
            'Barangay'            => 'required',
            'Municipality'        => 'required',
            'Province'            => 'required',
            'Brand'               => 'required',
            'Model'               => 'required',
            'EngineCapacity'      => 'required',
            'SerialNo'            => 'required',
            'DateOfAcquisition'   => 'required',
            'MaxLengthGuideBar'   => 'required',
            'Horsepower'          => 'required',
            'Purpose'             => 'required',
            'RegsType'            => 'required',
            'Image'               => 'max_size[Image,2048]|is_image[Image]',
            'ProfOwnShip'         => 'max_size[ProfOwnShip,2048]|mime_in[ProfOwnShip,application/pdf,image/jpeg,image/png,image/gif]',
            'CertBrgy'            => 'max_size[CertBrgy,2048]|mime_in[CertBrgy,application/pdf,image/jpeg,image/png,image/gif]',
            'CertRegs'            => 'max_size[CertRegs,2048]|mime_in[CertRegs,application/pdf,image/jpeg,image/png,image/gif]',
        ]);
    
        if (!$validation->withRequest($this->request)->run()) {
            log_message('error', 'Validation Errors: ' . json_encode($validation->getErrors()));
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validation->getErrors(),
            ]);
        }
    
        $clientModel = new ClientModel();
        $registrationNo = $this->request->getPost('RegistrationNo');
        
        // Check if the record exists
        $existingRecord = $clientModel->where('RegistrationNo', $registrationNo)->first();
    
        if (!$existingRecord) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Registration not found.',
            ]);
        }
    
        // Ensure directories for file uploads exist
        $this->ensureDirectoriesExist();
    
        try {
            $imageName = $existingRecord->Image;
            $profownName = $existingRecord->ProfOwnShip;
            $barangayCertName = $existingRecord->CertBrgy;
            $certRegsName = $existingRecord->CertRegs;
    
            // Handle file uploads if new files are provided
            if ($this->request->getFile('Image')->isValid()) {
                $imageName = $this->handleFileUpload('Image', 'uploads/images');
            }
            if ($this->request->getFile('ProfOwnShip')->isValid()) {
                $profownName = $this->handleFileUpload('ProfOwnShip', 'uploads/files');
            }
            if ($this->request->getFile('CertBrgy')->isValid()) {
                $barangayCertName = $this->handleFileUpload('CertBrgy', 'uploads/files');
            }
            if ($this->request->getFile('CertRegs')->isValid()) {
                $certRegsName = $this->handleFileUpload('CertRegs', 'uploads/files');
            }
    
            // Prepare data for database update
            $clientData = [
                'UserID'             => $this->request->getPost('UserID'),
                'Fullname'           => $this->request->getPost('Fullname'),
                //'ContactNo'          => $this->request->getPost('ContactNo'),
                'Barangay'           => $this->request->getPost('Barangay'),
                'Municipality'       => $this->request->getPost('Municipality'),
                'Province'           => $this->request->getPost('Province'),
                'Brand'              => $this->request->getPost('Brand'),
                'Model'              => $this->request->getPost('Model'),
                'EngineCapacity'     => $this->request->getPost('EngineCapacity'),
                'SerialNo'           => $this->request->getPost('SerialNo'),
                'DateOfAcquisition'  => $this->request->getPost('DateOfAcquisition'),
                'MaxLengthGuideBar'  => $this->request->getPost('MaxLengthGuideBar'),
                'Horsepower'         => $this->request->getPost('Horsepower'),
                'Purpose'            => $this->request->getPost('Purpose'),
                //'OfficeName'         => $this->request->getPost('OfficeName'),
                //'HeadOfOffice'       => $this->request->getPost('HeadOfOffice'),
                //'Position'           => $this->request->getPost('Position'),
                //'OfficeAddress'      => $this->request->getPost('OfficeAddress'),
                //'Telefax'            => $this->request->getPost('Telefax'),
                //'EmailAdd'           => $this->request->getPost('EmailAdd'),
                'RegsType'           => $this->request->getPost('RegsType'),
                'Status'             => 'Pending',
                'PaymentStatus'      => 'For Payment',
                'Image'              => $imageName,
                'ProfOwnShip'        => $profownName,
                'ProfOwnShipFilePath'=> 'uploads/files/' . $profownName,
                'CertBrgy'           => $barangayCertName,
                'CertBrgyFilePath'   => 'uploads/files/' . $barangayCertName,
                'CertRegs'           => $certRegsName,
                'CertRegsFilePath'   => 'uploads/files/' . $certRegsName,
                'Remarks'            => 'For re-evaluation',
                'UpdatedDate'        => date('Y-m-d H:i:s')
            ];
    
            // Update the record in the database
            $updateResult = $clientModel->update($registrationNo, $clientData);
    
            if ($updateResult !== false) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Registration updated successfully!',
                ]);
            } else {
                throw new \Exception('Database update failed.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception caught during registration update: ' . $e->getMessage());
    
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update registration. Exception occurred: ' . $e->getMessage(),
            ]);
        }
    }
    

    // Ensure directories for uploads exist
    private function ensureDirectoriesExist3()
    {
        if (!is_dir('uploads/images')) {
            mkdir('uploads/images', 0777, true);
        }

        if (!is_dir('uploads/files')) {
            mkdir('uploads/files', 0777, true);
        }
    }

    // Handle file upload and return the new file name or false on failure
    private function handleFileUpload3($fileInputName, $destinationPath)
    {
        $file = $this->request->getFile($fileInputName);

        if (!$file->isValid()) {
            log_message('error', "File Upload Error: {$fileInputName} - " . $file->getErrorString());
            return false;
        }

        if ($file->hasMoved()) {
            log_message('error', "File already moved: {$fileInputName}");
            return false;
        }

        $newFileName = $file->getRandomName();

        if ($file->move($destinationPath, $newFileName)) {
            log_message('info', "{$fileInputName} saved to {$destinationPath}/{$newFileName}");
            return $newFileName;
        } else {
            log_message('error', "Failed to move file: {$fileInputName}");
            return false;
        }
    }


    /* public function updateClientStatus($id)
{
    log_message('info', 'Received RegistrationNo: ' . $id);  // Log the incoming RegistrationNo

    $clientModel = new ClientModel();
    
    // Query based on the passed RegistrationNo (assuming the ID is hashed in the frontend)
    $client = $clientModel
        ->where('MD5(CONCAT(TRIM(RegistrationNo), "Confirm"))', $id)
        ->first();
    
    if ($client) {
        // Get the new status and remarks from the POST request
        $status = $this->request->getPost('Status');
        $remarks = $this->request->getPost('remarks');
        
        // Check if status is provided
        if (empty($status)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Status is required.']);
        }

        // Update the client status and UpdatedDate
        $updatedDate = new DateTime();  // Current timestamp
        $dataToUpdate = [
            'Status' => $status,
            'Remarks' => $remarks,  // Optional remarks, make sure to have this column in your database if needed
            'UpdatedDate' => $updatedDate->format('Y-m-d H:i:s'),
        ];

        // Generate encrypted QR code for the SerialNo
        $serialNo = $client->SerialNo;
        $encryptedSerialNo = md5($serialNo);

        // Add the encrypted QR code value to the update data
        $dataToUpdate['QRCode'] = $encryptedSerialNo;  // Ensure your table has a QRCode field

        // Update the client record
        if ($clientModel->update($client->RegistrationNo, $dataToUpdate)) {
            log_message('info', 'Client status and QR code updated successfully for RegistrationNo: ' . $client->RegistrationNo);

            // Respond with success
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Client status updated successfully!',
                'QRCode' => $encryptedSerialNo  // Return the QR code for use in the frontend if necessary
            ]);
        } else {
            // Handle update failure
            log_message('error', 'Failed to update client status for RegistrationNo: ' . $client->RegistrationNo);
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update client status.']);
        }
    } else {
        // If no client found
        log_message('error', 'Client not found for RegistrationNo: ' . $id);
        return $this->response->setJSON(['success' => false, 'message' => 'Client not found.']);
    }
} */

    public function updateClientStatus($hashedRegistrationNo)
    {
        $clientModel = new ClientModel();

        // Find the client based on the hashed RegistrationNo
        $client = $clientModel
            ->where('MD5(CONCAT(TRIM(RegistrationNo), "Confirm"))', $hashedRegistrationNo)
            ->first();

        if ($client) {
            // Prepare data for update
            $updateData = [
                'Status' => $this->request->getPost('Status'),
                'UpdatedDate' => date('Y-m-d H:i:s'),
                'Remarks' => $this->request->getPost('remarks'),
                'QRCode' => md5($client->SerialNo) // Example QR Code logic
            ];

            // Update the client data
            if ($clientModel->update($client->RegistrationNo, $updateData)) {
                return $this->response->setJSON([
                    'success' => true,
                    'QRCode' => $updateData['QRCode'],
                    'message' => 'Client status updated successfully!',
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to update client status.',
                ]);
            }
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Client not found.',
            ]);
        }
    }

    /**
     * Ensure the necessary directories for file uploads exist
     */
    private function ensureDirectoriesExist()
    {
        if (!is_dir('uploads/images')) {
            mkdir('uploads/images', 0777, true);
        }

        if (!is_dir('uploads/files')) {
            mkdir('uploads/files', 0777, true);
        }
    }

    /**
     * Handle file upload and return the new file name
     * @param string $fileInputName The name of the file input field
     * @param string $destinationPath The path to move the uploaded file
     * @return string|false The new file name or false if the upload failed
     */
    private function handleFileUpload($fileInputName, $destinationPath)
    {
        $file = $this->request->getFile($fileInputName);

        if ($file->isValid() && !$file->hasMoved()) {
            $newFileName = $file->getRandomName();
            if ($file->move($destinationPath, $newFileName)) {
                return $newFileName;
            } else {
                log_message('error', "Failed to move file: {$fileInputName}");
                return false;
            }
        } else {
            log_message('error', "Invalid or moved file: {$fileInputName} with error: " . $file->getErrorString());
            return false;
        }
    }

    public function confirmation1()
    {
        // Initialize the ClientModel
        $clientModel = new ClientModel();

        // Use a join query to merge data from tblusers
        $clientData = $clientModel
            ->select('tblregistration.*, tblusers.ContactNo')  // Select all fields from tlbregistration and ContactNo from tblusers
            ->join('tblusers', 'tblusers.UserID = tblregistration.UserID') // Join tblusers on RegistrationNo
            ->where('tblregistration.Status', 'Pending')       // Filter by Status in tlbregistration
            ->findAll();                                       // Fetch filtered client records

        // Pass the merged client data to the view
        return view('client/confirmation', [
            'clientData' => $clientData
        ]);
    }

    public function confirmation()
    {
        // Start a session to retrieve user data
        $session = session();
        $userData = $session->get('userData'); // Assuming user data is stored in the session

        // Get the OfficeName from the logged-in user
        $userOffice = $userData['OfficeName'];

        // Initialize the ClientModel
        $clientModel = new ClientModel();

        // Use a join query to merge data from tblusers and filter by OfficeName
        $clientData = $clientModel
            ->select('tblregistration.*, tblusers.ContactNo')  // Select all fields from tlbregistration and ContactNo from tblusers
            ->join('tblusers', 'tblusers.UserID = tblregistration.UserID') // Join tblusers on UserID
            ->where('tblregistration.Status', 'Pending')       // Filter by Status in tlbregistration
            ->where('tblusers.OfficeName', $userOffice)        // Filter by OfficeName of the logged-in user
            ->findAll();                                       // Fetch filtered client records

        // Pass the merged client data to the view
        return view('client/confirmation', [
            'clientData' => $clientData
        ]);
    }


    public function getClientDetailsByStatusAndPayment1($status, $paymentStatus = '')
    {
        $clientModel = new ClientModel();

        // If paymentStatus is provided, filter by both status and paymentStatus
        if (!empty($paymentStatus)) {
            $clients = $clientModel
                ->where('Status', $status)
                ->where('PaymentStatus', $paymentStatus)
                ->findAll();
        } else {
            // If paymentStatus is not provided, filter by status only
            $clients = $clientModel
                ->where('Status', $status)
                ->findAll();
        }

        if ($clients) {
            return $this->response->setJSON([
                'success' => true,
                'clients' => $clients
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No clients found.'
            ]);
        }
    }

    public function getClientDetailsByStatusAndPayment($status, $paymentStatus = '')
    {
        $session = session();
        $userData = $session->get('userData'); // Assuming user data is stored in the session

        // Retrieve the OfficeName of the logged-in user
        $userOffice = $userData['OfficeName'];

        $clientModel = new ClientModel();

        // If paymentStatus is provided, filter by both status, paymentStatus, and OfficeName
        if (!empty($paymentStatus)) {
            $clients = $clientModel
                ->where('Status', $status)
                ->where('PaymentStatus', $paymentStatus)
                ->where('OfficeName', $userOffice)
                ->findAll();
        } else {
            // If paymentStatus is not provided, filter by status and OfficeName only
            $clients = $clientModel
                ->where('Status', $status)
                ->where('OfficeName', $userOffice)
                ->findAll();
        }

        if ($clients) {
            return $this->response->setJSON([
                'success' => true,
                'clients' => $clients
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No clients found.'
            ]);
        }
    }

    public function releasing1()
    {
        // Initialize the ClientModel
        $clientModel = new ClientModel();

        // Fetch client data where Status is 'Confirmed' OR 'Released' AND PaymentStatus is 'Paid'
        $clientData = $clientModel->where('Status', 'Confirmed') // Allow both statuses
            ->where('PaymentStatus', 'Paid') // Ensure PaymentStatus is 'Paid'
            ->findAll();  // Fetch filtered client records

        // Pass the filtered client data to the view
        return view('client/releasing', [
            'clientData' => $clientData
        ]);
    }

    public function releasing() // Status after release must be For Printing or Printing
    {
        // Start a session to retrieve user data
        $session = session();
        $userData = $session->get('userData'); // Assuming user data is stored in the session

        // Get the OfficeName from the logged-in user
        $userOffice = $userData['OfficeName'];

        // Initialize the ClientModel
        $clientModel = new ClientModel();

        // Fetch client data where Status is 'Confirmed' or 'Released' AND PaymentStatus is 'Paid'
        // and filter by the user's OfficeName
        $clientData = $clientModel
            ->whereIn('Status', ['Confirmed']) // Allow both statuses
            ->where('PaymentStatus', 'Paid')              // Ensure PaymentStatus is 'Paid'
            ->where('OfficeName', $userOffice)            // Filter by OfficeName of the logged-in user
            ->findAll();                                  // Fetch filtered client records

        // Pass the filtered client data to the view
        return view('client/releasing', [
            'clientData' => $clientData
        ]);
    }


    public function print1()
    {
        // Initialize the ClientModel
        $clientModel = new ClientModel();

        // Fetch client data where Status is 'Confirmed' OR 'Released' AND PaymentStatus is 'Paid'
        $clientData = $clientModel->where('Status', 'Released') // Allow both statuses
            ->where('PaymentStatus', 'Paid') // Ensure PaymentStatus is 'Paid'
            ->findAll();  // Fetch filtered client records

        // Pass the filtered client data to the view
        return view('client/print', [
            'clientData' => $clientData
        ]);
    }

    public function print()
    {
        // Start a session to retrieve user data
        $session = session();
        $userData = $session->get('userData'); // Assuming user data is stored in the session

        // Get the OfficeName from the logged-in user
        $userOffice = $userData['OfficeName'];

        // Initialize the ClientModel
        $clientModel = new ClientModel();

        // Fetch client data where Status is 'Released' AND PaymentStatus is 'Paid',
        // and filter by the user's OfficeName
        $clientData = $clientModel
            ->where('Status', 'Released')       // Ensure Status is 'Released'
            ->where('PaymentStatus', 'Released')   // Ensure PaymentStatus is 'Paid'
            ->where('OfficeName', $userOffice) // Filter by OfficeName of the logged-in user
            ->findAll();                       // Fetch filtered client records

        // Pass the filtered client data to the view
        return view('client/print', [
            'clientData' => $clientData
        ]);
    }

    public function printCashier()
    {
        // Start a session to retrieve user data
        $session = session();
        $userData = $session->get('userData'); // Assuming user data is stored in the session

        // Get the OfficeName from the logged-in user
        $userOffice = $userData['OfficeName'];

        // Initialize the ClientModel
        $clientModel = new ClientModel();

        // Fetch client data where Status is 'Released' AND PaymentStatus is 'Paid',
        // and filter by the user's OfficeName
        $clientData = $clientModel
            ->where('Status', 'Released')       // Ensure Status is 'Released'
            ->where('PaymentStatus', 'Released')   // Ensure PaymentStatus is 'Paid'
            ->where('OfficeName', $userOffice) // Filter by OfficeName of the logged-in user
            ->findAll();                       // Fetch filtered client records

        // Pass the filtered client data to the view
        return view('client/printCashier', [
            'clientData' => $clientData
        ]);
    }

    public function reports1()
    {
        // Initialize the ClientModel
        $clientModel = new ClientModel();

        // Fetch client data from the database
        $clientData = $clientModel->findAll();  // Fetch all client records

        // Pass the client data to the view
        return view('client/reports', [
            'clientData' => $clientData
        ]);
    }

    public function reports()
    {
        // Start a session to retrieve user data
        $session = session();
        $userData = $session->get('userData'); // Assuming user data is stored in the session

        // Get the OfficeName from the logged-in user
        $userOffice = $userData['OfficeName'];

        // Initialize the ClientModel
        $clientModel = new ClientModel();

        // Fetch client data filtered by the user's OfficeName
        $clientData = $clientModel
            ->where('OfficeName', $userOffice) // Filter by OfficeName of the logged-in user
            ->findAll();                      // Fetch filtered client records

        // Pass the filtered client data to the view
        return view('client/reports', [
            'clientData' => $clientData
        ]);
    }

    public function getFiles($id)
    {
        $clientModel = new ClientModel();

        // Retrieve client record using the hashed ApplicationNo
        $client = $clientModel->where('MD5(CONCAT(RegistrationNo, "View Files"))', $id)->first();

        if ($client) {
            // Assuming the file paths are stored in the database fields
            $proofOfOwnership = base_url('uploads/files/' . $client->ProfOwnShip);
            $barangayCertificate = base_url('uploads/files/' . $client->CertBrgy);
            $registrationCertificate = base_url('uploads/files/' . $client->CertRegs);

            // Assuming Fullname is a field in the client record
            $fullName = $client->Fullname; // Retrieve the full name from the client object

            // Return JSON with the file paths
            return $this->response->setJSON([
                'success' => true,
                'fullName' => $fullName,
                'files' => [
                    'Proof of Ownership' => $proofOfOwnership,
                    'Barangay Certificate' => $barangayCertificate,
                    'Registration Certificate' => $registrationCertificate
                ]
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Files not found.'
            ]);
        }
    }

    /*  public function getClientInfo($id)
    {
        log_message('info', 'Received RegistrationNo: ' . $id);  // Log the incoming RegistrationNo
    
        $clientModel = new ClientModel();
    
        // Query based on ApplicationNo (assuming plain value is passed from the frontend)
        $client = $clientModel
            ->where('MD5(CONCAT(TRIM(RegistrationNo), "Confirm"))', $id)
            ->first();
    
        // Log the generated query for debugging
        log_message('info', 'Generated Query: ' . $clientModel->db->getLastQuery());
    
        if ($client) {
            log_message('info', 'Client found for RegistrationNo: ' . $client->RegistrationNo);  // Log if a client is found
    
            $clientInfo = [
                'Fullname' => $client->Fullname,
                'ContactNo' => $client->ContactNo,
                'Brand' => $client->Brand,
                'Model' => $client->Model,
                'EngineCapacity' => $client->EngineCapacity,
                'SerialNo' => $client->SerialNo,
                'CreatedDate' => $client->CreatedDate,
                'RegistrationNo' => $client->RegistrationNo // Add this to pass the original RegistrationNo back
            ];
    
            return $this->response->setJSON(['success' => true, 'client' => $clientInfo]);
        } else {
            log_message('error', 'Client not found for RegistrationNo: ' . $id);  // Log if no client is found
            return $this->response->setJSON(['success' => false, 'message' => 'Client not found.']);
        }
    } */

    public function getClientInfo1($id) //original
    {
        log_message('info', 'Received RegistrationNo: ' . $id);  // Log the incoming RegistrationNo

        $clientModel = new ClientModel();

        // Query based on the hashed RegistrationNo
        $client = $clientModel
            ->where('MD5(CONCAT(TRIM(RegistrationNo), "Confirm"))', $id)
            ->first();

        // Log the generated query for debugging
        log_message('info', 'Generated Query: ' . $clientModel->db->getLastQuery());

        if ($client) {
            log_message('info', 'Client found for RegistrationNo: ' . $client->RegistrationNo);  // Log if a client is found

            // Generate the hash of RegistrationNo
            $hashedRegistrationNo = md5(trim($client->RegistrationNo) . 'Confirm');

            $clientInfo = [
                'Fullname' => $client->Fullname,
                'ContactNo' => $client->ContactNo,
                'Brand' => $client->Brand,
                'Model' => $client->Model,
                'EngineCapacity' => $client->EngineCapacity,
                'SerialNo' => $client->SerialNo,
                'CreatedDate' => $client->CreatedDate,
                'RegistrationNo' => $client->RegistrationNo,  // Plain RegistrationNo
                'HashedRegistrationNo' => $hashedRegistrationNo // Send back the hashed RegistrationNo
            ];

            return $this->response->setJSON(['success' => true, 'client' => $clientInfo]);
        } else {
            log_message('error', 'Client not found for RegistrationNo: ' . $id);  // Log if no client is found
            return $this->response->setJSON(['success' => false, 'message' => 'Client not found.']);
        }
    }

    public function getClientInfo($id)
    {
        log_message('info', 'Received RegistrationNo: ' . $id);  // Log the incoming RegistrationNo

        $clientModel = new ClientModel();

        // Join with tblusers to get ContactNo based on the hashed RegistrationNo
        $client = $clientModel
            ->select('tblregistration.*, tblusers.ContactNo') // Select all fields from tlbregistration and ContactNo from tblusers
            ->join('tblusers', 'tblusers.UserID = tblregistration.UserID') // Join tblusers on RegistrationNo
            ->where('MD5(CONCAT(TRIM(tblregistration.RegistrationNo), "Confirm"))', $id) // Query based on hashed RegistrationNo
            ->first();

        // Log the generated query for debugging
        log_message('info', 'Generated Query: ' . $clientModel->db->getLastQuery());

        if ($client) {
            log_message('info', 'Client found for RegistrationNo: ' . $client->RegistrationNo);  // Log if a client is found

            // Generate the hash of RegistrationNo
            $hashedRegistrationNo = md5(trim($client->RegistrationNo) . 'Confirm');

            $clientInfo = [
                'Fullname' => $client->Fullname,
                'ContactNo' => $client->ContactNo,  // ContactNo from tblusers
                'Brand' => $client->Brand,
                'Model' => $client->Model,
                'EngineCapacity' => $client->EngineCapacity,
                'SerialNo' => $client->SerialNo,
                'CreatedDate' => $client->CreatedDate,
                'RegistrationNo' => $client->RegistrationNo,  // Plain RegistrationNo
                'HashedRegistrationNo' => $hashedRegistrationNo // Send back the hashed RegistrationNo
            ];

            return $this->response->setJSON(['success' => true, 'client' => $clientInfo]);
        } else {
            log_message('error', 'Client not found for RegistrationNo: ' . $id);  // Log if no client is found
            return $this->response->setJSON(['success' => false, 'message' => 'Client not found.']);
        }
    }

    /* public function getClientInfoByUserID1($userID)
{
    $clientModel = new ClientModel();

    // Fetch client by userID
    $client = $clientModel->where('UserID', $userID)->first();

    if ($client) {
        $clientInfo = [
            'RegistrationNo' => $client->RegistrationNo,
            'TotalFees' => '500' // Default fee, or dynamically fetched
        ];

        // Return the JSON response
        return $this->response->setJSON(['success' => true, 'client' => $clientInfo]);
    } else {
        // Log if client is not found
        log_message('error', 'Client not found for UserID: ' . $userID);
        return $this->response->setJSON(['success' => false, 'message' => 'Client not found.']);
    }
} */

    public function getClientInfoByUserID1($userID)
    {
        $clientModel = new ClientModel();

        // Fetch client by userID where Status is Confirmed
        //$client = $clientModel->where('UserID', $userID)->where('Status', 'Confirmed')->first();
        $client = $clientModel
            ->where('UserID', $userID)
            ->where('Status', 'Confirmed')
            ->where('PaymentStatus', 'For Payment')
            ->first();

        if ($client) {
            $clientInfo = [
                'RegistrationNo' => $client->RegistrationNo,
                'TotalFees' => '500' // Default fee, or dynamically fetched
            ];

            // Return the JSON response
            return $this->response->setJSON(['success' => true, 'client' => $clientInfo]);
        } else {
            // Log if client is not found or status is not confirmed
            log_message('error', 'Client not found or not confirmed for UserID: ' . $userID);
            return $this->response->setJSON(['success' => false, 'message' => 'Client not confirmed or not found.']);
        }
    }

    public function getClientInfoByUserID($userID)
    {
        $clientModel = new \App\Models\ClientModel1();
    
        $client = $clientModel
            ->where('UserID', $userID)
            ->where('Status', 'Confirmed')
            ->where('PaymentStatus', 'For Payment')
            ->first();
    
        if ($client) {
            $clientInfo = [
                'RegistrationNo' => $client->RegistrationNo, // Ensure this field is correctly retrieved
                'TotalFees' => $client->TotalFees ?? '500', // Default Total Fees
            ];
    
            log_message('debug', 'Client Info: ' . print_r($clientInfo, true)); // Log response
    
            return $this->response->setJSON(['success' => true, 'client' => $clientInfo]);
        } else {
            log_message('error', 'No client found or not confirmed for UserID: ' . $userID);
            return $this->response->setJSON(['success' => false, 'message' => 'Client not confirmed or not found.']);
        }
    }
    
    public function updatePaymentStatus()
    {
        $clientModel = new ClientModel();

        // Get the RegistrationNo from the POST request
        $registrationNo = $this->request->getPost('RegistrationNo');

        // Log the received RegistrationNo for debugging
        log_message('info', 'RegistrationNo received: ' . $registrationNo);

        // Check if the RegistrationNo exists
        $client = $clientModel->where('RegistrationNo', $registrationNo)->first();

        if ($client) {
            // Update the PaymentStatus to "Paid"
            $clientModel->set('PaymentStatus', 'Paid')
                ->where('RegistrationNo', $registrationNo)
                ->update();

            // Log the successful update
            log_message('info', 'Payment status updated to Paid for RegistrationNo: ' . $registrationNo);

            // Return success response
            return $this->response->setJSON(['success' => true, 'message' => 'Payment status updated to Paid.']);
        } else {
            // Log if client is not found for debugging
            log_message('error', 'Client not found for RegistrationNo: ' . $registrationNo);

            // Return error response if client is not found
            return $this->response->setJSON(['success' => false, 'message' => 'Client not found for RegistrationNo: ' . $registrationNo]);
        }
    }

    public function updateRegistration()
    {
        // Load your models for interacting with the tables
        $clientModel = new ClientModel();  // For tblregistration
        $userModel = new UserModel();  // For tblusers

        // Get the form data sent via AJAX or form POST
        $registrationNo = $this->request->getPost('RegistrationNo');
        $status = $this->request->getPost('Status');
        $remarks = $this->request->getPost('Remark');  // Assuming this corresponds to 'Remarks' in your database

        // Capture the current timestamp for UpdatedDate
        $updatedDate = date('Y-m-d H:i:s');

        // Log the received data for debugging purposes
        log_message('info', 'Received RegistrationNo: ' . $registrationNo);
        log_message('info', 'Received Status: ' . $status);
        log_message('info', 'Received Remarks: ' . $remarks);
        log_message('info', 'Generated UpdatedDate: ' . $updatedDate);

        // Attempt to retrieve the record from tblregistration based on the provided RegistrationNo
        $client = $clientModel->where('MD5(CONCAT(TRIM(RegistrationNo), "Confirm"))', $registrationNo)->first();

        if ($client) {
            // Log that the client was found
            log_message('info', 'Client found for RegistrationNo: ' . $client->RegistrationNo);

            // Retrieve the SerialNo for generating the QR code
            //$serialNo = $client->SerialNo;
            $registrationNo = $client->RegistrationNo;

            // Generate the QR code URL using the SerialNo
            $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . $registrationNo;

            // Log the generated QR code URL
            log_message('info', 'Generated QR Code URL: ' . $qrCodeUrl);

            // Prepare the data for updating the database (Ensure column names match the database)
            $updateData = [
                'Status' => $status,
                'UpdatedDate' => $updatedDate, // Exact field name in your database
                'Remarks' => $remarks, // Exact field name in your database
                'QRCodeUrl' => $qrCodeUrl  // Optionally store the QR code URL in the database
            ];

            // Log the data being updated
            log_message('info', 'Update Data: ' . json_encode($updateData));

            // Update the database with the new values
            $clientModel->where('RegistrationNo', $client->RegistrationNo)->set($updateData)->update();

            // Find the corresponding user in tblusers using a common identifier (e.g., ClientID or UserID)
            $user = $userModel->where('UserID', $client->UserID)->first();  // Assuming 'UserID' is a foreign key

            if ($user) {
                // Update tblusers with the same status
                $updateDataUser = [
                    'Status' => $status // Set the same status as tblregistration
                ];

                $userModel->where('UserID', $user->UserID)->set($updateDataUser)->update();

                // Log the success of the user update
                log_message('info', 'User status updated successfully for UserID: ' . $user->UserID);
            }

            // Return success response
            return $this->response->setJSON(['success' => true, 'message' => 'Registration and user status updated successfully.']);
        } else {
            // Log the error if the client is not found
            log_message('error', 'Client not found for RegistrationNo: ' . $registrationNo);

            // Return a response indicating that the client was not found
            return $this->response->setJSON(['success' => false, 'message' => 'Registration not found.']);
        }
    }

    public function savePayment() // Php
    {
        // Load the PaymentModel and RegistrationModel
        $paymentModel = new PaymentModel();
        $registrationModel = new ClientModel();

        // Get form data from the AJAX request
        $registrationNo = $this->request->getPost('RegistrationNo');
        $totalFees = $this->request->getPost('TotalFees');
        $qrCodeSchedule = $this->request->getPost('QRCodeSchedule');
        $gcashReferenceNo = $this->request->getPost('GCashReferenceNo');
        $officeName = $this->request->getPost('OfficeName');
        $rpsChief = $this->request->getPost('RPSChief');
        $cashier = $this->request->getPost('Cashier');

        // Get the current Month, Year, and Timestamp
        $month = date('F'); // e.g., October
        $year = date('Y'); // e.g., 2024
        $createdDate = date('Y-m-d H:i:s');

        // Generate the next PaymentNo
        $lastPayment = $paymentModel->orderBy('CreatedDate', 'DESC')->first();
        $lastPaymentNo = $lastPayment ? intval(substr($lastPayment->PaymentNo, -8)) : 0;
        $nextPaymentNo = str_pad($lastPaymentNo + 1, 8, '0', STR_PAD_LEFT);
        $paymentNo = "{$year}PAYNO{$nextPaymentNo}"; // Format: YYYY + PAYNO + Sequence

        // Prepare the data to be saved in tblPayment
        $paymentData = [
            'PaymentNo' => $paymentNo,
            'RegistrationNo' => $registrationNo,
            'TotalFees' => $totalFees,
            'QRCodeSchedule' => $qrCodeSchedule,
            'GCashReferenceNo' => $gcashReferenceNo,
            'OfficeName' => $officeName,
            'RPSChief' => $rpsChief,
            'Cashier' => $cashier,
            'Month' => $month,
            'Year' => $year,
            'CreatedDate' => $createdDate
        ];

        // Attempt to insert the payment data
        $insertResult = $paymentModel->insert($paymentData);


        // Prepare the data to update tblRegistration (change Status to "Paid")
        $updateData = [
            'PaymentStatus' => 'Paid'
        ];

        // Update the Status in tblRegistration based on the RegistrationNo
        $registrationModel->where('RegistrationNo', $registrationNo)->set($updateData)->update();

        // Return a success response
        return $this->response->setJSON(['success' => true, 'message' => 'Payment saved and status updated successfully']);
    }

    public function savePaymentF() // Flutter
    {
        // Load the PaymentModel and RegistrationModel
        $paymentModel = new PaymentModel();
        $registrationModel = new ClientModel();

        // Get form data from the AJAX request
        $registrationNo = $this->request->getPost('RegistrationNo');
        $totalFees = $this->request->getPost('TotalFees');
        $qrCodeSchedule = $this->request->getPost('QRCodeSchedule');
        $gcashReferenceNo = $this->request->getPost('GCashReferenceNo');
        $officeName = $this->request->getPost('OfficeName');
        $rpsChief = $this->request->getPost('RPSChief');
        $cashier = $this->request->getPost('Cashier');

        // Get the current Month, Year, and Timestamp
        $month = date('F'); // e.g., October
        $year = date('Y'); // e.g., 2024
        $createdDate = date('Y-m-d H:i:s');

        // Generate the next PaymentNo
        $lastPayment = $paymentModel->orderBy('CreatedDate', 'DESC')->first();
        $lastPaymentNo = $lastPayment ? intval(substr($lastPayment->PaymentNo, -8)) : 0;
        $nextPaymentNo = str_pad($lastPaymentNo + 1, 8, '0', STR_PAD_LEFT);
        $paymentNo = "{$year}PAYNO{$nextPaymentNo}"; // Format: YYYY + PAYNO + Sequence

        // Prepare the data to be saved in tblPayment
        $paymentData = [
            'PaymentNo' => $paymentNo,
            'RegistrationNo' => $registrationNo,
            'TotalFees' => $totalFees,
            'QRCodeSchedule' => $qrCodeSchedule,
            'GCashReferenceNo' => $gcashReferenceNo,
            'OfficeName' => $officeName,
            'RPSChief' => $rpsChief,
            'Cashier' => $cashier,
            'Month' => $month,
            'Year' => $year,
            'CreatedDate' => $createdDate
        ];

        // Attempt to insert the payment data
        $insertResult = $paymentModel->insert($paymentData);


        // Prepare the data to update tblRegistration (change Status to "Paid")
        $updateData = [
            'PaymentStatus' => 'Paid'
        ];

        // Update the Status in tblRegistration based on the RegistrationNo
        $registrationModel->where('RegistrationNo', $registrationNo)->set($updateData)->update();

        // Return a success response
        return $this->response->setJSON(['success' => true, 'message' => 'Payment saved and status updated successfully']);
    }

    public function sendSms() //php
    {
        // Get the data from the JSON request
        $json = $this->request->getJSON(true);

        // Fetch 'ContactNo' and 'Remarks' from the JSON request
        $contactNo = $json['ContactNo'];  // Make sure it matches the exact spelling from your form
        $remarks = $json['Remarks'];  // Ensure it matches the form field

        // Check if the contact number is provided
        if ($contactNo) {
            // Semaphore SMS API parameters
            $parameters = array(
                'apikey' => '51364d51c8a5e92ccad5c04a6a54d8ca', // Replace with your Semaphore API key
                'number' => $contactNo, // The recipient's contact number
                'message' => '' . $remarks, // The SMS message
                'sendername' => 'DENR12' // Replace with your sender name registered in Semaphore
            );

            // Initialize cURL session
            $ch = curl_init();

            // Set cURL options for the Semaphore API request
            curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Execute cURL request and store the response
            $output = curl_exec($ch);

            // Log the raw output for debugging
            log_message('info', 'Semaphore API response: ' . $output);

            // Close the cURL session
            curl_close($ch);
        }
    }

    public function sendSmsF2() // flutter
    {
        // Get the JSON data from the request
        $json = $this->request->getJSON(true);
    
        // Extract LastName and ContactNo from the JSON
        $lastName = $json['LastName'];
        $contactNo = $json['ContactNo'];
    
        // Validate input
        if (empty($lastName) || empty($contactNo)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'LastName and ContactNo are required.'
            ]);
        }
    
        // Check if the user exists in the database
        $db = \Config\Database::connect();
        $builder = $db->table('tblusers');
        $user = $builder->where('LastName', $lastName)
                        ->where('ContactNo', $contactNo)
                        ->get()
                        ->getRow();
    
        if ($user) {
            // User exists, proceed with sending the SMS
            $parameters = [
                'apikey' => '51364d51c8a5e92ccad5c04a6a54d8ca', // Replace with your Semaphore API key
                'number' => $contactNo,    // The recipient's contact number
                'message' => 'Your password is: ' . $user->Password, // Include password or a secure message
                'sendername' => 'DENR12'   // Replace with your sender name
            ];
    
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
            $output = curl_exec($ch);
            curl_close($ch);
    
            log_message('info', 'Semaphore API Response: ' . $output);
    
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Password has been sent to your mobile number.'
            ]);
        } else {
            // User not found
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User not found. Please check the LastName and ContactNo.'
            ]);
        }
    }

    public function sendSmsF() //flutter
    {
        // Get the JSON data from the request
        $json = $this->request->getJSON(true);

        // Extract LastName and ContactNo from the JSON
        $lastName = $json['LastName'];
        $contactNo = $json['ContactNo'];

        // Validate input
        if (empty($lastName) || empty($contactNo)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'LastName and ContactNo are required.'
            ]);
        }

        // Check if the user exists in the database
        $db = \Config\Database::connect();
        $builder = $db->table('tblusers');
        $user = $builder->where('LastName', $lastName)
            ->where('ContactNo', $contactNo)
            ->get()
            ->getRow();

        if ($user) {
            // Generate a 6-digit OTP
            $otp = rand(100000, 999999);

            // Save the OTP in the database (optional: add expiry time)
            $builder->where('ContactNo', $contactNo)->update([
                'OTP' => $otp,
                'OTPExpiry' => date('Y-m-d H:i:s', strtotime('+10 minutes')) // OTP valid for 10 minutes
            ]);

            // Send the OTP via SMS using Semaphore
            $parameters = [
                'apikey' => '51364d51c8a5e92ccad5c04a6a54d8ca', // Replace with your Semaphore API key
                'number' => $contactNo,
                'message' => 'Your one-time (OTP) is: ' . $otp,
                'sendername' => 'DENR12'   // Replace with your registered sender name
            ];

            // Initialize cURL session for Semaphore API
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Execute cURL request and capture response
            $output = curl_exec($ch);
            curl_close($ch);

            // Log Semaphore API response for debugging
            log_message('info', 'Semaphore API Response: ' . $output);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'OTP has been sent to your mobile number.'
            ]);
        } else {
            // User not found
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User not found. Please check the LastName and ContactNo.'
            ]);
        }
    }

    public function verifyOtp()
    {
        $json = $this->request->getJSON(true);
        $contactNo = $json['ContactNo'];
        $otp = $json['OTP'];

        if (empty($contactNo) || empty($otp)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ContactNo and OTP are required.'
            ]);
        }

        $db = \Config\Database::connect();
        $builder = $db->table('tblusers');
        $user = $builder->where('ContactNo', $contactNo)
            ->where('OTP', $otp)
            ->get()
            ->getRow();

        if ($user) {
            $currentTimestamp = date('Y-m-d H:i:s');
            if ($user->OTPExpiry >= $currentTimestamp) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'OTP verified successfully.'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'OTP has expired. Please request a new OTP.'
                ]);
            }
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid OTP or ContactNo.'
            ]);
        }
    }

    public function resetPassword()
    {
        // Get the JSON data from the request
        $json = $this->request->getJSON(true);

        // Extract ContactNo and Password from the JSON
        $contactNo = $json['ContactNo'];
        $newPassword = $json['Password'];

        // Validate input
        if (empty($contactNo) || empty($newPassword)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Contact number and password are required.'
            ]);
        }

        // Hash the new password for security
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Update the password in the database
        $db = \Config\Database::connect();
        $builder = $db->table('tblusers');
        $updated = $builder->where('ContactNo', $contactNo)
            ->update(['Password' => $hashedPassword]);

        if ($updated) {
            // Return success response
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Password has been reset successfully.'
            ]);
        } else {
            // Return failure response
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to reset password. Contact number not found.'
            ]);
        }
    }

    public function releaseClient()
    {
        // Get JSON input from the request
        $request = \Config\Services::request();
        $input = $request->getJSON(true); // Parse JSON payload

        $registrationNoHash = $input['registrationNoHash'] ?? null;

        if ($registrationNoHash) {
            // Load the model
            $clientModel = new \App\Models\ClientModel();

            // Find the client by matching the hashed RegistrationNo
            $client = $clientModel->where('MD5(CONCAT(RegistrationNo, "Confirm"))', $registrationNoHash)->first();

            if ($client) {
                // Update the status to "Released"
                $data = [
                    'Status' => 'Released',
                    'PaymentStatus' => 'Released'
                ];

                if ($clientModel->update($client->RegistrationNo, $data)) {
                    return $this->response->setJSON(['success' => true]);
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status.']);
                }
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Client not found.']);
            }
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Invalid request.']);
    }

    public function printCOR($id)
    {
        $clientModel = new ClientModel();

        // Retrieve client record using the hashed RegistrationNo
        $clientData = $clientModel->where('MD5(CONCAT(RegistrationNo, "View Files"))', $id)->first();

        if ($clientData) {
            // Extract necessary data from the database
            $data = [
                'RegistrationNo' => $clientData->RegistrationNo,
                'Fullname' => $clientData->Fullname,
                'Barangay' => $clientData->Barangay,
                'Municipality' => $clientData->Municipality,
                'Province' => $clientData->Province,
                'Brand' => $clientData->Brand,
                'Model' => $clientData->Model,
                'SerialNo' => $clientData->SerialNo,
                'Horsepower' => $clientData->Horsepower,
                //'EngineCapacity' => $clientData->EngineCapacity,
                //'Purpose' => $clientData->Purpose,
                'DateOfAcquisition' => $clientData->DateOfAcquisition,
                'MaxLengthGuideBar' => $clientData->MaxLengthGuideBar,
                'IssuedDate' => $clientData->IssuedDate ?? date('Y-m-d'), // Default to today's date if not set
                'ExpiryDate' => $clientData->ExpiryDate,
                'Image' => $clientData->Image,
                'HeadOfOffice' => $clientData->HeadOfOffice,  // Fetch Head of Office
                'Position' => $clientData->Position,           // Fetch Position
                'OfficeAddress' => $clientData->OfficeAddress,
                'Telefax' => $clientData->Telefax,
                'EmailAdd' => $clientData->EmailAdd,
            ];

            return view('client/printCOR', $data);
        } else {
            return redirect()->to('client/releasing')->with('error', 'Client not found.');
        }
    }

    public function printOC($hash)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tblpayment');

        // Join tblregistration using RegistrationNo
        $builder->select('tblpayment.*, 
                      tblregistration.Fullname, 
                      tblregistration.Barangay, 
                      tblregistration.Municipality, 
                      tblregistration.HeadOfOffice,
                      tblregistration.Position,
                      tblregistration.OfficeAddress, 
                      tblregistration.Telefax, 
                      tblregistration.EmailAdd');
        $builder->join('tblregistration', 'tblpayment.RegistrationNo = tblregistration.RegistrationNo');

        // Find the record where MD5 hash of RegistrationNo matches the hash from URL
        $builder->where('MD5(tblpayment.RegistrationNo)', $hash);

        $payment = $builder->get()->getRow();

        // Check if the payment data exists
        if (!$payment) {
            return redirect()->back()->with('error', 'Payment data not found.');
        }

        // Load the view with the payment and registration data
        return view('client/printOC', ['payment' => $payment]);
    }

    public function getReleasedClients1()
    {
        // Start a session to retrieve user data
        $session = session();
        $userData = $session->get('userData'); // Assuming user data is stored in the session

        // Get the OfficeName from the logged-in user
        $userOffice = $userData['OfficeName'];

        // Instantiate the ClientModel
        $clientModel = new ClientModel();

        // Build the query to get Released clients and filter by OfficeName
        $query = $clientModel
            ->where('Status', 'Released')
            ->where('OfficeName', $userOffice); // Filter by OfficeName of the logged-in user

        // Get filter parameters from the request
        $filterType = $this->request->getGet('filterType');
        $dateFrom = $this->request->getGet('dateFrom');
        $dateTo = $this->request->getGet('dateTo');

        // Apply additional filters based on the filter type
        if ($filterType === 'barangay') {
            $query->where('Barangay !=', '');
        } elseif ($filterType === 'municipality') {
            $query->where('Municipality !=', '');
        }

        // Apply date range filters if provided
        if (!empty($dateFrom)) {
            $query->where('CreatedDate >=', $dateFrom);
        }
        if (!empty($dateTo)) {
            $query->where('CreatedDate <=', $dateTo);
        }

        // Execute the query and get the result
        $clients = $query->findAll();

        // Check if clients are found
        if (!$clients) {
            return $this->response->setJSON(['clients' => [], 'message' => 'No data found']);
        }

        // Return the result as JSON
        return $this->response->setJSON(['clients' => $clients]);
    }

    public function getReleasedClients()
    {
        // Start a session to retrieve user data
        $session = session();
        $userData = $session->get('userData'); // Assuming user data is stored in the session

        // Get the OfficeName from the logged-in user
        $userOffice = $userData['OfficeName'];

        // Instantiate the ClientModel
        $clientModel = new ClientModel();

        // Build the query to get Released clients and filter by OfficeName
        $query = $clientModel
            ->where('Status', 'Released')
            ->where('OfficeName', $userOffice); // Filter by OfficeName of the logged-in user

        // Get filter parameters from the request
        $filterType = $this->request->getGet('filterType');
        $locationInput = $this->request->getGet('locationInput'); // Get the location input
        $dateFrom = $this->request->getGet('dateFrom');
        $dateTo = $this->request->getGet('dateTo');

        // Apply additional filters based on the filter type
        if ($filterType === 'barangay' && !empty($locationInput)) {
            $query->where('Barangay', $locationInput); // Filter by specific Barangay
        } elseif ($filterType === 'municipality' && !empty($locationInput)) {
            $query->where('Municipality', $locationInput); // Filter by specific Municipality
        }

        // Apply date range filters if provided
        if (!empty($dateFrom)) {
            $query->where('CreatedDate >=', $dateFrom);
        }
        if (!empty($dateTo)) {
            $query->where('CreatedDate <=', $dateTo);
        }

        // Execute the query and get the result
        $clients = $query->findAll();

        // Check if clients are found
        if (!$clients) {
            return $this->response->setJSON(['clients' => [], 'message' => 'No data found']);
        }

        // Return the result as JSON
        return $this->response->setJSON(['clients' => $clients]);
    }

    public function printReports1($registrationNo = null)
    {
        // Validate the registration number
        if (!$registrationNo) {
            return redirect()->back()->with('error', 'Invalid Registration Number.');
        }

        // Initialize the ClientModel
        $clientModel = new ClientModel();

        // Fetch the client data based on the registration number
        $client = $clientModel->where('RegistrationNo', $registrationNo)
            ->where('Status', 'Released')
            ->where('PaymentStatus', 'Paid')
            ->first();

        // Check if the client exists
        if (!$client) {
            return redirect()->back()->with('error', 'Client not found.');
        }

        // Pass the client data to the view
        return view('client/printReports', ['client' => $client]);
    }

    public function printReports($registrationNo = null)
    {
        // Validate the registration number
        if (!$registrationNo) {
            return redirect()->back()->with('error', 'Invalid Registration Number.');
        }

        // Start a session to retrieve user data
        $session = session();
        $userData = $session->get('userData'); // Assuming user data is stored in the session

        // Get the OfficeName from the logged-in user
        $userOffice = $userData['OfficeName'];

        // Initialize the ClientModel
        $clientModel = new ClientModel();

        // Fetch the client data based on the registration number, OfficeName, Status, and PaymentStatus
        $client = $clientModel
            ->where('RegistrationNo', $registrationNo)
            ->where('Status', 'Released')
            ->where('PaymentStatus', 'Paid')
            ->where('OfficeName', $userOffice) // Filter by OfficeName of the logged-in user
            ->first();

        // Check if the client exists
        if (!$client) {
            return redirect()->back()->with('error', 'Client not found or does not belong to your office.');
        }

        // Pass the client data to the view
        return view('client/printReports', ['client' => $client]);
    }


    public function getClientDetails($registrationNo)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tblregistration');

        // Select the relevant fields for the specific RegistrationNo
        $builder->select('RegistrationNo, Fullname, Barangay, Municipality, Province, Brand, Model, SerialNo, ExpiryDate, OfficeAddress, Telefax, EmailAdd');
        $builder->where('RegistrationNo', $registrationNo);

        // Fetch the client data
        $client = $builder->get()->getRow();

        if (!$client) {
            return $this->response->setJSON(['success' => false, 'message' => 'No data found']);
        }

        // Return the client data as JSON
        return $this->response->setJSON(['success' => true, 'client' => $client]);
    }

    public function getPendingRegistrationNo1($userId = null) // Payment
    {
        try {
            // Check if UserID is provided
            if ($userId === null) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status' => 400,
                    'error' => true,
                    'message' => 'UserID is required'
                ]);
            }

            // Initialize the ClientModel
            $clientModel = new \App\Models\ClientModel();

            // Retrieve pending registrations for the given UserID
            $pendingRegistrations = $clientModel->getPendingRegistrationNo($userId);

            // Check if any records were found
            if (empty($pendingRegistrations)) {
                return $this->response->setStatusCode(404)->setJSON([
                    'status' => 404,
                    'error' => true,
                    'message' => 'No pending registration found for the given UserID'
                ]);
            }

            // Respond with the found data
            return $this->response->setStatusCode(200)->setJSON([
                'status' => 200,
                'data' => $pendingRegistrations
            ]);
        } catch (\Exception $e) {
            // Log and handle any exceptions
            log_message('error', 'Exception in getPendingRegistrationNo: ' . $e->getMessage());

            return $this->response->setStatusCode(500)->setJSON([
                'status' => 500,
                'error' => true,
                'message' => 'An error occurred while processing your request.'
            ]);
        }
    }

    public function getPendingRegistrationNo($userId = null) // FLutter Payment Page for Client Confirmed Registration
    {
        try {
            if (!$userId) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status' => 400,
                    'error' => true,
                    'message' => 'UserID is required.'
                ]);
            }
    
            $clientModel = new \App\Models\ClientModel();
            $pendingRegistrations = $clientModel->getPendingRegistrationNo($userId);
    
            if (empty($pendingRegistrations)) {
                return $this->response->setStatusCode(404)->setJSON([
                    'status' => 404,
                    'Message' => true,
                    'message' => 'No pending registrations found.'
                ]);
            }
    
            return $this->response->setStatusCode(200)->setJSON([
                'status' => 200,
                'data' => $pendingRegistrations
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Exception in getPendingRegistrationNo: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 500,
                'error' => true,
                'message' => 'An internal server error occurred.'
            ]);
        }
    }
    

    public function checkSerialNo($serialNo) // Registration 
    {
        $clientModel = new ClientModel();
        $existing = $clientModel->where('SerialNo', $serialNo)->first();

        if ($existing) {
            return $this->response->setJSON(['exists' => true]);
        } else {
            return $this->response->setJSON(['exists' => false]);
        }
    }

    public function getRegistrationNumbers($userId) //Capture user registration details where status is Released for Renewal
    {
        $clientModel = new ClientModel();
        $registrationNumbers = $clientModel->where('UserID', $userId)
            ->where('Status', 'Released')
            ->findAll();

        // Prepare the response as a list of registration numbers
        $response = array_map(function ($item) {
            return ['RegistrationNo' => $item->RegistrationNo];
        }, $registrationNumbers);

        return $this->response->setJSON($response);
    }


    public function getRegistrationDetails($registrationNo)
    {
        $clientModel = new ClientModel();
        $registrationDetails = $clientModel->where('RegistrationNo', $registrationNo)->first();

        if ($registrationDetails) {
            return $this->response->setJSON(['success' => true, 'data' => $registrationDetails]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Registration not found']);
        }
    }

    public function getUserRolesByOffice($officeName)
    {
        try {
            $userModel = new \App\Models\UserModel();
    
            // Fetch RPS Chief
            $rpsChief = $userModel->where('OfficeName', $officeName)
                                  ->where('UserRole', 'RPS Chief')
                                  ->first();
    
            // Fetch Cashier
            $cashier = $userModel->where('OfficeName', $officeName)
                                 ->where('UserRole', 'Cashier')
                                 ->first();
    
            // Prepare response
            $response = [
                'rpsChief' => $rpsChief
                    ? trim($rpsChief->FirstName . ' ' . ($rpsChief->MiddleName ? $rpsChief->MiddleName[0] . '. ' : '') . $rpsChief->LastName)
                    : 'Not Assigned',
    
                'cashier' => $cashier
                    ? trim($cashier->FirstName . ' ' . ($cashier->MiddleName ? $cashier->MiddleName[0] . '. ' : '') . $cashier->LastName)
                    : 'Not Assigned',
            ];
    
            return $this->response->setJSON(['status' => 200, 'data' => $response]);
        } catch (\Exception $e) {
            log_message('error', 'Error fetching user roles: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 500,
                'message' => 'An error occurred while fetching user roles.',
            ]);
        }
    }

    public function getClientDetailsQR1($registrationNo)
    {
        $clientModel = new ClientModel(); // Instantiate the model

        // Fetch client details by RegistrationNo
        $clientDetails = $clientModel->getClientByRegistrationNo($registrationNo);

        if ($clientDetails) {
            return $this->response->setJSON([
                'success' => true,
                'data' => $clientDetails,
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Client not found',
            ]);
        }
    }

    public function getClientDetailsQR($registrationNo)
    {
        $clientModel = new \App\Models\ClientModel();
        $clientDetails = $clientModel->getClientByRegistrationNo($registrationNo);
    
        if ($clientDetails) {
            // Convert the stdClass object to an array if needed
            $clientDetails = (array) $clientDetails;
    
            // Add the full URL for the image
            if (isset($clientDetails['Image'])) {
                $clientDetails['Image'] = 'http://68.183.233.98//uploads/images/' . $clientDetails['Image'];
                //$clientDetails['Image'] = 'http://cris.denr12lrsis.com/uploads/images/' . $clientDetails['Image'];
            }
    
            return $this->response->setJSON([
                'success' => true,
                'data' => $clientDetails,
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Client not found',
            ]);
        }
    }
    

}