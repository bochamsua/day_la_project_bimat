<?php

class BS_Observation_Model_Observer
{

    protected $_openStatuses = [
        //object and its status that object can be edit by owner
        'car'   => [0],
        'drr'   => [0],
        'ir'    => [0],
        'ncr'   => [0],
        'qr'    => [0],
        //'hira'    => [0]
    ];

    protected $_hasCloseButton = [
        //object and its status that object has close button
        //this button is available for OWNER only
        //we need to specify what fields need to be saved when close, like proof of close
        'car'   => [
            'status' => [1,4],
            'close'    => [
                'status' => 2,//new status of close action
                'fields' => 'remark,ncausegroup_id,ncause_id,close_date'
                //values will be taken from POST object
            ],
        ],
        'drr'   => [
            'status' => [1,4],
            'close'    => [
                'status' => 2,//new status of close action
                'fields' => 'remark,res_date'
                //values will be taken from POST object
            ],
        ],
        'ncr'   => [
            'status' => [2,4,7,8,9],
            'close'    => [
                'status' => 3,//new status of close action
                'fields' => 'remark,ncausegroup_id,ncause_id,res_date,remark_text'
                //values will be taken from POST object
            ],
        ],
        'qr'    => [
            'status' => [2,4],
            'close'    => [
                'status' => 3,//new status of close action
                'fields' => 'remark,res_date'
                //values will be taken from POST object
            ],
        ],
        'nrw'    => [
            'status' => [1,4],
            'close'    => [
                'status' => 3,//new status of close action
                'fields' => 'close_date,remark_text'
                //values will be taken from POST object
            ],
            'remove' => [//buttons to be removed when object is in closed status
                'save',
                'delete'
            ]
        ],
        'coa'    => [
            'status' => [0,2],
            'close'    => [
                'status' => 1,//new status of close action
                'fields' => 'close_date,coa_source'
                //values will be taken from POST object
            ],
            'remove' => [//buttons to be removed when object is in closed status
                'save',
                'delete'
            ]
        ],
        /*'mor'    => [
            'status' => [0],//status of object that Close button will be avaible
            'close'    => [
                'status' => 1,//new status of close action
                'fields' => 'close_date'
                //fields will be saved when closing
            ],
            'remove' => [//buttons to be removed when object is in closed status
                'save',
                'delete'
            ],
        ]*/
    ];

    protected $_hasSubmitButton = [
        //object and its status that object has close button
        //this button is available for OWNER only
        'ir'    => [
            'status'    => [0],//status that buttons are available
            'submit' => [
                'status' => 1,
                'fields' => 'all',
                'require'   => ''
            ],//new status of submit action
        ],
        'ncr'   => [
            'status'    => [0],//status that buttons are available
            'submit' => [
                'status' => 1,
                'fields' => 'all',
                'require'   => 'due_date'
            ],//new status of submit action
        ],
        'qr'    => [
            'status'    => [0],//status that buttons are available
            'submit' => [
                'status' => 1,
                'fields' => 'all',
                'require'   => 'due_date'
            ],//new status of submit action
        ]
    ];

    protected $_hasFinishButton = [
        //object and its status that object has close button
        //this button is available for OWNER only
        'car'    => [
            'status'    => [0],//status that buttons are available
            'finish' => [
                'status' => 1,
                'fields' => 'all',
                'require'   => 'due_date'
            ],//new status of submit action
        ],
        'drr'   => [
            'status'    => [0],//status that buttons are available
            'finish' => [
                'status' => 1,
                'fields' => 'all',
                'require'   => 'due_date'
            ],//new status of submit action
        ]
    ];

    protected $_hasAddNewButton = [
        'sur' => 1
    ];

