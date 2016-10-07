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

/**
 * Class ExceptionWrapper
 * @package Adlogix\ConfluenceClient\Exception
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class ExceptionWrapper
{
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

        $uri = $request->getUri();
        $queryParams = \GuzzleHttp\Psr7\parse_query($uri->getQuery());

        if (
            !$request->hasHeader('Authorization')
            && !$request->hasHeader('Authentication')
            && !array_key_exists('jwt', $queryParams)
            && empty($queryParams['jwt'])
        ) {
            return 'Authentication Required';
        }

        switch ($response->getHeader('X-Seraph-LoginReason')) {
            case 'AUTHENTICATED_FAILED':
                $msg = 'Could not be authenticated';
                break;

            case 'AUTHENTICATION_DENIED':
                $msg = 'Not allowed to login';
                break;

            case 'AUTHORIZATION_FAILED':
            case 'AUTHORISATION_FAILED':
                $msg = 'Could not be authorised';
                break;

            case 'OUT':
                $msg = 'Logged out';
                break;
            default:
                $msg = 'Invalid Credentials';
                break;
        }

        return $msg;
    }
}
