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

namespace Adlogix\ConfluenceClient\Entity\Collection;

/**
 * Interface CollectionInterface
 * @package Adlogix\ConfluenceClient\Entity\Collection
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
interface CollectionInterface
{

    /**
     * @return int
     */
    public function getStart();


    /**
     * @return int
     */
    public function getLimit();


    /**
     * @return int
     */
    public function getSize();
}
