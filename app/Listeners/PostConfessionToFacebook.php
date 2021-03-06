<?php

namespace NUSWhispers\Listeners;

use Facebook\Facebook;
use Illuminate\Contracts\Queue\ShouldQueue;
use NUSWhispers\Events\BaseConfessionEvent;
use NUSWhispers\Models\Confession;

class PostConfessionToFacebook implements ShouldQueue
{
    use ResolvesFacebookPageToken;

    /** @var \Facebook\Facebook */
    protected $fb;

    /**
     * Constructs an instance of the event listener.
     *
     * @param \Facebook\Facebook $fb
     */
    public function __construct(Facebook $fb)
    {
        $this->fb = $fb;
    }

    /**
     * Handle the event.
     *
     * @param \NUSWhispers\Events\BaseConfessionEvent $event
     *
     * @return mixed
     *
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function handle(BaseConfessionEvent $event)
    {
        if (config('app.manual_mode')) {
            return true;
        }

        $confession = $event->confession;

        // Someone might have changed his/her mind...
        if (! in_array($confession->status, ['Approved', 'Featured'], true)) {
            return true;
        }

        $confession->fb_post_id = ! empty($confession->images) ?
            $this->createOrUpdatePhoto($confession, $event->user) :
            $this->createOrUpdateStatus($confession, $event->user);

        $confession->save();
    }

    /**
     * Create or update a Facebook photo post.
     *
     * @param \NUSWhispers\Models\Confession $confession
     * @param mixed $user
     *
     * @return string
     *
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    protected function createOrUpdatePhoto(Confession $confession, $user)
    {
        $fbPostId = $confession->getAttribute('fb_post_id');

        $endpoint = $fbPostId ?
            '/' . $fbPostId :
            '/' . config('services.facebook.page_id') . '/photos';

        $response = $this->fb->post(
            $endpoint,
            [
                'message' => $confession->getFacebookMessage(),
                'url' => $confession->images,
            ],
            $this->resolvePageToken($user)
        )->getGraphNode();

        return $fbPostId ?: $response['id'];
    }

    /**
     * Create or update a Facebook status update.
     *
     * @param \NUSWhispers\Models\Confession $confession
     * @param mixed $user
     *
     * @return string
     *
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    protected function createOrUpdateStatus(Confession $confession, $user)
    {
        $fbPostId = $confession->getAttribute('fb_post_id');

        $endpoint = $fbPostId ?
            '/' . config('services.facebook.page_id') . '_' . $fbPostId :
            '/' . config('services.facebook.page_id') . '/feed';

        $response = $this->fb->post(
            $endpoint,
            [
                'message' => $confession->getFacebookMessage(),
            ],
            $this->resolvePageToken($user)
        )->getGraphNode();

        return $fbPostId ?: last(explode('_', $response['id']));
    }
}
