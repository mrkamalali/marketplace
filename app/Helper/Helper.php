<?php



function getActiveLang()
{
    \App\Language::active()->selection()->get();
}

function getDefaultLang()
{
    return \Illuminate\Support\Facades\Config::get('app.locale');
}
