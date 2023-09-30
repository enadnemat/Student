<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'pass_mark',
        'obtained_mark',
    ];


    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_subject')->withPivot('mark');
    }
}
