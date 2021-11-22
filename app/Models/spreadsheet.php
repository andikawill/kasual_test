<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class spreadsheet
 * @package App\Models
 * @version November 21, 2021, 10:24 am UTC
 *
 * @property First $[first_name,
 * @property Last $[last_name,
 * @property Gender] $[gender,
 * @property Email] $[email,
 * @property IP $[ip_address,
 */
class spreadsheet extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'spreadsheets';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        '[first_name,',
        '[last_name,',
        '[gender,',
        '[email,',
        '[ip_address,'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
