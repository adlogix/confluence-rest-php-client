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

use Adlogix\Confluence\Client\Entity\Error\ApiError;
use Adlogix\Confluence\Client\Exception\ApiException;
use Adlogix\Confluence\Client\Exception\ExceptionWrapper;
use Adlogix\Confluence\Client\Tests\TestCase;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

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
        $request = $this->getMock(RequestInterface::class);
        $request->expects($this->atLeastOnce())
            ->method('hasHeader')
            ->with($this->logicalOr('Authentication', 'Authorization'))
            ->willReturn(false);


        $response = $this->getMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(401);

        $requestException = new RequestException('Error 401', $request, $response);

        $this->assertEquals(
            new ApiException(new ApiError(401, 'Authentication Required')),
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
    public function wrap_401AndCredentialsGiven_ReturnApiException($headerValue, $exceptionMessage)
    {
        $request = $this->getMock(RequestInterface::class);
        $request->expects($this->atLeastOnce())
            ->method('hasHeader')
            ->with($this->logicalOr('Authentication', 'Authorization'))
            ->willReturn(true);

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
            new ApiException(new ApiError(401, $exceptionMessage)),
            ExceptionWrapper::wrap($requestException, $this->getSerializer())
        );

    }


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

        $expectedApiError = new ApiError(
            400,
            'Invalid Request'
        );

        $request = $this->getMock(RequestInterface::class);

        $stream = $this->getMock(StreamInterface::class);
        $stream->expects($this->once())
            ->method('getContents')
            ->willReturn($this->serialize($expectedApiError));

        $response = $this->getMock(ResponseInterface::class);

        $response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(400);

        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        /**
         * @var RequestInterface  $request
         * @var ResponseInterface $response
         *
         */
        $requestException = new ClientException('Error 400', $request, $response);

        /** @var RequestException $requestException */
        $this->assertEquals(
            new ApiException($expectedApiError),
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

        /** @var RequestException $requestException */
        $this->assertEquals(
            new ApiException(new ApiError(500, 'Error 500')),
            ExceptionWrapper::wrap($requestException, $this->getSerializer())
        );
    }
}
