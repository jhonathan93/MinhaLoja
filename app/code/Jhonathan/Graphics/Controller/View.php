<?php

/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Graphics
 */

namespace Jhonathan\Graphics\Controller;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class View
 * @package Jhonathan\Graphics\Controller
 */
class View implements ActionInterface {

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute() {
        return $this->resultPageFactory->create();
    }
}
