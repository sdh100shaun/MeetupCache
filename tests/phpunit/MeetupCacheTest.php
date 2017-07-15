<?php
namespace Shaunhare\Tests\MeetupCache;

use Mockery\Mock;
use PHPUnit\Framework\TestCase;
use ShaunHare\MeetupCache\{
    MeetupCache
};
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
     * @var
     */
    private $meetupCache;
    
    /**
     * Just check if the Class has no syntax error
     *
     * Check to make sure has no syntax error. This helps you troubleshoot
     * any typo before you even use this package in a real project.
     *
     */
    public function setUp()
    {
        $this->mockedClient = \Mockery::mock('\DMS\Service\Meetup\MeetupKeyAuthClient');
        $options = array('path' => __DIR__ . '/../testdata/');
        $driver = new FileSystem($options);
        $this->meetupCache = new MeetupCache($this->mockedClient,new Pool($driver));
    }
    
    
    public function testIsThereAnySyntaxError()
    {
        
        $var = new MeetupCache($this->mockedClient,new Pool());
        $this->assertTrue(is_object($var));
        unset($var);
    }
    
    public function testCallCreatesCachedItemOfSameName()
    {
        $this->meetupCache->getEvent();
        var_dump($this->meetupCache->getCachedItem("getEvent"));
        self::assertNotEmpty($this->meetupCache->getCachedItem("getEvent"));
    }
    
    
}