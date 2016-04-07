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

use Adlogix\Confluence\Client\Entity\Connect\Descriptor;
use Adlogix\Confluence\Client\Entity\Connect\TokenInterface;

/**
 * Interface AuthenticationInterface
 * @package Adlogix\Confluence\Client\Security\Connect
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
interface ConnectAuthenticationInterface
{

    /**
     * @return string
     */
    public function getType();


    /**
     * @return array
     */
    public function getHeaders();


    /**
     * @return array
     */
    public function getQueryParameters();

    /**
     * @return TokenInterface
     */
    public function getToken();
}
