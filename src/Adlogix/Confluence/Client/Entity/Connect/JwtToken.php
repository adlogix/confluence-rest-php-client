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

/**
 * Class JwtToken
 *
 * The JWT standard can be found there
 * @see     https://jwt.io/
 *
 * You can test your JWT token validity against Atlassian there
 * @see     http://jwt-decoder.herokuapp.com/jwt/decode
 *
 *
 * @package Adlogix\Confluence\Client\Entity\Connect
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
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
        $url = rawurldecode(str_replace($this->appUrl, "", $url));

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

        if (null == $this->queryStringHash) {
            throw new \LogicException('You should provide a Query String before calling sign');
        }

        $payload = [
            'iss' => $this->issuer,
            'iat' => $this->issuedAtTime,
            'exp' => $this->expirationDate,
            'qsh' => $this->queryStringHash
        ];

        if (null !== $this->context) {
            $payload['context'] = $this->context;
        }

        if (null !== $this->subject) {
            $payload['sub'] = $this->subject;
        }

        if (null !== $this->audience) {
            $payload['aud'] = $this->audience;
        }

        if (!$encode) {
            return $payload;
        }
        return JWT::encode($payload, $this->secret);
    }

    /**
     * @return string
     */
    public function getIssuer()
    {
        return $this->issuer;
    }

    /**
     * @param string $issuer
     *
     * @return JwtToken
     */
    public function setIssuer($issuer)
    {
        $this->issuer = $issuer;
        return $this;
    }

    /**
     * @return string
     */
    public function getQueryStringHash()
    {
        return $this->queryStringHash;
    }

    /**
     * @param string $queryStringHash
     *
     * @return JwtToken
     */
    public function setQueryStringHash($queryStringHash)
    {
        $this->queryStringHash = $queryStringHash;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     *
     * @return JwtToken
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string
     */
    public function getAudience()
    {
        return $this->audience;
    }

    /**
     * @param string $audience
     *
     * @return JwtToken
     */
    public function setAudience($audience)
    {
        $this->audience = $audience;
        return $this;
    }

    /**
     * @return object
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param object $context
     *
     * @return JwtToken
     */
    public function setContext($context)
    {
        $this->context = $context;
        return $this;
    }

    /**
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param string $secret
     *
     * @return JwtToken
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
        return $this;
    }


}
