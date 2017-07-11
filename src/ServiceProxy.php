<?php namespace ShaunHare\MeetupProxy;

use DMS\Service\Meetup\MeetupKeyAuthClient;

/**
*  A Meetup Service Proxy
*
*  A meetup service proxy of sorts - enables us to get the reponse from meetup
*  from the filesystem if present
*
*  @author Shaun Hare
*/
class ServiceProxy{
    
    /**
     * @var MeetupKeyAuthClient
     */
    private $client;
    
    public function __construct(MeetupKeyAuthClient $client)
    {
    
        $this->client = $client;
    }
    
   /**  @var string storagePath*/
   private $storagePath = '';
 
  
}