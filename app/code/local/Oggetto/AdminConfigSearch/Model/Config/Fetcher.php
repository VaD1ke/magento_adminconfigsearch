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
 * Config fetcher
 *
 * @category   Oggetto
 * @package    Oggetto_AdminConfigSearch
 * @subpackage Model
 * @author     Vladislav Slesarenko <vslesarenko@oggettoweb.com>
 */
class Oggetto_AdminConfigSearch_Model_Config_Fetcher
{
    /**
     * Get all config fields
     *
     * @return array
     */
    public function getAllConfigFields()
    {
        $sections = $this->_getConfigSectionsArray();

        /** @var Oggetto_AdminConfigSearch_Helper_Data $helper */
        $helper = Mage::helper('oggetto_adminconfigsearch');

        $configArray = [];
        /** @var Mage_Core_Model_Config_Element $section */
        foreach ($sections as $section) {
            $groups = (array) $section->groups;
            $urlParams = ['section' => $section->getName()];
            /** @var Mage_Core_Model_Config_Element $group */
            foreach ($groups as $group) {
                $groupLabel = strval($group->label);
                if ($groupLabel !== '') {
                    $fields = (array) $group->fields;

                    foreach ($fields as $field) {

                        $fieldLabel = strval($field->label);
                        if ($fieldLabel !== '') {
                            $urlParams['group'] = $section->getName() . '_' . $group->getName();
                            $urlParams['field'] = $field->getName();
                            $urlParams['key']   = null;

                            $sourceModel     = strval($field->source_model);
                            $breadcrumbs     = $helper->__(strval($section->label)) . "->" . $helper->__($groupLabel);
                            $path            = $section->getName() . '/' . $group->getName() .  '/' . $field->getName();
                            $value           = htmlentities($this->getConfigFieldValue($path));
                            $comment         = strval($field->comment);

                            $valueFromSource = $helper->__(
                                $this->_getConfigValueFromSourceModel($sourceModel, $value)
                            );

                            $configArray[] = [
                                'label' => $fieldLabel,
                                'url'   => $this->getUrlForConfigField($urlParams),
                                'path'  => $path,
                                'field' => $value,
                                'value' => $valueFromSource,
                                'comment'            => $comment,
                                'commentTranslation' => $helper->__($comment),
                                'switchable'         => $this->isFieldTypeSwitchable($sourceModel),
                                'translations'       => $helper->__($fieldLabel),
                                'breadcrumbs'        => $breadcrumbs
                            ];
                        }

                    }
                }
            }
        }
        return $configArray;
    }

    /**
     * Get URL for config field
     *
     * @param array $params URL parameters
     *
     * @return mixed
     */
    public function getUrlForConfigField($params)
    {
        /** @var Mage_Adminhtml_Helper_Data $helper */
        $helper = Mage::helper('adminhtml');

        return $helper->getUrl('adminhtml/system_config/edit', $params);
    }

    /**
     * Get config field value
     *
     * @param string $path Path to config field
     *
     * @return mixed
     */
    public function getConfigFieldValue($path)
    {
        /** @var Oggetto_AdminConfigSearch_Helper_Data $helper */
        $helper = Mage::helper('oggetto_adminconfigsearch');

        if ($path == 'design/package/name') {
            return $helper->getConfigFieldValue($path, Mage::app()->getDefaultStoreView()->getCode());
        }
        return $helper->getConfigFieldValue($path);
    }

    /**
     * Get switchable field type
     *
     * @param string $model Field source model
     *
     * @return string
     */
    public function isFieldTypeSwitchable($model)
    {
        if ($model == 'adminhtml/system_config_source_yesno'
            || $model == 'adminhtml/system_config_source_enabledisable') {
            return true;
        }

        return false;
    }

    /**
     * Get config field value from source model
     *
     * @param string $sourceModel Source model
     * @param string $neededValue Value
     *
     * @return mixed
     */
    protected function _getConfigValueFromSourceModel($sourceModel, $neededValue)
    {
        $neededValuesArray  = explode(',', $neededValue);
        $returnedFieldValue = $neededValue;

        if ($sourceModel == 'adminhtml/system_config_source_design_robots') {
            return $neededValue;
        }

        if ($sourceModel !== '') {
            $valuesArray = [];

            $model = Mage::getModel($sourceModel);

            if (method_exists($model, 'toOptionArray')) {
                $optionArray = $model->toOptionArray(true);

                foreach ($optionArray as $option) {
                    if (isset($option['value']) && in_array($option['value'], $neededValuesArray)) {
                        if ($option['label'] == Mage::helper('oggetto_adminconfigsearch')->__('--Please Select--')) {
                            $valuesArray[] = Mage::helper('oggetto_adminconfigsearch')->__('Not set');
                        } else {
                            $valuesArray[] = $option['label'];
                        }
                    }
                }
                $returnedFieldValue = implode(', ', $valuesArray);
            } else {
                $modelArray = explode('::', $sourceModel);
                $model = Mage::getModel($modelArray[0]);
                if (is_callable($modelArray[0], $modelArray[1])) {
                    $optionArray = $model->$modelArray[1]();

                    foreach ($optionArray as $label => $option) {
                        if (in_array($label, $neededValuesArray)) {
                            $valuesArray[] = $option;
                        }
                    }
                    $returnedFieldValue = implode(', ', $valuesArray);
                }
            }
        }

        if ($returnedFieldValue == '') {
            $returnedFieldValue = Mage::helper('oggetto_adminconfigsearch')->__('Not set');
        }

        return $returnedFieldValue;
    }

    /**
     * Get system config sections array
     *
     * @return array
     */
    protected function _getConfigSectionsArray()
    {
        $config = Mage::getConfig()->loadModulesConfiguration('system.xml');
        $sections = (array)$config->getNode('sections')->children();

        return $sections;
    }
}
