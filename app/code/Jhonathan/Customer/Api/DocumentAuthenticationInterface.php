<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Customer
 */

namespace Jhonathan\Customer\Api;

/**
 * Interface DocumentAuthenticationInterface
 * @package Jhonathan\Customer\Api
 */
interface DocumentAuthenticationInterface {

    /**
     * @param string $doc
     * @return array[]|bool[][]|mixed
     */
    public function Authentication(string $doc): mixed;
}
