<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    /**
     * Table name
     */
    protected $table = 'announcements';

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'title',
        'content',
        'author_id',
        'audience',
        'is_published',
        'published_at',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Get the author (user) of this announcement.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class,'author_id');
    }

    /**
     * Scope: only published announcements.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)->whereNotNull('published_at');
    }
}
