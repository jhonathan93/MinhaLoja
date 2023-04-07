<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_CustomerBlock
 */

namespace Jhonathan\CustomerBlock\Setup\Patch\Data;

use Exception;
use Jhonathan\CustomerBlock\Model\Config\Source\Options;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\ResourceModel\Attribute;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Jhonathan\CustomerBlock\Helper\Data;

use Magento\Framework\Setup\Patch\PatchRevertableInterface;

/**
 * Class Blocked
 * @package Jhonathan\CustomerBlock\Setup\Patch\Data
 */
class Blocked implements DataPatchInterface, PatchRevertableInterface
{

    /**
     * @var string
     */
    const ATTRIBUTE_CODE = "is_blocked";

    private $customerSetup;

    /**
     * @var ModuleDataSetupInterface
     */
    private ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @var CustomerSetupFactory
     */
    private CustomerSetupFactory $customerSetupFactory;

    /**
     * @var Attribute
     */
    private Attribute $attributeResource;

    /**
     * @var SetFactory
     */
    private SetFactory $attributeSetFactory;

    /**
     * @var Data
     */
    private Data $helperData;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerSetupFactory $customerSetupFactory
     * @param Attribute $attributeResource
     * @param SetFactory $attributeSetFactory
     * @param Data $helperData
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        Attribute $attributeResource,
        SetFactory $attributeSetFactory,
        Data $helperData
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->customerSetup = $customerSetupFactory->create(['setup' => $moduleDataSetup]);
        $this->attributeResource = $attributeResource;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->helperData = $helperData;
    }

    /**
     * @return void
     */
    public function apply(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        try {
            $customerEntity = $this->customerSetup->getEavConfig()->getEntityType('customer');
            $attributeSetId = $customerEntity->getDefaultAttributeSetId();

            $attributeSet = $this->attributeSetFactory->create();
            $attributeGroupId = $attributeSet->getDefaultGroupId($customerEntity->getDefaultAttributeSetId());

            $this->customerSetup->addAttribute(Customer::ENTITY, self::ATTRIBUTE_CODE, [
                'type' => 'int',
                'label' => __('blocked'),
                'input' => 'select',
                'required' => false,
                'visible' => true,
                'user_defined' => true,
                'sort_order' => 15,
                'position' => 15,
                'system' => 0,
                'source' => Options::class,
                'default' => 0,
                'unique'=> false,
                'visible_on_front' => false,
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'is_filterable_in_grid' => true,
                'is_searchable_in_grid' => true,
            ]);

            $attribute = $this->customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, self::ATTRIBUTE_CODE)->addData([
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
                'used_in_forms' => ['adminhtml_customer'],
            ]);

            $this->attributeResource->save($attribute);
            $this->moduleDataSetup->getConnection()->endSetup();
        } catch (LocalizedException | Exception $e) {
            $this->helperData->logger(["error" => $e->getMessage()], true);
        }
    }

    /**
     * @return void
     */
    public function revert(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $customerSetup->removeAttribute(Customer::ENTITY, self::ATTRIBUTE_CODE);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases(): array
    {
        return [];
    }
}
