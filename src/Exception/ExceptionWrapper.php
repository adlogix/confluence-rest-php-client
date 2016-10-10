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

namespace Adlogix\ConfluenceClient\Exception;


use GuzzleHttp\Exception\RequestException;
use JMS\Serializer\SerializerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ExceptionWrapper
 * @package Adlogix\ConfluenceClient\Exception
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class ExceptionWrapper
{
    const RESPONSE_AUTHENTICATED_FAILED = 'AUTHENTICATED_FAILED';
    const RESPONSE_AUTHENTICATION_DENIED = 'AUTHENTICATION_DENIED';
    const RESPONSE_AUTHORIZATION_FAILED = 'AUTHORIZATION_FAILED';
    const RESPONSE_AUTHORISATION_FAILED = 'AUTHORISATION_FAILED';
    const RESPONSE_OUT = 'OUT';
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * ExceptionWrapper constructor.
     *
     * @param SerializerInterface $serializer
     */
    private function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public static function wrap(RequestException $exception, SerializerInterface $serializer)
    {
        $wrapper = new static($serializer);
        return $wrapper->parseException($exception);
    }

    /**
     * @param RequestException $exception
     *
     * @return ApiException
     */
    private function parseException(RequestException $exception)
    {
        if ($exception->getCode() == 401) {
            return new ApiException($this->create401ErrorMessage($exception), $exception->getCode(), $exception);
        }

        return new ApiException($exception->getMessage(), $exception->getCode(), $exception);
    }

    /**
     * @param RequestException $exception
     *
     * @return string
     */
    private function create401ErrorMessage(RequestException $exception)
    {
        $request = $exception->getRequest();
        $response = $exception->getResponse();

        return $this->getExceptionMessage($request, $response);
    }

    /**
     * @param RequestInterface  $request
     * @param ResponseInterface|null $response
     *
     * @return string
     */
    private function getExceptionMessage(RequestInterface $request, $response = null)
    {
        return $this->getExceptionMessageForRequest($request) ?: $this->getExceptionMessageForResponse($response);
    }

    /**
     * @param RequestInterface $request
     *
     * @return null|string
     */
    private function getExceptionMessageForRequest(RequestInterface $request)
    {
        if (!$this->isRequestValid($request)) {
            return 'Authentication Required';
        }
        return null;
    }

    /**
     * @param RequestInterface $request
     *
     * @return bool
     */
    private function isRequestValid(RequestInterface $request)
    {
        $uri = $request->getUri();
        $queryParams = \GuzzleHttp\Psr7\parse_query($uri->getQuery());

        return $request->hasHeader('Authorization')
        || $request->hasHeader('Authentication')
        || array_key_exists('jwt', $queryParams)
        || !empty($queryParams['jwt']);
    }

    /**
     * @param ResponseInterface|null $response
     *
     * @return string
     */
    private function getExceptionMessageForResponse($response = null)
    {

        if(null === $response){
            return null;
        }

        switch ($response->getHeader('X-Seraph-LoginReason')) {
            case self::RESPONSE_AUTHENTICATED_FAILED:
                return 'Could not be authenticated';

            case self::RESPONSE_AUTHENTICATION_DENIED:
                return 'Not allowed to login';

            case self::RESPONSE_AUTHORISATION_FAILED:
                return 'Could not be authorised';

            case self::RESPONSE_OUT:
                return 'Logged out';
        }
        return 'Invalid Credentials';
    }
}
