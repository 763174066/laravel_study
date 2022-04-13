<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Watchman extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'watchmen';

    protected $fillable = [
        'date',
        'week',
        'user_id',
    ];
    protected $dates = ['date'];

    public static $weekMap = [
        '星期天',
        '星期一',
        '星期二',
        '星期三',
        '星期四',
        '星期五',
        '星期六',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class,'user_id','id');
    }
}
