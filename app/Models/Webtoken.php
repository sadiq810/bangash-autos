<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Webtoken extends Model
{
    protected $table = 'web_tokens';
    protected $guarded = ['id'];
}
