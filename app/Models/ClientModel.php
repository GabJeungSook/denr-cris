<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table      = 'tblregistration';
    protected $primaryKey = 'RegistrationNo';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'RegistrationNo',
        'UserID',
        'Fullname',
        'ContactNo',
        'Barangay',
        'Municipality',
        'Province',
        'Brand',
        'Model',
        'EngineCapacity',
        'SerialNo',
        'DateOfAcquisition',
        'MaxLengthGuideBar',
        'Horsepower',
        'Purpose',
        'OfficeName',
        'HeadOfOffice',
        'Position',
        'OfficeAddress',
        'Telefax',
        'EmailAdd',
        'Status',
        'PaymentStatus',
        'RegsType',
        'Image',
        'ProfOwnShip',
        'ProfOwnShipFilePath',
        'CertBrgy',
        'CertBrgyFilePath',
        'CertRegs',
        'CertRegsFilePath',
        'Month',
        'Year',
        'CreatedDate',
        'UpdatedDate',  
        'ExpiryDate',
        'Remarks',
    ];

    // Disable automatic timestamp handling if you're manually setting it
    protected $useTimestamps = false;

    // Custom method to get confirmed registration by UserID
    public function getPendingRegistrationNo($userId) // Flutter API
    {
        try {
            if (empty($userId)) {
                log_message('error', 'UserID is empty or null.');
                return [];
            }
    
            return $this->where('UserID', $userId)
                        ->where('Status', 'Confirmed')
                        ->where('PaymentStatus', 'For Payment')
                        ->findAll();
        } catch (\Exception $e) {
            log_message('error', 'Database error in getPendingRegistrationNo: ' . $e->getMessage());
            return [];
        }
    }

    public function getClientByRegistrationNo1($registrationNo) // Flutter API
    {
        return $this->db->table('tblregistration') // Replace 'tblclients' with your actual table name
        ->where('RegistrationNo', $registrationNo)
            ->get()
            ->getRowArray(); // Fetch a single row as an array
    }

    public function getClientByRegistrationNo($registrationNo)
    {
        // Query to fetch details using RegistrationNo
        return $this->where('RegistrationNo', $registrationNo)
            ->select('Image, RegistrationNo, Fullname, Brand, Model, SerialNo, Horsepower, CreatedDate, ExpiryDate')
            ->first();
    }


    
}
