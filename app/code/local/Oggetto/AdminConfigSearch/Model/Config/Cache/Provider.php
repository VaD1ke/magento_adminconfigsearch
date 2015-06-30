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
 * Config cache provider
 *
 * @category   Oggetto
 * @package    Oggetto_AdminConfigSearch
 * @subpackage Model
 * @author     Vladislav Slesarenko <vslesarenko@oggettoweb.com>
 */
class Oggetto_AdminConfigSearch_Model_Config_Cache_Provider
{
    /**
     * Id for search caching
     */
    const SEARCH_CACHE_KEY = 'oggetto_adminconfigsearch';

    /**
     * Load search cache
     *
     * @return mixed
     */
    public function loadSearchCache()
    {
        return $this->_loadCache(self::SEARCH_CACHE_KEY);
    }

    /**
     * Save search cache
     *
     * @param mixed $data Data to save
     *
     * @return void
     */
    public function saveSearchCache($data)
    {
        $this->_saveCache($data, self::SEARCH_CACHE_KEY, [Mage_Core_Model_Config::CACHE_TAG]);
    }

    /**
     * Clear admin config cache
     *
     * @return void
     */
    public function clearAdminConfigCache()
    {
        $this->dispatchEvent('clean_cache_by_tags', array('tags' => array(
            Mage_Core_Model_Config::CACHE_TAG
        )));
    }

    /**
     * Clear block html cache
     *
     * @return void
     */
    public function clearBlockHtmlCache()
    {
        $this->dispatchEvent('clean_cache_by_tags', array('tags' => array(
            Mage_Core_Block_Abstract::CACHE_GROUP
        )));
    }

    /**
     * Load cache
     *
     * @param string $cacheKey Cache key
     *
     * @return mixed
     */
    protected function _loadCache($cacheKey)
    {
        return Mage::app()->loadCache($cacheKey);
    }

    /**
     * Save cache
     *
     * @param mixed  $data Data
     * @param string $id   ID
     * @param array  $tags Tags
     *
     * @return void
     */
    protected function _saveCache($data, $id, $tags)
    {
        Mage::app()->saveCache($data, $id, $tags);
    }

    /**
     * Dispatch event
     *
     * @param string $name Name
     * @param array  $data Data
     *
     * @return void
     */
    public function dispatchEvent($name, $data)
    {
        Mage::dispatchEvent($name, $data);
    }
}
