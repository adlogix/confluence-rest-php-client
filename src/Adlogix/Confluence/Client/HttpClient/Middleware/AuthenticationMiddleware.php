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


use Adlogix\Confluence\Security\AuthenticationInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Class AuthenticationMiddleware
 * @package Adlogix\Confluence\HttpClient\Middleware
 * @author Cedric Michaux <cedric@adlogix.eu>
 */
class AuthenticationMiddleware
{
    /**
     * @var AuthenticationInterface
     */
    private $authentication;

    /**
     * AuthenticationMiddleware constructor.
     * @param AuthenticationInterface $authentication
     */
    public function __construct(AuthenticationInterface $authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * @param callable $handler
     * @return callable
     */
    public function __invoke(callable $handler)
    {
        return function (RequestInterface $request, array $options) use ($handler) {

            foreach ($this->authentication->getHeaders() as $key => $value) {
                $request = $request->withHeader($key, $value);
            }

            return $handler($request, $options);
        };
    }
}
