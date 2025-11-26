<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distribusi extends Model
{
    protected $table = 'distribusi';
    public $timestamps = false;

    protected $fillable = [
        'device_id','floor','event_type','notif_channel',
        'status','message','image_url','timestamp'
    ];
}
