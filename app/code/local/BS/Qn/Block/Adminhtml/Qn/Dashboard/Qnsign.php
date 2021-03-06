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

class BS_Qn_Block_Adminhtml_Qn_Dashboard_Qnsign extends BS_Rewriting_Block_Adminhtml_Dashboard_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('qnSignGrid');
    }

    protected function _prepareCollection()
    {

        $currentUser = $this->helper('bs_misc')->getCurrentUserInfo();

        $collection = Mage::getModel('bs_qn/qn')
            ->getCollection()
	        ->addFieldToFilter('qn_status', ['eq'=>1])
            ->addFieldToFilter('region', $currentUser[2])
            ->addFieldToFilter('section', $currentUser[3])
            ->addFieldToFilter('accept', [
                ['eq' => 0],
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
                'header'    => Mage::helper('bs_qn')->__('Reference No'),
                'align'     => 'left',
                'index'     => 'ref_no',
            ]
        );

        $this->addColumn(
            'report_date',
            [
                'header' => Mage::helper('bs_qn')->__('Report Date'),
                'index'  => 'report_date',
                'type'=> 'date',

            ]
        );




        $this->setFilterVisibility(false);
        $this->setPagerVisibility(false);

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/qn_qn/edit', ['id' => $row->getId()]);
    }
}
