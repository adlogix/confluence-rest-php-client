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


use Adlogix\Confluence\Client\Entity\Error\ApiError;

/**
 * Class ApiException
 * @package Adlogix\Confluence\Client\Exception
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
}
