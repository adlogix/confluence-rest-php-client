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


use Adlogix\Confluence\Client\Entity\Collection\ContentCollection;
use Adlogix\Confluence\Client\Entity\Utils\ContentFaker;
use Adlogix\Confluence\Client\HttpClient\HttpClientInterface;
use Adlogix\Confluence\Client\Service\ContentService;
use Adlogix\Confluence\Client\Tests\TestCase;
use GuzzleHttp\Psr7\Response;

class ContentServiceTest extends TestCase
{

    /**
     * @tests
     */
    public function findById_WithValidId_Success()
    {
        $expectedContent = ContentFaker::create(1);

        $response = new Response(200, [], $this->serialize($expectedContent));
        
        $httpClient = $this->getMock(HttpClientInterface::class);
        $httpClient->expects($this->once())
            ->method('get')
            ->with('content/'.$expectedContent->getId(), [])
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

        $httpClient = $this->getMock(HttpClientInterface::class);
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

        $httpClient = $this->getMock(HttpClientInterface::class);
        $httpClient->expects($this->once())
            ->method('get')
            ->with('content', ['query' => ['spaceKey' => 'testSpace']])
            ->willReturn($response);

        $contentService = new ContentService($this->getSerializer(), $httpClient);
        $contentCollection = $contentService->all('testSpace');

        $this->assertEquals($expectedContentCollection, $contentCollection);
    }


}
