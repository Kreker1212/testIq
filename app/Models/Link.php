<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $link
 * @property int $id
 * @property string $code
 * @property Carbon $created_at
 */
class Link extends Model
{
    use HasFactory;

    const LENGTH_CODE = 6;

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'code',
        'link',
    ];
}
