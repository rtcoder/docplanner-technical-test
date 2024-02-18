<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property-read  string $status_name
 * @property-read  User $user
 * @property TaskStatus $status
 * @property int $user_id
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
    ];

    protected $guarded = [
        'status',
        'user_id',
    ];

    protected $casts = [
        'status' => TaskStatus::class,
    ];

    protected $with = [
        'user',
    ];

    protected $appends = [
        'status_name',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)
            ->select([
                'id',
                'name',
                'email',
            ]);
    }

    public function getStatusNameAttribute(): string
    {
        return match ($this->status) {
            TaskStatus::Pending => 'Pending',
            TaskStatus::InProgress => 'In Progress',
            TaskStatus::Completed => 'Completed',
        };
    }
}
