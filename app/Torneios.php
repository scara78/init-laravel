<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Torneios extends Model
{
    protected $table = 'torneios';

    protected $fillable = [
        'name', 'no', 'time_left', 'is_team'
    ];

    protected $appends = ["user_count"];
    
    public function getUserCountAttribute() {
        return TorneiosContent::where('torneios_id', $this->id)->count();
    }
}
