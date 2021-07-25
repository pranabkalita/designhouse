<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    'is_live'
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
}
