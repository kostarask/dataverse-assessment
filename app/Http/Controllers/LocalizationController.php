<?php

namespace App\Http\Controllers;

class LocalizationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $locale)
    {
        if (!in_array($locale, array_keys(config('localization.locales')))) {
            abort(404);
        }

        session(['localization' => $locale]);

        return redirect()->back();
    }
}
