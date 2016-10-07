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


use Adlogix\ConfluenceClient\Entity\Content;

/**
 * Class ContentCollection
 * @package Adlogix\ConfluenceClient\Entity\Collection
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class ContentCollection extends Collection
{

    /**
     * @var Content[]
     */
    private $contents;

    /**
     * SpaceCollection constructor.
     *
     * @param Content[] $contents
     */
    public function __construct(array $contents = [])
    {
        $this->contents = $contents;
    }

    /**
     * @return Content[]
     */
    public function getContents()
    {
        return $this->contents;
    }
}
