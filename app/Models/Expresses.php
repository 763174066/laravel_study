<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expresses extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','express_com_id','num'];

    public function user(){
        return $this->belongsTo(UserModel::class);
    }

    public function expressCom(){
        return $this->belongsTo(ExpressCom::class);
    }
}