    protected $_hasAcceptRejectButtons = [
        //object and its status that object has accept/reject buttons
        //those buttons are available for MANAGER only
        //we need to specify what fields need to be saved when reject, normally reject_reason?
        'ir'   => [
            'status'    => [1],//status that buttons are available
            'accept' => [//fields will be saved when accept
                'status' => 2,
                'fields' => '',
                'date'   => 'report_date',//which date fields will be automatically updated
            ],//new status of accept action
            'reject'    => [
                'status' => 0,//new status of reject action
                'fields' => 'reject_reason',
                 //values will be taken from POST object
            ],

        ],
        'ncr'   => [
            'status'    => [1],//status that buttons are available
            'accept' => [
                'status' => 2,
                'fields' => '',
                'date'   => 'report_date',//which date fields will be automatically updated
            ],//new status of accept action
            'reject'    => [
                'status' => 0,//new status of reject action
                'fields' => 'reject_reason',
                //values will be taken from POST object
            ],
        ],
        'qr'    => [
            'status'    => [1],//status that buttons are available
            'accept' => [
                'status' => 2,
                'fields' => '',
                'date'   => 'report_date',//which date fields will be automatically updated
            ],//new status of accept action
            'reject'    => [
                'status' => 0,//new status of reject action
                'fields' => 'reject_reason',
                //values will be taken from POST object
            ],
        ],
        'hira'    => [
            'status'    => [0],//status that buttons are available
            'accept' => [
                'status' => 1,//new status of accept action
                'fields' => ''
            ],
            'reject'    => [
                'status' => 0,//new status of reject action
                'fields' => '',
                //values will be taken from POST object
            ],
        ],
        'mor'    => [
            'status'    => [0],//status that buttons are available
            'accept' => [
                'status' => 1,//new status of accept action
                'fields' => ''
            ],
            'reject'    => [
                'status' => 0,//new status of reject action
                'fields' => '',
                //values will be taken from POST object
            ],
            'remove' => [//buttons to be removed when object is in accepted status
                'save',
                'delete'
            ],
        ],
        'meda'    => [
            'status'    => [0],//status that buttons are available
            'accept' => [
                'status' => 1,//new status of accept action
                'fields' => ''
            ],
            'reject'    => [
                'status' => 0,//new status of reject action
                'fields' => '',
                //values will be taken from POST object
            ],
            'remove' => [//buttons to be removed when object is in accepted status
                'save',
                'delete'
            ],
        ],
        'nrw'    => [
            'status'    => [0],//status that buttons are available
            'accept' => [
                'status' => 1,//new status of accept action
                'fields' => ''
            ],
            'reject'    => [
                'status' => 2,//new status of reject action
                'fields' => 'reject_reason',
                //values will be taken from POST object
            ],
            'remove' => [//buttons to be removed when object is in accepted status
                'save',
                'delete'
            ],
            //if this existed, we need to compare the field data with current user id, normally ins_id, but in some cases, it would be staff_id
            //this is used only in work assignments?
            'check' => 'staff_id'


        ]

    ];

    protected $_hasPrintButton = [
        //object and its status that object has print button
        //normally print button is available when object is existed
        'car',
        'drr',
        'ir',
        'ncr',
        'qr'
    ];

    protected $_notHaveRefNo = [
        //some entities dont have ref_no field so we need to exclude
        'concession',
    ];

    public function getCloseInfo(){
        return $this->_hasCloseButton;
    }

