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

namespace Adlogix\ConfluenceClient\Service;


use Adlogix\ConfluenceClient\Exception\ExceptionWrapper;
use Adlogix\ConfluenceClient\HttpClient\HttpClientInterface;
use GuzzleHttp\Exception\RequestException;
use JMS\Serializer\SerializerInterface;

/**
 * Class AbstractApiService
 * @package Adlogix\ConfluenceClient\Service
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class AbstractApiService extends AbstractService
{
    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * AbstractService constructor.
     *
     * @param SerializerInterface $serializer
     * @param HttpClientInterface $httpClient
     */
    public function __construct(SerializerInterface $serializer, HttpClientInterface $httpClient)
    {
        parent::__construct($serializer);
        $this->httpClient = $httpClient;
    }
    
    protected function get($uri, array $options = [])
    {
        try {
            $response = $this->httpClient
                ->get($uri, $options);

            return $response->getBody()
                ->getContents();

        } catch (RequestException $exception) {
            throw ExceptionWrapper::wrap($exception, $this->serializer);
        }
    }

    /**
     * @param array $oldQueryOptions
     * @param array $newQueryOptions
     *
     * @return mixed
     */
    protected function mergeQueryOptions(array $oldQueryOptions, array $newQueryOptions){
        return array_merge_recursive(
            $oldQueryOptions,
            $newQueryOptions
        );
    }
}
