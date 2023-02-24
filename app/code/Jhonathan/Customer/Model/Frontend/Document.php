<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Customer
 */

namespace Jhonathan\Customer\Model\Frontend;

use Jhonathan\Customer\Api\DocumentAuthenticationInterface;

/**
 * Class Document
 * @package Jhonathan\Customer\Model\Frontend
 */
class Document implements DocumentAuthenticationInterface {

    /**
     * Document constructor.
     */
    public function __construct() {}

    /**
     * @param string $doc
     * @return array[]|bool[][]|mixed
     */
    public function Authentication(string $doc): array {
        if (strlen($doc) === 14) {
            if ($this->ckeckCpf($doc)) {
                return json_encode(array(
                    'result' => true
                ), JSON_FORCE_OBJECT);
            }

            return json_encode(array(
                'result' => false,
                'message' => sprintf(__('O CPF %s é inválido'), $doc)
            ), JSON_FORCE_OBJECT);
        } else if (strlen($doc) === 18) {
            if ($this->ckeckCnpj($doc)) {
                return json_encode(array(
                    'result' => true
                ), JSON_FORCE_OBJECT);
            }

            return json_encode(array(
                'result' => false,
                'message' => sprintf(__('O CNPJ %s é inválido'), preg_replace('[@]', '/', $doc))
            ),JSON_FORCE_OBJECT);
        } else {
            return  json_encode(array(
                'result' => false,
                'message' => __('O documento informado está incompleto.')
            ), JSON_FORCE_OBJECT);
        }
    }

    /**
     * @param string $cpf
     * @return bool
     */
    private function ckeckCpf(string $cpf): bool {
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf);

        if (strlen($cpf) != 11) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $cnpj
     * @return bool
     */
    private function ckeckCnpj(string $cnpj): bool {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        if (strlen($cnpj) != 14) {
            return false;
        }

        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        for ($i = 0, $j = 5, $sum = 0; $i < 12; $i++) {
            $sum += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $rest = $sum % 11;

        if ($cnpj[12] != ($rest < 2 ? 0 : 11 - $rest)) {
            return false;
        }

        for ($i = 0, $j = 6, $sum = 0; $i < 13; $i++)  {
            $sum += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $rest = $sum % 11;

        return $cnpj[13] == ($rest < 2 ? 0 : 11 - $rest);
    }
}
