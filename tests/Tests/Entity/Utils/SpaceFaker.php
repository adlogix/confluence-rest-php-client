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

namespace Adlogix\ConfluenceClient\Tests\Entity\Utils;


use Adlogix\ConfluenceClient\Entity\Space;

/**
 * Class SpaceFaker
 * @package Adlogix\ConfluenceClient\Tests\Entity\Utils
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class SpaceFaker implements FakerInterface
{
    use fakerCreateManyTrait;

    /**
     * {@inheritdoc}
     */
    public static function create($id)
    {
        $space = new Space();

        $space->setId($id)
            ->setKey('space'.$id)
            ->setName('Space '.$id)
            ->setType('global')
            ->setDescription('Demo Space');


        return $space;
    }
}
