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

namespace Adlogix\Confluence\Client\Entity\Connect;

/**
 * Class AbstractToken
 * @package Adlogix\Confluence\Client\Entity\Connect
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class AbstractToken implements TokenInterface
{
    /**
     * @var string
     */
    protected $appUrl;

    /**
     * @var int
     */
    protected $issuedAtTime;

    /**
     * @var int
     */
    protected $expirationDate;

    /**
     * {@inheritdoc}
     */
    public function setQueryString($method, $url)
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function sign($encode = true)
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function setAppUrl($appUrl)
    {
        $this->appUrl = $appUrl;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setIssuedAtTime($time)
    {
        $this->issuedAtTime = $time;
    }

    /**
     * {@inheritdoc}
     */
    public function setExpirationDate($date)
    {
       $this->expirationDate = $date;
    }
}
