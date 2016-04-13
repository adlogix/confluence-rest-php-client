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


interface DescriptorInterface
{
    /**
     * Descriptor constructor.
     *
     * @param string $baseUrl
     * @param string $key
     *
     */
    public function __construct($baseUrl, $key);


    /**
     * @param DescriptorAuthentication $authentication
     *
     * @return DescriptorInterface
     */
    public function setAuthentication(DescriptorAuthentication $authentication);


    /**
     * @return string
     */
    public function getKey();
}
