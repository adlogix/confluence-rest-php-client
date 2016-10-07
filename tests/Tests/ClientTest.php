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

namespace Adlogix\ConfluenceClient\Tests;

use Adlogix\ConfluenceClient\Client;
use Adlogix\ConfluenceClient\HttpClient\HttpClientInterface;
use Adlogix\ConfluenceClient\Service\ContentService;
use Adlogix\ConfluenceClient\Service\SpaceService;
use Adlogix\GuzzleAtlassianConnect\Security\AuthenticationInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use JMS\Serializer\SerializerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;


/**
 * Class ClientTest
 * @package Adlogix\ConfluenceClient\Tests
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class ClientTest extends TestCase
{

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function service_WithInvalidName_Exception()
    {
        $serializer = $this->createMock(SerializerInterface::class);

        $httpClient = $this->createMock(HttpClientInterface::class);
        $authentication = $this->createMock(AuthenticationInterface::class);

        $client = new Client($httpClient, $serializer, $authentication);

        $client->service("nonExistingService");
    }

    /**
     * @test
     * @dataProvider service_dataprovider
     *
     * @param string $serviceName
     * @param string $expectedClassName
     */
    public function service_WithValidName_ReturnsServiceInstance($serviceName, $expectedClassName)
    {
        $serializer = $this->createMock(SerializerInterface::class);

        $httpClient = $this->createMock(HttpClientInterface::class);
        $authentication = $this->createMock(AuthenticationInterface::class);

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
        $serializer = $this->createMock(SerializerInterface::class);
        $httpClient = $this->createMock(HttpClientInterface::class);
        $authentication = $this->createMock(AuthenticationInterface::class);

        $client = new Client($httpClient, $serializer, $authentication);

        $service = $client->$serviceName();

        $this->assertEquals($expectedClassName, get_class($service));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function service_ThroughMagicMethodWithInvalidName_Exception()
    {
        $serializer = $this->createMock(SerializerInterface::class);
        $httpClient = $this->createMock(HttpClientInterface::class);
        $authentication = $this->createMock(AuthenticationInterface::class);

        $client = new Client($httpClient, $serializer, $authentication);

        $client->nonExistingService();
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
            ['spaces', SpaceService::class]
        ];
    }


    /**
     * @test
     */
    public function rawRequest_WithCorrectParameters_Success()
    {

        $serializer = $this->createMock(SerializerInterface::class);
        $httpClient = $this->createMock(HttpClientInterface::class);
        $authentication = $this->createMock(AuthenticationInterface::class);

        $response = $this->createMock(ResponseInterface::class);

        $httpClient->expects($this->once())
            ->method("request")
            ->willReturn($response);

        $client = new Client($httpClient, $serializer, $authentication);

        $client->sendRawRequest('get', "some/path");
    }

    /**
     * @test
     *  @expectedException Adlogix\ConfluenceClient\Exception\ApiException
     */
    public function rawRequest_CatchRequestException_Exception()
    {
        $serializer = $this->createMock(SerializerInterface::class);
        $httpClient = $this->createMock(HttpClientInterface::class);
        $authentication = $this->createMock(AuthenticationInterface::class);

        $request = $this->createMock(RequestInterface::class);
        $exception = new RequestException("message", $request);

        $httpClient->expects($this->once())
            ->method("request")
            ->willThrowException($exception);

        $client = new Client($httpClient, $serializer, $authentication);

        $client->sendRawRequest('get', "some/path");
    }

    /**
     * @test
     * @expectedException Adlogix\ConfluenceClient\Exception\ApiException
     */
    public function rawRequest_CatchClientException_Exception()
    {
        $serializer = $this->createMock(SerializerInterface::class);
        $httpClient = $this->createMock(HttpClientInterface::class);
        $authentication = $this->createMock(AuthenticationInterface::class);

        $request = $this->createMock(RequestInterface::class);
        $exception = new ClientException("message", $request);

        $httpClient->expects($this->once())
            ->method("request")
            ->willThrowException($exception);

        $client = new Client($httpClient, $serializer, $authentication);

        $client->sendRawRequest('get', "some/path");
    }

}
