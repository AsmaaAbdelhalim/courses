<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

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
        //'user_id',
    ];

    // ...
    public static function boot() {
        parent::boot();
        
        static::created(function ($item) {
            $adminEmail =  config('mail.admin');
            Mail::to($adminEmail)->send(new ContactMail($item));
        });
    }
}