    public function doBeforeBlockToHtml($observer)
    {
        $helper = Mage::helper('bs_observation');
        $misc = Mage::helper('bs_misc');
        $currentUser = $misc->getCurrentUserInfo();

        $relations = $misc->getRelations();

        $block = $observer->getBlock();
        $massactionClass  = Mage::getConfig()->getBlockClassName('adminhtml/widget_grid_massaction');
        $gridClass = Mage::getConfig()->getBlockClassName('adminhtml/widget_grid');
        $blockType = $block->getType();


        //Mass Actions hook
        if ($massactionClass == get_class($block)) {
            $name = $block->getFormFieldName();

            //Inspectors
            $ins = Mage::getModel('admin/user')->getCollection()->addFieldToFilter('user_id', ['gt' => 1]);

            if(!$misc->isSuperAdmin() && !$misc->isAdmin()){
                $ins->addFieldToFilter('region', $currentUser[2]);
                $ins->addFieldToFilter('section', $currentUser[3]);

                if($misc->isQAAdmin(null, $currentUser)){
                    $ins->getSelect()->where("user_id IN (SELECT user_id FROM admin_role WHERE parent_id IN(9,10,11))");
                }elseif($misc->isQCAdmin(null, $currentUser)){
                    $ins->getSelect()->where("user_id IN (SELECT user_id FROM admin_role WHERE parent_id IN(5,6,7))");
                }elseif($misc->isQCManager(null, $currentUser)){
                    $ins->getSelect()->where("user_id IN (SELECT user_id FROM admin_role WHERE parent_id IN(6,7))");
                }elseif($misc->isQAManager(null, $currentUser)){
                    $ins->getSelect()->where("user_id IN (SELECT user_id FROM admin_role WHERE parent_id IN(10,11))");
                }
            }





            $ins->load();
            $inspectors = [];
            foreach ($ins as $in) {
                $inspectors[$in->getUserId()] = $in->getFirstname().' '.$in->getLastname();
            }

            //Managers
            $mans = Mage::getModel('admin/user')->getCollection()
                ->addFieldToFilter('user_id', ['gt' => 1]);

            if($misc->isQAAdmin() || $misc->isQCAdmin()){
                $mans->addFieldToFilter('region', $currentUser[2]);
                $mans->addFieldToFilter('section', $currentUser[3]);
            }

            $mans->getSelect()->where("user_id IN (SELECT user_id FROM admin_role WHERE parent_id IN (5,9))");
            $mans->load();
            $managers = [];
            foreach ($mans as $m) {
                $managers[$m->getUserId()] = $m->getFirstname().' '.$m->getLastname();
            }

            //Statuses
            $statuses = Mage::getModel("bs_{$name}/{$name}_attribute_source_{$name}status");
            if($statuses){
                $statuses = $statuses->getAllOptions(true);
            }



            //Now add items

            if($misc->canDelete()){
                $block->addItem('delete',  [
                    'label'      => $helper->__('Delete'),
                    'url'        => $block->getUrl('*/misc_misc/massDelete',
                        [
                            'type' => $name
                        ]
                    ),
                    'confirm'  => $helper->__('Are you sure?')
                ]);

            }

            if(in_array($name, $relations)){
                if($misc->canChangeInspector()){



                    $block->addItem('change_inspector',  [
                        'label'      => $helper->__('Change Ins/Aud'),
                        'url'        => $block->getUrl('*/misc_misc/massInspector',
                            [
                                'type' => $name
                            ]
                        ),
                        'additional' => [
                            'inspector' => [
                                'name'   => 'inspector',
                                'type'   => 'select',
                                'class'  => 'required-entry',
                                'label'  => $helper->__('Ins/Aud'),
                                'values' => $inspectors
                            ]
                        ]
                    ]);



                }

                if($misc->canChangeStatus()){
                    $block->addItem('change_status',  [
                        'label'      => $helper->__('Change Status'),
                        'url'        => $block->getUrl('*/misc_misc/massStatus',
                            [
                                'type' => $name
                            ]
                        ),
                        'additional' => [
                            'status' => [
                                'name'   => 'status',
                                'type'   => 'select',
                                'class'  => 'required-entry',
                                'label'  => $helper->__('Status'),
                                'values' => $statuses
                            ]
                        ]
                    ]);
                }

                if($misc->canChangeApproval()){
                    $block->addItem('change_approval',  [
                        'label'      => Mage::helper('bs_ncr')->__('Change Approval'),
                        'url'        => $block->getUrl('*/misc_misc/massApproval',
                            [
                                'type' => $name
                            ]
                        ),
                        'additional' => [
                            'approval_id' => [
                                'name'   => 'approval_id',
                                'type'   => 'select',
                                'class'  => 'required-entry',
                                'label'  => $helper->__('Approval'),
                                'values' => $managers
                            ]
                        ]
                    ]);
                }



            }



        }

        //Grid Default Filter hook
        //Add Region/Section columns then set them as default filters
        if(substr($blockType, -4) ==  "grid"){
            $allTypes = $misc->getAllTypes();

            foreach ($allTypes as $type) {
                if(strpos($blockType, "{$type}_grid")){

                    $block->setDefaultFilter(['region' => $currentUser[2], 'section' => $currentUser[3]]);
                    $block->addColumn(
                        'region',
                        [
                            'header' => Mage::helper('bs_sur')->__('Region'),
                            'index'  => 'region',
                            'type'  => 'options',
                            'options' => Mage::helper('bs_sur')->convertOptions(
                                Mage::getModel('bs_sur/sur_attribute_source_region')->getAllOptions(false)
                            )

                        ]
                    );
                    $block->addColumn(
                        'section',
                        [
                            'header' => Mage::helper('bs_sur')->__('Section'),
                            'index'  => 'section',
                            'type'  => 'options',
                            'options' => Mage::helper('bs_sur')->convertOptions(
                                Mage::getModel('bs_sur/sur_attribute_source_section')->getAllOptions(false)
                            )

                        ]
                    );
                }
            }
        }

        //Edit block: Save/Submit/Close buttons handler
        if(substr($blockType, -4) ==  "edit"){//like bs_sur/adminhtml_sur_edit
            $alias = $block->getBlockAlias();
            $alias = explode('_', $alias);
            $currentType = $alias[0];


            $allTypes = $misc->getAllTypes();

            if(in_array($currentType, $allTypes)){
                $currentObj = Mage::registry("current_{$currentType}");

                $currentStatus = null;
                $objectExisted = false;
                if($currentObj->getId()){
                    $currentStatus = intval($currentObj->getData($currentType.'_status'));
                    $objectExisted = true;
                }

                //First we remove all default buttons
                $block->removeButton('save');
                $block->removeButton('saveandcontinue');
                $block->removeButton('delete');
                $block->removeButton('reset');


                //now add new buttons base on role
                //save button
                $saveConds = [];
                if(isset($this->_openStatuses[$currentType])){
                    foreach ($this->_openStatuses[$currentType] as $status) {
                        $saveConds[$currentType.'_status'] = $status;
                    }
                }

                if($misc->canEdit($currentObj, null, $saveConds)){
                    $block->addButton(
                        'save_button',
                        [
                            'label'   => Mage::helper('bs_misc')->__('Save'),
                            'onclick'   => "saveOnly()",
                            'class'   => 'save',
                        ]
                    );
                }

                if($objectExisted){

                    if(isset($this->_hasAddNewButton[$currentType])){
                        $block->addButton(
                            'new_button',
                            [
                                'label'   => Mage::helper('bs_misc')->__('Add New'),
                                'onclick'   => 'setLocation(\'' . $block->getUrl('*/*/new', ['from'=>$currentObj->getId()]) .'\')',
                                'class'   => 'add',
                            ]
                        );
                    }
                    if($misc->canDelete($currentObj, null, $saveConds)){
                        $block->addButton(
                            'delete_button',
                            [
                                'label'   => Mage::helper('bs_misc')->__('Delete'),
                                'onclick'   => "deleteOnly()",
                                'class'   => 'delete',
                            ]
                        );
                    }

                    if(in_array($currentType, $this->_hasPrintButton)){
                        $block->addButton(
                            'print_button',
                            [
                                'label'   => Mage::helper('bs_misc')->__('Print'),
                                'onclick'   => "setLocation('{$block->getUrl('*/*/generate'.ucfirst($currentType), ['_current' => true])}')",
                                'class'   => 'reset',
                            ]
                        );
                    }



                    //submit button
                    if(isset($this->_hasSubmitButton[$currentType])){
                        $submitUrl = $block->getUrl('*/misc_misc/doSpecial',
                            [
                                'id' => $currentObj->getId(),
                                't' => $currentType,
                                'a' => 'submitted',//action
                                's' => $this->_hasSubmitButton[$currentType]['submit']['status'],//status
                                'f' => $this->_hasSubmitButton[$currentType]['submit']['fields']
                            ]
                        );

                        if(in_array($currentStatus, $this->_hasSubmitButton[$currentType]['status'])){
                            if($misc->isOwner($currentObj)){
                                $block->addButton(
                                    'submit_button',
                                    [
                                        'label'   => Mage::helper('bs_misc')->__('Submit'),
                                        'onclick'   => "submitFinishObj('{$currentType}','{$submitUrl}','{$this->_hasSubmitButton[$currentType]['submit']['require']}');",
                                        'class'   => 'save submit',
                                    ]
                                );
                            }

                        }
                    }

                    //Finish button
                    if(isset($this->_hasFinishButton[$currentType])){
                        $finishUrl = $block->getUrl('*/misc_misc/doSpecial',
                            [
                                'id' => $currentObj->getId(),
                                't' => $currentType,
                                'a' => 'finished',//action
                                's' => $this->_hasFinishButton[$currentType]['finish']['status'],//status
                                'f' => $this->_hasFinishButton[$currentType]['finish']['fields']
                            ]
                        );

                        if(in_array($currentStatus, $this->_hasFinishButton[$currentType]['status'])){
                            if($misc->isOwner($currentObj)){
                                $block->addButton(
                                    'finish_button',
                                    [
                                        'label'   => Mage::helper('bs_misc')->__('Finish'),
                                        'onclick'   => "submitFinishObj('{$currentType}','{$finishUrl}','{$this->_hasFinishButton[$currentType]['finish']['require']}');",
                                        'class'   => 'save submit',
                                    ]
                                );
                            }

                        }
                    }


                    //accept/reject buttons, for manager
                    $acceptRejectConds = [];
                    $bypass = false;
                    if(isset($this->_hasAcceptRejectButtons[$currentType])){
                        $bypass = Mage::getSingleton('admin/session')->isAllowed("bs_work/{$currentType}/accept");
                        foreach ($this->_hasAcceptRejectButtons[$currentType]['status'] as $status) {
                            $acceptRejectConds[$currentType.'_status'] = $status;

                        }

                        if(isset($this->_hasAcceptRejectButtons[$currentType]['check']) && $this->_hasAcceptRejectButtons[$currentType]['check'] != ''){
                            $acceptRejectConds[$this->_hasAcceptRejectButtons[$currentType]['check']] = $currentUser[0];
                            $bypass = true;
                        }

                        if($misc->canAcceptReject($currentObj, null, $acceptRejectConds, $bypass)){
                            $acceptUrl = $block->getUrl('*/misc_misc/doSpecial',
                                [
                                    'id' => $currentObj->getId(),
                                    't' => $currentType,
                                    'a' => 'accepted',
                                    's' => $this->_hasAcceptRejectButtons[$currentType]['accept']['status'],//status
                                    'f' => $this->_hasAcceptRejectButtons[$currentType]['accept']['fields'],
                                    'c' => $this->_hasAcceptRejectButtons[$currentType]['reject']['fields'],
                                    'd' => $this->_hasAcceptRejectButtons[$currentType]['accept']['date'],//date fields
                                ]
                            );
                            $rejectUrl = $block->getUrl('*/misc_misc/doSpecial',
                                [
                                    'id' => $currentObj->getId(),
                                    't' => $currentType,
                                    'a' => 'rejected',
                                    's' => $this->_hasAcceptRejectButtons[$currentType]['reject']['status'],//status
                                    'f' => $this->_hasAcceptRejectButtons[$currentType]['reject']['fields'],
                                    'd' => $this->_hasAcceptRejectButtons[$currentType]['reject']['date'],//date fields
                                ]
                            );

                            //need to check required fields
                            //from reject fields

                            $requiredFields = explode(",", $this->_hasAcceptRejectButtons[$currentType]['reject']['fields']);
                            $additionalCheck = "";
                            if($requiredFields && count($requiredFields)){
                                foreach ($requiredFields as $requiredField) {
                                    $additionalCheck .= "$('".$currentType."_".$requiredField."').addClassName('required-entry'); ";
                                }
                            }

                            $block->addButton(
                                'reject',
                                [
                                    'label'   => Mage::helper('bs_misc')->__('Reject'),
                                    'onclick'   => $additionalCheck."editForm.submit('{$rejectUrl}');",
                                    'class'   => 'save',
                                ]
                            );

                            $block->addButton(
                                'accept',
                                [
                                    'label'   => Mage::helper('bs_misc')->__('Accept'),
                                    'onclick'   => "editForm.submit('{$acceptUrl}');",
                                    'class'   => 'save',
                                ]
                            );
                        }

                        if($this->_hasAcceptRejectButtons[$currentType]['accept']['status'] == $currentStatus) {//if object is in closed status, we need to disable some buttons
                            if(isset($this->_hasAcceptRejectButtons[$currentType]['remove']) && count($this->_hasAcceptRejectButtons[$currentType]['remove'])){
                                foreach ($this->_hasAcceptRejectButtons[$currentType]['remove'] as $item) {
                                    $block->removeButton($item.'_button');
                                }

                            }

                        }
                    }



                    //close button
                    if(isset($this->_hasCloseButton[$currentType])){
                        if(in_array($currentStatus, $this->_hasCloseButton[$currentType]['status'])){
                            if($misc->isOwner($currentObj)){
                                $closeUrl = $block->getUrl('*/misc_misc/doSpecial',
                                    [
                                        'id' => $currentObj->getId(),
                                        't' => $currentType,
                                        'a' => 'closed',
                                        's' => $this->_hasCloseButton[$currentType]['close']['status'],//status
                                        'f' => $this->_hasCloseButton[$currentType]['close']['fields'],
                                    ]
                                );

                                $block->addButton(
                                    'close_button',
                                    [
                                        'label'   => Mage::helper('bs_misc')->__('Close'),
                                        'onclick'   => "editForm.submit('{$closeUrl}');",
                                        'class'   => 'save closes',
                                    ]
                                );
                            }

                        }else if($this->_hasCloseButton[$currentType]['close']['status'] == $currentStatus) {//if object is in closed status, we need to disable some buttons
                            if(isset($this->_hasCloseButton[$currentType]['remove']) && count($this->_hasCloseButton[$currentType]['remove'])){
                                foreach ($this->_hasCloseButton[$currentType]['remove'] as $item) {
                                    $block->removeButton($item.'_button');
                                }

                            }

                        }
                    }


                }




            }


        }

        return $this;
    }

