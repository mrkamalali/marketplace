<?php


function getActiveLang()  // he made as get_languages()
{
    return \App\Language::active()->selection()->get();
}

function getDefaultLang()
{
    return \Illuminate\Support\Facades\Config::get('app.locale');
}

function uploadImage($folder, $image)
{
    $image->store('/', $folder);
    $filename = $image->hashName();
    $path = 'images/' . $folder . '/' . $filename;
    return $path;

}



