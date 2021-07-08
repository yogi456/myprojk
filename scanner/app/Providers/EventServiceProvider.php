<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        'contact.created' => [

            'App\Events\RefreshContactSegmentEvent@contactCreated',

        ],

        'contact.updated' => [

            'App\Events\RefreshContactSegmentEvent@contactUpdated',

        ],

        'contact.deleted' => [

            'App\Events\RefreshContactSegmentEvent@contactDeleted',

        ],

        'emailPlaybook.created' => [

            'App\Events\SendPlaybookMessageEvent@emailPlaybookCreated',

        ],

        'emailPlaybook.updated' => [

            'App\Events\SendPlaybookMessageEvent@emailPlaybookUpdated',

        ],

        'emailPlaybook.deleted' => [

            'App\Events\SendPlaybookMessageEvent@emailPlaybookDeleted',

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

        //
    }
}
