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
        'DeletedDate',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'CreatedDate';
    protected $updatedField  = 'UpdatedDate';
    protected $deletedField  = 'DeletedDate';

    // Method to retrieve user details by UserID
    public function getUserDetailsF($userId)
    {
        return $this->where('UserID', $userId)->first();
    }


    public function getUserRoleByUserId($userId)
    {
        // Use the Model's query builder
        $result = $this->select('UserRole') // Select only the UserRole column
            ->where('UserID', $userId) // Add the condition
            ->first(); // Get the first matching record

        // Check if a result was found and return it
        if ($result) {
            return $result->UserRole; // Access the UserRole property of the returned object
        } else {
            return false; // Return false if no record was found
        }
    }
}
