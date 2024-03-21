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

        // TODO: Phase 2
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
        ][$this->status->name] ?? 'slate';
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

    // public function getStatusChanges()
    // {
    //     return $this->notes()->orderBy('created_at')->get();
    // }
    public function getStatusTimeline()
    {
        $statusTimeline = [];
        $notes = $this->notes()->where('new_status', '!=', null)->orderBy('created_at')->get();
    
        // Initialize the first status of the ticket
        $currentStatus = $this->status->name;
        $startDate = $this->created_at;
        $startTime = $startDate;
        $endDate = $startDate;
    
        foreach ($notes as $note) {
            // Store the duration for the current status
            $duration = $endDate->diffInMinutes($startDate);
            $statusTimeline[] = [
                'user_id' => $note->user_id,
                'status' => $currentStatus,
                'start_date' => Carbon::parse($startDate)->format('M d, Y'),
                'start_time' => Carbon::parse($startTime)->format('H:i:s'),
                'end_date' => Carbon::parse($endDate)->format('M d, Y'),
                'end_time' => Carbon::parse($endDate)->format('H:i:s'),
                'duration' => $duration,
            ];
    
            // Update the start date for the new status
            $startDate = $note->created_at;
            $startTime = $note->created_at;
            // Change the current status
            $currentStatus = $note->new_status;
            // Update the end date
            $endDate = $note->created_at;
        }
    
        // Include the last status until now
        $duration = Carbon::now()->diffInMinutes($startDate);
        $statusTimeline[] = [
            'status' => $currentStatus,
            'start_date' => Carbon::parse($startDate)->format('M d, Y'),
            'start_time' => Carbon::parse($startTime)->format('H:i:s'),
            'end_date' => Carbon::now()->format('Y-m-d'),
            'end_time' => Carbon::now()->format('H:i:s'),
            'duration' => $duration,
        ];
    
        return $statusTimeline;
    }
    
}
