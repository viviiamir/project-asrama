<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    protected $table = 'riwayat';
    protected $fillable = [
        'device_id', 'floor', 'event_type', 'value',
        'image_url', 'notif_channel', 'sirine_status', 'timestamp'
    ];
    public $timestamps = false;
}
