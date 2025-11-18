<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuotePart extends Model
{
    use SoftDeletes;

    protected $fillable = ['quote_id', 'part_type', 'text', 'weight'];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
}
