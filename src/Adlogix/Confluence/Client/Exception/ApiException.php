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

namespace Adlogix\Confluence\Client\Exception;


use Adlogix\Confluence\Entity\Error\ApiError;
use Adlogix\Confluence\Entity\Error\FieldError;

/**
 * Class ApiException
 * @package Adlogix\Confluence\Exception
 * @author Cedric Michaux <cedric@adlogix.eu>
 */
class ApiException extends \Exception
{

    /**
     * @var ApiError
     */
    private $apiError;

    public function __construct(ApiError $apiError)
    {
        parent::__construct($apiError->getMessage(), $apiError->getCode());
        $this->apiError = $apiError;
    }

    /**
     * @return ApiError
     */
    public function getApiError()
    {
        return $this->apiError;
    }

    /**
     * @return FieldError[]
     */
    public function getFieldErrors()
    {
        return $this->apiError->getFieldErrors();
    }
}
