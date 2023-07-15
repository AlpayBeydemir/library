<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventParticipantsModel extends Model
{
    use HasFactory;
    protected $table = "events_participants";
    protected $guarded = ['updated_at'];
    public function event()
    {
        return $this->belongsTo(EventModel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'participants');
    }
}