    public function doAfterBlockToHtml($observer){
        $helper = Mage::helper('bs_observation');
        $misc = Mage::helper('bs_misc');
        $block = $observer->getBlock();
        $blockType = $block->getType();


        if(substr($blockType, -8) ==  "tab_form") {//like bs_sur/adminhtml_sur_edit_tab_form

            $type = $block->getType();//bs_sur/adminhtml_sur_edit_tab_form
            $type = explode("/", $type);
            $type = explode("_", $type[0]);
            $currentType = $type[1];

            $allTypes = $misc->getAllTypes();

            if(in_array($currentType, $allTypes)) {
                $currentObj = Mage::registry("current_{$currentType}");

                $currentStatus = null;
                $objectExisted = false;
                if ($currentObj->getId()) {
                    $currentStatus = intval($currentObj->getData($currentType . '_status'));
                    $objectExisted = true;
                }


                $transport          = $observer->getTransport();
                $html = $transport->getHtml();

                $script = $this->alterScriptAfterToHtml($block, $currentType);

                $html = $html . $script;
                $transport->setHtml($html);
            }



        }


    }

    public function adminUserSaveBefore($observer)
    {

    	$vaecoId = Mage::app()->getRequest()->getParam('vaeco_id', false);
	    $crsNo = Mage::app()->getRequest()->getParam('crs_no', false);

        $section= Mage::app()->getRequest()->getParam('section', false);
        $region = Mage::app()->getRequest()->getParam('region', false);

	    $user = $observer->getObject();
	    if($vaecoId){
		    $user->setVaecoId($vaecoId);
	    }
	    if($crsNo){
		    $user->setCrsNo($crsNo);
	    }

	    if($section){
            $user->setSection($section);
        }

        if($region){
            $user->setRegion($region);
        }




    }

