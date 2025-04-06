<?php

namespace App\Http\Traits;

trait uploadImage
{
    public function uploadImage($image, $folder)
    {
        $imageNameWithoutExtension = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $imageNameExtension = '.'.$image->getClientOriginalExtension();
        $time = substr(time(), -3);
        $imageNameToStore = $imageNameWithoutExtension.'-'.$time.$imageNameExtension;
        $image->storeAs($folder, $imageNameToStore, 'public');

        return $imageNameToStore;
    }
}
