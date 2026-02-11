<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $key
 * @property string $parent
 * @property ?string $value
 */
class Extern extends Model
{
    /** @use HasFactory<\Database\Factories\ExternFactory> */
    use HasFactory;

    protected $guarded = [];
}
