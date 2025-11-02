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

    // Accessors to remove 'prod_' prefix for easy access
    public function getIdAttribute()
    {
        return $this->attributes['prod_id'];
    }

    public function getNameAttribute()
    {
        return $this->attributes['prod_name'];
    }

    public function getDescriptionAttribute()
    {
        return $this->attributes['prod_description'];
    }

    public function getPriceAttribute()
    {
        return $this->attributes['prod_price'];
    }

    public function getQuantityAttribute()
    {
        return $this->attributes['prod_quantity'];
    }

    public function getDeletedAttribute()
    {
        return $this->attributes['prod_deleted'] ?? 0;;
    }

    public function getCreatedAtAttribute()
    {
        return $this->attributes['prod_created_at'];
    }

    public function getUpdatedAtAttribute()
    {
        return $this->attributes['prod_updated_at'];
    }

    // Optional: include these accessors in JSON output
    protected $appends = [
        'id',
        'name',
        'description',
        'price',
        'quantity',
        'deleted',
        'created_at',
        'updated_at'
    ];

    // Hide original columns so they don’t appear in JSON
    protected $hidden = [
        'prod_id',
        'prod_name',
        'prod_description',
        'prod_price',
        'prod_quantity',
        'prod_deleted',
        'prod_created_at',
        'prod_updated_at',
    ];
}
