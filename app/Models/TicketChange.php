<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketChange extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'field',
        'previous_value',
        'new_value',
        'file_added',
        'file_deleted',
        'file_name',
        'file_path',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createWithFileChange($ticketId, $userId, $field, $previousValue, $newValue, $fileAdded = false, $fileDeleted = false, $fileName = null, $filePath = null)
    {
        return self::create([
            'ticket_id' => $ticketId,
            'user_id' => $userId,
            'field' => $field,
            'previous_value' => $previousValue,
            'new_value' => $newValue,
            'file_added' => $fileAdded,
            'file_deleted' => $fileDeleted,
            'file_name' => $fileName,
            'file_path' => $filePath,
        ]);
    }
}
