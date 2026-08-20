<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_content',
        'ip_address',
        'browser',
    ];
}
?>