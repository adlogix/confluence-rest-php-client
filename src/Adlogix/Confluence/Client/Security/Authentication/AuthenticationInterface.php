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


use Adlogix\Confluence\Client\Entity\Connect\DescriptorInterface;
use Adlogix\Confluence\Client\Entity\Connect\SecurityContext;
use Adlogix\Confluence\Client\Entity\Connect\TokenInterface;
use JMS\Serializer\SerializerInterface;

/**
 * Interface AuthenticationInterface
 * @package Adlogix\Confluence\Client\Security\Connect
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
interface AuthenticationInterface
{

    /**
     * AuthenticationInterface constructor.
     *
     * @param SecurityContext          $securityContext
     * @param DescriptorInterface               $descriptor
     * @param SerializerInterface|null $serializer
     */
    public function __construct(
        SecurityContext $securityContext,
        DescriptorInterface $descriptor,
        SerializerInterface $serializer = null
    );

    /**
     * @return string
     */
    public function getType();


    /**
     * @return array
     */
    public function getHeaders();


    /**
     * @return array
     */
    public function getQueryParameters();

    /**
     * @return TokenInterface
     */
    public function getToken();
}
