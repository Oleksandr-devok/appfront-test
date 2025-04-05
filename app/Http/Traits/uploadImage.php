<?php

namespace App\Http\Traits;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait uploadImage
{
    public function uploadImage($image, $folder)
    {
        $imageNameWithoutExtension =  pathinfo( $image->getClientOriginalName(), PATHINFO_FILENAME);
        $imageNameExtension = '.' . $image->getClientOriginalExtension();
        $time = substr(time(), -3);
        $imageNameToStore =   $imageNameWithoutExtension . '-' . $time . $imageNameExtension;
        $image->storeAs($folder,  $imageNameToStore, 'public');

        return $imageNameToStore;
    }
}

