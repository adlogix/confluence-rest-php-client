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
use Adlogix\Confluence\Client\Entity\Connect\DescriptorBuilder;
use Adlogix\Confluence\Client\Entity\Connect\EmptyToken;
use Adlogix\Confluence\Client\Entity\Connect\SecurityContext;
use Adlogix\Confluence\Client\Security\ConnectJwtAuthentication;
use JMS\Serializer\SerializerInterface;


/**
 * Class ConnectAuthentication
 * @package Adlogix\Confluence\Client\Security
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class ConnectAuthentication implements AuthenticationInterface
{

    /**
     * @var TokenInterface
     */
    protected $token;

    /**
     * @var SerializerInterface|null
     */
    private $serializer;

    /**
     * @var SecurityContext
     */
    private $securityContext;

    /**
     * @var Descriptor
     */
    protected $descriptor;


    /**
     * ConnectAuthentication constructor.
     *
     * @param SecurityContext     $securityContext
     * @param Descriptor          $descriptor
     * @param SerializerInterface $serializer
     *
     */
    public function __construct(
        SecurityContext $securityContext,
        Descriptor $descriptor,
        SerializerInterface $serializer = null
    ) {
        $this->securityContext = $securityContext;
        $this->serializer = $serializer;
        $this->descriptor = $descriptor;

        //$descriptor->setAuthentication($this->authentication->getType());
        
        $this->descriptor->setAuthentication($this->getType());

        $this->token = new EmptyToken();

    }


    /**
     * {@inheritdoc}
     */
    public function getHeaders()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryParameters()
    {
    }


    /**
     * @return TokenInterface
     */
    public function getToken()
    {
        return $this->token;
    }

    public function getDescriptor()
    {
        return $this->descriptor;
    }
}
