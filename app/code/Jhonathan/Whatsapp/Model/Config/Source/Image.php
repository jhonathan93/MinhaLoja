<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Whatsapp
 */

namespace Jhonathan\Whatsapp\Model\Config\Source;

use Magento\Config\Model\Config\Backend\File\RequestData\RequestDataInterface;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Config\Model\Config\Backend\Image as Update;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Config\Model\Config\Backend\File;
use Magento\Framework\Model\Context;
use Magento\Framework\Filesystem;
use Magento\Framework\Registry;

use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Image
 * @package Mageuni\Whatsapp\Model\Config\Source
 * @method getGroupId()
 * @method getField()
 */
class Image extends Update {

    /**
     * @var string
     */
    const UPLOAD_DIR = 'jhonathan/whatsapp';

    /**
     * @var int
     */
    protected $_maxFileSize = 2048;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param UploaderFactory $uploaderFactory
     * @param RequestDataInterface $requestData
     * @param Filesystem $filesystem
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(Context $context,
                                Registry $registry,
                                ScopeConfigInterface $config,
                                TypeListInterface $cacheTypeList,
                                UploaderFactory $uploaderFactory,
                                RequestDataInterface $requestData,
                                Filesystem $filesystem,
                                AbstractResource $resource = null,
                                AbstractDb $resourceCollection = null,
                                array $data = []) {
        parent::__construct($context, $registry, $config, $cacheTypeList, $uploaderFactory, $requestData, $filesystem, $resource, $resourceCollection, $data);
    }

    /**
     * @return string
     */
    protected function _getUploadDir(): string {
        return $this->_mediaDirectory->getAbsolutePath($this->_appendScopeInfo(self::UPLOAD_DIR));
    }

    /**
     * @return bool
     */
    protected function _addWhetherScopeInfo(): bool {
        return true;
    }

    /**
     * @return string[]
     */
    protected function _getAllowedExtensions(): array {
        return ['jpg', 'jpeg', 'gif', 'png', 'svg'];
    }

    /**
     * @return mixed|null
     */
    protected function _getTmpFileName(): mixed {
        if (isset($_FILES['groups'])) {
            $tmpName = $_FILES['groups']['tmp_name'][$this->getGroupId()]['fields'][$this->getField()]['value'];
        } else {
            $tmpName = is_array($this->getValue()) ? $this->getValue()['tmp_name'] : null;
        }
        return $tmpName;
    }

    /**
     * @return File|string
     */
    protected function _beforeSave(): string|File {
        try {
            $value = $this->getValue();
            $deleteFlag = is_array($value) && !empty($value['delete']);
            $fileTmpName = $this->_getTmpFileName();

            if ($this->getOldValue() && ($fileTmpName || $deleteFlag)) {
                $this->_mediaDirectory->delete(self::UPLOAD_DIR . '/' . $this->getOldValue());
            }

            return parent::beforeSave();
        } catch (LocalizedException | FileSystemException $e) {
            return $e->getMessage();
        }
    }
}
