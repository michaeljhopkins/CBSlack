<?php namespace Drapor\Networking\Laravel\ServiceProviders;
/**
 * Created by PhpStorm.
 * User: michaelkantor
 * Date: 1/12/15
 * Time: 3:30 AM
 */

use Illuminate\Events\Dispatcher;

class EventHandlers {

    /**
     * @param $events Dispatcher
     */
    public function subscribe($events)
    {

        $events->listen('networking.response.created', 'Drapor\Networking\Laravel\Handlers\ResponseCreatedHandler@handle');
    }
} 