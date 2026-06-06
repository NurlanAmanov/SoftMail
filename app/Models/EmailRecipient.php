<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailRecipient extends Model {
  protected $fillable=['email_id','recipient_email','status','brevo_message_id','open_count','delivered_at','opened_at','clicked_at','last_response'];
  protected $casts=['last_response'=>'array','delivered_at'=>'datetime','opened_at'=>'datetime','clicked_at'=>'datetime'];
  public function email(){ return $this->belongsTo(Email::class); }
}
