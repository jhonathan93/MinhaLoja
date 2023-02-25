<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_ViaCep
 */

namespace Jhonathan\ViaCep\Api;

/**
 * Class Data
 * @package Jhonathan\ViaCep\Helper
 */
interface ViaCepInterface
{

    /**
     * @param string $zipcode
     * @return string
     */
    public function searchAddressByCep(string $zipcode): string;
}
