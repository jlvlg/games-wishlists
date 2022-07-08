<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bought',
        'deleted',
        'user_id',
    ];

    public function games() {
        return $this->hasMany(Game::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
