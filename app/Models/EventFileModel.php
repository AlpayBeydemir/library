<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventFileModel extends Model
{
    use HasFactory;
    protected $table = "events_file";
    public function event()
    {
        return $this->belongsTo(EventModel::class);
    }
}
