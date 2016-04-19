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

namespace Adlogix\Confluence\Client\Tests\Service;


use Adlogix\Confluence\Client\Entity\Collection\SpaceCollection;
use Adlogix\Confluence\Client\Exception\ApiException;
use Adlogix\Confluence\Client\HttpClient\HttpClientInterface;
use Adlogix\Confluence\Client\Service\SpaceService;
use Adlogix\Confluence\Client\Tests\Entity\Utils\SpaceFaker;
use Adlogix\Confluence\Client\Tests\TestCase;
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

        $httpClient = $this->getMock(HttpClientInterface::class);

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

        $httpClient = $this->getMock(HttpClientInterface::class);
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
     */
    public function get_CatchRequestException_Exception()
    {
        $this->expectException(ApiException::class);

        $request = $this->getMock(RequestInterface::class);
        $exception = new RequestException("message", $request);

        $httpClient = $this->getMock(HttpClientInterface::class);
        $httpClient->expects($this->once())
            ->method('get')
            ->willThrowException($exception);

        $spaceService = new SpaceService($this->getSerializer(), $httpClient);
        $spaceService->all();

    }

    /**
     * @test
     */
    public function get_CatchClientException_Exception()
    {
        $this->expectException(ApiException::class);
        $request = $this->getMock(RequestInterface::class);
        $exception = new ClientException("message", $request);

        $httpClient = $this->getMock(HttpClientInterface::class);
        $httpClient->expects($this->once())
            ->method('get')
            ->willThrowException($exception);

        $spaceService = new SpaceService($this->getSerializer(), $httpClient);
        $spaceService->all();

    }
}
