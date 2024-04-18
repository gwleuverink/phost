<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use ZBateson\MailMimeParser\Message as ParsedMessage;
use ZBateson\MailMimeParser\IMessage as ParsedMessageContract;

/**
 * @property ParsedMessageContract $parsed
 */
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

    //---------------------------------------------------------------
    // Attributes
    //---------------------------------------------------------------
    public function parsed(): Attribute
    {
        return Attribute::make(
            get: fn (): ParsedMessageContract => ParsedMessage::from($this->content, true)
        )->shouldCache();
    }

    //---------------------------------------------------------------
    // Helpers
    //---------------------------------------------------------------
    public function toggleBookmark(): void
    {
        $this->update([
            'bookmarked' => ! $this->bookmarked,
        ]);
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
}
