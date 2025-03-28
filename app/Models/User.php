<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// class User extends Authenticatable implements MustVerifyEmail
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login' => 'datetime',
    ];

    public function getUserColorAttribute()
    {
        return [
            'admin'=> 'odc-red',
            'user'=> 'slate',
        ][$this->role] ?? 'slate';
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(fn ($query) =>
                $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('role_id', 'like', '%' . $search . '%')
            );
        });
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function getPositionNameAttribute()
    {
        return [
            '4'=> 'Developer',
            '7'=> 'Finance',
            '9'=> 'Maintenance',
            '10'=> 'UI/UX',
            '11'=> 'Marketing',
            '12'=> 'HR',
            '1013'=> 'test',
            '1014'=> 'junior dev',
            '1015'=> 'Graphic Designer',
        ][$this['position']] ?? 'CSR';

        // $positionName = [
        //     '4'=> 'Developer',
        //     '7'=> 'Finance',
        //     '9'=> 'Maintenance',
        //     '10'=> 'UI/UX',
        //     '11'=> 'Marketing',
        //     '12'=> 'HR',
        //     '1013'=> 'test',
        //     '1014'=> 'junior dev',
        //     '1015'=> 'Graphic Designer',
        // ];
    
        // return $positionName[$positionId] ?? 'CSR';
    }

    public function getPositionName($positionId)
    {
        $positionName = [
            '1' => 'User',
            '2' => 'Admin',
            '3' => 'Employee',
            '14' => 'CorporateAdmin',
        ];
    
        return $positionName[$positionId] ?? 'CSR';
    }
}
