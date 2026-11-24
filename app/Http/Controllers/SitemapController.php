<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Throwable;

class SitemapController extends Controller
{
    /**
     * Regenerate the sitemap by running the sitemap:generate command.
     */
    public function generate(): RedirectResponse
    {
        try {
            $exitCode = Artisan::call('sitemap:generate');
        } catch (Throwable $exception) {
            report($exception);

            return redirect()->back()
                ->with('sitemap_error', 'Sitemap update failed: ' . $exception->getMessage());
        }

        if ($exitCode !== 0) {
            return redirect()->back()
                ->with('sitemap_error', 'Sitemap update failed.');
        }

        return redirect()->back()
            ->with('sitemap_updated', 'Sitemap updated');
    }
}
