<?php
/**
 * Oggetto Admin Config Search extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the Oggetto Admin Config Search module to newer versions in the future.
 * If you wish to customize the Oggetto Search module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_AdminConfigSearch
 * @copyright  Copyright (C) 2015 Oggetto Web (http://oggettoweb.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Config Controller for admin
 *
 * @category   Oggetto
 * @package    Oggetto_AdminConfigSearch
 * @subpackage controllers
 * @author     Vladislav Slesarenko <vslesarenko@oggettoweb.com>
 */
class Oggetto_AdminConfigSearch_Adminhtml_ConfigController extends Mage_Core_Controller_Front_Action
{
    /**
     * Switch config value
     *
     * @return void
     */
    public function switchAction()
    {
        $path = $this->getRequest()->getPost('path');

        /** @var Oggetto_Ajax_Model_Response $response */
        $response = Mage::getModel('ajax/response');

        /** @var Oggetto_AdminConfigSearch_Helper_Data $helper */
        $helper = Mage::helper('oggetto_adminconfigsearch');
        try {

            $value = $helper->switchConfigValue($path);
            $response->success()->setData([
                'path'   => $path,
                'value'  => $value,
                'status' => 'success'
            ]);

        } catch (Exception $e) {
            $response->error();
        }

        /** @var Oggetto_Ajax_Helper_Data $helperAjax */
        $helperAjax = Mage::helper('ajax');

        $helperAjax->sendResponse($response);
    }
}
