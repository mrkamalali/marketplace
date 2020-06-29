<?php


function getActiveLang()  // he made as get_languages()
{
    \App\Language::active()->selection()->get();
}

function getDefaultLang()
{
    return \Illuminate\Support\Facades\Config::get('app.locale');
}

function uploadImage($image, $folder)
{
    $image->store('/', $folder);
    $filename = $image->hashName();
    $path = 'images/' . $folder . '/' . $filename;
    return $path;

}
