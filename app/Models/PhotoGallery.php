<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhotoGallery extends Model
{
        use HasFactory, SoftDeletes;
        protected $table = 'photo_gallery';
        protected $primaryKey = 'id';
        protected $fillable = [
        'name',
        'sequence',
        'cover_image',
       ];
       protected $dates = ['deleted_at', 'created_at', 'updated_at'];
}