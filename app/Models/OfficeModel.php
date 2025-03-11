<?php

namespace App\Models;

use CodeIgniter\Model;

class OfficeModel extends Model
{
    protected $table      = 'tbloffice';  // Ensure this matches the actual table name
    protected $primaryKey = 'OfficeID';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'OfficeName',
        'HeadOfOffice', 
        'Position',
        'Address',
        'Telefax',
        'EmailAdd',
        'CreatedDate',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'CreatedDate';
}