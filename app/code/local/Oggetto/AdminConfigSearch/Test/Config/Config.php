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
 * If you wish to customize the Oggetto Yandex Prices module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_AdminConfigSearch
 * @copyright  Copyright (C) 2015 Oggetto Web (http://oggettoweb.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Config test class for config.xml
 *
 * @category   Oggetto
 * @package    Oggetto_AdminConfigSearch
 * @subpackage Test
 * @author     Vladislav Slesarenko <vslesarenko@oggettoweb.com>
 */
class Oggetto_AdminConfigSearch_Test_Config_Config extends EcomDev_PHPUnit_Test_Case_Config
{
    /**
     * Test class aliases for Model, Resource and Helper
     *
     * @return void
     */
    public function testChecksClassAliasesForModelResourceAndHelper()
    {
        $this->assertHelperAlias('oggetto_adminconfigsearch', 'Oggetto_AdminConfigSearch_Helper_Data');
    }

    /**
     * Test codePool and version of module
     *
     * @return void
     */
    public function testChecksModuleCodePoolAndVersion()
    {
        $this->assertModuleCodePool('local', 'oggetto_adminconfigsearch');
        $this->assertModuleVersion('0.1.0');
    }
}
