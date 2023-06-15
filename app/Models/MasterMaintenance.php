<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterMaintenance extends Model
{
    use HasFactory, SoftDeletes;
    protected $connection = 'HRDSQL_TRAINING(Shiyousho_Catalog_Test)';
    protected $table = 'master_maintenance';

}
