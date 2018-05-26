<?php
/**
 * BS_Imex extension
 * 
 * @category       BS
 * @package        BS_Imex
 * @copyright      Copyright (c) 2018
 */
/**
 * Import model
 *
 * @category    BS
 * @package     BS_Imex
 * @author Bui Phong
 */
class BS_Imex_Model_Im extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_imex_im';
    const CACHE_TAG = 'bs_imex_im';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_imex_im';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'im';

    protected $_importAdapter;

    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('bs_imex/im');
    }

    /**
     * before save import
     *
     * @access protected
     * @return BS_Imex_Model_Im
     * @author Bui Phong
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()) {
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }

    /**
     * save import relation
     *
     * @access public
     * @return BS_Imex_Model_Im
     * @author Bui Phong
     */
    protected function _afterSave()
    {
        return parent::_afterSave();
    }

    /**
     * get default values
     *
     * @access public
     * @return array
     * @author Bui Phong
     */
    public function getDefaultValues()
    {
        $values = [];
        $values['status'] = 1;
        return $values;
    }

    public static function getWorkingDir()
    {
        return Mage::getBaseDir('var') . DS . 'imex' . DS;
    }


    protected function _getSourceAdapter($sourceFile)
    {
        $adapter = new BS_Imex_Model_Im_Adapter_Csv($sourceFile);
        return $adapter;
    }

    public function doImport()
    {
        $entity = $this->getEntity();
        $behavior = $this->getBehavior();

        $uploader  = Mage::getModel('core/file_uploader', 'im_source');
        $uploader->skipDbProcessing(true);
        $result    = $uploader->save(self::getWorkingDir());
        $extension = pathinfo($result['file'], PATHINFO_EXTENSION);

        $uploadedFile = $result['path'] . $result['file'];
        if (!$extension) {
            unlink($uploadedFile);
            Mage::throwException(Mage::helper('bs_imex')->__('Uploaded file has no extension'));
        }
        $sourceFile = self::getWorkingDir().$entity;

        $sourceFile .= '.' . $extension;

        if(strtolower($uploadedFile) != strtolower($sourceFile)) {
            if (file_exists($sourceFile)) {
                unlink($sourceFile);
            }

            if (!@rename($uploadedFile, $sourceFile)) {
                Mage::throwException(Mage::helper('bs_imex')->__('Source file moving failed'));
            }
        }
        // trying to create source adapter for file and catch possible exception to be convinced in its adequacy
        try {


            if($behavior == 'replace'){
                $collection = Mage::getModel("bs_{$entity}/{$entity}")->getCollection();
                $collection->walk('delete');
            }

            $data = Mage::helper('bs_imex')->readExcelFile($sourceFile);

            return $this->{'import'.ucfirst($entity)}($data);



        } catch (Exception $e) {
            unlink($sourceFile);
            Mage::throwException($e->getMessage());
        }
        return $sourceFile;
    }


    /*
     * function import[entity]
     * for example: importSafety, importCar, importNrc, etc.
     */
    public function importSafety($data){
        $i = 0;
        foreach ( $data as $row) {

            $safetyData = [];

            $acType = $row['AC Type'];
            if($acType == 'A320' || $acType == 'A321'){
                $acType = 1;
            }else {
                $acTypeModel = Mage::getModel('bs_misc/aircraft')->getCollection()->addFieldToFilter('ac_code', $acType);
                if($id = $acTypeModel->getFirstItem()->getId()){
                    $acType = $id;
                }

            }
            $safetyData['ac_type'] = $acType;
            $acReg = $row['Ac Reg'];
            $acRegModel = Mage::getModel('bs_acreg/acreg')->getCollection()->addFieldToFilter('reg', $acReg);
            if($acregId = $acRegModel->getFirstItem()->getId()){
                $acReg = $acregId;
                $safetyData['ac_reg'] = $acReg;
            }

            $occurDate = $row['Occur Date'];
            if($occurDate != ''){
                $date = DateTime::createFromFormat('j-M-y', $occurDate);
                $occurDate =  $date->format('Y-m-d');
                $safetyData['occur_date'] = $occurDate;
            }
            $place = $row['Place'];
            $safetyData['place'] = $place;

            $description = $row['Defect'];
            $safetyData['description'] = $description;

            $finalAction = $row['Final Action'];
            $safetyData['final_action'] = $finalAction;

            $eventType = null;
            $mor = 0;
            $safetyType = 5;
            if($row['Delay'] != ''){
                $eventType = 1;
                $safetyType = 4;
            }
            if($row['AOG with Report'] != ''){
                $eventType = 2;
                $safetyType = 4;
            }
            if($row['AOG without Report'] != ''){
                $eventType = 3;
                $safetyType = 4;
            }
            if($row['Check'] != ''){
                $eventType = 4;
                $safetyType = 4;
            }
            if($row['Check Extended'] != ''){
                $eventType = 5;
                $safetyType = 4;
            }

            if($row['MOR'] != ''){
                $mor = 1;
            }
            $safetyData['mor'] = $mor;
            $safetyData['safety_type'] = $safetyType;
            $safetyData['event_type'] = $eventType;


            $safety = Mage::getModel('bs_safety/safety');
            $safety->addData($safetyData);
            $safety->save();



            $i++;
        }

        return $i;
    }



    
}
