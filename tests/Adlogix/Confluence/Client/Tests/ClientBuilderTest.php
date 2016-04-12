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

namespace Adlogix\Confluence\Client\Tests;


use Adlogix\Confluence\Client\Client;
use Adlogix\Confluence\Client\ClientBuilder;
use Adlogix\Confluence\Client\Security\Authentication\AuthenticationInterface;

class ClientBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function build_Simple_Success()
    {
        $authentication = $this->getMock(AuthenticationInterface::class);
        $clientBuilder = new ClientBuilder('/some/path', $authentication);
        $client = $clientBuilder->build();

        $this->assertInstanceOf(Client::class, $client);
    }

    /**
     * @test
     */
    public function build_WithNoAuthentication_ThrowsException()
    {
        try {
            new ClientBuilder('/', null);
            $this->fail('Should have thrown an exception');
        } catch (\Exception $exception) {
            $this->assertContains(
                AuthenticationInterface::class,
                $exception->getMessage()
            );
        }
    }


    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @dataProvider invalidBuilderParam_dataprovider
     *
     * @param $invalidBaseUri
     */
    public function build_WithInvalidBaseUri_ThrowsException($invalidBaseUri)
    {

        $authentication = $this->getMock(AuthenticationInterface::class);

        new ClientBuilder($invalidBaseUri, $authentication);
    }

    /**
     * @return array
     */
    public function invalidBuilderParam_dataprovider()
    {
        return [[''], [null]];
    }
}
