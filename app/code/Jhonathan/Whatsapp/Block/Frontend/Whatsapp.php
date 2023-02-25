<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Whatsapp
 */

namespace Jhonathan\Whatsapp\Block\Frontend;

use Jhonathan\Whatsapp\Helper\Data;
use Jhonathan\Whatsapp\Model\Config\Source\Image;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Asset\Repository;

use Magento\Framework\View\Element\Template;

/**
 * Class Whatsapp
 * @package Jhonathan\Whatsapp\Block\Frontend
 */
class Whatsapp extends Template
{

    /**
     * @var Data
     */
    private Data $helperData;

    /**
     * @var Repository
     */
    private Repository $assetRepo;

    /**
     * @var Json
     */
    private Json $json;

    /**
     * @param Template\Context $context
     * @param Data $helperData
     * @param Repository $assetRepo
     * @param Json $json
     * @param array $data
     */
    public function __construct(Template\Context $context, Data $helperData, Repository $assetRepo, Json $json, array $data = [])
    {
        parent::__construct($context, $data);
        $this->helperData = $helperData;
        $this->assetRepo = $assetRepo;
        $this->json = $json;
    }

    /**
     * @return string
     */
    public function getImgWhatsapp(): string
    {
        try {
            $mediaDirectory = $this->_filesystem->getDirectoryWrite(DirectoryList::MEDIA);
            $imagePath = Image::UPLOAD_DIR . '/' . $this->helperData->getContent('settings/image_upload');

            if ($mediaDirectory->isFile($imagePath)) {
                return $this->_urlBuilder->getBaseUrl(['_type' => DirectoryList::MEDIA]) . $imagePath;
            }

            return $this->assetRepo->getUrl($this->helperData->_getModuleName() . '::images/whatsapp.png');
        } catch (FileSystemException $e) {
            return $this->assetRepo->getUrl($this->helperData->_getModuleName() . '::images/whatsapp.png');
        }
    }

    /**
     * @param int $ddi
     * @param string $number
     * @return string
     */
    public function formatUrlWhatsapp(int $ddi, string $number): string
    {
        return "https://api.whatsapp.com/send?phone=" . $ddi . preg_replace("/[^0-9.]/", "", $number);
    }

    /**
     * @param int $hasSeveral
     * @return array|bool|float|int|mixed|string|null
     */
    public function getNumberPhone(int $hasSeveral): mixed
    {
        if ($hasSeveral) {
            return $this->json->unserialize($this->helperData->getContent('settings/multi_numbers'));
        } else {
            return $this->helperData->getContent('settings/number_whatsapp');
        }
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return 'style="' . $this->helperData->getContent('settings/icon_position') . ': 32px"';
    }

    /**
     * @return int
     */
    public function hasSeveralNumbers(): int
    {
        return (int)$this->helperData->getContent('settings/multiple_whatsapp');
    }
}
