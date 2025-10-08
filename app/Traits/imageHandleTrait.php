<?php

namespace App\Traits;

use App\Enums\ImageDirectory;
use Exception;
use Illuminate\Support\Facades\Session;
use Image;
use Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait imageHandleTrait {


    public function imageStore(
        string|object $imageFile,
        // string $directory,
        ImageDirectory $directory,
        int|null $width=null,
        int|null $height=null,
        bool|null $isSmall=true,
        bool|null $isMedium=true,
        bool|null $isLarge=true,

    ): string
    {
        if (is_string($imageFile)) {
            // Case 1: existing file name
            $extension = strtolower(pathinfo($imageFile, PATHINFO_EXTENSION));
            $originalName = pathinfo($imageFile, PATHINFO_FILENAME);
            $image = Image::make($imageFile);

            // Keep original filename, only change extension to .webp
            $fileName = $originalName . '.webp';

        } else {
            // Case 2: Uploaded new file object
            $extension = strtolower($imageFile->getClientOriginalExtension());
            $image = Image::make($imageFile->getRealPath());

            // New uploads → random name
            $fileName = Str::random(10) . '.webp';
        }


        // Block unsupported types
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
        if (!in_array($extension, $allowed)) {
            throw new Exception("Unsupported image type: {$extension}");
        }

        if ($isSmall) {
            $this->saveImageVariant($image, $directory->value . 'small/', $fileName, 60, 40);
        }

        if ($isMedium) {
            $this->saveImageVariant($image, $directory->value . 'medium/', $fileName, 300, 300);
        }

        if ($isLarge) {
            $this->saveImageVariant($image, $directory->value . 'large/', $fileName, $width, $height);
        }

        return $fileName;
    }

    private function saveImageVariant($image, string $path, string $fileName, ?int $width, ?int $height): void
    {
        $cloneImage = clone $image; // ensure original quality preserved

        if ($width && $height) {
            $cloneImage->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        $cloneImage->encode('webp');
        Storage::disk('public')->put($path . $fileName, $cloneImage);
    }

    public function imageSliderStore($image, $directory,$width, $height)
    {
        $imageName       = Str::random(10). '.' .$image->getClientOriginalExtension();
        $location  = public_path($directory.$imageName);
        Image::make($image)->resize($width,$height)->save($location);
        $imageUrl = $directory.$imageName;

        return $imageUrl;
    }


    //General
    public function previousImageDelete(string|null $filePath): void
    {
        // if (File::exists(public_path($filePath))) {
        //     File::delete(public_path($filePath));
        // }

        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }



    // private function convertIntoSmallImage($image, $directory, $fileName)
    // {
    //     $image->resize(50, 50)->encode('webp');

    //     $filePath = $directory.'small/' . $fileName;

    //     Storage::disk('public')->put($filePath, $image);
    // }

    // private function convertIntoMediumImage($image, $directory, $fileName)
    // {
    //     $image->resize(300, 300)->encode('webp');

    //     $filePath = $directory.'medium/' . $fileName;

    //     Storage::disk('public')->put($filePath, $image);
    // }

    // private function convertIntoLargeImage($image, $directory, $fileName, int|null $width=null, int|null $height=null)
    // {
    //     if ($width && $height) {
    //         $image->resize($width, $height);
    //     }

    //     $image->encode('webp');

    //     $filePath = $directory.'large/' . $fileName;

    //     Storage::disk('public')->put($filePath, $image);
    // }





    // // Old - 2
    // public function imageStore(string|object $imageFile, string $directory, int|null $width=null, int|null $height=null): string
    // {
    //     $extension = strtolower($imageFile->getClientOriginalExtension());

    //     // Block unsupported types
    //     $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
    //     if (!in_array($extension, $allowed)) {
    //         throw new Exception("Unsupported image type: {$extension}");
    //     }

    //     $fileName  = Str::random(10) . '.' . $extension;

    //     // $image = Image::make($imageFile)->resize($width, $height)->encode($extension); // you may also encode to $extension
    //     $image = Image::make($imageFile);

    //     if ($width && $height) {
    //         $image->resize($width, $height);
    //     }

    //     $image->encode($extension);

    //     $filePath = $directory . $fileName;

    //     Storage::disk('public')->put($filePath, $image);

    //     return $filePath;
    // }





    //Old-1
    // public function imageStore(string|object $imageFile, string $directory, int $width, int $height)
    // {

    //     // $directory = 'uploads/images/categories/';

    //     $fileName  = Str::random(10). '.' .$imageFile->getClientOriginalExtension();

    //     $image = Image::make($imageFile)->resize($width, $height)->encode('jpg');

    //     $filePath = $directory."{$fileName}";

    //     Storage::disk('public')->put($filePath, $image);

    //     // $imageUrl = Storage::url($filePath);

    //     return $filePath;




    //     // $imageName        = Str::random(10). '.' .$image->getClientOriginalExtension();

    //     // $location = public_path($directory.$imageName);

    //     // if ($type=='category') {
    //     //     // Image::make($image)->encode('jpg', 60)->fit(500,150)->save($location);
    //     //     $imageConvertFile = Image::make($image)->encode('jpg', 60)->fit(500,150);
    //     //     Storage::disk('public')->put($filePath, $imageName);
    //     //     $fileUrl = Storage::url($filePath);
    //     // }
    //     // else if ($type=='brand') {
    //     //     Image::make($image)->encode('jpg', 60)->fit(500,150)->save($location);
    //     // }
    //     // elseif ($type=='header_logo' || $type=='mail_logo') {
    //     //     Image::make($image)->encode('jpg', 60)->fit(280,62)->save($location);
    //     // }
    //     // elseif($type=='store_front_footer')
    //     // {
    //     //     Image::make($image)->encode('jpg', 60)->fit(342,30)->save($location);
    //     // }
    //     // elseif($type=='general')
    //     // {
    //     //     Image::make($image)->encode('jpg', 60)->save($location);
    //     // }
    //     // elseif($type=='topbar_logo')
    //     // {
    //     //     $filename = Str::random(10).'.'.$image->getClientOriginalExtension();
    //     //     $image->move(public_path($directory), $filename);
    //     //     return $directory.$filename;
    //     // }
    //     // elseif($type=='slider_banner')
    //     // {
    //     //     Image::make($image)->encode('jpg', 60)->fit(500,230)->save($location);
    //     // }
    //     // elseif($type=='one_column_banner')
    //     // {
    //     //     Image::make($image)->encode('jpg', 60)->fit(1200,270)->save($location);
    //     // }
    //     // elseif($type=='two_column_banners')
    //     // {
    //     //     Image::make($image)->encode('jpg', 60)->fit(870,270)->save($location);
    //     // }
    //     // elseif($type=='three_column_banners' || $type=='three_column_full_width_banners')
    //     // {
    //     //     Image::make($image)->encode('jpg', 60)->fit(570,230)->save($location);
    //     // }
    //     // elseif($type=='newslatter')
    //     // {
    //     //     $imageName      = 'newslatter'. '.' .'jpg';
    //     //     $location = public_path($directory.$imageName);
    //     //     Image::make($image)->encode('jpg', 60)->fit(850,450)->save($location);
    //     // }
    //     // elseif($type=='about_us')
    //     // {
    //     //     Image::make($image)->encode('webp', 60)->fit(1920,1240)->save($location);
    //     // }
    //     // else {
    //     //     Image::make($image)->encode('jpg', 60)->fit(300,300)->save($location);
    //     // }

    //     // $imageUrl = $directory.$imageName;
    //     // return $imageUrl;
    // }
}
