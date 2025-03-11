<?php

namespace App\Models;

use CodeIgniter\Model;

/* class ClientModel extends Model
{
    protected $table      = 'tblregistration';
    protected $primaryKey = 'RegistrationNo';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;  // Depending on whether you need soft deletes

    protected $allowedFields = [
        'RegistrationNo',
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
        'Purpose',
        'OfficeName',
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
        'CreatedDate',  // Add this field if timestamps are required
        'ExpiryDate',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates (if required by your database schema)
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'CreatedDate';
    protected $updatedField  = 'UpdatedDate';
} */

class ClientModel1 extends Model
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
}