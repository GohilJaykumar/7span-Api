<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHobby extends Model
{
    use HasFactory;
    
    protected $table = 'user_hobbies';
    protected $guarded  = ['id'];

    public function hobby()
    {
        return $this->belongsTo(Hobby::class);
    }
}
