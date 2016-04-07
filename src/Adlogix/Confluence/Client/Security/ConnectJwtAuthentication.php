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
use Adlogix\Confluence\Client\Entity\Connect\JwtToken;
use Adlogix\Confluence\Client\Entity\Connect\SecurityContext;

class ConnectJwtAuthentication extends ConnectAuthentication implements ConnectAuthenticationInterface
{


    
    
    /**
     * ConnectJwtAuthentication constructor.
     *
     * @param SecurityContext|null $securityContext
     * @param Descriptor           $descriptor
     * @param SerializerInterface  $serializer
     */
    public function __construct(
        SecurityContext $securityContext,
        Descriptor $descriptor,
        SerializerInterface $serializer = null)
    {
        parent::__construct( $securityContext, $descriptor, $serializer = null);
        $this->token = new JwtToken($descriptor->getKey(), $securityContext->getSharedSecret()); 
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'jwt';
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders()
    {
        return [
            "Authentication" => sprintf('JWT %s', $this->token->sign())
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryParameters()
    {
        return [
            'jwt' => $this->token->sign()
        ];
    }
}
