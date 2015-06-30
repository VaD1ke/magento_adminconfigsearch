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
 * Test class for observer
 *
 * @category   Oggetto
 * @package    Oggetto_AdminConfigSearch
 * @subpackage Test
 * @author     Vladislav Slesarenko <vslesarenko@oggettoweb.com>
 */
class Oggetto_AdminConfigSearch_Test_Model_Observer extends EcomDev_PHPUnit_Test_Case
{
    /**
     * Clears admin config cache after
     *
     * @return void
     */
    public function testClearsConfigCacheAfterChange()
    {
        /** @var Oggetto_AdminConfigSearch_Model_Observer $modelObserver */
        $modelObserver = Mage::getModel('oggetto_adminconfigsearch/observer');

        $modelProviderMock = $this->getModelMock(
            'oggetto_adminconfigsearch/config_cache_provider',
            ['clearAdminConfigCache', 'clearBlockHtmlCache']
        );

        $modelProviderMock->expects($this->once())
            ->method('clearAdminConfigCache');

        $modelProviderMock->expects($this->once())
            ->method('clearBlockHtmlCache');

        $this->replaceByMock('model', 'oggetto_adminconfigsearch/config_cache_provider', $modelProviderMock);

        $modelObserver->clearConfigCacheAfterChange();
    }

}
