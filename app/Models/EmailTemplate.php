<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $table = 'email_templates';

    protected $fillable = ['name', 'slug', 'html_content', 'json_structure'];

    protected $casts = [
        'json_structure' => 'array',
    ];
}
