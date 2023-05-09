<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageMaster extends Model
{
    use HasFactory;
    protected $connection = 'HRDSQL_TRAINING(Shiyousho_Catalog_Test)';
    protected $table = 'image_masters';

}
