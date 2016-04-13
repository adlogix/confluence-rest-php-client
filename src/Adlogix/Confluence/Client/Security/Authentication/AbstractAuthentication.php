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
use Adlogix\Confluence\Client\Entity\Connect\DescriptorBuilder;
use Adlogix\Confluence\Client\Entity\Connect\DescriptorInterface;
use Adlogix\Confluence\Client\Entity\Connect\EmptyToken;
use Adlogix\Confluence\Client\Entity\Connect\SecurityContext;
use Adlogix\Confluence\Client\Entity\Connect\TokenInterface;
use Adlogix\Confluence\Client\Security\JwtAbstractAuthentication;
use JMS\Serializer\SerializerInterface;


/**
 * Class ConnectAuthentication
 * @package Adlogix\Confluence\Client\Security
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
abstract class AbstractAuthentication implements AuthenticationInterface
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
     * {@inheritdoc}
     */
    public function __construct(
        SecurityContext $securityContext,
        DescriptorInterface $descriptor,
        SerializerInterface $serializer = null
    ) {
        $this->securityContext = $securityContext;
        $this->serializer = $serializer;
        $this->descriptor = $descriptor;
        
        $this->descriptor->setAuthentication(new DescriptorAuthentication($this->getType()));

        $this->token = new EmptyToken();
    }


    /**
     * {@inheritdoc}
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescriptor()
    {
        return $this->descriptor;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getHeaders()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryParameters()
    {
        return [];
    }
}
