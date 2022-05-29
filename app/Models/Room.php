<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    
    const GENERAL = 'General';

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
