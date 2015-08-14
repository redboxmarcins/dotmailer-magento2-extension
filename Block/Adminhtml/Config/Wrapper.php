<?php

namespace Dotdigitalgroup\Email\Block\Adminhtml\Config;

class Wrapper extends \Magento\Config\Block\System\Config\Form\Field
{

	/**
	 * Ajax Validate the api credentials.
	 */
	protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
	{
		$url = $this->getUrl('ddg_automation/connector/ajaxvalidation');

        $element->setData('after_element_html',
            "<script type='text/javascript'>
			require(['prototype', 'domReady'], function($){
            (function () {
	            var elem = document.getElementById('connector_api_credentials_api_password');

	            function onChange() {
	            	var api_username   = $('connector_api_credentials_api_username');
                    var api_password   = $('connector_api_credentials_api_password');
                    console.log(api_username);
                    console.log(api_password);
                    var reloadurl  = '{$url}';
                    var encoded = btoa(api_password.value);
                    if(api_username.value && api_password.value){
                        new Ajax.Request(reloadurl, {
                            method: 'post',
                            parameters: {'api_username' : api_username.value, 'api_password' : encoded},
                            onComplete: function(transport) {
                                Element.hide('loadingmask');
                                if(transport.responseText == '\"Credentials Valid.\"'){
                                    api_username.setStyle({
                                        fontWeight: 'bold',
                                        color:  'green' ,
                                        background: 'transparent url(\"" . $this->getSkinUrl('images/success_msg_icon.gif') . "\") no-repeat right center'
                                    })
                                }else{
                                    api_username.setStyle({
                                        fontWeight: 'bold',
                                        color:  'red',
                                        background: 'transparent url(\"" . $this->getSkinUrl('images/error_msg_icon.gif') . "\") no-repeat right center'
                                    });
                                }
                            }
                        });
                    }
                    return false;
	            }
	            elem.addEventListener('change', onChange);
	        })();
	        });
			</script>");

		return parent::_getElementHtml($element);

	}
}