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


use Adlogix\Confluence\Client\Entity\Connect\JwtToken;
use Adlogix\Confluence\Client\Tests\TestCase;

/**
 * Class JwtTokenTest
 * @package Adlogix\Confluence\Client\Tests\Entity
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class JwtTokenTest extends TestCase
{

    /**
     * @test
     * @expectedException \LogicException
     */
    public function sign_WithoutQsh_ThrowsException()
    {
        $token = new JwtToken('testIssuer', 'secretKey');
        $token->sign();
    }


    /**
     * @test
     */
    public function sign_WithQsh_Success()
    {
        $token = new JwtToken('testIssuer', 'secretKey', 1234567);
        $token->setQueryString('GET', '/some/path');

        $this->assertEquals(
            'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0SXNzdWVyIiwiaWF0IjoxMjM0NTY3LCJleHAiOjEyMzgxNjcsInFzaCI6IjkwOTE0NDIyMGI4ZWI0Nzk5NjIzYmRiYjE5OGEwMTQ4NWQ0YTdhZDk3NWQyNjFjZGZlMTRkYWZlMDIxNzQ4YzMiLCJzdWIiOm51bGwsImF1ZCI6bnVsbCwiY29udGV4dCI6bnVsbH0.euyfp2nPRM5E_gGV0AXhm271h-QbBM-CvaKUtU2h1ZI',
            $token->sign()
        );
    }
}