    public function modelSaveBefore($observer){
        $obj = $observer->getObject();
        $isNew = $obj->isObjectNew();


        $resourceName = $obj->getResourceName();


        $id = $obj->getId();
        $type = end(explode("/", $resourceName));

        $deptId = $obj->getData('dept_id');


        if($isNew){
            $currentUser = Mage::helper('bs_misc')->getCurrentUserInfo();
            if($currentUser){//when running cron and some others, they are not in Admin so we need to take care this case
                if(!$obj->getData('ins_id')){//we need this for some cases, like QC HAN Evaluation report, the ins_id is existed
                    $data['ins_id'] = $currentUser[0];
                }

                $data['region'] = $currentUser[2];
                $data['section'] = $currentUser[3];
                $data[$type.'_status'] = 0;

                if(!in_array($type, $this->_notHaveRefNo)){
                    $data['ref_no'] = Mage::helper('bs_misc')->getNextRefNo($type, $currentUser[2], $deptId);
                }

                $obj->addData($data);


                if($type == 'coa'){//we need to update parent status to Ongoing

                    $refType = $obj->getRefType();
                    $refId = $obj->getRefId();

                    $messages = Mage::helper('bs_coa')->updateStatus($refId, $refType);
                    if(is_array($messages)){
                        foreach ($messages as $message) {
                            Mage::getSingleton('adminhtml/session')->addSuccess($message);
                        }
                    }





                }
                //$data['ref_no'] = Mage::helper('bs_ncr')->getNextRefNo();
                //$data['ncr_status'] = 0;
            }

        }
    }

