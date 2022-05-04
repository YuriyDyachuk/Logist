<?php
/**
 * Author: Vitalii Pervii
 * Author URI: https://www.amconsoft.com/
 * Date: 10.08.2018
 */

namespace App\Services;


abstract class BaseService
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @return array
     */
    public function fails(): array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function isFails(): bool
    {
        return !empty($this->errors);
    }

    /**
     * @return array
     */
    public function getFails(): array
    {
        return $this->errors;
    }
}