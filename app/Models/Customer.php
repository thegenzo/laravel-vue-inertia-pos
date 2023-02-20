<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'no_telp',
        'address',
    ];

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
