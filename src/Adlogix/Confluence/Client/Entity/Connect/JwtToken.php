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


use Firebase\JWT\JWT;

class JwtToken implements TokenInterface
{

    /**
     * @var string
     */
    private $issuer;

    /**
     * @var int
     */
    private $issuedAtTime;

    /**
     * @var int
     */
    private $expirationDate;

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
     * @var string
     */
    private $appUrl;


    /**
     * JwtToken constructor.
     *
     * @param string $issuer
     * @param string $secret
     * @param int    $expirationAfter = 3600
     */
    public function __construct($issuer, $secret, $expirationAfter = 3600)
    {

        $this->issuer = $issuer;
        $this->secret = $secret;
        $this->issuedAtTime = time();
        $this->expirationDate = $this->issuedAtTime + $expirationAfter;
    }

    /**
     * @return string
     */
    public function getIssuer()
    {
        return $this->issuer;
    }

    /**
     * @param $issuer
     *
     * @return $this
     */
    public function setIssuer($issuer)
    {
        $this->issuer = $issuer;
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
     * @param $subject
     *
     * @return $this
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
     * @param $audience
     *
     * @return $this
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
     * @param $context
     *
     * @return $this
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

    /**
     * @return string
     */
    public function getAppUrl()
    {
        return $this->appUrl;
    }

    /**
     * @param string $appUrl
     *
     * @return $this
     */
    public function setAppUrl($appUrl)
    {
        $this->appUrl = $appUrl;
        return $this;
    }

    /**
     * @param string $method
     * @param string $url
     */
    public function setQueryString($method, $url)
    {
        $url = str_replace($this->appUrl, "", $url);
        
        $this->queryStringHash = QSH::create($method, $url);
    }

    /**
     * @param bool $encode
     *
     * @return string
     */
    public function sign($encode = true)
    {
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
