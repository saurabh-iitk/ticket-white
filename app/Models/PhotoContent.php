<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhotoContent extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'photo_content';
    protected $primaryKey = 'id';
    protected $fillable = [
    'gallery_id',
    'name',
    'sequence',
    'cover_img',
   ];
   protected $dates = ['deleted_at', 'created_at', 'updated_at'];
}