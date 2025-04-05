<?php

namespace App\Http\Traits;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait uploadImage
{
    public function uploadImage($image, $folder)
    {

        $imageNameWithoutExtension =  pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $imageNameExtension = '.' . $image->getClientOriginalExtension();
        $time = substr(time(), -3);
        $imageNameToStore =   $imageNameWithoutExtension . '-' . $time . $imageNameExtension;
        $img = Image::make($image)->fit(700)->encode();
        Storage::put($imageNameToStore, $img);
        Storage::move($imageNameToStore, "$folder/" . $imageNameToStore);

        return $imageNameToStore;
    }
}

// $img = Image::make($coverArt)->fit(500)->encode();
// Storage::put($imageName, $img);
// Storage::move($imageName, 'public/music_cover_arts/' . $imageName);
