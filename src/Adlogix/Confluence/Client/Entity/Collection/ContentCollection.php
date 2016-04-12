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

namespace Adlogix\Confluence\Client\Entity\Collection;


use Adlogix\Confluence\Client\Entity\Content;

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
