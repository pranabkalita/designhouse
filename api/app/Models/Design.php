<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Design extends Model
{
  use HasFactory;

  protected $fillable = [
    'image',
    'title',
    'description',
    'slug',
    'close_to_comment',
    'is_live',
    'upload_successful',
    'disk'
  ];

  // FILE PATHS
  public static $TMP_LOCATION = [
    'ORIGINAL_FILE' => '/uploads/original/',
    'LARGE_FILE' => '/uploads/large/',
    'THUMBNAIL_FILE' => '/uploads/thumbnail/',
  ];

  public static $PUBLIC_LOCATION = [
    'ORIGINAL_FILE' => '/uploads/designs/original/',
    'LARGE_FILE' => '/uploads/designs/large/',
    'THUMBNAIL_FILE' => '/uploads/designs/thumbnail/',
  ];

  // RELATIONSHIPS

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  // MUTATORS

  public function setSlugAttribute($title)
  {
    $this->attributes['slug'] = Str::slug($title);
  }

  public function getImagesAttribute()
  {
    return [
      'original' => $this->getImagePath('ORIGINAL_FILE'),
      'large' => $this->getImagePath('LARGE_FILE'),
      'thumbnail' => $this->getImagePath('THUMBNAIL_FILE'),
    ];
  }

  protected function getImagePath($size) {
    return Storage::disk($this->disk)->url(ltrim($this::$PUBLIC_LOCATION[$size], '/') . $this->image);
  }
}
