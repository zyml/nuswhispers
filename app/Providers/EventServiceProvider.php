<?php

namespace NUSWhispers\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \NUSWhispers\Events\ConfessionWasCreated::class => [
            \NUSWhispers\Listeners\SyncConfessionTags::class,
        ],
        \NUSWhispers\Events\ConfessionWasUpdated::class => [
            \NUSWhispers\Listeners\SyncConfessionTags::class,
        ],
        \NUSWhispers\Events\ConfessionWasDeleted::class => [
            \NUSWhispers\Listeners\DeleteConfessionFromFacebook::class,
        ],
        \NUSWhispers\Events\ConfessionStatusWasChanged::class => [
            \NUSWhispers\Listeners\FlushConfessionQueue::class,
            \NUSWhispers\Listeners\LogConfessionStatusChange::class,
        ],
        \NUSWhispers\Events\ConfessionWasApproved::class => [
            \NUSWhispers\Listeners\PostConfessionToFacebook::class,
        ],
        \NUSWhispers\Events\ConfessionWasFeatured::class => [
            \NUSWhispers\Listeners\PostConfessionToFacebook::class,
        ],
        \NUSWhispers\Events\ConfessionWasRejected::class => [
            \NUSWhispers\Listeners\DeleteConfessionFromFacebook::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
