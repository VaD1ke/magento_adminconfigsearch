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
 * Observer model
 *
 * @category   Oggetto
 * @package    Oggetto_AdminConfigSearch
 * @subpackage Model
 * @author     Vladislav Slesarenko <vslesarenko@oggettoweb.com>
 */
class Oggetto_AdminConfigSearch_Model_Observer
{
    /**
     * Clear admin config cache after change
     *
     * @return void
     */
    public function clearConfigCacheAfterChange()
    {
        /** @var Oggetto_AdminConfigSearch_Model_Config_Cache_Provider $cacheProvider */
        $cacheProvider = Mage::getModel('oggetto_adminconfigsearch/config_cache_provider');

        $cacheProvider->clearAdminConfigCache();
        $cacheProvider->clearBlockHtmlCache();
    }
}
