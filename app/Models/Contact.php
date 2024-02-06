<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Mail;

use App\Mail\ContactMail;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'subject',
        'phone',
        'message',
        'country',
        'city',
        ///'user_id',
    ];

    // ...
    public static function boot() {
        parent::boot();
        
        static::created(function ($item) {

            $adminEmail = "onlinecoursesplatform@gmail.com";
            Mail::to($adminEmail)->send(new ContactMail($item));
        });
    }
}
