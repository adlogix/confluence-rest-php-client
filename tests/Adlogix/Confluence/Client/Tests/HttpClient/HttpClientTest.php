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

namespace Adlogix\Confluence\Client\Tests\HttpClient;


use Adlogix\Confluence\Client\HttpClient\HttpClient;
use Adlogix\Confluence\Client\Tests\TestCase;
use GuzzleHttp\ClientInterface;

class HttpClientTest extends TestCase
{

    /**
     * @test
     */
    public function get_WithValidOptions_Success()
    {

        $uri = '/some/path';
        $options = ['query' => ['test' => 123]];

        $guzzleClient = $this->getMock(ClientInterface::class);
        $guzzleClient->expects($this->once())
            ->method('request')
            ->with('GET', $uri, $options);

        /** @var ClientInterface $guzzleClient */
        $httpClient = new HttpClient([], $guzzleClient);
        $httpClient->get($uri, $options);
    }


    /**
     * @test
     */
    public function post_WithValidOptions_Success()
    {
        $uri = '/some/path';
        $options = ['query' => ['test' => 123]];
        $json = '{"some":"json"}';

        $guzzleClient = $this->getMock(ClientInterface::class);
        $guzzleClient->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                $uri,
                array_merge($options, ['body' => $json, 'headers' => ['content-type' => 'application/json']])
            );

        /** @var ClientInterface $guzzleClient */
        $httpClient = new HttpClient([], $guzzleClient);
        $httpClient->post($uri, $json, $options);
    }

    /**
     * @test
     */
    public function put_WithValidOptions_Success()
    {
        $uri = '/some/path';
        $options = ['query' => ['test' => 123]];
        $json = '{"some":"json"}';

        $guzzleClient = $this->getMock(ClientInterface::class);
        $guzzleClient->expects($this->once())
            ->method('request')
            ->with(
                'PUT',
                $uri,
                array_merge($options, ['body' => $json, 'headers' => ['content-type' => 'application/json']])
            );

        /** @var ClientInterface $guzzleClient */
        $httpClient = new HttpClient([], $guzzleClient);
        $httpClient->put($uri, $json, $options);
    }

    /**
     * @test
     */
    public function delete_WithValidOptions_Success()
    {

        $uri = '/some/path';
        $options = ['query' => ['test' => 123]];

        $guzzleClient = $this->getMock(ClientInterface::class);
        $guzzleClient->expects($this->once())
            ->method('request')
            ->with('DELETE', $uri, $options);

        /** @var ClientInterface $guzzleClient */
        $httpClient = new HttpClient([], $guzzleClient);
        $httpClient->delete($uri, $options);
    }

}
