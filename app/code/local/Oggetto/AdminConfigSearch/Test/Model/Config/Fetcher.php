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
 * Test class for vonfig fetcher
 *
 * @category   Oggetto
 * @package    Oggetto_AdminConfigSearch
 * @subpackage Test
 * @author     Vladislav Slesarenko <vslesarenko@oggettoweb.com>
 */
class Oggetto_AdminConfigSearch_Test_Model_Config_Fetcher extends EcomDev_PHPUnit_Test_Case
{
    /**
     * Fetcher model
     *
     * @var Oggetto_AdminConfigSearch_Model_Config_Fetcher
     */
    protected $_fetcherModel;

    /**
     * Set up initial variables
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_fetcherModel = Mage::getModel('oggetto_adminconfigsearch/config_fetcher');
    }

    /**
     * Return empty config array if sections array is empty
     *
     * @return void
     */
    public function testReturnsEmptyConfigArrayIfSectionsArrayIsEmpty()
    {
        $modelFetcherMock = $this->getModelMock(
            'oggetto_adminconfigsearch/config_fetcher', ['_getConfigSectionsArray']
        );

        $modelFetcherMock->expects($this->once())
            ->method('_getConfigSectionsArray')
            ->willReturn([]);

        $this->replaceByMock('model', 'oggetto_adminconfigsearch/config_fetcher', $modelFetcherMock);

        $this->assertEquals([], $modelFetcherMock->getAllConfigFields());
    }

    /**
     * Return URL for adminhtml helper for config field
     *
     * @return void
     */
    public function testReturnsUrlFromAdminhtmlHelperForConfigField()
    {
        $testUrl = 'url';
        $urlParams = ['field' => 'test'];

        $helperAdminhtmlMock = $this->getMockBuilder('adminhtml')->disableOriginalConstructor()
            ->setMethods(['getUrl'])->getMock();

        $helperAdminhtmlMock->expects($this->once())
            ->method('getUrl')
            ->with('adminhtml/system_config/edit', $urlParams)
            ->willReturn($testUrl);

        $this->replaceByMock('helper', 'adminhtml', $helperAdminhtmlMock);

        $this->assertEquals($testUrl, $this->_fetcherModel->getUrlForConfigField($urlParams));
    }

    /**
     * Return config field value from helper data
     *
     * @return void
     */
    public function testReturnsConfigFieldValueFromHelperData()
    {
        $path  = 'path';
        $value = 'value';

        $helperDataMock = $this->getHelperMock('oggetto_adminconfigsearch', ['getConfigFieldValue']);

        $helperDataMock->expects($this->once())
            ->method('getConfigFieldValue')
            ->with($path)
            ->willReturn($value);

        $this->replaceByMock('helper', 'oggetto_adminconfigsearch', $helperDataMock);

        $this->assertEquals($value, $this->_fetcherModel->getConfigFieldValue($path));
    }

    /**
     * Return switchable status if model is yesno
     *
     * @param array $status Status
     * @param array $model  Model
     *
     * @return void
     *
     * @dataProvider dataProvider
     */
    public function testReturnsSwitchableStatusIfModelIsYesNoOrEnableDisable($status, $model)
    {
        $this->assertEquals(
            $this->expected($status)->getResult(), $this->_fetcherModel->isFieldTypeSwitchable($model['model'])
        );
    }

}
