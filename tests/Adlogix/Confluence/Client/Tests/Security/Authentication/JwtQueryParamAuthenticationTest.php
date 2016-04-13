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

namespace Adlogix\Confluence\Client\Tests\Security\Authentication;


use Adlogix\Confluence\Client\Entity\Connect\DescriptorInterface;
use Adlogix\Confluence\Client\Entity\Connect\SecurityContext;
use Adlogix\Confluence\Client\Security\Authentication\JwtQueryParamAuthentication;
use Adlogix\Confluence\Client\Tests\TestCase;

class JwtQueryParamAuthenticationTest extends TestCase
{

    /**
     * @test
     */
    public function return_Type_Correct()
    {
        $securityContext = $this->getMock(SecurityContext::class);
        $descriptor = $this->getMock(DescriptorInterface::class);

        $descriptor->expects($this->once())
            ->method("setAuthentication")
            ->willReturnSelf();


        $descriptor->expects($this->once())
            ->method('getKey')
            ->willReturn('12345');

        $jwtQueryParamAuthentication = new JwtQueryParamAuthentication($securityContext, $descriptor);

        $this->assertEquals(
            'jwt',
            $jwtQueryParamAuthentication->getType()
        );
    }


    /**
     * @test
     * @expectedException LogicException
     */
    public function return_WithoutQSH_ThrowsException()
    {
        $securityContext = $this->getMock(SecurityContext::class);
        $descriptor = $this->getMock(DescriptorInterface::class);

        $descriptor->expects($this->once())
            ->method("setAuthentication")
            ->willReturnSelf();


        $descriptor->expects($this->once())
            ->method('getKey')
            ->willReturn('12345');

        $jwtQueryParamAuthentication = new JwtQueryParamAuthentication($securityContext, $descriptor);

        $this->assertEquals(
            ['jwt' => ''],
            $jwtQueryParamAuthentication->getQueryParameters()
        );
    }


    /**
     * @test
     */
    public function return_WithQSH_Success()
    {
        $securityContext = $this->getMock(SecurityContext::class);
        $descriptor = $this->getMock(DescriptorInterface::class);

        $descriptor->expects($this->once())
            ->method("setAuthentication")
            ->willReturnSelf();


        $descriptor->expects($this->once())
            ->method('getKey')
            ->willReturn('12345');

        $jwtQueryParamAuthentication = new JwtQueryParamAuthentication($securityContext, $descriptor);

        $token = $jwtQueryParamAuthentication->getToken();

        $token->setIssuedAtTime(123456);
        $token->setExpirationDate(123457);
        $token->setQueryString('GET', '/some/path');

        $this->assertEquals(
            ['jwt' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiIxMjM0NSIsImlhdCI6MTIzNDU2LCJleHAiOjEyMzQ1NywicXNoIjoiOTA5MTQ0MjIwYjhlYjQ3OTk2MjNiZGJiMTk4YTAxNDg1ZDRhN2FkOTc1ZDI2MWNkZmUxNGRhZmUwMjE3NDhjMyJ9.5TwSmHVGWaBZM78PNVtHSoU1gtZ21X-SDuSGsIRmNS4'],
            $jwtQueryParamAuthentication->getQueryParameters()
        );


        $this->assertEmpty(
            $jwtQueryParamAuthentication->getHeaders()
        );

    }

}
