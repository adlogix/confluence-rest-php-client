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


use Adlogix\ConfluenceClient\Entity\Collection\ContentCollection;
use Adlogix\ConfluenceClient\Exception\ApiException;
use Adlogix\ConfluenceClient\HttpClient\HttpClientInterface;
use Adlogix\ConfluenceClient\Service\ContentService;
use Adlogix\ConfluenceClient\Tests\Entity\Utils\ContentFaker;
use Adlogix\ConfluenceClient\Tests\TestCase;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;

class ContentServiceTest extends TestCase
{

    /**
     * @tests
     */
    public function findById_WithValidId_Success()
    {
        $expectedContent = ContentFaker::create(1);

        $response = new Response(200, [], $this->serialize($expectedContent));

        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->expects($this->once())
            ->method('get')
            ->with('content/' . $expectedContent->getId(), [])
            ->willReturn($response);

        $contentService = new ContentService($this->getSerializer(), $httpClient);
        $content = $contentService->findById($expectedContent->getId());

        $this->assertEquals(
            $expectedContent,
            $content
        );
    }

    /**
     * @test
     */
    public function all_WithNoOptions_Success()
    {
        $expectedContentCollection = new ContentCollection(ContentFaker::createMany(5));

        $response = new Response(200, [], $this->serialize($expectedContentCollection));

        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->expects($this->once())
            ->method('get')
            ->with('content', [])
            ->willReturn($response);

        $contentService = new ContentService($this->getSerializer(), $httpClient);
        $contentCollection = $contentService->all();

        $this->assertEquals($expectedContentCollection, $contentCollection);
    }


    /**
     * @test
     */
    public function all_WithSpaceKey_Success()
    {
        $expectedContentCollection = new ContentCollection(ContentFaker::createMany(5));

        $response = new Response(200, [], $this->serialize($expectedContentCollection));

        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->expects($this->once())
            ->method('get')
            ->with('content', ['query' => ['spaceKey' => 'testSpace']])
            ->willReturn($response);

        $contentService = new ContentService($this->getSerializer(), $httpClient);
        $contentCollection = $contentService->all('testSpace');

        $this->assertEquals($expectedContentCollection, $contentCollection);
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

        $contentService = new ContentService($this->getSerializer(), $httpClient);
        $contentService->all();

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

        $contentService = new ContentService($this->getSerializer(), $httpClient);
        $contentService->all();

    }
}
