<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OfficeModel;
use App\Models\ClientModel;
use App\Models\PaymentModel;

class User extends BaseController
{

    public function index()
    {

       $UserModel = new \App\Models\UserModel();
        $data['UserData'] = $UserModel->findAll();
        $allUsers = $UserModel->withDeleted()->findAll();
        return view('user/index', $data);
        //$session = session();
       // $userData = $session->get('userData'); // This is an array

        //return view('user/index', [
            //'userID' => $userData['UserID'],
           // 'firstName' => $userData['FirstName'],
           // 'contactNo' => $userData['ContactNo'],
           // 'officeName' => $userData['OfficeName'],
           // 'headOfOffice' => $userData['HeadOfOffice'],
           // 'position' => $userData['Position'],

            //'address' => $userData['OfficeAddress'],
           // 'telefax' => $userData['Telefax'],
           // 'emailadd' => $userData['EmailAdd'],
        //]);
    }

    public function login() //php
    {
        $UserModel = new \App\Models\UserModel();
        helper('form');

        if ($this->request->getMethod() === "POST") {
            $rules = [
                'Username' => 'required',
                'Password' => 'required',
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
                // return view('user/add', $data);
            } else {
                $result = $UserModel
                    ->where('Username', $_POST['Username'])
                    ->first();

                if ($result) {
                    if (password_verify($_POST['Password'], $result->Password)) {
                        // Set the session with UserRole and Status
                        session()->set([
                            'userData' => [
                                'FirstName' => $result->FirstName,
                                'ContactNo' => $result->ContactNo,
                                'UserID' => $result->UserID,
                                'UserRole' => $result->UserRole, // Add UserRole
                                'Status' => $result->Status,     // Add Status
                                'OfficeName' => $result->OfficeName,
                                'HeadOfOffice' => $result->HeadOfOffice,
                                'Position' => $result->Position,
                                'Address' => $result->Address,
                                'Telefax' => $result->Telefax,
                                'EmailAdd' => $result->EmailAdd,
                            ],
                            'isLoggedIn' => true
                        ]);

                        return redirect()->to('dashboard');
                    }
                }
                session()->setFlashdata('error', 'Username or Password is incorrect.');
            }
        }
        return view('user/login');
    }

