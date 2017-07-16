<?php

use Behat\Behat\Context\Context;
use ShaunHare\MeetupCache\MeetupCache;
use Stash\Driver\FileSystem;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private $meetupCache;
    private $event;
    private $response;
    
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     *  "apiKey" => "403d1e347352741c50544b613c537872",
    "baseUrl" => "https://api.meetup.com/2",
    "publish_status" => 'draft', // always draft for Development
    "PHPMinds" =>  ["group_urlname" => "PHPMiNDS-in-Nottingham"]
 
     */
    public function __construct()
    {
        $client = \DMS\Service\Meetup\MeetupKeyAuthClient::factory(
            [
                'key' => '403d1e347352741c50544b613c537872',
                'base_url' => 'https://api.meetup.com/2',
                'group_urlname' => 'PHPMiNDS-in-Nottingham',
                'publish_status' => 'draft'
            ]
        );
        $options = array('path' => __DIR__ . '/testdata/');
        $driver = new FileSystem($options);
        $this->meetupCache = new MeetupCache($client, new \Stash\Pool($driver));
        
    }
    
    /**
     * @Given I pass an id and url
     */
    public function iPassAnIdAndUrl()
    {
        $this->event = ['id'=>'241741815','group_urlname' => 'PHPMiNDS-in-Nottingham'];
    }
    
    /**
     * @When I call the meetup api
     */
    public function iCallTheMeetupApi()
    {
        //$this->meetupCache->expireCache();
        $this->response =$this->meetupCache->getEvent(['id'=>'241741815','group_urlname' => 'PHPMiNDS-in-Nottingham']);
    
    }
    
    
    /**
     * @Then I should get an response
     */
    public function iShouldGetAnResponse()
    {
        
        return $this->response->getData();
    }
    
    
}
