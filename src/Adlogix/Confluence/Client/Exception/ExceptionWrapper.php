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

namespace Adlogix\Confluence\Client\Exception;

use Adlogix\Confluence\Client\Entity\Error\ApiError;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use JMS\Serializer\SerializerInterface;

/**
 * Class ExceptionWrapper
 * @package Adlogix\Confluence\Client\Exception
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
            return new ApiException($this->create401Error($exception));
        }

        if ($exception instanceof ClientException) {
            return new ApiException($this->create4xxError($exception));
        }

        return new ApiException(new ApiError($exception->getCode(), $exception->getMessage()));
    }

    /**
     * @param RequestException $exception
     *
     * @return ApiError
     */
    private function create401Error(RequestException $exception)
    {
        $request = $exception->getRequest();
        $response = $exception->getResponse();


        if (!$request->hasHeader('Authorization') && !$request->hasHeader('Authentication')) {
            return new ApiError($exception->getCode(), 'Authentication Required');
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

        return new ApiError($exception->getCode(), $msg);
    }


    /**
     * @param RequestException $exception
     *
     * @return ApiError
     */
    private function create4xxError(RequestException $exception)
    {
        $response = $exception->getResponse();

        return $this->serializer->deserialize(
            $response->getBody()
                ->getContents(),
            ApiError::class,
            'json'
        );
    }
}
