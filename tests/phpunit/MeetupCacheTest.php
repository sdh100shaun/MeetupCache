<?php
namespace Shaunhare\Tests\MeetupCache;

use DMS\Service\Meetup\Response\SingleResultResponse;
use Mockery;
use PHPUnit\Framework\TestCase;
use ShaunHare\MeetupCache\MeetupCache;
use Stash\Driver\FileSystem;
use Stash\Pool;

/*
*  @author Shaun Hare
*/

class MeetupCacheTest extends TestCase
{
    
    /**
     * @var
     */
    private $mockedClient;
    
    /**
     * @var MeetupCache
     */
    private $meetupCache;
    
    /**
     * @var FileSystem
     */
    private $driver;
    
    /**
     * Just check if the Class has no syntax error
     *
     * Check to make sure has no syntax error. This helps you troubleshoot
     * any typo before you even use this package in a real project.
     *
     */
    public function setUp():void 
    {
        $this->mockedClient = Mockery::mock('\DMS\Service\Meetup\MeetupKeyAuthClient');
        $options = array('path' => __DIR__ . '/testdata/');
        $this->driver = new FileSystem($options);
        $this->meetupCache = new MeetupCache($this->mockedClient, new Pool($this->driver));
    }
    
    
    public function testIsThereAnySyntaxError()
    {
        
        $var = new MeetupCache($this->mockedClient, new Pool());
        $this->assertTrue(is_object($var));
        unset($var);
    }
    
    public function testCallCreatesCachedItemOfSameName()
    {
        //ensure cache cleared
        $this->driver->clear('getEvent');
    
        $this->meetupCache = new MeetupCache($this->mockedClient, new Pool($this->driver));
        
        $this->mockedClient->shouldReceive('getEvent')
            ->once()
            ->andReturn(new SingleResultResponse(200, [], "{}"));
        
        $this->meetupCache->getEvent();
        
        self::assertNotEmpty($this->meetupCache->getCachedItem("getEvent")->getData());
    }
    
    public function testIsCacheHit()
    {
        $this->meetupCache->getEvent();
        self::assertTrue($this->meetupCache->isHit());
    }
    
    public function testExpireCache()
    {
        $this->meetupCache->getEvent();
        
        $this->meetupCache->expireCache();
        
        $actual = $this->meetupCache->getCachedItem("getEvent");
    
        self::assertNull($actual);
    }
    
    public function tearDown()
    {
        Mockery::close();
    }
}
