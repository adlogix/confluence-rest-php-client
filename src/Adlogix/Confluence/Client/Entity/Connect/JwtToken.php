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

namespace Adlogix\Confluence\Client\Entity\Connect;


use Adlogix\Confluence\Client\Helpers\Qsh;
use Firebase\JWT\JWT;

class JwtToken extends AbstractToken
{

    /**
     * @var string
     */
    private $issuer;

    /**
     * @var string
     */
    private $queryStringHash;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $audience;

    /**
     * @var object
     */
    private $context;

    /**
     * @var string
     */
    private $secret;


    /**
     * JwtToken constructor.
     *
     * @param string $issuer
     * @param string $secret
     * @param null   $issuedAtTime
     * @param int    $expirationAfter = 3600
     */
    public function __construct($issuer, $secret, $issuedAtTime = null, $expirationAfter = 3600)
    {
        $this->issuer = $issuer;
        $this->secret = $secret;
        $this->issuedAtTime = ($issuedAtTime) ?: time();
        $this->expirationDate = $this->issuedAtTime + $expirationAfter;
    }

    /**
     * {@inheritdoc}
     */
    public function setQueryString($method, $url)
    {
        $url = str_replace($this->appUrl, "", $url);

        $this->queryStringHash = Qsh::create($method, $url);
        return $this;
    }

    /**
     * @param bool $encode
     *
     * @return string
     */
    public function sign($encode = true)
    {

        if(null == $this->queryStringHash){
            throw new \LogicException('You should provide a Query String before calling sign');
        }

        $payload = [
            'iss' => $this->issuer,
            'iat' => $this->issuedAtTime,
            'exp' => $this->expirationDate,
            'qsh' => $this->queryStringHash
        ];
        

        if (!$encode) {
            return $payload;
        }
        return JWT::encode($payload, $this->secret);
    }


}
