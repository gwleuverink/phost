<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ZBateson\MailMimeParser\Message as ParsedMessage;

class Message extends Model
{
    protected $fillable = [
        'content',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'immutable_datetime',
    ];

    public static function fromContent(string $content): self
    {
        return self::create([
            'content' => $content,
        ]);
    }

    public function parsed(): ParsedMessage
    {
        return ParsedMessage::from($this->content, true);
    }
}
