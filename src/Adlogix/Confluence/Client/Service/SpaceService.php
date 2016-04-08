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

use Adlogix\Confluence\Client\Entity\Collection\SpaceCollection;
use Adlogix\Confluence\Client\Entity\Space;

/**
 * Class SpaceService
 * @package Adlogix\Confluence\Client\Service
 * @author Cedric Michaux <cedric@adlogix.eu>
 */
class SpaceService extends AbstractApiService
{

    /**
     * @param array $options
     *
     * @return SpaceCollection
     */
    public function all(array $options = [])
    {
        $all = $this->get('space', $options);

        return $this->deserialize(
            $all,
            'Adlogix\Confluence\Client\Entity\Collection\SpaceCollection'
        );
    }

    /**
     * @param string      $key
     * @param array $options
     *
     * @return Space
     */
    public function byKey($key, array $options = [])
    {
        $space = $this->get(sprintf('space/%s', $key), $options);

        return $this->deserialize(
            $space,
            'Adlogix\Confluence\Client\Entity\Space'
        );
    }
}
