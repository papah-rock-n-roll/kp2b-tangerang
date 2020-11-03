<?php namespace App\Models;

use CodeIgniter\Model;

class FarmerModel extends Model
{
    protected $table = 'mstr_farmers';
    protected $primaryKey = 'farmcode';
    protected $allowedFields = ['farmcode','farmname','farmmobile','farmhead'];
}