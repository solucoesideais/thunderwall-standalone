<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class RootComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $processUser = posix_getpwuid(posix_geteuid());

        $view->with('root', $processUser['name']);
    }
}