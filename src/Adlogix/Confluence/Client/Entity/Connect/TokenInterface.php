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

namespace Adlogix\Confluence\Client\Entity\Connect;

/**
 * Interface TokenInterface
 * @package Adlogix\Confluence\Client\Entity\Connect
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
interface TokenInterface
{

    /**
     * @param string $method
     * @param string $url
     *
     * @return TokenInterface
     */
    public function setQueryString($method, $url);

    /**
     * @param bool $encode
     *
     * @return string
     */
    public function sign($encode = true);


    /**
     * @param string $appUrl
     *
     * @return TokenInterface
     */
    public function setAppUrl($appUrl);


    /**
     * @param int $time
     *
     * @return TokenInterface
     */
    public function setIssuedAtTime($time);


    /**
     * @param int $date
     *
     * @return TokenInterface
     */
    public function setExpirationDate($date);

}
