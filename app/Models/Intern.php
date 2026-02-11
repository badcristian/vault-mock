<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $key
 * @property ?string $value
 */
class Intern extends Model
{
    /** @use HasFactory<\Database\Factories\InternFactory> */
    use HasFactory;

    protected $guarded = [];

}
