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

namespace Adlogix\Confluence\Client\Security;

/**
 * Class BasicAuthentication
 * @package Adlogix\Confluence\Client\Security
 * @author Cedric Michaux <cedric@adlogix.eu>
 */
class BasicAuthentication implements AuthenticationInterface
{
    /**
     * @var array
     */
    private $headers;


    /**
     * BasicAuthentication constructor.
     * @param string $username
     * @param string $password
     */
    public function __construct($username, $password)
    {

        if (empty($username)) {
            throw new \InvalidArgumentException("The username cannot be empty");
        }

        if (empty($password)) {
            throw new \InvalidArgumentException("The password cannot be empty");
        }

        $this->headers = [
            'Authorization' => sprintf('Basic %s', base64_encode($username . ':' . $password))
        ];

    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
