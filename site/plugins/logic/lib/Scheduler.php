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

    /**
     * Queue.
     * @var IronMQ
     */
    protected $queue;

    /**
     * Messages.
     * @var array
     */
    protected $messages = array();

    /**
     * Constructor.
     *
     * @method __construct
     */
    public function __construct()
    {
        // Set up queue
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
     * This will be triggered by a cronjob every <x> minutes.
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
            if (($info !== false) and \fetch()->outdated($info['user'], $info['repo'])) {
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

    /**
     * Update a single repositories information.
     *
     * This will be triggered by the push queue.
     *
     * @method run
     * @return Response
     */
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


    /**************************************************************************\
    *                                  QUEUE                                   *
    \**************************************************************************/

    /**
     * Add a message to be pushed to the queue.
     *
     * @method addMessage
     * @param  string $message
     */
    protected function addMessage($message)
    {
        $this->messages[] = $message;
    }

    /**
     * Push all messages to the queue.
     *
     * @method pushMessages
     */
    protected function pushMessages()
    {
        if ($this->messagesCount() > 0) {
            $this->queue->postMessages(getenv('IRONIO_QUEUE'), $this->messages);
        }
    }

    /**
     * The number of messages to be pushed to the queue.
     *
     * @method messagesCount
     * @return integer
     */
    protected function messagesCount()
    {
        return count($this->messages);
    }

    /**************************************************************************\
    *                                REPOSITORY                                *
    \**************************************************************************/

    /**
     * Find all valid repositories.
     *
     * @method findRepositories
     * @return array
     */
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
