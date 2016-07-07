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

namespace Adlogix\Confluence\Client\Tests\Helpers;


use Adlogix\Confluence\Client\Helpers\Qsh;
use Adlogix\Confluence\Client\Tests\TestCase;

/**
 * Class QshTest
 * @package Adlogix\Confluence\Client\Helpers
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class QshTest extends TestCase
{
    /**
     * @test
     */
    public function create_WithoutQueryParams_Success()
    {
        // QSH can be generated at: http://jwt-decoder.herokuapp.com/jwt/decode
        $this->assertEquals(
            '909144220b8eb4799623bdbb198a01485d4a7ad975d261cdfe14dafe021748c3',
            Qsh::create('GET', '/some/path')
        );
    }

    /**
     * @test
     */
    public function create_WithQueryParams_Success()
    {
        $this->assertEquals(
            '536378242f0cd9a2a0b909a30a8ab1fb608f27891ec4acf250f42e66c04ca220',
            Qsh::create('GET', '/some/path?with=parameter&other=parameter')
        );
    }

    /**
     * @test
     * @dataProvider queryStringHash_dataprovider
     *
     * @param $hash
     * @param $method
     * @param $uri
     */
    public function create_WithDifferentMethods_Success($hash, $method, $uri)
    {
        $this->assertEquals(
            $hash,
            Qsh::create($method, $uri)
        );
    }

    public function queryStringHash_dataprovider()
    {
        return [
            [
                '536378242f0cd9a2a0b909a30a8ab1fb608f27891ec4acf250f42e66c04ca220',
                'GET',
                '/some/path?with=parameter&other=parameter'
            ],
            [
                '93ff4bd7660c5e618e66aaf7ae806c408d1746625b3a8407e1814320f0f3e844',
                'POST',
                '/some/path?with=parameter&other=parameter'
            ],
            [
                '7bf781c8cee3048039629b175fbd94508cabf5d4563a3c8ceb89c792cb3dca23',
                'PUT',
                '/some/path?with=parameter&other=parameter'
            ],
            [
                '48f33ed920afac6e55321b02c3637810242e80832abc0dde1373e452f2a12bd6',
                'DELETE',
                '/some/path?with=parameter&other=parameter'
            ]
        ];
    }

}
