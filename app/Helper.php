<?php

function storeFile($file, $path = "storage")
{
    $file = $file;
    $filename = rand() . '.' . $file->getClientOriginalExtension();
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    $file->move(public_path($path), $filename);
    return $filename;
}
function requiredField()
{
    return " <span class='text-danger'>*</span>";
}
