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
 * Class DescriptorAuthentication
 * @package Adlogix\Confluence\Client\Entity\Connect
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class DescriptorAuthentication
{

    const TYPE_JWT = 'jwt';
    const TYPE_NONE = 'none';

    /**
     * @var string
     */
    private $type;

    /**
     * DescriptorAuthentication constructor.
     *
     * @param string $type
     */
    public function __construct($type = "")
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return DescriptorAuthentication
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

}