    public function modelSaveAfter($observer){
        $obj = $observer->getObject();

        $resourceName = $obj->getResourceName();
        $id = $obj->getId();
        $type = end(explode("/", $resourceName));

        $refType = $obj->getRefType();
        $refId = $obj->getRefId();



        $data['count'] = Mage::helper('bs_misc/relation')->countRelation($refId, $refType, $type);
        //update count
        $obj->addData($data);

        //Now handle COA related statues
        /*$relation = Mage::helper('bs_misc')->getRelations();
        if(in_array($type, $relation)){
            $messages = Mage::helper('bs_coa')->updateStatus($id, $type);
            if(is_array($messages)){
                foreach ($messages as $message) {
                    Mage::getSingleton('adminhtml/session')->addSuccess($message);
                }
            }
        }*/



    }



    public function modelDeleteBefore($observer){
        $obj = $observer->getObject();

        $resourceName = $obj->getResourceName();
        $id = $obj->getId();
        $type = end(explode("/", $resourceName));

        Mage::helper('bs_misc/relation')->doBeforeDeleteChildren($id, $type);

        $messages = Mage::helper('bs_misc/relation')->deleteRelation($id, $type);

        if(count($messages)){
            foreach ($messages as $message) {
                Mage::getSingleton('adminhtml/session')->addWarning($message);
            }
        }


    }

    public function updateOverdue()
    {
        $resource = Mage::getSingleton('core/resource');
        $writeConnection = $resource->getConnection('core_write');
        $readConnection = $resource->getConnection('core_read');

        $statuses = [
            'car' => [1,4],//from first status -> second status
            'drr' => [1,4],
            'cmr' => [0,2],
            'cofa' => [0,2],
            'ncr' => [2,4],
            //'ir' => [3,6],
            'qn' => [2,4],
            'qr' => [2,4],
            'nrw' => [1,5],
            'coa' => [0,2],


        ];

        $resStatues = [
            'car' => [1,4],//from first status -> second status
            'drr' => [1,4],
            'cmr' => [0,2],
            'cofa' => [0,2],
            'ncr' => [2,4],
            //'ir' => [3,6],
            'qn' => [2,4],
            'qr' => [2,4],
            'nrw' => [1,4],
            'coa' => [0,2],
        ];



        try {
            foreach ($statuses as $type => $option) {
                $writeConnection->update($resource->getTableName("bs_{$type}/{$type}"), ["{$type}_status" => $option[1]], "{$type}_status = {$option[0]} AND due_date IS NOT NULL AND due_date < now()");
            }
            echo "Done";
        } catch ( Exception $e ) {
            echo $e->getMessage();
        }


    }

    public function updateLateClose()
    {
        $resource = Mage::getSingleton('core/resource');
        $writeConnection = $resource->getConnection('core_write');
        $readConnection = $resource->getConnection('core_read');

        $statuses = [
            'car' => [2,3],
            'cmr' => [1,3],//from first status -> second status
            'cofa' => [1,2],
            'drr' => [2,3],
            'ncr' => [3,6],
            //'ir' => [3,6],
            'qr' => [3,5],
            'coa' => [1,4],



        ];

        try {

            foreach ($statuses as $type => $option) {
                $writeConnection->update($resource->getTableName("bs_{$type}/{$type}"), ["{$type}_status" => $option[1]], "{$type}_status = {$option[0]} AND due_date IS NOT NULL AND due_date < close_date");
            }

            echo "Done";
        } catch ( Exception $e ) {
            echo $e->getMessage();
        }


    }

