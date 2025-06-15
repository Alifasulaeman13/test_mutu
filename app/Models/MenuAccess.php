<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuAccess extends Model
{
    protected $table = 'menu_access';
    
    protected $fillable = [
        'role_id',
        'menu_key'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
