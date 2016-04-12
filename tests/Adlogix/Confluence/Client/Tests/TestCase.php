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

namespace Adlogix\Confluence\Client\Tests;


use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use PHPUnit_Framework_TestCase;

/**
 * Class TestCase
 * @package Adlogix\Confluence\Client\Tests
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
abstract class TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var SerializerInterface
     */
    private static $serializer;

    /**
     * Configures serializer
     */
    private static function configureSerializer()
    {
        self::$serializer = SerializerBuilder::create()
            ->addMetadataDir(
                __DIR__ . '/../../../../../src/Adlogix/Confluence/Client/Resources/serializer',
                'Adlogix\Confluence\Client'
            )
            ->build();
    }

    /**
     * @return SerializerInterface
     */
    protected function getSerializer()
    {
        return self::$serializer;
    }

    /**
     * @param object|array $data
     *
     * @return string
     */
    protected function serialize($data)
    {
        return self::$serializer->serialize($data, 'json');
    }

    /**
     * {@inheritdoc}
     */
    public static function setUpBeforeClass()
    {
        self::configureSerializer();
    }

}
