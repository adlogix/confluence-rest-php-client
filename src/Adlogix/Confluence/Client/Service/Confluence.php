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

namespace Adlogix\Confluence\Client\Service;

use Adlogix\Confluence\Client\Wrapper\ConfluenceWrapper;

/**
 * Class Confluence
 * @package Adlogix\Confluence\Client\Service
 * @author Cedric Michaux <cedric@adlogix.eu>
 */
class Confluence
{

    /**
     * @var ConfluenceWrapper
     */
    private $wrapperInstance;

    public function __construct($url)
    {
        $this->wrapperInstance = new ConfluenceWrapper($url);
    }

    public function getSpaces()
    {
        $spaces = $this->wrapperInstance->getSpaces();

        return $spaces;
    }

    /**
     * @param        $requestUri
     * @param string $method
     * @param array $headers
     * @param null $body
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendRequest(
        $requestUri,
        $method = 'GET',
        array $headers = [],
        $body = null
    ) {
        return $this->wrapperInstance->sendRequest($requestUri, $method, $headers, $body);
    }

}
