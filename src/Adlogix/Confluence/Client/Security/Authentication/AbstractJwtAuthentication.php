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
use Adlogix\Confluence\Client\Entity\Connect\DescriptorInterface;
use Adlogix\Confluence\Client\Entity\Connect\JwtToken;
use Adlogix\Confluence\Client\Entity\Connect\SecurityContext;
use JMS\Serializer\SerializerInterface;

/**
 * Class AbstractJwtAuthentication
 * @package Adlogix\Confluence\Client\Security\Authentication
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
abstract class AbstractJwtAuthentication extends AbstractAuthentication
{

    /**
     * {@inheritdoc}
     */
    public function __construct(
        SecurityContext $securityContext,
        DescriptorInterface $descriptor,
        SerializerInterface $serializer = null
    )
    {
        parent::__construct($securityContext, $descriptor, $serializer = null);
        $this->token = new JwtToken($descriptor->getKey(), $securityContext->getSharedSecret());
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return DescriptorAuthentication::TYPE_JWT;
    }
}
