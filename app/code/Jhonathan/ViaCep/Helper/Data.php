<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_ViaCep
 */

namespace Jhonathan\ViaCep\Helper;

use Jhonathan\Core\Helper\Data\AbstractData;
use Jhonathan\ViaCep\Model\Method\Debug;
use Magento\Backend\App\Config;
use Magento\Framework\App\Helper\Context;

use Magento\Framework\HTTP\Client\Curl;

/**
 * Class Data
 * @package Jhonathan\ViaCep\Helper
 */
class Data extends AbstractData
{

    /**
     * @var string
     */
    const URL_VIACEP = 'https://viacep.com.br/ws/{{CEP}}/json/';

    /**
     * @var string[]
     */
    const STATE_BY_UF = [
        'AC'=>'Acre',
        'AL'=>'Alagoas',
        'AP'=>'Amapá',
        'AM'=>'Amazonas',
        'BA'=>'Bahia',
        'CE'=>'Ceará',
        'DF'=>'Distrito Federal',
        'ES'=>'Espírito Santo',
        'GO'=>'Goiás',
        'MA'=>'Maranhão',
        'MT'=>'Mato Grosso',
        'MS'=>'Mato Grosso do Sul',
        'MG'=>'Minas Gerais',
        'PA'=>'Pará',
        'PB'=>'Paraíba',
        'PR'=>'Paraná',
        'PE'=>'Pernambuco',
        'PI'=>'Piauí',
        'RJ'=>'Rio de Janeiro',
        'RN'=>'Rio Grande do Norte',
        'RS'=>'Rio Grande do Sul',
        'RO'=>'Rondônia',
        'RR'=>'Roraima',
        'SC'=>'Santa Catarina',
        'SP'=>'São Paulo',
        'SE'=>'Sergipe',
        'TO'=>'Tocantins'
    ];

    /**
     * @var Curl
     */
    public Curl $curl;

    /**
     * @var Debug
     */
    public Debug $debug;

    public function __construct(Context $context, Config $config, Curl $curl, Debug $debug)
    {
        parent::__construct($context, $this->_getModuleName(), $config);
        $this->curl = $curl;
        $this->debug = $debug;
    }

    /**
     * @param string $code
     * @return mixed
     */
    public function isEnabled(string $code): mixed
    {
        return parent::isEnabled($code);
    }

    /**
     * @param array $data
     * @param bool $forceDebug
     * @return void
     */
    public function logger(array $data, bool $forceDebug): void
    {
        if ($forceDebug === true || $this->isEnabled('logging/enabled') === true) {
            $this->debug->debug($data);
        }
    }
}
