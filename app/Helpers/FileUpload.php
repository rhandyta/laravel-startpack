<?php
use Illuminate\Support\Facades\File;

function handleFileUpload($request)
{
    $uploadedFiles = [];

    if ($request->hasFile("gambar")) {
        $filepath = "/storage/images/";

        if (!File::isDirectory(public_path($filepath))) {
            File::makeDirectory(public_path($filepath), 0775, true, true);
        }

        foreach ($request->file("gambar") as $item) {
            $fileName = time() . "-" . \Str::random(7) . "." . $item->extension();
            $item->move(public_path($filepath), $fileName);

            $uploadedFiles[] = public_path($filepath) . "/" . $fileName;
        }
    }

    return $uploadedFiles;
}


function cleanupUploadedFiles($uploadedFiles)
{
    foreach ($uploadedFiles as $file) {
        if (File::exists($file)) {
            File::delete($file);
        }
    }
}