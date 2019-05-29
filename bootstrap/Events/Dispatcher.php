<?php

namespace Bootstrap\Events;

use App\Events\ImportOracleEvent;
use App\Listeners\ImportOracleListener;

/**
 * Class Dispatcher
 * Application dispatcher bootstrapping
 *
 * @package Bootstrap\Events
 */
class Dispatcher extends \Illuminate\Events\Dispatcher
{
    /**
     * Application Events & Listeners Scheme
     *
     * @var array
     */
    protected $listen = [
        ImportOracleEvent::class => [ImportOracleListener::class],
    ];

    /**
     * Dispatcher constructor.
     */
    public function __construct($container = null)
    {
        parent::__construct();


        $this->registerApplicationEvents();
    }

    /**
     *  Events & Listeners registration
     */
    private function registerApplicationEvents(): void
    {
        foreach ($this->listens() as $event => $listeners) {
            foreach ($listeners as $listener) {
                self::listen($event, $listener);
            }
        }

    }

    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function listens()
    {
        return $this->listen;
    }
}
