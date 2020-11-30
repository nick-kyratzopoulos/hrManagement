<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Department extends Model
{
    use HasFactory, Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'manager_id',
    ];

    public function users() {
        return $this->hasMany(User::class);
    }

    public function manager() {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
