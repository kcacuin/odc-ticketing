<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Ticket extends Model
{
    use HasFactory, SoftDeletes, HasRichText;
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
    ];
    protected $casts = [
        'files' => 'array',
    ];

    protected $with = ['status'];

    protected $dates = ['deleted_at'];

    protected $richTextAttributes = [
        'issue',
        'notes',
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(fn ($query) =>
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('number', 'like', '%' . $search . '%')
                    ->orWhere('date_received', 'like', '%' . $search . '%')
                    ->orWhere('requested_by', 'like', '%' . $search . '%')
                    ->orWhere('client', 'like', '%' . $search . '%')
                    ->orWhere('product', 'like', '%' . $search . '%')
            )->orWhereHas('richTexts', fn ($query) =>
                $query->where('field', 'issue')
                    ->where('body', 'like', '%' . $search . '%')
            );
        });

        // $query->when($filters['issues'] ?? false, fn($query, $issue) =>
        //     $query->whereHas('issues', fn ($query) =>
        //         $query->where('issues', $issue)
        //     )
        // );

        // $query->when($filters['client'] ?? false, fn($query, $client) =>
        //     $query->whereHas('client', fn ($query) =>
        //         $query->where('client', $client)
        //     )
        // );
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

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function temporaryFiles()
    {
        return $this->hasMany(TemporaryFile::class);
    }

    public function richTexts()
    {
        return $this->morphMany(RichText::class, 'record');
    }
}
