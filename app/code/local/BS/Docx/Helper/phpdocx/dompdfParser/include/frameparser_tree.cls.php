<?php
/**
 * PARSERHTML - PHP5 HTML to PDF renderer
 *
 * File: $RCSfile: frame_tree.cls.php,v $
 * Created on: 2004-06-02
 *
 * Copyright (c) 2004 - Benj Carson <benjcarson@digitaljunkies.ca>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this library in the file LICENSE.LGPL; if not, write to the
 * Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 * 02111-1307 USA
 *
 * Alternatively, you may distribute this software under the terms of the
 * PHP License, version 3.0 or later.  A copy of this license should have
 * been distributed with this file in the file LICENSE.PHP .  If this is not
 * the case, you can obtain a copy at http://www.php.net/license/3_0.txt.
 *
 * The latest version of DOMPDF might be available at:
 * http://www.dompdf.com/
 *
 * @link http://www.dompdf.com/
 * @copyright 2004 Benj Carson
 * @author Benj Carson <benjcarson@digitaljunkies.ca>
 * @package parserhtml
 */

/* $Id: frame_tree.cls.php 332 2010-11-27 14:06:34Z fabien.menager $ */

/**
 * Represents an entire document as a tree of frames
 *
 * The FrameParser_Tree consists of {@link FrameParser} objects each tied to specific
 * DomNode objects in a specific DomDocument.  The FrameParser_Tree has the same
 * structure as the DomDocument, but adds additional capabalities for
 * styling and layout.
 *
 * @package parserhtml
 * @access protected
 */
class FrameParser_Tree {

  /**
   * Tags to ignore while parsing the tree
   *
   * @var array
   */
  static protected $_HIDDEN_TAGS = ["area", "base", "basefont", "head", "style",
                                         "meta", "title", "colgroup",
                                         "noembed", "noscript", "param", "#comment"
                                         , 'script'];

  /**
   * The main DomDocument
   *
   * @see http://ca2.php.net/manual/en/ref.dom.php
   * @var DomDocument
   */
  protected $_dom;

  /**
   * The root node of the FrameParserTree.
   *
   * @var FrameParser
   */
  protected $_root;

  /**
   * A mapping of {@link FrameParser} objects to DomNode objects
   *
   * @var array
   */
  protected $_registry;

  /**
   * Class constructor
   *
   * @param DomDocument $dom the main DomDocument object representing the current html document
   */
  function __construct(DomDocument $dom) {
    $this->_dom = $dom;
    $this->_root = null;
    $this->_registry = [];
  }
  
  function __destruct() {
    clear_object_parser($this);
  }

  /**
   * Returns the DomDocument object representing the curent html document
   *
   * @return DomDocument
   */
  function get_dom() { return $this->_dom; }

  /**
   * Returns a specific frame given its id
   *
   * @param string $id
   * @return FrameParser
   */
  function get_frame($id) { return isset($this->_registry[$id]) ? $this->_registry[$id] : null; }

  /**
   * Returns a post-order iterator for all frames in the tree
   *
   * @return FrameParserTreeList
   */
  function get_frames() { return new FrameParserTreeList($this->_root); }

