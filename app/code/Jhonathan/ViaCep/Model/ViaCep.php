<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_ViaCep
 */

namespace Jhonathan\ViaCep\Model;

use Magento\Framework\Serialize\Serializer\Json;
use Magento\Directory\Model\RegionFactory;
use Jhonathan\ViaCep\Api\ViaCepInterface;
use Jhonathan\ViaCep\Helper\Data;

use Exception;

/**
 * Class ViaCep
 * @package Jhonathan\Customer\Model\Frontend
 */
class ViaCep implements ViaCepInterface {

    /**
     * @var Data
     */
    private Data $helper;

    /**
     * @var Json
     */
    private Json $json;

    /**
     * @var RegionFactory
     */
    private regionFactory $regionFactory;

    /**
     * @param Data $helper
     * @param Json $json
     * @param RegionFactory $regionFactory
     */
    public function __construct(Data $helper,
                                Json $json,
                                RegionFactory $regionFactory) {
        $this->helper = $helper;
        $this->json = $json;
        $this->regionFactory = $regionFactory;
    }

    /**
     * @param string $zipcode
     * @return string
     */
    public function searchAddressByCep(string $zipcode): string {
        try {
            $response = $this->json->unserialize($this->helper->request(preg_replace("/[^0-9]/", "", $zipcode)));
            $response['uf'] =  $this->getRegionId($response['uf']);
            return $this->json->serialize($response);
        } catch (Exception $e) {
            $this->helper->logger->debug(["error" => $e->getMessage()], true);
            return 'error';
        }
    }

    /**
     * @param string $uf
     * @return int
     */
    private function getRegionId(string $uf): int {
        return (int)$this->regionFactory->create()->loadByName($this->helper::STATE_BY_UF[$uf],  'BR')->getRegionId();
    }
}
