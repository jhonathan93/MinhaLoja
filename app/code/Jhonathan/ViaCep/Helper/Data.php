<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_ViaCep
 */

namespace Jhonathan\ViaCep\Helper;

use Jhonathan\Core\Helper\Data\AbstractData;
use Magento\Framework\App\Helper\Context;
use Magento\Backend\App\ConfigInterface;
use Magento\Framework\HTTP\Client\Curl;

use Jhonathan\ViaCep\Model\Method\Logger;

use Exception;

/**
 * Class Data
 * @package Jhonathan\ViaCep\Helper
 */
class Data extends AbstractData {

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
    private Curl $curl;

    /**
     * @var Logger
     */
    public Logger $logger;

    /**
     * @param Context $context
     * @param ConfigInterface $config
     * @param Curl $curl
     * @param Logger $logger
     */
    public function __construct(Context $context, ConfigInterface $config, Curl $curl, Logger $logger) {
        parent::__construct($context, $this->_getModuleName(), $config);
        $this->curl = $curl;
        $this->logger = $logger;
    }

    /**
     * @param string $zipcode
     * @return string
     * @throws Exception
     */
    public function request(string $zipcode): string {
        $this->curl->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->curl->setTimeout(90);
        $this->curl->setOption(CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        $this->curl->setOption(CURLOPT_CUSTOMREQUEST, 'GET');
        $this->curl->addHeader("Content-Type", "application/json");
        $this->curl->get(str_replace('{{CEP}}', $zipcode, self::URL_VIACEP));
        $response = $this->curl->getBody();

        if ($this->curl->getStatus() > 201) {
            throw new Exception(print_r($response, true));
        }

        $this->logger->debug(['response' => $response], true);

        return $response;
    }
}
