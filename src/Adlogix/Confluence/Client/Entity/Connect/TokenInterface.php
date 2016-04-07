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


interface TokenInterface
{

    /**
     * @param string $method
     * @param string $url
     */
    public function setQueryString($method, $url);

    /**
     * @param bool $encode
     *
     * @return string
     */
    public function sign($encode = true);
}