    public function alterScriptAfterToHtml($block, $type){//like updateAcreg, task, subtask, etc
        $id = $block->getForm()->getHtmlIdPrefix();
        $html = "<script>";

        if(!Mage::registry("current_{$type}")->getId()){
            $html .= "Event.observe(document, \"dom:loaded\", function(e) {";
            $html .= "
                        if($('".$id.$type."_type') != undefined){ //like ncr_type
                            updateDueDate();
                        }
                        
                        if($('".$id."task_id') != undefined){
                            updateSubtasks($('".$id."task_id').value);
                        }
                        
                        
                        if($('".$id."short_desc') != undefined){
                            if($('".$id."short_desc').value == ''){
                              $('".$id."description').up('tr').hide(); 
                           }
                           
                           $('".$id."short_desc').observe('change', function(){
                                $('".$id."description').up('tr').show(); 
                           });
                       
                        }
                        
                       
                       
                    ";
            $html .= "});";
        }

        $html .= "Event.observe(document, \"dom:loaded\", function(e) {";
        $html .= "
                    if($('".$id."customer') != undefined && $('".$id."ac_type') != undefined){
                        //updateAcreg($('".$id."customer').value, $('".$id."ac_type').value);
                    }
                        
                      
                    ";
        $html .= "});";

        $html .= "Event.observe(document, \"dom:loaded\", function(e) {";

        $html .= $this->buildHideCloseButtonJs($id);


        $html .= "});";

        $html .= "
                if($('".$id."task_id') != undefined){
                    Event.observe('".$id."task_id', 'change', function(evt){
                        updateSubtasks($('".$id."task_id').value);
                    });
                }
                
                 
                if($('".$id."ncr_type') != undefined){
                    //update due date according to type
                     Event.observe('".$id."ncr_type', 'change', function(evt){
                        updateDueDate();
                     });  
                     
                     Event.observe('".$id."report_date', 'change', function(evt){
                        updateDueDate();
                     });
                }
                
                if($('".$id."customer') != undefined){
                    Event.observe('".$id."customer', 'change', function(evt){
                        updateAcreg($('".$id."customer').value, $('".$id."ac_type').value);
                    });
                }
                
                if($('".$id."ac_type') != undefined){
                    Event.observe('".$id."ac_type', 'change', function(evt){
                        updateAcreg($('".$id."customer').value, $('".$id."ac_type').value);
                    });
                }
                    
                    ";

        $html .= $this->buildCheckCloseConditionJs($id);
        $html .= $this->buildUpdateSubtaskJs($block, $id);
        $html .= $this->buildUpdateCauseJs($block, $id);
        $html .= $this->buildUpdateDueDateJs($type, $id);
        $html .= $this->buildUpdateAcregJs($block, $id);

        $html .= "                    
                    function submitFinishObj(obj, url, field){
                        if(field != ''){
                            $(obj +'_'+field).addClassName('required-entry');
                        }
                        editForm.submit(url);
                    }
                   
                    
                </script>";

        return $html;
    }

    public function buildHideCloseButtonJs($id){

        return "
            $$('.closes').each(function (el){
                $(el).hide();
            });
              
            if($('".$id."ncause_id') != undefined){ 
              $('".$id."ncause_id').observe('change', function(){
                $$('.closes').each(function (el){
                    $(el).hide();
                  });
              
                if(checkCloseCondition()){
                    $$('.closes').each(function (el){
                        $(el).show();
                      });
              
                }
              });
              
              
            }
            if($('".$id."close_date') != undefined){ 
              $('".$id."close_date').observe('change', function(){
                $$('.closes').each(function (el){
                    $(el).hide();
                  });
              
                if(checkCloseCondition()){
                    $$('.closes').each(function (el){
                        $(el).show();
                      });
              
                }
              });
              
              
            }
            
            if($('".$id."res_date') != undefined){ 
              $('".$id."res_date').observe('change', function(){
                $$('.closes').each(function (el){
                    $(el).hide();
                  });
              
                if(checkCloseCondition()){
                    $$('.closes').each(function (el){
                        $(el).show();
                      });
              
                }
              });
              
              
            }
            
            if($('".$id."remark') != undefined){
                  $('".$id."remark').observe('change', function(){
                      $$('.closes').each(function (el){
                        $(el).hide();
                      });
                  
                    if(checkCloseCondition()){
                        $$('.closes').each(function (el){
                            $(el).show();
                          });
                  
                    }
                  });
              }
              
              if($('".$id."ncausegroup_id') != undefined){ 
                  $('".$id."ncausegroup_id').observe('change', function(){
                      $$('.closes').each(function (el){
                        $(el).hide();
                      });
                    if(checkCloseCondition()){
                        $$('.closes').each(function (el){
                            $(el).show();
                          });
                  
                    }
                  });
                  
                  Event.observe('".$id."ncausegroup_id', 'change', function(evt){
                        updateCauses($('".$id."ncausegroup_id').value);
                 });
              }
            
            ";
    }

