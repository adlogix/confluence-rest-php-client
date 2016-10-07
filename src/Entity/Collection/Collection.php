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
 * Class Collection
 * @package Adlogix\ConfluenceClient\Entity\Collection
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class Collection implements CollectionInterface
{

    /**
     * @var int
     */
    private $start;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $size;

    /**
     * {@inheritdoc}
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param int $start
     *
     * @return Collection
     */
    public function setStart($start)
    {
        $this->start = $start;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     *
     * @return Collection
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSize()
    {
        return $this->size;
    }

    /*
     * @param int $size
     *
     * @return Collection
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

}
