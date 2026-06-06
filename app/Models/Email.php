<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model {
  protected $fillable = [
    'subject',
    'title',
    'html',
    'template_used',
    'button_text',
    'button_url',
    'sender_name',
    'sender_email'
  ];
  public function recipients(){ return $this->hasMany(EmailRecipient::class); }
}