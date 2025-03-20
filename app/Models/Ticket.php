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
use Carbon\Carbon;

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
    public function getRouteKeyName()
    {
        return 'number';
    }

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
    }

    public function getStatusColorAttribute()
    {
        return [
            'Open' => 'stat-bg-red',
            'Pending' => 'stat-bg-blue',
            'In-progress' => 'stat-bg-yellow',
            'In-review' => 'stat-bg-purple',
            'Closed' => 'stat-bg-green',
        ][$this->status->name] ?? 'slate';
    }

    public function getStatusTextColorAttribute()
    {
        return [
            'Open' => 'stat-text-red',
            'Pending' => 'stat-text-blue',
            'In-progress' => 'stat-text-yellow',
            'In-review' => 'stat-text-purple',
            'Closed' => 'stat-text-green',
        ][$this->status->name] ?? 'slate';
    }

    public function getUpdatedStatusColor($statusName)
    {
        $colors = [
            'Open' => 'stat-bg-red',
            'Pending' => 'stat-bg-blue',
            'In-progress' => 'stat-bg-yellow',
            'In-review' => 'stat-bg-purple',
            'Closed' => 'stat-bg-green',
        ];
    
        return $colors[$statusName] ?? 'slate';
    }

    public function getUpdatedStatusTextColor($statusName)
    {
        $colors = [
            'Open' => 'stat-text-red',
            'Pending' => 'stat-text-blue',
            'In-progress' => 'stat-text-yellow',
            'In-review' => 'stat-text-purple',
            'Closed' => 'stat-text-green',
        ];
    
        return $colors[$statusName] ?? 'slate';
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

    public function updateFiles($user, $previousFiles, $newFiles)
    {
        $fileChanges = [
            'previous_files' => $previousFiles,
            'new_files' => $newFiles,
        ];

        TicketChange::create([
            'ticket_id' => $this->id,
            'user_id' => $user->id,
            'field' => 'files',
            'previous_value' => json_encode($fileChanges['previous_files']),
            'new_value' => json_encode($fileChanges['new_files']),
        ]);
    }

    public function temporaryFiles()
    {
        return $this->hasMany(TemporaryFile::class);
    }

    public function richTexts()
    {
        return $this->morphMany(RichText::class, 'record');
    }

    public function changes()
    {
        return $this->hasMany(TicketChange::class);
    }

    public function getLatestWeeklyTickets()
    {
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();

        $tickets = Ticket::whereBetween('created_at', [$startDate, $endDate])
                            ->orderBy('created_at', 'desc')
                            ->get();

        $ticketsByDate = [];

        foreach ($tickets as $ticket) {
            $date = $ticket->created_at->toDateString();
            if (!isset($ticketsByDate[$date])) {
                $ticketsByDate[$date] = [];
            }
            $ticketsByDate[$date][] = $ticket;
        }
    
        return $ticketsByDate;
    }
}
