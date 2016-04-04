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

namespace Adlogix\Confluence\Client\Entity\Error;

/**
 * Class ApiError
 * @package Adlogix\Confluence\Entity\Error
 * @author Cedric Michaux <cedric@adlogix.eu>
 */
class ApiError
{

    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $message;

    /**
     * @var FieldError[]
     */
    private $fieldErrors;

    /**
     * ApiError constructor.
     * @param int $code
     * @param string $message
     * @param FieldError[] $fieldErrors
     */
    public function __construct($code, $message, array $fieldErrors = [])
    {
        $this->code = (int)$code;
        $this->message = (string)$message;
        $this->fieldErrors = $fieldErrors;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return FieldError[]
     */
    public function getFieldErrors()
    {
        return $this->fieldErrors;
    }


}
