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


trait fakerCreateManyTrait
{
    /**
     * @param int $qty
     *
     * @return array
     */
    public static function createMany($qty)
    {
        /** @var FakerInterface $fakerClass */
        $fakerClass = get_called_class();

        $objects = [];
        for ($i = 0; $i < $qty; $i++) {
            $objects[] = $fakerClass::create($i + 1);
        }

        return $objects;
    }
}
