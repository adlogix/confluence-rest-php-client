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

namespace Adlogix\Confluence\Client\Service;

use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;

/**
 * Class AbstractService
 * @package Adlogix\Confluence\Client\Service
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class AbstractService implements ServiceInterface
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * AbstractService constructor.
     *
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }


    /**
     * @param mixed                $entity
     * @param SerializationContext $context
     *
     * @return string
     */
    protected function serialize($entity, SerializationContext $context = null)
    {
        return $this->serializer->serialize($entity, 'json', $context);
    }

    /**
     * @param string                 $json
     * @param string                 $type
     * @param DeserializationContext $context
     *
     * @return mixed
     */
    protected function deserialize($json, $type, DeserializationContext $context = null)
    {
        return $this->serializer->deserialize($json, $type, 'json', $context);
    }

}
