<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationEnter extends Model
{
    use HasFactory;

    public $fillable = ['type', 'category', 'brut_value', 'vat_tax_percent', 'vat_tax_value', 'net_value', 'title', 'comment'];
}