    public function loginF() // Flutter login
    {
        $UserModel = new \App\Models\UserModel();
        helper('form');

        if ($this->request->getMethod() === "POST") {
            $rules = [
                'Username' => 'required',
                'Password' => 'required',
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON(['success' => false, 'message' => 'Validation failed']);
            } else {
                $result = $UserModel->where('Username', $this->request->getPost('Username'))->first();

                if ($result) {
                    if (password_verify($this->request->getPost('Password'), $result->Password)) {
                        // Set session data
                        session()->set([
                            'userData' => [
                                'FirstName' => $result->FirstName,
                                'ContactNo' => $result->ContactNo,
                                'UserID' => $result->UserID,
                                'UserRole' => $result->UserRole,
                                'Status' => $result->Status,
                                'OfficeName' => $result->OfficeName,
                                'HeadOfOffice' => $result->HeadOfOffice,
                                'Position' => $result->Position,
                                'Address' => $result->Address,
                                'Telefax' => $result->Telefax,
                                'EmailAdd' => $result->EmailAdd,
                            ],
                            'isLoggedIn' => true
                        ]);

                        return $this->response->setJSON(['success' => true, 'message' => 'Login successful', 'userData' => [
                            'UserID' => $result->UserID,
                            'FirstName' => $result->FirstName
                        ]]);
                    }
                }
                return $this->response->setJSON(['success' => false, 'message' => 'Username or Password is incorrect.']);
            }
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Invalid request method.']);
    }

    public function addUser()
    {
        helper('form');
        $UserModel = new UserModel();
    
        if ($this->request->getMethod() === 'POST') {
            // Validation rules
            $rules = [
                'LastName'        => 'required|min_length[3]|max_length[20]',
                'FirstName'       => 'required|min_length[3]|max_length[20]',
                'MiddleName'      => 'permit_empty|min_length[1]|max_length[20]', // Optional field
                'ContactNo'       => 'required|numeric',
                'UserRole'        => 'required',
                'OfficeName'      => 'required',
                'Username'        => 'required|is_unique[tblusers.Username]',
                'Password'        => 'required|min_length[6]',
                'ConfirmPassword' => 'matches[Password]',
            ];
    
            // Validate form input
            if (!$this->validate($rules)) {
                session()->setFlashdata('errors', $this->validator->getErrors());
                return redirect()->back()->withInput();
            }
    
            // Generate UserID
            $year = date('Y');
            $lastUser = $UserModel->orderBy('CreatedDate', 'DESC')->first();
            $lastUserID = $lastUser ? intval(substr($lastUser->UserID, -9)) : 0;
            $nextUserID = str_pad($lastUserID + 1, 9, '0', STR_PAD_LEFT);
            $userID = "{$year}USID{$nextUserID}";
    
            // Prepare user data
            $userData = [
                'UserID'       => $userID,
                'FirstName'    => $this->request->getPost('FirstName'),
                'LastName'     => $this->request->getPost('LastName'),
                'MiddleName'   => $this->request->getPost('MiddleName'),
                'ContactNo'    => $this->request->getPost('ContactNo'),
                'UserRole'     => $this->request->getPost('UserRole'),
                'OfficeName'   => $this->request->getPost('OfficeName'),
                'HeadOfOffice' => $this->request->getPost('HeadOfOffice'),
                'Position'     => $this->request->getPost('Position'),
                'Address'      => $this->request->getPost('Address'),
                'Telefax'      => $this->request->getPost('Telefax'),
                'EmailAdd'     => $this->request->getPost('EmailAdd'),
                'Status'       => 'Confirmed', // Default value
                'Username'     => $this->request->getPost('Username'),
                'Password'     => password_hash($this->request->getPost('Password'), PASSWORD_DEFAULT),
            ];
    
            // Insert user data
            $insertResult = $UserModel->insert($userData);
    
            // Check if the insert was successful by validating the result
            if ($insertResult !== false && $insertResult !== null) {
                // Success: Return JSON response
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'User successfully added.'
                ]);
            } else {
                // Log the error for debugging
                log_message('error', 'User insert failed: ' . var_export($insertResult, true));
    
                // Failure: Return error response
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to add user. Please try again.'
                ]);
            }
        }
    
        // Load the registration view
        return view('user/add');
    }
    
    public function register()
    {
        helper('form');
        $UserModel = new UserModel();
    
        if ($this->request->getMethod() === 'POST') {
            // Validation rules
            $rules = [
                'LastName'        => 'required|min_length[3]|max_length[20]',
                'FirstName'       => 'required|min_length[3]|max_length[20]',
                'ContactNo'       => 'required|numeric|min_length[10]|max_length[15]',
                'OfficeName'      => 'required',
                'Username'        => 'required|is_unique[tblusers.Username]',
                'Password'        => 'required|min_length[6]',
                'ConfirmPassword' => 'required|matches[Password]',
            ];
    
            // Validate form input
            if (!$this->validate($rules)) {
                session()->setFlashdata('errors', $this->validator->getErrors());
                return redirect()->back()->withInput();
            }
    
            // Generate UserID
            $year = date('Y');
            $lastUser = $UserModel->orderBy('CreatedDate', 'DESC')->first();
            $lastUserID = $lastUser ? intval(substr($lastUser->UserID, -9)) : 0;
            $nextUserID = str_pad($lastUserID + 1, 9, '0', STR_PAD_LEFT);
            $userID = "{$year}USID{$nextUserID}";
    
            // Prepare user data
            $userData = [
                'UserID'       => $userID,
                'FirstName'    => $this->request->getPost('FirstName'),
                'LastName'     => $this->request->getPost('LastName'),
                'ContactNo'    => $this->request->getPost('ContactNo'),
                'UserRole'     => 'Client', // Default value
                'OfficeName'   => $this->request->getPost('OfficeName'),
                'HeadOfOffice' => $this->request->getPost('HeadOfOffice'),
                'Position'     => $this->request->getPost('Position'),
                'Address' => $this->request->getPost('Address'),
                'Telefax'      => $this->request->getPost('Telefax'),
                'EmailAdd'     => $this->request->getPost('EmailAdd'),
                'Status'       => 'Pending', // Default value
                'Username'     => $this->request->getPost('Username'),
                'Password'     => password_hash($this->request->getPost('Password'), PASSWORD_DEFAULT),
                'CreatedDate'  => date('Y-m-d H:i:s'),
            ];
    
            // Insert user data and get the result
            try {
                $db = \Config\Database::connect();
                $builder = $db->table('tblusers');
            
                // Perform the insert operation
                $insertResult = $builder->insert($userData);
            
                if ($insertResult) {
                    session()->setFlashdata('success', 'User successfully registered. You can now log in.');
                    return redirect()->to(base_url('login'));  // Redirect to login
                } else {
                    log_message('error', 'Insert operation failed: ' . var_export($insertResult, true));
                    session()->setFlashdata('error', 'Failed to register user. Insert operation did not return a valid result.');
                }
            } catch (\Exception $e) {
                log_message('error', 'User registration failed: ' . $e->getMessage());
                session()->setFlashdata('error', 'An error occurred while registering the user. Please try again.');
            }
            
            return redirect()->back()->withInput();            
        }
    
        // Load the registration view
        return view('user/register');
    }

    public function registerF() //flutter user registration
    {
        helper('form');
        $UserModel = new \App\Models\UserModel();

        if ($this->request->getMethod() === 'POST') {
            // Define validation rules
            $rules = [
                'FirstName'       => 'required|min_length[3]|max_length[20]',
                'LastName'        => 'required|min_length[3]|max_length[20]',
                'ContactNo'       => 'required|numeric|min_length[10]|max_length[15]',
                'OfficeName'      => 'required',
                'Username'        => 'required|is_unique[tblusers.Username]',
                'Password'        => 'required|min_length[6]',
                'ConfirmPassword' => 'required|matches[Password]',
            ];

            // Validate the input
            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors'  => $this->validator->getErrors()
                ]);
            }

            // Generate UserID
            $year = date('Y');
            $lastUser = $UserModel->orderBy('CreatedDate', 'DESC')->first();
            $lastUserID = $lastUser ? intval(substr($lastUser->UserID, -9)) : 0;
            $nextUserID = str_pad($lastUserID + 1, 9, '0', STR_PAD_LEFT);
            $userID = "{$year}USID{$nextUserID}";

            // Prepare user data for insertion
            $userData = [
                'UserID'       => $userID,
                'FirstName'    => $this->request->getPost('FirstName'),
                'LastName'     => $this->request->getPost('LastName'),
                'ContactNo'    => $this->request->getPost('ContactNo'),
                'UserRole'     => 'Client', // Default role
                'OfficeName'   => $this->request->getPost('OfficeName'),
                'HeadOfOffice' => $this->request->getPost('HeadOfOffice'),
                'Position'     => $this->request->getPost('Position'),
                'Address'      => $this->request->getPost('Address'),
                'Telefax'      => $this->request->getPost('Telefax'),
                'EmailAdd'     => $this->request->getPost('EmailAdd'),
                'Status'       => 'Pending', // Default status
                'Username'     => $this->request->getPost('Username'),
                'Password'     => password_hash($this->request->getPost('Password'), PASSWORD_DEFAULT),
                'CreatedDate'  => date('Y-m-d H:i:s'),
            ];

            try {
                // Insert user data into the database
                $db = \Config\Database::connect();
                $builder = $db->table('tblusers');
                $insertResult = $builder->insert($userData);

                if ($insertResult) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'User successfully registered.'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to register user.'
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ]);
            }
        }

        // Handle invalid request method
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid request method.'
        ]);
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }

    public function forgotpassword()
    {
        // Load the 'forgot_password' view
        return view('user/forgotpassword');
    }

    public function verify_otp()
    {
        // Get the contactNo from the query string
        $contactNo = $this->request->getGet('contactNo');

        // Check if contactNo is available
        if (empty($contactNo)) {
            return redirect()->to('/forgot_password')->with('error', 'Session expired. Please request a new OTP.');
        }

        // Pass contactNo to the view
        return view('user/verify_otp', ['contactNo' => $contactNo]);
    }

    public function verifyOTPU()
    {
        $otp = $this->request->getPost('OTP');
        $contactNo = $this->request->getPost('ContactNo');
    
        // Validate input
        if (empty($otp) || empty($contactNo)) {
            return redirect()->back()->with('error', 'Both OTP and Contact Number are required.');
        }
    
        // Validate OTP in the database
        $db = \Config\Database::connect();
        $builder = $db->table('tblusers');
        $user = $builder->where('ContactNo', $contactNo)
            ->where('OTP', $otp)
            ->where('OTPExpiry >=', date('Y-m-d H:i:s')) // OTP is not expired
            ->get()
            ->getRow();
    
        if ($user) {
            // OTP is valid, redirect to Reset Password page
            session()->set('contactNo', $contactNo);
            return redirect()->to('/resetpassword');
        } else {
            return redirect()->back()->with('error', 'Invalid or expired OTP.');
        }
    }
    
    public function resetPassword()
    {
        // Check if contactNo is in the session
        $contactNo = session()->get('contactNo');
        if (!$contactNo) {
            return redirect()->to('/login')->with('error', 'Session expired. Please request a new OTP.');
        }
    
        // Load the reset password view
        return view('user/resetpassword', [
            'contactNo' => $contactNo // Pass contact number to the view
        ]);
    }

    public function updatePassword()
    {
        $contactNo = $this->request->getPost('ContactNo');
        $newPassword = $this->request->getPost('NewPassword');
        $confirmPassword = $this->request->getPost('ConfirmPassword');

        // Validation checks
        if (empty($newPassword) || empty($confirmPassword)) {
            return redirect()->back()->withInput()->with('error', 'All fields are required.');
        }

        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->withInput()->with('error', 'Passwords do not match.');
        }

        if (strlen($newPassword) < 6 || strlen($newPassword) > 10) {
            return redirect()->back()->withInput()->with('error', 'Password must be between 6 and 10 characters.');
        }

        // Update password in the database
        $db = \Config\Database::connect();
        $builder = $db->table('tblusers');
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT); // Hash the new password

        $updated = $builder->where('ContactNo', $contactNo)->update([
            'Password' => $hashedPassword
        ]);

        if ($updated) {
            return redirect()->to('/login')->with('success', 'Password successfully updated. You can now log in.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update the password. Please try again.');
        }
    }


    public function sendOTP1()
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

    public function sendOTP()
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

            // Save the OTP in the database with expiry time
            $builder->where('ContactNo', $contactNo)->update([
                'OTP' => $otp,
                'OTPExpiry' => date('Y-m-d H:i:s', strtotime('+10 minutes')) // OTP valid for 10 minutes
            ]);

            // Send the OTP via SMS using Semaphore
            $parameters = [
                'apikey' => '51364d51c8a5e92ccad5c04a6a54d8ca', // Replace with your Semaphore API key
                'number' => $contactNo,
                'message' => 'Your one-time (OTP) is: ' . $otp,
                'sendername' => 'DENR12' // Replace with your registered sender name
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
                'message' => 'OTP has been sent to your mobile number.',
                'contactNo' => $contactNo // Pass contactNo to the front-end
            ]);
        } else {
            // User not found
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User not found. Please check the LastName and ContactNo.'
            ]);
        }
    }

    public function dashboard()
    {
        // Assuming session holds user data
        $session = session();
        $userData = $session->get('userData'); // This is an array

        // Initialize the ClientModel and UserModel
        $clientModel = new ClientModel();
        $userModel = new UserModel();

        // Get the office name from the logged-in user
        $userOffice = $userData['OfficeName'];

        // Query RPS Chief and Cashier based on the office name
        $rpsChief = $userModel
            ->where('UserRole', 'RPS Chief')
            ->where('OfficeName', $userOffice)
            ->first();

        $cashier = $userModel
            ->where('UserRole', 'Cashier')
            ->where('OfficeName', $userOffice)
            ->first();

        // Count clients for different statuses based on the user's office
        $confirmedForPaymentCount = $clientModel
            ->where('Status', 'Confirmed')
            ->where('PaymentStatus', 'For Payment')
            ->where('OfficeName', $userOffice)
            ->countAllResults();

        $confirmedPaidCount = $clientModel
            ->where('Status', 'Confirmed')
            ->where('PaymentStatus', 'Paid')
            ->where('OfficeName', $userOffice)
            ->countAllResults();

        $releasedCount = $clientModel
            ->where('Status', 'Released')
            ->where('OfficeName', $userOffice)
            ->countAllResults();

        $pendingCount = $clientModel
            ->where('Status', 'Pending')
            ->where('OfficeName', $userOffice)
            ->countAllResults();

        // Count clients for Pending, Confirmed, Paid, Released (Grouped by OfficeName)
        $officeStatistics = $clientModel
            ->select('OfficeName, 
                  SUM(CASE WHEN Status = "Pending" THEN 1 ELSE 0 END) as Pending,
                  SUM(CASE WHEN Status = "Confirmed" THEN 1 ELSE 0 END) as Confirmed,
                  SUM(CASE WHEN PaymentStatus = "Paid" THEN 1 ELSE 0 END) as Paid,
                  SUM(CASE WHEN Status = "Released" THEN 1 ELSE 0 END) as Released')
            ->groupBy('OfficeName')
            ->findAll();

        // Count all Released clients between 2024 and 2030
        $releasedCount2024to2030 = $clientModel
            ->where('Status', 'Released')
            ->where('CreatedDate >=', '2024-01-01')
            ->where('CreatedDate <=', '2030-12-31')
            ->countAllResults();

        // Pass data to the view
        return view('user/dashboard', [
            'userID' => $userData['UserID'],
            'firstName' => $userData['FirstName'],
            'contactNo' => $userData['ContactNo'],
            'officeName' => $userData['OfficeName'],
            'headOfOffice' => $userData['HeadOfOffice'],
            'position' => $userData['Position'],
            'address' => $userData['Address'],
            'telefax' => $userData['Telefax'],
            'emailadd' => $userData['EmailAdd'],

            // RPS Chief and Cashier data for the specific office
            'rpsChief' => $rpsChief
                ? trim($rpsChief->FirstName . ' ' . ($rpsChief->MiddleName ? $rpsChief->MiddleName[0] . '. ' : '') . $rpsChief->LastName)
                : 'Not Assigned',

            'cashier' => $cashier
                ? trim($cashier->FirstName . ' ' . ($cashier->MiddleName ? $cashier->MiddleName[0] . '. ' : '') . $cashier->LastName)
                : 'Not Assigned',

            // Client counts
            'pendingCount' => $pendingCount,
            'confirmedForPaymentCount' => $confirmedForPaymentCount,
            'confirmedPaidCount' => $confirmedPaidCount,
            'releasedCount' => $releasedCount,

            // Data for graphs
            'officeStatistics' => $officeStatistics,
            'releasedCount2024to2030' => $releasedCount2024to2030,
        ]);
    }

    /*     public function add1()
    {
        helper('form');

        $UserModel = new \App\Models\UserModel();

        if ($this->request->getMethod() === "POST") {
            $rules = [
                'LastName' => 'required',
                'FirstName' => 'required',
                'MiddleName' => 'permit_empty',
                'ContactNo' => 'required',   
                'Username' => 'required|is_unique[user_tbl.Username]',
                'Password' => 'required',
                'ConfirmPassword' => 'matches[Password]',
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
                return view('user/add', $data);
            } else {
                $password = password_hash($this->request->getPost('Password'), PASSWORD_DEFAULT);
                $userData = [
                   'LastName' => $this->request->getPost('LastName'),
                    'FirstName' => $this->request->getPost('FirstName'),
                    'MiddleName' => $this->request->getPost('MiddleName'),
                    'Username' => $this->request->getPost('Username'),
                    'Password' => $password,

                    'LastName'     => 'required|min_length[3]|max_length[20]',
                    'ContactNo'    => 'required|numeric',
                    'UserRole'     => 'required|',
                    'Status'       => 'Confirmed', // Default value
                    'Username'     => $this->request->getPost('username'),
                    'Password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                ];

                if ($UserModel->insert($userData)) {
                    session()->setFlashdata('success', 'User successfully added.');
                    return redirect()->to('user');
                } else {
                    session()->setFlashdata('error', 'User failed to add.');
                }
            }
        }

        return view('user/add');
    }  */

    public function addUser1()
    {
        helper('form');

        $UserModel = new \App\Models\UserModel();

        if ($this->request->getMethod() === "POST") {
            // Validation rules
            $rules = [
                'LastName'        => 'required|min_length[3]|max_length[20]',
                'FirstName'       => 'required|min_length[3]|max_length[20]',
                'MiddleName'      => 'permit_empty|min_length[1]|max_length[20]', // Optional field
                'ContactNo'       => 'required|numeric',
                'UserRole'        => 'required',
                'OfficeName'      => 'required',
                'Username'        => 'required|is_unique[tblusers.Username]',
                'Password'        => 'required|min_length[6]',
                'ConfirmPassword' => 'matches[Password]',
            ];

            // Validate form input
            if (!$this->validate($rules)) {
                // Return validation errors in JSON format for AJAX to handle
                return $this->response->setJSON([
                    'success' => false,
                    'errors' => $this->validator->getErrors()
                ]);
            } else {

                // Generate UserID
                $year = date('Y');
                $lastUser = $UserModel->orderBy('CreatedDate', 'DESC')->first();
                $lastUserID = $lastUser ? intval(substr($lastUser->UserID, -9)) : 0;
                $nextUserID = str_pad($lastUserID + 1, 9, '0', STR_PAD_LEFT);
                $userID = "{$year}USID{$nextUserID}";

                // If validation passes, proceed to save the user
                $userData = [
                    'FirstName'    => $this->request->getPost('FirstName'),
                    'LastName'     => $this->request->getPost('LastName'),
                    'MiddlleName'     => $this->request->getPost('MiddleName'),
                    'ContactNo'    => $this->request->getPost('ContactNo'),
                    'UserRole'     => $this->request->getPost('UserRole'),
                    'OfficeName'   => $this->request->getPost('OfficeName'),
                    'HeadOfOffice' => $this->request->getPost('HeadOfOffice'),
                    'Position'     => $this->request->getPost('Position'),
                    'Address'     => $this->request->getPost('Address'),
                    'Telefax'     => $this->request->getPost('Telefax'),
                    'EmailAdd'     => $this->request->getPost('EmailAdd'),
                    'Status'       => 'Confirmed', // Default value
                    'Username'     => $this->request->getPost('Username'),
                    'Password'     => password_hash($this->request->getPost('Password'), PASSWORD_DEFAULT),
                ];

                if ($UserModel->insert($userData)) {
                    // Return success response in JSON format
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'User successfully added.'
                    ]);
                } else {
                    // Return error response in JSON format
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to add user. Please try again.'
                    ]);
                }
            }
        }

        return view('user/add');
    }

    public function updateUser()
    {
        $userModel = new UserModel();
        $userID = $this->request->getPost('UserID');

        // Validate and update existing user
        $data = [
            //'UserID' => $this->request->getPost('UserID'),
            'FirstName' => $this->request->getPost('FirstName'),
            'LastName' => $this->request->getPost('LastName'),
            'MiddleName' => $this->request->getPost('MiddleName'),
            'ContactNo' => $this->request->getPost('ContactNo'),
            'OfficeName' => $this->request->getPost('OfficeName'),
            'HeadOfOffice' => $this->request->getPost('HeadOfOffice'),
            'Position' => $this->request->getPost('Position'),
            'Address'     => $this->request->getPost('Address'),
            'Telefax'     => $this->request->getPost('Telefax'),
            'EmailAdd'     => $this->request->getPost('EmailAdd'),
            'UserRole' => $this->request->getPost('UserRole'),
            'Username' => $this->request->getPost('Username'),
        ];

        // Check if a new password was provided
        if (!empty($this->request->getPost('Password'))) {
            $data['Password'] = password_hash($this->request->getPost('Password'), PASSWORD_DEFAULT);
        }

        if ($userModel->update($userID, $data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'User updated successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update user']);
        }
    }

    public function getUserDetails($userID)
    {
        $userModel = new UserModel();

        // Fetch the user details by UserID
        $user = $userModel->find($userID);

        if ($user) {
            return $this->response->setJSON([
                'success' => true,
                'user' => $user
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User not found.'
            ]);
        }
    }

    public function getOffices()
    {
        $officeModel = new OfficeModel();

        // Fetch all offices from the tblOffice table
        $offices = $officeModel->select('OfficeName')->findAll(); // Only select OfficeName

        if ($offices) {
            // Log the office data for debugging purposes
            log_message('info', 'Offices fetched: ' . json_encode($offices));

            // Return the office data as JSON
            return $this->response->setJSON($offices);
        } else {
            // Log an error if no offices are found
            log_message('error', 'No offices found in the tblOffice.');
            return $this->response->setJSON(['error' => 'No offices found.']);
        }
    }

    public function getOfficeDetails($officeName)
    {
        $officeModel = new OfficeModel();

        // Fetch details of the selected office (HeadOfOffice and Position)
        $office = $officeModel->where('OfficeName', $officeName)->first();

        if ($office) {
            // Log the office data for debugging purposes
            log_message('info', 'Office details fetched: ' . json_encode($office));

            // Return the office data as JSON
            return $this->response->setJSON($office);
        } else {
            // Log an error if office not found
            log_message('error', 'Office not found: ' . $officeName);
            return $this->response->setJSON(['error' => 'Office not found']);
        }
    }

    /*  public function addUser() flutter connect
    {
        helper('form');

        $UserModel = new \App\Models\UserModel();

        if ($this->request->getMethod() === "POST") {
            $password = password_hash($this->request->getPost('Password'), PASSWORD_DEFAULT);

            // Prepare the data to insert
            $userData = [
                'LastName' => $this->request->getPost('LastName'),
                'FirstName' => $this->request->getPost('FirstName'),
                'MiddleName' => $this->request->getPost('MiddleName'),
                'Username' => $this->request->getPost('Username'),
                'Password' => $password,
            ];

            if ($UserModel->insert($userData)) {
                // Get the inserted user data, excluding the password for security
                $addedUser = [
                    'LastName' => $userData['LastName'],
                    'FirstName' => $userData['FirstName'],
                    'MiddleName' => $userData['MiddleName'],
                    'Username' => $userData['Username']
                ];

                // Return success message and the inserted user data
                return $this->response->setStatusCode(201)->setJSON([
                    'status' => 'success',
                    'message' => 'User successfully added.',
                    'data' => $addedUser
                ]);
            } else {
                // Failed to insert user
                return $this->response->setStatusCode(500)->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to add user.'
                ]);
            }
        } else {
            // If request is not POST, return method not allowed
            return $this->response->setStatusCode(405)->setJSON([
                'status' => 'error',
                'message' => 'Method not allowed.'
            ]);
        }
    } */

    public function addUserF()
    {
        helper('form');
        $UserModel = new \App\Models\UserModel();

        if ($this->request->getMethod() === 'POST') {
            $password = password_hash($this->request->getPost('Password'), PASSWORD_DEFAULT);

            // Generate UserID
            $year = date('Y');
            $lastUser = $UserModel->orderBy('CreatedDate', 'DESC')->first();
            $lastUserID = $lastUser ? intval(substr($lastUser->UserID, -9)) : 0;
            $nextUserID = str_pad($lastUserID + 1, 9, '0', STR_PAD_LEFT);
            $userID = "{$year}USID{$nextUserID}";

            // Prepare the data to insert
            $userData = [
                'UserID'       => $userID,
                'FirstName'    => $this->request->getPost('FirstName'),
                'LastName'     => $this->request->getPost('LastName'),
                //'MiddleName'   => $this->request->getPost('MiddleName'),
                'ContactNo'    => $this->request->getPost('ContactNo'),
                'UserRole'     => $this->request->getPost('UserRole'),
                'OfficeName'   => $this->request->getPost('OfficeName'),
                'HeadOfOffice' => $this->request->getPost('HeadOfOffice'),
                'Position'     => $this->request->getPost('Position'),
                'Address'      => $this->request->getPost('Address'),
                'Telefax'      => $this->request->getPost('Telefax'),
                'EmailAdd'     => $this->request->getPost('EmailAdd'),
                'Status'       => 'Pending', // Default status
                'Username'     => $this->request->getPost('Username'),
                'Password'     => $password,
            ];

            // Insert user data
            if ($UserModel->insert($userData)) {
                // Prepare the response data (excluding sensitive fields like password)
                $addedUser = [
                    'UserID'     => $userID,
                    'FirstName'  => $userData['FirstName'],
                    'LastName'   => $userData['LastName'],
                    //'MiddleName' => $userData['MiddleName'],
                    'Username'   => $userData['Username'],
                    'ContactNo'  => $userData['ContactNo'],
                    'UserRole'   => $userData['UserRole'],
                    'OfficeName' => $userData['OfficeName'],
                ];

                // Return success message and the inserted user data in JSON format
                return $this->response->setStatusCode(201)->setJSON([
                    'status'  => 'success',
                    'message' => 'User successfully added.',
                    'data'    => $addedUser
                ]);
            } else {
                // Log the error for debugging
                log_message('error', 'User insert failed.');

                // Return error response in JSON format
                return $this->response->setStatusCode(500)->setJSON([
                    'status'  => 'error',
                    'message' => 'Failed to add user. Please try again.'
                ]);
            }
        } else {
            // If request is not POST, return method not allowed
            return $this->response->setStatusCode(405)->setJSON([
                'status'  => 'error',
                'message' => 'Method not allowed.'
            ]);
        }
    }

    public function delete()
    {
        $UserModel = new \App\Models\UserModel();

        // Check if the request is POST and UserID is provided
        if ($this->request->getMethod() === 'POST') {
            $userID = $this->request->getPost('UserID');

            // Validate that the UserID is present
            if (empty($userID)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'UserID is required.'
                ]);
            }

            // Check if the user exists in the database
            $user = $UserModel->withDeleted()->find($userID);  // Fetch even soft-deleted users
            if (!$user) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'User not found.'
                ]);
            }

            // Debug: Output the user data to check if DeletedDate is already set
            log_message('debug', 'User data: ' . print_r($user, true));

            // Check if the user has already been soft deleted
            if (!empty($user->DeletedDate)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'User has already been deleted.'
                ]);
            }

            // Perform the soft delete
            $result = $UserModel->delete($userID);  // Use delete() method for soft deletes

            // Check if any rows were affected
            if ($UserModel->db->affectedRows() > 0) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'User successfully deleted.'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No data to update. The user might not exist or has already been deleted.'
                ]);
            }
        }

        // If the request is not POST, return an error
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid request.'
        ]);
    }
    
    
    public function getUserDetailF5()
{
    try {
        // Capture the JSON input and decode it
        $postData = json_decode(file_get_contents("php://input"), true);

        // Log the JSON payload to confirm it's being received
        error_log("Received JSON data: " . json_encode($postData));

        // Extract UserID from JSON payload
        $userId = $postData['UserID'] ?? null;

        // Log the UserID to confirm it’s parsed correctly
        error_log("Parsed UserID: " . $userId);

        if (!$userId) {
            error_log("UserID is missing");
            return $this->response->setJSON([
                'success' => false,
                'message' => 'UserID is required.'
            ]);
        }

        // Proceed with finding the user in the database
        $UserModel = new \App\Models\UserModel();
        $user = $UserModel->find($userId);

        if ($user) {
            error_log("User data found: " . json_encode($user)); // Log user data for debugging
            return $this->response->setJSON([
                'success' => true,
                'userData' => [
                    'UserID' => $user['UserID'],
                    'ContactNo' => $user['ContactNo'],
                    'OfficeName' => $user['OfficeName'],
                    'HeadOfOffice' => $user['HeadOfOffice'],
                    'Position' => $user['Position'],
                    'OfficeAddress' => $user['Address'],
                    'Telefax' => $user['Telefax'],
                    'EmailAdd' => $user['EmailAdd'],
                ]
            ]);
        } else {
            error_log("User not found for UserID: " . $userId);
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User not found.'
            ]);
        }
    } catch (\Exception $e) {
        error_log("Exception in getUserDetailsF: " . $e->getMessage());
        return $this->response->setStatusCode(200)->setJSON([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ]);
    }
}
    
    public function getUserDetailsF2() {
        error_log("Endpoint hit with UserID: " . $this->request->getPost('UserID'));
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Endpoint reachable and UserID received',
            'receivedUserID' => $this->request->getPost('UserID')
        ]);
    }

    public function getUserDetailsF($userId)
    {
        $userModel = new UserModel();

        // Fetch user details based on UserID
        $userDetails = $userModel->getUserDetailsF($userId);

        if ($userDetails) {
            return $this->response->setStatusCode(200)->setJSON([
                'status' => 200,
                'data' => $userDetails
            ]);
        } else {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 404,
                'error' => true,
                'message' => 'User not found'
            ]);
        }
    }

    public function getUserRoleByUserId($userId)
    {
        $userModel = new UserModel();
    
        // Fetch user role based on UserID
        $userRole = $userModel->getUserRoleByUserId($userId);
    
        if ($userRole) {
            return $this->response->setStatusCode(200)->setJSON([
                'success' => true,
                'data' => [
                    'UserRole' => $userRole
                ]
            ]);
        } else {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'User role not found for the given UserID'
            ]);
        }
    }

    
}
