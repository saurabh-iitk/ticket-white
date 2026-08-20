<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoGallery extends Model
{
        use HasFactory;
        protected $table = 'video_gallery';
        protected $primaryKey = 'id';
        protected $fillable = [
        'name',
        'sequence',
        'youtube_id',
       ];
       protected $dates = ['deleted_at', 'created_at', 'updated_at'];
}