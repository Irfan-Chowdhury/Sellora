<?php

namespace App\Models;

use App\Enums\ImageDirectory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug', 'name', 'image', 'is_active'
    ];

    public function getSmallImageUrlAttribute()
    {
        // $directory = 'uploads/images/brands/small';
        $directory = ImageDirectory::BRAND->value.'/small';

        // return isset($this->image) && Storage::disk('public')->exists($directory.'/'.$this->image) ? url(Storage::url("{$directory}/{$this->image}")) : url("images/empty.jpg");
        return isset($this->image) && Storage::disk('public')->exists($directory.'/'.$this->image) ? url(Storage::url("{$directory}/{$this->image}")) : 'https://placehold.co/600x400?text=Category';
    }

    public function getMediumImageUrlAttribute()
    {
        // $directory = 'uploads/images/brands/small';
        $directory = ImageDirectory::BRAND->value.'/medium';

        return isset($this->image) && Storage::disk('public')->exists($directory.'/'.$this->image) ? url(Storage::url("{$directory}/{$this->image}")) : 'https://placehold.co/600x400?text=Category';
    }

    public function getLargeImageUrlAttribute()
    {
        // $directory = 'uploads/images/brands/large';
        $directory = ImageDirectory::BRAND->value.'/large';

        return isset($this->image) && Storage::disk('public')->exists($directory.'/'.$this->image) ? url(Storage::url("{$directory}/{$this->image}")) : 'https://placehold.co/600x400?text=Category';
    }
}
