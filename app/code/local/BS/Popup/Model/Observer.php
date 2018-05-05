<?php

class BS_Popup_Model_Observer
{
    public function loadPopup($observer){
        $misc = Mage::helper('bs_misc');
        $block = $observer->getBlock();
        $blockType = $block->getType();

        //Mage::log($blockType);
        if($blockType == 'adminhtml/dashboard'){
            $transport          = $observer->getTransport();
            $html = $transport->getHtml();

            $script = $this->alterScriptAfterToHtml();

            $html = $html . $script;
            $transport->setHtml($html);
        }

    }



    public function alterScriptAfterToHtml(){

        $content = '';

        //expired works
        $works = Mage::helper('bs_nrw')->getExpireWorks();
        $content .= $works;

        //expired suppliers
        $suppliers = Mage::helper('bs_sup')->getExpireSups();
        $content .= $suppliers;

        //expired tool suppliers
        $tosuppliers = Mage::helper('bs_tosup')->getExpireTosups();
        $content .= $tosuppliers;

        //expired client
        $clients = Mage::helper('bs_client')->getExpireClients();
        $content .= $clients;

        //expired authority
        $auts = Mage::helper('bs_aut')->getExpireAuts();
        $content .= $auts;

        $html = '';
        if($content != ''){
            $html = '<script type="text/javascript">
                    //<![CDATA[
                    var messagePopupClosed = false;
                    function openMessagePopup() {
                        var height = $(\'html-body\').getHeight();
                        $(\'message-popup-window-mask\').setStyle({\'height\':height+\'px\'});
                        toggleSelectsUnderBlock($(\'message-popup-window-mask\'), false);
                        Element.show(\'message-popup-window-mask\');
                        $(\'message-popup-window\').addClassName(\'show\');
                    }
                
                    function closeMessagePopup() {
                        toggleSelectsUnderBlock($(\'message-popup-window-mask\'), true);
                        Element.hide(\'message-popup-window-mask\');
                        $(\'message-popup-window\').removeClassName(\'show\');
                        messagePopupClosed = true;
                    }
                
                    function markAsRead(news_id){
                        new Ajax.Request(\'\', {
                            method : \'post\',
                            parameters: {
                                \'id\'   : news_id
                            },
                            onSuccess : function(transport){
                                try{
                                    closeMessagePopup();
                
                                    response = eval(\'(\' + transport.responseText + \')\');
                
                                } catch (e) {
                                    response = {};
                                }
                
                            },
                            onFailure : function(transport) {
                                alert(\'An unknown error occurred!\')
                            }
                        });
                    }
                
                    Event.observe(window, \'load\', openMessagePopup);
                    Event.observe(window, \'keyup\', function(evt) {
                        if(messagePopupClosed) return;
                        var code;
                        if (evt.keyCode) code = evt.keyCode;
                        else if (evt.which) code = evt.which;
                        if (code == Event.KEY_ESC) {
                            closeMessagePopup();
                        }
                    });
                    //]]>
                </script>
                <div id="message-popup-window-mask" style="display:none;"></div>
                <div id="message-popup-window" class="message-popup">
                    <div class="message-popup-head">
                        <a href="#" onclick="closeMessagePopup(); return false;" title="Close"><span>CLOSE</span></a>
                        <h2>ALERT!</h2>
                    </div>
                    <div class="message-popup-content">
                        <div class="message">
                          '.$content.'
                        </div>
                        
                    </div>
                </div>';

        }


        return $html;
    }


}
