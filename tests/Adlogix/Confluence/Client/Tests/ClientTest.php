<?php
/*
 * This file is part of the Adlogix package.
 *
 * (c) Allan Segebarth <allan@adlogix.eu>
 * (c) Jean-Jacques Courtens <jjc@adlogix.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Adlogix\Confluence\Client\Tests;

use Adlogix\Confluence\Client\Client;
use Adlogix\Confluence\Client\HttpClient\HttpClientInterface;
use Adlogix\Confluence\Client\Security\Authentication\AuthenticationInterface;
use Adlogix\Confluence\Client\Service\AuthenticationService;
use Adlogix\Confluence\Client\Service\ContentService;
use Adlogix\Confluence\Client\Service\DescriptorService;
use Adlogix\Confluence\Client\Service\SpaceService;
use JMS\Serializer\SerializerInterface;

/**
 * Class ClientTest
 * @package Adlogix\Confluence\Client\Tests
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class ClientTest extends TestCase
{

    /**
     * @test
     * @dataProvider service_dataprovider
     *
     * @param string $serviceName
     * @param string $expectedClassName
     */
    public function service_WIthValidName_ReturnsServiceInstance($serviceName, $expectedClassName)
    {
        $serializer = $this->getMock(SerializerInterface::class);

        $httpClient = $this->getMock(HttpClientInterface::class);
        $authentication = $this->getMock(AuthenticationInterface::class);

        $client = new Client($httpClient, $serializer, $authentication);

        $service = $client->service($serviceName);

        $this->assertEquals($expectedClassName, get_class($service));
    }


    /**
     * @test
     * @dataProvider service_dataprovider
     *
     * @param string $serviceName
     * @param string $expectedClassName
     */
    public function service_ThroughMagicMethodWithValidName_ReturnsServiceInstance($serviceName, $expectedClassName)
    {
        $serializer = $this->getMock(SerializerInterface::class);
        $httpClient = $this->getMock(HttpClientInterface::class);
        $authentication = $this->getMock(AuthenticationInterface::class);

        $client = new Client($httpClient, $serializer, $authentication);

        $service = $client->$serviceName();

        $this->assertEquals($expectedClassName, get_class($service));
    }
    
    /**
     * @return array
     */
    public function service_dataprovider()
    {
        return [
            ['content', ContentService::class],
            ['contents', ContentService::class],
            ['space', SpaceService::class],
            ['spaces', SpaceService::class],
            ['descriptor', DescriptorService::class],
            ['descriptors', DescriptorService::class],
            ['authentication', AuthenticationService::class],
            ['authentications', AuthenticationService::class],

        ];
    }

}
