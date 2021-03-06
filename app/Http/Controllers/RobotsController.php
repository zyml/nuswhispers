<?php

namespace NUSWhispers\Http\Controllers;

use NUSWhispers\Models\Confession;

class RobotsController extends Controller
{
    /**
     * Display a confession based on ID for search engine crawlers.
     *
     * @param int $id confession ID
     *
     * @return mixed
     */
    public function getConfession($id)
    {
        if ($this->isCrawler()) {
            $confession = Confession::approved()->findOrFail($id);

            return view('robots.confession', [
                'confession' => $confession,
            ]);
        }

        return redirect(url('/confession', $id));
    }

    /**
     * Checks if current user agent is a crawler.
     * Adapted from https://gist.github.com/Exadra37/9453909.
     *
     * @return bool
     */
    protected function isCrawler(): bool
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;
        $botTypes = 'bot|crawl|slurp|spider|facebookexternalhit';

        return ! empty($userAgent) ? preg_match("/{$botTypes}/", $userAgent) > 0 : false;
    }
}
