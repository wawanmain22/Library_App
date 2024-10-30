<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BooksReader extends Model
{
    protected $fillable = ['name', 'book', 'created_at', 'updated_at'];

    public $timestamps = false;

    // Tambahkan mutator untuk created_at
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value);
    }
}
