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
 * Class DescriptorLinks
 * @package Adlogix\Confluence\Client\Entity\Connect
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class DescriptorLink
{
    /**
     * @var array
     */
    private $store = [];

    /**
     * @param $name
     * @param $url
     *
     * @return DescriptorLink
     */
    public function add($name, $url)
    {
        $this->store[$name] = $url;
        return $this;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->store;
    }


}
