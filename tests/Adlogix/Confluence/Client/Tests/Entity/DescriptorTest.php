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

namespace Adlogix\Confluence\Client\Tests\Entity;


use Adlogix\Confluence\Client\Entity\Connect\Descriptor;
use Adlogix\Confluence\Client\Entity\Connect\DescriptorAuthentication;
use Adlogix\Confluence\Client\Entity\Connect\DescriptorLifecycle;
use Adlogix\Confluence\Client\Tests\TestCase;

class DescriptorTest extends TestCase
{

    /**
     * @test
     */
    public function create_Success()
    {

        $jsonString = '{"authentication":{"type":"jwt"},"baseUrl":"some\/path","key":"ABCDEF","lifecycle":{"enabled":"\/other\/webhook","installed":"\/some\/webhook"}}';

        $descriptor = new Descriptor('some/path', 'ABCDEF');

        $descriptor->setAuthentication(new DescriptorAuthentication('jwt'));

        $lifecycle = new DescriptorLifecycle();

        $lifecycle->setInstalled('/some/webhook')
            ->setEnabled("/other/webhook");

        $descriptor->setLifecycle($lifecycle);
        
        $this->assertEquals(
            $jsonString,
            $this->serialize($descriptor)
        );

    }


}
