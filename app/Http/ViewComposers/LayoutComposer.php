<?php

namespace App\Http\ViewComposers;

use App\Support\GitHub;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class LayoutComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('updateAvailable', $this->isUpdateAvailable());
    }

    protected function isUpdateAvailable()
    {
        $dayInMinutes = Carbon::MINUTES_PER_HOUR * Carbon::HOURS_PER_DAY;

        return Cache::remember('updateAvailable', $dayInMinutes, function () {
            $latest = (new GitHub)->latestVersion();

            return version_compare($latest, config('app.version')) === 1;
        });
    }
}