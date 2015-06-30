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
 * Test class for config cache provider
 *
 * @category   Oggetto
 * @package    Oggetto_AdminConfigSearch
 * @subpackage Test
 * @author     Vladislav Slesarenko <vslesarenko@oggettoweb.com>
 */
class Oggetto_AdminConfigSearch_Test_Model_Config_Cache_Provider extends EcomDev_PHPUnit_Test_Case
{
    /**
     * Search cache key
     *
     * @var string
     */
    protected $_searchCacheKey;

    /**
     * Set up initial variables
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_searchCacheKey = Oggetto_AdminConfigSearch_Model_Config_Cache_Provider::SEARCH_CACHE_KEY;
    }


    /**
     * Return loaded search cache
     *
     * @return void
     */
    public function testReturnsLoadedSearchCache()
    {
        $cache = ['test'];

        $modelProviderMock = $this->getModelMock('oggetto_adminconfigsearch/config_cache_provider', ['_loadCache']);

        $modelProviderMock->expects($this->once())
            ->method('_loadCache')
            ->with($this->_searchCacheKey)
            ->willReturn($cache);

        $this->replaceByMock('model', 'oggetto_adminconfigsearch/config_cache_provider', $modelProviderMock);

        $this->assertEquals($cache, $modelProviderMock->loadSearchCache());
    }

    /**
     * Save search cache with established data
     *
     * @return void
     */
    public function testSavesSearchCacheWithEstablishedData()
    {
        $data = ['test'];

        $modelProviderMock = $this->getModelMock('oggetto_adminconfigsearch/config_cache_provider', ['_saveCache']);

        $modelProviderMock->expects($this->once())
            ->method('_saveCache')
            ->with($data, $this->_searchCacheKey, [Mage_Core_Model_Config::CACHE_TAG]);

        $this->replaceByMock('model', 'oggetto_adminconfigsearch/config_cache_provider', $modelProviderMock);

        $modelProviderMock->saveSearchCache($data);
    }

    /**
     * Clear admin config cache by dispatching clean cache event
     *
     * @return void
     */
    public function testClearsAdminConfigCacheByDispatchingCleanCacheEvent()
    {
        $modelProviderMock = $this->getModelMock('oggetto_adminconfigsearch/config_cache_provider', ['dispatchEvent']);

        $modelProviderMock->expects($this->once())
            ->method('dispatchEvent')
            ->with('clean_cache_by_tags', array('tags' => array(Mage_Core_Model_Config::CACHE_TAG)));

        $this->replaceByMock('model', 'oggetto_adminconfigsearch/config_cache_provider', $modelProviderMock);

        $modelProviderMock->clearAdminConfigCache();
    }

    /**
     * Clear admin config cache by dispatching clean cache event
     *
     * @return void
     */
    public function testClearsBlockHtmlCacheByDispatchingCleanCacheEvent()
    {
        $modelProviderMock = $this->getModelMock('oggetto_adminconfigsearch/config_cache_provider', ['dispatchEvent']);

        $modelProviderMock->expects($this->once())
            ->method('dispatchEvent')
            ->with('clean_cache_by_tags', array('tags' => array(Mage_Core_Block_Abstract::CACHE_GROUP)));

        $this->replaceByMock('model', 'oggetto_adminconfigsearch/config_cache_provider', $modelProviderMock);

        $modelProviderMock->clearBlockHtmlCache();
    }

    /**
     * Check event dispatch with established event name
     *
     * @return void
     */
    public function testCheckEventDispatchWithEstablishedEventName()
    {
        $eventName = 'clean_cache_by_tags';

        /** @var Oggetto_AdminConfigSearch_Model_Config_Cache_Provider $provider */
        $provider = Mage::getModel('oggetto_adminconfigsearch/config_cache_provider');

        $provider->dispatchEvent($eventName, []);

        $this->assertEventDispatched($eventName);
    }
}
