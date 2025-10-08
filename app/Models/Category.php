<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'slug', 'name', 'image','top','is_active','icon','parent_id'
    ];

    protected $dates = ['deleted_at'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = htmlspecialchars_decode($value);
    }

    public function getSmallImageUrlAttribute()
    {
        $directory = 'uploads/images/categories/small';

        return isset($this->image) && Storage::disk('public')->exists($directory.'/'.$this->image) ? url(Storage::url("{$directory}/{$this->image}")) : url("images/empty.jpg");
    }

    public function getMediumImageUrlAttribute()
    {
        $directory = 'uploads/images/categories/medium';

        return isset($this->image) && Storage::disk('public')->exists($directory.'/'.$this->image) ? url(Storage::url("{$directory}/{$this->image}")) : url("images/empty.jpg");
    }


    public function childs()
    {
        return $this->hasMany(self::class,'parent_id');
    }

    public function parentCategory()
    {
        return $this->belongsTo(self::class,'parent_id');
    }
}