    public function buildCheckCloseConditionJs($id){


        return "
            function checkCloseCondition(){
                var check = 1;
                if($('".$id."remark') != undefined){
                    if($('".$id."remark').value == ''){
                        check = 0 ;
                    }
                }
                
                if($('".$id."ncausegroup_id') != undefined){
                    if($('".$id."ncausegroup_id').value == ''){
                        check = 0 ;
                    }
                }
                
                if($('".$id."ncause_id') != undefined){
                    if($('".$id."ncause_id').value == ''){
                        check = 0 ;
                    }
                }
                
                if($('".$id."res_date') != undefined){
                    if($('".$id."res_date').value == ''){
                        check = 0 ;
                    }
                }
                if($('".$id."close_date') != undefined){
                    if($('".$id."close_date').value == ''){
                        check = 0 ;
                    }
                }
                
                return check;
                
            
            }
            ";
    }

    public function buildUpdateSubtaskJs($block, $id){

        return "
            function updateSubtasks(task_id){
                new Ajax.Request('".$block->getUrl('*/misc_task/updateSubtasks')."', {
                        method : 'post',
                        parameters: {
                            'task_id'   : task_id,
                            'full'      : 1
                        },
                        onSuccess : function(transport){
                            try{
                                response = eval('(' + transport.responseText + ')');
                            } catch (e) {
                                response = {};
                            }
                            if (response.subtask) {

                                if($('".$id."subtask_id') != undefined){
                                    $('".$id."subtask_id').innerHTML = response.subtask;
                                }

                            }else {
                                alert('Something went wrong');
                            }

                        },
                        onFailure : function(transport) {
                            alert('Something went wrong')
                        }
                    });
            }
            ";
    }

    public function buildUpdateCauseJs($block, $id){

        return "
            function updateCauses(group_id){
                new Ajax.Request('".$block->getUrl('*/ncause_ncausegroup/updateCauses')."', {
                        method : 'post',
                        parameters: {
                            'group_id'   : group_id
                        },
                        onSuccess : function(transport){
                            try{
                                response = eval('(' + transport.responseText + ')');
                            } catch (e) {
                                response = {};
                            }
                            if (response.causes) {

                                if($('".$id."ncause_id') != undefined){
                                    $('".$id."ncause_id').innerHTML = response.causes;
                                }

                            }else {
                                alert('Something went wrong');
                            }

                        },
                        onFailure : function(transport) {
                            alert('Something went wrong')
                        }
                    });
            }";
    }

    public function buildUpdateDueDateJs($type, $id){

        return "
            function updateDueDate(){
                var type_id = $('".$id.$type."_type').value;
                if($('".$id."report_date') != undefined){
                    var report_date = $('".$id."report_date').value;
                
                    if(type_id != '' && report_date != ''){
                        var dateArray = report_date.split('/');
                        var addDay = 0;
                        switch(type_id){
                            case '1':
                                addDay = 3;
                                break;
                            case '2':
                                addDay = 10;
                                break;
                           
                            default:
                                break;
                                
                        }
                        
                        var result = new Date(dateArray[2], dateArray[1]-1, dateArray[0]);
                        result.setDate(result.getDate() + addDay);
                        
                        var dayday = result.getDate();
                        if(dayday < 10) {
                            dayday = '0' + dayday;
                        }
                        var month = result.getMonth() * 1 + 1;
                        if(month < 10) {
                            month = '0' + month;
                        }
                        
                        var duedate = dayday + '/' + month + '/' + result.getFullYear();
                                                    
                        if($('".$id."due_date') != undefined){
                            $('".$id."due_date').value = duedate;
                        }
                    }
                
                }
                
               
            }";
    }

    public function buildUpdateAcregJs($block, $id){
        return "
            function updateAcreg(customer_id, ac_type){
                new Ajax.Request('".$block->getUrl('*/acreg_acreg/updateAcreg')."', {
                    method : 'post',
                    parameters: {
                        'customer_id'   : customer_id,
                        'ac_type'   : ac_type
                    },
                    onSuccess : function(transport){
                        try{
                            response = eval('(' + transport.responseText + ')');
                        } catch (e) {
                            response = {};
                        }
                        if (response.acreg) {
    
                            if($('".$id."ac_reg') != undefined){
                                $('".$id."ac_reg').innerHTML = response.acreg;
                            }
    
                        }else {
                            alert('Something went wrong');
                        }
    
                    },
                    onFailure : function(transport) {
                        alert('Something went wrong')
                    }
                });
            }
        ";
    }

}
