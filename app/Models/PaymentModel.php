<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table      = 'tblpayment';
    protected $primaryKey = 'PaymentNo';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;  

    protected $allowedFields = [
        'PaymentNo',
        'RegistrationNo',
        'TotalFees',
        'QRCodeSchedule',
        'GCashReferenceNo',
        'OfficeName',
        'RPSChief',
        'Cashier',
        'Month',
        'Year',
        'CreatedDate',
    ];

    // Disable automatic timestamp handling if you're manually setting it
    protected $useTimestamps = false; 
}