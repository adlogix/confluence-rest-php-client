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

namespace Adlogix\ConfluenceClient\Service;

use Adlogix\ConfluenceClient\Entity\Collection\ContentCollection;
use Adlogix\ConfluenceClient\Entity\Content;

/**
 * Class PageService
 * @package Adlogix\ConfluenceClient\Service
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class ContentService extends AbstractApiService
{

    /**
     * @param string $spaceKey
     * @param array  $options
     *
     * @return ContentCollection|null
     */
    public function all($spaceKey = "", array $options = [])
    {

        if (!empty($spaceKey)) {
            $options = $this->mergeQueryOptions($options, [
                "query" => [
                    "spaceKey" => $spaceKey
                ]
            ]);
        }

        $all = $this->get('content', $options);
        return $this->deserialize(
            $all,
            ContentCollection::class
        );

    }


    /**
     * @param $id
     *
     * @return mixed
     */
    public function findById($id)
    {
        $content = $this->get('content/' . $id);
        return $this->deserialize(
            $content,
            Content::class
        );
    }

}
