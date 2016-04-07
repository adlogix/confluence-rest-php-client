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

namespace Adlogix\Confluence\Client\Service;

/**
 * Class SpaceService
 * @package Adlogix\Confluence\Client\Service
 * @author Cedric Michaux <cedric@adlogix.eu>
 */
class SpaceService extends AbstractApiService
{

    public function all(array $options = [])
    {
        $all = $this->get('space');

        return $all;
    }

    public function byKey($key, array $options = [])
    {
        $space = $this->get(sprintf('space/%s', $key));

        return $space;
    }
}
