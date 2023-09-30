<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubject extends Model
{

    protected $primaryKey = null;
    public $incrementing = false;
    protected $table = "user_subject";

    protected $fillable = [
        'user_id',
        'subject_id',
        'mark',
    ];

    public $timestamps = false;

}
