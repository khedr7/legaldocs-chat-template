<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable  = ['conversation_id', 'message', 'response'];

    protected $casts = [
        'conversation_id' => 'integer',
        'message'   => 'string',
        'response'  => 'string',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id', 'id');
    }

    public function messageDocuments()
    {
        return $this->hasMany(MessageDocument::class);
    }

}
