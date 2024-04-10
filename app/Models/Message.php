<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ZBateson\MailMimeParser\Message as ParsedMessage;

class Message extends Model
{
    protected $fillable = [
        'bookmarked',
        'content',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'immutable_datetime',
        'bookmarked' => 'boolean',
    ];

    public static function fromContent(string $content): self
    {
        return self::create([
            'content' => $content,
        ]);
    }

    public function parsed(): ParsedMessage
    {
        return once(
            fn () => ParsedMessage::from($this->content, true)
        );
    }

    public function markRead(): void
    {
        if ($this->read_at) {
            return;
        }

        $this->update([
            'read_at' => now(),
        ]);
    }

    public function toggleBookmark(): void
    {
        $this->update([
            'bookmarked' => ! $this->bookmarked,
        ]);
    }
}
