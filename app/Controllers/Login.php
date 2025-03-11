<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Validation\Validation; // Ensure validation is loaded

class Login extends Controller
{
    public function index()
    {
        $data = [];

        // Check if validation errors exist
        if (session()->has('validation')) {
            $data['validation'] = session('validation');
        }

        return view('user/login', $data); // Ensure 'login.php' exists in app/Views/user/
    }

    public function login()
{
    $UserModel = new \App\Models\UserModel();
    helper(['form']);

    // Initialize data array to pass to view
    $data = [];

    if ($this->request->getMethod() === "POST") {
        $rules = [
            'Username' => 'required',
            'Password' => 'required',
        ];

        if (!$this->validate($rules)) {
            // If validation fails, return to login with errors
            return view('user/login', [
                'validation' => $this->validator
            ]);
        }

        // Fetch user from database
        $result = $UserModel->where('Username', $this->request->getPost('Username'))->first();

        if ($result) {
            // Verify hashed password
            if (password_verify($this->request->getPost('Password'), $result['Password'])) {
                // Set session data
                session()->set([
                    'userData' => [
                        'FirstName' => $result['FirstName'],
                        'ContactNo' => $result['ContactNo'],
                        'UserID' => $result['UserID'],
                        'UserRole' => $result['UserRole'],
                        'Status' => $result['Status'],
                        'OfficeName' => $result['OfficeName'],
                        'HeadOfOffice' => $result['HeadOfOffice'],
                        'Position' => $result['Position'],
                        'Address' => $result['Address'],
                        'Telefax' => $result['Telefax'],
                        'EmailAdd' => $result['EmailAdd'],
                    ],
                    'isLoggedIn' => true
                ]);

                return redirect()->to('dashboard');
            }
        }

        // Set flash message if login fails
        session()->setFlashdata('error', 'Invalid Username or Password.');
        return redirect()->to('/login')->withInput();
    }

    return view('user/login', $data);
}

}
