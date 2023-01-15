<?php

namespace App\Libraries;

use Validator;

class Utilities
{
    public static function newsValidate($data){
        $validator = Validator::make($data, [
            'author' => 'required',
            'title' => 'required',
            'image' => 'required|mimes:jpg,jpeg,bmp,png,gif|max:2000',
            'content' => 'required',
        ]);

        if ($validator->fails()) return $validator->errors();

        return false;
    }

    public static function uploadImage($image, $folder){
        $image->store($folder, 'public');
        $path = 'storage/'.$folder.'/'.$image->hashName();

        return $path;
    }
}
