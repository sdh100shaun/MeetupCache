<?php namespace ShaunHare\MeetupCache;

use DMS\Service\Meetup\MeetupOAuthClient;

use DMS\Service\Meetup\Response\SingleResultResponse;
use Stash\Pool;

/**
 *  A Meetup Service cache
 *
 *  A meetup service cache of sorts - enables us to get the response from meetup
 *  or from the filesystem if present
 *
 * @author Shaun Hare
 */
class MeetupCache
{
    
    /**
     * @var MeetupOAuthClient
     */
    private $client;
    
    /**
     * @var Pool
     */
    private $cache;
    
    /**
     * @var bool
     */
    private $fromCache;
    
    /**
     * ServiceProxy constructor.
     *
     * @param MeetupOAuthClient $client
     * @param Pool                $cache
     */
    public function __construct(MeetupOAuthClient $client, Pool $cache)
    {
        $this->client = $client;
        $this->cache = $cache;
    }
    
    /**
     * @return Pool
     */
    public function getCachedItem($name)
    {
        return $this->cache->getItem($name)->get();
    }
    
    /**
     * @return bool
     */
    public function isHit():bool
    {
        return $this->fromCache;
    }

    /**
     * @param $name
     * @param $arguments
     * @return SingleResultResponse
     */
    public function __call($name, $arguments)
    {
        $item = $this->cache->getItem($name);
        $meetupResponse = $item->get();

        $this->fromCache = true;
        if ($item->isMiss()) {
            $this->fromCache = false;
            $meetupResponse = $this->client->$name($arguments);
            $this->cache->save($item->set($meetupResponse));
        }
        return $meetupResponse;
    }
    
    /**
     *
     */
    public function expireCache() :bool
    {
        return $this->cache->clear();
    }
}
