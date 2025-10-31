<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Table name
    protected $table = 'tbl_products';

    //Primary key
    protected $primaryKey = 'prod_id';

    // Disable default timestamps
    public $timestamps = true;

    // Set custom names for timestamp columns
    const CREATED_AT = 'prod_created_at';
    const UPDATED_AT = 'prod_updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'prod_name',
        'prod_price',
        'prod_description',
        'prod_quantity',
        'prod_deleted',
        'prod_created_at',
        'prod_updated_at'
    ];
}
