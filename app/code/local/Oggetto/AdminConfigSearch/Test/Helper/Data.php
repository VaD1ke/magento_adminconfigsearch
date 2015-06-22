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
 * Helper Data test class
 *
 * @category   Oggetto
 * @package    Oggetto_AdminConfigSearch
 * @subpackage Test
 * @author     Vladislav Slesarenko <vslesarenko@oggettoweb.com>
 */
class Oggetto_AdminConfigSearch_Test_Helper_Data extends EcomDev_PHPUnit_Test_Case
{
    /**
     * Helper Data
     *
     * @var Oggetto_AdminConfigSearch_Helper_Data
     */
    protected $_helper;

    /**
     * Set Up initial variables
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_helper = Mage::helper('oggetto_adminconfigsearch');
    }

    /**
     * Return expected switched values
     *
     * @return void
     */
    public function testReturnsExpectedSwitchedBoolValues()
    {
        $this->assertEquals(false, $this->_helper->switchValue(true));
        $this->assertEquals(true, $this->_helper->switchValue(false));
    }

    /**
     * Return json encoded system config array with adding slashes
     *
     * @return void
     */
    public function testReturnsJsonEncodedSystemConfigArrayWithAddingSlashes()
    {
        $configArray = ['label' => 'test'];
        $jsonConfig  = '{"label":"test"}';
        $addSlashes  = '{"label\'":"test"}';

        $this->replaceByMock('singleton', 'core/session', $this->getModelMock('core/session', ['start']));

        $modelFetcherMock = $this->getModelMock('oggetto_adminconfigsearch/config_fetcher', ['getAllConfigFields']);

        $modelFetcherMock->expects($this->once())
            ->method('getAllConfigFields')
            ->willReturn($configArray);

        $this->replaceByMock('model', 'oggetto_adminconfigsearch/config_fetcher', $modelFetcherMock);


        $helperCoreMock = $this->getHelperMock('core', ['jsonEncode']);

        $helperCoreMock->expects($this->once())
            ->method('jsonEncode')
            ->with($configArray)
            ->willReturn($jsonConfig);

        $this->replaceByMock('helper', 'core', $helperCoreMock);

        $helperDataMock = $this->getHelperMock('oggetto_adminconfigsearch', ['_addSlashes']);

        $helperDataMock->expects($this->once())
            ->method('_addSlashes')
            ->with($jsonConfig)
            ->willReturn($addSlashes);

        $this->replaceByMock('helper', 'oggetto_adminconfigsearch', $helperDataMock);

        $this->assertEquals($addSlashes, $helperDataMock->getJsonEncodedSystemConfigArray());
    }

    /**
     * Switch store config field value with established path
     *
     * @return void
     */
    public function testSwitchesStoreConfigFieldValueWithEstablishedPath()
    {
        $path          = 'path';
        $value         = '0';
        $switchedValue = '1';

        $helperMock = $this->getHelperMock('oggetto_adminconfigsearch', ['switchValue', 'getConfigFieldValue']);

        $helperMock->expects($this->once())
            ->method('getConfigFieldValue')
            ->with($path)
            ->willReturn($value);

        $helperMock->expects($this->once())
            ->method('switchValue')
            ->with($value)
            ->willReturn($switchedValue);

        $this->replaceByMock('helper', 'oggetto_adminconfigsearch', $helperMock);


        $modelConfigMock = $this->getModelMock('core/config', ['saveConfig']);

        $modelConfigMock->expects($this->once())
            ->method('saveConfig')
            ->with($path, $switchedValue);

        $this->replaceByMock('model', 'core/config', $modelConfigMock);


        $modelProviderMock = $this->getModelMock(
                'oggetto_adminconfigsearch/config_cache_provider',
                ['clearAdminConfigCache']
        );

        $modelProviderMock->expects($this->once())
            ->method('clearAdminConfigCache');

        $this->replaceByMock('model', 'oggetto_adminconfigsearch/config_cache_provider', $modelProviderMock);


        $this->assertEquals($switchedValue, $helperMock->switchConfigValue($path, $value));
    }

    /**
     * Switch store config field value with established path
     *
     * @return void
     */
    public function testReturnsValueIfStoreConfigFieldValueEqualsValueToSwitch()
    {
        $path          = 'path';
        $value         = '0';
        $switchedValue = '1';

        $helperMock = $this->getHelperMock('oggetto_adminconfigsearch', ['switchValue', 'getConfigFieldValue']);

        $helperMock->expects($this->once())
            ->method('getConfigFieldValue')
            ->with($path)
            ->willReturn($switchedValue);

        $helperMock->expects($this->once())
            ->method('switchValue')
            ->with($value)
            ->willReturn($switchedValue);

        $this->replaceByMock('helper', 'oggetto_adminconfigsearch', $helperMock);


        $modelConfigMock = $this->getModelMock('core/config', ['saveConfig']);

        $modelConfigMock->expects($this->never())
            ->method('saveConfig');

        $this->replaceByMock('model', 'core/config', $modelConfigMock);


        $modelProviderMock = $this->getModelMock(
            'oggetto_adminconfigsearch/config_cache_provider',
            ['clearAdminConfigCache']
        );

        $modelProviderMock->expects($this->never())
            ->method('clearAdminConfigCache');

        $this->replaceByMock('model', 'oggetto_adminconfigsearch/config_cache_provider', $modelProviderMock);


        $this->assertEquals($switchedValue, $helperMock->switchConfigValue($path, $value));
    }

    /**
     * Return store config field value with established path
     *
     * @return void
     *
     * @loadFixture
     */
    public function testReturnsStoreConfigFieldValueWithEstablishedPath()
    {
        $path  = 'system/smtp/disable';
        $value = '0';

        $this->assertEquals($value, $this->_helper->getConfigFieldValue($path));
    }
}
