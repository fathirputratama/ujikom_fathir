<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    //
    protected $fillable = [
        'user_id',
        'member_id',
        'total_price',
        'amount_paid',
        'change',
        'point_used',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function member(){
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function saledetails(){
        return $this->hasMany(SaleDetail::class , 'sale_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'sale_details')
                    ->withPivot('quantity', 'subtotal')
                    ->withTimestamps();
    }
}
