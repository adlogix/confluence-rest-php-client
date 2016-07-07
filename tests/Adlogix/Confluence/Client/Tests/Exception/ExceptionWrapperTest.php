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

namespace Adlogix\Confluence\Client\Tests\Exception;


use Adlogix\Confluence\Client\Exception\ApiException;
use Adlogix\Confluence\Client\Exception\ExceptionWrapper;
use Adlogix\Confluence\Client\Tests\TestCase;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ExceptionWrapperTest
 * @package Adlogix\Confluence\Client\Tests\Exception
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class ExceptionWrapperTest extends TestCase
{

    /**
     * @test
     */
    public function wrap_401AndNoCredentialsGiven_ReturnsApiException()
    {
        $uri = new Uri('/some/path');

        $request = $this->getMock(RequestInterface::class);
        $request->expects($this->atLeastOnce())
            ->method('hasHeader')
            ->with($this->logicalOr('Authentication', 'Authorization'))
            ->willReturn(false);

        $request->expects($this->once())
            ->method('getUri')
            ->willReturn($uri);


        $response = $this->getMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(401);

        $requestException = new RequestException('Error 401', $request, $response);

        $this->assertEquals(
            new ApiException('Authentication Required', 401, $requestException),
            ExceptionWrapper::wrap($requestException, $this->getSerializer())
        );
    }

    /**
     * @test
     * @dataProvider loginReasons_dataprovider
     *
     * @param string $headerValue
     * @param string $exceptionMessage
     *
     */
    public function wrap_401AndHeaderCredentialsGiven_ReturnApiException($headerValue, $exceptionMessage)
    {

        $uri = new Uri('/some/path');
        $request = $this->getMock(RequestInterface::class);

        $request->expects($this->atLeastOnce())
            ->method('hasHeader')
            ->with($this->logicalOr('Authentication', 'Authorization'))
            ->willReturn(true);

        $request->expects($this->once())
            ->method('getUri')
            ->willReturn($uri);

        $response = $this->getMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(401);

        $response->expects($this->once())
            ->method('getHeader')
            ->with('X-Seraph-LoginReason')
            ->willReturn($headerValue);

        $requestException = new RequestException('Error 401', $request, $response);

        $this->assertEquals(
            new ApiException($exceptionMessage, 401, $requestException),
            ExceptionWrapper::wrap($requestException, $this->getSerializer())
        );

    }


    /**
     * @test
     * @dataProvider loginReasons_dataprovider
     *
     * @param string $headerValue
     * @param string $exceptionMessage
     */
    public function wrap_401AndQueryParamCredentialGiven_ReturnApiException($headerValue, $exceptionMessage)
    {

        $uri = new Uri('/some/path?jwt=jwttoken');

        $request = $this->getMock(RequestInterface::class);
        $request->expects($this->atLeastOnce())
            ->method('hasHeader')
            ->with($this->logicalOr('Authentication', 'Authorization'))
            ->willReturn(false);

        $request->expects($this->once())
            ->method('getUri')
            ->willReturn($uri);

        $response = $this->getMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(401);

        $response->expects($this->once())
            ->method('getHeader')
            ->with('X-Seraph-LoginReason')
            ->willReturn($headerValue);

        $requestException = new RequestException('Error 401', $request, $response);

        $this->assertEquals(
            new ApiException($exceptionMessage, 401, $requestException),
            ExceptionWrapper::wrap($requestException, $this->getSerializer())
        );
    }

    /**
     * @return array
     */
    public function loginReasons_dataprovider()
    {
        return [
            ['AUTHENTICATED_FAILED', 'Could not be authenticated'],
            ['AUTHENTICATION_DENIED', 'Not allowed to login'],
            ['AUTHORIZATION_FAILED', 'Could not be authorised'],
            ['AUTHORISATION_FAILED', 'Could not be authorised'],
            ['OUT', 'Logged out'],
            ['', 'Invalid Credentials']
        ];
    }

    /**
     * @test
     */
    public function wrap_4xxWithErrors_ReturnsApiException()
    {

        $request = $this->getMock(RequestInterface::class);
        $response = $this->getMock(ResponseInterface::class);

        $response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(403);


        $requestException = new ClientException('Error 403', $request, $response);

        $this->assertEquals(
            new ApiException(
                'Error 403',
                403,
                $requestException
            ),
            ExceptionWrapper::wrap($requestException, $this->getSerializer())
        );

    }

    /**
     * @test
     */
    public function wrap_Non4xxException_ReturnsApiException()
    {

        $request = $this->getMock(RequestInterface::class);

        $response = $this->getMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(500);

        $requestException = new RequestException('Error 500', $request, $response);

        $this->assertEquals(
            new ApiException('Error 500', 500, $requestException),
            ExceptionWrapper::wrap($requestException, $this->getSerializer())
        );
    }

}
