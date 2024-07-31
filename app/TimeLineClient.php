<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeLineClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'lead',
        'active',
        'date',
        'image',
        'audio',
        'description',
        'client_id'
    ];

    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }
}