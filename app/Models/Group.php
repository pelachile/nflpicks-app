<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'code',
        'max_members',
        'created_by',
        'season',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members(): HasMany
    {
        return $this->hasMany(GroupMember::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'group_members')
            ->withPivot('is_admin', 'joined_at')
            ->withTimestamps();
    }

    // Helper methods
    public function isFull(): bool
    {
        return $this->members()->count() >= $this->max_members;
    }

    public function isUserMember(int $userId): bool
    {
        return $this->members()->where('user_id', $userId)->exists();
    }

    public function isUserAdmin(int $userId): bool
    {
        return $this->members()->where('user_id', $userId)->where('is_admin', true)->exists();
    }

    // Update app/Models/Group.php - add this to the existing class

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($group) {
            // Delete all group members
            $group->members()->delete();

            // If you have predictions tied to groups, delete those too
            // This depends on your weekly_scores table structure
            // WeeklyScore::where('group_id', $group->id)->delete();
        });
    }
}
