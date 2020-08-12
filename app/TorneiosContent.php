<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TorneiosContent extends Model
{
    protected $table = 'torneios_content';

    protected $fillable = [
        'torneios_id', 'team_id', 'statue_id'
    ];

}
