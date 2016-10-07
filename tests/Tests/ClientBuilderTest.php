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

namespace Adlogix\ConfluenceClient\Tests;


use Adlogix\ConfluenceClient\Client;
use Adlogix\ConfluenceClient\ClientBuilder;
use Adlogix\GuzzleAtlassianConnect\Security\AuthenticationInterface;

class ClientBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function build_Simple_Success()
    {
        $authentication = $this->createMock(AuthenticationInterface::class);
        $clientBuilder = ClientBuilder::create('/some/path', $authentication);
        $client = $clientBuilder->build();

        $this->assertInstanceOf(Client::class, $client);
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

        $authentication = $this->createMock(AuthenticationInterface::class);

        ClientBuilder::create($invalidBaseUri, $authentication);
    }

    /**
     * @return array
     */
    public function invalidBuilderParam_dataprovider()
    {
        return [[''], [null]];
    }
}
