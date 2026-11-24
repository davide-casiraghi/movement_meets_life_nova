<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;
use Throwable;

class SitemapController extends Controller
{
    /**
     * Show the URLs of the current sitemap as a tree.
     */
    public function show(): View
    {
        $path = public_path('sitemap.xml');
        $tree = ['children' => [], 'url' => null];
        $total = 0;
        $updatedAt = null;

        if (is_file($path)) {
            $updatedAt = Carbon::createFromTimestamp(filemtime($path));

            libxml_use_internal_errors(true);
            $xml = simplexml_load_file($path);
            libxml_clear_errors();

            if ($xml !== false) {
                foreach ($xml->url as $url) {
                    $location = (string) $url->loc;
                    $total++;

                    $urlPath = trim((string) parse_url($location, PHP_URL_PATH), '/');
                    $segments = $urlPath === '' ? [] : explode('/', $urlPath);

                    $node = &$tree;
                    foreach ($segments as $segment) {
                        if (!isset($node['children'][$segment])) {
                            $node['children'][$segment] = ['children' => [], 'url' => null];
                        }
                        $node = &$node['children'][$segment];
                    }
                    $node['url'] = $location;
                    unset($node);
                }

                $this->sortTree($tree);
            }
        }

        return view('sitemap.show', [
            'tree' => $tree,
            'total' => $total,
            'updatedAt' => $updatedAt,
        ]);
    }

    /**
     * Sort the tree alphabetically at every level.
     */
    private function sortTree(array &$node): void
    {
        ksort($node['children']);

        foreach ($node['children'] as &$child) {
            $this->sortTree($child);
        }
    }

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
