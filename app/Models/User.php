<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Lesson;
use App\Models\CourseUser;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

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
    ];


    public function course()
    {
        return $this->hasMany(Course::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'course_users')
            ->withPivot('completed', 'course_id')
            ->withTimestamps();
    }

    public function courseUsers()
    {
        return $this->hasMany(CourseUser::class);
    }

    public function courseProgress(int $courseId): int
    {
        $course = Course::withCount('lessons')->find($courseId);

        if (!$course || $course->lessons_count === 0) {
            return 0;
        }

        $completedCount = $this->lessons()
            ->where('lessons.course_id', $courseId)
            ->wherePivot('completed', 1)
            ->count();

        return round(($completedCount / $course->lessons_count) * 100);
    }
}