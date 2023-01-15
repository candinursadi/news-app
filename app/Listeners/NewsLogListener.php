<?php

namespace App\Listeners;

use App\Events\NewsLogEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\NewsListLog;

class NewsLogListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NewsLogEvent  $event
     * @return void
     */
    public function handle(NewsLogEvent $event)
    {
        $log = new NewsListLog;
        $log->news_list_id  = $event->data->id;
        $log->action        = $event->action;
        $log->author        = $event->data->author;
        $log->title         = $event->data->title;
        $log->image         = $event->data->image;
        $log->content       = $event->data->content;
        $log->posted_by     = $event->data->posted_by;
        $log->save();
    }
}
