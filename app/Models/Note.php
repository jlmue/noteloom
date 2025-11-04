<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Note model representing user notes
 */
class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'is_important',
    ];

    protected $casts = [
        'is_important' => 'boolean',
    ];

    /**
     * Get the user that owns the note
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
