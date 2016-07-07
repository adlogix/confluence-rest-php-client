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


use Adlogix\Confluence\Client\Security\Authentication\AuthenticationInterface;
use GuzzleHttp\Psr7\Uri;
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
     * @var bool
     */
    private $inHeader;

    /**
     * AuthenticationMiddleware constructor.
     *
     * @param AuthenticationInterface $authentication
     * @param string                  $appUrl
     * @param bool                    $inHeader
     */
    public function __construct(AuthenticationInterface $authentication, $appUrl, $inHeader = true)
    {
        $this->authentication = $authentication;
        $this->appUrl = $appUrl;

        $this->inHeader = (bool)$inHeader;
    }

    /**
     * @param callable $handler
     *
     * @return callable
     */
    public function __invoke(callable $handler)
    {
        return function (RequestInterface $request, array $options) use ($handler) {

            $this->authentication
                ->getToken()
                ->setAppUrl($this->appUrl)
                ->setQueryString($request->getMethod(), $request->getUri());

            foreach ($this->authentication->getHeaders() as $key => $value) {
                $request = $request->withHeader($key, $value);
            }

            foreach ($this->authentication->getQueryParameters() as $key => $value) {
                $request = $request->withUri(Uri::withQueryValue($request->getUri(), $key, $value));
            }

            return $handler($request, $options);
        };
    }
}
