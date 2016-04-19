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

/**
 * Class DescriptorTest
 * @package Adlogix\Confluence\Client\Tests\Entity
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
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

    /**
     * @test
     * @dataProvider authorizedCharacters_dataprovider
     *
     * @param $chars
     */
    public function create_WithAuthorizedChars_Success($chars)
    {
        new Descriptor('some/path', $chars);
    }

    public function authorizedCharacters_dataprovider()
    {
        return [
            ['abcdefghijklmnopqrstuvwxyz'],
            ['ABCDEFGHIJKLMNOPQRSTUVWXYZ'],
            ['123456789'],
            ['.-_']
        ];
    }


    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function create_WithKeyTooLong_Exception()
    {
        new Descriptor('some/path', '12345678901234567890123456789012345678901234567890123456789012345678901234567890');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @dataProvider restrictedCharacter_dataprovider
     *
     * @param $chars
     */
    public function create_WithRestrictedChars_Exception($chars)
    {
        new Descriptor('some/path', $chars);
    }

    public function restrictedCharacter_dataprovider()
    {
        return [
            ['{'],
            ['}'],
            ['['],
            [']'],
            ['\''],
            ['\\'],
            ['"']
        ];
    }


}
