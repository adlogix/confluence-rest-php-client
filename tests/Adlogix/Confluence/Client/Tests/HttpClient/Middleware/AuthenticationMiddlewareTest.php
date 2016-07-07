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

namespace Adlogix\Confluence\Client\Tests\HttpClient\Middleware;


use Adlogix\Confluence\Client\Entity\Connect\TokenInterface;
use Adlogix\Confluence\Client\HttpClient\Middleware\AuthenticationMiddleware;
use Adlogix\Confluence\Client\Security\Authentication\AuthenticationInterface;
use Adlogix\Confluence\Client\Tests\TestCase;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;

class AuthenticationMiddlewareTest extends TestCase
{

    /**
     * @var Uri
     */
    private $baseUri;

    /**
     * @var TokenInterface
     */
    private $token;

    /**
     * @var AuthenticationInterface
     */
    private $authentication;

    /**
     * @var RequestInterface
     */
    private $request;


    public function setUp()
    {
        $this->baseUri = new Uri('http://confluence.dev');

        $this->token = $this->getMock(TokenInterface::class);
        $this->token->expects($this->once())
            ->method('setAppUrl')
            ->willReturnSelf();

        $this->authentication = $this->getMock(AuthenticationInterface::class);

        $this->authentication->expects($this->once())
            ->method('getToken')
            ->willReturn($this->token);

        $this->request = $this->getMock(RequestInterface::class);
    }

    /**
     * @test
     */
    public function invoke_WithHeader_Success()
    {
        $this->authentication->expects($this->once())
            ->method('getHeaders')
            ->willReturn([
                'Authorization' => "XXXX",
                'OtherOption' => 'XXXX'
            ]);

        $this->authentication->expects($this->once())
            ->method('getQueryParameters')
            ->willReturn([]);


        $middleware = new AuthenticationMiddleware($this->authentication, '/some/path ');


        $this->request->expects($this->exactly(2))
            ->method('withHeader')
            ->withConsecutive(
                ['Authorization', "XXXX"],
                ['OtherOption', 'XXXX']
            )
            ->willReturnSelf();

        $callable = $middleware(
            function (RequestInterface $actualRequest, array $options){
                $this->assertEquals($this->request, $actualRequest);
                $this->assertEquals(['Hello World'], $options);
            }
        );

        $callable($this->request, ['Hello World']);
    }


    /**
     * @test
     */
    public function invoke_WithQueryParam_Success()
    {

        $this->authentication->expects($this->once())
            ->method('getHeaders')
            ->willReturn([]);

        $this->authentication->expects($this->once())
            ->method('getQueryParameters')
            ->willReturn([
                'jwt' => 'YYYY',
                'otherParam' => 'YYYY'
            ]);

        $this->request->expects($this->atLeast(2))
            ->method('getUri')
            ->willReturn($this->baseUri);

        $this->request->expects($this->exactly(2))
            ->method('withUri')
            ->withConsecutive(
                Uri::withQueryValue($this->baseUri, 'jwt', 'YYYY'),
                Uri::withQueryValue($this->baseUri, 'otherParam', 'YYYY')
            )
            ->willReturnSelf();

        $middleware = new AuthenticationMiddleware($this->authentication, '/some/path ');

        $callable = $middleware(
            function (RequestInterface $actualRequest, array $options){
                $this->assertEquals($this->request, $actualRequest);
                $this->assertEquals(['Hello World'], $options);
            }
        );

        $callable($this->request, ['Hello World']);
    }
}
