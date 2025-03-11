<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'tblusers';
    protected $primaryKey = 'UserID';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'UserID',
        'FirstName',
        'LastName', 
        'MiddleName', 
        'ContactNo',
        'UserRole',
        'OfficeName',
        'HeadOfOffice',
        'Position',
        'Address',
        'Telefax',
        'EmailAdd',
        'Status',
        'Username',
        'Password',
        'DeletedDate',  // Include this field


    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'CreatedDate';
    protected $updatedField  = 'UpdatedDate';
    protected $deletedField  = 'DeletedDate';

 

}