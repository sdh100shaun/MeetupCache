<?php
namespace Shaunhare\Tests\MeetupProxy;

use Mockery\Mock;
use PHPUnit\Framework\TestCase;
use ShaunHare\MeetupProxy\{
    ServiceProxy
};

/*
*  @author Shaun Hare
*/

class ServiceProxyTest extends TestCase
{
    
    /**
     * @var
     */
    private $mockedClient;
    
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
    }
    
    
    public function testIsThereAnySyntaxError()
    {
        
        $var = new ServiceProxy($this->mockedClient);
        $this->assertTrue(is_object($var));
        unset($var);
    }
    
    
}