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
use Adlogix\Confluence\Client\Security\Authentication\NoAuthentication;
use Adlogix\Confluence\Client\Tests\TestCase;

class NoAuthenticationTest extends TestCase
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
            ->with('none')
            ->willReturnSelf();

        $noAuthentication = new NoAuthentication($securityContext, $descriptor);

        $this->assertEquals(
            'none',
            $noAuthentication->getType()
        );

    }

}
