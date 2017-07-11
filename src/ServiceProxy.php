<?php namespace ShaunHare\MeetupProxy;

use DMS\Service\Meetup\MeetupKeyAuthClient;
use DMS\Service\Meetup\Response\SingleResultResponse;

/**
*  A Meetup Service Proxy
*
*  A meetup service proxy of sorts - enables us to get the response from meetup
*  or from the filesystem if present
*
*  @author Shaun Hare
*/
class ServiceProxy{
    
    /**
     * @var MeetupKeyAuthClient
     */
    private $client;
    
    /**  @var string storagePath*/
    private $storagePath = '';
    
    /**
     * ServiceProxy constructor.
     * @param MeetupKeyAuthClient $client
     */
    public function __construct(MeetupKeyAuthClient $client)
    {
        $this->client = $client;
    }
    
    public function __call($name, $arguments)
    {
       
    }
    
    
    
}