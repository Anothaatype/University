<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserModel extends Model
{
    use HasFactory;
    protected $table = 'm_user'; //mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id'; //mendifinikan primary key dari tabel yang digunakan

    /**
     * The attributes that are mass assignable 
     * 
     * @var array 
     */

     protected $fillable = ['level_id', 'username', 'nama', 'password'];

}
