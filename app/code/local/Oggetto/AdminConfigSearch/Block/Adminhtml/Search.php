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
 * Block class for search system config fields
 *
 * @category   Oggetto
 * @package    Oggetto_AdminConfigSearch
 * @subpackage Block
 * @author     Vladislav Slesarenko <vslesarenko@oggettoweb.com>
 */
class Oggetto_AdminConfigSearch_Block_Adminhtml_Search extends Mage_Adminhtml_Block_Page_Menu
{
    /**
     * Get config array
     *
     * @return string
     */
    public function getConfigArray()
    {
        /** @var Oggetto_AdminConfigSearch_Helper_Data $helper */
        $helper = Mage::helper('oggetto_adminconfigsearch');
        return $helper->getJsonEncodedSystemConfigArray();
    }

    /**
     * Get URL for field value switch
     *
     * @return mixed
     */
    public function getUrlForFieldValueSwitch()
    {
        /** @var Mage_Adminhtml_Helper_Data $helper */
        $helper = Mage::helper('adminhtml');

        return $helper->getUrl('oggetto_adminconfigsearch/config/switch');
    }
}
