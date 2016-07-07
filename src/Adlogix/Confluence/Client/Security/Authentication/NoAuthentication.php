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

namespace Adlogix\Confluence\Client\Security\Authentication;

use Adlogix\Confluence\Client\Entity\Connect\DescriptorAuthentication;

/**
 * Class NoAuthentication
 * @package Adlogix\Confluence\Client\Security\Connect
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class NoAuthentication extends AbstractAuthentication
{

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return  DescriptorAuthentication::TYPE_NONE;
    }

}
