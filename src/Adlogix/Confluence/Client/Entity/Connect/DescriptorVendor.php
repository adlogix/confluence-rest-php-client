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
 * Class DescriptorVendor
 * @package Adlogix\Confluence\Client\Entity\Connect
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class DescriptorVendor implements DescriptorInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $url;


    /**
     * ConnectDescriptorVendor constructor.
     *
     * @param string $name
     * @param string $url
     */
    public function __construct($name, $url)
    {
        $this->name = $name;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return DescriptorVendor
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return DescriptorVendor
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }
}
