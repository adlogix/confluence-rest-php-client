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

namespace Adlogix\Confluence\Client\HttpClient\Middleware;


use Adlogix\Confluence\Client\Security\AuthenticationInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Class AuthenticationMiddleware
 * @package Adlogix\Confluence\Client\HttpClient\Middleware
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class AuthenticationMiddleware
{
    /**
     * @var AuthenticationInterface
     */
    private $authentication;

    /**
     * @var string
     */
    private $appUrl;

    /**
     * AuthenticationMiddleware constructor.
     *
     * @param AuthenticationInterface $authentication
     * @param string                  $appUrl
     */
    public function __construct(AuthenticationInterface $authentication, $appUrl)
    {
        $this->authentication = $authentication;
        $this->appUrl = $appUrl;
    }

    /**
     * @param callable $handler
     *
     * @return callable
     */
    public function __invoke(callable $handler)
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            echo (string)$request->getUri();

            $this->authentication->getToken()
                ->setAppUrl($this->appUrl)
                ->setQueryString($request->getMethod(), $request->getUri());

            foreach ($this->authentication->getHeaders() as $key => $value) {
                $request = $request->withHeader($key, $value);
            }


            $uri = $request->getUri();
            $query = $uri->getQuery();
            if(empty($query)){
                $query = "?";
            }
            else{
                $query = $query."&";
            }

            $queryParams = [];
            foreach( $this->authentication->getQueryParameters() as $key => $value){
                $queryParams[] = $key.'='.$value;
            }
            $query = $query . implode('&', $queryParams);
            $uri = $uri->withQuery($query);
            $request = $request->withUri($uri);


            return $handler($request, $options);
        };
    }
}
