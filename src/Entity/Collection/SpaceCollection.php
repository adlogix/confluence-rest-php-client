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


use Adlogix\ConfluenceClient\Entity\Space;

/**
 * Class SpaceCollection
 * @package Adlogix\ConfluenceClient\Entity\Collection
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class SpaceCollection extends Collection
{

    /**
     * @var Space[]
     */
    private $spaces;

    /**
     * SpaceCollection constructor.
     *
     * @param Space[] $spaces
     */
    public function __construct(array $spaces = [])
    {
        $this->spaces = $spaces;
    }

    /**
     * @return Space
     */
    public function getSpaces()
    {
        return $this->spaces;
    }
}
