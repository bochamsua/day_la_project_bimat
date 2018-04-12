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

class BS_Nrw_Block_Adminhtml_Nrw_Dashboard_Nrwsign extends BS_Rewriting_Block_Adminhtml_Dashboard_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('nrwSignGrid');
    }

    protected function _prepareCollection()
    {
        $currentUser = $this->helper('bs_misc')->getCurrentUserInfo();

        $collection = Mage::getModel('bs_nrw/nrw')
            ->getCollection()
            ->addFieldToFilter('ins_id', $currentUser[0])
            //->addFieldToFilter('region', $currentUser[2])
            //->addFieldToFilter('section', $currentUser[3])
            ->addFieldToFilter('nrw_status', [
                ['nin' => [3]],
                ['null' => true],
            ])
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
                'header'    => Mage::helper('bs_nrw')->__('Reference No'),
                'align'     => 'left',
                'index'     => 'ref_no',
            ]
        );

        $this->addColumn(
            'staff_id',
            [
                'header' => Mage::helper('bs_nrw')->__('Inspector'),
                'index'  => 'staff_id',
                'type'=> 'options',
                'options'   => Mage::helper('bs_misc/user')->getUsers(false, false, true, true, true),

            ]
        );

        $this->addColumn(
            'report_date',
            [
                'header' => Mage::helper('bs_nrw')->__('Issue Date'),
                'index'  => 'report_date',
                'type'=> 'date',

            ]
        );

        $this->addColumn(
            'due_date',
            [
                'header' => Mage::helper('bs_nrw')->__('Due Date'),
                'index'  => 'due_date',
                'type'=> 'date',

            ]
        );

        $this->addColumn(
            'nrw_status',
            [
                'header' => Mage::helper('bs_nrw')->__('Status'),
                'index'  => 'nrw_status',
                'type'  => 'options',
                'options' => Mage::helper('bs_nrw')->convertOptions(
                    Mage::getModel('bs_nrw/nrw_attribute_source_nrwstatus')->getAllOptions(false)
                )

            ]
        );






        $this->setFilterVisibility(false);
        $this->setPagerVisibility(false);

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/nrw_nrw/edit', ['id' => $row->getId()]);
    }
}
