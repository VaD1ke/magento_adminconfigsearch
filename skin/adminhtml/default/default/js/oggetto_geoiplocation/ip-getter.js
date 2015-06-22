/**
 * Oggetto Geo IP Location extension for Magento
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
 * the Oggetto Geo IP Location module to newer versions in the future.
 * If you wish to customize the Oggetto Search module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_GeoIpLocation
 * @copyright  Copyright (C) 2015 Oggetto Web (http://oggettoweb.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
"use strict";
jQuery(function($) {
        $.ajax({
            url: 'http://ip-api.com/json',
            dataType: 'json',
            success: function(data) {
                console.log(data.countryCode + '-' + data.region + ' : ' + data.city);

                //onoffswitch.next('.preloader').remove();
                //if (data.status == 'success') {
                //    ConfigSingleton.setConfigValue(data.path, data.value);
                //    checkbox.prop('checked', data.value == true);
                //}
                //else {
                //    label.addClass('error');
                //    setTimeout( function() { label.removeClass('error'); }, 1500);
                //}
            }
        });
});