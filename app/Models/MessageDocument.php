<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'message_documents';

    protected $fillable = ['message_id', 'title'];

    protected $casts = [
        'message_id' => 'integer',
        'title'   => 'string',
    ];

    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id', 'id');
    }
}
