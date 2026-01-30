<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
  protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'profile_photo',
];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function coursesTeaching() {
    return $this->hasMany(Course::class, 'instructor_id');
}

public function enrolledCourses() {
    return $this->belongsToMany(Course::class)->withPivot('enrolled_at', 'pricing_plan_id');
}

// App\Models\User.php

public function getProfilePhotoUrlAttribute()
{
    return $this->profile_photo 
        ? asset('storage/' . $this->profile_photo) 
        : asset('images/default-profile.png');
}

public function messages()
{
    return $this->hasMany(Message::class, 'sender_id')
        ->orWhere('receiver_id', $this->id);
}

}
