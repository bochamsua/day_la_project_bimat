<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2016 X.commerce, Inc. and affiliates (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml dashboard recent orders grid
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class BS_Car_Block_Adminhtml_Car_Dashboard_Grid extends BS_Rewriting_Block_Adminhtml_Dashboard_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('carGrid');
    }

    protected function _prepareCollection()
    {

        $collection = Mage::getModel('bs_car/car')
            ->getCollection()
            ->addFieldToFilter('ins_id', Mage::getSingleton('admin/session')->getUser()->getUserId())
	        ->addFieldToFilter('car_status', ['nin' => [2,3]])
            ->setOrder('ref_no', 'DESC')

        ;


        $this->setCollection($collection);

        return parent::_prepareCollection();
    }


    protected function _prepareColumns()
    {
        $this->addColumn(
            'ref_no',
            [
                'header'    => Mage::helper('bs_car')->__('Reference No'),
                'align'     => 'left',
                'index'     => 'ref_no',
            ]
        );



        $this->addColumn(
            'report_date',
            [
                'header' => Mage::helper('bs_car')->__('Report Date'),
                'index'  => 'report_date',
                'type'=> 'date',

            ]
        );


        $this->addColumn(
            'car_status',
            [
                'header' => Mage::helper('bs_car')->__('Status'),
                'index'  => 'car_status',
                'type'  => 'options',
                'options' => Mage::helper('bs_car')->convertOptions(
                    Mage::getModel('bs_car/car_attribute_source_carstatus')->getAllOptions(false)
                )

            ]
        );

        $this->addColumn(
            'due_date',
            [
                'header' => Mage::helper('bs_car')->__('Due Date'),
                'index'  => 'due_date',
                'type'=> 'date',

            ]
        );


        $this->setFilterVisibility(false);
        $this->setPagerVisibility(false);

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/car_car/edit', ['id' => $row->getId()]);
    }
}
