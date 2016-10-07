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

/**
 * Interface FakerInterface
 * @package Adlogix\ConfluenceClient\Tests\Entity\Utils
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
interface FakerInterface
{
    /**
     * @param $id
     *
     * @return mixed
     */
    public static function create($id);
}