  /**
   * Builds the tree
   */
  function build_tree($filter = '*') {

    if($filter != '*' && strpos($filter, '/') === false){
        if(strpos($filter, '.') === 0) $filter = "//*[contains(@class,'".substr($filter, 1)."')]"; //css class
        elseif(strpos($filter, '#') === 0) $filter = "//*[@id='".substr($filter, 1)."']"; //dom id
        elseif(strpos($filter, '<') === 0) $filter = '//'.trim($filter, ' <>'); //dom tag //*[contains(name(),'C')]
        else $filter = "//*[contains(@class,'".$filter."')]|//*[@id='".$filter."']|//".trim($filter, ' <>'); //css|id|tag
    }

    if(strpos($filter, '/') === 0){ //xpath expression
        $xpath = new DOMXPath($this->_dom);
        $entradas = @$xpath->query($filter);

        if($entradas !== false){
            foreach($entradas as $entrada){
                //$entrada->item($i)->nodeValue
                $entrada->setAttribute('class', ($entrada->hasAttribute('class')?$entrada->getAttribute('class').' ':'').'_phpdocx_filter_paint_');
            }

            /*$aNodos = array();
            foreach($entradas as $entrada){
                $aNodos[] = $entrada;
            }

            //remake domdocument
            $oldBody = $this->_dom->getElementsByTagName('body')->item(0);
            if($this->_dom->getElementsByTagName("html")->item(0)->removeChild($oldBody)){
                $newBody = $this->_dom->createElement('body');
                $this->_dom->getElementsByTagName("html")->item(0)->appendChild($newBody);

                foreach($aNodos as $nodo){
                    try{$this->_dom->getElementsByTagName('body')->item(0)->appendChild($nodo);}
                    catch(Exception $e){echo($filter.' -> incorrect XPath expression.');}
                }
            }*/
        }
        else $filter = '*'; //xpath expression was incorrect
    }

    if($filter == '*') @$this->_dom->getElementsByTagName("html")->item(0)->setAttribute('class', '_phpdocx_filter_paint_');

    $html = @$this->_dom->getElementsByTagName("html")->item(0); //all document, default

    if ( is_null($html) )
      $html = $this->_dom->firstChild;

    if ( is_null($html) )
      throw new Exception("Requested HTML document contains no data.");

    $this->_root = $this->_build_tree_r($html);

  }

  /**
   * Recursively adds {@link FrameParser} objects to the tree
   *
   * Recursively build a tree of FrameParser objects based on a dom tree.
   * No layout information is calculated at this time, although the
   * tree may be adjusted (i.e. nodes and frames for generated content
   * and images may be created).
   *
   * @param DomNode $node the current DomNode being considered
   * @return FrameParser
   */
  protected function _build_tree_r(DomNode $node) {

    $frame = new FrameParser($node);
    $id = $frame->get_id();
    $this->_registry[ $id ] = $frame;

    if ( !$node->hasChildNodes() )
      return $frame;

    // Fixes 'cannot access undefined property for object with
    // overloaded access', fix by Stefan radulian
    // <stefan.radulian@symbion.at>
    //foreach ($node->childNodes as $child) {

    // Store the children in an array so that the tree can be modified
    $children = [];
    for ($i = 0; $i < $node->childNodes->length; $i++)
      $children[] = $node->childNodes->item($i);

    foreach ($children as $child) {
      $node_name = mb_strtolower($child->nodeName);

      // Skip non-displaying nodes
      if ( in_array($node_name, self::$_HIDDEN_TAGS) ) {
        if ( $node_name !== "head" &&
             $node_name !== "style" )
          $child->parentNode->removeChild($child);
        continue;
      }

      // Skip empty text nodes
      if ( $node_name === "#text" && $child->nodeValue == "" ) {
        $child->parentNode->removeChild($child);
        continue;
      }

      // Skip empty image nodes
      if ( $node_name === "img" && $child->getAttribute("src") == "" ) {
        $child->parentNode->removeChild($child);
        continue;
      }

      $frame->append_child($this->_build_tree_r($child), false);
    }

    return $frame;
  }

  public function insert_node(DOMNode $node, DOMNode $new_node, $pos) {
    if ($pos === "after" || !$node->firstChild)
      $node->appendChild($new_node);
    else
      $node->insertBefore($new_node, $node->firstChild);

    $this->_build_tree_r($new_node);

    $frame_id = $new_node->getAttribute("frame_id");
    $frame = $this->get_frame($frame_id);

    $parent_id = $node->getAttribute("frame_id");
    $parent = $this->get_frame($parent_id);

    if ($pos === "before")
      $parent->prepend_child($frame, false);
    else
      $parent->append_child($frame, false);
  }
}
