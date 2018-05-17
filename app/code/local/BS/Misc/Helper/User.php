<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Misc default helper
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Helper_User extends BS_Misc_Helper_Data
{
    protected $_admin = [1,3,4,8];
    protected $_manager = [5,9];
    protected $_deputy = [6,10];


    /**
     * @param $only - Only maintenance center
     */
    public function getUsers($onlyManager = true, $includeDeputy = true, $grid = false, $userName = true, $withEmpty = false, $excludeAdmin = true, $excludeManager = false, $correctRegionSection = true){

        $currentUser = $this->getCurrentUserInfo();

        $users = Mage::getModel('admin/user')->getCollection()->addFieldToFilter('user_id', ['gt' => 1]);

        $users->addFieldToFilter('is_active', 1);

        if($correctRegionSection){
            $users->addFieldToFilter('region', ['eq' => $currentUser[2]]);
            $users->addFieldToFilter('section', ['eq' => $currentUser[3]]);
        }


        $managers = $this->_manager;

        if($includeDeputy){
            $managers = array_merge($this->_manager, $this->_deputy);
        }

        if($onlyManager){
            $users->getSelect()->where("user_id IN (SELECT user_id FROM admin_role WHERE parent_id IN(".implode(",", $managers)."))");
            //$users->addFieldToFilter('user_id', ['in' => $managers]);
        }

        $exclude = [];

        if($excludeAdmin){
            $exclude = array_merge($exclude, $this->_admin);
        }

        if($excludeManager){
            $exclude = array_merge($exclude, $managers);
        }

        if(count($exclude)){
            $users->getSelect()->where("user_id NOT IN (SELECT user_id FROM admin_role WHERE parent_id IN(".implode(",", $exclude)."))");
        }

        //$query = $users->getSelect()->__toString();

        $userArray = [];
        $userArrayGrid = [];

        $users->load();

        foreach ($users as $in) {
            if($userName){
                $name = strtoupper($in->getUsername());
            }else {
                $name = $in->getName();
            }
            $userArrayGrid[$in->getUserId()] = $name;
            $userArray[] = ['value' => $in->getUserId(), 'label' => $name];
        }



        if($grid){
            return $userArrayGrid;
        }

        if($withEmpty){
            array_unshift($userArray, ['value' => 0, 'label' => 'N/A']);
        }

        return $userArray;

    }

    public function getUsersByManager($userName = true, $grid = false, $withEmpty = false){
        $ins = Mage::getModel('admin/user')->getCollection()->addFieldToFilter('user_id', ['gt' => 1]);
        $misc = Mage::helper('bs_misc');
        $currentUser = $misc->getCurrentUserInfo();

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

        $userArray = [];
        $userArrayGrid = [];

        $ins->load();

        foreach ($ins as $in) {
            if($userName){
                $name = strtoupper($in->getUsername());
            }else {
                $name = $in->getName();
            }
            $userArrayGrid[$in->getUserId()] = $name;
            $userArray[] = ['value' => $in->getUserId(), 'label' => $name];
        }



        if($grid){
            return $userArrayGrid;
        }

        if($withEmpty){
            array_unshift($userArray, ['value' => 0, 'label' => 'N/A']);
        }

        return $userArray;
    }



}
