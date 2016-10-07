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

namespace Adlogix\ConfluenceClient\Tests\Service;


use Adlogix\ConfluenceClient\Entity\Collection\SpaceCollection;
use Adlogix\ConfluenceClient\Exception\ApiException;
use Adlogix\ConfluenceClient\HttpClient\HttpClientInterface;
use Adlogix\ConfluenceClient\Service\SpaceService;
use Adlogix\ConfluenceClient\Tests\Entity\Utils\SpaceFaker;
use Adlogix\ConfluenceClient\Tests\TestCase;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;

class SpaceServiceTest extends TestCase
{

    /**
     * @test
     */
    public function findByKey_WithValidKey_Success()
    {
        $expectedSpace = SpaceFaker::create(1);

        $response = new Response(200, [], $this->serialize($expectedSpace));

        $httpClient = $this->createMock(HttpClientInterface::class);

        $httpClient->expects($this->once())
            ->method('get')
            ->with('space/' . $expectedSpace->getKey(), [])
            ->willReturn($response);

        $spaceService = new SpaceService($this->getSerializer(), $httpClient);
        $space = $spaceService->findByKey($expectedSpace->getKey());

        $this->assertEquals(
            $expectedSpace,
            $space
        );
    }

    /**
     * @test
     */
    public function all_WithNoOptions_Success()
    {
        $expectedSpaceCollection = new SpaceCollection(SpaceFaker::createMany(5));

        $response = new Response(200, [], $this->serialize($expectedSpaceCollection));

        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->expects($this->once())
            ->method('get')
            ->with('space')
            ->willReturn($response);

        $spaceService = new SpaceService($this->getSerializer(), $httpClient);
        $spaceCollection = $spaceService->all();

        $this->assertEquals($expectedSpaceCollection, $spaceCollection);
    }


    /**
     * @test
     * @expectedException Adlogix\ConfluenceClient\Exception\ApiException
     */
    public function get_CatchRequestException_Exception()
    {
        $request = $this->createMock(RequestInterface::class);
        $exception = new RequestException("message", $request);

        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->expects($this->once())
            ->method('get')
            ->willThrowException($exception);

        $spaceService = new SpaceService($this->getSerializer(), $httpClient);
        $spaceService->all();

    }

    /**
     * @test
     * @expectedException Adlogix\ConfluenceClient\Exception\ApiException
     */
    public function get_CatchClientException_Exception()
    {
        $request = $this->createMock(RequestInterface::class);
        $exception = new ClientException("message", $request);

        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->expects($this->once())
            ->method('get')
            ->willThrowException($exception);

        $spaceService = new SpaceService($this->getSerializer(), $httpClient);
        $spaceService->all();

    }
}
