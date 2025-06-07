<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormUser extends Model
{
    /** @use HasFactory<\Database\Factories\FormUserFactory> */
    use HasFactory;

    protected $fillables = ['name', 'user_name', 'password', 'email', 'phone_number', 'whatsapp_phone_number', 'address', 'image_path'];
}