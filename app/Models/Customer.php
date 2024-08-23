<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function invoices()
    {
        return $this->hasMany(Invoice::class)->where('invoices.deleted_at', null);
    }

    public function last_invoices()
    {
        return $this->hasMany(Invoice::class)->where('invoices.status', '!=', 'annullata')->orderBy('invoices.created_at', 'DESC')->limit(10);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
