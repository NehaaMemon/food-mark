<?php

namespace App\Traits;

use Illuminate\Http\Request;
use File;

trait fileuploadtriat
{

    function uploadImage(Request $request, $inputName, $oldPath = Null, $path = "/uploads")
    {
        if ($request->hasFile($inputName)) {
            $image = $request->{$inputName};
            $ext = $image->getClientOriginalExtension();
            $imageName = 'media_' . uniqid() . '.' . $ext;

            $image->move(public_path($path), $imageName);

            if ($oldPath && File::exists(public_path($oldPath))) {
                File::delete(public_path($oldPath));
            }
            return $path . '/' . $imageName;
        }
        return null;
    }
    function removeImage(string $path): void
    {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
