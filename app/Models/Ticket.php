<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'number',
        'date_received',
        'title',
        'issue',
        'requested_by',
        'client',
        'product',
        'status_id',
        'files',
    ];

    protected $with = ['status'];

    protected $dates = ['deleted_at'];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, fn($query, $search) =>
            $query->where(fn($query) =>
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('issue', 'like', '%' . $search . '%')
                    ->orWhere('requested_by', 'like', '%' . $search . '%')
                    ->orWhere('client', 'like', '%' . $search . '%')
                    ->orWhere('product', 'like', '%' . $search . '%')
            )
        );

        $query->when($filters['statuses'] ?? false, fn($query, $status) =>
            $query->whereHas('statuses', fn ($query) =>
                $query->where('statuses', $status)
            )
        );

        $query->when($filters['client'] ?? false, fn($query, $client) =>
            $query->whereHas('client', fn ($query) =>
                $query->where('client', $client)
            )
        );
    }

    public function getStatusColorAttribute()
    {
        return [
            'Open'=> 'red',
            'Pending'=> 'blue',
            'In-progress'=> 'yellow',
            'In-review'=> 'purple',
            'Closed'=> 'green',
        ][$this->status->name] ?? 'cool-gray';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

}
