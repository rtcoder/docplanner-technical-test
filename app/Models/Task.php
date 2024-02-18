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

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class)
            ->select([
                'name'
            ]);
    }
}
