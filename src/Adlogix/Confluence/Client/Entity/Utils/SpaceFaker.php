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

namespace Adlogix\Confluence\Client\Entity\Utils;


use Adlogix\Confluence\Client\Entity\Space;

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
