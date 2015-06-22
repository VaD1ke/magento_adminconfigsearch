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
 * Test class for config Controller for admin
 *
 * @category   Oggetto
 * @package    Oggetto_AdminConfigSearch
 * @subpackage Test
 * @author     Vladislav Slesarenko <vslesarenko@oggettoweb.com>
 */
class Oggetto_AdminConfigSearch_Test_Controller_Adminhtml_Config extends Oggetto_Phpunit_Test_Case_Controller_Adminhtml
{
    /**
     * Set up initial variables
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_setUpAdminSession();
    }


    /**
     * Switch config value and send success ajax
     *
     * @return void
     */
    public function testSwitchesConfigValueAndSendSuccessAjax()
    {
        $post  = ['path' => 'test', 'value' => 0];
        $value = 'value';

        $this->getRequest()->setMethod('POST');
        $this->getRequest()->setPost($post);

        $helperMock = $this->getHelperMock('oggetto_adminconfigsearch', ['switchConfigValue']);

        $helperMock->expects($this->once())
            ->method('switchConfigValue')
            ->with($post['path'], $post['value'])
            ->willReturn($value);

        $this->replaceByMock('helper', 'oggetto_adminconfigsearch', $helperMock);


        $ajaxResponseMock = $this->getModelMock('ajax/response', ['success', 'error', 'setData']);

        $ajaxResponseMock->expects($this->once())
            ->method('success')
            ->willReturnSelf();

        $ajaxResponseMock->expects($this->once())
            ->method('setData')
            ->with(['path' => $post['path'], 'value' => $value, 'status' => 'success'])
            ->willReturnSelf();

        $ajaxResponseMock->expects($this->never())
            ->method('error');

        $this->replaceByMock('model', 'ajax/response', $ajaxResponseMock);


        $helperAjaxMock = $this->getHelperMock('ajax', ['sendResponse']);

        $helperAjaxMock->expects($this->once())
            ->method('sendResponse')
            ->with($ajaxResponseMock);

        $this->replaceByMock('helper', 'ajax', $helperAjaxMock);


        $this->dispatch('adminhtml/config/switch');

        $this->_assertRequestsDispatchForwardAndController('switch');
    }

    /**
     * Throw exception when switching config value and send error ajax
     *
     * @return void
     */
    public function testThrowsExceptionWhenSwitchConfigValueAndSendErrorAjax()
    {
        $post  = ['path' => 'test', 'value' => 0];

        $this->getRequest()->setMethod('POST');
        $this->getRequest()->setPost($post);

        $helperMock = $this->getHelperMock('oggetto_adminconfigsearch', ['switchConfigValue']);

        $helperMock->expects($this->once())
            ->method('switchConfigValue')
            ->with($post['path'])
            ->willThrowException(new Exception);

        $this->replaceByMock('helper', 'oggetto_adminconfigsearch', $helperMock);


        $ajaxResponseMock = $this->getModelMock('ajax/response', ['success', 'error', 'setData']);

        $ajaxResponseMock->expects($this->never())
            ->method('success')
            ->willReturnSelf();

        $ajaxResponseMock->expects($this->never())
            ->method('setData');

        $ajaxResponseMock->expects($this->once())
            ->method('error');

        $this->replaceByMock('model', 'ajax/response', $ajaxResponseMock);


        $helperAjaxMock = $this->getHelperMock('ajax', ['sendResponse']);

        $helperAjaxMock->expects($this->once())
            ->method('sendResponse')
            ->with($ajaxResponseMock);

        $this->replaceByMock('helper', 'ajax', $helperAjaxMock);


        $this->dispatch('adminhtml/config/switch');

        $this->_assertRequestsDispatchForwardAndController('switch');
    }

    /**
     * Case for asserting Request dispatched, not forwarded, Controller module, name and action for oggetto_faq module
     *
     * @param string $actionName Name of action
     *
     * @return void
     */
    protected function _assertRequestsDispatchForwardAndController($actionName)
    {
        $this->assertRequestDispatched();
        $this->assertRequestNotForwarded();
        $this->assertRequestControllerModule('Oggetto_AdminConfigSearch_Adminhtml');

        $this->assertRequestRouteName('adminhtml');
        $this->assertRequestControllerName('config');
        $this->assertRequestActionName($actionName);
    }
}
