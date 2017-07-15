<?php namespace ShaunHare\MeetupCache;

use DMS\Service\Meetup\MeetupKeyAuthClient;

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
     * @var MeetupKeyAuthClient
     */
    private $client;
    
    
    /**
     * @var Pool
     */
    private $cache;
    
    /**
     * ServiceProxy constructor.
     *
     * @param MeetupKeyAuthClient $client
     * @param Pool                $cache
     */
    public function __construct(MeetupKeyAuthClient $client, Pool $cache)
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
    
    public function __call($name, $arguments)
    {
        $response = $this->client->$name($arguments);
        $item = $this->cache->getItem($name);
        $this->cache->save($item->set($response));

        
        
    }
}
