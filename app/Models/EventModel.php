<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "events";
    // bir eventin birden fazla dosyasi olabilir
    public function file()
    {
        return $this->hasMany(EventFileModel::class);
    }

    // bir eventin birden fazla katilimcisi olabilir
    public function participants()
    {
        return $this->hasMany(EventParticipantsModel::class);
    }
}
