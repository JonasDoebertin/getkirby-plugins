<?php

namespace jdpowered\GetKirbyPlugins\Logic;

use IronMQ\IronMQ;
use jdpowered\GetKirbyPlugins\Logic\Helper;
use jdpowered\GetKirbyPlugins\Logic\Structures\Message;
use R;
use Response;

class Scheduler
{
    /**
     * The *singleton* instance of this class.
     * @var Fetcher
     */
    protected static $instance;

    protected $queue;

    protected $messages = array();

    public function __construct()
    {
        $this->queue = new IronMQ([
            'token'      => getenv('IRONIO_TOKEN'),
            'project_id' => getenv('IRONIO_PROJECT'),
        ]);
    }

    /**************************************************************************\
    *                            SINGLETON PATTERN                             *
    \**************************************************************************/

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Singleton The *Singleton* instance.
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone() {}

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup() {}

    /**************************************************************************\
    *                                PUBLIC API                                *
    \**************************************************************************/

    /**
     * Trigger a complete update of all plugins releases and infos.
     *
     * @method trigger
     * @return Response
     */
    public function trigger()
    {
        // Security check
        $token = get('token');
        if ($token !== getenv('SCHEDULER_CRON_TOKEN')) {
            return Response::error(
                'Security check failed.',
                403,
                []
            );
        }

        // Find all valid repository urls
        $repositories = $this->findRepositories();

        // Iterate over all repositories, extract user and repo info
        // and push it to the queue
        foreach ($repositories as $repository) {
            $info = Helper::extract($repository);
            if ($info !== false) {
                $this->addMessage(new Message(
                    $info['user'],
                    $info['repo']
                ));
            }
        }

        // Push all queued messages
        $this->pushMessages();

        return Response::success(
            sprintf('Triggered %d messages.', $this->messagesCount()),
            [],
            200
        );
    }

    public function run()
    {
        // Security check
        $token = get('token');
        if ($token !== getenv('SCHEDULER_QUEUE_TOKEN')) {
            return Response::error('Security check failed.', 403, []);
        }

        // Validate request structure
        $info = json_decode(R::body());
        if (is_null($info) or !isset($info->user) or !isset($info->repo))
        {
            return Response::error('Invalid request body.', 400, []);
        }

        // Delegate preloading to fetcher
        \fetch()->preload($info->user, $info->repo);

        return Response::success(
            sprintf('Updated [%s/%s].', $info->user, $info->repo),
            [],
            200
        );
    }




    protected function addMessage($message)
    {
        $this->messages[] = $message;
    }

    protected function pushMessages()
    {
        $this->queue->postMessages(getenv('IRONIO_QUEUE'), $this->messages);
    }

    protected function messagesCount()
    {
        return count($this->messages);
    }

    protected function findRepositories()
    {
        // Find all plugin pages containing a repository url
        $pages = page('plugins')->children()->filterBy('draft', 'false')->sortBy('uid', 'asc')->filterBy('repository', '!=', '');

        // Filter out invalid repository urls
        $repositories = array();
        foreach ($pages as $plugin) {
            if (Helper::isValidRepository($plugin->repository())) {
                $repositories[] = $plugin->repository();
            }
        }

        return $repositories;
    }


}
