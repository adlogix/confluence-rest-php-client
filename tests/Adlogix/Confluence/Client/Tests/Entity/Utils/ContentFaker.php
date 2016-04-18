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

namespace Adlogix\Confluence\Client\Tests\Entity\Utils;


use Adlogix\Confluence\Client\Entity\Content;

class ContentFaker implements FakerInterface
{
    
    use fakerCreateManyTrait;

    /**
     * @param $id
     *
     * @return Content
     */
    public static function create($id)
    {
        $content = new Content();

        $content->setId($id)
            ->setTitle('Content '.$id)
            ->setType('page')
            ->setStatus('published');

        return $content;
    }
}
