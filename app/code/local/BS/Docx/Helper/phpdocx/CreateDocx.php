<?php

/**
 * Generate a DOCX file 
 *
 * @category   Phpdocx
 * @package    create
 * @copyright  Copyright (c) Narcea Producciones Multimedia S.L.
 *             (http://www.2mdc.com)
 * @license    http://www.phpdocx.com/wp-content/themes/lightword/pro_license.php
 * @version    2014.08.01
 * @link       http://www.phpdocx.com
 */
error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE);

require_once dirname(__FILE__) . '/Phpdocx_config.inc';

class CreateDocx
{

    const NAMESPACEWORD = 'w';
    const SCHEMA_IMAGEDOCUMENT = 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/image';
    const SCHEMA_OFFICEDOCUMENT = 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument';

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $bookmarksIds;

    /**
     *
     * @access public
     * @static
     * @var string
     */
    public static $_encodeUTF;

    /**
     *
     * @access public
     * @var array
     * @static
     */
    public static $_relsHeaderFooterImage;

    /**
     *
     * @access public
     * @var array
     * @static
     */
    public static $_relsHeaderFooterExternalImage;

    /**
     *
     * @access public
     * @var array
     * @static
     */
    public static $_relsHeaderFooterLink;

    /**
     *
     * @access public
     * @var array
     * @static
     */
    public static $_relsNotesExternalImage;

    /**
     *
     * @access public
     * @var array
     * @static
     */
    public static $_relsNotesImage;

    /**
     *
     * @access public
     * @var array
     * @static
     */
    public static $_relsNotesLink;

    /**
     *
     * @access public
     * @var array
     * @static
     */
    public static $bidi;

    /**
     *
     * @access public
     * @var array
     * @static
     */
    public static $rtl;

    /**
     *
     * @var array
     * @access public
     * @static
     */
    public static $customLists;

    /**
     *
     * @var array
     * @access public
     * @static
     */
    public static $generateCustomRels;

    /**
     *
     * @var array
     * @access public
     * @static
     */
    public static $insertNameSpaces;

    /**
     *
     * @var array
     * @access public
     * @static
     */
    public static $nameSpaces;

    /**
     *
     * @var array
     * @access public
     * @static
     */
    public static $propsCore;

    /**
     *
     * @var array
     * @access public
     * @static
     */
    public static $propsApp;

    /**
     *
     * @var array
     * @access public
     * @static
     */
    public static $propsCustom;

    /**
     *
     * @var array
     * @access public
     * @static
     */
    public static $relsRels;

    /**
     *
     * @access public
     * @static
     * @var integer
     */
    public static $numUL;

    /**
     *
     * @access public
     * @static
     * @var integer
     */
    public static $numOL;

    /**
     *
     * @access public
     * @static
     * @var int
     */
    public static $intIdWord;

    /**
     *
     * @access public
     * @static
     * @var Logger
     */
    public static $log;

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $unlinkFiles;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_background;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_backgroundColor;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_baseTemplateFilesPath;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_baseTemplatePath;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_baseTemplateZip;

    /**
     *
     * @access protected
     * @var boolean
     */
    protected $_compatibilityMode;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_contentTypeC;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_defaultFont;

    /**
     *
     * @access private
     * @var boolean
     */
    private $_defaultTemplate;

    /**
     *
     * @access private
     * @var boolean
     */
    private $_docm;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_documentXMLElement;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_docxTemplate;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_extension;

    /**
     *
     * @access protected
     * @var array
     */
    protected $_idWords;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_language;

    /**
     *
     * @access protected
     * @var boolean
     */
    protected $_macro;

    /**
     *
     * @access protected
     * @var int
     */
    protected $_markAsFinal;

    /**
     *
     * @access protected
     * @var int
     */
    protected $_modifiedDocxProperties;

    /**
     *
     * @access protected
     * @var array
     */
    protected $_modifiedHeadersFooters;

    /**
     *
     * @access protected
     * @var array
     */
    protected $_modifiedRels;

    /**
     *
     * @access protected
     * @var array
     */
    protected $_parsedStyles;

    /**
     *
     * @access protected
     * @var array
     */
    protected $_phpdocxconfig;

    /**
     *
     * @access protected
     * @var array
     */
    protected $_relsHeader;

    /**
     *
     * @access protected
     * @var array
     */
    protected $_relsFooter;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_relsRelsC;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_relsRelsT;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_sectPr;

    /**
     * Directory path used for temporary files
     *
     * @access protected
     * @var string
     */
    protected $_tempDir;

    /**
     * Temporary document DOM 
     *
     * @access protected
     * @var DocumentDOM
     */
    protected $_tempDocumentDOM;

    /**
     * Path of temp file to use as DOCX file
     *
     * @access protected
     * @var string
     */
    protected $_tempFile;

    /**
     * Paths of temps files to use as DOCX file
     *
     * @access protected
     * @var array
     */
    protected $_tempFileXLSX;

    /**
     * Unique id for the insertion of new elements
     *
     * @access protected
     * @var string
     */
    protected $_uniqid;

    /**
     *
     * @access protected
     * @var DOMDocument
     */
    protected $_wordCommentsT;

    /**
     *
     * @access protected
     * @var DOMDocument
     */
    protected $_wordCommentsRelsT;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_wordDocumentC;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_wordDocumentT;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_wordDocumentStyles;

    /**
     *
     * @access protected
     * @var DOMDocument
     */
    protected $_wordEndnotesT;

    /**
     *
     * @access protected
     * @var DOMDocument
     */
    protected $_wordEndnotesRelsT;

    /**
     *
     * @access protected
     * @var array
     */
    protected $_wordFooterC;

    /**
     *
     * @access protected
     * @var array
     */
    protected $_wordFooterT;

    /**
     *
     * @access protected
     * @var DOMDocument
     */
    protected $_wordFootnotesT;

    /**
     *
     * @access protected
     * @var DOMDocument
     */
    protected $_wordFootnotesRelsT;

    /**
     *
     * @access protected
     * @var array
     */
    protected $_wordHeaderC;

    /**
     *
     * @access protected
     * @var array
     */
    protected $_wordHeaderT;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_wordNumberingT;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_wordRelsDocumentRelsC;

    /**
     *
     * @access protected
     * @var DOMDocument
     */
    protected $_wordRelsDocumentRelsT;

    /**
     *
     * @access protected
     * @var DOMDocument
     */
    protected $_wordSettingsT;

    /**
     *
     * @access protected
     * @var DOMDocument
     */
    protected $_wordStylesT;

    /**
     *
     * @access protected
     * @var ZipArchive
     */
    protected $_zipDocx;

    /**
     * Construct
     *
     * @access public
     * @param string $baseTemplatePath. Optional, basicTemplate.docx as default
     * @param $docxTemplatePath. User custom template (preserves Word content)
     */
    public function __construct($baseTemplatePath = PHPDOCX_BASE_TEMPLATE, $docxTemplatePath = '')
    {
        // general settings
        $this->_phpdocxconfig = PhpdocxUtilities::parseConfig();

        $this->_docxTemplate = false;
        if ($baseTemplatePath == 'docm') {
            $this->_baseTemplatePath = PHPDOCX_BASE_FOLDER . 'phpdocxBaseTemplate.docm'; // base template path
            $this->_docm = true;
            $this->_defaultTemplate = true;
            $this->_extension = 'docm';
        } else if ($baseTemplatePath == 'docx') {
            $this->_baseTemplatePath = PHPDOCX_BASE_FOLDER . 'phpdocxBaseTemplate.docx'; // base template path
            $this->_docm = false;
            $this->_defaultTemplate = true;
            $this->_extension = 'docx';
        } else if (!empty($docxTemplatePath)) {
            $this->_defaultTemplate = false;
            $this->_docxTemplate = true;
            $this->_baseTemplatePath = $docxTemplatePath; // external template path
            $extension = pathinfo($this->_baseTemplatePath, PATHINFO_EXTENSION);
            $this->_extension = $extension;
            if ($extension == 'docm') {
                $this->_docm = true;
            } else if ($extension == 'docx') {
                $this->_docm = false;
            } else {
                //PhpdocxLogger::logger('Invalid template extension', 'fatal');
            }
        } else {
            if ($baseTemplatePath == PHPDOCX_BASE_TEMPLATE) {
                $this->_defaultTemplate = true;
            } else {
                $this->_defaultTemplate = false;
            }
            $this->_baseTemplatePath = $baseTemplatePath; //base template path
            $extension = pathinfo($this->_baseTemplatePath, PATHINFO_EXTENSION);
            $this->_extension = $extension;
            if ($extension == 'docm') {
                $this->_docm = true;
            } else if ($extension == 'docx') {
                $this->_docm = false;
            } else {
                //PhpdocxLogger::logger('Invalid base template extension', 'fatal');
            }
        }
        // make a copy of the template or the base template that we want to work with so we
        // do not overwrite it
        if ($this->_phpdocxconfig['settings']['temp_path']) {
            $this->_tempDir = $this->_phpdocxconfig['settings']['temp_path'];
        } else {
            $this->_tempDir = self::getTempDir();
        }
        $this->_tempFile = tempnam($this->_tempDir, 'document');
        copy($this->_baseTemplatePath, $this->_tempFile);
        $this->_zipDocx = new ZipArchive();
        try {
            $openZip = $this->_zipDocx->open($this->_tempFile);
            if ($openZip !== true) {
                throw new Exception('Error while trying to open the (base) template as a zip file');
            }
        } catch (Exception $e) {
            //PhpdocxLogger::logger($e->getMessage(), 'fatal');
        }

        // initialize some required variables
        $this->_background = ''; // w:background OOXML element
        $this->_backgroundColor = 'FFFFFF'; // docx background color
        self::$bookmarksIds = [];
        $this->_idWords = [];
        self::$intIdWord = rand(9999999, 99999999);
        self::$_encodeUTF = 0;
        $this->_language = 'en-US';
        $this->_markAsFinal = 0;
        $this->_compatibilityMode = false;
        $this->_relsRelsC = '';
        $this->_relsRelsT = '';
        $this->_contentTypeC = '';
        $this->_contentTypeT = NULL;
        $this->_defaultFont = '';
        $this->_macro = 0;
        $this->_modifiedDocxProperties = false;
        $this->_modifiedHeadersFooters= [];
        $this->_relsHeader = [];
        $this->_relsFooter = [];
        $this->_parsedStyles = [];
        self::$_relsHeaderFooterImage = [];
        self::$_relsHeaderFooterExternalImage = [];
        self::$_relsHeaderFooterLink = [];
        self::$_relsNotesExternalImage = [];
        self::$_relsNotesImage = [];
        self::$_relsNotesLink = [];
        $this->_sectPr = NULL;
        $this->_tempDocumentDOM = NULL;
        $this->_tempFileXLSX = [];
        $this->_uniqid = 'phpdocx_' . uniqid();
        $this->_wordCommentsT = new DOMDocument();
        $this->_wordCommentsRelsT = new DOMDocument();
        $this->_wordDocumentT = '';
        $this->_wordDocumentC = '';
        $this->_wordDocumentStyles = '';
        $this->_wordEndnotesT = new DOMDocument();
        $this->_wordEndnotesRelsT = new DOMDocument();
        $this->_wordFooterC = [];
        $this->_wordFooterT = [];
        $this->_wordFootnotesT = new DOMDocument();
        $this->_wordFootnotesRelsT = new DOMDocument();
        $this->_wordHeaderC = [];
        $this->_wordHeaderT = [];
        $this->_wordNumberingT;
        $this->_wordRelsDocumentRelsT = NULL;
        $this->_wordSettingsT = '';
        $this->_wordStylesT = NULL;
        //
        self::$customLists = [];
        self::$insertNameSpaces = [];
        self::$nameSpaces = [];
        self::$unlinkFiles = [];

        $baseTemplateDocumentT = $this->getFromZip('word/document.xml');

        // extract the w:document tag with its namespaces and atributes and the 
        // w:background element if it exists
        $bodySplit = explode('<w:body>', $baseTemplateDocumentT);
        $tempDocumentXMLElement = $bodySplit[0];
        $backgroundSplit = explode('<w:background', $tempDocumentXMLElement);
        $this->_documentXMLElement = $backgroundSplit[0];
        if (!empty($backgroundSplit[1])) {
            $this->_background = '<w:background' . $backgroundSplit[1];
        }
        // do some manipulations with the DOM to get or not the file contents
        $baseDocument = new DOMDocument();
        $baseDocument->loadXML($baseTemplateDocumentT);
        // parse for front page
        $docXpath = new DOMXPath($baseDocument);
        $docXpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        // extract namespaces
        $NSQuery = '//w:document/namespace::*';
        $xmlnsNodes = $docXpath->query($NSQuery);
        foreach ($xmlnsNodes as $node) {
            self::$nameSpaces[$node->nodeName] = $node->nodeValue;
        }
        $documentQuery = '//w:document';
        $documentElement = $docXpath->query($documentQuery)->item(0);
        foreach ($documentElement->attributes as $attribute_name => $attribute_node) {
            self::$nameSpaces[$attribute_name] = $attribute_node->nodeValue;
        }
        if (!$this->_docxTemplate) {
            $queryDoc = '//w:body/w:sdt';
            $docNodes = $docXpath->query($queryDoc);

            if ($docNodes->length > 0) {
                if ($docNodes->item(0)->nodeName == 'w:sdt') {
                    $tempDoc = new DomDocument();
                    $sdt = $tempDoc->importNode($docNodes->item(0), true);
                    $newNode = $tempDoc->appendChild($sdt);
                    $frontPage = $tempDoc->saveXML($newNode);
                    $this->_wordDocumentC .= $frontPage;
                }
            }
        } else {
            // get the contents of the file
            $queryBody = '//w:body';
            $bodyNodes = $docXpath->query($queryBody);
            $bodyNode = $bodyNodes->item(0);
            $bodyChilds = $bodyNode->childNodes;
            foreach ($bodyChilds as $node) {
                if ($node->nodeName != 'w:sectPr') {
                    $this->_wordDocumentC .= $baseDocument->saveXML($node);
                }
            }
        }
        // create the a tempDocumentDOM for further manipulation
        $this->_tempDocumentDOM = $this->getDOMDocx();
        $querySectPr = '//w:body/w:sectPr';
        $sectPrNodes = $docXpath->query($querySectPr);
        $sectPr = $sectPrNodes->item(0);
        $this->_sectPr = new DOMDocument();
        $sectNode = $this->_sectPr->importNode($sectPr, true);
        $this->_sectPr->appendChild($sectNode);

        $this->_contentTypeT = $this->getFromZip('[Content_Types].xml', 'DOMDocument');

        // include the standard image defaults
        $this->generateDEFAULT('gif', 'image/gif');
        $this->generateDEFAULT('jpg', 'image/jpg');
        $this->generateDEFAULT('png', 'image/png');
        $this->generateDEFAULT('jpeg', 'image/jpeg');
        $this->generateDEFAULT('bmp', 'image/bmp');

        // get the rels file
        $this->_wordRelsDocumentRelsT = $this->getFromZip('word/_rels/document.xml.rels', 'DOMDocument');
        $relationships = $this->_wordRelsDocumentRelsT->getElementsByTagName('Relationship');

        // get the styles
        $this->_wordStylesT = $this->getFromZip('word/styles.xml', 'DOMDocument');
        // get the settings
        $this->_wordSettingsT = $this->getFromZip('word/settings.xml', 'DOMDocument');

        // use some default styles, for example, in the creation of lists, footnotes, titles, ...
        // So we should make sure that it is included in the styles.xml document
        if (!$this->_defaultTemplate || $this->_docxTemplate) {
            $this->importStyles(PHPDOCX_BASE_TEMPLATE, 'PHPDOCXStyles');
        }

        // get the numbering
        // if it does not exist it will return false
        $this->_wordNumberingT = $this->getFromZip('word/numbering.xml');

        // manage the numbering.xml and style.xml files
        // first check if the base template file has a numbering.xml file
        $numRef = rand(9999999, 99999999);
        self::$numUL = $numRef;
        self::$numOL = $numRef + 1;
        if ($this->_wordNumberingT !== false) {
            $this->_wordNumberingT = $this->importSingleNumbering($this->_wordNumberingT, OOXMLResources::$unorderedListStyle, self::$numUL);
            $this->_wordNumberingT = $this->importSingleNumbering($this->_wordNumberingT, OOXMLResources::$orderedListStyle, self::$numOL);
        } else {
            $this->_wordNumberingT = $this->generateBaseWordNumbering();
            $this->_wordNumberingT = $this->importSingleNumbering($this->_wordNumberingT, OOXMLResources::$unorderedListStyle, self::$numUL);
            $this->_wordNumberingT = $this->importSingleNumbering($this->_wordNumberingT, OOXMLResources::$orderedListStyle, self::$numOL);
            //Now we should include the corresponding relationshipand Override
            $this->generateRELATIONSHIP(
                    'rId' . rand(99999999, 999999999), 'numbering', 'numbering.xml'
            );
            $this->generateOVERRIDE('/word/numbering.xml', 'application/vnd.openxmlformats-officedocument.wordprocessingml.numbering+xml');
        }
        // make sure that there are the corresponding xmls, with all their relationships for endnotes and footnotes
        // footnotes
        if ($this->getFromZip('word/footnotes.xml') === false) {
            $this->_wordFootnotesT->loadXML(OOXMLResources::$footnotesXML);
            // include the corresponding relationshipand Override
            $this->generateRELATIONSHIP(
                    'rId' . rand(99999999, 999999999), 'footnotes', 'footnotes.xml'
            );
            $this->generateOVERRIDE('/word/footnotes.xml', 'application/vnd.openxmlformats-officedocument.wordprocessingml.footnotes+xml');
        } else {
            $this->_wordFootnotesT = $this->getFromZip('word/footnotes.xml', 'DOMDocument');
        }
        if ($this->getFromZip('word/_rels/footnotes.xml.rels') === false) {
            $this->_wordFootnotesRelsT->loadXML(OOXMLResources::$notesXMLRels);
        } else {
            $this->_wordFootnotesRelsT = $this->getFromZip('word/_rels/footnotes.xml.rels', 'DOMDocument');
        }
        // endnotes
        if ($this->getFromZip('word/endnotes.xml') === false) {
            $this->_wordEndnotesT->loadXML(OOXMLResources::$endnotesXML);
            //Now we should include the corresponding relationshipand Override
            $this->generateRELATIONSHIP(
                    'rId' . rand(99999999, 999999999), 'endnotes', 'endnotes.xml'
            );
            $this->generateOVERRIDE('/word/endnotes.xml', 'application/vnd.openxmlformats-officedocument.wordprocessingml.endnotes+xml');
        } else {
            $this->_wordEndnotesT = $this->getFromZip('word/endnotes.xml', 'DOMDocument');
        }
        if ($this->getFromZip('word/_rels/endnotes.xml.rels') === false) {
            $this->_wordEndnotesRelsT->loadXML(OOXMLResources::$notesXMLRels);
        } else {
            $this->_wordEndnotesRelsT = $this->getFromZip('word/_rels/endnotes.xml.rels', 'DOMDocument');
        }
        // comments
        if ($this->getFromZip('word/comments.xml') === false) {
            $this->_wordCommentsT->loadXML(OOXMLResources::$commentsXML);
            //Now we should include the corresponding relationshipand Override
            $this->generateRELATIONSHIP(
                    'rId' . rand(99999999, 999999999), 'comments', 'comments.xml'
            );
            $this->generateOVERRIDE('/word/comments.xml', 'application/vnd.openxmlformats-officedocument.wordprocessingml.comments+xml');
        } else {
            $this->_wordCommentsT = $this->getFromZip('word/comments.xml', 'DOMDocument');
        }
        if ($this->getFromZip('word/_rels/comments.xml.rels') === false) {
            $this->_wordCommentsRelsT->loadXML(OOXMLResources::$notesXMLRels);
        } else {
            $this->_wordCommentsRelsT = $this->getFromZip('word/_rels/comments.xml.rels', 'DOMDocument');
        }

        // take care of the case that the template used is not one of the default preprocessed templates

        if ($this->_defaultTemplate) {
            self::$numUL = 1;
            self::$numOL = rand(9999, 999999999);
        } else {
            if (!$this->_docxTemplate) {
                // do some cleaning of the files from the base template zip
                // first look at the document.xml.rels file to analyze the contents
                // analyze its structure
                // in order to do that parse word/_rels/document.xml.rels
                $counter = $relationships->length - 1;

                for ($j = $counter; $j > -1; $j--) {
                    $completeType = $relationships->item($j)->getAttribute('Type');
                    $target = $relationships->item($j)->getAttribute('Target');
                    $tempArray = explode('/', $completeType);
                    $type = array_pop($tempArray);
                    // this array holds the data that has to be changed
                    $arrayCleaner = [];

                    switch ($type) {
                        case 'header':
                            array_push($this->_relsHeader, $target);
                            break;
                        case 'footer':
                            array_push($this->_relsFooter, $target);
                            break;
                        case 'chart':
                            $this->recursiveDelete($this->_baseTemplateFilesPath . '/word/charts');
                            $this->_wordRelsDocumentRelsT->documentElement->removeChild($relationships->item($j));
                            break;
                        case 'embeddings':
                            $this->recursiveDelete($this->_baseTemplateFilesPath . '/word/embeddings');
                            $this->_wordRelsDocumentRelsT->documentElement->removeChild($relationships->item($j));
                            break;
                    }
                }
            } else {
                // parse word/_rels/document.xml.rels
                $counter = $relationships->length - 1;

                for ($j = $counter; $j > -1; $j--) {
                    $completeType = $relationships->item($j)->getAttribute('Type');
                    $target = $relationships->item($j)->getAttribute('Target');
                    $tempArray = explode('/', $completeType);
                    $type = array_pop($tempArray);
                    // this array holds the data that has to be changed
                    $arrayCleaner = [];

                    switch ($type) {
                        case 'header':
                            array_push($this->_relsHeader, $target);
                            break;
                        case 'footer':
                            array_push($this->_relsFooter, $target);
                            break;
                    }
                }
            }
        }
        //make sure that we are using the default paper size and the default language
        if (!$this->_docxTemplate) {
            $this->modifyPageLayout($this->_phpdocxconfig['settings']['paper_size']);
            $this->setLanguage($this->_phpdocxconfig['settings']['language']);
        }
        //set bidi and rtl static variables
        if (isset($this->_phpdocxconfig['settings']['bidi'])) {
            self::$bidi = $this->_phpdocxconfig['settings']['bidi'];
        } else {
            self::$bidi = false;
        }
        if (isset($this->_phpdocxconfig['settings']['rtl'])) {
            self::$rtl = $this->_phpdocxconfig['settings']['rtl'];
        } else {
            self::$rtl = false;
        }
        if (self::$bidi || self::$rtl) {
            $this->setRTL(['bidi' => self::$bidi, 'rtl' => self::$rtl]);
        }
    }

    /**
     * Destruct
     *
     * @access public
     */
    public function __destruct()
    {
        
    }

    /**
     * Magic method, returns current word XML
     *
     * @access public
     * @return string Return current word
     */
    public function __toString()
    {
        $this->generateTemplateWordDocument();
        //PhpdocxLogger::logger('Get document template content.', 'debug');
        return $this->_wordDocumentT;
    }

    /**
     * Setter
     *
     * @access public
     */
    public function setXmlWordDocument($domDocument)
    {
        $stringDoc = $domDocument->saveXML();
        $bodyTag = explode('<w:body>', $stringDoc);
        $this->_wordDocumentC = str_replace('</w:body></w:document>', '', $bodyTag[1]);
    }

    /**
     * Getter
     *
     * @access public
     */
    public function getDOMDocx()
    {
        $loadContent = $this->_documentXMLElement . '<w:body>' .
                $this->_wordDocumentC . '</w:body></w:document>';
        $domDocument = new DomDocument();
        $domDocument->loadXML($loadContent);
        return $domDocument;
    }

    /**
     * Getter
     *
     * @access public
     */
    public function getDOMComments()
    {
        return $this->_wordCommentsT;
    }

    /**
     * Getter
     *
     * @access public
     */
    public function getDOMEndnotes()
    {
        return $this->_wordEndnotesT;
    }

    /**
     * Getter
     *
     * @access public
     */
    public function getDOMFootnotes()
    {
        return $this->_wordFootnotesT;
    }

    /**
     * Adds a background image to the document
     *
     * @access public
     * @example ../examples/easy/BackgroundImage.php
     * @param string $src
     */
    public function addBackgroundImage($src)
    {
        // extract some basic info about the background image
        $image = pathinfo($src);
        $extension = $image['extension'];
        $imageName = $image['filename'];
        // define an unique identifier
        $tempId = uniqid(true);
        $identifier = 'rId' . $tempId;

        // construct the background WordML code
        $this->_background = '<w:background w:color="' . $this->_backgroundColor . '">
                      <v:background id="id_' . uniqid() . '" o:bwmode="white" o:targetscreensize="800,600">
                      <v:fill r:id="' . $identifier . '" o:title="tit_' . uniqid(true) . '" recolor="t" type="frame" />
                      </v:background></w:background>';
        // make sure that there exists the corresponding content type
        $this->generateDEFAULT($extension, 'image/' . $extension);
        // copy the image in the media folder
        $this->saveToZip($src, 'word/media/img' . $tempId . '.' . $extension);
        // insert the relationship
        $relsImage = '<Relationship Id="' . $identifier . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="media/img' . $tempId . '.' . $extension . '" />';
        $relsNodeImage = $this->_wordRelsDocumentRelsT->createDocumentFragment();
        $relsNodeImage->appendXML($relsImage);
        $this->_wordRelsDocumentRelsT->documentElement->appendChild($relsNodeImage);
        // modify the settings to display the background image
        $this->docxSettings(['displayBackgroundShape' => true]);
    }

    /**
     * Adds a bookmart start or end tag
     *
     * @access public
     * @example ../examples/easy/Bookmarks.php
     * @param array $options
     * Values:
     * 'type' (start, end)
     * 'name' (string)
     */
    public function addBookmark($options = ['type' => null, 'name' => null])
    {
        $class = get_class($this);
        $type = $options['type'];
        $name = $options['name'];
        // first check for the requested parameters
        if (empty($type) || empty($name)) {
            //PhpdocxLogger::logger('The addBookmark method is lacking at least one required parameter', 'fatal');
        }
        if ($type == 'start') {
            $bookmarkId = rand(9999999, 999999999);
            $bookmark = '<w:bookmarkStart w:id="' . $bookmarkId . '" w:name="' . $name . '" />';
            CreateDocx::$bookmarksIds[$name] = $bookmarkId;
        } else if ($type == 'end') {
            if (empty(CreateDocx::$bookmarksIds[$name])) {
                //PhpdocxLogger::logger('You are trying to end a nonexisting bookmark', 'fatal');
            }
            $bookmark = '<w:bookmarkEnd w:id="' . CreateDocx::$bookmarksIds[$name] . '" />';
            unset(CreateDocx::$bookmarksIds[$name]);
        } else {
            //PhpdocxLogger::logger('The addBookmark type is incorrect', 'fatal');
        }
        //PhpdocxLogger::logger('Adds a bookmark' . $type . ' to the Word document.', 'info');
        if ($class == 'WordFragment') {
            $this->wordML .= (string) $bookmark;
        } else {
            $this->_wordDocumentC .= (string) $bookmark;
        }
    }

    /**
     * Add a break
     *
     * @access public
     * @example ../examples/easy/PageBreak.php
     * @example ../examples/intermediate/Chart_footnote.php
     * @example ../examples/intermediate/FooterPager.php
     * @example ../examples/intermediate/Multidocument.php
     * @example ../examples/advanced/Report.php
     * @param array $options
     *  Values:
     * 'type' (line, page, column)
     * 'number' (int) the number of breaks that we want to include
     */
    public function addBreak($options = ['type' => 'line', 'number' => 1])
    {
        if (!isset($options['type'])) {
            $options['type'] = 'line';
        }
        if (!isset($options['number'])) {
            $options['number'] = 1;
        }

        $class = get_class($this);
        $break = CreatePage::getInstance();
        $break->generatePageBreak($options);
        //PhpdocxLogger::logger('Add break to word document.', 'info');
        if ($class == 'WordFragment') {
            $this->wordML .= (string) $break;
        } else {
            $this->_wordDocumentC .= (string) $break;
        }
    }

    /**
     * Add a chart
     *
     * @access public
     * @example ../examples/easy/Chart.php
     * @example ../examples/easy/Chart_area3D.php
     * @example ../examples/easy/Chart_bar.php
     * @example ../examples/easy/Chart_barStacked.php
     * @example ../examples/easy/Chart_bubble.php
     * @example ../examples/easy/Chart_col.php
     * @example ../examples/easy/Chart_doughnut.php
     * @example ../examples/easy/Chart_line.php
     * @example ../examples/easy/Chart_ofPieChart_bar.php
     * @example ../examples/easy/Chart_ofPieChart_pie.php
     * @example ../examples/easy/Chart_percentstaked.php
     * @example ../examples/easy/Chart_radar.php
     * @example ../examples/easy/Chart_scatter.php
     * @example ../examples/easy/Chart_surface.php
     * @example ../examples/intermediate/Chart.php
     * @example ../examples/intermediate/Chart_cylinder.php
     * @example ../examples/intermediate/Chart_footnote.php
     * @example ../examples/intermediate/Multidocument.php
     * @example ../examples/advanced/Report.php
     * @param array $options
     *  Values: 'color' (1, 2, 3...) color scheme,
     *  'perspective' (20, 30...),
     *  'rotX' (20, 30...),
     *  'rotY' (20, 30...),
     *  'data' (array of values),
     *  'float' (left, right, center) floating chart. It only applies if textWrap is not inline (default value).
     *  'font' (Arial, Times New Roman...),
     *  'groupBar' (clustered, stacked, percentStacked),
     *  'horizontalOffset' (int) given in emus (1cm = 360000 emus)
     *  'chartAlign' (center, left, right),
     *  'showPercent' (0, 1),
     *  'sizeX' (10, 11, 12...),
     *  'sizeY' (10, 11, 12...),
     *  'textWrap' (0 (inline), 1 (square), 2 (front), 3 (back), 4 (up and bottom)),
     *  'verticalOffset' (int) given in emus (1cm = 360000 emus)
     *  'title',
     *  'type' (barChart, bar3DChart, bar3DChartCylinder, bar3DChartCone,  bar3DChartPyramid, colChart, col3DChart,
     *          col3DChartCylinder,  col3DChartCone, bar3DChartPyramid, pieChart, pie3DChart, lineChart, line3DChart,
     *          areaChart, area3DChart, radar, scatterChart, surfaceChart,ofpiechar, doughnut, bublechart)
     *  'legendPos' (r, l, t, b, none),
     *  'legendOverlay' (0, 1),
     *  'border' (0, 1),
     *  'haxLabel' horizontal axis label,
     *  'vaxLabel' vertical axis label,
     *  'showTable' (0, 1) shows the table of values,
     *  'vaxLabelDisplay' (rotated, vertical, horizontal),
     *  'haxLabelDisplay' (rotated, vertical, horizontal),
     *  'hgrid' (0, 1, 2, 3),
     *  'vgrid' (0, 1, 2, 3),
     *  'style' this work only in radar charts.
     *  'gapWidth' distance between the pie and the second chart(ofpiechart)
     *  'secondPieSize' : size of the second chart(ofpiechart)
     *  'splitType' how decide to split the values :auto(Default Split), cust(Custom Split), percent(Split by Percentage), pos(Split by Position), val(Split by Value)
     *  'splitPos' split position , integer or float
     *  'custSplit' array of index to split
     *  'subtype' type of the second chart pie or bar
     *  'explosion' distance between the diferents values
     *  'holeSize' size of the hole in doughnut type
     *  'symbol'  array of symbols(scatter chart)
     *  'symbolSize' the size of the simbols
     *  'smooth' smooth the line (scatter chart)
     *  'wireframe' boolean(surface chart)to remove content color and only leave the border colors
     *  'showValue' (0,1) shows the values inside the chart
     *  'showCategory' (0,1) shows the category inside the chart
     */
    public function addChart($options = [])
    {
        //PhpdocxLogger::logger('Create chart.', 'debug');
        $class = get_class($this);

        $options = self::translateChartOptions2StandardFormat($options);
        try {
            if (isset($options['data']) && isset($options['type'])) {
                self::$intIdWord++;
                //PhpdocxLogger::logger('New ID ' . self::$intIdWord . ' . Chart.', 'debug');
                $type = $options['type'];
                if (strpos($type, 'Chart') === false)
                    $type .= 'Chart';

                $graphic = CreateChartFactory::createObject($type);

                if ($graphic->createGraphic(self::$intIdWord, $options) != false) {

                    $this->_zipDocx->addFromString(
                            'word/charts/chart' . self::$intIdWord . '.xml', $graphic->getXmlChart()
                    );
                    $this->generateRELATIONSHIP(
                            'rId' . self::$intIdWord, 'chart', 'charts/chart' . self::$intIdWord . '.xml'
                    );
                    $this->generateDEFAULT('xlsx', 'application/octet-stream');
                    $this->generateOVERRIDE(
                            '/word/charts/chart' . self::$intIdWord . '.xml', 'application/vnd.openxmlformats-officedocument.' .
                            'drawingml.chart+xml'
                    );
                } else {
                    throw new Exception(
                    'There was an error related to the chart.'
                    );
                }
                $excel = $graphic->getXlsxType();

                $this->_tempFileXLSX[self::$intIdWord] = tempnam($this->_tempDir, 'documentxlsx');
                if (
                        $excel->createXlsx(
                                $this->_tempFileXLSX[self::$intIdWord], $options['data']
                        ) != false
                ) {
                    $this->_zipDocx->addFile(
                            $this->_tempFileXLSX[self::$intIdWord], 'word/embeddings/datos' . self::$intIdWord . '.xlsx'
                    );

                    $chartRels = CreateChartRels::getInstance();
                    $chartRels->createRelationship(self::$intIdWord);
                    $this->_zipDocx->addFromString(
                            'word/charts/_rels/chart' . self::$intIdWord .
                            '.xml.rels', (string) $chartRels
                    );
                }
                if ($class == 'WordFragment') {
                    $this->wordML .= (string) $graphic;
                } else {
                    $this->_wordDocumentC .= (string) $graphic;
                }
            } else {
                throw new Exception(
                'Charts must have data and type values.'
                );
            }
        } catch (Exception $e) {
            //PhpdocxLogger::logger($e->getMessage(), 'fatal');
        }
    }

    /**
     * Adds a comment
     *
     * @access public
     * @example ../examples/easy/Comment.php
     * @param array $options
     *  Values:
     * 'textDocument'(mixed) a string of text to appear in the document body as anchor for the comment or an array with the text and associated text options
     * 'textComment' (mixed) a string of text to be used as the comment text or a Word fragment
     * 'initials' (string)
     * 'author' (string)
     * 'date' (string)
     */
    public function addComment($options = [])
    {
        $class = get_class($this);
        $id = rand(9999, 32766); //this number can not be bigger or equal than 32767
        $idBookmark = uniqid(true);
        if ($options['textComment'] instanceof WordFragment) {
            $commentBase = '<w:comment w:id="' . $id . '"';
            if (isset($options['initials'])) {
                $commentBase .= ' w:initials="' . $options['initials'] . '"';
            }
            if (isset($options['author'])) {
                $commentBase .= ' w:author="' . $options['author'] . '"';
            }
            if (isset($options['date'])) {
                $commentBase .= ' w:date="' . date("Y-m-d\TH:i:s\Z", strtotime($options['date'])) . '"';
            }
            $commentBase .= ' xmlns:ve="http://schemas.openxmlformats.org/markup-compatibility/2006"
                xmlns:o="urn:schemas-microsoft-com:office:office"
                xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"
                xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math"
                xmlns:v="urn:schemas-microsoft-com:vml"
                xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing"
                xmlns:w10="urn:schemas-microsoft-com:office:word"
                xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"
                xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml"
                >';
            $commentBase .= $this->parseWordMLNote('comment', $options['textComment'], [], []);
            $commentBase .= '<w:bookmarkStart w:id="' . $idBookmark . '" w:name="_GoBack"/><w:bookmarkEnd w:id="' . $idBookmark . '"/>';
            $commentBase .= '</w:comment>';
        } else {
            $commentBase = '<w:comment w:id="' . $id . '"';
            if (isset($options['initials'])) {
                $commentBase .= ' w:initials="' . $options['initials'] . '"';
            }
            if (isset($options['author'])) {
                $commentBase .= ' w:author="' . $options['author'] . '"';
            }
            if (isset($options['date']) && ($options['date'] instanceof date )) {
                $commentBase .= ' w:date="' . date("Y-m-d\TH:i:s\Z", strtotime($options['date'])) . '"';
            }
            $commentBase .= ' xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" ><w:p>
                <w:pPr><w:pStyle w:val="commentTextPHPDOCX"/>';
            if (self::$bidi) {
                $commentBase .= '<w:bidi />';
            }
            $commentBase .= '</w:pPr>';
            $commentBase .= '<w:r><w:rPr><w:rStyle w:val="commentReferencePHPDOCX"/>';
            if (self::$rtl) {
                $commentBase .= '<w:rtl />';
            }
            $commentBase .= '</w:rPr><w:annotationRef/></w:r>';
            $commentBase .= '<w:r>';
            if (self::$rtl) {
                $commentBase .= '<w:rPr><w:rtl /></w:rPr>';
            }
            $commentBase .= '<w:t xml:space="preserve">' . $options['textComment'] . '</w:t></w:r></w:p>';
            $commentBase .= '<w:bookmarkStart w:id="' . $idBookmark . '" w:name="_GoBack"/><w:bookmarkEnd w:id="' . $idBookmark . '"/>';
            $commentBase .= '</w:comment>';
        }
        if (!is_array($options['textDocument'])) {
            $options['textDocument'] = ['text' => $options['textDocument']];
        }
        $textOptions = $options['textDocument'];
        $text = $textOptions['text'];
        $commentDocument = new WordFragment();
        $textOptions = self::setRTLOptions($textOptions);
        $commentDocument->addText($text, $textOptions);
        $commentStart = '</w:pPr><w:commentRangeStart w:id="' . $id . '"/>';
        $commentEnd .= '<w:commentRangeEnd w:id="' . $id . '"/>
                         <w:r><w:rPr><w:rStyle w:val="CommentReference"/>';
        if (self::$rtl) {
            $commentEnd .= '<w.rtl />';
        }
        $commentEnd .= '</w:rPr><w:commentReference w:id="' . $id . '"/></w:r></w:p>';
        // clean the commentDocument from auxilairy variable
        $commentDocument = preg_replace('/__[A-Z]+__/', '', $commentDocument);
        // pPrepare the data
        $commentDocument = str_replace('</w:pPr>', $commentStart, $commentDocument);
        $commentDocument = str_replace('</w:p>', $commentEnd, $commentDocument);


        $tempNode = $this->_wordCommentsT->createDocumentFragment();
        $tempNode->appendXML($commentBase);
        $this->_wordCommentsT->documentElement->appendChild($tempNode);


        //PhpdocxLogger::logger('Add comment to word document.', 'info');

        if ($class == 'WordFragment') {
            $this->wordML .= (string) $commentDocument;
        } else {
            $this->_wordDocumentC .= (string) $commentDocument;
        }
    }

    /**
     * Adds date and hour to the Word document
     *
     * @access public
     * @example ../examples/easy/DateAndHour.php
     * @param array $options Style options to apply to the date
     *  Values:
     * 'bidi' (boolean) set to true for right to left languages
     * 'bold' (boolean)
     * 'color' (ffffff, ff0000...)
     * 'dateFormat (string) dd/MM/yyyy H:mm:ss (default value) One may define a
     * customised format like dd' of 'MMMM' of 'yyyy' at 'H:mm (resulting in 20 of December of 2012 at 9:30)
     * 'font' (Arial, Times New Roman...)
     * 'fontSize' (int)
     * 'italic' (boolean)
     * 'lineSpacing' 120, 240 (standard), 480...
     * 'indentLeft' (int) in twentieths of a point (twips)
     * 'indentRight' (int) in twentieths of a point (twips)
     * 'pageBreakBefore' (on, off)
     * 'textAlign' (both, center, distribute, left, right)
     * 'underline' (dash, dotted, double, single, wave, words)
     * 'widowControl' (boolean)
     * 'wordWrap' (boolean)     
     *
     */
    public function addDateAndHour($options = ['dateFormat' => 'dd/MM/yyyy H:mm:ss'])
    {
        $options = self::setRTLOptions($options);
        $class = get_class($this);
        if (!isset($options['dateFormat'])) {
            $options['dateFormat'] = 'dd/MM/yyyy H:mm:ss';
        }
        $date = new WordFragment();
        $date->addText('date', $options);
        $date = preg_replace('/__[A-Z]+__/', '', $date);
        $dateRef = '<?xml version="1.0" encoding="UTF-8" ?>' . $date;
        $dateRef = str_replace('<w:p>', '<w:p xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">', $dateRef);
        $dateDOM = new DOMDocument();
        $dateDOM->loadXML($dateRef);
        $pPrNodes = $dateDOM->getElementsByTagName('pPr');
        if ($pPrNodes->length > 0) {
            $pPrContent = $dateDOM->saveXML($pPrNodes->item(0));
        } else {
            $pPrContent = '';
        }
        $rPrNodes = $dateDOM->getElementsByTagName('rPr');
        if ($rPrNodes->length > 0) {
            $rPrContent = $dateDOM->saveXML($rPrNodes->item(0));
        } else {
            $rPrContent = '';
        }
        if ($pPrContent != '') {
            $pPrContent = str_replace('</w:pPr>', $rPrContent . '</w:pPr>', $pPrContent);
        } else {
            $pPrContent = '<w:pPr>' . $rPrContent . '</w:pPr>';
        }
        $runs = '<w:r>' . $rPrContent . '<w:fldChar w:fldCharType="begin" /></w:r>';
        $runs .= '<w:r>' . $rPrContent . '<w:instrText xml:space="preserve">TIME \@ &quot;' . $options['dateFormat'] . '&quot;</w:instrText></w:r>';
        $runs .= '<w:r>' . $rPrContent . '<w:fldChar w:fldCharType="separate" /></w:r>';
        $runs .= '<w:r>' . $rPrContent . '<w:t>date</w:t></w:r>';
        $runs .= '<w:r>' . $rPrContent . '<w:fldChar w:fldCharType="end" /></w:r>';

        $date = '<w:p>' . $pPrContent . $runs . '</w:p>';
        //PhpdocxLogger::logger('Add a date to word document.', 'info');
        if ($class == 'WordFragment') {
            $this->wordML .= (string) $date;
        } else {
            $this->_wordDocumentC .= (string) $date;
        }
    }

    /**
     * Adds an endnote
     *
     * @access public
     * @example ../examples/easy/Endnote.php
     * @example ../examples/intermediate/EndnoteAndFootnote.php
     * @param array $options.
     * Values:
     * 'textDocument'(mixed) a string of text to appear in the document body or an array with the text and associated text options
     * 'textEndnote' (mixed) a string of text to be used as the endnote text or a WordML fragment
     * 'endnoteMark' (array) bidi, customMark, font, fontSize, bold, italic, color, rtl
     * 'referenceMark' (array) bidi, font, fontSize, bold, italic, color, rtl
     */
    public function addEndnote($options = [])
    {
        $options['endnoteMark'] = self::translateTextOptions2StandardFormat($options['endnoteMark']);
        $options['endnoteMark'] = self::setRTLOptions($options['endnoteMark']);
        $options['referenceMark'] = self::translateTextOptions2StandardFormat($options['referenceMark']);
        $options['referenceMark'] = self::setRTLOptions($options['referenceMark']);
        $class = get_class($this);
        $id = rand(9999, 32766); //this number can not be bigger or equal than 32767
        if ($options['textEndnote'] instanceof WordFragment) {
            $endnoteBase = '<w:endnote w:id="' . $id . '"
                xmlns:ve="http://schemas.openxmlformats.org/markup-compatibility/2006"
                xmlns:o="urn:schemas-microsoft-com:office:office"
                xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"
                xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math"
                xmlns:v="urn:schemas-microsoft-com:vml"
                xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing"
                xmlns:w10="urn:schemas-microsoft-com:office:word"
                xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"
                xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml"
                >';
            $endnoteBase .= $this->parseWordMLNote('endnote', $options['textEndnote'], $options['endnoteMark'], $options['referenceMark']);
            $endnoteBase .= '</w:endnote>';
        } else {
            $endnoteBase = '<w:endnote w:id="' . $id . '" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"><w:p>
                <w:pPr><w:pStyle w:val="endnoteTextPHPDOCX"/>';
            if (self::$bidi) {
                $endnoteBase .= '<w:bidi />';
            }
            $endnoteBase .= '</w:pPr><w:r><w:rPr><w:rStyle w:val="endnoteReferencePHPDOCX"/>';

            //Parse the referenceMark options
            if (isset($options['referenceMark']['font'])) {
                $endnoteBase .= '<w:rFonts w:ascii="' . $options['referenceMark']['font'] .
                        '" w:hAnsi="' . $options['referenceMark']['font'] .
                        '" w:cs="' . $options['referenceMark']['font'] . '"/>';
            }
            if (isset($options['referenceMark']['b'])) {
                $endnoteBase .= '<w:b w:val="' . $options['referenceMark']['b'] . '"/>';
                $endnoteBase .= '<w:bCs w:val="' . $options['referenceMark']['b'] . '"/>';
            }
            if (isset($options['referenceMark']['i'])) {
                $endnoteBase .= '<w:i w:val="' . $options['referenceMark']['i'] . '"/>';
                $endnoteBase .= '<w:iCs w:val="' . $options['referenceMark']['i'] . '"/>';
            }
            if (isset($options['referenceMark']['color'])) {
                $endnoteBase .= '<w:color w:val="' . $options['referenceMark']['color'] . '"/>';
            }
            if (isset($options['referenceMark']['sz'])) {
                $endnoteBase .= '<w:sz w:val="' . (2 * $options['referenceMark']['sz']) . '"/>';
                $endnoteBase .= '<w:szCs w:val="' . (2 * $options['referenceMark']['sz']) . '"/>';
            }
            if (isset($options['referenceMark']['rtl']) && $options['referenceMark']['rtl']) {
                $endnoteBase .= '<w:rtl />';
            }
            $endnoteBase .= '</w:rPr>';
            if (isset($options['endnoteMark']['customMark'])) {
                $endnoteBase .= '<w:t>' . $options['endnoteMark']['customMark'] . '</w:t>';
            } else {
                $endnoteBase .= '<w:endnoteRef/>';
            }
            $endnoteBase .= '</w:r>';
            if (self::$rtl) {
                $endnoteBase .= '<w:rPr><w:rtl /></w:rPr>';
            }
            $endnoteBase .= '<w:r><w:t xml:space="preserve">' . $options['textEndnote'] . '</w:t></w:r></w:p>
                </w:endnote>';
        }
        if (!is_array($options['textDocument'])) {
            $options['textDocument'] = ['text' => $options['textDocument']];
        }
        $textOptions = $options['textDocument'];
        $textOptions = self::setRTLOptions($textOptions);
        $text = $textOptions['text'];
        $endnoteDocument = new WordFragment();
        $endnoteDocument->addText($text, $textOptions);
        $endnoteMark = '<w:r><w:rPr><w:rStyle w:val="endnoteReferencePHPDOCX" />';
        //Parse the endnoteMark options
        if (isset($options['endnoteMark']['font'])) {
            $endnoteMark .= '<w:rFonts w:ascii="' . $options['endnoteMark']['font'] .
                    '" w:hAnsi="' . $options['endnoteMark']['font'] .
                    '" w:cs="' . $options['endnoteMark']['font'] . '"/>';
        }
        if (isset($options['endnoteMark']['b'])) {
            $endnoteMark .= '<w:b w:val="' . $options['endnoteMark']['b'] . '"/>';
            $endnoteMark .= '<w:bCs w:val="' . $options['endnoteMark']['b'] . '"/>';
        }
        if (isset($options['endnoteMark']['i'])) {
            $endnoteMark .= '<w:i w:val="' . $options['endnoteMark']['i'] . '"/>';
            $endnoteMark .= '<w:iCs w:val="' . $options['endnoteMark']['i'] . '"/>';
        }
        if (isset($options['endnoteMark']['color'])) {
            $endnoteMark .= '<w:color w:val="' . $options['endnoteMark']['color'] . '"/>';
        }
        if (isset($options['endnoteMark']['sz'])) {
            $endnoteMark .= '<w:sz w:val="' . (2 * $options['endnoteMark']['sz']) . '"/>';
            $endnoteMark .= '<w:szCs w:val="' . (2 * $options['endnoteMark']['sz']) . '"/>';
        }
        if (isset($options['endnoteMark']['rtl']) && $options['endnoteMark']['rtl']) {
            $endnoteMark .= '<w:rtl />';
        }
        $endnoteMark .= '</w:rPr><w:endnoteReference w:id="' . $id . '" ';
        if (isset($options['endnoteMark']['customMark'])) {
            $endnoteMark .= 'w:customMarkFollows="1"/><w:t>' . $options['endnoteMark']['customMark'] . '</w:t>';
        } else {
            $endnoteMark .= '/>';
        }
        $endnoteMark .= '</w:r></w:p>';
        $endnoteDocument = str_replace('</w:p>', $endnoteMark, $endnoteDocument);
        //Clean the endnoteDocument from auxilairy variable
        $endnoteDocument = preg_replace('/__[A-Z]+__/', '', $endnoteDocument);

        $tempNode = $this->_wordEndnotesT->createDocumentFragment();
        $tempNode->appendXML($endnoteBase);
        $this->_wordEndnotesT->documentElement->appendChild($tempNode);


        //PhpdocxLogger::logger('Add endnote to word document.', 'info');
        if ($class == 'WordFragment') {
            $this->wordML .= (string) $endnoteDocument;
        } else {
            $this->_wordDocumentC .= (string) $endnoteDocument;
        }
    }
    
    /**
     * Embeds a external DOCX, HTML, MHT or RTF file
     *
     * @access public
     * @param array $options
     * 'src' (string) path to the external file
     * 'firstMatch (boolean) if true it only replaces the first variable match. Default is set to false.
     * 'matchSource' (boolean) if true (default value)tries to preserve as much as posible the styles of the docx to be included
     * 'preprocess' (boolean) if true does some preprocessing on the docx file to add
     * @return void
     */
    public function addExternalFile($options)
    {
       if (file_exists($options['src'])) {
            $extension = pathinfo($options['src'], PATHINFO_EXTENSION);
            if ($extension == 'docx') {
                $this->addDOCX($options);
            } elseif ($extension == 'html') {
                $this->addHTML($options);
            } elseif ($extension == 'mht') {
                $this->addMHT($options);
            } elseif ($extension == 'rtf') {
                $this->addRTF($options);
            } else {
                //PhpdocxLogger::logger('Invalid file extension', 'fatal');
            }
        } else {
            //PhpdocxLogger::logger('The file does not exist', 'fatal');
        }
    }

    /**
     * Add a footer
     *
     * @access public
     * @example ../examples/easy/Footer.php
     * @example ../examples/intermediate/HeaderAndFooter.php
     * @example ../examples/advanced/Report.php
     * @param array $footer
     * @param array
     *  Values:
     * 'default'(object) WordFragment
     * 'even' (object) WordFragment
     * 'first' (object) WordFragment
     */
    public function addFooter($footers)
    {
        $this->removeFooters();
        foreach ($footers as $key => $value) {
            if ($value instanceof WordFragment) {
                $this->_wordFooterT[$key] = '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>
                                            <w:ftr
                                                xmlns:ve="http://schemas.openxmlformats.org/markup-compatibility/2006"
                                                xmlns:o="urn:schemas-microsoft-com:office:office"
                                                xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"
                                                xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math"
                                                xmlns:v="urn:schemas-microsoft-com:vml"
                                                xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing"
                                                xmlns:w10="urn:schemas-microsoft-com:office:word"
                                                xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"
                                                xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml">';
                $this->_wordFooterT[$key] .= (string) $value;
                $this->_wordFooterT[$key] .= '</w:ftr>';
                $this->_wordFooterT[$key] = preg_replace('/__[A-Z]+__/', '', $this->_wordFooterT[$key]);
                // first insert image rels
                // then insert external images rels
                // then insert link rels
                $relationships = '';
                if (isset(CreateDocx::$_relsHeaderFooterImage[$key . 'Footer'])) {
                    foreach (CreateDocx::$_relsHeaderFooterImage[$key . 'Footer'] as $key2 => $value2) {
                        $relationships .= '<Relationship Id="' . $value2['rId'] . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="media/img' . $value2['rId'] . '.' . $value2['extension'] . '" />';
                    }
                }
                if (isset(CreateDocx::$_relsHeaderFooterExternalImage[$key . 'Footer'])) {
                    foreach (CreateDocx::$_relsHeaderFooterExternalImage[$key . 'Footer'] as $key2 => $value2) {
                        $relationships .= '<Relationship Id="' . $value2['rId'] . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="' . $value2['url'] . '" TargetMode="External" />';
                    }
                }
                if (isset(CreateDocx::$_relsHeaderFooterLink[$key . 'Footer'])) {
                    foreach (CreateDocx::$_relsHeaderFooterLink[$key . 'Footer'] as $key2 => $value2) {
                        $relationships .= '<Relationship Id="' . $value2['rId'] . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/hyperlink" Target="' . $value2['url'] . '" TargetMode="External" />';
                    }
                }
                // create the complete rels file relative to that footer
                if ($relationships != '') {
                    $rels = '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">';
                    $rels .= $relationships;
                    $rels .= '</Relationships>';
                }
                // include the footer xml files
                $this->saveToZip($this->_wordFooterT[$key], 'word/' . $key . 'Footer.xml');
                // include the footer rels files
                if (isset($rels)) {
                    $this->saveToZip($rels, 'word/_rels/' . $key . 'Footer.xml.rels');
                }
                // modify the document.xml.rels file
                $newId = uniqid(true);
                $newFooterNode = '<Relationship Id="rId';
                $newFooterNode .= $newId . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/footer"';
                $newFooterNode .= ' Target="' . $key . 'Footer.xml" />';
                $newNode = $this->_wordRelsDocumentRelsT->createDocumentFragment();
                $newNode->appendXML($newFooterNode);
                $baseNode = $this->_wordRelsDocumentRelsT->documentElement;
                $baseNode->appendChild($newNode);
                //7. modify accordingly the sectPr node
                $newSectNode = '<w:footerReference w:type="' . $key . '" r:id="rId' . $newId . '" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"/>';
                $sectNode = $this->_sectPr->createDocumentFragment();
                $sectNode->appendXML($newSectNode);
                $refNode = $this->_sectPr->documentElement->childNodes->item(0);
                $refNode->parentNode->insertBefore($sectNode, $refNode);
                if ($key == 'first') {
                    $this->generateTitlePg(false);
                } else if ($key == 'even') {
                    $this->generateSetting('w:evenAndOddHeaders');
                }
                // generate the corresponding Override element in [Content_Types].xml
                $this->generateOVERRIDE(
                        '/word/' . $key . 'Footer.xml', 'application/vnd.openxmlformats-officedocument.wordprocessingml.' .
                        'footer+xml'
                );
                // refresh the _relsFooter array
                $this->_relsFooter[] = $key . 'Footer.xml';
                // refresh the arrays used to hold the image and link data
                CreateDocx::$_relsHeaderFooterImage[$key . 'Footer'] = [];
                CreateDocx::$_relsHeaderFooterExternalImage[$key . 'Footer'] = [];
                CreateDocx::$_relsHeaderFooterLink[$key . 'Footer'] = [];
            } else {
                //PhpdocxLogger::logger('The footer contents must be WordML fragments', 'fatal');
            }
        }
    }

    /**
     * Adds a footnote
     *
     * @access public
     * @example ../examples/easy/Footnote.php
     * @example ../examples/intermediate/Chart_footnote.php
     * @example ../examples/intermediate/EndnoteAndFootnote.php
     * @param array $options
     *  Values:
     * 'textDocument'(mixed) a string of text to appear in the document body or an array with the text and associated text options
     * 'textFootnote' (mixed) a string of text to be used as the footnote text or a WordML fragment
     * 'footnoteMark' (array) bidi, customMark, font, fontSize, bold, italic, color, rtl
     * 'referenceMark' (array) bidi, font, fontSize, bold, italic, color, rtl
     */
    public function addFootnote($options = [])
    {
        $options['footnoteMark'] = self::translateTextOptions2StandardFormat($options['footnoteMark']);
        $options['footnoteMark'] = self::setRTLOptions($options['footnoteMark']);
        $options['referenceMark'] = self::translateTextOptions2StandardFormat($options['referenceMark']);
        $options['referenceMark'] = self::setRTLOptions($options['referenceMark']);
        $class = get_class($this);
        $id = rand(9999, 32766); //this number can not be bigger or equal than 32767
        if ($options['textFootnote'] instanceof WordFragment) {
            $footnoteBase = '<w:footnote w:id="' . $id . '"
                xmlns:ve="http://schemas.openxmlformats.org/markup-compatibility/2006"
                xmlns:o="urn:schemas-microsoft-com:office:office"
                xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"
                xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math"
                xmlns:v="urn:schemas-microsoft-com:vml"
                xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing"
                xmlns:w10="urn:schemas-microsoft-com:office:word"
                xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"
                xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml"
                >';
            $footnoteBase .= $this->parseWordMLNote('footnote', $options['textFootnote'], $options['footnoteMark'], $options['referenceMark']);
            $footnoteBase .= '</w:footnote>';
        } else {
            $footnoteBase = '<w:footnote w:id="' . $id . '" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"><w:p>
                <w:pPr><w:pStyle w:val="footnoteTextPHPDOCX"/>';
            if (self::$bidi) {
                $footnoteBase .= '<w:bidi />';
            }
            $footnoteBase .= '</w:pPr><w:r><w:rPr><w:rStyle w:val="footnoteReferencePHPDOCX"/>';
            // parse the referenceMark options
            if (isset($options['referenceMark']['font'])) {
                $footnoteBase .= '<w:rFonts w:ascii="' . $options['referenceMark']['font'] .
                        '" w:hAnsi="' . $options['referenceMark']['font'] .
                        '" w:cs="' . $options['referenceMark']['font'] . '"/>';
            }
            if (isset($options['referenceMark']['b'])) {
                $footnoteBase .= '<w:b w:val="' . $options['referenceMark']['b'] . '"/>';
                $footnoteBase .= '<w:bCs w:val="' . $options['referenceMark']['b'] . '"/>';
            }
            if (isset($options['referenceMark']['i'])) {
                $footnoteBase .= '<w:i w:val="' . $options['referenceMark']['i'] . '"/>';
                $footnoteBase .= '<w:iCs w:val="' . $options['referenceMark']['i'] . '"/>';
            }
            if (isset($options['referenceMark']['color'])) {
                $footnoteBase .= '<w:color w:val="' . $options['referenceMark']['color'] . '"/>';
            }
            if (isset($options['referenceMark']['sz'])) {
                $footnoteBase .= '<w:sz w:val="' . (2 * $options['referenceMark']['sz']) . '"/>';
                $footnoteBase .= '<w:szCs w:val="' . (2 * $options['referenceMark']['sz']) . '"/>';
            }
            if (isset($options['referenceMark']['rtl']) && $options['referenceMark']['rtl']) {
                $footnoteBase .= '<w:rtl />';
            }
            $footnoteBase .= '</w:rPr>';
            if (isset($options['footnoteMark']['customMark'])) {
                $footnoteBase .= '<w:t>' . $options['footnoteMark']['customMark'] . '</w:t>';
            } else {
                $footnoteBase .= '<w:footnoteRef/>';
            }
            $footnoteBase .= '</w:r>';
            if (self::$rtl) {
                $footnoteBase .= '<w:rPr><w:rtl /></w:rPr>';
            }
            $footnoteBase .= '<w:r><w:t xml:space="preserve">' . $options['textFootnote'] . '</w:t></w:r></w:p>
                </w:footnote>';
        }
        if (!is_array($options['textDocument'])) {
            $options['textDocument'] = ['text' => $options['textDocument']];
        }
        $textOptions = $options['textDocument'];
        $textOptions = self::setRTLOptions($textOptions);
        $text = $textOptions['text'];
        $footnoteDocument = new WordFragment();
        $footnoteDocument->addText($text, $textOptions);
        $footnoteMark = '<w:r><w:rPr><w:rStyle w:val="footnoteReferencePHPDOCX" />';
        // parse the footnoteMark options
        if (isset($options['footnoteMark']['font'])) {
            $footnoteMark .= '<w:rFonts w:ascii="' . $options['footnoteMark']['font'] .
                    '" w:hAnsi="' . $options['footnoteMark']['font'] .
                    '" w:cs="' . $options['footnoteMark']['font'] . '"/>';
        }
        if (isset($options['footnoteMark']['b'])) {
            $footnoteMark .= '<w:b w:val="' . $options['footnoteMark']['b'] . '"/>';
            $footnoteMark .= '<w:bCs w:val="' . $options['footnoteMark']['b'] . '"/>';
        }
        if (isset($options['footnoteMark']['i'])) {
            $footnoteMark .= '<w:i w:val="' . $options['footnoteMark']['i'] . '"/>';
            $footnoteMark .= '<w:iCs w:val="' . $options['footnoteMark']['i'] . '"/>';
        }
        if (isset($options['footnoteMark']['color'])) {
            $footnoteMark .= '<w:color w:val="' . $options['footnoteMark']['color'] . '"/>';
        }
        if (isset($options['footnoteMark']['sz'])) {
            $footnoteMark .= '<w:sz w:val="' . (2 * $options['footnoteMark']['sz']) . '"/>';
            $footnoteMark .= '<w:szCs w:val="' . (2 * $options['footnoteMark']['sz']) . '"/>';
        }
        if (isset($options['footnoteMark']['rtl']) && $options['footnoteMark']['rtl']) {
            $footnoteMark .= '<w:rtl />';
        }
        $footnoteMark .= '</w:rPr><w:footnoteReference w:id="' . $id . '" ';
        if (isset($options['footnoteMark']['customMark'])) {
            $footnoteMark .= 'w:customMarkFollows="1"/><w:t>' . $options['footnoteMark']['customMark'] . '</w:t>';
        } else {
            $footnoteMark .= '/>';
        }
        $footnoteMark .= '</w:r></w:p>';
        $footnoteDocument = str_replace('</w:p>', $footnoteMark, $footnoteDocument);
        // clean the footnoteDocument from auxilairy variable
        $footnoteDocument = preg_replace('/__[A-Z]+__/', '', $footnoteDocument);

        $tempNode = $this->_wordFootnotesT->createDocumentFragment();
        $tempNode->appendXML($footnoteBase);
        $this->_wordFootnotesT->documentElement->appendChild($tempNode);

        //PhpdocxLogger::logger('Add footnote to word document.', 'info');

        if ($class == 'WordFragment') {
            $this->wordML .= (string) $footnoteDocument;
        } else {
            $this->_wordDocumentC .= (string) $footnoteDocument;
        }
    }

    /**
     * Add a Form element (text field, select or checkbox)
     *
     * @access public
     * @example ../examples/easy/FormElements.php
     * @param mixed $type it can be 'textfield', 'checkbox' or 'select'
     * @param array $options Style options to apply to the text
     *  Values:
     * 'bidi' (bool)
     * 'bold' (bool)
     * 'color' (ffffff, ff0000...)
     * 'font' (Arial, Times New Roman...)
     * 'fontSize' (int)
     * 'italic' (bool)
     * 'textAlign' (both, center, distribute, left, right)
     * 'lineBreak' (before, after, both)
     * 'columnBreak' (before, after, both)
     * 'pageBreakBefore' (on, off)
     * 'rtl' (bool)
     * 'underline' (dash, dotted, double, single, wave, words)
     * 'widowControl' (bool)
     * 'wordWrap' (bool)
     * 'lineSpacing' 120, 240 (standard), 480...,
     * 'indentLeft' 100...,
     * 'indentRight' 100...
     * 'defaultValue' (mixed) a string of text for the textfield type,
     * a boolean value for the checkbox type or an integer representing the index (0 based)
     * for the options of a select form element
     * 'selectOptions' (array) an array of options for the dropdown menu
     */
    public function addFormElement($type, $options = [])
    {
        $options = self::setRTLOptions($options);
        $class = get_class($this);
        $formElementTypes = ['textfield', 'checkbox', 'select'];
        if (!in_array($type, $formElementTypes)) {
            //PhpdocxLogger::logger('The chosen form element type is not available', 'fatal');
        }
        $formElementBase = CreateText::getInstance();
        $ParagraphOptions = $options;
        $formElementBase = new WordFragment();
        $formElementBase->addText([['text' => '__formElement__']], $ParagraphOptions);
        $formElement = CreateFormElement::getInstance();
        $formElement->createFormElement($type, $options, (string) $formElementBase);
        //PhpdocxLogger::logger('Add form element to Word document.', 'info');
        if ($class == 'WordFragment') {
            $this->wordML .= (string) $formElement;
        } else {
            $this->_wordDocumentC .= (string) $formElement;
        }
    }

    /**
     * Add a header
     *
     * @access public
     * @example ../examples/easy/Header.php
     * @example ../examples/intermediate/HeaderAndFooter.php
     * @example ../examples/advanced/Report.php
     * @param array $headers
     *  Values:
     * 'default'(object) WordFragment
     * 'even' (object) WordFragment
     * 'first' (object) WordFragment
     */
    public function addHeader($headers)
    {
        $this->removeHeaders();
        foreach ($headers as $key => $value) {
            if ($value instanceof WordFragment) {
                $this->_wordHeaderT[$key] = '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>
                                            <w:hdr
                                                xmlns:ve="http://schemas.openxmlformats.org/markup-compatibility/2006"
                                                xmlns:o="urn:schemas-microsoft-com:office:office"
                                                xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"
                                                xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math"
                                                xmlns:v="urn:schemas-microsoft-com:vml"
                                                xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing"
                                                xmlns:w10="urn:schemas-microsoft-com:office:word"
                                                xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"
                                                xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml">';
                $this->_wordHeaderT[$key] .= (string) $value;
                $this->_wordHeaderT[$key] .= '</w:hdr>';
                $this->_wordHeaderT[$key] = preg_replace('/__[A-Z]+__/', '', $this->_wordHeaderT[$key]);
                // first insert image Rels
                // then insert external images rels
                // then insert Link rels
                $relationships = '';
                if (isset(CreateDocx::$_relsHeaderFooterImage[$key . 'Header'])) {
                    foreach (CreateDocx::$_relsHeaderFooterImage[$key . 'Header'] as $key2 => $value2) {
                        $relationships .= '<Relationship Id="' . $value2['rId'] . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="media/img' . $value2['rId'] . '.' . $value2['extension'] . '" />';
                    }
                }
                if (isset(CreateDocx::$_relsHeaderFooterExternalImage[$key . 'Header'])) {
                    foreach (CreateDocx::$_relsHeaderFooterExternalImage[$key . 'Header'] as $key2 => $value2) {
                        $relationships .= '<Relationship Id="' . $value2['rId'] . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="' . $value2['url'] . '" TargetMode="External" />';
                    }
                }
                if (isset(CreateDocx::$_relsHeaderFooterLink[$key . 'Header'])) {
                    foreach (CreateDocx::$_relsHeaderFooterLink[$key . 'Header'] as $key2 => $value2) {
                        $relationships .= '<Relationship Id="' . $value2['rId'] . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/hyperlink" Target="' . $value2['url'] . '" TargetMode="External" />';
                    }
                }
                // create the complete rels file relative to that header
                if ($relationships != '') {
                    $rels = '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">';
                    $rels .= $relationships;
                    $rels .= '</Relationships>';
                }
                // include the header xml files
                $this->saveToZip($this->_wordHeaderT[$key], 'word/' . $key . 'Header.xml');
                // include the header rels files
                if (isset($rels)) {
                    $this->saveToZip($rels, 'word/_rels/' . $key . 'Header.xml.rels');
                }
                // modify the document.xml.rels file
                $newId = uniqid(true);
                $newHeaderNode = '<Relationship Id="rId';
                $newHeaderNode .= $newId . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/header"';
                $newHeaderNode .= ' Target="' . $key . 'Header.xml" />';
                $newNode = $this->_wordRelsDocumentRelsT->createDocumentFragment();
                $newNode->appendXML($newHeaderNode);
                $baseNode = $this->_wordRelsDocumentRelsT->documentElement;
                $baseNode->appendChild($newNode);
                // modify accordingly the sectPr node
                $newSectNode = '<w:headerReference w:type="' . $key . '" r:id="rId' . $newId . '" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"/>';
                $sectNode = $this->_sectPr->createDocumentFragment();
                $sectNode->appendXML($newSectNode);
                $refNode = $this->_sectPr->documentElement->childNodes->item(0);
                $refNode->parentNode->insertBefore($sectNode, $refNode);
                if ($key == 'first') {
                    $this->generateTitlePg(false);
                } else if ($key == 'even') {
                    $this->generateSetting('w:evenAndOddHeaders');
                }
                // generate the corresponding Override element in [Content_Types].xml
                $this->generateOVERRIDE(
                        '/word/' . $key . 'Header.xml', 'application/vnd.openxmlformats-officedocument.wordprocessingml.' .
                        'header+xml'
                );
                // refresh the _relsHeader array
                $this->_relsHeader[] = $key . 'Header.xml';
                //8.Refresh the arrays used to hold the image and link data
                CreateDocx::$_relsHeaderFooterImage[$key . 'Header'] = [];
                CreateDocx::$_relsHeaderFooterExternalImage[$key . 'Header'] = [];
                CreateDocx::$_relsHeaderFooterLink[$key . 'Header'] = [];
            } else {
                //PhpdocxLogger::logger('The header contents must be WordML fragments', 'fatal');
            }
        }
    }

    /**
     * Adds a heading to the Word document
     *
     * @access public
     * @example ../examples/easy/Heading.php
     * @param string $text the heading text
     * @param int $level can be 1 (default), 2,3, ...
     * @param array $options Style options to apply to the heading
     *  Values:
     * 'bidi' (bool)
     * 'bold' (bool)
     * 'caps' (bool) display text in capital letters
     * 'color' (ffffff, ff0000...)
     * 'font' (Cambria (default), Arial, Times New Roman...)
     * 'fontSize' (int) size in points
     * 'italic' (bool)
     * 'indentLeft' (int) distange in twentieths of a point (twips)
     * 'indentRight' (int) distange in twentieths of a point (twips)
     * 'textAlign' (both, center, distribute, left, right)
     * 'keepLines' (bool) keep all paragraph lines on the same page
     * 'keepNext' (bool) keep in the same page the current paragraph with next paragraph
     * 'lineSpacing' 120, 240 (standard), 360, 480, ...
     * 'pageBreakBefore' (on, off)
     * 'spacingBottom' (int) bottom margin in twentieths of a point
     * 'spacingTop' (int) top margin in twentieths of a point
     * 'underline' (none, dash, dotted, double, single, wave, words)
     * 'widowControl' (on, off)
     * 'wordWrap' (on, off)
     */
    public function addHeading($text, $level = 1, $options = [])
    {
        $options = self::translateTextOptions2StandardFormat($options);
        $options = self::setRTLOptions($options);
        $class = get_class($this);

        if (!isset($options['b'])) {
            $options['b'] = 'on';
        }
        if (!isset($options['keepLines'])) {
            $options['keepLines'] = 'on';
        }
        if (!isset($options['keepNext'])) {
            $options['keepNext'] = 'on';
        }
        if (!isset($options['widowControl'])) {
            $options['widowControl'] = 'on';
        }
        if (!isset($options['sz'])) {
            $options['sz'] = max(15 - $level, 10);
        }
        if (!isset($options['font'])) {
            $options['font'] = 'Cambria';
        }

        $options['headingLevel'] = $level;
        $heading = CreateText::getInstance();
        $heading->createText($text, $options);
        //PhpdocxLogger::logger('Adds a heading of level ' . $level . 'to the Word document.', 'info');
        if ($class == 'WordFragment') {
            $this->wordML .= (string) $heading;
        } else {
            $this->_wordDocumentC .= (string) $heading;
        }
    }

    /**
     * Add an image
     *
     * @access public
     * @example ../examples/easy/Image.php
     * @example ../examples/intermediate/Chart_footnote.php
     * @param array $data
     * Values:
     * 'borderColor' (string)
     * 'borderStyle'(string) can be solid, dot, dash, lgDash, dashDot, lgDashDot, lgDashDotDot, sysDash, sysDot, sysDashDot, sysDashDotDot
     * 'borderWidth' (int) given in emus (1cm = 360000 emus)
     * 'float' (left, right, center) floating image. It only applies if textWrap is not inline (default value).
     * 'horizontalOffset' (int) given in emus (1cm = 360000 emus). Only applies if there is the image is not floating
     * 'imageAlign' (center, left, right, inside, outside)
     * 'src' (string) path to a local image
     * 'scaling' (int) a pecentage: 50, 100, ..
     * 'width' (int) in pixels
     * 'height' (int) in pixels
     * 'dpi' (int) dots per inch
     * 'spacingTop' (int) in pixels
     * 'spacingBottom' (int) in pixels
     * 'spacingLeft' (int) in pixels
     * 'spacingRight' (int) in pixels
     * 'textWrap' 0 (inline), 1 (square), 2 (front), 3 (back), 4 (up and bottom))
     * 'verticalOffset' (int) given in emus (1cm = 360000 emus)
     */
    public function addImage($data = '')
    {
        if (isset($data['width'])) {
            $data['sizeX'] = $data['width'];
        }
        if (isset($data['height'])) {
            $data['sizeY'] = $data['height'];
        }
        $class = get_class($this);
        if ($class != 'CreateDocx') {
            $data['target'] = $this->target;
        } else {
            $data['target'] = 'document';
        }
        //PhpdocxLogger::logger('Create image.', 'debug');
        try {
            if (isset($data['src']) && file_exists($data['src']) == 'true') {
                $attrImage = getimagesize($data['src']);
                try {
                    if ($attrImage['mime'] == 'image/jpg' ||
                            $attrImage['mime'] == 'image/jpeg' ||
                            $attrImage['mime'] == 'image/png' ||
                            $attrImage['mime'] == 'image/gif'
                    ) {
                        self::$intIdWord++;
                        //PhpdocxLogger::logger('New ID rId' . self::$intIdWord . ' . Image.', 'debug');
                        $image = CreateImage::getInstance();
                        $data['rId'] = self::$intIdWord;
                        $image->createImage($data);
                        $dir = $this->parsePath($data['src']);
                        //PhpdocxLogger::logger('Add image word/media/imgrId' .
                        //        self::$intIdWord . '.' . $dir['extension'] .
                         //       '.xml to DOCX.', 'info');
                        $this->_zipDocx->addFile(
                                $data['src'], 'word/media/imgrId' .
                                self::$intIdWord . '.' .
                                $dir['extension']
                        );
                        $this->generateDEFAULT(
                                $dir['extension'], $attrImage['mime']
                        );
                        if ((string) $image != '') {
                            // consider the case where the image will be included in a header or footer
                            if ($data['target'] == 'defaultHeader' ||
                                    $data['target'] == 'firstHeader' ||
                                    $data['target'] == 'evenHeader' ||
                                    $data['target'] == 'defaultFooter' ||
                                    $data['target'] == 'firstFooter' ||
                                    $data['target'] == 'evenFooter') {
                                createDocx::$_relsHeaderFooterImage[$data['target']][] = ['rId' => 'rId' . self::$intIdWord, 'extension' => $dir['extension']];
                            } else if ($data['target'] == 'footnote' ||
                                    $data['target'] == 'endnote' ||
                                    $data['target'] == 'comment') {
                                CreateDocx::$_relsNotesImage[$data['target']][] = ['rId' => 'rId' . self::$intIdWord, 'extension' => $dir['extension']];
                            } else {
                                $this->generateRELATIONSHIP(
                                        'rId' . self::$intIdWord, 'image', 'media/imgrId' . self::$intIdWord . '.'
                                        . $dir['extension']
                                );
                            }
                        }
                        if ($class == 'WordFragment') {
                            $this->wordML .= (string) $image;
                        } else {
                            $this->_wordDocumentC .= (string) $image;
                        }
                    } else {
                        throw new Exception('Image format is not supported.');
                    }
                } catch (Exception $e) {
                    //PhpdocxLogger::logger($e->getMessage(), 'fatal');
                }
            } else {
                throw new Exception('Image does not exist.');
            }
        } catch (Exception $e) {
            //PhpdocxLogger::logger($e->getMessage(), 'fatal');
        }
    }

    /**
     * Adds line numbering
     *
     * @access public
     * @example ../examples/easy/LineNumbering.php
     * @param array $options
     * countBy (int) line number increments to display (default value is 1)
     * start (int) initial line number (default value is 1)
     * distance (int) separation in twentieths of a point between the number and the text (defaults to auto)
     * restart (string) could be:
     *      continuous (default value: the numbering does not get restarted anywhere in the document),
     *      newPage (the numbering restarts at the beginning of every page)
     *      newSection (the numbering restarts at the beginning of every section)
     * sectionNumbers (array) if empty it will apply to all sections
     */
    public function addLineNumbering($options = [])
    {
        // restart condition available types
        $restart_types = ['continuous', 'newPage', 'newSection'];
        $lineNumberOptions = [];
        // set defaults
        if (isset($options['countBy']) && is_int($options['countBy'])) {
            $lineNumberOptions['countBy'] = $options['countBy'];
        } else {
            $lineNumberOptions['countBy'] = 1;
        }
        if (isset($options['start']) && is_int($options['start'])) {
            $lineNumberOptions['start'] = $options['start'];
        } else {
            $lineNumberOptions['start'] = 0;
        }
        if (isset($options['distance']) && is_int($options['distance'])) {
            $lineNumberOptions['distance'] = $options['distance'];
        }
        if (isset($options['restart']) && in_array($options['restart'], $restart_types)) {
            $lineNumberOptions['restart'] = $options['restart'];
        } else {
            $lineNumberOptions['restart'] = 'continuous';
        }
        if (!isset($options['sectionNumbers'])) {
            $options['sectionNumbers'] = NULL;
        }
        // get the current sectPr nodes
        $sectPrNodes = $this->getSectionNodes($options['sectionNumbers']);
        // modify them
        foreach ($sectPrNodes as $sectionNode) {
            $this->modifySingleSectionProperty($sectionNode, 'lnNumType', $lineNumberOptions);
        }
        $this->restoreDocumentXML();
    }

    /**
     * Add a link
     *
     * @access public
     * @example ../examples/easy/Link.php
     * @example ../examples/advanced/Report.php
     * @param array $options
     * @see addText
     * additional parameter:
     * 'url' (string) URL or #bookmarkName
     *
     */
    public function addLink($text, $options = [])
    {
        if (!isset($options['color'])) {
            $options['color'] = '0000ff';
        }
        if (!isset($options['u']) && !isset($options['underline'])) {
            $options['underline'] = 'single';
        }
        $options = self::setRTLOptions($options);
        $class = get_class($this);
        if (substr($options['url'], 0, 1) == '#') {
            $url = 'HYPERLINK \l "' . substr($options['url'], 1) . '"';
        } else {
            $url = 'HYPERLINK "' . $options['url'] . '"';
        }
        if ($text == '') {
            //PhpdocxLogger::logger('The linked text is missing', 'fatal');
        } else if ($options['url'] == '') {
            //PhpdocxLogger::logger('The URL is missing', 'fatal');
        }
        if (isset($options['color'])) {
            $color = $options['color'];
        } else {
            $color = '0000ff';
        }
        if (isset($options['u'])) {
            $u = $options['u'];
        } else {
            $u = 'single';
        }
        $textOptions = $options;
        $link = new WordFragment();
        $link->addText($text, $textOptions);
        $link = preg_replace('/__[A-Z]+__/', '', $link);
        $startNodes = '<w:r><w:fldChar w:fldCharType="begin" /></w:r><w:r>
        <w:instrText xml:space="preserve">' . $url . '</w:instrText>
        </w:r><w:r><w:fldChar w:fldCharType="separate" /></w:r>';
        if (strstr($link, '</w:pPr>')) {
            $link = preg_replace('/<\/w:pPr>/', '</w:pPr>' . $startNodes, $link);
        } else {
            $link = preg_replace('/<w:p>/', '<w:p>' . $startNodes, $link);
        }
        $endNode = '<w:r><w:fldChar w:fldCharType="end" /></w:r>';
        $link = preg_replace('/<\/w:p>/', $endNode . '</w:p>', $link);
        //PhpdocxLogger::logger('Add link to word document.', 'info');
        if ($class == 'WordFragment') {
            $this->wordML .= (string) $link;
        } else {
            $this->_wordDocumentC .= (string) $link;
        }
    }

    /**
     * Add a list
     *
     * @access public
     * @example ../examples/easy/List.php
     * @example ../examples/intermediate/List.php
     * @example ../examples/intermediate/List_nested.php
     * @example ../examples/intermediate/Multidocument.php
     * @param array $data Values of the list
     * @param string $styleType (mixed), 0 (clear), 1 (inordinate), 2(numerical) or the name of the created list
     * @param array $options formatting parameters for the text of all list items
     *  Values:
     * 'bold' (boolean)
     * 'caps' (boolean) display text in capital letters
     * 'color' (ffffff, ff0000, ...)
     * 'font' (Arial, Times New Roman...)
     * 'fontSize' (8, 9, 10, ...) size in points
     * 'highlightColor' (string) available highlighting colors are: black, blue, cyan, green, magenta, red, yellow, white, darkBlue, darkCyan, darkGreen, darkMagenta, darkRed,	darkYellow, darkGray, lightGray, none.
     * 'italic' (boolean)
     * 'smallCaps' (boolean)displays text in small capital letters
     * 'underline' (none, dash, dotted, double, single, wave, words)
     * 
     */
    public function addList($data, $styleType = 1, $options = [])
    {
        $options['val'] = (int) $styleType;
        $class = get_class($this);
        $list = CreateList::getInstance();

        if ($options['val'] == 2) {
            self::$numOL++;
            $this->_wordNumberingT = $this->importSingleNumbering($this->_wordNumberingT, OOXMLResources::$orderedListStyle, self::$numOL);
        }
        if (is_string($styleType)) {
            $options['val'] = self::$customLists[$styleType]['id'];
        }
        $list->createList($data, $options);
        //PhpdocxLogger::logger('Add list to word document.', 'info');
        if ($class == 'WordFragment') {
            $this->wordML .= (string) $list;
        } else {
            $this->_wordDocumentC .= (string) $list;
        }
    }

    /**
     * Add a macro from a DOC
     *
     * @access public
     * @param string $path Path to a file with macro
     */
    public function addMacroFromDoc($path)
    {

        if (!$this->_docm) {
            //PhpdocxLogger::logger('The base template should be a docm to include a macro in your document', 'fatal');
            exit();
        }
        try {
            $package = new ZipArchive();
            $openZip = $package->open($path);
            if ($openZip !== true) {
                throw new Exception('Error while trying to open the given .docm');
            }
        } catch (Exception $e) {
            //PhpdocxLogger::logger($e->getMessage(), 'fatal');
        }
        //PhpdocxLogger::logger('Open document with a macro.', 'info');
        // copy the contents of vbaData
        $vbaData = $package->getFromName('word/vbaData.xml');
        $vbaBin = $package->getFromName('word/vbaProject.bin');
        //PhpdocxLogger::logger('Add macro files to DOCX file.', 'info');
        // copy the contents
        $this->saveToZip($vbaData, 'word/vbaData.xml');
        $this->saveToZip($vbaBin, 'word/vbaProject.bin');
        $package->close();
    }

    /**
     * Add an existing math equation to DOCX
     *
     * @access public
     * @example ../examples/easy/Math.php
     * @param string $equation DOCX file with an equation, OMML equation string or MML
     * @param string $type Type of equation: docx, omml, mathml
     */
    public function addMathEquation($equation, $type)
    {
        if ($type == 'docx') {
            $package = new ZipArchive();
            //PhpdocxLogger::logger('Open document with an existing math eq.', 'info');
            $package->open($equation);
            $document = $package->getFromName('word/document.xml');
            $eqs = preg_split('/<[\/]*m:oMathPara>/', $document);
            //PhpdocxLogger::logger('Add math eq to word document.', 'info');
            $this->_wordDocumentC .= '<' . CreateDocx::NAMESPACEWORD . ':p>' .
                        '<m:oMathPara>' . $eqs[1] . '</m:oMathPara>' .
                        '</' . CreateDocx::NAMESPACEWORD . ':p>';
            $package->close();
        } /*elseif ($type == 'omml') {
            $class = get_class($this);
            //PhpdocxLogger::logger('Add existing math eq to word document.', 'info');
            if ($class == 'WordFragment') {
                $this->wordML .= (string) $equation;
            } else {
                $this->_wordDocumentC .= '<' . CreateDocx::NAMESPACEWORD . ':p>' .
                        (string) $equation . '</' . CreateDocx::NAMESPACEWORD . ':p>';
            }
        } elseif ($type == 'mathml') {
            $class = get_class($this);
            $math = CreateMath::getInstance();
            //PhpdocxLogger::logger('Convert MathML eq.', 'debug');
            $math->createMath($equation);
            //PhpdocxLogger::logger('Add converted MathML eq to word document.', 'info');
            if ($class == 'WordFragment') {
                $this->wordML .= $transformedEquation;
            } else {
                $this->_wordDocumentC .= '<' . CreateDocx::NAMESPACEWORD . ':p>' .
                        '<m:oMathPara>' . (string) $math . '</m:oMathPara>' .
                        '</' . CreateDocx::NAMESPACEWORD . ':p>';
            }
        }*/
    }

    /**
     * Adds a merge field to the Word document
     *
     * @access public
     * @example ../examples/easy/MergeField.php
     * @param string $name
     * @param array $mergeParameters
     * Keys and values:
     * 'format' (Caps, FirstCap, Lower, Upper)
     * 'mappedField' (boolean)
     * 'preserveFormat' (boolean)
     * 'textAfter' string of text to include after the merge field
     * 'textBefore' string of text to include before the merge field
     * 'verticalFormat' (boolean)
     * @param string $format
     * @param array $options style options to apply to the field
     * Fot the avalaible options @see addText
     *
     */
    public function addMergeField($name, $mergeParameters = [], $options = [])
    {
        $options = self::setRTLOptions($options);
        if (!isset($mergeParameters['preserveFormat'])) {
            $mergeParameters['preserveFormat'] = true;
        }

        $fieldName = '';
        if (isset($mergeParameters['textBefore'])) {
            $fieldName .= $mergeParameters['textBefore'];
        }
        $fieldName .= '«' . $name . '»';
        if (isset($mergeParameters['textAfter'])) {
            $fieldName .= $mergeParameters['textAfter'];
        }

        $simpleField = new WordFragment();
        $simpleField->addText($fieldName, $options);

        $data = 'MERGEFIELD &quot;' . $name . '&quot; ';
        foreach ($mergeParameters as $key => $value) {
            switch ($key) {
                case 'textBefore':
                    $data .= '\b &quot;' . $value . '&quot; ';
                    break;
                case 'textAfter':
                    $data .= '\f &quot;' . $value . '&quot; ';
                    break;
                case 'mappedField':
                    if ($value) {
                        $data .= '\m ';
                    }
                    break;
                case 'verticalFormat':
                    if ($value) {
                        $data .= '\v ';
                    }
                    break;
                case 'preserveFormat':
                    if ($value) {
                        $data .= '\* MERGEFORMAT';
                    }
                    break;
            }
        }

        $beguin = '<w:fldSimple w:instr=" ' . $data . ' ">';
        $end = '</w:fldSimple>';

        $simpleField = str_replace('<w:r>', $beguin . '<w:r>', $simpleField);
        $simpleField = str_replace('</w:r>', '</w:r>' . $end, $simpleField);

        //PhpdocxLogger::logger('Adding a merge field to the Word document.', 'info');

        $class = get_class($this);
        if ($class == 'WordFragment') {
            $this->wordML .= (string) $simpleField;
        } else {
            $this->_wordDocumentC .= (string) $simpleField;
        }
    }

    /**
     * Adds page borders
     *
     * @access public
     * @example ../examples/easy/PageBorders.php
     * @param array $options (<side> stands for top, right, bootom or left)
     * 'zOrder' (int)
     * 'display' (string) posible values are:allPages (display page border on all pages, default value),
     *  firstPage(display page border on first page), notFirstPage (display page border on all pages except first)
     * 'offsetFrom' (string) posible values are: page or text
     * 'border' (nil, single, double, dashed, threeDEngrave, threeDEmboss, outset, inset, ...)
     *       this value can be override for each side with 'borderTop', 'borderRight', 'borderBottom' and 'borderLeft'
     * 'borderColor' (ffffff, ff0000)
     *      this value can be override for each side with 'borderTopColor', 'borderRightColor', 'borderBottomColor' and 'borderLeftColor'
     * 'borderSpacing' (0, 1, 2...)
     *      this value can be override for each side with 'borderTopSpacing', 'borderRightSpacing', 'borderBottomSpacing' and 'borderLeftSpacing'
     * 'borderWidth' (10, 11...) in eights of a point
     *      this value can be override for each side with 'borderTopWidth', 'borderRightWidth', 'borderBottomWidth' and 'borderLeftWidth'
     * sectionNumbers (array)
     */
    public function addPageBorders($options = [])
    {
        if (!isset($options['sectionNumbers'])) {
            $options['sectionNumbers'] = NULL;
        }

        $options = CreateDocx::translateTableOptions2StandardFormat($options);

        //Get the current sectPr nodes
        $sectPrNodes = $this->getSectionNodes($options['sectionNumbers']);
        //Modify them
        foreach ($sectPrNodes as $sectionNode) {
            $this->modifyPageBordersSectionProperty($sectionNode, $options);
        }
        $this->restoreDocumentXML();
    }

    /**
     * Adds a page number to the document
     * WARNING: if the page number is not added to a header or footer the user may
     * need to press F9 in the MS Word interface to update its value to the current page
     *
     * @access public
     * @example ../examples/easy/PageNumber.php
     * @example ../examples/intermediate/FooterPager.php
     * @param mixed $type (String): numerical, alphabetical.
     * @param array $options Style options to apply to the numbering
     *  Values:
     * 'bidi' (bool)
     * 'bold' (on, off)
     * 'color' (ffffff, ff0000...)
     * 'font' (Arial, Times New Roman...)
     * 'fontSize' (int) size in half points
     * 'italic' (on, off)
     * 'indentLeft' (int) distange in twentieths of a point (twips)
     * 'indentRight' (int) distange in twentieths of a point (twips)
     * 'pageBreakBefore' (bool)
     * 'textAlign' (both, center, distribute, left, right)
     * 'underline' (dash, dotted, double, single, wave, words)
     * 'widowControl' (bool)
     * 'wordWrap' (bool)
     * 'lineSpacing' 120, 240 (standard), 480...,
     * 'defaultValue' (int)
     *
     */
    public function addPageNumber($type = 'numerical', $options = ['defaultValue' => 1])
    {
        $options = self::setRTLOptions($options);
        $class = get_class($this);
        if (!isset($options['defaultValue'])) {
            if ($type == 'numerical') {
                $options['defaultValue'] = '1';
            } else if ($type == 'alphabetical') {
                $options['defaultValue'] = 'a';
            }
        }
        $pageNumber = new WordFragment();
        $pageNumber->addText($options['defaultValue'], $options);
        if ($type == 'alphabetical') {
            $beguin = '<w:fldSimple w:instr="PAGE \* alphabetic \* MERGEFORMAT">';
        } else {
            $beguin = '<w:fldSimple w:instr="PAGE \* MERGEFORMAT">';
        }
        $end = '</w:fldSimple>';
        $pageNumber = str_replace('<w:r>', $beguin . '<w:r>', (string) $pageNumber);
        $pageNumber = str_replace('</w:r>', '</w:r>' . $end, (string) $pageNumber);
        //PhpdocxLogger::logger('Add page number to word document.', 'info');
        if ($class == 'WordFragment') {
            $this->wordML .= (string) $pageNumber;
        } else {
            $this->_wordDocumentC .= (string) $pageNumber;
        }
    }

    /**
     * Add properties to document
     *
     * @access public
     * @example ../examples/easy/Properties.php
     * @param array $values Parameters to use
     *  Values: 'title', 'subject', 'creator', 'keywords', 'description',
     *  'category', 'contentStatus', 'Manager','Company', 'custom' ('name' => array('type' => 'value'))
     */
    public function addProperties($values)
    {
        $this->_modifiedDocxProperties = true;
        self::$propsCore = $this->getFromZip('docProps/core.xml', 'DOMDocument');
        self::$propsApp = $this->getFromZip('docProps/app.xml', 'DOMDocument');
        self::$propsCustom = $this->getFromZip('docProps/custom.xml', 'DOMDocument');
        if (self::$propsCustom === false) {
            self::$generateCustomRels = true;
            self::$propsCustom = new DOMDocument();
            self::$propsCustom->loadXML(OOXMLResources::$customProperties);
            // write the new Override node associated to the new custon.xml file en [Content_Types].xml
            $this->generateOVERRIDE(
                    '/docProps/custom.xml', 'application/vnd.openxmlformats-officedocument.' .
                    'custom-properties+xml'
            );
        }
        self::$relsRels = $this->getFromZip('_rels/.rels', 'DOMDocument');


        $prop = CreateProperties::getInstance();
        if (!empty($values['title']) || !empty($values['subject']) || !empty($values['creator']) || !empty($values['keywords']) || !empty($values['description']) || !empty($values['category']) || !empty($values['contentStatus'])) {
            self::$propsCore = $prop->createProperties($values, self::$propsCore);
        }
        if (isset($values['contentStatus']) && $values['contentStatus'] == 'Final') {
            self::$propsCustom = $prop->createPropertiesCustom(['_MarkAsFinal' => ['boolean' => 'true']], self::$propsCustom);
        }
        if (!empty($values['Manager']) || !empty($values['Company'])) {
            self::$propsApp = $prop->createPropertiesApp($values, self::$propsApp);
        }
        if (!empty($values['custom']) && is_array($values['custom'])) {
            self::$propsCustom = $prop->createPropertiesCustom($values['custom'], self::$propsCustom);
            // write the new Override node associated to the new custon.xml file en [Content_Types].xml
            $this->generateOVERRIDE(
                    '/docProps/custom.xml', 'application/vnd.openxmlformats-officedocument.' .
                    'custom-properties+xml'
            );
        }
        if (self::$generateCustomRels) {
            $this->generateCUSTOMRELS();
        }
        //PhpdocxLogger::logger('Adding properties to word document.', 'info');
    }
    
    /**
     * Adds a section
     *
     * @access public
     * @example ../examples/easy/Section.php
     * @param string sectionType (string): nextPage, nextColumn, continuous, evenPage, oddPage
     * @param array paperType (string): A4, A3, letter, legal, A4-landscape, A3-landscape, letter-landscape, legal-landscape, custom
     * @param array options
     * Values:
     * width (int): measurement in twips (twentieths of a point)
     * height (int): measurement in twips (twentieths of a point)
     * numberCols (int): number of columns
     * orient (string): portrait, landscape
     * marginTop (int): measurement in twips (twentieths of a point)
     * marginRight (int): measurement in twips (twentieths of a point)
     * marginBottom (int): measurement in twips (twentieths of a point)
     * marginLeft (int): measurement in twips (twentieths of a point)
     * marginHeader (int): measurement in twips (twentieths of a point)
     * marginFooter (int): measurement in twips (twentieths of a point)
     * gutter (int): measurement in twips (twentieths of a point)
     * bidi (bool)
     * rtl (bool)
     */
    public function addSection($sectionType = 'nextPage', $paperType = '', $options = [])
    {
        $options = self::translateTextOptions2StandardFormat($options);
        $options = self::setRTLOptions($options);
        if (empty($paperType)) {
            $paperType = $this->_phpdocxconfig['settings']['paper_size'];
        }
        $previousSectionPr = '<w:p><w:pPr>' . $this->_sectPr->saveXML() . '</w:pPr></w:p>';
        $previousSectionPr = str_replace('<?xml version="1.0"?>', '', $previousSectionPr);
        $this->_wordDocumentC .= (string) $previousSectionPr;
        $options['onlyLastSection'] = true;
        $this->modifyPageLayout($paperType, $options);
        $nodeSz = $this->_sectPr->getElementsByTagName('pgSz')->item(0);
        $typeNode = $this->_sectPr->createDocumentFragment();
        $typeNode->appendXML('<w:type xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:val="' . $sectionType . '" />');
        $nodeSz->parentNode->insertBefore($typeNode, $nodeSz);
    }
    
    /**
     * Add a shape
     *
     * @access public
     * @example ../examples/intermediate/Shapes.php
     * @param string $type Type of shape to draw
     *  Values:arc, curve, line, polyline, rect, roundrect, shape, oval
     * @param array $options
     * General options:
     * 'width' in points
     * 'height' in points
     * 'position' (absolute, relative)
     * 'marginTop' in points
     * 'marginLeft' in points
     * 'z-index' integer
     * 'strokecolor' (#ff0000, #00ffff, ...)
     * 'strokeweight' (1.0pt, 3.5pt, ...)
     * 'fillcolor' (#ff0000, #00ffff, ...)
     * Options for especific type:
     * arc: 'startAngle' (0, 45, 90, ...), 'endAngle' (0, 45, 90, ...)
     * line and curve: 'from' and 'to' (initial and final points in x,y format)
     * curve: 'control1' (x,y), 'control2' (x,y)
     * polyline: 'points' (x1,y1 x2,y2 ....)
     * roundrect: 'arcsize' (0.5, 1.8, ...)
     * shape: 'path' (VML path), 'coordsize' (x,y)
     */
    public function addShape($type, $options = [])
    {
        if (!empty($options['marginTop'])) {
            $options['margin-top'] = $options['marginTop'];
        }
        if (!empty($options['marginLeft'])) {
            $options['margin-left'] = $options['marginLeft'];
        }
        $class = get_class($this);
        $shape = new CreateShape();
        $shapeData = $shape->createShape($type, $options);
        //PhpdocxLogger::logger('Add a ' . $type . 'to the Word document.', 'info');
        if ($class == 'WordFragment') {
            $this->wordML .= '<w:p><w:r>' . $shapeData . '</w:r></w:p>';
        } else {
            $paragraphShape = '<w:p><w:r>' . $shapeData . '</w:r></w:p>';
            $this->_wordDocumentC .= $paragraphShape;
        }
    }

    /**
     * Adds a simple field to the Word document
     * WARNING: if the page number is not added to a header or footer the user may
     * need to press F9 in the MS Word interface to update its value to the current page
     *
     * @access public
     * @example ../examples/easy/SimpleField.php
     * @param $fieldName the field value. Available fields are:
     * AUTHOR, COMMENTS, DOCPROPERTY, FILENAME, FILESIZE, KEYWORDS,
     * LASTSAVEDBY, NUMCHARS, NUMPAGES, NUMWORDS, SUBJECT, TEMPLATE, TITLE
     * @param string $type: date, numeric or general.
     * @param string $format
     * @param array $options style options to apply to the field
     * Values:
     * 'bidi' (bool)
     * 'bold' (bool)
     * 'color' (ffffff, ff0000...)
     * 'font' (Arial, Times New Roman...)
     * 'fontSize (int)
     * 'indentLeft' (int) distange in twentieths of a point (twips)
     * 'indentRight' (int) distange in twentieths of a point (twips)
     * 'italic' (bool)
     * 'lineSpacing' 120, 240 (standard), 480...,
     * 'pageBreakBefore' (bool)
     * 'textAlign' (both, center, distribute, left, right)
     * 'underline' (dash, dotted, double, single, wave, words)
     * 'widowControl' (bool)
     * 'wordWrap' (bool)
     * 'defaultValue' (mixed)
     * 'doNotShadeFormData' (bool)
     * 'updateFields' (bool)
     *
     */
    public function addSimpleField($fieldName, $type = 'general', $format = '', $options = [])
    {
        $options = self::setRTLOptions($options);
        $class = get_class($this);
        $availableTypes = ['date' => '\@', 'numeric' => '\#', 'general' => '\*'];
        $fieldOptions = [];
        if (isset($options['doNotShadeFormData']) && $options['doNotShadeFormData']) {
            $fieldOptions['doNotShadeFormData'] = true;
        }
        if (isset($options['updateFields']) && $options['updateFields']) {
            $fieldOptions['updateFields'] = true;
        }
        if (count($fieldOptions) > 0) {
            $this->docxSettings($fieldOptions);
        }
        $simpleField = new WordFragment();
        $simpleField->addText($fieldName, $options);

        $data = $fieldName . ' ';
        if (!empty($format)) {
            $data .= $availableTypes[$type] . ' ' . $format . ' ';
        }
        $data .= '\* MERGEFORMAT';
        $beguin = '<w:fldSimple w:instr=" ' . $data . ' ">';

        $end = '</w:fldSimple>';
        $simpleField = str_replace('<w:r>', $beguin . '<w:r>', (string) $simpleField);
        $simpleField = str_replace('</w:r>', '</w:r>' . $end, (string) $simpleField);

        //PhpdocxLogger::logger('Adding a simple field to the Word document.', 'info');
        // in order to preserve the run styles insert them within the <w:pPr> tag
        if ($class == 'WordFragment') {
            $this->wordML .= (string) $simpleField;
        } else {
            $this->_wordDocumentC .= (string) $simpleField;
        }
    }

    /**
     * Add a Structured Document Tag
     *
     * @access public
     * @example ../examples/easy/StructuredDocumentTag.php
     * @param mixed $type it can be 'comboBox', 'date', 'dropDownList' or 'richText'
     * @param array $options Style options to apply to the text
     *  Values:
     * 'bidi' (bool)
     * 'bold' (bool)
     * 'color' (ffffff, ff0000...)
     * 'font' (Arial, Times New Roman...)
     * 'fontSi`ze (int)
     * 'indentLeft' (int) distange in twentieths of a point (twips)
     * 'indentRight' (int) distange in twentieths of a point (twips)
     * 'italic' (bool)
     * 'lineSpacing' 120, 240 (standard), 480...,
     * 'pageBreakBefore' (bool)
     * 'textAlign' (both, center, distribute, left, right)
     * 'underline' (dash, dotted, double, single, wave, words)
     * 'widowControl' (bool)
     * 'wordWrap' (bool)
     * 'placeholderText (string) text to be shown by default
     * 'alias' (string) the label that will be shown by the structured document tag
     * 'lock' (string) locking properties: sdtLocked (cannot be deleted),
     * contentLocked (contents can not be edited directly), unlocked (default value: no locking) and sdtContentLocked (contents can not be directyly edited or the structured tag removed)
     * 'tag' (string) a programmatic tag
     * 'temporary (boolean) if true the structured tag is removed after editing
     * 'listItems' (array) an array of arrays each one of them containing the text to show and value
     */
    public function addStructuredDocumentTag($type, $options = [])
    {
        $options = self::setRTLOptions($options);
        $class = get_class($this);
        $sdtTypes = ['comboBox', 'date', 'dropDownList', 'richText'];
        if (!in_array($type, $sdtTypes)) {
            //PhpdocxLogger::logger('The chosen Structured Document Tag type is not available', 'fatal');
            exit();
        }
        $sdtBase = CreateText::getInstance();
        $ParagraphOptions = $options;
        $ParagraphOptions['text'] = $options['placeholderText'];
        $sdtBase->createText([$ParagraphOptions], $ParagraphOptions);
        $sdt = CreateStructuredDocumentTag::getInstance();
        $sdt->createStructuredDocumentTag($type, $options, (string) $sdtBase);
        //PhpdocxLogger::logger('Add Structured Document Tag to Word document.', 'info');
        if ($class == 'WordFragment') {
            $this->wordML .= (string) $sdt;
        } else {
            $this->_wordDocumentC .= (string) $sdt;
        }
    }

    /**
     * Add a table.
     *
     * @access public
     * @example ../examples/easy/Table.php
     * @example ../examples/intermediate/Table.php
     * @example ../examples/intermediate/TableStyled.php
     * @example ../examples/advanced/Report.php
     * @param array $tableData an array of arrays with the table data organized by rows
     * Each cell content may be a string, WordFragment or array.
     * If the cell contents are in the form of an array its keys and posible values are:
     *      'value' (mixed) a string or WordFragment
     *      'rowspan' (int)
     *      'colspan' (int)
     *      'width' (int) in twentieths of a point
     *      'border' (nil, single, double, dashed, threeDEngrave, threeDEmboss, outset, inset, ...)
     *          this value can be override for each side with 'borderTop', 'borderRight', 'borderBottom' and 'borderLeft'
     *      'borderColor' (ffffff, ff0000)
     *          this value can be override for each side with 'borderTopColor', 'borderRightColor', 'borderBottomColor' and 'borderLeftColor'
     *      'borderSpacing' (0, 1, 2...)
     *          this value can be override for each side with 'borderTopSpacing', 'borderRightSpacing', 'borderBottomSpacing' and 'borderLeftSpacing'
     *      'borderWidth' (10, 11...) in eights of a point
     *          this value can be override for each side with 'borderTopWidth', 'borderRightWidth', 'borderBottomWidth' and 'borderLeftWidth'
     *      'background_color' (ffffff, ff0000)
     *      'noWrap' (boolean)
     *      'cellMargin' (mixed) an integer value or an array:
     *          'top' (int) in twentieths of a point
     *          'right' (int) in twentieths of a point
     *          'bottom' (int) in twentieths of a point
     *          'left' (int) in twentieths of a point
     *      'textDirection' (string) available values are: tbRl and btLr
     *      'fitText' (boolean) if true fits the text to the size of the cell
     *      'vAlign' (string) vertical align of text: top, center, both or bottom
     *
     * @param array $tableProperties Parameters to use
     *  Values:
     *  'bidi' (boolean) set to true for right to left languages
     *  'border' (nil, single, double, dashed, threeDEngrave, threeDEmboss, outset, inset, ...)
     *  'borderColor' (ffffff, ff0000)
     *  'borderSpacing' (0, 1, 2...)
     *  'borderWidth' (10, 11...) in eights of a point
     *  'borderSettings' (all, outside, inside) if all (default value) the border styles apply to all table borders.
     *  If the value is set to outside or inside the border styles will only apply to the outside or inside boreders respectively.
     *  'cantSplitRows' (boolean) set global row split properties (can be overriden by rowProperties)
     *  'cellMargin' (array) the keys are top, right, bottom and left and the values is given in twips (twentieths of a point)
     *  'cellSpacing' (int) given in twips (twentieths of a point)
     *  'columnWidths': column width fix (int)
     *              column width variable (array)
     *  'conditionalFormating' (array) with the following keys and values:
     *      'firstRow' (boolean) first table row conditional formatting
     *      'lastRow' (boolean) last table row conditional formatting
     *      'firstCol' (boolean) first table column conditional formatting
     *      'lastCol' (boolean) last table column conditional formatting
     *      'noHBand' (boolean) do not apply row banding conditional formatting
     *      'noVBand' (boolean) do not apply column banding conditional formatting
     *  The default values are: firstRow (true), firstCol(true), noVBand (true) and all other false
     *  'float' (array) with the following keys and values:
     *      'textMarginTop' (int) in twentieths of a point
     *      'textMarginRight' (int) in twentieths of a point
     *      'textMarginBottom' (int) in twentieths of a point
     *      'textMarginLeft' (int) in twentieths of a point
     *      'align' (string) posible values are: left, center, right, outside, inside
     *  'font' (Arial, Times New Roman...)
     *  'indent' (int) given in twips (twentieths of a point)
     *  'tableAlign' (center, left, right)
     *  'tableLayout' (fixed, autofit) set to 'fixed' only if you do not want Word to handle the best possible width fit
     *  'tableStyle' (string) Word table style
     *  'tableWidth' (array) its posible keys and values are:
     *      'type' (pct, dxa) pct if the value refers to percentage and dxa if the value is given in twentieths of a point (twips)
     *      'value' (int)
     *  'textProperties' (array) it may include any of the paragraph properties of the addText method
     *
     * @param array $rowProperties (array) a cero based array. Each entry is an array with keys and values:
     *      'cantSplit' (boolean)
     *      'minHeight' (int) in twentieths of a point
     *      'height' (int) in twentieths of a point
     *      'tableHeader' (boolean) if true this row repeats at the beguinning of each new page
     */
    public function addTable($tableData, $tableProperties = [], $rowProperties = [])
    {
        $tableProperties = CreateDocx::translateTableOptions2StandardFormat($tableProperties);
        $tableProperties = self::setRTLOptions($tableProperties);
        $class = get_class($this);
        $table = CreateTables::getInstance();
        $table->createTable($tableData, $tableProperties, $rowProperties);
        //PhpdocxLogger::logger('Add table to Word document.', 'info');
        if ($class == 'WordFragment') {
            $this->wordML .= (string) $table;
        } else {
            $this->_wordDocumentC .= (string) $table;
        }
    }

    /**
     * Add a table of contents (TOC)
     *
     * @access public
     * @example ../examples/easy/TableContents.php
     * @param array $options
     *  Values:
     * 'autoUpdate' (boolean) if true it will try to update the TOC when first opened
     * 'displayLevels' (string) must be of the form '1-3' where the first number is
     * the start level an the second the end level. If not defined all existing levels are shown
     * @param (array) $legend
     * Values:
     * 'pStyle' (string) Word style to be used. Run parseStyles() to check all available paragraph styles
     * 'bidi' (bool)
     * 'bold' (bool)
     * 'color' (ffffff, ff0000...)
     * 'font' (Arial, Times New Roman...)
     * 'fontSi`ze (int)
     * 'indentLeft' (int) distange in twentieths of a point (twips)
     * 'indentRight' (int) distange in twentieths of a point (twips)
     * 'italic' (bool)
     * 'lineSpacing' 120, 240 (standard), 480...,
     * 'pageBreakBefore' (bool)
     * 'textAlign' (both, center, distribute, left, right)
     * 'underline' (dash, dotted, double, single, wave, words)
     * 'widowControl' (bool)
     * 'wordWrap' (bool)
     * @param (string) $stylesTOC path to the docx with the required styles for the Table of Contents
     */
    public function addTableContents($options = [], $legend = [], $stylesTOC = '')
    {
        $legend = self::translateTextOptions2StandardFormat($legend);
        $legend = self::setRTLOptions($legend);
        if (!empty($stylesTOC)) {
            $this->importStyles($stylesTOC, 'merge', ['TDC1', 'TDC2', 'TDC3', 'TDC4', 'TDC5', 'TDC6', 'TDC7', 'TDC8', 'TDC9'], 'styleID');
        }
        if (empty($legend['text'])) {
            $legend['text'] = 'Click here to update the Table of Contents';
        }
        $legendOptions = $legend;
        unset($legendOptions['text']);
        $legendData = new WordFragment();
        $legendData->addText([$legend], $legendOptions);
        $tableContents = CreateTableContents::getInstance();
        $tableContents->createTableContents($options, $legendData);
        if ($options['autoUpdate']) {
            $this->generateSetting('w:updateFields');
        }
        //PhpdocxLogger::logger('Add table of contents to word document.', 'info');
        $this->_wordDocumentC .= (string) $tableContents;
    }

    /**
     * Adds a text paragraph
     *
     * @access public
     * @example ../examples/easy/Text.php
     * @example ../examples/easy/Text_columns.php
     * @example ../examples/easy/Text_cursive.php
     * @example ../examples/easy/Text_linespacing.php
     * @example ../examples/intermediate/FooterPager.php
     * @example ../examples/intermediate/Multidocument.php
     * @example ../examples/intermediate/Text.php
     * @example ../examples/advanced/Report.php
     * @param mixed $textParams if a string just the text to be included, if an
     * array is or an array of arrays with each element containing
     * the text to be inserted and their formatting properties or a an instance of WordFragment
     * Array values:
     * 'text' (string) the run of text to be inserted
     * 'bold' (boolean)
     * 'caps' (boolean) display text in capital letters
     * 'color' (ffffff, ff0000, ...)
     * 'columnBreak' (before, after, both) inserts a column break before, after or both, a run of text
     * 'font' (Arial, Times New Roman...)
     * 'fontSize' (8, 9, 10, ...) size in points
     * 'highlightColor' (string) available highlighting colors are: black, blue, cyan, green, magenta, red, yellow, white, darkBlue, darkCyan, darkGreen, darkMagenta, darkRed,	darkYellow, darkGray, lightGray, none.
     * 'italic' (boolean)
     * 'lineBreak' (before, after, both) inserts a line break before, after or both, a run of text
     * 'rtl' (boolean) if true sets right to left text orientation
     * 'smallCaps' (boolean)displays text in small capital letters
     * 'tab' (boolean) inserts a tab. Default value is false
     * 'spaces': number of spaces at the beguinning of the run of text
     * 'underline' (none, dash, dotted, double, single, wave, words)
     * @param array $paragraphParams Style options to apply to the whole paragraph
     *  Values:
     * 'pStyle' (string) Word style to be used. Run parseStyles() to check all available paragraph styles
     * 'backgroundColor' (string) hexadecimal value (FFFF00, CCCCCC, ...)
     * 'bidi' (boolean) if true sets right to left paragraph orientation
     * 'bold' (boolean)
     * 'border' (none, single, double, dashed, threeDEngrave, threeDEmboss, outset, inset, ...)
     *      this value can be override for each side with 'borderTop', 'borderRight', 'borderBottom' and 'borderLeft'
     * 'borderColor' (ffffff, ff0000)
     *      this value can be override for each side with 'borderTopColor', 'borderRightColor', 'borderBottomColor' and 'borderLeftColor'
     * 'borderSpacing' (0, 1, 2...)
     *      this value can be override for each side with 'borderTopSpacing', 'borderRightSpacing', 'borderBottomSpacing' and 'borderLeftSpacing'
     * 'borderWidth' (10, 11...) in eights of a point
     *      this value can be override for each side with 'borderTopWidth', 'borderRightWidth', 'borderBottomWidth' and 'borderLeftWidth'
     *      
     * 'caps' (boolean) display text in capital letters
     * 'color' (ffffff, ff0000...)
     * 'contextualSpacing' (on, off) ignore spacing above and below when using identical styles
     * 'firstLineIndent' 1first line indent in twentieths of a point (twips)
     * 'font' (Arial, Times New Roman...)
     * 'fontSize' (8, 9, 10, ...) size in points
     * 'hanging' 100, 200, ...
     * 'headingLevel' (int) the heading level, if any.
     * 'italic' (on, off)
     * 'indentLeft' 100...,
     * 'indentRight' 100...
     * 'textAlign' (both, center, distribute, left, right)
     * 'keepLines' (boolean) keep all paragraph lines on the same page
     * 'keepNext' (boolean) keep in the same page the current paragraph with next paragraph
     * 'lineSpacing' (float) 1 corresponds to single line spacing, 2 to double line spacing and so long so forth
     * 'pageBreakBefore' (boolean)
     * 'rtl' (boolean) if true sets right to left text orientation
     * 'smallCaps' (boolean)displays text in small capital letters
     * 'spacingBottom' (int) bottom margin in twentieths of a point
     * 'spacingTop' (int) top margin in twentieths of a point
     * 'tabPositions' (array) each entry is an associative array with the following keys and values
     *      'type' (string) can be clear, left (default), center, right, decimal, bar and num
     *      'leader' (string) can be none (default), dot, hyphen, underscore, heavy and middleDot
     *      'position' (int) given in twentieths of a point
     *  if there is a tab and the tabPositions array is not defined the standard tab position (default of 708) will be used
     * 'textDirection' (lrTb, tbRl, btLr, lrTbV, tbRlV, tbLrV) text flow direction
     * 'underline' (none, dash, dotted, double, single, wave, words)
     * 'widowControl' (boolean)
     * 'wordWrap' (boolean)
     */
    public function addText($textParams, $paragraphParams = [])
    {
        $paragraphParams = self::setRTLOptions($paragraphParams);
        $textParams = self::translateTextOptions2StandardFormat($textParams);
        $paragraphParams = self::translateTextOptions2StandardFormat($paragraphParams);
        $class = get_class($this);
        $text = CreateText::getInstance();
        $text->createText($textParams, $paragraphParams);
        //PhpdocxLogger::logger('Add text to word document.', 'info');
        if ($class == 'WordFragment') {
            $this->wordML .= (string) $text;
        } else {
            $this->_wordDocumentC .= (string) $text;
        }
    }

    /**
     * Add a textbox
     *
     * @access public
     * @example ../examples/easy/TextBox.php
     * @example ../examples/intermediate/TextBox.php
     * @param mixed $content it may be a Word fragment, a plain text string or an array with same parameters used in the addText method
     * The first array entry is the text to be included in the text box, the second one
     * is itself another array with all the standard text formatting options
     * @param array $options includes the specific textbox options
     *  Values:
     * 'border' (bool) default value is true
     * 'borderColor' (string) hexadecimal value (#ff0000, #0000ff, ...)
     * 'borderWidth' (float) value in points
     * 'align' (left, center, right) default value is left
     * 'contentVerticalAlign' (top, center, bottom) default value is top
     * 'fillColor' (string)hexadecimal value (#ff0000, #0000ff, ...)
     * 'width' (float) width in points
     * 'height' (mixed) height in points or 'auto' (default value)
     * 'textWrap' (tight, square, through) default value is square
     * 'paddingBottom' (float) distance in mm (default is 1.3)
     * 'paddingLeft' (float) distance in mm (default is 2.5)
     * 'paddingRight' (float) distance in mm (default is 2.5)
     * 'paddingTop' (float) distance in mm (default is 1.3)
     */
    public function addTextBox($content, $options = [])
    {
        $class = get_class($this);
        $textBox = CreateTextBox::getInstance();
        if ($content instanceof WordFragment) {
            $textBoxContent = (string) $content;
        } else if (is_array($content)) {
            $textBoxParagraph = new WordFragment();
            $textBoxParagraph->addText($content[0], $content[1]);
            $textBoxContent = (string) $textBoxParagraph;
        } else {
            $textBoxParagraph = new WordFragment();
            $textBoxParagraph->addText($content);
            $textBoxContent = (string) $textBoxParagraph;
        }
        $textBox->createTextBox($textBoxContent, $options);
        //PhpdocxLogger::logger('Add textbox to word document.', 'info');
        if ($class == 'WordFragment') {
            $this->wordML .= (string) $textBox;
            $this->textBox = true;
        } else {
            $this->_wordDocumentC .= (string) $textBox;
        }
    }

    /**
     * Add a raw WordML chunk of code
     *
     * @access public
     * @param string $wordML
     */
    public function addWordML($wordML)
    {
        $class = get_class($this);
        //PhpdocxLogger::logger('Add raw WordML to the Word document.', 'info');
        if ($class == 'WordFragment') {
            $this->wordML .= (string) $wordML;
        } else {
            $this->_wordDocumentC .= $wordML;
        }
    }

    /**
     * Appends nodes selected via a DOCXPath query
     *
     * @access public
     * @param mixed $wordFragment the WordML fragment that we wish to insert. 
     * it can be an instance of the WordFragment class or the result of a DOCXPath expression
     */
    public function appendWordFragment($wordFragment)
    {
        if ($wordFragment instanceof WordFragment) {
            //PhpdocxLogger::logger('Insertion of a WordFragment into the Word document', 'info');
            $this->_wordDocumentC .= (string) $wordFragment;
        } else if ($wordFragment instanceof DOCXPathresult) {
            //PhpdocxLogger::logger('Insertion of a DOCXPath query result into the Word document', 'info');
            $appendXML = '';
            foreach ($wordFragment as $node) {
                $node = Repair::repairDOCXPath($node);
                $appendXML .= $node->ownerDocument->saveXML($node);
            }
            $this->_wordDocumentC .= (string) $appendXML;
        } else if (empty($WordFragment)) {
            //PhpdocxLogger::logger('There was no content to insert', 'info');
        } else {
            //PhpdocxLogger::logger('You can only insert a WordFragment or the result of a DOCXPath query', 'fatal');
        }
    }

    /**
     * Eliminates all block type elements from a WordML string
     *
     * @access public
     */
    public function cleanWordMLBlockElements($wordML)
    {
        $wordMLChunk = new DOMDocument();
        $namespaces = 'xmlns:ve="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" ';
        $wordML = '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?><w:root ' . $namespaces . '>' . $wordML;
        $wordML = $wordML . '</w:root>';
        $wordMLChunk->loadXML($wordML);
        $wordMLXpath = new DOMXPath($wordMLChunk);
        $wordMLXpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $wordMLXpath->registerNamespace('m', 'http://schemas.openxmlformats.org/wordprocessingml/2006/math');
        $query = '//w:r[not(ancestor::w:hyperlink or ancestor::v:textbox)] | //w:hyperlink | //w:bookmarkStart | //w:bookmarkEnd | //w:commentRangeStart | //w:commentRangeEnd | //m:oMath';
        $wrNodes = $wordMLXpath->query($query);
        $blockCleaned = '';
        foreach ($wrNodes as $node) {
            $nodeR = $node->ownerDocument->saveXML($node);
            $blockCleaned .= $nodeR;
        }
        return $blockCleaned;
    }

    /**
     * Generates the new DOCX file
     *
     * @access public
     * @example ../examples/easy/Text.php
     * @example ../examples/advanced/Report.php
     * @param string $fileName path to the resulting docx
     */
    public function createDocx($fileName = 'document')
    {
        //PhpdocxLogger::logger('Set DOCX name to: ' . $fileName . '.', 'info');
        //Check if there are openbookmars and if so throw an error
        if (count(CreateDocx::$bookmarksIds) > 0) {
            //PhpdocxLogger::logger('There are unclosed bookmarks. Please, check that all open bookmarks tags are properly closed.', 'fatal');
        }

        //PhpdocxLogger::logger('Set DOCX name to: ' . $fileName . '.', 'info');


        //$this->addBackgroundImage(dirname(__FILE__) . '/../examples/img/imagebg.jpg');
        $this->addProperties(
            [
                'creator' => 'Bui Phong <phongbx.vaeco@vietnamairlines.com>',
                'description' => 'The Great Mind',
                'title' => 'Training Center',
                'Manager'   => 'Bui Phong',
                'Company'   => 'VAECO TC'
            ]
        );

        $this->saveToZip($this->_contentTypeT, '[Content_Types].xml');
        $this->saveToZip($this->_wordRelsDocumentRelsT, 'word/_rels/document.xml.rels');
        $this->saveToZip($this->_wordStylesT, 'word/styles.xml');
        $this->saveToZip($this->_wordSettingsT, 'word/settings.xml');
        $this->saveToZip($this->_wordFootnotesT, 'word/footnotes.xml');
        $this->saveToZip($this->_wordEndnotesT, 'word/endnotes.xml');
        $this->saveToZip($this->_wordCommentsT, 'word/comments.xml');

        if ($this->_modifiedDocxProperties) {
            $this->saveToZip(self::$propsCore, 'docProps/core.xml');
            $this->saveToZip(self::$propsApp, 'docProps/app.xml');
            $this->saveToZip(self::$propsCustom, 'docProps/custom.xml');
            $this->saveToZip(self::$relsRels, '_rels/.rels');
        }

        $this->generateTemplateWordDocument();

        //PhpdocxLogger::logger('Add word/document.xml content to DOCX file.', 'info');

        if (self::$_encodeUTF) {
            $contentDocumentXML = utf8_encode($this->_wordDocumentT);
        } else {
            if ($this->_phpdocxconfig['settings']['encode_to_UTF8'] == 'true' && !PhpdocxUtilities::isUtf8($this->_wordDocumentT)) {
                $contentDocumentXML = utf8_encode($this->_wordDocumentT);
            } else {
                $contentDocumentXML = $this->_wordDocumentT;
            }
        }

        // repair document.xml to make sure there is no invalid markup
        $repair = Repair::getInstance();
        $repair->setXML($contentDocumentXML);
        $repair->addParapraphEmptyTablesTags();
        $contentRepair = (string) $repair;
        if (file_exists(dirname(__FILE__) . '/RepairPDF.inc')) {
            if ($this->_compatibilityMode) {
                $contentRepair = RepairPDF::repairPDFConversion($contentRepair, '', []);
            }
        }

        $this->saveToZip($contentRepair, 'word/document.xml');
        $this->saveToZip($this->_wordNumberingT, 'word/numbering.xml');
        //Check if there are rels for footnotes, endnotes and comments
        if (!empty(CreateDocx::$_relsNotesImage['footnote']) ||
                !empty(CreateDocx::$_relsNotesExternalImage['footnote']) ||
                !empty(CreateDocx::$_relsNotesLink['footnote'])) {
            $this->generateRelsNotes('footnote');
            $this->saveToZip($this->_wordFootnotesRelsT, 'word/_rels/footnotes.xml.rels');
        }
        if (!empty(CreateDocx::$_relsNotesImage['endnote']) ||
                !empty(CreateDocx::$_relsNotesExternalImage['endnote']) ||
                !empty(CreateDocx::$_relsNotesLink['endnote'])) {
            $this->generateRelsNotes('endnote');
            $this->saveToZip($this->_wordEndnotesRelsT, 'word/_rels/endnotes.xml.rels');
        }
        if (!empty(CreateDocx::$_relsNotesImage['comment']) ||
                !empty(CreateDocx::$_relsNotesExternalImage['comment']) ||
                !empty(CreateDocx::$_relsNotesLink['comment'])) {
            $this->generateRelsNotes('comment');
            $this->saveToZip($this->_wordCommentsRelsT, 'word/_rels/comments.xml.rels');
        }
        //PhpdocxLogger::logger('Close ZIP file', 'info');
        $this->_zipDocx->close();

        //PhpdocxLogger::logger('Copy DOCX file using a new name.', 'info');
        copy(
                $this->_tempFile, $fileName . '.' . $this->_extension
        );

        // delete temp file
        if (is_file($this->_tempFile) && is_writable($this->_tempFile)) {
            unlink($this->_tempFile);
        }

        // delete additional tempfles
        foreach (self::$unlinkFiles as $file) {
            unlink($file);
        }
        return true;
    }

    /**
     * Generate and download a new DOCX file
     *
     * @access public
     * @param string $args[0] File name
     * @param string $args[1] Page style
     *  Values: 'bottom' (4000, 4001...), 'left' (4000, 4001...),
     *  'orient' (landscape), 'right' (4000, 4001), 'titlePage' (1),
     *  'top' (4000, 4001)
     * @param string $args[0] Download file name
     */
    public function createDocxAndDownload()
    {
        $args = func_get_args();

        try {
            if (isset($args[1])) {
                $this->createDocx($args[0], $args[1]);
            } else {
                $this->createDocx($args[0]);
            }
        } catch (Exception $e) {
            //PhpdocxLogger::logger($e->getMessage(), 'fatal');
        }

        if (!empty($args[0])) {
            $fileName = $args[0];
            $completeName = explode("/", $args[0]);
            $fileNameDownload = array_pop($completeName);
        } else {
            $fileName = 'document';
            $fileNameDownload = 'document';
        }

        //PhpdocxLogger::logger('Download file ' . $fileNameDownload . '.' . $this->_extension . '.', 'info');
        header(
                'Content-Type: application/vnd.openxmlformats-officedocument.' .
                'wordprocessingml.document'
        );
        header(
                'Content-Disposition: attachment; filename="' . $fileNameDownload .
                '.' . $this->_extension . '"'
        );
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($fileName . '.' . $this->_extension));
        readfile($fileName . '.' . $this->_extension);
    }
    
    /**
     * Create a new style to use in your Word document.
     *
     * @access public
     * @example ../examples/easy/CreateListStyle.php
     * @param string $name the name we want to give to the created list
     * @param array $listOptions an array with the different styling options for each level:
     *  'type' can be decimal, lowerLetter, bullet, ....
     *  'font' Symbol, Courier new, Wingdings, ...
     *  'fontSize' in points
     *  'format' the default one is '%1.' for firs level, '%2.' for second level and so long so forth
     *  'hanging' the extra space for the numbering, should be big enough to accomodate it, the default is 360
     *  'left' the left indent. The default value is 720 times the list level
     */
    public function createListStyle($name, $listOptions = [])
    {
        $newStyle = new CreateListStyle();
        $style = $newStyle->addListStyle($name, $listOptions);
        $listId = rand(9999, 999999999);
        $this->_wordNumberingT = $this->importSingleNumbering($this->_wordNumberingT, $style, $listId);
        self::$customLists[$name]['id'] = $listId;
        self::$customLists[$name]['wordML'] = $style;
    }

    /**
     * Create a new paragraph style and linked char style to be used in your Word document.
     *
     * @access public
     * @example ../examples/easy/CreateParagraphStyle.php
     * @param string $name the name we want to give to the created style
     * @param mixed $styleOptions it includes the required style options
     * Array values:
     * 'bold' (on, off)
     * 'border' (none, single, double, dashed, threeDEngrave, threeDEmboss, outset, inset, ...)
     *      this value can be override for each side with 'borderTop', 'borderRight', 'borderBottom' and 'borderLeft'
     * 'borderColor' (ffffff, ff0000)
     *      this value can be override for each side with 'borderTopColor', 'borderRightColor', 'borderBottomColor' and 'borderLeftColor'
     * 'borderSpacing' (0, 1, 2...)
     *      this value can be override for each side with 'borderTopSpacing', 'borderRightSpacing', 'borderBottomSpacing' and 'borderLeftSpacing'
     * 'borderWidth' (10, 11...) in eights of a point
     *      this value can be override for each side with 'borderTopWidth', 'borderRightWidth', 'borderBottomWidth' and 'borderLeftWidth'
     * 'caps' (on, off) display text in capital letters
     * 'color' (ffffff, ff0000...)
     * 'contextualSpacing' (on, off) ignore spacing above and below when using identical styles
     * 'font' (Arial, Times New Roman...)
     * 'fontSize' (8, 9, 10, ...) size in points
     * 'hanging' 100, ....
     * 'italic' (on, off)
     * 'indentLeft' 100...,
     * 'indentRight' 100...
     * 'indent_firstLine' 100, ...
     * 'jc' (both, center, distribute, left, right)
     * 'keepLines' (on, off) keep all paragraph lines on the same page
     * 'keepNext' (on, off) keep in the same page the current paragraph with next paragraph
     * 'lineSpacing' 120, 240 (standard), 360, 480, ...
     * 'outlineLvl' (int) heading level (1-9)
     * 'pageBreakBefore' (on, off)
     * 'pStyle' id of the style this paragraph style is based on (it may be retrieved with the parseStyles method)
     * 'spacingBottom' (int) bottom margin in twentieths of a point
     * 'spacingTop' (int) top margin in twentieths of a point
     * 'smallCaps' (on, off) display text in small caps
     * 'tabPositions' (array) each entry is an associative array with the following keys and values
     *      'type' (string) can be clear, left (default), center, right, decimal, bar and num
     *      'leader' (string) can be none (default), dot, hyphen, underscore, heavy and middleDot
     *      'position' (int) given in twentieths of a point
     * 'textDirection' (lrTb, tbRl, btLr, lrTbV, tbRlV, tbLrV) text flow direction
     * 'u' (none, dash, dotted, double, single, wave, words)
     * 'widowControl' (on, off)
     * 'wordWrap' (on, off)
     */
    public function createParagraphStyle($name, $styleOptions = [])
    {
        $styleOptions = self::translateTextOptions2StandardFormat($styleOptions);
        $newStyle = new CreateParagraphStyle();
        $style = $newStyle->addParagraphStyle($name, $styleOptions);
        //Let's get the original styles
        $styleXML = $this->_wordStylesT->saveXML();
        //append the new styles as a string at the end of the styles file
        $styleXML = str_replace('</w:styles>', $style[0] . '</w:styles>', $styleXML);
        $styleXML = str_replace('</w:styles>', $style[1] . '</w:styles>', $styleXML);
        $this->_wordStylesT->loadXML($styleXML);
    }

    /**
     * Stablish the general docx settings in settings.xml
     *
     * @access public
     * @example ../examples/easy/Settings.php
     * @param array settings
     * Keys and values:
     * 'view' (string): none(default), print, outline, masterPages, normal (draft view), web
     * 'zoom'(mixed): a percentage or none, fullPage (display one full page), bestFit (display page width), textFit (display text width)
     * 'mirrorMargins' (bool) if true interchanges inside and outside margins in odd and even pages
     * 'bordersDoNotSurroundHeader' (bool)
     * 'bordersDoNotSurroundFooter' (bool)
     * 'gutterAtTop' (bool)
     * 'hideSpellingErrors' (bool)
     * 'hideGrammaticalErrors' (bool)
     * 'documentType' (string): notSpecified (default), letter, eMail
     * 'trackRevisions' (bool)
     * 'defaultTabStop'(int) in twips (twentieths of a point)
     * 'autoHyphenation' (bool)
     * 'consecutiveHyphenLimit'(int): maximum number of consecutively hyphenated lines
     * 'hyphenationZone' (int) distance in twips (twentieths of a point)
     * 'doNotHyphenateCaps' (bool): do not hyphenate capital letters
     * 'defaultTableStyle' (string): the table style to be used by default
     * 'bookFoldRevPrinting' (bool): reverse book fold printing
     * 'bookFoldPrinting' (bool): book fold printing
     * 'bookFoldPrintingSheets' (int): number of pages per booklet
     * 'doNotShadeFormData' (bool)
     * 'noPunctuationKerning' (bool): never kern punctuation characters
     * 'printTwoOnOne' (bool): print two pages per sheet
     * 'savePreviewPicture' (bool): generate thumbnail for document on save
     * 'updateFields' (bool): automatically recalculate fields on open
     *
     * @return void
     */
    public function docxSettings($settingParameters)
    {
        $settingParams = [
            'view',
            'zoom',
            'displayBackgroundShape',
            'mirrorMargins',
            'bordersDoNotSurroundHeader',
            'bordersDoNotSurroundFooter',
            'gutterAtTop',
            'hideSpellingErrors',
            'hideGrammaticalErrors',
            'documentType',
            'trackRevisions',
            'defaultTabStop',
            'autoHyphenation',
            'consecutiveHyphenLimit',
            'hyphenationZone',
            'doNotHyphenateCaps',
            'defaultTableStyle',
            'bookFoldRevPrinting',
            'bookFoldPrinting',
            'bookFoldPrintingSheets',
            'doNotShadeFormData',
            'noPunctuationKerning',
            'printTwoOnOne',
            'savePreviewPicture',
            'updateFields'
        ];
        foreach ($settingParameters as $tag => $value) {
            if ((!in_array($tag, $settingParams))) {
                //PhpdocxLogger::logger('That setting tag is not supported.', 'info');
            } else {
                $settingIndex = array_search('w:' . $tag, OOXMLResources::$settings);
                $selectedElements = $this->_wordSettingsT->documentElement->getElementsByTagName($tag);
                if ($selectedElements->length == 0) {
                    $settingsElement = $this->_wordSettingsT->createDocumentFragment();
                    if ($tag == 'zoom') {
                        if (is_numeric($value)) {
                            $settingsElement->appendXML('<w:' . $tag . ' xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:percent = "' . $value . '"/>');
                        } else {
                            $settingsElement->appendXML('<w:' . $tag . ' xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:val = "' . $value . '"/>');
                        }
                    } else {
                        $settingsElement->appendXML('<w:' . $tag . ' xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:val = "' . $value . '"/>');
                    }
                    $childNodes = $this->_wordSettingsT->documentElement->childNodes;
                    $index = false;
                    foreach ($childNodes as $node) {
                        $name = $node->nodeName;
                        $index = array_search($node->nodeName, OOXMLResources::$settings);
                        if ($index > $settingIndex) {
                            $node->parentNode->insertBefore($settingsElement, $node);
                            break;
                        }
                    }
                    //in case no node was found (pretty unlikely)we should append the node
                    if (!$index) {
                        $this->_wordSettingsT->documentElement->appendChild($settingsElement);
                    }
                } else {//that setting is already present
                    if ($tag == 'zoom') {
                        $selectedElements->item(0)->removeAttribute('w:val');
                        $selectedElements->item(0)->removeAttribute('w:percent');
                        if (is_numeric($value)) {
                            $selectedElements->item(0)->setAttribute('w:percent', $value);
                        } else {
                            $selectedElements->item(0)->setAttribute('w:val', $value);
                        }
                    } else {
                        $selectedElements->item(0)->setAttribute('w:val', $value);
                    }
                }
            }
        }
    }

    /**
     *
     * Transform a word document to a text file
     *
     * @example ../examples/easy/Docx2Text.php
     * @param string $path. Path to the docx from which we wish to import the content
     * @param string $path. Path to the text file output
     * @param array styles.
     * keys: table => true/false,list => true/false, paragraph => true/false, footnote => true/false, endnote => true/false, chart => (0=false,1=array,2=table)
     */
    public static function docx2txt($from, $to, $options = [])
    {
        $text = new Docx2Text($options);
        $text->setDocx($from);
        $text->extract($to);
    }

    /**
     * Embed HTML into the Word document by parsing the HTML code and converting it into WordML
     * It preserves many CSS styles
     *
     * @access public
     * @example ../examples/easy/EmbedSimpleHTML.php
     * @example ../examples/intermediate/EmbedExternalHTML.php
     * @example ../examples/intermediate/EmbedHTMLinTable.php
     * @param string $html HTML to add. Must be a valid XHTML
     * @param array $options:
     * isFile (boolean),
     * baseURL (string),
     * customListStyles (bool) if true try to use the predefined customm lists
     * downloadImages (boolean),
     * filter (string) could be an string denoting the id, class or tag to be filtered.
     * If you want only a class introduce .classname, #idName for an id or <htmlTag> for a particular tag. One can also use
     * standard XPath expresions supported by PHP.
     * 'parseAnchors' (boolean),
     * 'parseDivs' (paragraph, table): parses divs as paragraphs or tables,
     * 'parseFloats' (boolean),
     * 'strictWordStyles' (boolean) if true ignores all CSS styles and uses the styles set via the wordStyles option (see next)
     * 'wordStyles' (array) associates a particular class, id or HTML tag to a Word style
     */
    public function embedHTML($html = '<html><body></body></html>', $options = [])
    {
        $class = get_class($this);
        if ($class != 'CreateDocx') {
            $options['target'] = $this->target;
        } else {
            $options['target'] = 'document';
        }
        $htmlDOCX = new HTML2WordML($this->_zipDocx);
        $sFinalDocX = $htmlDOCX->render($html, $options);
        //PhpdocxLogger::logger('Add converted HTML to word document.', 'info');

        $this->HTMLRels($sFinalDocX, $options);
        // take care of the ordered lsit if they exist
        if (is_array($sFinalDocX[3])) {
            foreach ($sFinalDocX[3] as $value) {
                $this->_wordNumberingT = $this->importSingleNumbering($this->_wordNumberingT, OOXMLResources::$orderedListStyle, $value);
            }
        }
        // take care of the custom lists if they exist
        if (is_array($sFinalDocX[4])) {
            foreach ($sFinalDocX[4] as $value) {
                //We have to remove from the name the random indentifier
                $realNameArray = explode('_', $value['name']);
                $value['name'] = $realNameArray[0];
                $this->_wordNumberingT = $this->importSingleNumbering($this->_wordNumberingT, self::$customLists[$value['name']]['wordML'], $value['id']);
            }
        }

        if ($class == 'WordFragment') {
            $this->wordML .= (string) $sFinalDocX[0];
        } else {
            $this->_wordDocumentC .= (string) $sFinalDocX[0];
        }
    }

    /**
     * Enable compatibility mode for OpenOffice and MS Office 2003 CP. Avoid using unsupported methods
     *
     * @access public
     */
    public function enableCompatibilityMode()
    {
        //PhpdocxLogger::logger('Enable compatibility mode.', 'info');
        $this->_compatibilityMode = true;
    }
    
    /**
     * Creates an empty word numbering base string
     */
    public function generateBaseWordNumbering()
    {
        // copy the numbering.xml file from the standard PHPDocX template into the new base template
        $numZip = new ZipArchive();
        try {
            $openNumZip = $numZip->open(PHPDOCX_BASE_TEMPLATE);
            if ($openNumZip !== true) {
                throw new Exception('Error while opening the standard base template to extract the word/numbering.xml file');
            }
        } catch (Exception $e) {
            //PhpdocxLogger::logger($e->getMessage(), 'fatal');
        }
        $baseWordNumbering = $numZip->getFromName('word/numbering.xml');

        return $baseWordNumbering;
    }
    
    /**
     * To add support of sys_get_temp_dir for PHP versions under 5.2.1
     *
     * @access private
     * @return string
     */
    public static function getTempDir()
    {
        if (!function_exists('sys_get_temp_dir')) {

            function sys_get_temp_dir()
            {
                if ($temp = getenv('TMP')) {
                    return $temp;
                }
                if ($temp = getenv('TEMP')) {
                    return $temp;
                }
                if ($temp = getenv('TMPDIR')) {
                    return $temp;
                }
                $temp = tempnam(__FILE__, '');
                if (file_exists($temp)) {
                    unlink($temp);
                    return dirname($temp);
                }
                return null;
            }

        } else {
            return sys_get_temp_dir();
        }
    }
    
    /**
     * Inserts new headers and/or footers from a word file.
     *
     * @example ../examples/easy/ImportHeaderAndFooter.php
     * @param string $path. Path to the docx from which we wish to import the header and/or footer
     * @param string $type. Declares if we want to import only the header, only the footer or both.
     * Values: header, footer, headerAndFooter (default value)
     */
    public function importHeadersAndFooters($path, $type = 'headerAndFooter')
    {
        switch ($type) {
            case 'headerAndFooter':
                $this->removeHeadersAndFooters();
                break;
            case 'header':
                $this->removeHeaders();
                break;
            case 'footer':
                $this->removeFooters();
                break;
        }
        // get, parse and extract the relevant files from the docx with the new headers/footers
        try {
            $baseHeadersFooters = new ZipArchive();
            $openHeadersFooters = $baseHeadersFooters->open($path);
            if ($openHeadersFooters !== true) {
                throw new Exception('Error while opening the docx to extract the header and/or footer');
            }
        } catch (Exception $e) {
            //PhpdocxLogger::logger($e->getMessage(), 'fatal');
        }

        // extract the different roles: default, even or first played by the different headers and footers.
        // In order to do that we should first parse the node sectPr from the document.xml file
        $docHeadersFootersContent = $this->getFromZip('word/document.xml', 'DOMDocument', $baseHeadersFooters);

        //We now extract the first sectPr element in the document
        //We are assuming there is only one section
        $docSectPr = $docHeadersFootersContent->getElementsByTagName('sectPr')->item(0);

        $headerTypes = [];
        $footerTypes = [];
        $titlePg = false;
        $extraSections = false;
        foreach ($docSectPr->childNodes as $value) {
            if ($value->nodeName == 'w:headerReference') {
                $headerTypes[$value->getAttribute('r:id')] = $value->getAttribute('w:type');
            } else if ($value->nodeName == 'w:footerReference') {
                $footerTypes[$value->getAttribute('r:id')] = $value->getAttribute('w:type');
            }
        }
        // check if the first and even headers and footers are shown in the original Word document
        $titlePg = false;
        if ($docHeadersFootersContent->getElementsByTagName('titlePg')->length > 0) {
            $titlePg = true;
        }

        $settingsHeadersFootersContent = $this->getFromZip('word/settings.xml', 'DOMDocument', $baseHeadersFooters);

        if ($settingsHeadersFootersContent->getElementsByTagName('evenAndOddHeaders')->length > 0) {
            $this->generateSetting('w:evenAndOddHeaders');
        }

        // parse word/_rels/document.xml.rels
        $wordHeadersFootersRelsT = $this->getFromZip('word/_rels/document.xml.rels', 'DOMDocument', $baseHeadersFooters);
        $relationships = $wordHeadersFootersRelsT->getElementsByTagName('Relationship');

        $counter = $relationships->length - 1;

        for ($j = $counter; $j > -1; $j--) {
            $rId = $relationships->item($j)->getAttribute('Id');
            $completeType = $relationships->item($j)->getAttribute('Type');
            $target = $relationships->item($j)->getAttribute('Target');
            $myType = array_pop(explode('/', $completeType));

            switch ($myType) {
                case 'header':
                    $relsHeader[$rId] = $target;
                    break;
                case 'footer':
                    $relsFooter[$rId] = $target;
                    break;
            }
        }
        // in case there are more sectPr within $this->documentC include the corresponding elements
        $domDocument = $this->getDOMDocx();
        $sections = $domDocument->getElementsByTagName('sectPr');

        // start the looping over the $relsHeader and/or $relsFooter arrays
        if ($type == 'headerAndFooter' || $type == 'header') {
            foreach ($relsHeader as $key => $value) {
                // first check if there is a rels file for each header
                if ($this->getFromZip('word/_rels/' . $value . '.rels', 'DOMDocument', $baseHeadersFooters)) {
                    // parse the corresponding rels file to copy and rename the images included in the header
                    $wordHeadersRelsT = $this->getFromZip('word/_rels/' . $value . '.rels', 'DOMDocument', $baseHeadersFooters);
                    $relations = $wordHeadersRelsT->getElementsByTagName('Relationship');

                    $countrels = $relations->length - 1;

                    for ($j = $countrels; $j > -1; $j--) {
                        $completeType = $relations->item($j)->getAttribute('Type');
                        $target = $relations->item($j)->getAttribute('Target');
                        $myType = array_pop(explode('/', $completeType));

                        switch ($myType) {
                            case 'image':
                                $refExtension = array_pop(explode('.', $target));
                                $refImage = 'media/image' . uniqid(true) . '.' . $refExtension;
                                // change the attibute to the new name
                                $relations->item($j)->setAttribute('Target', $refImage);
                                // copy the image in the base template with the new name
                                $image = $this->getFromZip('word/' . $target, 'string', $baseHeadersFooters);
                                $this->saveToZip($image, 'word/' . $refImage);
                                // copy the associated rels file
                                $this->saveToZip($wordHeadersRelsT, 'word/_rels/' . $value . '.rels');
                                // make sure that the corresponding image types are included in [Content_Types].xml
                                $imageTypeFound = false;
                                foreach ($this->_contentTypeT->documentElement->childNodes as $node) {
                                    if ($node->nodeName == 'Default' && $node->getAttribute('Extension') == $refExtension) {
                                        $imageTypeFound = true;
                                    }
                                }
                                if (!$imageTypeFound) {
                                    $newDefaultNode = '<Default Extension="' . $refExtension . '" ContentType="image/' . $refExtension . '" />';
                                    $newDefault = $this->_contentTypeT->createDocumentFragment();
                                    $newDefault->appendXML($newDefaultNode);
                                    $baseDefaultNode = $this->_contentTypeT->documentElement;
                                    $baseDefaultNode->appendChild($newDefault);
                                }
                                break;
                        }
                    }
                }

                // copy the corresponding header xml files
                $file = $this->getFromZip('word/' . $value, 'string', $baseHeadersFooters);
                $this->saveToZip($file, 'word/' . $value);
                // modify the /_rels/document.xml.rels of the base template to include the new element
                $newId = uniqid(true);
                $newHeaderNode = '<Relationship Id="rId';
                $newHeaderNode .= $newId . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/header"';
                $newHeaderNode .= ' Target="' . $value . '" />';
                $newNode = $this->_wordRelsDocumentRelsT->createDocumentFragment();
                $newNode->appendXML($newHeaderNode);
                $baseNode = $this->_wordRelsDocumentRelsT->documentElement;
                $baseNode->appendChild($newNode);

                // as well as the section DOMNode
                $newSectNode = '<w:headerReference w:type="' . $headerTypes[$key] . '" r:id="rId' . $newId . '" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"/>';
                $sectNode = $this->_sectPr->createDocumentFragment();
                $sectNode->appendXML($newSectNode);
                $refNode = $this->_sectPr->documentElement->childNodes->item(0);
                $refNode->parentNode->insertBefore($sectNode, $refNode);
                // and include the corresponding <Override> in [Content_Types].xml
                $newOverrideNode = '<Override PartName="/word/' . $value . '" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.header+xml" />';
                $newOverride = $this->_contentTypeT->createDocumentFragment();
                $newOverride->appendXML($newOverrideNode);
                $baseOverrideNode = $this->_contentTypeT->documentElement;
                $baseOverrideNode->appendChild($newOverride);


                foreach ($sections as $section) {
                    $extraSections = true;
                    $refNode = $section->childNodes->item(0);
                    $sectNode = $domDocument->createDocumentFragment();
                    $sectNode->appendXML($newSectNode);
                    $refNode->parentNode->insertBefore($sectNode, $refNode);
                }
            }
        }
        if ($type == 'headerAndFooter' || $type == 'footer') {
            foreach ($relsFooter as $key => $value) {
                // check if there is a rels file for each footer
                if ($this->getFromZip('word/_rels/' . $value . '.rels', 'DOMDocument', $baseHeadersFooters)) {
                    // parse the corresponding rels file to copy and rename the images included in the footer
                    $wordFootersRelsT = $this->getFromZip('word/_rels/' . $value . '.rels', 'DOMDocument', $baseHeadersFooters);
                    $relations = $wordFootersRelsT->getElementsByTagName('Relationship');

                    $countrels = $relations->length - 1;

                    for ($j = $countrels; $j > -1; $j--) {
                        $completeType = $relations->item($j)->getAttribute('Type');
                        $target = $relations->item($j)->getAttribute('Target');
                        $myType = array_pop(explode('/', $completeType));

                        switch ($myType) {
                            case 'image':
                                $refExtension = array_pop(explode('.', $target));
                                $refImage = 'media/image' . uniqid(true) . '.' . $refExtension;
                                // change the attibute to the new name
                                $relations->item($j)->setAttribute('Target', $refImage);
                                // copy the image in the base template with the new name
                                $image = $this->getFromZip('word/' . $target, 'string', $baseHeadersFooters);
                                $this->saveToZip($image, 'word/' . $refImage);
                                // copy the associated rels file
                                $this->saveToZip($wordFootersRelsT, 'word/_rels/' . $value . '.rels');
                                // make sure that the corresponding image types are included in [Content_Types].xml
                                $imageTypeFound = false;
                                foreach ($this->_contentTypeT->documentElement->childNodes as $node) {
                                    if ($node->nodeName == 'Default' && $node->getAttribute('Extension') == $refExtension) {
                                        $imageTypeFound = true;
                                    }
                                }
                                if (!$imageTypeFound) {
                                    $newDefaultNode = '<Default Extension="' . $refExtension . '" ContentType="image/' . $refExtension . '" />';
                                    $newDefault = $this->_contentTypeT->createDocumentFragment();
                                    $newDefault->appendXML($newDefaultNode);
                                    $baseDefaultNode = $this->_contentTypeT->documentElement;
                                    $baseDefaultNode->appendChild($newDefault);
                                }
                                break;
                        }
                    }
                }

                // copy the corresponding footer xml files
                $file = $this->getFromZip('word/' . $value, 'string', $baseHeadersFooters);
                $this->saveToZip($file, 'word/' . $value);
                // modify the /_rels/document.xml.rels of the base template to include the new element
                $newId = uniqid(true);
                $newFooterNode = '<Relationship Id="rId';
                $newFooterNode .= $newId . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/footer"';
                $newFooterNode .= ' Target="' . $value . '" />';
                $newNode = $this->_wordRelsDocumentRelsT->createDocumentFragment();
                $newNode->appendXML($newFooterNode);
                $baseNode = $this->_wordRelsDocumentRelsT->documentElement;
                $baseNode->appendChild($newNode);

                // as well as the section DOMNode
                $newSectNode = '<w:footerReference w:type="' . $footerTypes[$key] . '" r:id="rId' . $newId . '" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"/>';
                $sectNode = $this->_sectPr->createDocumentFragment();
                $sectNode->appendXML($newSectNode);
                $refNode = $this->_sectPr->documentElement->childNodes->item(0);
                $refNode->parentNode->insertBefore($sectNode, $refNode);

                // include the corresponding <Override> in [Content_Types].xml
                $newOverrideNode = '<Override PartName="/word/' . $value . '" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.footer+xml" />';
                $newOverride = $this->_contentTypeT->createDocumentFragment();
                $newOverride->appendXML($newOverrideNode);
                $baseOverrideNode = $this->_contentTypeT->documentElement;
                $baseOverrideNode->appendChild($newOverride);

                foreach ($sections as $section) {
                    $extraSections = true;
                    $refNode = $section->childNodes->item(0);
                    $sectNode = $domDocument->createDocumentFragment();
                    $sectNode->appendXML($newSectNode);
                    $refNode->parentNode->insertBefore($sectNode, $refNode);
                }
            }
        }
        $stringDoc = $domDocument->saveXML();
        $bodyTag = explode('<w:body>', $stringDoc);
        $this->_wordDocumentC = str_replace('</w:body></w:document>', '', $bodyTag[1]);

        if ($titlePg) {
            $this->generateTitlePg($extraSections);
        }
    }

    /**
     * Imports an existing list style  from an existing docx document.
     *
     * @access public
     * @example ../examples/easy/ImportListStyle.php
     * @param string $path. Must be a valid path to an existing .docx, .dotx o .docm document
     * @param int $id. The id of the style you want to import. You may obtain the id with the help of the parseStyle method
     */
    public function importListStyle($path, $id, $name)
    {
        $listStyles = new ZipArchive();
        try {
            $openStyle = $zipStyles->open($path);
            if ($openStyle !== true) {
                throw new Exception('Error while opening the Style Template: please, check the path');
            }
        } catch (Exception $e) {
            //PhpdocxLogger::logger($e->getMessage(), 'fatal');
        }
        $externalNumbering = $this->getFromZip('word/numbering.xml', 'DOMDocument', $listStyles);
        $numXPath = new DOMXPath($externalNumbering);
        $numXPath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $query = '//w:num[@w:numId = "' . $id . '"]';
        $numbering = $numXPath->query($query);
        if ($numbering->length > 0) {
            $abstractNumId = $numbering->item(0)->getElementsByTagName('abstractNumId')->item(0)->getAttribute('w:val');
        } else {
            //PhpdocxLogger::logger('The requested list style could not be found.', 'fatal');
        }
        $query2 = '//w:abstractNum[@w:abstractNumId = "' . $abstractNumId . '"]';
        $listStyleNode = $numXPath->query($query2)->item(0);
        $listStyleXML = $listStyleNode->ownerDocument->saveXML($listStyleNode);
        $listId = rand(9999, 999999999);
        $this->_wordNumberingT = $this->importSingleNumbering($this->_wordNumberingT, $listStyleXML, $listId);
        self::$customLists[$name]['id'] = $listId;
        self::$customLists[$name]['wordML'] = $listStyleXML;
    }
    
    /**
     *
     * Inserts a new numbering style.
     *
     * @param string $numberingsXML the numberings.xml that we wish to modify
     * @param string $newNumbering the new numbering style we wish to add.
     * @param string $numberId a unique integer tha determines the numbering id
     * and the abstract numbering id
     */
    public function importSingleNumbering($numberingsXML, $newNumbering, $numberId, $originalAbstractNumId = '')
    {
        // insert the $newNumbering into $numberingsXML
        $myNumbering = new DOMDocument();
        $myNumbering->loadXML($numberingsXML);

        // modify the w:abstractNumId atribute
        $newNumbering = str_replace('<w:abstractNum w:abstractNumId="' . $originalAbstractNumId . '"', '<w:abstractNum w:abstractNumId="' . $numberId . '"', $newNumbering);
        $newNumbering = str_replace('w:tplc=""', 'w:tplc="' . rand(10000000, 99999999) . '"', $newNumbering);
        $new = $myNumbering->createDocumentFragment();
        $new->appendXML($newNumbering);
        $base = $myNumbering->documentElement->firstChild;
        $base->parentNode->insertBefore($new, $base);
        $numberingsXML = $myNumbering->saveXML();

        // include the relationshiop
        $newNum = '<w:num w:numId="' . $numberId . '"><w:abstractNumId w:val="' . $numberId . '" /></w:num>';
        // check if there is a w:numIdMacAtCleanup element
        if (strpos($numberingsXML, 'w:numIdMacAtCleanup') !== false) {
            $numberingsXML = str_replace('<w:numIdMacAtCleanup', $newNum . '<w:numIdMacAtCleanup', $numberingsXML);
        } else {
            $numberingsXML = str_replace('</w:numbering>', $newNum . '</w:numbering>', $numberingsXML);
        }

        return $numberingsXML;
    }

    /**
     * Imports an existing style sheet from an existing docx document.
     *
     * @access public
     * @example ../examples/easy/ImportWordStyles.php
     * @param string $path. Must be a valid path to an existing .docx, .dotx o .docm document
     * @param string $type. You may choose 'replace' (overwrites the current styles) or 'merge' (adds the selected styles)
     * @param array $myStyles. A list of specific styles to be merged. If it is empty or the choosen type is 'replace' it will be ignored.
     * @param string $styleIdentifier can be styleName or styleID
     */
    public function importStyles($path, $type = 'replace', $myStyles = [], $styleIdentifier = 'styleName')
    {

        $zipStyles = new ZipArchive();
        try {
            $openStyle = $zipStyles->open($path);
            if ($openStyle !== true) {
                throw new Exception('Error while opening the Style Template: please, check the path');
            }
        } catch (Exception $e) {
            //PhpdocxLogger::logger($e->getMessage(), 'fatal');
        }
        if ($type == 'replace') {
            // overwrite the original styles file
            $extractingStyleFile = $this->getFromZip('word/styles.xml');
            // in order not to loose certain styles needed for certain PHPDOCX methods, merge them
            $this->importStyles(PHPDOCX_BASE_TEMPLATE, 'PHPDOCXStyles');
        } else {
            if ($type == 'PHPDOCXStyles') {
                $newStyles = OOXMLResources::$PHPDOCXStyles;
            } else {
                // first extract the new styles from the external docx
                try {
                    $newStyles = $zipStyles->getFromName('word/styles.xml');
                    if ($newStyles == '') {
                        throw new Exception('Error while extracting the styles from the external docx');
                    }
                } catch (Exception $e) {
                    //PhpdocxLogger::logger($e->getMessage(), 'fatal');
                }
            }

            // parse the different styles via XPath
            $newStylesDoc = new DOMDocument();
            $newStylesDoc->loadXML($newStyles);
            $stylesXpath = new DOMXPath($newStylesDoc);
            $stylesXpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
            $queryStyle = '//w:style';
            $styleNodes = $stylesXpath->query($queryStyle);

            //search for linked styles and basedOn styles
            if ($type == 'merge' && count($myStyles) > 0) {
                foreach ($myStyles as $singleStyle) {
                    if ($styleIdentifier == 'styleID') {
                        $query = '//w:style[@w:styleId="' . $singleStyle . '"]/w:basedOn | //w:style[@w:styleId="' . $singleStyle . '"]/w:link';
                        $linkedNodes = $stylesXpath->query($query);
                        foreach ($linkedNodes as $linked) {
                            $myStyles[] = $linked->getAttribute('w:val');
                        }
                    } else if ($styleIdentifier == 'styleName') {
                        $query = '//w:style[w:name[@w:val="' . $singleStyle . '"]]/w:basedOn | //w:style[w:name[@w:val="' . $singleStyle . '"]]/w:link';
                        $linkedNodes = $stylesXpath->query($query);
                        foreach ($linkedNodes as $linked) {
                            $linkedID = $linked->getAttribute('w:val');
                            $query = '//w:style[@w:styleId="' . $linkedID . '"]/w:name';
                            $nodeNames = $stylesXpath->query($query);
                            if ($nodeNames->length > 0) {
                                $myStyles[] = $nodeNames->item(0)->getAttribute('w:val');
                            }
                        }
                    }
                }
            }
            // get the original styles as a DOMDocument
            $baseNode = $this->_wordStylesT->documentElement;
            $stylesDocumentXPath = new DOMXPath($this->_wordStylesT);
            $stylesDocumentXPath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
            $query = '//w:style';
            $originalNodes = $stylesDocumentXPath->query($query);

            // insert the new styles at the end of the styles.xml
            foreach ($styleNodes as $node) {
                // in order to avoid duplicated Ids we first remove from the
                // original styles.xml any duplicity with the new ones
                // TODO: check performance
                foreach ($originalNodes as $oldNode) {
                    if ($styleIdentifier == 'styleID') {
                        if ($oldNode->getAttribute('w:styleId') == $node->getAttribute('w:styleId') && in_array($oldNode->getAttribute('w:styleId'), $myStyles)) {
                            $oldNode->parentNode->removeChild($oldNode);
                        }
                    } else {
                        $oldName = $oldNode->getElementsByTagName('name');
                        foreach ($oldName as $myNode) {
                            $myName = $myNode->getAttribute('w:val');
                            if ($oldNode->getAttribute('w:styleId') == $node->getAttribute('w:styleId') && in_array($myName, $myStyles)) {
                                $oldNode->parentNode->removeChild($oldNode);
                            }
                        }
                    }
                }
                if (count($myStyles) > 0) {
                    // insert the selected styles
                    if ($styleIdentifier == 'styleID') {
                        if (in_array($node->getAttribute('w:styleId'), $myStyles)) {
                            $insertNode = $this->_wordStylesT->importNode($node, true);
                            $baseNode->appendChild($insertNode);
                        }
                    } else {
                        $nodeChilds = $node->childNodes;
                        foreach ($nodeChilds as $child) {
                            if ($child->nodeName == 'w:name') {
                                $styleName = $child->getAttribute('w:val');
                                if (in_array($styleName, $myStyles)) {
                                    $insertNode = $this->_wordStylesT->importNode($node, true);
                                    $baseNode->appendChild($insertNode);
                                }
                            }
                        }
                    }
                } else {
                    $insertNode = $this->_wordStylesT->importNode($node, true);
                    $baseNode->appendChild($insertNode);
                }
            }
        }
        //PhpdocxLogger::logger('Importing styles from an external docx.', 'info');
    }

    /**
     * Inserts a Word fragment before a certain node.
     *
     * @access public
     * @param mixed $wordFragment the WordML fragment that we wish to insert. 
     * it can be an instance of the WordFragment class or the result of a DOCXPath expression
     * @param DOMDocument $domDocument
     * @param string $source possible values are WordFragment or DocxPath
     * @param DOMNode $refNode
     * @return void
     */
    private function insertWordContent($wordFragment, $domDocument, $source, $refNode)
    {
        if ($source == 'WordFragment') {
            $cursor = $domDocument->createElement('cursor', 'WordFragment');
            $refNode->parentNode->insertBefore($cursor, $refNode);
            $stringDoc = $domDocument->saveXML();
            $bodyTag = explode('<w:body>', $stringDoc);
            $this->_wordDocumentC = str_replace('</w:body></w:document>', '', $bodyTag[1]);
            $this->_wordDocumentC = str_replace('<cursor>WordFragment</cursor>', (string) $wordFragment, $this->_wordDocumentC);
        } else if ($source == 'DocxPath') {
            foreach ($wordFragment as $node) {
                $node = Repair::repairDOCXPath($node);
                $insert = $domDocument->importNode($node, true);
                $refNode->parentNode->insertBefore($insert, $refNode);
            }

            $stringDoc = $domDocument->saveXML();
            $bodyTag = explode('<w:body>', $stringDoc);
            $this->_wordDocumentC = str_replace('</w:body></w:document>', '', $bodyTag[1]);
        }
    }

    /**
     * Inserts a Word fragment after a certain node.
     *
     * @access public
     * @example ../examples/easy/InsertWordFragmentAfter.php
     * @param mixed $wordFragment the WordML fragment that we wish to insert. 
     * it can be an instance of the WordFragment class or the result of a DOCXPath expression
     * @param array $referenceNode
     * Keys and values:
     * 'type' (string) can be * (all, default value), paragraph, table
     * 'section' (int) 
     * 'contains' (string) 
     * 'position' (int) (include first and last sintax?)
     * 'ocurrence' (int)
     * @return void
     */
    public function insertWordFragmentAfter($wordFragment, $referenceNode)
    {
        if ($wordFragment instanceof WordFragment) {
            //PhpdocxLogger::logger('Insertion of a WordML fragment into the Word document', 'info');
            $source = 'WordFragment';
        } else if ($wordFragment instanceof DOCXPathResult) {
            //PhpdocxLogger::logger('Insertion of a DOCXPath result into the Word document', 'info');
            $source = 'DocxPath';
        } else {
            //PhpdocxLogger::logger('You are trying to insert a non-valid object', 'fatal');
        }
        // choose the reference node based on content
        if (isset($referenceNode['type'])) {
            $type = $referenceNode['type'];
        } else {
            $type = '*';
        }
        $domDocument = $this->getDOMDocx();
        $domXpath = new DOMXPath($domDocument);
        $domXpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');

        $query = DOCXPath::xpathContentQuery($type, $referenceNode);

        $contentNodes = $domXpath->query($query);

        if ($contentNodes->length > 0) {
            $referenceNode = $contentNodes->item(0)->nextSibling;
            if (!($referenceNode instanceof DOMNode) || $referenceNode->nodeName == 'w:sectPr') {
                $this->appendWordFragment($wordFragment);
                return;
            }
        } else {
            //PhpdocxLogger::logger('The reference node could not be found. The selection will be appended', 'info');
            $this->appendWordFragment($wordFragment);
            return;
        }
        $this->insertWordContent($wordFragment, $domDocument, $source, $referenceNode);
    }

    /**
     * Inserts a Word fragment before a certain node.
     *
     * @access public
     * @example ../examples/easy/InsertWordFragmentBefore.php
     * @param mixed $wordFragment the WordML fragment that we wish to insert. 
     * it can be an instance of the WordFragment class or the result of a DOCXPath expression
     * @param array $referenceNode
     * Keys and values:
     * 'type' (string) can be * (all, default value), paragraph, table
     * 'section' (int) 
     * 'contains' (string) 
     * 'position' (int) (include first and last sintax?)
     * 'ocurrence' (int)
     * @return void
     */
    public function insertWordFragmentBefore($wordFragment, $referenceNode)
    {
        if ($wordFragment instanceof WordFragment) {
            //PhpdocxLogger::logger('Insertion of a WordML fragment into the Word document', 'info');
            $source = 'WordFragment';
        } else if ($wordFragment instanceof DOCXPathResult) {
            //PhpdocxLogger::logger('Insertion of a DOCXPath result into the Word document', 'info');
            $source = 'DocxPath';
        } else {
            //PhpdocxLogger::logger('You are trying to insert a non-valid object', 'fatal');
        }
        // choose the reference node based on content
        if (isset($referenceNode['type'])) {
            $type = $referenceNode['type'];
        } else {
            $type = '*';
        }
        $domDocument = $this->getDOMDocx();
        $domXpath = new DOMXPath($domDocument);
        $domXpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');

        $query = DOCXPath::xpathContentQuery($type, $referenceNode);

        $contentNodes = $domXpath->query($query);

        if ($contentNodes->length > 0) {
            $referenceNode = $contentNodes->item(0);
        } else {
            //PhpdocxLogger::logger('The reference node could not be found. The selection will be appended', 'info');
            $this->appendWordFragment($wordFragment);
            return;
        }
        $this->insertWordContent($wordFragment, $domDocument, $source, $referenceNode);
    }
    
    /**
     * Modify page layout
     *
     * @access public
     * @example ../examples/intermediate/modifyPageLayout.php
     * @param array paperType (string): A4, A3, letter, legal, A4-landscape, A3-landscape, letter-landscape, legal-landscape, custom
     * @param array options
     * Values:
     * width (int): measuremt in twips (twentieths of a point)
     * height (int): measuremt in twips (twentieths of a point)
     * numberCols (int): integer
     * orient (string): portrait, landscape
     * marginTop (int): measuremt in twips (twentieths of a point)
     * marginRight (int): measuremt in twips (twentieths of a point)
     * marginBottom (int): measuremt in twips (twentieths of a point)
     * marginLeft (int): measuremt in twips (twentieths of a point)
     * marginHeader (int): measuremt in twips (twentieths of a point)
     * marginFooter (int): measuremt in twips (twentieths of a point)
     * gutter (int): measurement in twips (twentieths of a point)
     * bidi (bool): set to true for right to left languages
     * rtlGutter (bool): set to true for right to left languages
     * onlyLastSection (boolean): if true it only modifies the last section (default value is false)
     * sectionNumbers (array): an array with the sections that we want to modify
     */
    public function modifyPageLayout($paperType = 'letter', $options = [])
    {
        $options = $options = self::setRTLOptions($options);
        if (empty($options['onlyLastSection'])) {
            $options['onlyLastSection'] = false;
        }
        $paperTypes = ['A4',
            'A3',
            'letter',
            'legal',
            'A4-landscape',
            'A3-landscape',
            'letter-landscape',
            'legal-landscape',
            'custom'];

        $layoutOptions = ['width',
            'height',
            'numberCols',
            'orient',
            'code',
            'marginTop',
            'marginRight',
            'marginBottom',
            'marginLeft',
            'marginHeader',
            'marginFooter',
            'gutter',
            'bidi',
            'rtlGutter'];
        $referenceSizes = [
            'A4' => [
                'width' => '11906',
                'height' => '16838',
                'numberCols' => '1',
                'orient' => 'portrait',
                'code' => '9',
                'marginTop' => '1417',
                'marginRight' => '1701',
                'marginBottom' => '1417',
                'marginLeft' => '1701',
                'marginHeader' => '708',
                'marginFooter' => '708',
                'gutter' => '0'
            ],
            'A4-landscape' => [
                'width' => '16838',
                'height' => '11906',
                'numberCols' => '1',
                'orient' => 'landscape',
                'code' => '9',
                'marginTop' => '1701',
                'marginRight' => '1417',
                'marginBottom' => '1701',
                'marginLeft' => '1417',
                'marginHeader' => '708',
                'marginFooter' => '708',
                'gutter' => '0'
            ],
            'A3' => [
                'width' => '16839',
                'height' => '23814',
                'numberCols' => '1',
                'orient' => 'portrait',
                'code' => '8',
                'marginTop' => '1417',
                'marginRight' => '1701',
                'marginBottom' => '1417',
                'marginLeft' => '1701',
                'marginHeader' => '708',
                'marginFooter' => '708',
                'gutter' => '0'
            ],
            'A3-landscape' => [
                'width' => '23814',
                'height' => '16839',
                'numberCols' => '1',
                'orient' => 'landscape',
                'code' => '8',
                'marginTop' => '1701',
                'marginRight' => '1417',
                'marginBottom' => '1701',
                'marginLeft' => '1417',
                'marginHeader' => '708',
                'marginFooter' => '708',
                'gutter' => '0'
            ],
            'letter' => [
                'width' => '12240',
                'height' => '15840',
                'numberCols' => '1',
                'orient' => 'portrait',
                'code' => '1',
                'marginTop' => '1417',
                'marginRight' => '1701',
                'marginBottom' => '1417',
                'marginLeft' => '1701',
                'marginHeader' => '708',
                'marginFooter' => '708',
                'gutter' => '0'
            ],
            'letter-landscape' => [
                'width' => '15840',
                'height' => '12240',
                'numberCols' => '1',
                'orient' => 'landscape',
                'code' => '1',
                'marginTop' => '1701',
                'marginRight' => '1417',
                'marginBottom' => '1701',
                'marginLeft' => '1417',
                'marginHeader' => '708',
                'marginFooter' => '708',
                'gutter' => '0'
            ],
            'legal' => [
                'width' => '12240',
                'height' => '20160',
                'numberCols' => '1',
                'orient' => 'portrait',
                'code' => '5',
                'marginTop' => '1417',
                'marginRight' => '1701',
                'marginBottom' => '1417',
                'marginLeft' => '1701',
                'marginHeader' => '708',
                'marginFooter' => '708',
                'gutter' => '0'
            ],
            'legal-landscape' => [
                'width' => '20160',
                'height' => '12240',
                'numberCols' => '1',
                'orient' => 'landscape',
                'code' => '5',
                'marginTop' => '1701',
                'marginRight' => '1417',
                'marginBottom' => '1701',
                'marginLeft' => '1417',
                'marginHeader' => '708',
                'marginFooter' => '708',
                'gutter' => '0'
            ],
        ];

        try {
            if (!in_array($paperType, $paperTypes)) {
                throw new Exception('You have used an invalid paper size');
            }
        } catch (Exception $e) {
            //PhpdocxLogger::logger($e->getMessage(), 'fatal');
        }


        $layout = [];
        foreach ($layoutOptions as $opt) {
            if (isset($referenceSizes[$paperType][$opt])) {
                $layout[$opt] = $referenceSizes[$paperType][$opt];
            }
        }
        foreach ($layoutOptions as $opt) {
            if (isset($options[$opt])) {
                $layout[$opt] = $options[$opt];
            }
        }

        if (!isset($options['sectionNumbers'])) {
            $options['sectionNumbers'] = NULL;
        }
        // get the current sectPr nodes
        if ($options['onlyLastSection']) {
            $this->_tempDocumentDOM = $this->getDOMDocx();
            $sectPrNodes = [];
            $sectPrNodes[] = $this->_sectPr->documentElement;
        } else {
            $sectPrNodes = $this->getSectionNodes($options['sectionNumbers']);
        }
        // modify them
        foreach ($sectPrNodes as $sectionNode) {
            if (isset($layout['width'])) {
                $sectionNode->getElementsByTagName('pgSz')->item(0)->setAttribute('w:w', $layout['width']);
            }
            if (isset($layout['height'])) {
                $sectionNode->getElementsByTagName('pgSz')->item(0)->setAttribute('w:h', $layout['height']);
            }
            if (isset($layout['orient'])) {
                $this->_sectPr->getElementsByTagName('pgSz')->item(0)->setAttribute('w:orient', $layout['orient']);
            }
            if (isset($layout['code'])) {
                $sectionNode->getElementsByTagName('pgSz')->item(0)->setAttribute('w:code', $layout['code']);
            }
            if (isset($layout['marginTop'])) {
                $sectionNode->getElementsByTagName('pgMar')->item(0)->setAttribute('w:top', $layout['marginTop']);
            }
            if (isset($layout['marginRight'])) {
                $sectionNode->getElementsByTagName('pgMar')->item(0)->setAttribute('w:right', $layout['marginRight']);
            }
            if (isset($layout['marginBottom'])) {
                $sectionNode->getElementsByTagName('pgMar')->item(0)->setAttribute('w:bottom', $layout['marginBottom']);
            }
            if (isset($layout['marginLeft'])) {
                $sectionNode->getElementsByTagName('pgMar')->item(0)->setAttribute('w:left', $layout['marginLeft']);
            }
            if (isset($layout['marginHeader'])) {
                $sectionNode->getElementsByTagName('pgMar')->item(0)->setAttribute('w:header', $layout['marginHeader']);
            }
            if (isset($layout[$paperType]['marginFooter'])) {
                $sectionNode->getElementsByTagName('pgMar')->item(0)->setAttribute('w:footer', $layout['marginFooter']);
            }
            if (isset($layout['gutter'])) {
                $sectionNode->getElementsByTagName('pgMar')->item(0)->setAttribute('w:gutter', $layout['gutter']);
            }
            if (isset($layout['bidi'])) {
                $this->modifySingleSectionProperty($sectionNode, 'bidi', ['val' => $layout['bidi']]);
            }
            if (isset($layout['rtlGutter'])) {
                $this->modifySingleSectionProperty($sectionNode, 'rtlGutter', ['val' => $layout['rtlGutter']]);
            }

            //Now we look at the case of numberCols
            if (isset($layout['numberCols'])) {
                if ($sectionNode->getElementsByTagName('cols')->length > 0) {
                    $sectionNode->getElementsByTagName('cols')->item(0)->setAttribute('w:num', $layout['numberCols']);
                } else {
                    $colsNode = $sectionNode->ownerDocument->createDocumentFragment();
                    $colsNode->appendXML('<w:cols w:num="' . $layout['numberCols'] . '" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" />');
                    $sectionNode->appendChild($colsNode);
                }
            }
        }
        $this->restoreDocumentXML();
    }
    
    /**
     * Gets the Ids associated with the different styles in the current document or an external docx.
     * It returns a docx with all the avalaible paragraph, list and table styles.
     *
     * @access public
     * @example ../examples/easy/ParseStyles.php
     * @param string $path. Optional, if empty lists the styles of the current style sheet
     */
    public function parseStyles($path = '')
    {
        if ($path != '') {
            $tempTitle = explode('/', $path);
            $title = array_pop($tempTitle);
            $parseStyles = new ZipArchive();
            try {
                $openParseStyle = $parseStyles->open($path);
                if ($openParseStyle !== true) {
                    throw new Exception('Error while opening the Style sheet to be tested: please, check the path');
                }
            } catch (Exception $e) {
                //PhpdocxLogger::logger($e->getMessage(), 'fatal');
            }

            try {
                $parsedStyles = $parseStyles->getFromName('word/styles.xml');
                if ($parsedStyles == '') {
                    throw new Exception('Error while extracting the styles to be parsed from the external docx');
                }
            } catch (Exception $e) {
                //PhpdocxLogger::logger($e->getMessage(), 'fatal');
            }

            try {
                $parsedNumberings = $parseStyles->getFromName('word/numbering.xml');
                if ($parsedNumberings == '') {
                    throw new Exception('Error while extracting the numberings to be parsed from the external docx');
                }
            } catch (Exception $e) {
                //PhpdocxLogger::logger($e->getMessage(), 'fatal');
            }
        } else {
            if ($this->_docxTemplate == true) {
                $tempTitle = explode('/', $this->_baseTemplatePath);
            } else {
                $tempTitle = explode('/', PHPDOCX_BASE_TEMPLATE);
            }
            $title = array_pop($tempTitle);
            $this->_wordDocumentC = '';
            $parsedStyles = $this->_wordStylesT->saveXML();
            $parsedNumberings = $this->_wordNumberingT;
        }


        // include certain sample content to create the resulting style docx

        $myParagraph = 'This is some sample paragraph test';
        $myList = ['item 1', 'item 2', ['subitem 2_1', 'subitem 2_2'], 'item 3', ['subitem 3_1', 'subitem 3_2', ['sub_subitem 3_2_1', 'sub_subitem 3_2_1']], 'item 4'];
        $myTable = [
            [
                'Title A',
                'Title B',
                'Title C'
            ],
            [
                'First row A',
                'First row B',
                'First row C'
            ],
            [
                'Second row A',
                'Second row B',
                'Second row C'
            ]
        ];

        // parse the different list numberings from
        $this->addText('List styles: ' . $title, ['jc' => 'center', 'color' => 'b90000', 'b' => 'single', 'sz' => '18', 'u' => 'double']);

        $wordListChunk = '<w:p><w:pPr><w:rPr><w:b/></w:rPr></w:pPr>
        <w:r><w:rPr><w:b/></w:rPr><w:t>SAMPLE CODE:</w:t></w:r>
        </w:p><w:tbl><w:tblPr><w:tblW w:w="0" w:type="auto"/>
        <w:shd w:val="clear" w:color="auto" w:fill="DDD9C3"/>
        <w:tblLook w:val="04A0"/></w:tblPr><w:tblGrid>
        <w:gridCol w:w="8644"/></w:tblGrid><w:tr><w:tc>
        <w:tcPr><w:tcW w:w="8644" w:type="dxa"/>
        <w:shd w:val="clear" w:color="auto" w:fill="DCDAC4"/>
        </w:tcPr><w:p><w:pPr><w:spacing w:before="200"/></w:pPr>
        <w:r><w:t>$</w:t></w:r><w:r>
        <w:t>myList</w:t></w:r><w:r>
        <w:t xml:space="preserve"> = array(\'item 1\', </w:t>
        </w:r><w:r>
        <w:br/>
        <w:t xml:space="preserve">                             </w:t>
        </w:r><w:r>
        <w:t xml:space="preserve">\'item 2\', </w:t>
        </w:r><w:r><w:br/>
        <w:t xml:space="preserve">                             </w:t>
        </w:r><w:r><w:t>array(\'</w:t></w:r><w:r><w:t>subitem</w:t>
        </w:r><w:r>
        <w:t xml:space="preserve"> 2_1\', </w:t></w:r><w:r><w:br/>
        <w:t xml:space="preserve">                                        </w:t>
        </w:r><w:r><w:t>\'</w:t>
        </w:r><w:r><w:t>subitem</w:t></w:r><w:r>
        <w:t xml:space="preserve"> 2_2\'), </w:t></w:r><w:r><w:br/>
        <w:t xml:space="preserve">                             </w:t>
        </w:r><w:r><w:t xml:space="preserve">\'item 3\', </w:t></w:r>
        <w:r><w:br/>
        <w:t xml:space="preserve">                             </w:t>
        </w:r><w:r><w:t>array(\'</w:t></w:r><w:r><w:t>subitem</w:t>
        </w:r><w:r><w:t xml:space="preserve"> 3_1\', </w:t></w:r>
        <w:r><w:br/>
        <w:t xml:space="preserve">                                        </w:t>
        </w:r><w:r><w:t>\'</w:t></w:r><w:r><w:t>subitem</w:t></w:r>
        <w:r><w:t xml:space="preserve"> 3_2\', </w:t></w:r><w:r><w:br/>
        <w:t xml:space="preserve">                                        </w:t>
        </w:r><w:r><w:t>array(\'</w:t></w:r><w:r><w:t>sub_subitem</w:t></w:r><w:r>
        <w:t xml:space="preserve"> 3_2_1\', </w:t></w:r><w:r><w:br/>
        <w:t xml:space="preserve">                                                   </w:t>
        </w:r><w:r><w:t>\'</w:t></w:r><w:r><w:t>sub_subitem</w:t></w:r><w:r>
        <w:t xml:space="preserve"> 3_2_1\')),</w:t></w:r><w:r><w:br/>
        <w:t xml:space="preserve">                             </w:t>
        </w:r><w:r><w:t xml:space="preserve"> \'item 4\');</w:t></w:r></w:p>
        <w:p><w:pPr><w:spacing w:before="200"/></w:pPr>
        <w:r><w:t>addList</w:t></w:r><w:r><w:t>($</w:t></w:r>
        <w:r><w:t>myList</w:t></w:r><w:r><w:t>, NUMID</w:t></w:r>
        <w:r><w:t>))</w:t></w:r></w:p></w:tc></w:tr></w:tbl><w:p><w:pPr></w:pPr>
        </w:p>
        <w:p><w:pPr><w:rPr><w:b/></w:rPr></w:pPr>
        <w:r><w:rPr><w:b/></w:rPr><w:t>SAMPLE RESULT:</w:t></w:r>
        </w:p>';
        $NumberingsDoc = new DOMDocument();
        $NumberingsDoc->loadXML($parsedNumberings);
        $numberXpath = new DOMXPath($NumberingsDoc);
        $numberXpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $queryNumber = '//w:num';
        $numberingsNodes = $numberXpath->query($queryNumber);
        foreach ($numberingsNodes as $node) {
            $wordListChunkTemp = str_replace('NUMID', $node->getAttribute('w:numId'), $wordListChunk);
            $this->_wordDocumentC .= $wordListChunkTemp;
            $this->addList($myList, (int) $node->getAttribute('w:numId'));
            $this->addBreak(['type' => 'page']);
        }

        $this->addText('Paragraph and Table styles: ' . $title, ['jc' => 'center', 'color' => 'b90000', 'b' => 'single', 'sz' => '18', 'u' => 'double']);

        // parse the different styles using XPath
        $StylesDoc = new DOMDocument();
        $StylesDoc->loadXML($parsedStyles);
        $parseStylesXpath = new DOMXPath($StylesDoc);
        $parseStylesXpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $query = '//w:style';
        $parsedNodes = $parseStylesXpath->query($query);
        // list the present styles and their respective Ids
        $count = 1;
        foreach ($parsedNodes as $node) {
            $styleId = $node->getAttribute('w:styleId');
            $styleType = $node->getAttribute('w:type');
            $styleDefault = $node->getAttribute('w:default');
            $styleCustom = $node->getAttribute('w:custom');
            $nodeChilds = $node->childNodes;
            foreach ($nodeChilds as $child) {
                if ($child->nodeName == 'w:name') {
                    $styleName = $child->getAttribute('w:val');
                }
            }
            $this->parsedStyles[$count] = ['id' => $styleId, 'name' => $styleName, 'type' => $styleType, 'default' => $styleDefault, 'custom' => $styleCustom];

            $default = ($styleDefault == 1) ? 'true' : 'false';
            $custom = ($styleCustom == 1) ? 'true' : 'false';

            $wordMLChunk = '<w:tbl><w:tblPr><w:tblW w:w="0" w:type="auto"/>
                </w:tblPr><w:tblGrid><w:gridCol w:w="4322"/><w:gridCol w:w="4322"/>
                </w:tblGrid><w:tr><w:tc><w:tcPr><w:tcW w:w="4322" w:type="dxa"/>
                <w:shd w:val="clear" w:color="auto" w:fill="BD1503"/>
                </w:tcPr><w:p><w:pPr><w:spacing w:after="0"/><w:rPr>
                <w:color w:val="FFFFFF"/></w:rPr></w:pPr><w:r><w:rPr>
                <w:color w:val="FFFFFF"/></w:rPr><w:t>NAME:</w:t></w:r></w:p>
                </w:tc><w:tc><w:tcPr><w:tcW w:w="4322" w:type="dxa"/>
                <w:shd w:val="clear" w:color="auto" w:fill="BD1503"/></w:tcPr>
                <w:p><w:pPr><w:spacing w:after="0"/><w:rPr><w:color w:val="FFFFFF"/>
                </w:rPr></w:pPr><w:r><w:rPr><w:color w:val="FFFFFF"/>
                </w:rPr><w:t>' . $styleName . '</w:t></w:r></w:p></w:tc>
                </w:tr><w:tr><w:tc><w:tcPr><w:tcW w:w="4322" w:type="dxa"/>
                <w:shd w:val="clear" w:color="auto" w:fill="3E3E42"/>
                </w:tcPr><w:p><w:pPr><w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                <w:rPr><w:color w:val="FFFFFF"/></w:rPr></w:pPr><w:r>
                <w:rPr><w:color w:val="FFFFFF"/></w:rPr><w:t>Type</w:t>
                </w:r><w:r><w:rPr><w:color w:val="FFFFFF"/></w:rPr>
                <w:t>:</w:t></w:r></w:p></w:tc><w:tc><w:tcPr>
                <w:tcW w:w="4322" w:type="dxa"/>
                <w:shd w:val="clear" w:color="auto" w:fill="3E3E42"/>
                </w:tcPr><w:p><w:pPr>
                <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                <w:rPr><w:color w:val="FFFFFF"/></w:rPr></w:pPr><w:r>
                <w:rPr><w:color w:val="FFFFFF"/></w:rPr>
                <w:t>' . $styleType . '</w:t></w:r></w:p></w:tc></w:tr>
                <w:tr><w:tc><w:tcPr>
                <w:tcW w:w="4322" w:type="dxa"/>
                <w:shd w:val="clear" w:color="auto" w:fill="3E3E42"/>
                </w:tcPr><w:p><w:pPr>
                <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                <w:rPr><w:color w:val="FFFFFF"/></w:rPr></w:pPr><w:r>
                <w:rPr><w:color w:val="FFFFFF"/></w:rPr>
                <w:t>ID:</w:t></w:r></w:p></w:tc><w:tc>
                <w:tcPr><w:tcW w:w="4322" w:type="dxa"/>
                <w:shd w:val="clear" w:color="auto" w:fill="3E3E42"/>
                </w:tcPr><w:p><w:pPr>
                <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                <w:rPr><w:color w:val="FFFFFF"/></w:rPr></w:pPr><w:r>
                <w:rPr><w:color w:val="FFFFFF"/></w:rPr>
                <w:t>' . $styleId . '</w:t></w:r></w:p></w:tc></w:tr><w:tr><w:tc><w:tcPr>
                <w:tcW w:w="4322" w:type="dxa"/>
                <w:shd w:val="clear" w:color="auto" w:fill="3E3E42"/></w:tcPr>
                <w:p><w:pPr><w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                <w:rPr><w:color w:val="FFFFFF"/></w:rPr></w:pPr><w:r>
                <w:rPr><w:color w:val="FFFFFF"/></w:rPr><w:t>Default:</w:t></w:r>
                </w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="4322" w:type="dxa"/>
                <w:shd w:val="clear" w:color="auto" w:fill="3E3E42"/>
                </w:tcPr><w:p><w:pPr>
                <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                <w:rPr><w:color w:val="FFFFFF"/></w:rPr></w:pPr>
                <w:r><w:rPr><w:color w:val="FFFFFF"/></w:rPr>
                <w:t>' . $default . '</w:t></w:r></w:p></w:tc></w:tr><w:tr>
                <w:tc><w:tcPr><w:tcW w:w="4322" w:type="dxa"/>
                <w:shd w:val="clear" w:color="auto" w:fill="3E3E42"/>
                </w:tcPr><w:p><w:pPr>
                <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                <w:rPr><w:color w:val="FFFFFF"/></w:rPr></w:pPr>
                <w:r><w:rPr><w:color w:val="FFFFFF"/></w:rPr><w:t>Custom</w:t>
                </w:r><w:r><w:rPr><w:color w:val="FFFFFF"/></w:rPr>
                <w:t>:</w:t></w:r></w:p></w:tc><w:tc><w:tcPr>
                <w:tcW w:w="4322" w:type="dxa"/>
                <w:shd w:val="clear" w:color="auto" w:fill="3E3E42"/>
                </w:tcPr><w:p><w:pPr>
                <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                <w:rPr><w:color w:val="FFFFFF"/></w:rPr></w:pPr><w:r>
                <w:rPr><w:color w:val="FFFFFF"/></w:rPr><w:t>' . $custom . '</w:t>
                </w:r></w:p></w:tc></w:tr></w:tbl>
                <w:p w:rsidR="000F6147" w:rsidRDefault="000F6147" w:rsidP="00B42E7D">
                <w:pPr><w:spacing w:after="0"/></w:pPr></w:p>
                <w:p w:rsidR="00DC3ACE" w:rsidRDefault="00DC3ACE">
                <w:pPr><w:rPr><w:b/></w:rPr></w:pPr><w:r>
                <w:rPr><w:b/></w:rPr><w:t>SAMPLE CODE:</w:t></w:r></w:p>
                <w:tbl><w:tblPr><w:tblW w:w="0" w:type="auto"/>
                <w:shd w:val="clear" w:color="auto" w:fill="DDD9C3"/>
                </w:tblPr><w:tblGrid><w:gridCol w:w="8644"/>
                </w:tblGrid><w:tr><w:tc><w:tcPr><w:tcW w:w="8644" w:type="dxa"/>
                <w:shd w:val="clear" w:color="auto" w:fill="DCDAC4"/></w:tcPr>
                <w:p w:rsidR="00DC3ACE" w:rsidRDefault="00DC3ACE">
                <w:pPr><w:spacing w:before="200" /></w:pPr><w:r>
                <w:t>CODEX</w:t></w:r></w:p></w:tc></w:tr></w:tbl><w:p/><w:p>
                <w:pPr><w:rPr><w:b/></w:rPr></w:pPr><w:r><w:rPr><w:b/>
                </w:rPr><w:t>SAMPLE RESULT:</w:t></w:r></w:p>
                ';

            switch ($styleType) {
                case 'table':
                    $wordMLChunk = str_replace('CODEX', "addTable(array(array('Title A','Title B','Title C'),array('First row A','First row B','First row C'),array('Second row A','Second row B','Second row C')), array('tableStyle'=> '$styleId'), 'columnWidths' => array(1800, 1800, 1800))", $wordMLChunk);
                    $this->_wordDocumentC .= $wordMLChunk;
                    $params = ['tableStyle' => $styleId, 'columnWidths' => [1800, 1800, 1800]];
                    $this->addTable($myTable, $params);
                    if ($count % 2 == 0) {
                        $this->_wordDocumentC .= '<w:p><w:r><w:br w:type="page"/></w:r></w:p>';
                    } else {
                        $this->_wordDocumentC .= '<w:p /><w:p />';
                    }
                    $count++;
                    break;
                case 'paragraph':
                    $myPCode = "addText('This is some sample paragraph test', array('pStyle' => '" . $styleId . "'))";
                    $wordMLChunk = str_replace('CODEX', $myPCode, $wordMLChunk);
                    $this->_wordDocumentC .= $wordMLChunk;
                    $params = ['pStyle' => $styleId];
                    $this->addText($myParagraph, $params);
                    if ($count % 2 == 0) {
                        $this->_wordDocumentC .= '<w:p><w:r><w:br w:type="page"/></w:r></w:p>';
                    } else {
                        $this->_wordDocumentC .= '<w:p /><w:p />';
                    }
                    $count++;
                    break;
            }
        }
    }
    
    /**
     *
     * Removes existing headers.
     *
     */
    private function removeHeaders()
    {

        foreach ($this->_relsHeader as $key => $value) {
            // first remove the actual header files
            $this->_zipDocx->deleteName('word/' . $value);
            $this->_zipDocx->deleteName('word/_rels/' . $value . '.rels');

            // modify the rels file
            $relationships = $this->_wordRelsDocumentRelsT->getElementsByTagName('Relationship');
            $counter = $relationships->length - 1;
            for ($j = $counter; $j > -1; $j--) {
                $target = $relationships->item($j)->getAttribute('Target');
                if ($target == $value) {
                    $this->_wordRelsDocumentRelsT->documentElement->removeChild($relationships->item($j));
                }
            }

            // remove the corresponding override tags from [Content_Types].xml
            $overrides = $this->_contentTypeT->getElementsByTagName('Override');
            $counter = $overrides->length - 1;
            for ($j = $counter; $j > -1; $j--) {
                $target = $overrides->item($j)->getAttribute('PartName');
                if ($target == '/word/' . $value) {
                    $this->_contentTypeT->documentElement->removeChild($overrides->item($j));
                }
            }
        }

        // change the section properties
        $headers = $this->_sectPr->getElementsByTagName('headerReference');
        $counter = $headers->length - 1;
        for ($j = $counter; $j > -1; $j--) {
            $this->_sectPr->documentElement->removeChild($headers->item($j));
        }
        $titlePage = $this->_sectPr->getElementsByTagName('titlePg');
        $counter = $titlePage->length - 1;
        for ($j = $counter; $j > -1; $j--) {
            $this->_sectPr->documentElement->removeChild($titlePage->item($j));
        }
        // remove the header references that may exist
        // within $this->_wordDocumentC
        $domDocument = $this->getDOMDocx();
        $headers = $domDocument->getElementsByTagName('headerReference');
        $counter = $headers->length - 1;
        for ($j = $counter; $j > -1; $j--) {
            $headers->item($j)->parentNode->removeChild($headers->item($j));
        }
        $titlePage = $domDocument->getElementsByTagName('titlePg');
        $counter = $titlePage->length - 1;
        for ($j = $counter; $j > -1; $j--) {
            $titlePage->item($j)->parentNode->removeChild($titlePage->item($j));
        }
        $this->_tempDocumentDOM = $domDocument;
        $this->restoreDocumentXML();

        // finally, if it exists, the evenAndOddHeader element from settings
        $this->removeSetting('w:evenAndOddHeaders');
    }
    
    /**
     *
     * Removes headers and footers.
     *
     */
    private function removeHeadersAndFooters()
    {
        $this->removeHeaders();
        $this->removeFooters();
    }

    /**
     *
     * Removes existing footers
     *
     */
    private function removeFooters()
    {
        foreach ($this->_relsFooter as $key => $value) {
            // first remove the actual header files
            $this->_zipDocx->deleteName('word/' . $value);
            $this->_zipDocx->deleteName('word/_rels/' . $value . '.rels');

            // modify the rels file
            $relationships = $this->_wordRelsDocumentRelsT->getElementsByTagName('Relationship');
            $counter = $relationships->length - 1;
            for ($j = $counter; $j > -1; $j--) {
                $target = $relationships->item($j)->getAttribute('Target');
                if ($target == $value) {
                    $this->_wordRelsDocumentRelsT->documentElement->removeChild($relationships->item($j));
                }
            }
            // remove the corresponding override tags from [Content_Types].xml
            $overrides = $this->_contentTypeT->getElementsByTagName('Override');
            $counter = $overrides->length - 1;
            for ($j = $counter; $j > -1; $j--) {
                $target = $overrides->item($j)->getAttribute('PartName');
                if ($target == '/word/' . $value) {
                    $this->_contentTypeT->documentElement->removeChild($overrides->item($j));
                }
            }
        }
        // change the section properties
        $footers = $this->_sectPr->getElementsByTagName('footerReference');
        $counter = $footers->length - 1;
        for ($j = $counter; $j > -1; $j--) {
            $this->_sectPr->documentElement->removeChild($footers->item($j));
        }
        $titlePage = $this->_sectPr->getElementsByTagName('titlePg');
        $counter = $titlePage->length - 1;
        for ($j = $counter; $j > -1; $j--) {
            $this->_sectPr->documentElement->removeChild($titlePage->item($j));
        }
        // remove the header references that may exist
        // within $this->_wordDocumentC
        $domDocument = $this->getDOMDocx();
        $footers = $domDocument->getElementsByTagName('footerReference');
        $counter = $footers->length - 1;
        for ($j = $counter; $j > -1; $j--) {
            $footers->item($j)->parentNode->removeChild($footers->item($j));
        }
        $titlePage = $domDocument->getElementsByTagName('titlePg');
        $counter = $titlePage->length - 1;
        for ($j = $counter; $j > -1; $j--) {
            $titlePage->item($j)->parentNode->removeChild($titlePage->item($j));
        }
        $this->_tempDocumentDOM = $domDocument;
        $this->restoreDocumentXML();
        // finally, if it exists, the evenAndOddHeader element from settings
        $this->removeSetting('w:evenAndOddHeaders');
    }

    /**
     * Changes the background color of the document
     *
     * @access public
     * @example ../examples/easy/BackgroundColor.php
     * @param string $color
     * Values: hexadecimal color value without # (ffff00, 0000ff, ...)
     */
    public function setBackgroundColor($color)
    {
        $this->_backgroundColor = $color;
        // construct the background WordML code
        if ($this->_background == '') {
            $this->_background = '<w:background w:color="' . $color . '" />';
            // modify the settings.xml file
            $this->docxSettings(['displayBackgroundShape' => true]);
        } else {
            $this->_background = str_replace('w:color="FFFFFF"', 'w:color="' . $color . '"', $this->_background);
        }
    }

    /**
     * Change the decimal symbol
     *
     * @access public
     * @param string $symbol
     *  Values: '.', ',',...
     */
    public function setDecimalSymbol($symbol)
    {
        $decimalNodes = $this->_wordSettingsT->getElementsByTagName('decimalSymbol');
        if ($decimalNodes->length > 0) {
            $decimalNode = $decimalNodes->item(0);
            $decimalNode->setAttribute('w:val', $symbol);
        }
        //PhpdocxLogger::logger('Change decimal symbol.', 'info');
    }

    /**
     * Change the default font
     *
     * @access public
     * @example ../examples/easy/SetDefaultFont.php
     * @param string $font The new font
     *  Values: 'Arial', 'Times New Roman'...
     */
    public function setDefaultFont($font)
    {
        $this->_defaultFont = $font;
        // get the original theme as a DOMdocument
        $themeDocument = $this->getFromZip('word/theme/theme1.xml', 'DOMDocument');
        $latinNode = $themeDocument->getElementsByTagName('latin');
        $latinNode->item(0)->setAttribute('typeface', $font);
        $latinNode->item(1)->setAttribute('typeface', $font);
        $this->saveToZip($themeDocument, 'word/theme/theme1.xml');
        //To preserve the default font for PDF conversion make sure the $font is
        //defined in the fontTable.xml file
        $fontDocument = $this->getFromZip('word/fontTable.xml', 'DOMDocument');
        $fontXPath = new DOMXPath($fontDocument);
        $fontXPath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $query = '//w:font[@w:name="' . $font . '"]';
        $fonts = $fontXPath->query($query);
        //If the font is not found append a w:font node to fontTable.xml
        if ($fonts->length == 0) {
            $newNode = $fontDocument->createElementNS('http://schemas.openxmlformats.org/wordprocessingml/2006/main', 'w:font');
            $newNode->setAttributeNS('http://schemas.openxmlformats.org/wordprocessingml/2006/main', 'w:name', $font);
            $fontDocument->documentElement->appendChild($newNode);
            $this->saveToZip($fontDocument, 'word/fontTable.xml');
        }
        //PhpdocxLogger::logger('The default font was changed to' . $font, 'info');
    }

    /**
     * Transform to UTF-8 charset
     *
     * @access public
     */
    public function setEncodeUTF8()
    {
        self::$_encodeUTF = 1;
    }

    /**
     * Change default language.
     * @example ../examples/easy/Language.php
     * @param $lang Locale: en-US, es-ES...
     * @access public
     */
    public function setLanguage($lang = null)
    {
        if (!$lang) {
            $lang = 'en-US';
        }
        // get the original styles as a DOMdocument
        $langNode = $this->_wordStylesT->getElementsByTagName('lang');
        if ($langNode->length > 0) {
            $langNode->item(0)->setAttribute('w:val', $lang);
            $langNode->item(0)->setAttribute('w:eastAsia', $lang);
        }
        // check also if tehre is a themeFontlanfg entry in the settings file
        $themeFontLangNode = $this->_wordSettingsT->getElementsByTagName('themeFontLang');
        if ($themeFontLangNode->length > 0) {
            $themeFontLangNode->item(0)->setAttribute('w:val', $lang);
        }

        //PhpdocxLogger::logger('Set language: ' . $lang, 'info');
    }

    /**
     * Mark the document as final
     *
     * @access public
     * @example ../examples/easy/MarkAsFinal.php
     *
     */
    public function setMarkAsFinal()
    {
        $this->_markAsFinal = 1;
        $this->addProperties(['contentStatus' => 'Final']);
        $this->generateOVERRIDE(
                '/docProps/custom.xml', 'application/vnd.openxmlformats-officedocument.' .
                'custom-properties+xml'
        );
    }

    /**
     * sets global right to left options
     * @access public
     * @param array $options
     * values:
     *  'bidi' (bool)
     *  'rtl' (bool)
     * @return void
     */
    public function setRTL($options = ['bidi' => true, 'rtl' => true])
    {
        if (isset($options['bidi']) && $options['bidi']) {
            self::$bidi = true;
        }
        if (isset($options['rtl']) && $options['rtl']) {
            self::$rtl = true;
        }
        $this->modifyPageLayout('custom', ['bidi' => $options['bidi'], 'rtlGutter' => $options['rtl']]);
        //set footnotes and endnotes separators for bidi and rtl
        $notesArray = ['footnote' => $this->_wordFootnotesT, 'endnote' => $this->_wordEndnotesT];
        foreach ($notesArray as $note => $value) {
            $noteXPath = new DOMXPath($value);
            $noteXPath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
            $query = '//w:' . $note . '[@w:type="separator"] | //w:' . $note . '[@w:type="continuationSeparator"]';
            $selectedNodes = $noteXPath->query($query);
            foreach ($selectedNodes as $node) {
                $pPrNode = $node->getElementsbyTagName('pPr')->item(0);
                $bidiNodes = $node->getElementsbyTagName('bidi');
                if ($bidiNodes->length > 0) {
                    $bidiNodes->item(0)->setAttribute('w:val', $options['bidi']);
                } else {
                    $bidi = $pPrNode->ownerDocument->createElement('w:bidi');
                    $bidi->setAttribute('w:val', $options['bidi']);
                    $pPrNode->appendChild($bidi);
                }
                $rtlNodes = $node->getElementsbyTagName('rtl');
                if ($rtlNodes->length > 0) {
                    $rtlNodes->item(0)->setAttribute('w:val', $options['rtl']);
                } else {
                    $rtl = $pPrNode->ownerDocument->createElement('w:rtl');
                    $rtl->setAttribute('w:val', $options['rtl']);
                    $pPrNode->appendChild($rtl);
                }
            }
        }
    }

    /**
     * sets global right to left options for the different methods
     * @access public
     * @static
     * @param array $options
     * @return array
     */
    public static function setRTLOptions($options)
    {
        if (!isset($options['bidi']) && CreateDocx::$bidi) {
            $options['bidi'] = true;
        }
        if (!isset($options['rtl']) && CreateDocx::$rtl) {
            $options['rtl'] = true;
        }
        return $options;
    }

    /**
     * Transform DOCX to PDF, ODT, SXW, RTF, DOC, TXT, HTML or WIKI
     * Transforms all documents supported by OpenOffice
     *
     * @access public
     * @example ../examples/advanced/Transform.php
     * @param string $docSource
     * @param string $docDestination
     * @param string $tempDir
     * @param array $options :
     *      · method : 'direct' (default), 'script' ; 'direct' method uses
     *                  passthru and 'script' uses a external script.
     *                  If you're using Apache and 'direct' doesn't work use 'script'
     *      · 'odfconverter' : true (default) or false. Use odf-converter.
     *      · 'debug' : false (default) or true. It shows debug information about the plugin conversion
     * @param string $version 32, 64 or null (default). If null autodetect
     * @return void
     */
    public function transformDocument($docSource, $docDestination, $tempDir = null, $options = [], $version = null)
    {
        if (file_exists(dirname(__FILE__) . '/TransformDocAdv.inc')) {
            try {
                if (!$this->_compatibilityMode) {
                    throw new Exception('Running in compatibility mode. Unsupported method.');
                }
                $convert = new TransformDocAdv();
                $convert->transformDocument($docSource, $docDestination, $tempDir, $options, $version);
            } catch (Exception $e) {
                //PhpdocxLogger::logger($e->getMessage(), 'fatal');
            }
        }
    }

    /**
     * If PHPDocX is installed in a server with a working copy of Word 2007 or newer you may
     * use it to do format conversions.
     * Supported formats, DOCX and DOC to PDF, RTF, HTML and DOC
     * @access public
     * @static
     * @param $docSource you should use the full Windows path to the docx (remember to escape backslashes)
     * @param $docDestination you should use the full Windows path to the docx (remember to escape backslashes)
     * @return void
     */
    public function transformDocxUsingMSWord($docSource, $docDestination)
    {
        $convert = new MSWordInterface();
        $convert->transformFormat($docSource, $docDestination);
    }

    /**
     * Translate chart option arrays to a predefined format
     * @param array $options
     * @access public
     * @static
     */
    public static function translateChartOptions2StandardFormat($options)
    {
        foreach ($options as $key => $value) {
            $options[strtolower($key)] = $value;
        }
        if (isset($options['chartAlign'])) {
            $options['jc'] = $options['chartAlign'];
        }
        return $options;
    }

    /**
     * Translate table option arrays to a predefined format
     * @param array $options
     * @access public
     * @static
     */
    public static function translateTableOptions2StandardFormat($options)
    {
        // general border options
        if (isset($options['borderColor'])) {
            $options['border_color'] = $options['borderColor'];
        }
        if (isset($options['borderSpacing'])) {
            $options['border_spacing'] = $options['borderSpacing'];
        }
        if (isset($options['borderWidth'])) {
            $options['border_sz'] = $options['borderWidth'];
            $options['border_width'] = $options['borderWidth'];
        }
        if (isset($options['borderSettings'])) {
            $options['border_settings'] = $options['borderSettings'];
        }
        // individual side options
        if (isset($options['borderTop'])) {
            $options['border_top'] = $options['borderTop'];
            $options['border_top_style'] = $options['borderTop'];
        }
        if (isset($options['borderRight'])) {
            $options['border_right'] = $options['borderRight'];
            $options['border_right_style'] = $options['borderRight'];
        }
        if (isset($options['borderBottom'])) {
            $options['border_bottom'] = $options['borderBottom'];
            $options['border_bottom_style'] = $options['borderBottom'];
        }
        if (isset($options['borderLeft'])) {
            $options['border_left'] = $options['borderLeft'];
            $options['border_left_style'] = $options['borderLeft'];
        }
        if (isset($options['borderTopWidth'])) {
            $options['border_top_sz'] = $options['borderTopWidth'];
            $options['border_top_width'] = $options['borderTopWidth'];
        }
        if (isset($options['borderRightWidth'])) {
            $options['border_right_sz'] = $options['borderRightWidth'];
            $options['border_right_width'] = $options['borderRightWidth'];
        }
        if (isset($options['borderBottomWidth'])) {
            $options['border_bottom_sz'] = $options['borderBottomWidth'];
            $options['border_bottom_width'] = $options['borderBottomWidth'];
        }
        if (isset($options['borderLeftWidth'])) {
            $options['border_left_sz'] = $options['borderLeftWidth'];
            $options['border_left_width'] = $options['borderLeftWidth'];
        }
        if (isset($options['borderTopColor'])) {
            $options['border_top_color'] = $options['borderTopColor'];
        }
        if (isset($options['borderRightColor'])) {
            $options['border_right_color'] = $options['borderRightColor'];
        }
        if (isset($options['borderBottomColor'])) {
            $options['border_bottom_color'] = $options['borderBottomColor'];
        }
        if (isset($options['borderLeftColor'])) {
            $options['border_left_color'] = $options['borderLeftColor'];
        }
        if (isset($options['borderTopSpacing'])) {
            $options['border_top_spacing'] = $options['borderTopSpacing'];
        }
        if (isset($options['borderRightSpacing'])) {
            $options['border_right_spacing'] = $options['borderRightSpacing'];
        }
        if (isset($options['borderBottomSpacing'])) {
            $options['border_bottom_spacing'] = $options['borderBottomSpacing'];
        }
        if (isset($options['borderLeftSpacing'])) {
            $options['border_left_spacing'] = $options['borderLeftSpacing'];
        }
        // column sizes
        if (isset($options['columnWidths'])) {
            $options['size_col'] = $options['columnWidths'];
        }
        // text margins
        if (isset($options['float']['tableMarginTop'])) {
            $options['float']['textMargin_top'] = $options['float']['tableMarginTop'];
        }
        if (isset($options['float']['tableMarginRight'])) {
            $options['float']['textMargin_right'] = $options['float']['tableMarginRight'];
        }
        if (isset($options['float']['tableMarginBottom'])) {
            $options['float']['textMargin_bottom'] = $options['float']['tableMarginBottom'];
        }
        if (isset($options['float']['tableMarginLeft'])) {
            $options['float']['textMargin_left'] = $options['float']['tableMarginLeft'];
        }
        // styles
        if (isset($options['tableAlign'])) {
            $options['jc'] = $options['tableAlign'];
        }
        if (isset($options['tableStyle'])) {
            $options['TBLSTYLEval'] = $options['tableStyle'];
        }
        if (isset($options['backgroundColor'])) {
            $options['background_color'] = $options['backgroundColor'];
        }
        return $options;
    }

    /**
     * Translate table option arrays to a predefined format
     * @param array $options
     * @access public
     * @static
     */
    public static function translateTextOptions2StandardFormat($options)
    {
        if (is_array($options)) {
            // general border options
            if (isset($options['border']) && $options['border'] == 'none') {
                $options['border'] = 'nil';
            }
            if (isset($options['borderColor'])) {
                $options['border_color'] = $options['borderColor'];
            }
            if (isset($options['borderSpacing'])) {
                $options['border_spacing'] = $options['borderSpacing'];
            }
            if (isset($options['borderWidth'])) {
                $options['border_sz'] = $options['borderWidth'];
            }
            if (isset($options['borderSettings'])) {
                $options['border_settings'] = $options['borderSettings'];
            }
            // individual side options
            if (isset($options['borderTop'])) {
                $options['border_top'] = $options['borderTop'];
                $options['border_top_style'] = $options['borderTop'];
            }
            if (isset($options['borderRight'])) {
                $options['border_right'] = $options['borderRight'];
                $options['border_right_style'] = $options['borderRight'];
            }
            if (isset($options['borderBottom'])) {
                $options['border_bottom'] = $options['borderBottom'];
                $options['border_bottom_style'] = $options['borderBottom'];
            }
            if (isset($options['borderLeft'])) {
                $options['border_left'] = $options['borderLeft'];
                $options['border_left_style'] = $options['borderLeft'];
            }
            if (isset($options['borderTopWidth'])) {
                $options['border_top_sz'] = $options['borderTopWidth'];
            }
            if (isset($options['borderRightWidth'])) {
                $options['border_right_sz'] = $options['borderRightWidth'];
            }
            if (isset($options['borderBottomWidth'])) {
                $options['border_bottom_sz'] = $options['borderBottomWidth'];
            }
            if (isset($options['borderLeftWidth'])) {
                $options['border_left_sz'] = $options['borderLeftWidth'];
            }
            if (isset($options['borderTopColor'])) {
                $options['border_top_color'] = $options['borderTopColor'];
            }
            if (isset($options['borderRightColor'])) {
                $options['border_right_color'] = $options['borderRightColor'];
            }
            if (isset($options['borderBottomColor'])) {
                $options['border_bottom_color'] = $options['borderBottomColor'];
            }
            if (isset($options['borderLeftColor'])) {
                $options['border_left_color'] = $options['borderLeftColor'];
            }
            if (isset($options['borderTopSpacing'])) {
                $options['border_top_spacing'] = $options['borderTopSpacing'];
            }
            if (isset($options['borderRightSpacing'])) {
                $options['border_right_spacing'] = $options['borderRightSpacing'];
            }
            if (isset($options['borderBottomSpacing'])) {
                $options['border_bottom_spacing'] = $options['borderBottomSpacing'];
            }
            if (isset($options['borderLeftSpacing'])) {
                $options['border_left_spacing'] = $options['borderLeftSpacing'];
            }
            // reassigned variables
            if (isset($options['indentLeft'])) {
                $options['indent_left'] = $options['indentLeft'];
            }
            if (isset($options['indentRight'])) {
                $options['indent_right'] = $options['indentRight'];
            }
            if (!empty($options['bold'])) {
                $options['b'] = 'on';
            }
            if (!empty($options['italic'])) {
                $options['i'] = 'on';
            }
            if (!empty($options['lineSpacing'])) {
                $options['lineSpacing'] = ceil($options['lineSpacing'] * 240);
            }

            if (isset($options['fontSize'])) {
                $options['sz'] = $options['fontSize'];
            }
            if (isset($options['underline'])) {
                $options['u'] = $options['underline'];
            }
            if (isset($options['textAlign'])) {
                $options['jc'] = $options['textAlign'];
            }
            // translate to boolean
            if (!empty($options['bidi'])) {
                $options['bidi'] = 'on';
            }
            if (!empty($options['caps'])) {
                $options['caps'] = 'on';
            }
            if (!empty($options['keepLines'])) {
                $options['keepLines'] = 'on';
            }
            if (!empty($options['keepNext'])) {
                $options['keepNext'] = 'on';
            }
            if (!empty($options['pageBreakBefore'])) {
                $options['pageBreakBefore'] = 'on';
            }
            if (!empty($options['smallCaps'])) {
                $options['smallCaps'] = 'on';
            }
            if (!empty($options['widowControl'])) {
                $options['widowControl'] = 'on';
            }
            if (!empty($options['wordWrap'])) {
                $options['wordWrap'] = 'on';
            }
        }
        return $options;
    }

    /**
     *
     * Insert the content of a text file into a word document trying to hold the styles
     *
     * @example ../examples/easy/Text2Docx.php
     * @param string $path. Path to the text file from which we insert into docx document
     * @param array of style values
     * keys: styleTbl, styleLst, styleP
     */
    public function txt2docx($text_filename, $options = [])
    {
        $text = new Text2Docx($text_filename, $options);
        //PhpdocxLogger::logger('Add text from text file.', 'info');
        $this->_wordDocumentC .= (string) $text;
    }
    
    /**
     * Embeds a DOCX
     *
     * @access public
     * @example ../examples/easy/DOCX.php
     * @param array $options
     * Values:
     * 'src' (string) path to DOCX
     * 'matchSource' (bool) if true (default value)tries to preserve as much as posible the styles of the docx to be included
     * 'preprocess' (boolean) if true does some preprocessing on the docx file to add
     *  WARNING: beware that the docx to insert gets modified so please make a safeguard copy first
     */
    protected function addDOCX($options)
    {
        if (!isset($options['matchSource'])) {
            $options['matchSource'] = true;
        }
        if (!isset($options['preprocess'])) {
            $options['preprocess'] = false;
        }
        $class = get_class($this);
        try {
            if ($this->_compatibilityMode) {
                throw new Exception('Running in compatibility mode. Unsupported method.');
            }
            if (file_exists($options['src'])) {
                // if preprocess is true we do certain previous manipulation on the docx to embed
                if ($options['preprocess']) {
                    $this->preprocessDocx($options['src']);
                }
                $wordDOCX = EmbedDOCX::getInstance();
                if (isset($options['matchSource']) && $options['matchSource'] === false) {
                    $wordDOCX->embed(false);
                } else {
                    $wordDOCX->embed(true);
                }
                //PhpdocxLogger::logger('Add DOCX file to word document.', 'info');

                $this->_zipDocx->addFile($options['src'], 'word/docx' . $wordDOCX->getId() .
                        '.zip');
                $this->generateRELATIONSHIP(
                        'rDOCXId' . $wordDOCX->getId(), 'aFChunk', 'docx' .
                        $wordDOCX->getId() . '.zip', 'TargetMode="Internal"');
                $this->generateDEFAULT('zip', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml');
                if ($class == 'WordFragment') {
                    $this->wordML .= (string) $wordDOCX . '<w:p />';
                } else {
                    $this->_wordDocumentC .= (string) $wordDOCX;
                }
            } else {
                throw new Exception('File does not exist.');
            }
        } catch (Exception $e) {
            //PhpdocxLogger::logger($e->getMessage(), 'fatal');
        }
    }
    
    /**
     * Inserts HTML into a document as alternative content (altChunk).
     * This method IS NOT compatible with PDF conversion or Open Office (use embedHTML instead).
     *
     * @access private
     * @example ../examples/easy/HTML.php
     * @example ../examples/intermediate/BasicHTML.php
     * @example ../examples/intermediate/HTML.php
     * @param array $options
     * Values:
     * 'html' (string)
     */
    protected function addHTML($options)
    {
        $class = get_class($this);
        try {
            if ($this->_compatibilityMode) {
                throw new Exception('Running in compatibility mode. Unsupported method.');
            }
            $wordHTML = EmbedHTML::getInstance();
            $wordHTML->embed();
            //PhpdocxLogger::logger('Embed HTML to word document.', 'info');
            $this->_zipDocx->addFromString('word/html' . $wordHTML->getId() .
                    '.htm', '<html>' . file_get_contents($options['src']) . '</html>');
            $this->generateRELATIONSHIP(
                    'rHTMLId' . $wordHTML->getId(), 'aFChunk', 'html' .
                    $wordHTML->getId() . '.htm', 'TargetMode="Internal"');
            $this->generateDEFAULT('htm', 'application/xhtml+xml');
            if ($class == 'WordFragment') {
                $this->wordML .= (string) $wordHTML . '<w:p/>';
            } else {
                $this->_wordDocumentC .= (string) $wordHTML;
            }
        } catch (Exception $e) {
            //PhpdocxLogger::logger($e->getMessage(), 'fatal');
        }
    }
    
    /**
     * Add a MHT file
     *
     * @access private
     * @example ../examples/easy/MHT.php
     * @param array $options
     * Values:
     * 'src' (string) path to the MHT file
     */
    protected function addMHT($options)
    {
        $class = get_class($this);
        try {
            if ($this->_compatibilityMode) {
                throw new Exception('Running in compatibility mode. Unsupported method.');
            }
            if (file_exists($options['src'])) {
                $wordMHT = EmbedMHT::getInstance();
                $wordMHT->embed();
                //PhpdocxLogger::logger('Add MHT file to word document.', 'info');
                $this->_zipDocx->addFile($options['src'], 'word/mht' . $wordMHT->getId() .
                        '.mht');
                $this->generateRELATIONSHIP(
                        'rMHTId' . $wordMHT->getId(), 'aFChunk', 'mht' .
                        $wordMHT->getId() . '.mht', 'TargetMode="Internal"');
                $this->generateDEFAULT('mht', 'message/rfc822');
                if ($class == 'WordFragment') {
                    $this->wordML .= (string) $wordMHT . '<w:p />';
                } else {
                    $this->_wordDocumentC .= (string) $wordMHT;
                }
            } else {
                throw new Exception('File does not exist.');
            }
        } catch (Exception $e) {
            //PhpdocxLogger::logger($e->getMessage(), 'fatal');
        }
    }
    
    /**
     * Add a RTF file. Keep content and styles
     *
     * @access public
     * @example ../examples/easy/RTF.php
     * @param array $options
     * Values:
     * 'src' (string) path to the RTF file
     */
    protected function addRTF($options = [])
    {
        $class = get_class($this);
        try {
            if ($this->_compatibilityMode) {
                throw new Exception('Running in compatibility mode. Unsupported method.');
            }
            if (file_exists($options['src'])) {
                $wordRTF = EmbedRTF::getInstance();
                $wordRTF->embed();
                //PhpdocxLogger::logger('Add RTF file to word document.', 'info');
                $this->saveToZip($options['src'], 'word/rtf' . $wordRTF->getId() .
                        '.rtf');
                $this->generateRELATIONSHIP(
                        'rRTFId' . $wordRTF->getId(), 'aFChunk', 'rtf' .
                        $wordRTF->getId() . '.rtf', 'TargetMode="Internal"');
                $this->generateDEFAULT('rtf', 'application/rtf');
                if ($class == 'WordFragment') {
                    $this->wordML .= (string) $wordRTF . '<w:p/>';
                } else {
                    $this->_wordDocumentC .= (string) $wordRTF;
                }
            } else {
                throw new Exception('File does not exist.');
            }
        } catch (Exception $e) {
            //PhpdocxLogger::logger($e->getMessage(), 'fatal');
        }
    }
    
    /**
     * Generates a relationship entry for the custom properties XML file
     *
     * @access protected
     */
    protected function generateCUSTOMRELS()
    {
        // write the new Relationship node
        $strCustom = '<Relationship Id="rId' . rand(999, 9999) . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/custom-properties" Target="docProps/custom.xml" />';
        $tempNode = self::$relsRels->createDocumentFragment();
        $tempNode->appendXML($strCustom);
        self::$relsRels->documentElement->appendChild($tempNode);
    }

    /**
     * Generate DEFAULT
     *
     * @access protected
     */
    protected function generateDEFAULT($extension, $contentType)
    {
        $strContent = $this->_contentTypeT->saveXML();
        if (
                strpos($strContent, 'Extension="' . $extension) === false
        ) {
            $strContentTypes = '<Default Extension="' . $extension . '" ContentType="' . $contentType . '"> </Default>';
            $tempNode = $this->_contentTypeT->createDocumentFragment();
            $tempNode->appendXML($strContentTypes);
            $this->_contentTypeT->documentElement->appendChild($tempNode);
        }
    }

    /**
     * Generate OVERRIDE
     *
     * @access protected
     * @param string $partName
     * @param string $contentType
     */
    protected function generateOVERRIDE($partName, $contentType)
    {
        $strContent = $this->_contentTypeT->saveXML();
        if (
                strpos($strContent, 'PartName="' . $partName . '"') === false
        ) {
            $strContentTypes = '<Override PartName="' . $partName . '" ContentType="' . $contentType . '" />';
            $tempNode = $this->_contentTypeT->createDocumentFragment();
            $tempNode->appendXML($strContentTypes);
            $this->_contentTypeT->documentElement->appendChild($tempNode);
        }
    }

    /**
     * Generate RELATIONSHIP
     *
     * @access protected
     */
    protected function generateRELATIONSHIP()
    {
        $arrArgs = func_get_args();

        if ($arrArgs[1] == 'vbaProject') {
            $type = 'http://schemas.microsoft.com/office/2006/relationships/vbaProject';
        } else {
            $type = 'http://schemas.openxmlformats.org/officeDocument/2006/' .
                    'relationships/' . $arrArgs[1];
        }

        if (!isset($arrArgs[3])) {
            $nodeWML = '<Relationship Id="' . $arrArgs[0] . '" Type="' . $type .
                    '" Target="' . $arrArgs[2] . '"></Relationship>';
        } else {
            $nodeWML = '<Relationship Id="' . $arrArgs[0] . '" Type="' . $type .
                    '" Target="' . $arrArgs[2] . '" ' . $arrArgs[3] .
                    '></Relationship>';
        }
        $relsNode = $this->_wordRelsDocumentRelsT->createDocumentFragment();
        $relsNode->appendXML($nodeWML);
        $this->_wordRelsDocumentRelsT->documentElement->appendChild($relsNode);
    }

    /**
     * Extracts a file from the template docx zip and returns it as an string or a DOMDocument/SimpleXMLElement object
     * 
     * @access protected
     * @param string $src the path of the file to be retrieved
     * @param string $type string, DOMDocument or SimpleXMLElement
     * @param ZipArchive object $zip
     * $return mixed
     */
    protected function getFromZip($src, $type = 'string', $zip = '')
    {
        if ($zip == '') {
            $zip = $this->_zipDocx;
        } else if ($zip instanceof ZipArchive) {
            // use $zip as the data source
        } else {
            //PhpdocxLogger::logger('The private method getFromZip is trying to extract data from a nonZipArchive object', 'fatal');
        }
        // extract the src contents from the zip

        $XMLData = $zip->getFromName($src);

        // return the data in the requested format
        if ($type == 'string') {
            return $XMLData;
        } else if ($type == 'DOMDocument') {
            if ($XMLData !== false) {
                $domDocument = new DOMDocument();
                $domDocument->loadXML($XMLData);
                return $domDocument;
            } else {
                return false;
            }
        } else if ($type == 'SimpleXMLElement') {
            if ($XMLData !== false) {
                $simpleXML = simplexml_load_string($XMLData);
            } else {
                return false;
            }
        } else {
            //PhpdocxLogger::logger('getFromZip: The chosen type is not recognized', 'fatal');
        }
    }
    
    /**
     * Gets all section nodes present in the docx
     *
     * @access protected
     * @param array $sectionNumbers
     * @return string
     */
    protected function getSectionNodes($sectionNumbers)
    {
        $sectNodes = [];
        // get all sectPr sections that may exist
        // within $this->_wordDocumentC
        $this->_tempDocumentDOM = $this->getDOMDocx();
        $sections = $this->_tempDocumentDOM->getElementsByTagName('sectPr');
        foreach ($sections as $section) {
            $sectNodes[] = $section;
        }
        $sectNodes[] = $this->_sectPr->documentElement;

        $finalSectNodes = [];
        if (empty($sectionNumbers)) {
            $finalSectNodes = $sectNodes;
        } else {
            foreach ($sectionNumbers as $key => $value) {
                if (isset($sectNodes[$value - 1])) {
                    $finalSectNodes[] = $sectNodes[$value - 1];
                }
            }
        }
        return $finalSectNodes;
    }
    
    /**
     * Modify the w:PageBorders sectPr property
     * 
     * @access protected
     * @param DOMNode $sectionNode
     * @param array $options 
     */
    protected function modifyPageBordersSectionProperty($sectionNode, $options)
    {
        // restart condition available types
        $display_types = ['allPages', 'firstPage', 'notFirstPage'];
        $offset_types = ['page', 'text'];
        $sides = ['top', 'left', 'bottom', 'right'];
        $type = ['width' => 4, 'color' => '000000', 'style' => 'single', 'space' => 24];

        // set default values
        if (isset($options['zOrder'])) {
            $zOrder = $options['zOrder'];
        } else {
            $zOrder = 1000;
        }
        if (isset($options['display']) && in_array($options['display'], $display_types)) {
            $display = $options['display'];
        } else {
            $display = 'allPages';
        }
        if (isset($options['offsetFrom']) && in_array($options['offsetFrom'], $offset_types)) {
            $offsetFrom = $options['offsetFrom'];
        } else {
            $offsetFrom = 'page';
        }
        foreach ($type as $key => $value) {
            foreach ($sides as $side) {
                if (isset($options['border_' . $side . '_' . $key])) {
                    $opt['border_' . $side . '_' . $key] = $options['border_' . $side . '_' . $key];
                } else if (isset($options['border_' . $key])) {
                    $opt['border_' . $side . '_' . $key] = $options['border_' . $key];
                } else {
                    $opt['border_' . $side . '_' . $key] = $value;
                }
            }
        }

        // if there is any previous pgBorders tag remove it
        if ($sectionNode->getElementsByTagName('pgBorders')->length > 0) {
            $pgBorder = $sectionNode->getElementsByTagName('pgBorders')->item(0);
            $pgBorder->parentNode->removeChild($pgBorder);
        }
        // insert the requested page borders
        $pgBordersNode = $sectionNode->ownerDocument->createDocumentFragment();
        $strNode = '<w:pgBorders ';
        $strNode .= 'xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" ';
        $strNode .= 'w:zOrder="' . $zOrder . '" w:display="' . $display . '" w:offsetFrom="' . $offsetFrom . '" >';
        foreach ($sides as $side) {
            $strNode .='<w:' . $side . ' w:val="' . $opt['border_' . $side . '_style'] . '" ';
            $strNode .= 'w:color="' . $opt['border_' . $side . '_color'] . '" ';
            $strNode .= 'w:sz="' . $opt['border_' . $side . '_width'] . '" ';
            $strNode .= 'w:space="' . $opt['border_' . $side . '_space'] . '" />';
        }
        $strNode .= '</w:pgBorders>';
        $pgBordersNode->appendXML($strNode);

        $propIndex = array_search('w:pgBorders', OOXMLResources::$sectionProperties);
        $childNodes = $sectionNode->childNodes;
        $index = false;
        foreach ($childNodes as $node) {
            $index = array_search($node->nodeName, OOXMLResources::$sectionProperties);
            if ($index > $propIndex) {
                $node->parentNode->insertBefore($pgBordersNode, $node);
                break;
            }
        }
        // in case no node was found we should append the node
        if (!$index) {
            $sectionNode->appendChild($pgBordersNode);
        }
    }
    
    /**
     * Recovers as a well formatted string the $_wordDocumentC variable
     *
     * @access protected
     */
    protected function restoreDocumentXML()
    {
        $stringDoc = $this->_tempDocumentDOM->saveXML();
        $bodyTag = explode('<w:body>', $stringDoc);
        if (isset($bodyTag[1])) {
            $this->_wordDocumentC = str_replace('</w:body></w:document>', '', $bodyTag[1]);
        }
    }

    /**
     * Inserts data in different format into the docx template zip
     * 
     * @access protected
     * @param mixed $src it can be a string, a DOMDocument object or a SimpleXMLElement object
     * @param string $target  path for the created file
     * @param ZipArchive object $zip
     * $return mixed
     */
    protected function saveToZip($src, $target, &$zip = '')
    {
        if ($zip == '') {
            $zip = $this->_zipDocx;
        } else if ($zip instanceof ZipArchive) {
            // use $zip as the data source
        } else {
            //PhpdocxLogger::logger('saveToZip: trying to insert data into a nonZipArchive object', 'fatal');
        }
        if (!is_object($src) && @is_file($src)) {
            // insert file into the zip
            try {
                $inserted = $zip->addFile($src, $target);
                if ($inserted === false) {
                    throw new Exception('Error while inserting the ' . $target . 'into the zip');
                }
            } catch (Exception $e) {
                //PhpdocxLogger::logger($e->getMessage(), 'fatal');
            }
        } else {
            if (is_string($src)) {
                $XMLData = $src;
            } else if ($src instanceof DOMDocument) {
                $XMLData = $src->saveXML();
            } else if ($src instanceof SimpleXMLElement) {
                $XMLData = $src->asXML();
            } else {
                $XMLData = $src;
                ////PhpdocxLogger::logger('saveToZip: invalid data source', 'fatal');
            }
            // insert the data into the zip
            try {
                $inserted = $zip->addFromString($target, $XMLData);
                if ($inserted === false) {
                    throw new Exception('Error while inserting the ' . $target . 'into the zip');
                }
            } catch (Exception $e) {
                //PhpdocxLogger::logger($e->getMessage(), 'fatal');
            }
        }
    }

    /**
     * Clean template
     *
     * @access private
     */
    private function cleanTemplate()
    {
        //PhpdocxLogger::logger('Remove existing template tags.', 'debug');
        $this->_wordDocumentT = preg_replace(
                '/__[A-Z]+__/', '', $this->_wordDocumentT
        );
    }

    /**
     * Modify/create the rels files for footnotes, endnotes and comments
     * @param string $type can be footnote, endnote or comment
     * @access private
     */
    private function generateRelsNotes($type)
    {
        if ($type == 'footnote') {
            $relsDOM = $this->_wordFootnotesRelsT;
        } else if ($type == 'endnote') {
            $relsDOM = $this->_wordEndnotesRelsT;
        } else if ($type == 'comment') {
            $relsDOM = $this->_wordCommentsRelsT;
        } else {
            //PhpdocxLogger::logger('Wrong note type', 'fatal');
        }
        if (!empty(CreateDocx::$_relsNotesImage[$type])) {
            foreach (CreateDocx::$_relsNotesImage[$type] as $key => $value) {
                if (empty($value['name'])) {
                    $value['name'] = $value['rId'];
                }
                $nodeWML = '<Relationship Id="' . $value['rId'] . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="media/img' . $value['name'] . '.' . $value['extension'] . '" ></Relationship>';
                $relsNode = $relsDOM->createDocumentFragment();
                $relsNode->appendXML($nodeWML);
                $relsDOM->documentElement->appendChild($relsNode);
            }
        }
        if (!empty(CreateDocx::$_relsNotesExternalImage[$type])) {
            foreach (CreateDocx::$_relsNotesExternalImage[$type] as $key => $value) {
                $nodeWML = '<Relationship Id="' . $value['rId'] . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="' . $value['url'] . '" TargetMode="External" ></Relationship>';
                $relsNode = $relsDOM->createDocumentFragment();
                $relsNode->appendXML($nodeWML);
                $relsDOM->documentElement->appendChild($relsNode);
            }
        }
        if (!empty(CreateDocx::$_relsNotesLink[$type])) {
            foreach (CreateDocx::$_relsNotesLink[$type] as $key => $value) {
                $nodeWML = '<Relationship Id="' . $value['rId'] . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/hyperlink" Target="' . $value['url'] . '" TargetMode="External" ></Relationship>';
                $relsNode = $relsDOM->createDocumentFragment();
                $relsNode->appendXML($nodeWML);
                $relsDOM->documentElement->appendChild($relsNode);
            }
        }

        if ($type == 'footnote') {
            $this->_wordFootnotesRelsT = $relsDOM;
        } else if ($type == 'endnote') {
            $this->_wordEndnotesRelsT = $relsDOM;
        } else if ($type == 'comment') {
            $this->_wordCommentsRelsT = $relsDOM;
        }
    }

    /**
     * Generate SECTPR
     *
     * @access private
     * @param array $args Section style
     */
    private function generateSECTPR($args = '')
    {
        $page = CreatePage::getInstance();
        $page->createSECTPR($args);
        $this->_wordDocumentC .= (string) $page;
    }

    /**
     * Generates an element in settings.xml
     *
     * @access private
     */
    private function generateSetting($tag)
    {
        if ((!in_array($tag, OOXMLResources::$settings))) {
            //PhpdocxLogger::logger('Incorrect setting tag', 'fatal');
        }
        $settingIndex = array_search($tag, OOXMLResources::$settings);
        $selectedElements = $this->_wordSettingsT->documentElement->getElementsByTagName($tag);
        if ($selectedElements->length == 0) {
            $settingsElement = $this->_wordSettingsT->createDocumentFragment();
            $settingsElement->appendXML('<' . $tag . ' xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" />');
            $childNodes = $this->_wordSettingsT->documentElement->childNodes;
            $index = false;
            foreach ($childNodes as $node) {
                $index = array_search($node->nodeName, OOXMLResources::$settings);
                if ($index > $settingIndex) {
                    $node->parentNode->insertBefore($settingsElement, $node);
                    break;
                }
            }
            // in case no node was found (pretty unlikely)we should append the node
            if (!$index) {
                $this->_wordSettingsT->documentElement->appendChild($settingsElement);
            }
        }
    }

    /**
     * Generate WordDocument XML template
     *
     * @access private
     */
    private function generateTemplateWordDocument()
    {
        if (count(CreateDocx::$insertNameSpaces) > 0) {
            $strxmlns = '';
            foreach (CreateDocx::$insertNameSpaces as $key => $value) {
                $strxmlns .= $key . '="' . $value . '" ';
            }
            $this->_documentXMLElement = str_replace('<w:document', '<w:document ' . $strxmlns, $this->_documentXMLElement);
        }
        $this->_wordDocumentC .= $this->_sectPr->saveXML($this->_sectPr->documentElement); //FIXME: I am insertying by hand the sections of the base template
        if (!empty($this->_wordHeaderC)) {
            $this->_wordDocumentC = str_replace(
                    '__GENERATEHEADERREFERENCE__', '<' . CreateDocx::NAMESPACEWORD . ':headerReference ' .
                    CreateDocx::NAMESPACEWORD . ':type="default" r:id="rId' .
                    $this->_idWords['header'] . '"></' .
                    CreateDocx::NAMESPACEWORD . ':headerReference>', $this->_wordDocumentC
            );
        }
        if (!empty($this->_wordFooterC)) {
            $this->_wordDocumentC = str_replace(
                    '__GENERATEFOOTERREFERENCE__', '<' . CreateDocx::NAMESPACEWORD . ':footerReference ' .
                    CreateDocx::NAMESPACEWORD . ':type="default" r:id="rId' .
                    $this->_idWords['footer'] . '"></' .
                    CreateDocx::NAMESPACEWORD . ':footerReference>', $this->_wordDocumentC
            );
        }
        $this->_wordDocumentT = $this->_documentXMLElement .
                $this->_background .
                '<' . CreateDocx::NAMESPACEWORD . ':body>' .
                $this->_wordDocumentC .
                '</' . CreateDocx::NAMESPACEWORD . ':body>' .
                '</' . CreateDocx::NAMESPACEWORD . ':document>';
        $this->cleanTemplate();
    }

    /**
     * Generates a TitlePg element in SectPr
     *
     * @access private
     * @param boolean $extraSections if true there is more than one section
     */
    private function generateTitlePg($extraSections)
    {
        if ($extraSections) {
            $domDocument = $this->getDOMDocx();
            $sections = $domDocument->getElementsByTagName('sectPr');
            $firstSection = $sections->item(0);
            $foundNodes = $firstSection->getElementsByTagName('TitlePg');
            if ($foundNodes->length == 0) {
                $newSectNode = '<w:titlePg xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" />';
                $sectNode = $domDocument->createDocumentFragment();
                $sectNode->appendXML($newSectNode);
                $refNode = $firstSection->appendChild($sectNode);
            } else {
                $foundNodes->item(0)->setAttribute('val', 1);
            }
            $stringDoc = $domDocument->saveXML();
            $bodyTag = explode('<w:body>', $stringDoc);
            $this->_wordDocumentC = str_replace('</w:body></w:document>', '', $bodyTag[1]);
        } else {

            $foundNodes = $this->_sectPr->documentElement->getElementsByTagName('TitlePg');
            if ($foundNodes->length == 0) {
                $newSectNode = '<w:titlePg xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" />';
                $sectNode = $this->_sectPr->createDocumentFragment();
                $sectNode->appendXML($newSectNode);
                $refNode = $this->_sectPr->documentElement->appendChild($sectNode);
            } else {
                $foundNodes->item(0)->setAttribute('val', 1);
            }
        }
    }

    /**
     * Takes care of the links and images asociated with an HTML chunck processed
     * by the embedHTML method
     *
     * @access private
     * @param array $sFinalDocX an arry with the required link and image data
     */
    private function HTMLRels($sFinalDocX, $options)
    {
        $relsLinks = '';
        if ($options['target'] == 'defaultHeader' ||
                $options['target'] == 'firstHeader' ||
                $options['target'] == 'evenHeader' ||
                $options['target'] == 'defaultFooter' ||
                $options['target'] == 'firstFooter' ||
                $options['target'] == 'evenFooter') {
            foreach ($sFinalDocX[1] as $key => $value) {
                CreateDocx::$_relsHeaderFooterLink[$options['target']][] = ['rId' => $key, 'url' => $value];
            }
        } else if ($options['target'] == 'footnote' ||
                $options['target'] == 'endnote' ||
                $options['target'] == 'comment') {
            foreach ($sFinalDocX[1] as $key => $value) {
                CreateDocx::$_relsNotesLink[$options['target']][] = ['rId' => $key, 'url' => $value];
            }
        } else {
            foreach ($sFinalDocX[1] as $key => $value) {
                $relsLinks .= '<Relationship Id="' . $key . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/hyperlink" Target="' . $value . '" TargetMode="External" />';
            }
            if ($relsLinks != '') {
                $relsNode = $this->_wordRelsDocumentRelsT->createDocumentFragment();
                $relsNode->appendXML($relsLinks);
                $this->_wordRelsDocumentRelsT->documentElement->appendChild($relsNode);
            }
        }

        $relsImages = '';

        if ($options['target'] == 'defaultHeader' ||
                $options['target'] == 'firstHeader' ||
                $options['target'] == 'evenHeader' ||
                $options['target'] == 'defaultFooter' ||
                $options['target'] == 'firstFooter' ||
                $options['target'] == 'evenFooter') {
            foreach ($sFinalDocX[2] as $key => $value) {
                // remove the first three 'rId' characters in this case
                $value = array_shift(explode('?', $value));
                if (isset($options['downloadImages']) && $options['downloadImages']) {
                    $arrayExtension = explode('.', $value);
                    $extension = strtolower(array_pop($arrayExtension));
                    $predefinedExtensions = ['gif', 'png', 'jpg', 'jpeg', 'bmp'];
                    if (!in_array($extension, $predefinedExtensions)) {
                        $this->generateDEFAULT($extension, 'image/' . $extension);
                    }

                    createDocx::$_relsHeaderFooterImage[$options['target']][] = ['rId' => $key, 'extension' => $extension];
                } else {
                    createDocx::$_relsHeaderFooterExternalImage[$options['target']][] = ['rId' => $key, 'url' => $value];
                }
            }
        } else if ($options['target'] == 'footnote' ||
                $options['target'] == 'endnote' ||
                $options['target'] == 'comment') {
            foreach ($sFinalDocX[2] as $key => $value) {
                // remove the first three 'rId' characters in this case
                $value = array_shift(explode('?', $value));
                if (isset($options['downloadImages']) && $options['downloadImages']) {
                    $arrayExtension = explode('.', $value);
                    $extension = strtolower(array_pop($arrayExtension));
                    $predefinedExtensions = ['gif', 'png', 'jpg', 'jpeg', 'bmp'];
                    if (!in_array($extension, $predefinedExtensions)) {
                        $this->generateDEFAULT($extension, 'image/' . $extension);
                    }

                    CreateDocx::$_relsNotesImage[$options['target']][] = ['rId' => $key, 'extension' => $extension];
                } else {
                    CreateDocx::$_relsNotesExternalImage[$options['target']][] = ['rId' => $key, 'url' => $value];
                }
            }
        } else {
            foreach ($sFinalDocX[2] as $key => $value) {
                $valueArray = explode('?', $value);
                $value = array_shift($valueArray);
                if (isset($options['downloadImages']) && $options['downloadImages']) {
                    $arrayExtension = explode('.', $value);
                    $extension = strtolower(array_pop($arrayExtension));
                    $predefinedExtensions = ['gif', 'png', 'jpg', 'jpeg', 'bmp'];
                    if (!in_array($extension, $predefinedExtensions)) {
                        $this->generateDEFAULT($extension, 'image/' . $extension);
                    }
                    $relsImages .= '<Relationship Id="' . $key . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="media/img' . $key . '.' . $extension . '" />';
                } else {
                    $relsImages .= '<Relationship Id="' . $key . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="' . $value . '" TargetMode="External" />';
                }
            }

            if ($relsImages != '') {
                $relsNodeImages = $this->_wordRelsDocumentRelsT->createDocumentFragment();
                $relsNodeImages->appendXML($relsImages);
                $this->_wordRelsDocumentRelsT->documentElement->appendChild($relsNodeImages);
            }
        }
    }
    
    /**
     * Modify a single sectPr property with no XML childs
     * 
     * @access private
     * @param DOMNode $sectionNode
     * @param string $tag name of the property we want to modify
     * @param array $options the corresponding attribute values
     */
    private function modifySingleSectionProperty($sectionNode, $tag, $options, $nameSpace = 'w')
    {
        if ($sectionNode->getElementsByTagName($tag)->length > 0) {
            // node exists
            $node = $sectionNode->getElementsByTagName($tag);
            foreach ($options as $key => $value) {
                $node->item(0)->setAttribute($nameSpace . ':' . $key, $value);
            }
        } else {
            // otherwise create it
            $newNode = $sectionNode->ownerDocument->createDocumentFragment();
            $strNode = '<' . $nameSpace . ':' . $tag . ' ';
            foreach ($options as $key => $value) {
                $strNode .= $nameSpace . ':' . $key . '="' . $value . '" ';
            }
            if ($nameSpace == 'w') {
                $strNode .=' xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" ';
            }
            $strNode .='/>';
            $newNode->appendXML($strNode);

            $propIndex = array_search($nameSpace . ':' . $tag, OOXMLResources::$sectionProperties);
            $childNodes = $sectionNode->childNodes;
            $index = false;
            foreach ($childNodes as $node) {
                $name = $node->nodeName;
                $index = array_search($node->nodeName, OOXMLResources::$sectionProperties);
                if ($index > $propIndex) {
                    $node->parentNode->insertBefore($newNode, $node);
                    break;
                }
            }
            // in case no node was found we should append the node
            if (!$index) {
                $sectionNode->appendChild($newNode);
            }
        }
    }
    
    /**
     * Parse path dir
     *
     * @access private
     * @param string $dir Directory path
     */
    private function parsePath($dir)
    {
        $slash = 0;
        $path = '';
        if (($slash = strrpos($dir, '/')) !== false) {
            $slash += 1;
            $path = substr($dir, 0, $slash);
        }
        $punto = strpos(substr($dir, $slash), '.');

        $nombre = substr($dir, $slash, $punto);
        $extension = substr($dir, $punto + $slash + 1);
        return [
            'path' => $path, 'nombre' => $nombre, 'extension' => $extension
        ];
    }
    
    /**
     * Parses a WordML fragment to be inserted as a footnote or endnote
     *
     * @access private
     * @param string $type it can be footnote, endnote or comment
     * @param WordFragment object $wordFragment
     * @param array $markOptions the note mark options
     * @param array $referenceOptions the note reference options
     * @return string
     */
    private function parseWordMLNote($type, $wordFragment, $markOptions = [], $referenceOptions = [])
    {
        $referenceOptions = self::translateTextOptions2StandardFormat($referenceOptions);
        $referenceOptions = self::setRTLOptions($referenceOptions);

        $strFrag = (string) $wordFragment;
        $basePIni = '<w:p><w:pPr><w:pStyle w:val="' . $type . 'TextPHPDOCX"/>';
        if (isset($referenceOptions['bidi']) && $referenceOptions['bidi']) {
            $basePIni .= '<w:bidi />';
        }
        $basePIni .= '</w:pPr>';
        $run .= '<w:r><w:rPr><w:rStyle w:val="' . $type . 'ReferencePHPDOCX"/>';
        // parse the referenceMark options
        if (isset($referenceOptions['font'])) {
            $run .= '<w:rFonts w:ascii="' . $referenceOptions['font'] .
                    '" w:hAnsi="' . $referenceOptions['font'] .
                    '" w:cs="' . $referenceOptions['font'] . '"/>';
        }
        if (isset($referenceOptions['b'])) {
            $run .= '<w:b w:val="' . $referenceOptions['b'] . '"/>';
            $run .= '<w:bCs w:val="' . $referenceOptions['b'] . '"/>';
        }
        if (isset($referenceOptions['i'])) {
            $run .= '<w:i w:val="' . $referenceOptions['i'] . '"/>';
            $run .= '<w:iCs w:val="' . $referenceOptions['i'] . '"/>';
        }
        if (isset($referenceOptions['color'])) {
            $run .= '<w:color w:val="' . $referenceOptions['color'] . '"/>';
        }
        if (isset($referenceOptions['sz'])) {
            $run .= '<w:sz w:val="' . (2 * $referenceOptions['sz']) . '"/>';
            $run .= '<w:szCs w:val="' . (2 * $referenceOptions['sz']) . '"/>';
        }
        if (isset($referenceOptions['rtl']) && $referenceOptions['rtl']) {
            $basePIni .= '<w:rtl />';
        }
        $run .= '</w:rPr>';
        if (isset($markOptions['customMark'])) {
            $run .= '<w:t>' . $markOptions['customMark'] . '</w:t>';
        } else {
            if ($type != 'comment') {
                $run .= '<w:' . $type . 'Ref/>';
            }
        }
        $run .= '</w:r>';
        $basePEnd = '</w:p>';
        // check if the WordML fragment starts with a paragraph
        $startFrag = substr($strFrag, 0, 5);
        if ($startFrag == '<w:p>') {
            $strFrag = preg_replace('/<\/w:pPr>/', '</w:pPr>' . $run, $strFrag, 1);
        } else {
            $strFrag = $basePIni . $run . $basePEnd . $strFrag;
        }
        return $strFrag;
    }

    /**
     * Preprocess a docx for the addDOCX method
     * By the time being we only remove the w:nsid and w:tmpl nodes from the
     * numbering.xml file
     *
     * @param string $path path to file
     */
    private function preprocessDocx($pathDOCX)
    {
        //PhpdocxLogger::logger('Preprocess a docx for embeding with the addDOCX method.', 'debug');
        try {
            $embedZip = new ZipArchive();
            if ($embedZip->open($pathDOCX) === true) {
                // the docx was succesfully unzipped
            } else {
                throw new Exception(
                'it was not posible to unzip the docx file.'
                );
            }
            $numberingXML = $embedZip->getFromName('word/numbering.xml');
            $numberingDOM = new DOMDocument();
            $numberingDOM->loadXML($numberingXML);
            $numberingXPath = new DOMXPath($numberingDOM);
            $numberingXPath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
            // remove the w:nsid and w:tmpl elements to avoid conflicts
            $nsidQuery = '//w:nsid | //w:tmpl';
            $nsidNodes = $numberingXPath->query($nsidQuery);
            foreach ($nsidNodes as $node) {
                $node->parentNode->removeChild($node);
            }
            $newNumbering = $numberingDOM->saveXML();
            $embedZip->addFromString('word/numbering.xml', $newNumbering);
            $embedZip->close();
        } catch (Exception $e) {
            //PhpdocxLogger::logger($e->getMessage(), 'fatal');
        }
    }

    /**
     * Removes an element from settings.xml
     *
     * @access private
     */
    private function removeSetting($tag)
    {
        $settingsHeader = $this->_wordSettingsT->documentElement->getElementsByTagName($tag);
        if ($settingsHeader->length > 0) {
            $this->_wordSettingsT->documentElement->removeChild($settingsHeader->item(0));
        }
    }

}

class PhpdocxUtilities
{

    /**
     *
     * @access public
     * @static
     * @var integer
     */
    private static $_phpdocxConfig;

    /**
     * Check if string is UTF8
     *
     * @access public
     * @param string $string String to check
     * @static
     * @return boolean
     */
    public static function isUtf8($string_input)
    {
        $string = $string_input;

        $string = preg_replace("#[\x09\x0A\x0D\x20-\x7E]#", "", $string);
        $string = preg_replace("#[\xC2-\xDF][\x80-\xBF]#", "", $string);
        $string = preg_replace("#\xE0[\xA0-\xBF][\x80-\xBF]#", "", $string);
        $string = preg_replace("#[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}#", "", $string);
        $string = preg_replace("#\xED[\x80-\x9F][\x80-\xBF]#", "", $string);
        $string = preg_replace("#\xF0[\x90-\xBF][\x80-\xBF]{2}#", "", $string);
        $string = preg_replace("#[\xF1-\xF3][\x80-\xBF]{3}#", "", $string);
        $string = preg_replace("#\xF4[\x80-\x8F][\x80-\xBF]{2}#", "", $string);

        return ($string == "" ? true : false);
    }

    /**
     * Return a uniqueid to be used in tags
     *
     * @access public
     * @static
     * @return string
     */
    public static function parseConfig()
    {
        if (!isset(self::$_phpdocxConfig)) {
            self::$_phpdocxConfig = parse_ini_file(dirname(__FILE__) . '/config/phpdocxconfig.ini', true);
        }
        return self::$_phpdocxConfig;
    }

    /**
     * Return a uniqueid to be used in tags
     *
     * @access public
     * @static
     * @return string
     */
    public static function uniqueId()
    {
        $uniqueid = uniqid('phpdocx_');

        return $uniqueid;
    }

}


class CreateDocxFromTemplate extends CreateDocx
{

    /**
     *
     * @access public
     * @static
     * @var string
     */
    public static $_templateSymbol = '$';

    /**
     *
     * @access public
     * @static
     * @var boolean
     */
    public static $_preprocessed = false;

    /**
     * Construct
     * @param string $docxTemplatePath path to the template we wish to use
     * @param array $options
     * The available keys and values are:
     *  'preprocessed' (boolean) if true the variables will not be 'repaired'. Default value is false
     * @access public
     */
    public function __construct($docxTemplatePath, $options = [])
    {
        if (empty($docxTemplatePath)) {
            //PhpdocxLogger::logger('The template path can not be empty', 'fatal');
        }
        parent::__construct($baseTemplatePath = PHPDOCX_BASE_TEMPLATE, $docxTemplatePath);
        if (!empty($options['preprocessed'])) {
            self::$_preprocessed = true;
        }
    }

    /**
     * Destruct
     *
     * @access public
     */
    public function __destruct()
    {

    }

    /**
     * Getter. Return template symbol
     *
     * @access public
     * @return string
     */
    public function getTemplateSymbol()
    {
        return self::$_templateSymbol;
    }

    /**
     * Setter. Set template symbol
     *
     * @access public
     * @param string $templateSymbol
     */
    public function setTemplateSymbol($templateSymbol = '$')
    {
        self::$_templateSymbol = $templateSymbol;
    }

    /**
     * Clear all the placeholders variables which start with 'BLOCK_'
     *
     * @access public
     */
    public function clearBlocks()
    {
        $loadContent = $this->_documentXMLElement . '<w:body>' .
            $this->_wordDocumentC . '</w:body></w:document>';
        // Sometimes Word splits tags so they have to be repared
        // Like this time we do not know the exact variable name we can not use
        // the repairVariable method directly
        $documentSymbol = explode(self::$_templateSymbol, $loadContent);
        foreach ($documentSymbol as $documentSymbolValue) {
            if (strpos(strip_tags($documentSymbolValue), 'BLOCK_') !== false) {
                $loadContent = str_replace($documentSymbolValue, strip_tags($documentSymbolValue), $loadContent);
            }
        }
        $domDocument = new DomDocument();
        $domDocument->loadXML($loadContent);

        //Use XPath to find all paragraphs that include a BLOCK variable name
        $name = self::$_templateSymbol . 'BLOCK_';
        $xpath = new DOMXPath($domDocument);
        $xpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $query = '//w:p[w:r/w:t[text()[contains(.,"' . $name . '")]]]';
        $affectedNodes = $xpath->query($query);
        foreach ($affectedNodes as $node) {
            $paragraphContents = $node->ownerDocument->saveXML($node);
            $paragraphText = strip_tags($paragraphContents);
            if (($pos = strpos($paragraphText, $name, 0)) !== false) {
                //If we remove a paragraph inside a table cell we need to take special care
                if ($node->parentNode->nodeName == 'w:tc') {
                    $tcChilds = $node->parentNode->getElementsByTagNameNS('http://schemas.openxmlformats.org/wordprocessingml/2006/main', 'p');
                    if ($tcChilds->length > 1) {
                        $node->parentNode->removeChild($node);
                    } else {
                        $emptyP = $domDocument->createElement("w:p");
                        $node->parentNode->appendChild($emptyP);
                        $node->parentNode->removeChild($node);
                    }
                } else {
                    $node->parentNode->removeChild($node);
                }
            }
        }
        $stringDoc = $domDocument->saveXML();
        $bodyTag = explode('<w:body>', $stringDoc);
        $this->_wordDocumentC = str_replace('</w:body></w:document>', '', $bodyTag[1]);
    }

    /**
     * Removes all content between two 'BLOCK_*' variables
     *
     * @access public
     * @param string $blockName Block name
     */
    public function deleteTemplateBlock($blockName)
    {
        $aType = ['BLOCK_'/* , 'TAB_' */]; //deletables types
        foreach ($aType as $type) {
            $variableName = $type . $blockName;
            $loadContent = $this->_documentXMLElement . '<w:body>' .
                $this->_wordDocumentC . '</w:body></w:document>';
            if (!self::$_preprocessed) {
                $loadContent = $this->repairVariables([$variableName => ''], $loadContent);
            }
            $loadContent = preg_replace('/\\' . self::$_templateSymbol . $type . $blockName . '([|]|\\' . self::$_templateSymbol . ').*?\\' . self::$_templateSymbol . $type . $blockName . '.*?\\' . self::$_templateSymbol . '/', self::$_templateSymbol . $variableName . self::$_templateSymbol, $loadContent);
            //Use XPath to find all paragraphs that include the variable name
            $name = self::$_templateSymbol . $variableName . self::$_templateSymbol;
            $domDocument = new DOMDocument();
            $domDocument->loadXML($loadContent);
            $xpath = new DOMXPath($domDocument);
            $xpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
            $query = '//w:p[w:r/w:t[text()[contains(.,"' . $variableName . '")]]]';
            $affectedNodes = $xpath->query($query);
            foreach ($affectedNodes as $node) {
                $paragraphContents = $node->ownerDocument->saveXML($node);
                $paragraphText = strip_tags($paragraphContents);
                if (($pos = strpos($paragraphText, $name, 0)) !== false) {
                    //If we remove a paragraph inside a table cell we need to take special care
                    if ($node->parentNode->nodeName == 'w:tc') {
                        $tcChilds = $node->parentNode->getElementsByTagNameNS('http://schemas.openxmlformats.org/wordprocessingml/2006/main', 'p');
                        if ($tcChilds->length > 1) {
                            $node->parentNode->removeChild($node);
                        } else {
                            $emptyP = $domDocument->createElement("w:p");
                            $node->parentNode->appendChild($emptyP);
                            $node->parentNode->removeChild($node);
                        }
                    } else {
                        $node->parentNode->removeChild($node);
                    }
                }
            }
            $bodyTag = explode('<w:body>', $domDocument->saveXML());
            $this->_wordDocumentC = str_replace('</w:body></w:document>', '', $bodyTag[1]);
        }
    }

    /**
     * Returns the template variables
     *
     * @access public
     * @param $target may be all (default), document, header, footer, footnotes, endnotes or comments
     * @param array $prefixes (optional) if nonempty it will only return the
     * variables that start with the given prefixes
     * @return array
     */
    public function getTemplateVariables($target = 'all', $prefixes = [], $variables = [])
    {
        $targetTypes = ['document', 'header', 'footer', 'footnotes', 'endnotes', 'comments'];

        if ($target == 'document') {
            $documentSymbol = explode(self::$_templateSymbol, $this->_wordDocumentC);
            $variables = $this->extractVariables($target, $documentSymbol, $variables);
        } else if ($target == 'header') {
            $xpathHeaders = simplexml_import_dom($this->_contentTypeT);
            $xpathHeaders->registerXPathNamespace('ns', 'http://schemas.openxmlformats.org/package/2006/content-types');
            $xpathHeadersResults = $xpathHeaders->xpath('ns:Override[@ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.header+xml"]');
            foreach ($xpathHeadersResults as $headersResults) {
                $header = substr($headersResults['PartName'], 1);
                $loadContent = $this->getFromZip($header);
                if (empty($loadContent)) {
                    $loadContent = $this->_modifiedHeadersFooters[$header];
                }
                $documentSymbol = explode(self::$_templateSymbol, $loadContent);
                $variables = $this->extractVariables($target, $documentSymbol, $variables);
            }
        } else if ($target == 'footer') {
            $xpathFooters = simplexml_import_dom($this->_contentTypeT);
            $xpathFooters->registerXPathNamespace('ns', 'http://schemas.openxmlformats.org/package/2006/content-types');
            $xpathFootersResults = $xpathFooters->xpath('ns:Override[@ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.footer+xml"]');
            foreach ($xpathFootersResults as $footersResults) {
                $footer = substr($footersResults['PartName'], 1);
                $loadContent = $this->getFromZip($footer);
                if (empty($loadContent)) {
                    $loadContent = $this->_modifiedHeadersFooters[$footer];
                }
                $documentSymbol = explode(self::$_templateSymbol, $loadContent);
                $variables = $this->extractVariables($target, $documentSymbol, $variables);
            }
        } else if ($target == 'footnotes') {
            $documentSymbol = explode(self::$_templateSymbol, $this->_wordFootnotesT->saveXML());
            $variables = $this->extractVariables($target, $documentSymbol, $variables);
        } else if ($target == 'endnotes') {
            $documentSymbol = explode(self::$_templateSymbol, $this->_wordEndnotesT->saveXML());
            $variables = $this->extractVariables($target, $documentSymbol, $variables);
        } else if ($target == 'comments') {
            $documentSymbol = explode(self::$_templateSymbol, $this->_wordCommentsT->saveXML());
            $variables = $this->extractVariables($target, $documentSymbol, $variables);
        } else if ($target == 'all') {
            foreach ($targetTypes as $targets) {
                $variables = $this->getTemplateVariables($targets, $prefixes, $variables);
            }
        }

        return $variables;
    }

    /**
     * Modify the value of an input field
     *
     * @access public
     * @param array $data with the key the name of the variable and the value the value of the input text
     *
     */
    public function modifyInputFields($data)
    {
        $loadContent = $this->_documentXMLElement . '<w:body>' .
            $this->_wordDocumentC . '</w:body></w:document>';
        $domDocument = new DOMDocument();
        $domDocument->loadXML($loadContent);
        $docXPath = new DOMXPath($domDocument);
        $docXPath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $docXPath->registerNamespace('w14', 'http://schemas.microsoft.com/office/word/2010/wordml');
        foreach ($data as $var => $value) {
            //check for legacy checkboxes
            $queryDoc = '//w:ffData[w:name[@w:val="' . $var . '"]]';
            $affectedNodes = $docXPath->query($queryDoc);
            foreach ($affectedNodes as $node) {
                //get the parent p Node
                $pNode = $node->parentNode->parentNode->parentNode;
                //we should take into account that there could be more than one firld per paragraph
                $preliminaryQuery = './/w:r[descendant::w:ffData and count(preceding-sibling::w:r[descendant::w:name[@w:val = "' . $var . '"]]) < 1]';
                $previousInputs = $docXPath->query($preliminaryQuery, $pNode)->length;
                $position = $previousInputs - 1;
                $query = './/w:r[count(preceding-sibling::w:r[descendant::w:fldChar[@w:fldCharType = "separate"]]) >= ' . ($position + 1);
                $query .= ' and count(preceding-sibling::w:r[descendant::w:fldChar[@w:fldCharType = "end"]]) < ' . ($position + 1);
                $query .= ' and not(descendant::w:fldChar)]';
                $rNodes = $docXPath->query($query, $pNode);
                $rCount = 0;
                foreach ($rNodes as $rNode) {
                    if ($rCount == 0) {
                        $rNode->getElementsByTagName('t')->item(0)->nodeValue = $value;
                    } else {
                        $rNode->setAttribute('w:remove', 1);
                    }
                    $rCount++;
                }
                //remove the unwanted rNodes
                $query = './/w:r[@w:remove="1"]';
                $removeNodes = $docXPath->query($query, $pNode);
                $length = $removeNodes->length;
                for ($j = $length - 1; $j > -1; $j--) {
                    $removeNodes->item($j)->parentNode->removeChild($removeNodes->item($j));
                }
            }
            //Now we look for Word 2010 sdt checkboxes
            $queryDoc = '//w:sdtPr[w:tag[@w:val="' . $var . '"]]';
            $affectedNodes = $docXPath->query($queryDoc);
            foreach ($affectedNodes as $node) {
                $sdtNode = $node->parentNode;
                $query = './/w:t[1]';
                $tNode = $docXPath->query($query, $sdtNode)->item(0)->nodeValue = $value;
            }
        }

        $stringDoc = $domDocument->saveXML();
        $bodyTag = explode('<w:body>', $stringDoc);
        $this->_wordDocumentC = str_replace('</w:body></w:document>', '', $bodyTag[1]);
    }

    /**
     * process the template to repair all listed variables
     *
     * @access public
     * @param array $variables an array of arrays of variables that should be repaired.
     * Posible keys and values are:
     *  'document' array of variables within the main document
     *  'headers' array of variables within the headers
     *  'footers' array of variables within the headers
     *  'footnotes' array of variables within the footnotes
     *  'endnotes' array of variables within the endnotes
     *  'comments' array of variables within the comments
     * If the array is empty the variables will be tried to be extracted automatically.
     * @return array
     */
    public function processTemplate($variables = [])
    {
        self::$_preprocessed = true;
        if (is_array($variables) && count($variables) == 0) {
            $variables = $this->getTemplateVariables();
        }
        foreach ($variables as $target => $varList) {
            $variableList = array_flip($varList);
            if ($target == 'document') {
                $loadContent = $this->_documentXMLElement . '<w:body>' .
                    $this->_wordDocumentC . '</w:body></w:document>';
                $stringDoc = $this->repairVariables($variableList, $loadContent);
                $bodyTag = explode('<w:body>', $stringDoc);
                $this->_wordDocumentC = str_replace('</w:body></w:document>', '', $bodyTag[1]);
            } else if ($target == 'footnotes') {
                $content = $this->_wordFootnotesT->saveXML();
                $XML = $this->repairVariables($variableList, $content);
                $this->_wordFootnotesT = new DOMDocument();
                $this->_wordFootnotesT->loadXML($XML);
            } else if ($target == 'endnotes') {
                $content = $this->_wordEndnotesT->saveXML();
                $XML = $this->repairVariables($variableList, $content);
                $this->_wordEndnotesT = new DOMDocument();
                $this->_wordEndnotesT->loadXML($XML);
            } else if ($target == 'comments') {
                $content = $this->_wordCommentsT->saveXML();
                $XML = $this->repairVariables($variableList, $content);
                $this->_wordCommentsT = new DOMDocument();
                $this->_wordCommentsT->loadXML($XML);
            } else if ($target == 'headers') {
                $xpathHeaders = simplexml_import_dom($this->_contentTypeT);
                $xpathHeaders->registerXPathNamespace('ns', 'http://schemas.openxmlformats.org/package/2006/content-types');
                $xpathHeadersResults = $xpathHeaders->xpath('ns:Override[@ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.header+xml"]');
                foreach ($xpathHeadersResults as $headersResults) {
                    $header = substr($headersResults['PartName'], 1);
                    $loadContent = $this->getFromZip($header);
                    if (empty($loadContent)) {
                        $loadContent = $this->_modifiedHeadersFooters[$header];
                    }
                    $dom = $this->repairVariables($variableList, $loadContent);
                    $this->_modifiedHeadersFooters[$header] = $dom->saveXML();
                    $this->saveToZip($dom, $header);
                }
            } else if ($target == 'footers') {
                $xpathFooters = simplexml_import_dom($this->_contentTypeT);
                $xpathFooters->registerXPathNamespace('ns', 'http://schemas.openxmlformats.org/package/2006/content-types');
                $xpathFootersResults = $xpathFooters->xpath('ns:Override[@ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.footer+xml"]');
                foreach ($xpathFootersResults as $footersResults) {
                    $footer = substr($footersResults['PartName'], 1);
                    $loadContent = $this->getFromZip($footer);
                    if (empty($loadContent)) {
                        $loadContent = $this->_modifiedHeadersFooters[$footer];
                    }
                    $dom = $this->repairVariables($variableList, $loadContent);
                    $this->_modifiedHeadersFooters[$footer] = $dom->saveXML();
                    $this->saveToZip($dom, $footer);
                }
            }
        }
    }

    /**
     * Removes a template variable with its container paragraph
     *
     * @access public
     * @param string $variableName
     * @param string $type can be block or inline
     * @param string $target it can be document (default value), header, footer, footnote, endnote, comment
     */
    public function removeTemplateVariable($variableName, $type = 'block', $target = 'document')
    {

        if ($type == 'inline') {
            $this->replaceVariableByText([$variableName => ''], ['target' => $target]);
        } else {
            if ($target == 'document') {
                $loadContent = $this->_documentXMLElement . '<w:body>' .
                    $this->_wordDocumentC . '</w:body></w:document>';
                $stringDoc = $this->removeVariableBlock($variableName, $loadContent);
                $bodyTag = explode('<w:body>', $stringDoc);
                $this->_wordDocumentC = str_replace('</w:body></w:document>', '', $bodyTag[1]);
            } else if ($target == 'footnote') {
                $dom = $this->removeVariableBlock($variableName, $this->_wordFootnotesT->saveXML());
                $this->_wordFootnotesT->loadXML($dom);
            } else if ($target == 'endnote') {
                $dom = $this->removeVariableBlock($variableName, $this->_wordEndnotesT->saveXML());
                $this->_wordEndnotesT->loadXML($dom);
            } else if ($target == 'comment') {
                $dom = $this->removeVariableBlock($variableName, $this->_wordCommentsT->saveXML());
                $this->_wordCommentsT->loadXML($dom);
            } else if ($target == 'header') {
                $xpathHeaders = simplexml_import_dom($this->_contentTypeT);
                $xpathHeaders->registerXPathNamespace('ns', 'http://schemas.openxmlformats.org/package/2006/content-types');
                $xpathHeadersResults = $xpathHeaders->xpath('ns:Override[@ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.header+xml"]');
                foreach ($xpathHeadersResults as $headersResults) {
                    $header = substr($headersResults['PartName'], 1);
                    $loadContent = $this->getFromZip($header);
                    if (empty($loadContent)) {
                        $loadContent = $this->_modifiedHeadersFooters[$header];
                    }
                    $dom = $this->removeVariableBlock($variableName, $loadContent);
                    if (is_string($dom)) {
                        $this->_modifiedHeadersFooters[$header] = $dom;
                    } else {
                        $this->_modifiedHeadersFooters[$header] = $dom->saveXML();
                    }
                    $this->saveToZip($dom, $header);
                }
            } else if ($target == 'footer') {
                $xpathFooters = simplexml_import_dom($this->_contentTypeT);
                $xpathFooters->registerXPathNamespace('ns', 'http://schemas.openxmlformats.org/package/2006/content-types');
                $xpathFootersResults = $xpathFooters->xpath('ns:Override[@ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.footer+xml"]');
                foreach ($xpathFootersResults as $footersResults) {
                    $footer = substr($footersResults['PartName'], 1);
                    $loadContent = $this->getFromZip($footer);
                    if (empty($loadContent)) {
                        $loadContent = $this->_modifiedHeadersFooters[$footer];
                    }
                    $dom = $this->removeVariableBlock($variableName, $loadContent);
                    if (is_string($dom)){
                        $this->_modifiedHeadersFooters[$footer] = $dom;
                    } else {
                        $this->_modifiedHeadersFooters[$footer] = $dom->saveXML();
                    }
                    $this->saveToZip($dom, $footer);
                }
            }
        }
    }

    /**
     * Replaces a single variable within a list by a list of items
     *
     * @access public
     * @param string $variable
     * @param array $listValues
     * @param string $options
     * 'firstMatch (boolean) if true it only replaces the first variable match. Default is set to false.
     * 'parseLineBreaks' (boolean) if true (default is false) parses the line breaks to include them in the Word document
     * @return void
     */
    public function replaceListVariable($variable, $listValues, $options = [])
    {
        if (isset($options['firstMatch'])) {
            $firstMatch = $options['firstMatch'];
        } else {
            $firstMatch = false;
        }
        $loadContent = $this->_documentXMLElement . '<w:body>' .
            $this->_wordDocumentC . '</w:body></w:document>';
        if (!self::$_preprocessed) {
            $loadContent = $this->repairVariables([$variable => ''], $loadContent);
        }
        $dom = simplexml_load_string($loadContent);
        $dom->registerXPathNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $search = self::$_templateSymbol . $variable . self::$_templateSymbol;
        $query = '//w:p[w:r/w:t[text()[contains(., "' . $search . '")]]]';
        if ($firstMatch) {
            $query = '(' . $query . ')[1]';
        }
        $foundNodes = $dom->xpath($query);
        foreach ($foundNodes as $node) {
            $domNode = dom_import_simplexml($node);
            foreach ($listValues as $key => $value) {
                $newNode = $domNode->cloneNode(true);
                $textNodes = $newNode->getElementsBytagName('t');
                foreach ($textNodes as $text) {
                    $sxText = simplexml_import_dom($text);
                    $strNode = (string) $sxText;
                    if ($options['parseLineBreaks']) {
                        //parse $val for \n\r, \r\n, \n or \r
                        $value = str_replace(['\n\r', '\r\n', '\n', '\r'], '__LINEBREAK__', $value);
                    }
                    $strNodeReplaced = str_replace($search, $value, $strNode);
                    $sxText[0] = $strNodeReplaced;
                }
                $domNode->parentNode->insertBefore($newNode, $domNode);
            }
            $domNode->parentNode->removeChild($domNode);
        }
        $stringDoc = $dom->asXML();
        $bodyTag = explode('<w:body>', $stringDoc);
        $this->_wordDocumentC = str_replace('</w:body></w:document>', '', $bodyTag[1]);
        $this->_wordDocumentC = str_replace('__LINEBREAK__', '</w:t><w:br/><w:t>', $this->_wordDocumentC);
    }

    /**
     * Replaces a placeholder image by an external image
     *
     * @access public
     * @param string $variable this variable uniquely identifies the image we want to replace
     * @param string $src path to the substitution image
     * @param string $options
     * 'firstMatch (boolean) if true it only replaces the first variable match. Default is set to false.
     * 'target': document, header, footer, footnote, endnote, comment
     * 'width' (mixed): the value in cm (float) or 'auto' (use image size)
     * 'height' (mixed): the value in cm (float) or 'auto' (use image size)
     * 'dpi' (int): dots per inch. This parameter is only taken into account if width or height are set to auto.
     * If any of these formatting parameters is not set, the width and/or height of the placeholder image will be preserved
     * @return void
     */
    public function replacePlaceholderImage($variable, $src, $options = [])
    {
        if (!file_exists($src)) {
            //PhpdocxLogger::logger('The' . $src . ' path seems not to be correct. Unable to obtain image file.', 'fatal');
        }
        if (isset($options['target'])) {
            $target = $options['target'];
        } else {
            $target = 'document';
        }

        if ($target == 'document') {
            $loadContent = $this->_documentXMLElement . '<w:body>' .
                $this->_wordDocumentC . '</w:body></w:document>';
            $stringDoc = $this->Image4Image($variable, $src, $options, $loadContent)->saveXML();
            $bodyTag = explode('<w:body>', $stringDoc);
            $this->_wordDocumentC = str_replace('</w:body></w:document>', '', $bodyTag[1]);
        } else if ($target == 'footnote') {
            $dom = $this->Image4Image($variable, $src, $options, $this->_wordFootnotesT->saveXML(), $target)->saveXML();
            $this->_wordFootnotesT->loadXML($dom);
        } else if ($target == 'endnote') {
            $dom = $this->Image4Image($variable, $src, $options, $this->_wordEndnotesT->saveXML(), $target)->saveXML();
            $this->_wordEndnotesT->loadXML($dom);
        } else if ($target == 'comment') {
            $dom = $this->Image4Image($variable, $src, $options, $this->_wordCommentsT->saveXML(), $target)->saveXML();
            $this->_wordCommentsT->loadXML($dom);
        } else if ($target == 'header') {
            $xpathHeaders = simplexml_import_dom($this->_contentTypeT);
            $xpathHeaders->registerXPathNamespace('ns', 'http://schemas.openxmlformats.org/package/2006/content-types');
            $xpathHeadersResults = $xpathHeaders->xpath('ns:Override[@ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.header+xml"]');
            foreach ($xpathHeadersResults as $headersResults) {
                $header = substr($headersResults['PartName'], 1);
                $rels = substr($header, 5);
                $rels = substr($rels, 0, -4);
                $loadContent = $this->getFromZip($header);
                if (empty($loadContent)) {
                    $loadContent = $this->_modifiedHeadersFooters[$header];
                }
                $dom = $this->Image4Image($variable, $src, $options, $loadContent, $rels);
                $this->_modifiedHeadersFooters[$header] = $dom->saveXML();
                $this->saveToZip($dom, $header);
            }
        } else if ($target == 'footer') {
            $xpathFooters = simplexml_import_dom($this->_contentTypeT);
            $xpathFooters->registerXPathNamespace('ns', 'http://schemas.openxmlformats.org/package/2006/content-types');
            $xpathFootersResults = $xpathFooters->xpath('ns:Override[@ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.footer+xml"]');
            foreach ($xpathFootersResults as $footersResults) {
                $footer = substr($footersResults['PartName'], 1);
                $rels = substr($footer, 5);
                $rels = substr($rels, 0, -4);
                $loadContent = $this->getFromZip($footer);
                if (empty($loadContent)) {
                    $loadContent = $this->_modifiedHeadersFooters[$footer];
                }
                $dom = $this->Image4Image($variable, $src, $options, $loadContent, $rels);
                $this->_modifiedHeadersFooters[$footer] = $dom->saveXML();
                $this->saveToZip($dom, $footer);
            }
        }
    }

    /**
     * Do the actual substitution of the variables in a 'table set of rows'
     *
     * @access public
     * @param array $vars
     * @param string $options
     * 'firstMatch (boolean) if true it only replaces the first variable match. Default is set to false.
     * 'parseLineBreaks' (boolean) if true (default is false) parses the line breaks to include them in the Word document
     * @return void
     */
    public function replaceTableVariable($vars, $options = [])
    {
        if (isset($options['firstMatch'])) {
            $firstMatch = $options['firstMatch'];
        } else {
            $firstMatch = false;
        }
        $varKeys = array_keys($vars[0]);
        //We build an array to clean the table variables
        $toRepair = [];
        foreach ($varKeys as $key => $value) {
            $toRepair[$value] = '';
        }
        $loadContent = $this->_documentXMLElement . '<w:body>' .
            $this->_wordDocumentC . '</w:body></w:document>';
        if (!self::$_preprocessed) {
            $loadContent = $this->repairVariables($toRepair, $loadContent);
        }
        $dom = simplexml_load_string($loadContent);
        $dom->registerXPathNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $search = [];
        for ($j = 0; $j < count($varKeys); $j++) {
            $search[$j] = self::$_templateSymbol . $varKeys[$j] . self::$_templateSymbol;
        }
        $queryArray = [];
        for ($j = 0; $j < count($search); $j++) {
            $queryArray[$j] = '//w:tr[w:tc/w:p/w:r/w:t[text()[contains(., "' . $search[$j] . '")]]]';
        }
        $query = join(' | ', $queryArray);
        $foundNodes = $dom->xpath($query);
        $tableCounter = 0;
        foreach ($vars as $key => $rowValue) {
            foreach ($foundNodes as $node) {
                $domNode = dom_import_simplexml($node);
                if (!is_object($referenceNode) || !$domNode->parentNode->isSameNode($parentNode)) {
                    $referenceNode = $domNode;
                    $parentNode = $domNode->parentNode;
                    $tableCounter++;
                }
                if (!$firstMatch || ($firstMatch && $tableCounter < 2)) {
                    $newNode = $domNode->cloneNode(true);
                    $textNodes = $newNode->getElementsBytagName('t');
                    foreach ($textNodes as $text) {
                        for ($k = 0; $k < count($search); $k++) {
                            $sxText = simplexml_import_dom($text);
                            $strNode = (string) $sxText;
                            if (!empty($rowValue[$varKeys[$k]]) ||
                                $rowValue[$varKeys[$k]] === 0 ||
                                $rowValue[$varKeys[$k]] === "0") {
                                if ($options['parseLineBreaks']) {
                                    //parse $val for \n\r, \r\n, \n or \r
                                    $rowValue[$varKeys[$k]] = str_replace(['\n\r', '\r\n', '\n', '\r'], '__LINEBREAK__', $rowValue[$varKeys[$k]]);
                                }
                                $strNode = str_replace($search[$k], $rowValue[$varKeys[$k]], $strNode);
                            } else {
                                $strNode = str_replace($search[$k], '', $strNode);
                            }
                            $sxText[0] = $strNode;
                        }
                    }
                    $parentNode->insertBefore($newNode, $referenceNode);
                }
            }
        }
        //Remove the original nodes
        $tableCounter2 = 0;
        foreach ($foundNodes as $node) {
            $domNode = dom_import_simplexml($node);
            if ($firstMatch && !$domNode->parentNode->isSameNode($parentNode)) {
                $parentNode = $domNode->parentNode;
                $tableCounter2++; //Esto está mal!!!!
            }
            if ($tableCounter2 < 2) {
                $domNode->parentNode->removeChild($domNode);
            }
        }

        $stringDoc = $dom->asXML();
        $bodyTag = explode('<w:body>', $stringDoc);
        $this->_wordDocumentC = str_replace('</w:body></w:document>', '', $bodyTag[1]);
        $this->_wordDocumentC = str_replace('__LINEBREAK__', '</w:t><w:br/><w:t>', $this->_wordDocumentC);
    }

    /**
     * Replaces an array of variables by external files
     *
     * @access public
     * @param array $variables
     *  keys: variable names
     *  values: path to the external DOCX, RTF, HTML or MHT file
     * @param array $options
     * 'firstMatch (boolean) if true it only replaces the first variable match. Default is set to false.
     * 'matchSource' (boolean) if true (default value)tries to preserve as much as posible the styles of the docx to be included
     * 'preprocess' (boolean) if true does some preprocessing on the docx file to add
     *  WARNING: beware that the docx to insert gets modified so please make a safeguard copy first
     * @return void
     */
    public function replaceVariableByExternalFile($variables, $options = [])
    {
        foreach ($variables as $key => $value) {
            $options['src'] = $value;
            $extension = strtoupper($this->getFileExtension($value));
            switch ($extension) {
                case 'DOCX':
                    if (!isset($options['matchSource'])) {
                        $options['matchSource'] = true;
                    }
                    $file = new WordFragment($this);
                    $file->addDOCX($options);
                    $this->replaceVariableByWordFragment([$key => $file], $options);
                    break;
                case 'HTML':
                    $options['html'] = file_get_contents($value);
                    $file = new WordFragment($this);
                    $file->addHTML($options);
                    $this->replaceVariableByWordFragment([$key => $file], $options);
                    break;
                case 'RTF':
                    $file = new WordFragment($this);
                    $file->addRTF($options);
                    $this->replaceVariableByWordFragment([$key => $file], $options);
                    break;
                case 'MHT':
                    $file = new WordFragment($this);
                    $file->addMHT($options);
                    $this->replaceVariableByWordFragment([$key => $file], $options);
                    break;
                default:
                    //PhpdocxLogger::logger('Invalid file extension', 'fatal');
            }
        }
    }

    /**
     * Replace a template variable with WordML obtained from HTML via the
     * embedHTML method.
     *
     * @access public
     * @param string $var Value of the variable.
     * @param type inline or block
     * @param string $html HTML source
     * @param array $options:
     * isFile (boolean),
     * customListStyles (bool) if true try to use the predefined customm lists
     * baseURL (string),
     * downloadImages (boolean),
     * filter (string) could be an string denoting the id, class or tag to be filtered.
     * If you want only a class introduce .classname, #idName for an id or <htmlTag> for a particular tag. One can also use
     * standard XPath expresions supported by PHP.
     * 'firstMatch (boolean) if true it only replaces the first variable match. Default is set to false.
     * 'parseAnchors' (boolean),
     * 'parseDivs' (paragraph, table): parses divs as paragraphs or tables,
     * 'parseFloats' (boolean),
     * 'strictWordStyles' (boolean) if true ignores all CSS styles and uses the styles set via the wordStyles option (see next)
     * 'wordStyles' (array) associates a particular class, id or HTML tag to a Word style
     *
     * @return void
     */
    public function replaceVariableByHTML($var, $type = 'block', $html = '<html><body></body></html>', $options = [])
    {
        if (isset($options['target'])) {
            $target = $options['target'];
        } else {
            $target = 'document';
        }
        if (isset($options['firstMatch'])) {
            $firstMatch = $options['firstMatch'];
        } else {
            $firstMatch = false;
        }
        $options['type'] = $type;
        $htmlFragment = new WordFragment($this, $target);
        $htmlFragment->embedHTML($html, $options);
        $this->replaceVariableByWordFragment([$var => $htmlFragment], $options);
    }

    /**
     * Replaces an array of variables by their values
     *
     * @access public
     * @param array $variables
     *  keys: variable names
     *  values: text we want to insert
     * @param string $options
     * 'target': document (default), header, footer, footnote, endnote, comment
     * 'firstMatch (boolean) if true it only replaces the first variable match. Default is set to false.
     * 'parseLineBreaks' (boolean) if true (default is false) parses the line breaks to include them in the Word document
     * @return void
     */
    public function replaceVariableByText($variables, $options = [])
    {
        if (isset($options['target'])) {
            $target = $options['target'];
        } else {
            $target = 'document';
        }

        if ($target == 'document') {
            $loadContent = $this->_documentXMLElement . '<w:body>' .
                $this->_wordDocumentC . '</w:body></w:document>';
            $dom = $this->variable2Text($variables, $loadContent, $options);
            $stringDoc = $dom->asXML();
            $bodyTag = explode('<w:body>', $stringDoc);
            $this->_wordDocumentC = str_replace('</w:body></w:document>', '', $bodyTag[1]);
        } else if ($target == 'footnote') {
            $dom = $this->variable2Text($variables, $this->_wordFootnotesT->saveXML(), $options)->saveXML();
            $this->_wordFootnotesT->loadXML($dom);
        } else if ($target == 'endnote') {
            $dom = $this->variable2Text($variables, $this->_wordEndnotesT->saveXML(), $options)->saveXML();
            $this->_wordEndnotesT->loadXML($dom);
        } else if ($target == 'comment') {
            $dom = $this->variable2Text($variables, $this->_wordCommentsT->saveXML(), $options)->saveXML();
            $this->_wordCommentsT->loadXML($dom);
        } else if ($target == 'header') {
            $xpathHeaders = simplexml_import_dom($this->_contentTypeT);
            $xpathHeaders->registerXPathNamespace('ns', 'http://schemas.openxmlformats.org/package/2006/content-types');
            $xpathHeadersResults = $xpathHeaders->xpath('ns:Override[@ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.header+xml"]');
            foreach ($xpathHeadersResults as $headersResults) {
                $header = substr($headersResults['PartName'], 1);
                $loadContent = $this->getFromZip($header);
                if (empty($loadContent)) {
                    $loadContent = $this->_modifiedHeadersFooters[$header];
                }
                $dom = $this->variable2Text($variables, $loadContent, $options);
                $this->_modifiedHeadersFooters[$header] = $dom->saveXML();
                $this->saveToZip($dom, $header);
            }
        } else if ($target == 'footer') {
            $xpathFooters = simplexml_import_dom($this->_contentTypeT);
            $xpathFooters->registerXPathNamespace('ns', 'http://schemas.openxmlformats.org/package/2006/content-types');
            $xpathFootersResults = $xpathFooters->xpath('ns:Override[@ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.footer+xml"]');
            foreach ($xpathFootersResults as $footersResults) {
                $footer = substr($footersResults['PartName'], 1);
                $loadContent = $this->getFromZip($footer);
                if (empty($loadContent)) {
                    $loadContent = $this->_modifiedHeadersFooters[$footer];
                }
                $dom = $this->variable2Text($variables, $loadContent, $options);
                $this->_modifiedHeadersFooters[$footer] = $dom->saveXML();
                $this->saveToZip($dom, $footer);
            }
        }
    }

    /**
     * Replaces an array of variables by Word Fragments
     *
     * @access public
     * @param array $variables
     *  keys: variable names
     *  values: instances of the WordFragment or DOCXPath result objects
     * @param string $options
     * 'firstMatch (boolean) if true it only replaces the first variable match. Default is set to false.
     * 'type': inline (only replaces the variable) or block (removes the variable and its containing paragraph)
     * 'target': document (default), footnote, endnote or comment. By the time being header, footer,  are not supported
     * @return void
     */
    public function replaceVariableByWordFragment($variables, $options = [])
    {
        if (isset($options['firstMatch'])) {
            $firstMatch = $options['firstMatch'];
        } else {
            $firstMatch = false;
        }
        if (isset($options['target'])) {
            $target = $options['target'];
        } else {
            $target = 'document';
        }
        if (isset($options['type'])) {
            $type = $options['type'];
        } else {
            $type = 'block';
        }
        if ($target == 'document') {
            $loadContent = $this->_documentXMLElement . '<w:body>' .
                $this->_wordDocumentC . '</w:body></w:document>';
            $stringDoc = $this->variable4WordFragment($variables, $type, $loadContent);
            $bodyTag = explode('<w:body>', $stringDoc);
            $this->_wordDocumentC = str_replace('</w:body></w:document>', '', $bodyTag[1]);
        } else if ($target == 'footnote') {
            $stringDoc = $this->variable4WordFragment($variables, $type, $this->_wordFootnotesT->saveXML());
            $this->_wordFootnotesT->loadXML($stringDoc);
        } else if ($target == 'endnote') {
            $stringDoc = $this->variable4WordFragment($variables, $type, $this->_wordEndnotesT->saveXML());
            $this->_wordEndnotesT->loadXML($stringDoc);
        } else if ($target == 'comment') {
            $stringDoc = $this->variable4WordFragment($variables, $type, $this->_wordCommentsT->saveXML());
            $this->_wordCommentsT->loadXML($stringDoc);
        }
    }

    /**
     * Replaces an array of variables by plain WordML
     * WARNING: the system does not validate the WordML against any scheme so
     * you have to make sure by your own that the used WORDML is correctly encoded
     * and moreover has NO relationships that require to modify the rels files.
     *
     * @access public
     * @param array $variables
     *  keys: variable names
     *  values: WordML code
     * @param string $options
     * 'firstMatch (boolean) if true it only replaces the first variable match. Default is set to false.
     * 'type': inline (only replaces the variable) or block (removes the variable and its containing paragraph)
     * 'target': document (default). By the time being header, footer, footnote, endnote, comment are not supported
     * @return void
     */
    public function replaceVariableByWordML($variables, $options = ['type' => 'block'])
    {
        $counter = 0;
        foreach ($variables as $key => $value) {
            ${'wf_' . $counter} = new WordFragment();
            ${'wf_' . $counter}->addRawWordML($value);
            $variables[$key] = ${'wf_' . $counter};
            $counter++;
        }
        $this->replaceVariableByWordFragment($variables, $options);
    }

    /**
     * Checks or unchecks template checkboxes
     *
     * @access public
     * @param array $variables
     *  keys: variable names
     *  values: 1 (check), 0 (uncheck)
     */
    public function tickCheckboxes($variables)
    {
        $loadContent = $this->_documentXMLElement . '<w:body>' .
            $this->_wordDocumentC . '</w:body></w:document>';
        $domDocument = new DOMDocument();
        $domDocument->loadXML($loadContent);
        $docXPath = new DOMXPath($domDocument);
        $docXPath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $docXPath->registerNamespace('w14', 'http://schemas.microsoft.com/office/word/2010/wordml');
        foreach ($variables as $var => $value) {
            if (empty($value)) {
                $value = 0;
            } else {
                $value = 1;
            }
            //First we check for legacy checkboxes
            $searchTerm = self::$_templateSymbol . $var . self::$_templateSymbol;
            $queryDoc = '//w:ffData[w:statusText[@w:val="' . $searchTerm . '"]]';
            $affectedNodes = $docXPath->query($queryDoc);
            foreach ($affectedNodes as $node) {
                $nodeVals = $node->getElementsByTagNameNS('http://schemas.openxmlformats.org/wordprocessingml/2006/main', 'default');
                $nodeVals->item(0)->setAttribute('w:val', $value);
            }
            //Now we look for Word 2010 sdt checkboxes
            $queryDoc = '//w:sdtPr[w:tag[@w:val="' . $searchTerm . '"]]';
            $affectedNodes = $docXPath->query($queryDoc);
            foreach ($affectedNodes as $node) {
                $nodeVals = $node->getElementsByTagNameNS('http://schemas.microsoft.com/office/word/2010/wordml', 'checked');
                $nodeVals->item(0)->setAttribute('w14:val', $value);
                //Now change the selected symbol for checked or unchecked
                $sdt = $node->parentNode;
                $txt = $sdt->getElementsByTagNameNS('http://schemas.openxmlformats.org/wordprocessingml/2006/main', 't');
                if ($value == 1) {
                    $txt->item(0)->nodeValue = '☒';
                } else {
                    $txt->item(0)->nodeValue = '☐';
                }
            }
        }

        $stringDoc = $domDocument->saveXML();
        $bodyTag = explode('<w:body>', $stringDoc);
        $this->_wordDocumentC = str_replace('</w:body></w:document>', '', $bodyTag[1]);
    }

    /**
     * Extract the PHPDocX type variables from an existing template
     *
     * @access private
     */
    private function extractVariables($target, $documentSymbol, $variables)
    {
        $i = 0;
        foreach ($documentSymbol as $documentSymbolValue) {
            // avoid first and last values and even positions
            if ($i == 0 || $i == count($documentSymbol) || $i % 2 == 0) {
                $i++;
                continue;
            } else {
                $i++;
                if (empty($prefixes)) {
                    $variables[$target][] = strip_tags($documentSymbolValue);
                } else {
                    foreach ($prefixes as $value) {
                        if (($pos = strpos($documentSymbolValue, $value, 0)) !== false) {
                            $variables[$target][] = strip_tags($documentSymbolValue);
                        }
                    }
                }
            }
        }
        return $variables;
    }


    /**
     * Gets jpg image dpi
     *
     * @access private
     * @param string $filename
     * @return array
     */
    private function getDpiJpg($filename)
    {
        $a = fopen($filename, 'r');
        $string = fread($a, 20);
        fclose($a);
        $type = hexdec(bin2hex(substr($string, 13, 1)));
        $data = bin2hex(substr($string, 14, 4));
        if ($type == 1) {
            $x = substr($data, 0, 4);
            $y = substr($data, 4, 4);
            return [hexdec($x), hexdec($y)];
        } else if ($type == 2) {
            $x = floor(hexdec(substr($data, 0, 4)) / 2.54);
            $y = floor(hexdec(substr($data, 4, 4)) / 2.54);
            return [$x, $y];
        } else {
            return [96, 96];
        }
    }

    /**
     * Gets png image dpi
     *
     * @access private
     * @param string $filename
     * @return array
     */
    private function getDpiPng($filename)
    {
        $pngScaleFactor = 29.5;
        $a = fopen($filename, 'r');
        $string = fread($a, 1000);
        $aux = strpos($string, 'pHYs');
        if ($aux > 0) {
            $type = hexdec(bin2hex(substr($string, $aux + strlen('pHYs') + 16, 1)));
        }
        if ($aux > 0 && $type = 1) {
            $data = bin2hex(substr($string, $aux + strlen('pHYs'), 16));
            fclose($a);
            $x = substr($data, 0, 8);
            $y = substr($data, 8, 8);
            return [round(hexdec($x) / $pngScaleFactor), round(hexdec($y) / $pngScaleFactor)];
        } else {
            return [96, 96];
        }
    }

    /**
     * Gets the file extension
     *
     * @access private
     * @param string $filename
     * @return string
     */
    private function getFileExtension($filename)
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        return $extension;
    }

    /**
     * Replaces a placeholder images by external images
     *
     * @access public
     * @param string $variable this variable uniquely identifies the image we want to replace
     * @param string $src path to the substitution image
     * @param string $options
     * 'target': document, header, footer, footnote, endnote, comment
     * 'width' (mixed): the value in cm (float) or 'auto' (use image size)
     * 'height' (mixed): the value in cm (float) or 'auto' (use image size)
     * 'dpi' (int): dots per inch. This parameter is only taken into account if width or height are set to auto.
     * If any of these formatting parameters is not set, the width and/or height of the placeholder image will be preserved
     * @param (string) $loadContent st
     * @param (string) $rels
     * @return DOMDocument Object
     */
    private function Image4Image($variable, $src, $options = [], $loadContent, $rels = 'document')
    {
        if (isset($options['firstMatch'])) {
            $firstMatch = $options['firstMatch'];
        } else {
            $firstMatch = false;
        }

        $cx = 0;
        $cy = 0;
        //Get the name and extension of the replacement image
        $imageNameArray = explode('/', $src);
        if (count($imageNameArray) > 1) {
            $imageName = array_pop($imageNameArray);
        } else {
            $imageName = $src;
        }
        $imageExtensionArray = explode('.', $src);
        $extension = strtolower(array_pop($imageExtensionArray));

        $wordScaleFactor = 360000;
        if (isset($options['dpi'])) {
            $dpiX = $options['dpi'];
            $dpiY = $options['dpi'];
        } else {
            if ((isset($options['width']) && $options['width'] == 'auto') ||
                (isset($options['height']) && $options['height'] == 'auto')) {
                if ($extension == 'jpg' || $extension == 'jpeg') {
                    list($dpiX, $dpiY) = $this->getDpiJpg($src);
                } else if ($extension == 'png') {
                    list($dpiX, $dpiY) = $this->getDpiPng($src);
                } else {
                    $dpiX = 96;
                    $dpiY = 96;
                }
            }
        }

        //Check if a width and height have been set
        $width = 0;
        $height = 0;
        if (isset($options['width']) && $options['width'] != 'auto') {
            $cx = (int) round($options['width'] * $wordScaleFactor);
        }
        if (isset($options['height']) && $options['height'] != 'auto') {
            $cy = (int) round($options['height'] * $wordScaleFactor);
        }
        //Proceed to compute the sizes if the width or height are set to auto
        if ((isset($options['width']) && $options['width'] == 'auto') ||
            (isset($options['height']) && $options['height'] == 'auto')) {
            $realSize = getimagesize($src);
        }
        if (isset($options['width']) && $options['width'] == 'auto') {
            $cx = (int) round($realSize[0] * 2.54 / $dpiX * $wordScaleFactor);
        }
        if (isset($options['height']) && $options['height'] == 'auto') {
            $cy = (int) round($realSize[1] * 2.54 / $dpiY * $wordScaleFactor);
        }
        $docDOM = new DOMDocument();
        $docDOM->loadXML($loadContent);
        $domImages = $docDOM->getElementsByTagNameNS('http://schemas.openxmlformats.org/drawingml/2006/' .
            'wordprocessingDrawing', 'docPr');

        $imageCounter = 0;
        //create a new Id
        $id = uniqid(rand(99,9999999), true);
        $ind = 'rId' . $id;
        $relsCounter = 0;
        for ($i = 0; $i < $domImages->length; $i++) {
            if ($domImages->item($i)->getAttribute('descr') ==
                self::$_templateSymbol . $variable . self::$_templateSymbol &&
                $imageCounter == 0) {

                //generate new relationship
                $relString = '<Relationship Id="' . $ind . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="media/img' . $id . '.' . $extension . '" />';
                if ($rels == 'document') {
                    if ($relsCounter == 0) {
                        $this->generateRELATIONSHIP($ind, 'image', 'media/img' . $id . '.' . $extension);
                        $relsCounter++;
                    }
                } else if ($rels == 'footnote' || $rels == 'endnote' || $rels == 'comment') {
                    self::$_relsNotesImage[$rels][] = ['rId' => 'rId' . $id, 'name' => $id, 'extension' => $extension];
                } else {
                    $relsXML = $this->getFromZip('word/_rels/' . $rels . '.xml.rels');
                    if (empty($relsXML)){
                        $relsXML = $this->_modifiedRels['word/_rels/' . $rels . '.xml.rels'];
                    }
                    $relationship = '<Relationship Target="media/img' . $id . '.' . $extension . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Id="rId' . $id . '"/>';
                    $relsXML = str_replace('</Relationships>', $relationship . '</Relationships>', $relsXML);
                    $this->_modifiedRels['word/_rels/' . $rels . '.xml.rels'] = $relsXML;
                    $this->saveToZip($relsXML, 'word/_rels/' . $rels . '.xml.rels');
                }
                //generate content type if it does not exist yet
                $this->generateDEFAULT($extension, 'image/' . $extension);
                //modify the image data to modify the r:embed attribute
                $domImages->item($i)->parentNode
                    ->getElementsByTagNameNS('http://schemas.openxmlformats.org/drawingml/2006/main', 'blip')
                    ->item(0)->setAttribute('r:embed', $ind);
                if ($cx != 0) {
                    $domImages->item($i)->parentNode
                        ->getElementsByTagNameNS('http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing', 'extent')
                        ->item(0)->setAttribute('cx', $cx);
                    $xfrmNode = $domImages->item($i)->parentNode
                        ->getElementsByTagNameNS('http://schemas.openxmlformats.org/drawingml/2006/main', 'xfrm')->item(0);
                    $xfrmNode->getElementsByTagNameNS('http://schemas.openxmlformats.org/drawingml/2006/main', 'ext')
                        ->item(0)->setAttribute('cx', $cx);
                }
                if ($cy != 0) {
                    $domImages->item($i)->parentNode
                        ->getElementsByTagNameNS('http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing', 'extent')
                        ->item(0)->setAttribute('cy', $cy);
                    $xfrmNode = $domImages->item($i)->parentNode
                        ->getElementsByTagNameNS('http://schemas.openxmlformats.org/drawingml/2006/main', 'xfrm')->item(0);
                    $xfrmNode->getElementsByTagNameNS('http://schemas.openxmlformats.org/drawingml/2006/main', 'ext')
                        ->item(0)->setAttribute('cy', $cy);
                }
                if ($options['firstMatch']) {
                    $imageCounter++;
                    $domImages->item($i)->setAttribute('descr', '');
                }
            }
        }
        //We copy the image in the (base) template with the new name
        $this->saveToZip($src, 'word/media/img' . $id . '.' . $extension);

        return $docDOM;
    }

    /**
     * Removes a template variable with its container paragraph
     *
     * @access private
     * @param string $variableName
     * @param string $loadContent
     */
    private function removeVariableBlock($variableName, $loadContent)
    {
        if (!self::$_preprocessed) {
            $loadContent = $this->repairVariables([$variableName => ''], $loadContent);
        }
        $domDocument = new DomDocument();
        $domDocument->loadXML($loadContent);
        //Use XPath to find all paragraphs that include the variable name
        $name = self::$_templateSymbol . $variableName . self::$_templateSymbol;
        $xpath = new DOMXPath($domDocument);
        $xpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $query = '//w:p[w:r/w:t[text()[contains(.,"' . $variableName . '")]]]';
        $affectedNodes = $xpath->query($query);
        foreach ($affectedNodes as $node) {
            $paragraphContents = $node->ownerDocument->saveXML($node);
            $paragraphText = strip_tags($paragraphContents);
            if (($pos = strpos($paragraphText, $name, 0)) !== false) {
                //If we remove a paragraph inside a table cell we need to take special care
                if ($node->parentNode->nodeName == 'w:tc') {
                    $tcChilds = $node->parentNode->getElementsByTagNameNS('http://schemas.openxmlformats.org/wordprocessingml/2006/main', 'p');
                    if ($tcChilds->length > 1) {
                        $node->parentNode->removeChild($node);
                    } else {
                        $emptyP = $domDocument->createElement("w:p");
                        $node->parentNode->appendChild($emptyP);
                        $node->parentNode->removeChild($node);
                    }
                } else {
                    $node->parentNode->removeChild($node);
                }
            }
        }
        $stringDoc = $domDocument->saveXML();
        return $stringDoc;
    }

    /**
     * Prepares a single PHPDocX variable for substitution
     *
     * @access private
     * @param array $variables
     * @param string $content
     * @return string
     */
    private function repairVariables($variables, $content)
    {
        $documentSymbol = explode(self::$_templateSymbol, $content);
        foreach ($variables as $var => $value) {
            foreach ($documentSymbol as $documentSymbolValue) {
                $tempSearch = trim(strip_tags($documentSymbolValue));
                if ($tempSearch == $var) {
                    $pos = strpos($content, $documentSymbolValue);
                    if ($pos !== false) {
                        $content = substr_replace($content, $var, $pos, strlen($documentSymbolValue));
                    }
                }
                if (strpos($documentSymbolValue, 'xml:space="preserve"')) {
                    $preserve = true;
                }
            }
            if (isset($preserve) && $preserve) {
                $query = '//w:t[text()[contains(., "' . self::$_templateSymbol . $var . self::$_templateSymbol . '")]]';
                $docDOM = new DOMDocument();
                $docDOM->loadXML($content);
                $docXPath = new DOMXPath($docDOM);
                $docXPath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
                $affectedNodes = $docXPath->query($query);
                foreach ($affectedNodes as $node) {
                    $space = $node->getAttribute('xml:space');
                    if (isset($space) && $space == 'preserve') {
                        //Do nothing
                    } else {
                        $str = $node->nodeValue;
                        $firstChar = $str[0];
                        if ($firstChar == ' ') {
                            $node->nodeValue = substr($str, 1);
                        }
                        $node->setAttribute('xml:space', 'preserve');
                    }
                }
                $content = $docDOM->saveXML($docDOM->documentElement);
                //$content = html_entity_decode($content, ENT_NOQUOTES, 'UTF-8');
            }
        }
        return $content;
    }

    /**
     * Replaces an array of variables by their values
     *
     * @access public
     * @param array $variables
     *  keys: variable names
     *  values: text we want to insert
     * @param string $loadContent
     * @param array $options
     * @return SimpleXML Object
     */
    private function variable2Text($variables, $loadContent, $options)
    {
        if (isset($options['firstMatch'])) {
            $firstMatch = $options['firstMatch'];
        } else {
            $firstMatch = false;
        }
        if (!self::$_preprocessed) {
            $loadContent = $this->repairVariables($variables, $loadContent);
        }
        $dom = simplexml_load_string($loadContent);
        $dom->registerXPathNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        foreach ($variables as $var => $val) {
            $search = self::$_templateSymbol . $var . self::$_templateSymbol;
            $query = '//w:t[text()[contains(., "' . $search . '")]]';
            if ($firstMatch) {
                $query = '(' . $query . ')[1]';
            }
            $foundNodes = $dom->xpath($query);
            foreach ($foundNodes as $node) {
                $strNode = (string) $node;
                if ($options['parseLineBreaks']) {
                    $domNode = dom_import_simplexml($node);
                    //parse $val for \n\r, \r\n, \n or \r
                    $val = str_replace(['\n\r', '\r\n', '\n', '\r'], '<linebreak/>', $val);
                    $strNode = str_replace($search, $val, $strNode);
                    $runs = explode('<linebreak/>', $strNode);
                    $preserveWS = false;
                    $preserveWhiteSpace = $domNode->getAttribute('xml:space');
                    if ($preserveWhiteSpace == 'preserve') {
                        $preserveWS = true;
                    }
                    //TODO: check and finish
                    $numberOfRuns = count($runs);
                    $counter = 0;
                    foreach ($runs as $run) {
                        $counter++;
                        $newT = $domNode->ownerDocument->createElementNS('http://schemas.openxmlformats.org/wordprocessingml/2006/main', 't', $run);
                        if ($preserveWS) {
                            $newT->setAttribute('xml:space', 'preserve');
                        }
                        $domNode->parentNode->insertBefore($newT, $domNode);
                        if ($counter < $numberOfRuns) {
                            $br = $domNode->ownerDocument->createElementNS('http://schemas.openxmlformats.org/wordprocessingml/2006/main', 'br');
                            $domNode->parentNode->insertBefore($br, $domNode);
                        }
                    }
                    $domNode->parentNode->removeChild($domNode);
                } else {
                    $strNode = str_replace($search, $val, $strNode);
                    $node[0] = $strNode;
                }
            }
        }

        return $dom;
    }

    /**
     * Does the actual parsing of the content for the replacement by a Word Fragment
     *
     * @access private
     * @param array $variables
     * @param string $type
     * @param @param string $loadContent
     */
    private function variable4WordFragment($variables, $type, $loadContent)
    {
        if (!self::$_preprocessed) {
            $loadContent = $this->repairVariables($variables, $loadContent);
        }

        foreach ($variables as $var => $val) {
            $loadContent = $this->singleVariable4WordFragment($var, $val, $type, $loadContent);
        }

        return $loadContent;
    }

    /**
     * Replaces a single variable by a Word fragment Word Fragment
     *
     * @access private
     * @param string $var
     * @param WordFragment $val
     * @param string $type
     * @param string $loadContent
     */
    private function singleVariable4WordFragment($var, $val, $type, $loadContent)
    {
        $docDOM = new DOMDocument();
        $docDOM->loadXML($loadContent);
        $docXpath = new DOMXPath($docDOM);


        if ($val instanceof WordFragment) {
            //PhpdocxLogger::logger('Replacing a variable by a  WordML fragment', 'info');
        } else if ($val instanceof DOCXPathResult) {
            //PhpdocxLogger::logger('Replacing a variable by a  DOCXPath result', 'info');
        } else {
            //PhpdocxLogger::logger('This methods requires that the variable value is a WordML fragment', 'fatal');
        }
        $wordML = (string) $val;
        if ($type == 'inline') {
            $wordML = $this->cleanWordMLBlockElements($wordML);
        }
        $searchString = self::$_templateSymbol;
        $searchVariable = self::$_templateSymbol . $var . self::$_templateSymbol;
        $query = '//w:p[w:r/w:t[text()[contains(., "' . $searchVariable . '")]]]';
        if ($firstMatch) {
            $query = '(' . $query . ')[1]';
        }

        $docNodes = $docXpath->query($query);
        foreach ($docNodes as $node) {
            $nodeText = $node->ownerDocument->saveXML($node);
            $cleanNodeText = strip_tags($nodeText);
            if (strpos($cleanNodeText, $searchVariable) !== false) {
                if ($type == 'block') {
                    $cursorNode = $docDOM->createElement('cursorWordML');
                    //We should take care of the case that is empty and inside a table cell (fix word bug empty cells)
                    if ($wordML == '' && $node->parentNode->nodeName == 'w:tc')
                        $wordML = '<w:p />';
                    $node->parentNode->insertBefore($cursorNode, $node);
                    $node->parentNode->removeChild($node);
                }else if ($type == 'inline') {
                    $textNode = $node->ownerDocument->saveXML($node);
                    $textChunks = explode($searchString, $textNode);
                    $limit = count($textChunks);
                    for ($j = 0; $j < $limit; $j++) {
                        $cleanValue = strip_tags($textChunks[$j]);
                        if ($cleanValue == $var) {
                            $textChunks[$j] = '</w:t></w:r><cursorWordML/><w:r><w:t xml:space="preserve">';
                        }
                    }
                    $newNodeText = implode($searchString, $textChunks);
                    $newNodeText = str_replace(self::$_templateSymbol . '</w:t></w:r><cursorWordML/><w:r><w:t xml:space="preserve">', '</w:t></w:r><cursorWordML/><w:r><w:t xml:space="preserve">', $newNodeText);
                    $newNodeText = str_replace('</w:t></w:r><cursorWordML/><w:r><w:t xml:space="preserve">' . self::$_templateSymbol, '</w:t></w:r><cursorWordML/><w:r><w:t xml:space="preserve">', $newNodeText);
                    $tempDoc = new DOMDocument();
                    $tempDoc->loadXML('<w:root xmlns:wpc="http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas"
                                               xmlns:mo="http://schemas.microsoft.com/office/mac/office/2008/main"
                                               xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006"
                                               xmlns:mv="urn:schemas-microsoft-com:mac:vml"
                                               xmlns:o="urn:schemas-microsoft-com:office:office"
                                               xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"
                                               xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math"
                                               xmlns:v="urn:schemas-microsoft-com:vml"
                                               xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing"
                                               xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing"
                                               xmlns:w10="urn:schemas-microsoft-com:office:word"
                                               xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"
                                               xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml"
                                               xmlns:wpg="http://schemas.microsoft.com/office/word/2010/wordprocessingGroup"
                                               xmlns:wpi="http://schemas.microsoft.com/office/word/2010/wordprocessingInk"
                                               xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml"
                                               xmlns:wps="http://schemas.microsoft.com/office/word/2010/wordprocessingShape"
                                               mc:Ignorable="w14 wp14">' . $newNodeText . '</w:root>');
                    $newCursorNode = $tempDoc->documentElement->firstChild;
                    $cursorNode = $docDOM->importNode($newCursorNode, true);
                    $node->parentNode->insertBefore($cursorNode, $node);
                    $node->parentNode->removeChild($node);
                }
            }
        }

        $stringDoc = $docDOM->saveXML();
        $stringDoc = str_replace('<cursorWordML/>', $wordML, $stringDoc);

        return $stringDoc;
    }

}

class OOXMLResources
{

    /**
     * @access public
     * @var string
     * @static
     */
    public static $commentsXML = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                                    <w:comments xmlns:ve="http://schemas.openxmlformats.org/markup-compatibility/2006"
                                    xmlns:o="urn:schemas-microsoft-com:office:office"
                                    xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"
                                    xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math"
                                    xmlns:v="urn:schemas-microsoft-com:vml"
                                    xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing"
                                    xmlns:w10="urn:schemas-microsoft-com:office:word"
                                    xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"
                                    xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml">
                                    </w:comments>';

    /**
     * @access public
     * @var string
     * @static
     */
    public static $customProperties = '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>
                                        <Properties xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes"
                                        xmlns="http://schemas.openxmlformats.org/officeDocument/2006/custom-properties">
                                        </Properties>';

    /**
     * @access public
     * @var string
     * @static
     */
    public static $defaultPHPDOCXStyles = ['Default Paragraph Font PHPDOCX', //This is the default paragraph font style used in multiple places
        'List Paragraph PHPDOCX', //This is the style used for the defolt ordered and unorderd lists
        'Title PHPDOCX', //This style is used by the addTitle method
        'Subtitle PHPDOCX', //This style is used by the addTitle method
        'Normal Table PHPDOCX', //This style is used for the basic table
        'Table Grid PHPDOCX', //This style is for basic tables and is also used to embed HTML tables with border="1"
        'footnote Text PHPDOCX', //This style is used for default footnotes
        'footnote text Car PHPDOCX', //The character style for footnotes
        'footnote Reference PHPDOCX', // The style for the footnote
        'endnote Text PHPDOCX', //This style is used for default endnotes
        'endnote text Car PHPDOCX', //The character style for endnotes
        'endnote Reference PHPDOCX', // The style for the endnote
        'annotation reference PHPDOCX', //styles for comments
        'annotation text PHPDOCX', //styles for comments
        'Comment Text Char PHPDOCX', //styles for comments
        'annotation subject PHPDOCX', //styles for comments
        'Comment Subject Char PHPDOCX', //styles for comments
        'Balloon Text PHPDOCX', //styles for comments
        'Balloon Text Char PHPDOCX']; //styles for comments
    /**
     * @access public
     * @var string
     * @static
     */
    public static $endnotesXML = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                                    <w:endnotes xmlns:ve="http://schemas.openxmlformats.org/markup-compatibility/2006"
                                    xmlns:o="urn:schemas-microsoft-com:office:office"
                                    xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"
                                    xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math"
                                    xmlns:v="urn:schemas-microsoft-com:vml"
                                    xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing"
                                    xmlns:w10="urn:schemas-microsoft-com:office:word"
                                    xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"
                                    xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml">
                                        <w:endnote w:type="separator" w:id="-1">
                                            <w:p w:rsidR="006E0FDA" w:rsidRDefault="006E0FDA" w:rsidP="006E0FDA">
                                                <w:pPr>
                                                    <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                                                </w:pPr>
                                                <w:r>
                                                    <w:separator/>
                                                </w:r>
                                            </w:p>
                                        </w:endnote>
                                        <w:endnote w:type="continuationSeparator" w:id="0">
                                            <w:p w:rsidR="006E0FDA" w:rsidRDefault="006E0FDA" w:rsidP="006E0FDA">
                                                <w:pPr>
                                                    <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                                                </w:pPr>
                                                <w:r>
                                                    <w:continuationSeparator/>
                                                </w:r>
                                            </w:p>
                                        </w:endnote>
                                    </w:endnotes>';

    /**
     * @access public
     * @var string
     * @static
     */
    public static $notesXMLRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                                <Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
                                </Relationships>';

    /**
     * @access public
     * @var string
     * @static
     */
    public static $footnotesXML = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                                    <w:footnotes xmlns:ve="http://schemas.openxmlformats.org/markup-compatibility/2006"
                                    xmlns:o="urn:schemas-microsoft-com:office:office"
                                    xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"
                                    xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math"
                                    xmlns:v="urn:schemas-microsoft-com:vml"
                                    xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing"
                                    xmlns:w10="urn:schemas-microsoft-com:office:word"
                                    xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"
                                    xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml">
                                        <w:footnote w:type="separator" w:id="-1">
                                            <w:p w:rsidR="006E0FDA" w:rsidRDefault="006E0FDA" w:rsidP="006E0FDA">
                                                <w:pPr>
                                                    <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                                                </w:pPr>
                                                <w:r>
                                                    <w:separator/>
                                                </w:r>
                                            </w:p>
                                        </w:footnote>
                                        <w:footnote w:type="continuationSeparator" w:id="0">
                                            <w:p w:rsidR="006E0FDA" w:rsidRDefault="006E0FDA" w:rsidP="006E0FDA">
                                                <w:pPr>
                                                    <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                                                </w:pPr>
                                                <w:r>
                                                    <w:continuationSeparator/>
                                                </w:r>
                                            </w:p>
                                        </w:footnote>
                                    </w:footnotes>';

    /**
     * @access public
     * @var string
     * @static
     */
    public static $notesRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                                <Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
                                </Relationships>';

    /**
     * @access public
     * @var string
     * @static
     */
    public static $PHPDOCXStyles = '<w:styles xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" >
                                        <w:style w:type="character" w:styleId="DefaultParagraphFontPHPDOCX">
                                            <w:name w:val="Default Paragraph Font PHPDOCX"/>
                                            <w:uiPriority w:val="1"/>
                                            <w:semiHidden/>
                                            <w:unhideWhenUsed/>
                                        </w:style>
                                        <w:style w:type="paragraph" w:styleId="ListParagraphPHPDOCX">
                                            <w:name w:val="List Paragraph PHPDOCX"/>
                                            <w:basedOn w:val="Normal"/>
                                            <w:uiPriority w:val="34"/>
                                            <w:qFormat/>
                                            <w:rsid w:val="00DF064E"/>
                                            <w:pPr>
                                                <w:ind w:left="720"/>
                                                <w:contextualSpacing/>
                                            </w:pPr>
                                        </w:style>
                                        <w:style w:type="paragraph" w:styleId="TitlePHPDOCX">
                                            <w:name w:val="Title PHPDOCX"/>
                                            <w:basedOn w:val="Normal"/>
                                            <w:next w:val="Normal"/>
                                            <w:link w:val="TitleCarPHPDOCX"/>
                                            <w:uiPriority w:val="10"/>
                                            <w:qFormat/>
                                            <w:rsid w:val="00DF064E"/>
                                            <w:pPr>
                                                <w:pBdr>
                                                    <w:bottom w:val="single" w:sz="8" w:space="4" w:color="4F81BD" w:themeColor="accent1"/>
                                                </w:pBdr>
                                                <w:spacing w:after="300" w:line="240" w:lineRule="auto"/>
                                                <w:contextualSpacing/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:asciiTheme="majorHAnsi" w:eastAsiaTheme="majorEastAsia" w:hAnsiTheme="majorHAnsi" w:cstheme="majorBidi"/>
                                                <w:color w:val="17365D" w:themeColor="text2" w:themeShade="BF"/>
                                                <w:spacing w:val="5"/>
                                                <w:kern w:val="28"/>
                                                <w:sz w:val="52"/>
                                                <w:szCs w:val="52"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="character" w:customStyle="1" w:styleId="TitleCarPHPDOCX">
                                            <w:name w:val="Title Car PHPDOCX"/>
                                            <w:basedOn w:val="DefaultParagraphFontPHPDOCX"/>
                                            <w:link w:val="TitlePHPDOCX"/>
                                            <w:uiPriority w:val="10"/>
                                            <w:rsid w:val="00DF064E"/>
                                            <w:rPr>
                                                <w:rFonts w:asciiTheme="majorHAnsi" w:eastAsiaTheme="majorEastAsia" w:hAnsiTheme="majorHAnsi" w:cstheme="majorBidi"/>
                                                <w:color w:val="17365D" w:themeColor="text2" w:themeShade="BF"/>
                                                <w:spacing w:val="5"/>
                                                <w:kern w:val="28"/>
                                                <w:sz w:val="52"/>
                                                <w:szCs w:val="52"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="paragraph" w:styleId="SubtitlePHPDOCX">
                                            <w:name w:val="Subtitle PHPDOCX"/>
                                            <w:basedOn w:val="Normal"/>
                                            <w:next w:val="Normal"/>
                                            <w:link w:val="SubtitleCarPHPDOCX"/>
                                            <w:uiPriority w:val="11"/>
                                            <w:qFormat/>
                                            <w:rsid w:val="00DF064E"/>
                                            <w:pPr>
                                                <w:numPr>
                                                    <w:ilvl w:val="1"/>
                                                </w:numPr>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:asciiTheme="majorHAnsi" w:eastAsiaTheme="majorEastAsia" w:hAnsiTheme="majorHAnsi" w:cstheme="majorBidi"/>
                                                <w:i/>
                                                <w:iCs/>
                                                <w:color w:val="4F81BD" w:themeColor="accent1"/>
                                                <w:spacing w:val="15"/>
                                                <w:sz w:val="24"/>
                                                <w:szCs w:val="24"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="character" w:customStyle="1" w:styleId="SubtitleCarPHPDOCX">
                                            <w:name w:val="Subtitle Car PHPDOCX"/>
                                            <w:basedOn w:val="DefaultParagraphFontPHPDOCX"/>
                                            <w:link w:val="SubtitlePHPDOCX"/>
                                            <w:uiPriority w:val="11"/>
                                            <w:rsid w:val="00DF064E"/>
                                            <w:rPr>
                                                <w:rFonts w:asciiTheme="majorHAnsi" w:eastAsiaTheme="majorEastAsia" w:hAnsiTheme="majorHAnsi" w:cstheme="majorBidi"/>
                                                <w:i/>
                                                <w:iCs/>
                                                <w:color w:val="4F81BD" w:themeColor="accent1"/>
                                                <w:spacing w:val="15"/>
                                                <w:sz w:val="24"/>
                                                <w:szCs w:val="24"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="table" w:styleId="NormalTablePHPDOCX">
                                            <w:name w:val="Normal Table PHPDOCX"/>
                                            <w:uiPriority w:val="99"/>
                                            <w:semiHidden/>
                                            <w:unhideWhenUsed/>
                                            <w:qFormat/>
                                            <w:pPr>
                                                <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                                            </w:pPr>
                                            <w:tblPr>
                                                <w:tblInd w:w="0" w:type="dxa"/>
                                                <w:tblCellMar>
                                                    <w:top w:w="0" w:type="dxa"/>
                                                    <w:left w:w="108" w:type="dxa"/>
                                                    <w:bottom w:w="0" w:type="dxa"/>
                                                    <w:right w:w="108" w:type="dxa"/>
                                                </w:tblCellMar>
                                            </w:tblPr>
                                        </w:style>
                                        <w:style w:type="table" w:styleId="TableGridPHPDOCX">
                                            <w:name w:val="Table Grid PHPDOCX"/>
                                            <w:uiPriority w:val="59"/>
                                            <w:rsid w:val="00493A0C"/>
                                            <w:pPr>
                                                <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                                            </w:pPr>
                                            <w:tblPr>
                                                <w:tblInd w:w="0" w:type="dxa"/>
                                                <w:tblBorders>
                                                    <w:top w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                                    <w:left w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                                    <w:bottom w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                                    <w:right w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                                    <w:insideH w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                                    <w:insideV w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                                </w:tblBorders>
                                                <w:tblCellMar>
                                                    <w:top w:w="0" w:type="dxa"/>
                                                    <w:left w:w="108" w:type="dxa"/>
                                                    <w:bottom w:w="0" w:type="dxa"/>
                                                    <w:right w:w="108" w:type="dxa"/>
                                                </w:tblCellMar>
                                            </w:tblPr>
                                        </w:style>
                                        <w:style w:type="character" w:styleId="CommentReferencePHPDOCX">
                                            <w:name w:val="annotation reference PHPDOCX"/>
                                            <w:basedOn w:val="DefaultParagraphFontPHPDOCX"/>
                                            <w:uiPriority w:val="99"/>
                                            <w:semiHidden/>
                                            <w:unhideWhenUsed/>
                                            <w:rsid w:val="00E139EA"/>
                                            <w:rPr>
                                                <w:sz w:val="16"/>
                                                <w:szCs w:val="16"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="paragraph" w:styleId="CommentTextPHPDOCX">
                                            <w:name w:val="annotation text PHPDOCX"/>
                                            <w:basedOn w:val="Normal"/>
                                            <w:link w:val="CommentTextCharPHPDOCX"/>
                                            <w:uiPriority w:val="99"/>
                                            <w:semiHidden/>
                                            <w:unhideWhenUsed/>
                                            <w:rsid w:val="00E139EA"/>
                                            <w:pPr>
                                                <w:spacing w:line="240" w:lineRule="auto"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:sz w:val="20"/>
                                                <w:szCs w:val="20"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="character" w:customStyle="1" w:styleId="CommentTextCharPHPDOCX">
                                            <w:name w:val="Comment Text Char PHPDOCX"/>
                                            <w:basedOn w:val="DefaultParagraphFontPHPDOCX"/>
                                            <w:link w:val="CommentTextPHPDOCX"/>
                                            <w:uiPriority w:val="99"/>
                                            <w:semiHidden/>
                                            <w:rsid w:val="00E139EA"/>
                                            <w:rPr>
                                                <w:sz w:val="20"/>
                                                <w:szCs w:val="20"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="paragraph" w:styleId="CommentSubjectPHPDOCX">
                                            <w:name w:val="annotation subject PHPDOCX"/>
                                            <w:basedOn w:val="CommentTextPHPDOCX"/>
                                            <w:next w:val="CommentTextPHPDOCX"/>
                                            <w:link w:val="CommentSubjectCharPHPDOCX"/>
                                            <w:uiPriority w:val="99"/>
                                            <w:semiHidden/>
                                            <w:unhideWhenUsed/>
                                            <w:rsid w:val="00E139EA"/>
                                            <w:rPr>
                                                <w:b/>
                                                <w:bCs/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="character" w:customStyle="1" w:styleId="CommentSubjectCharPHPDOCX">
                                            <w:name w:val="Comment Subject Char PHPDOCX"/>
                                            <w:basedOn w:val="CommentTextCharPHPDOCX"/>
                                            <w:link w:val="CommentSubjectPHPDOCX"/>
                                            <w:uiPriority w:val="99"/>
                                            <w:semiHidden/>
                                            <w:rsid w:val="00E139EA"/>
                                            <w:rPr>
                                                <w:b/>
                                                <w:bCs/>
                                                <w:sz w:val="20"/>
                                                <w:szCs w:val="20"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="paragraph" w:styleId="BalloonTextPHPDOCX">
                                            <w:name w:val="Balloon Text PHPDOCX"/>
                                            <w:basedOn w:val="Normal"/>
                                            <w:link w:val="BalloonTextCharPHPDOCX"/>
                                            <w:uiPriority w:val="99"/>
                                            <w:semiHidden/>
                                            <w:unhideWhenUsed/>
                                            <w:rsid w:val="00E139EA"/>
                                            <w:pPr>
                                                <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:ascii="Tahoma" w:hAnsi="Tahoma" w:cs="Tahoma"/>
                                                <w:sz w:val="16"/>
                                            <w:szCs w:val="16"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="character" w:customStyle="1" w:styleId="BalloonTextCharPHPDOCX">
                                            <w:name w:val="Balloon Text Char PHPDOCX"/>
                                            <w:basedOn w:val="DefaultParagraphFontPHPDOCX"/>
                                            <w:link w:val="BalloonTextPHPDOCX"/>
                                            <w:uiPriority w:val="99"/>
                                            <w:semiHidden/>
                                            <w:rsid w:val="00E139EA"/>
                                            <w:rPr>
                                                <w:rFonts w:ascii="Tahoma" w:hAnsi="Tahoma" w:cs="Tahoma"/>
                                                <w:sz w:val="16"/>
                                                <w:szCs w:val="16"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="paragraph" w:styleId="footnoteTextPHPDOCX">
                                            <w:name w:val="footnote Text PHPDOCX"/>
                                            <w:basedOn w:val="Normal"/>
                                            <w:link w:val="footnoteTextCarPHPDOCX"/>
                                            <w:uiPriority w:val="99"/>
                                            <w:semiHidden/>
                                            <w:unhideWhenUsed/>
                                            <w:rsid w:val="006E0FDA"/>
                                            <w:pPr>
                                                <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:sz w:val="20"/>
                                                <w:szCs w:val="20"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="character" w:customStyle="1" w:styleId="footnoteTextCarPHPDOCX">
                                            <w:name w:val="footnote Text Car PHPDOCX"/>
                                            <w:basedOn w:val="DefaultParagraphFontPHPDOCX"/>
                                            <w:link w:val="footnoteTextPHPDOCX"/>
                                            <w:uiPriority w:val="99"/>
                                            <w:semiHidden/>
                                            <w:rsid w:val="006E0FDA"/>
                                            <w:rPr>
                                                <w:sz w:val="20"/>
                                                <w:szCs w:val="20"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="character" w:styleId="footnoteReferencePHPDOCX">
                                        <w:name w:val="footnote Reference PHPDOCX"/>
                                        <w:basedOn w:val="DefaultParagraphFontPHPDOCX"/>
                                        <w:uiPriority w:val="99"/>
                                        <w:semiHidden/>
                                        <w:unhideWhenUsed/>
                                        <w:rsid w:val="006E0FDA"/>
                                        <w:rPr>
                                            <w:vertAlign w:val="superscript"/>
                                        </w:rPr>
                                    </w:style>
                                    <w:style w:type="paragraph" w:styleId="endnoteTextPHPDOCX">
                                        <w:name w:val="endnote Text PHPDOCX"/>
                                        <w:basedOn w:val="Normal"/>
                                        <w:link w:val="endnoteTextCarPHPDOCX"/>
                                        <w:uiPriority w:val="99"/>
                                        <w:semiHidden/>
                                        <w:unhideWhenUsed/>
                                        <w:rsid w:val="006E0FDA"/>
                                        <w:pPr>
                                            <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                                        </w:pPr>
                                        <w:rPr>
                                            <w:sz w:val="20"/>
                                            <w:szCs w:val="20"/>
                                        </w:rPr>
                                    </w:style>
                                    <w:style w:type="character" w:customStyle="1" w:styleId="endnoteTextCarPHPDOCX">
                                        <w:name w:val="endnote Text Car PHPDOCX"/>
                                        <w:basedOn w:val="DefaultParagraphFontPHPDOCX"/>
                                        <w:link w:val="endnoteTextPHPDOCX"/>
                                        <w:uiPriority w:val="99"/>
                                        <w:semiHidden/>
                                        <w:rsid w:val="006E0FDA"/>
                                        <w:rPr>
                                            <w:sz w:val="20"/>
                                            <w:szCs w:val="20"/>
                                        </w:rPr>
                                    </w:style>
                                    <w:style w:type="character" w:styleId="endnoteReferencePHPDOCX">
                                        <w:name w:val="endnote Reference PHPDOCX"/>
                                        <w:basedOn w:val="DefaultParagraphFontPHPDOCX"/>
                                        <w:uiPriority w:val="99"/>
                                        <w:semiHidden/>
                                        <w:unhideWhenUsed/>
                                        <w:rsid w:val="006E0FDA"/>
                                        <w:rPr>
                                            <w:vertAlign w:val="superscript"/>
                                        </w:rPr>
                                    </w:style>
                                 </w:styles>';

    /**
     * @access public
     * @var string
     * @static
     */
    public static $unorderedListStyle = '<w:abstractNum w:abstractNumId="" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" >
                                        <w:multiLevelType w:val="hybridMultilevel"/>
                                        <w:lvl w:ilvl="0" w:tplc="">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="bullet"/>
                                            <w:lvlText w:val=""/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="720" w:hanging="360"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:ascii="Symbol" w:hAnsi="Symbol" w:hint="default"/>
                                            </w:rPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="1" w:tplc="0C0A0003" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="bullet"/>
                                            <w:lvlText w:val="o"/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="1440" w:hanging="360"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:ascii="Courier New" w:hAnsi="Courier New" w:cs="Courier New" w:hint="default"/>
                                            </w:rPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="2" w:tplc="0C0A0005" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="bullet"/>
                                            <w:lvlText w:val=""/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="2160" w:hanging="360"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:ascii="Wingdings" w:hAnsi="Wingdings" w:hint="default"/>
                                            </w:rPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="3" w:tplc="0C0A0001" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="bullet"/>
                                            <w:lvlText w:val=""/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="2880" w:hanging="360"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:ascii="Symbol" w:hAnsi="Symbol" w:hint="default"/>
                                            </w:rPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="4" w:tplc="0C0A0003" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="bullet"/>
                                            <w:lvlText w:val="o"/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="3600" w:hanging="360"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:ascii="Courier New" w:hAnsi="Courier New" w:cs="Courier New" w:hint="default"/>
                                            </w:rPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="5" w:tplc="0C0A0005" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="bullet"/>
                                            <w:lvlText w:val=""/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="4320" w:hanging="360"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:ascii="Wingdings" w:hAnsi="Wingdings" w:hint="default"/>
                                            </w:rPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="6" w:tplc="0C0A0001" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="bullet"/>
                                            <w:lvlText w:val=""/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="5040" w:hanging="360"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:ascii="Symbol" w:hAnsi="Symbol" w:hint="default"/>
                                            </w:rPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="7" w:tplc="0C0A0003" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="bullet"/>
                                            <w:lvlText w:val="o"/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="5760" w:hanging="360"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:ascii="Courier New" w:hAnsi="Courier New" w:cs="Courier New" w:hint="default"/>
                                            </w:rPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="8" w:tplc="0C0A0005" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="bullet"/>
                                            <w:lvlText w:val=""/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="6480" w:hanging="360"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:ascii="Wingdings" w:hAnsi="Wingdings" w:hint="default"/>
                                            </w:rPr>
                                        </w:lvl>
                                    </w:abstractNum>';

    /**
     * @access public
     * @var ostring
     * @static
     */
    public static $orderedListStyle = '<w:abstractNum w:abstractNumId="" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" >
                                        <w:multiLevelType w:val="hybridMultilevel"/>
                                        <w:lvl w:ilvl="0" w:tplc="">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="decimal"/>
                                            <w:lvlText w:val="%1."/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="720" w:hanging="360"/>
                                            </w:pPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="1" w:tplc="" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="lowerLetter"/>
                                            <w:lvlText w:val="%2."/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="1440" w:hanging="360"/>
                                            </w:pPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="2" w:tplc="" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="lowerRoman"/>
                                            <w:lvlText w:val="%3."/>
                                            <w:lvlJc w:val="right"/>
                                            <w:pPr>
                                                <w:ind w:left="2160" w:hanging="180"/>
                                            </w:pPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="3" w:tplc="" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="decimal"/>
                                            <w:lvlText w:val="%4."/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="2880" w:hanging="360"/>
                                            </w:pPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="4" w:tplc="" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="lowerLetter"/>
                                            <w:lvlText w:val="%5."/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="3600" w:hanging="360"/>
                                            </w:pPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="5" w:tplc="" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="lowerRoman"/>
                                            <w:lvlText w:val="%6."/>
                                            <w:lvlJc w:val="right"/>
                                            <w:pPr>
                                                <w:ind w:left="4320" w:hanging="180"/>
                                            </w:pPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="6" w:tplc="" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="decimal"/>
                                            <w:lvlText w:val="%7."/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="5040" w:hanging="360"/>
                                            </w:pPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="7" w:tplc="" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="lowerLetter"/>
                                            <w:lvlText w:val="%8."/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="5760" w:hanging="360"/>
                                            </w:pPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="8" w:tplc="" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="lowerRoman"/>
                                            <w:lvlText w:val="%9."/>
                                            <w:lvlJc w:val="right"/>
                                            <w:pPr>
                                                <w:ind w:left="6480" w:hanging="180"/>
                                            </w:pPr>
                                        </w:lvl>
                                    </w:abstractNum>';

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $paragraphProperties = ['w:pStyle',
        'w:keepNext',
        'w:keepLines',
        'w:pageBreakBefore',
        'w:framePr',
        'w:widowControl',
        'w:numPr',
        'w:suppressLineNumbers',
        'w:pBdr',
        'w:shd',
        'w:tabs',
        'w:suppressAutoHyphens',
        'w:kinsoku',
        'w:wordWrap',
        'w:overflowPunct',
        'w:topLinePunct',
        'w:autoSpaceDE',
        'w:autoSpaceDN',
        'w:bidi',
        'w:adjustRightInd',
        'w:snapToGrid',
        'w:spacing',
        'w:ind',
        'w:contextualSpacing',
        'w:mirrorIndents',
        'w:suppressOverlap',
        'w:jc',
        'w:textDirectio',
        'w:textAlignment',
        'w:textboxTightWrap',
        'w:outlineLvl',
        'w:divId',
        'w:cnfStyle',
        'w:rPr',
        'w:sectPr',
        'w:pPrChange'
    ];

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $runProperties = ['w:rStyle',
        'w:rFonts',
        'w:b',
        'w:bCs',
        'w:i',
        'w:iCs',
        'w:caps',
        'w:smallCaps',
        'w:strike',
        'w:dstrike',
        'w:outline',
        'w:shadow',
        'w:emboss',
        'w:imprint',
        'w:noProof',
        'w:snapToGrid',
        'w:vanish',
        'w:webHidden',
        'w:color',
        'w:spacin',
        'w:w',
        'w:kern',
        'w:position',
        'w:sz',
        'w:szCs',
        'w:highlight',
        'w:u',
        'w:effect',
        'w:bdr',
        'w:shd',
        'w:fitText',
        'w:vertAlign',
        'w:rtl',
        'w:cs',
        'w:em',
        'w:lang',
        'w:eastAsianLayout',
        'w:specVanish',
        'w:oMath'
    ];

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $sectionProperties = ['w:footnotePr',
        'w:endnotePr',
        'w:type',
        'w:pgSz',
        'w:pgMar',
        'w:paperSrc',
        'w:pgBorders',
        'w:lnNumType',
        'w:pgNumType',
        'w:cols',
        'w:formProt',
        'w:vAlign',
        'w:noEndnote',
        'w:titlePg',
        'w:textDirection',
        'w:bidi',
        'w:rtlGutter',
        'w:docGrid',
        'w:printerSettings',
        'w:sectPrChange'
    ];

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $settings = ['w:writeProtection',
        'w:view',
        'w:zoom',
        'w:removePersonalInformation',
        'w:removeDateAndTime',
        'w:doNotDisplayPageBoundaries',
        'w:displayBackgroundShape',
        'w:printPostScriptOverText',
        'w:printFractionalCharacterWidth',
        'w:printFormsData',
        'w:embedTrueTypeFonts',
        'w:embedSystemFonts',
        'w:saveSubsetFonts',
        'w:saveFormsData',
        'w:mirrorMargins',
        'w:alignBordersAndEdges',
        'w:bordersDoNotSurroundHeader',
        'w:bordersDoNotSurroundFooter',
        'w:gutterAtTop',
        'w:hideSpellingErrors',
        'w:hideGrammaticalErrors',
        'w:activeWritingStyle',
        'w:proofState',
        'w:formsDesign',
        'w:attachedTemplate',
        'w:linkStyles',
        'w:stylePaneFormatFilter',
        'w:stylePaneSortMethod',
        'w:documentType',
        'w:mailMerge',
        'w:revisionView',
        'w:trackRevisions',
        'w:doNotTrackMoves',
        'w:doNotTrackFormatting',
        'w:documentProtection',
        'w:autoFormatOverride',
        'w:styleLockTheme',
        'w:styleLockQFSet',
        'w:defaultTabStop',
        'w:autoHyphenation',
        'w:consecutiveHyphenLimit',
        'w:hyphenationZone',
        'w:doNotHyphenateCaps',
        'w:showEnvelope',
        'w:summaryLength',
        'w:clickAndTypeStyle',
        'w:defaultTableStyle',
        'w:evenAndOddHeaders',
        'w:bookFoldRevPrinting',
        'w:bookFoldPrinting',
        'w:bookFoldPrintingSheets',
        'w:drawingGridHorizontalSpacing',
        'w:drawingGridVerticalSpacing',
        'w:displayHorizontalDrawingGridEvery',
        'w:displayVerticalDrawingGridEvery',
        'w:doNotUseMarginsForDrawingGridOrigin',
        'w:drawingGridHorizontalOrigin',
        'w:drawingGridVerticalOrigin',
        'w:doNotShadeFormData',
        'w:noPunctuationKerning',
        'w:characterSpacingControl',
        'w:printTwoOnOne',
        'w:strictFirstAndLastChars',
        'w:noLineBreaksAfter',
        'w:noLineBreaksBefore',
        'w:savePreviewPicture',
        'w:doNotValidateAgainstSchema',
        'w:saveInvalidXml',
        'w:ignoreMixedContent',
        'w:alwaysShowPlaceholderText',
        'w:doNotDemarcateInvalidXml',
        'w:saveXmlDataOnly',
        'w:useXSLTWhenSaving',
        'w:saveThroughXslt',
        'w:showXMLTags',
        'w:alwaysMergeEmptyNamespace',
        'w:updateFields',
        'w:hdrShapeDefaults',
        'w:footnotePr',
        'w:endnotePr',
        'w:compat',
        'w:docVars',
        'w:rsids',
        'm:mathPr',
        'w:uiCompat97To2003',
        'w:attachedSchema',
        'w:themeFontLang',
        'w:clrSchemeMapping',
        'w:doNotIncludeSubdocsInStats',
        'w:doNotAutoCompressPictures',
        'w:forceUpgrade',
        'w:captions',
        'w:readModeInkLockDown',
        'w:smartTagType',
        'sl:schemaLibrary',
        'w:shapeDefaults',
        'w:doNotEmbedSmartTags',
        'w:decimalSymbol',
        'w:listSeparator'
    ];

    /**
     * Class constructor
     */
    public function __construct()
    {

    }

    /**
     * Class destructor
     */
    public function __destruct()
    {

    }

    /**
     * @access public
     * @static
     * @param int $integer
     * @param bool $uppercase
     * @return string
     */
    public static function integer2Letter($integer, $uppercase = false)
    {
        $letter = '';
        $integer = $integer - 1;
        $letter = chr(($integer % 26) + 97);
        $letter .= (floor($integer / 26) > 0) ? str_repeat($letter, floor($integer / 26)) : '';
        if ($uppercase)
            $letter = strtoupper($letter);
        return $letter;
    }

    /**
     * @access public
     * @static
     * @param int $integer
     * @param bool $uppercase
     * @return string
     */
    public static function integer2RomanNumeral($integer, $uppercase = false)
    {
        $roman = '';
        $baseTransform = ['m' => 1000,
            'cm' => 900,
            'd' => 500,
            'cd' => 400,
            'c' => 100,
            'xc' => 90,
            'l' => 50,
            'xl' => 40,
            'x' => 10,
            'ix' => 9,
            'v' => 5,
            'iv' => 4,
            'i' => 1];
        foreach ($baseTransform as $key => $value) {
            $result = floor($integer / $value);
            $roman .= str_repeat($key, $result);
            $integer = $integer % $value;
        }
        if ($uppercase)
            $roman = strtoupper($roman);
        return $roman;
    }

    /**
     * @access public
     * @param DOMNode $targetNode this is the node where we want to insert the new child
     * @param DOMNode $sourceNode the child to be inserted
     * @param array $XMLSequence the sequence of childs given by the corresponding Schema for the target node
     * @param $type it can be ignore (if the node already exists jus leave silently, default value) or replace to overwrite the current node
     * @static
     */
    public static function insertNodeIntoSequence($targetNode, $sourceNode, $XMLSequence, $type = 'ignore')
    {
        //make sure that the $newNode belongs to the same DOM document as the $targetNode
        $newNode = $targetNode->ownerDocument->importNode($sourceNode, true);
        $nodeName = $newNode->nodeName;
        if ($nodeName == '#document-fragment') {
            $baseString = $newNode->ownerDocument->saveXML($newNode);
            $fragArray = explode(' ', $baseString);
            $nodeName = trim(str_replace('<', '', $fragArray[0]));
        }
        $sequenceIndex = array_search($nodeName, $XMLSequence);
        if (empty($sequenceIndex)) {
            //PhpdocxLogger::logger('The new node does not belong to the  given XML sequence', 'fatal');
        }
        $childNodes = $targetNode->childNodes;
        $append = true;
        foreach ($childNodes as $node) {
            $name = $node->nodeName;
            $index = array_search($node->nodeName, $XMLSequence);
            if ($index == $sequenceIndex) {
                if ($type == 'ignore') {
                    $append = false;
                    break;
                } else {
                    $node->parentNode->insertBefore($newNode, $node);
                    $node->parentNode->removeChild($node);
                    $append = false;
                    break;
                }
            } else if ($index > $sequenceIndex) {
                $node->parentNode->insertBefore($newNode, $node);
                $append = false;
                break;
            }
        }
        //in case no node was found we should append the node
        if ($append) {
            $targetNode->appendChild($newNode);
        }
    }

    /**
     * The child elements of the second node are added to the first node. If overwrite is set to true coincident nodes
     * will be overwritten
     * @access public
     * @param DOMNode $firstNode
     * @param DOMNode $secondNode
     * @param array $XMLSequence the sequence of childs given by the corresponding Schema for the given nodes
     * @param string $overwrite can take the values:
     * ignore (if the node already exists jus leave silently, default value) or replace to overwrite the current node
     * @param array $exceptions exceptions to teh overwrite rule
     * @static
     */
    public static function mergeXMLNodes($firstNode, $secondNode, $XMLSequence, $overwrite = false, $exceptions = [])
    {
        $childs = $secondNode->childNodes;
        foreach ($childs as $child) {
            $name = $child->nodeName;
            if ($overwrite) {
                if (!in_array($name, $exceptions)) {
                    OOXMLResources::insertNodeIntoSequence($firstNode, $child, $XMLSequence, $type = 'replace');
                } else {
                    OOXMLResources::insertNodeIntoSequence($firstNode, $child, $XMLSequence);
                }
            } else {
                if (!in_array($name, $exceptions)) {
                    OOXMLResources::insertNodeIntoSequence($firstNode, $child, $XMLSequence);
                } else {
                    OOXMLResources::insertNodeIntoSequence($firstNode, $child, $XMLSequence, $type = 'replace');
                }
            }
        }
    }

}

class CleanTemp
{

    /**
     * Construct
     *
     * @access private
     */
    private function __construct()
    {

    }

    /**
     * Destruct
     *
     * @access public
     */
    public function __destruct()
    {

    }

    /**
     * Delete files and folders
     *
     * @param string $path To delete
     */
    public static function clean($path)
    {
        if (is_file($path)) {
            @unlink($path);
        }
        if (!$dh = @opendir($path)) {
            return;
        }
        while (($obj = readdir($dh))) {
            if ($obj == '.' || $obj == '..') {
                continue;
            }
            if (!@unlink($path . '/' . $obj)) {
                self::clean($path . '/' . $obj);
            }
        }

        closedir($dh);
        @rmdir($path);
    }

}

class CreateProperties extends CreateElement
{

    /**
     *
     * @access private
     * @var string
     */
    private static $_instance = NULL;

    /**
     * Destruct
     *
     * @access public
     */
    public function __construct()
    {
    }

    /**
     * Destruct
     *
     * @access public
     */
    public function __destruct()
    {

    }

    /**
     * Magic method, returns current XML
     *
     * @access public
     * @return string Return current XML
     */
    public function __toString()
    {
        return $this->_xml;
    }

    /**
     * Singleton, return instance of class
     *
     * @access public
     * @return CreateText
     * @static
     */
    public static function getInstance()
    {
        if (self::$_instance == NULL) {
            self::$_instance = new CreateProperties();
        }
        return self::$_instance;
    }

    /**
     * Create properties
     *
     * @access public
     * @param mixed $args[0], $args[1]
     */
    public function CreateProperties()
    {
        $generalProperties = ['title', 'subject', 'creator', 'keywords', 'description', 'category', 'contentStatus'];
        $nameSpaces = ['title' => 'dc', 'subject' => 'dc', 'creator' => 'dc', 'keywords' => 'cp', 'description' => 'dc', 'category' => 'cp', 'contentStatus' => 'cp'];
        $nameSpacesURI = [
            'dc' => 'http://purl.org/dc/elements/1.1/',
            'cp' => 'http://schemas.openxmlformats.org/package/2006/metadata/core-properties',
            'dcterms' => 'http://purl.org/dc/terms/'
        ];
        $args = func_get_args();

        //Let us load the contents of the file in a DOMDocument
        $coreDocument = $args[1];

        foreach ($args[0] as $key => $value) {
            if (in_array($key, $generalProperties)) {
                $coreNodes = $coreDocument->getElementsByTagName($key);
                if ($coreNodes->length > 0) {
                    $coreNodes->item(0)->nodeValue = $value;
                } else {
                    $strNode = '<' . $nameSpaces[$key] . ':' . $key . ' xmlns:' . $nameSpaces[$key] . '="' . $nameSpacesURI[$nameSpaces[$key]] . '">' . $value . '</' . $nameSpaces[$key] . ':' . $key . '>';
                    $tempNode = $coreDocument->createDocumentFragment();
                    $tempNode->appendXML($strNode);
                    $coreDocument->documentElement->appendChild($tempNode);
                }
            }
        }
        return $coreDocument;
    }

    /**
     * Create properties
     *
     * @access public
     * @param mixed $args[0], $args[1]
     */
    public function createPropertiesApp()
    {
        $appProperties = ['Manager', 'Company'];

        $args = func_get_args();

        //Let us load the contents of the file in a DOMDocument
        $appDocument = $args[1];

        foreach ($args[0] as $key => $value) {
            if (in_array($key, $appProperties)) {
                $appNodes = $appDocument->getElementsByTagName($key);
                if ($appNodes->length > 0) {
                    $appNodes->item(0)->nodeValue = $value;
                } else {
                    $strNode = '<' . $key . '>' . $value . '</' . $key . '>';
                    $tempNode = $appDocument->createDocumentFragment();
                    $tempNode->appendXML($strNode);
                    $appDocument->documentElement->appendChild($tempNode);
                }
            }
        }
        return $appDocument;
    }

    /**
     * Create custom properties
     *
     * @access public
     * @param mixed $args[0], $args[1]
     */
    public function createPropertiesCustom()
    {
        $tagName = ['text' => 'lpwstr', 'date' => 'filetime', 'number' => 'r8', 'boolean' => 'bool'];

        $args = func_get_args();
        $customDocument = $args[1];

        //Now we begin the insertion of the custom properties
        foreach ($args[0] as $key => $value) {

            $myKey = array_keys($value);
            $myValue = array_values($value);

            if (array_key_exists($myKey[0], $tagName)) {

                $customNodes = $customDocument->getElementsByTagName('property');
                $numberNodes = $customNodes->length;
                if ($myValue[0] === true) {
                    $myValue[0] = 1;
                } else if ($myValue[0] === false) {
                    $myValue[0] = 0;
                }
                if ($numberNodes > 0) {
                    for ($j = 0; $j < $numberNodes; $j++) {
                        if ($customNodes->item($j)->getAttribute('name') == $key) {
                            $customNodes->item($j)->firstChild->nodeValue = $myValue[0];
                        } else {
                            $strNode = '<property fmtid="{D5CDD505-2E9C-101B-9397-08002B2CF9AE}" pid="' . rand(999, 99999999) . '" name="' . $key . '"><vt:' . $tagName[$myKey[0]] . ' xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes" temp="xxx">' . (string) $myValue[0] . '</vt:' . $tagName[$myKey[0]] . '></property>';
                        }
                    }
                } else {
                    $strNode = '<property fmtid="{D5CDD505-2E9C-101B-9397-08002B2CF9AE}" pid="' . rand(999, 99999999) . '" name="' . $key . '"><vt:' . $tagName[$myKey[0]] . ' xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes"  temp="xxx">' . (string) $myValue[0] . '</vt:' . $tagName[$myKey[0]] . '></property>';
                }
                if ($strNode != '') {
                    $tempNode = $customDocument->createDocumentFragment();
                    $tempNode->appendXML($strNode);
                    $customDocument->documentElement->appendChild($tempNode);
                }
            }
        }
        $propData = str_replace('xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes" temp="xxx">', '>', $customDocument->saveXML());
        return $propData;
    }

}

class CreateElement
{

    const MATHNAMESPACEWORD = 'm';
    const NAMESPACEWORD = 'w';

    /**
     *
     * @var string
     * @access protected
     */
    protected $_xml;

    /**
     * Construct
     *
     * @access public
     */
    public function __construct()
    {

    }

    /**
     * Destruct
     *
     * @access public
     */
    public function __destruct()
    {

    }

    /**
     *
     * @access public
     * @return string
     */
    public function __toString()
    {

    }

    /**
     * Delete pending tags
     *
     * @access protected
     */
    protected function cleanTemplate()
    {
        $this->_xml = preg_replace('/__[A-Z]+__/', '', $this->_xml);
    }

    /**
     * Delete first w:rpr
     *
     * @access protected
     */
    protected function cleanTemplateFirstRPR()
    {
        $this->_xml = preg_replace('/__GENERATERPR__/', '', $this->_xml, 1);
    }

    /**
     * Generate w:align
     *
     * @param string $align
     * @access protected
     */
    protected function generateALIGN($align)
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
            ':align>' . $align . '</' . CreateImage::NAMESPACEWORD .
            ':align>';

        $this->_xml = str_replace('__GENERATEPOSITION__', $xml, $this->_xml);
    }

    /**
     * Generate w:anchor
     *
     * @param string $behindDoc
     * @param string $distT
     * @param string $distB
     * @param string $distL
     * @param string $distR
     * @param int $simplePos
     * @param string $relativeHeight
     * @param string $locked
     * @param string $layoutInCell
     * @param string $allowOverlap
     * @access protected
     */
    protected function generateANCHOR($behindDoc = 0, $distT = '0', $distB = '0', $distL = '0', $distR = '0', $simplePos = 0, $relativeHeight = '0', $locked = 0, $layoutInCell = 1, $allowOverlap = 1)
    {
        $xml = '<' . CreateImage::NAMESPACEWORD . ':anchor distT="' . $distT .
            '" distB="' . $distB . '" distL="' . $distL .
            '" distR="' . $distR . '" simplePos="' . $simplePos .
            '" relativeHeight="' . $relativeHeight .
            '" behindDoc="' . $behindDoc .
            '" locked="' . $locked .
            '" layoutInCell="' . $layoutInCell .
            '" allowOverlap="' . $allowOverlap .
            '">__GENERATEINLINE__</' . CreateImage::NAMESPACEWORD .
            ':anchor>';

        $this->_xml = str_replace('__GENERATEDRAWING__', $xml, $this->_xml);
    }

    /**
     * Generate w:avlst
     *
     * @access protected
     */
    protected function generateAVLST()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
            ':avLst></' . CreateImage::NAMESPACEWORD1 .
            ':avLst>__GENERATEPRSTGEOM__';

        $this->_xml = str_replace('__GENERATEPRSTGEOM__', $xml, $this->_xml);
    }

    /**
     * Generate w:b and w:bCs
     *
     * @param string $val
     * @access protected
     */
    protected function generateB($val = 'off')
    {
        if ($val == 'single') {
            $val = 'on';
        }
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':b ' . CreateElement::NAMESPACEWORD .
            ':val="' . $val . '"></' . CreateElement::NAMESPACEWORD .
            ':b><' . CreateElement::NAMESPACEWORD .
            ':bCs ' . CreateElement::NAMESPACEWORD .
            ':val="' . $val . '"></' . CreateElement::NAMESPACEWORD .
            ':bCs>' .
            '__GENERATERPR__';

        $this->_xml = str_replace('__GENERATERPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:bcs
     *
     * @access protected
     */
    protected function generateBCS()
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':bCs></' . CreateElement::NAMESPACEWORD .
            ':bCs>__GENERATERPR__';

        $this->_xml = str_replace('__GENERATERPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:blip
     *
     * @param string $cstate
     * @access protected
     */
    protected function generateBLIP($cstate = 'print')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
            ':blip r:embed="rId' . $this->getRId() .
            '" cstate="' . $cstate .
            '"></' . CreateImage::NAMESPACEWORD1 .
            ':blip>__GENERATEBLIPFILL__';

        $this->_xml = str_replace('__GENERATEBLIPFILL__', $xml, $this->_xml);
    }

    /**
     * Generate w:blipfill
     *
     * @access protected
     */
    protected function generateBLIPFILL()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD2 .
            ':blipFill>__GENERATEBLIPFILL__</' .
            CreateImage::NAMESPACEWORD2 . ':blipFill>__GENERATEPIC__';

        $this->_xml = str_replace('__GENERATEPIC__', $xml, $this->_xml);
    }

    /**
     * Generate w:br
     *
     * @access protected
     * @param string $type
     */
    protected function generateBR($type = '')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD . ':br ' .
            CreateElement::NAMESPACEWORD . ':type="' . $type . '"></' .
            CreateElement::NAMESPACEWORD . ':br>';
        $this->_xml = str_replace('__GENERATER__', $xml, $this->_xml);
    }

    /**
     * Generate w:cnvgraphicframepr
     *
     * @access protected
     */
    protected function generateCNVGRAPHICFRAMEPR()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
            ':cNvGraphicFramePr>__GENERATECNVGRAPHICFRAMEPR__</' .
            CreateImage::NAMESPACEWORD .
            ':cNvGraphicFramePr>__GENERATEINLINE__';

        $this->_xml = str_replace('__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:cnvpicpr
     *
     * @access protected
     */
    protected function generateCNVPICPR()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD2 .
            ':cNvPicPr></' . CreateImage::NAMESPACEWORD2 .
            ':cNvPicPr>__GENERATENVPICPR__';

        $this->_xml = str_replace('__GENERATENVPICPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:cnvpr
     *
     * @param string $id
     * @access protected
     */
    protected function generateCNVPR($id = '0')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD2 .
            ':cNvPr id="' . $id . '" name="' . $this->getName() .
            '"></' . CreateImage::NAMESPACEWORD2 .
            ':cNvPr>__GENERATENVPICPR__';

        $this->_xml = str_replace('__GENERATENVPICPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:docpr
     *
     * @param string $id
     * @param string $name
     * @access protected
     */
    protected function generateDOCPR($id = "1", $name = "0 Imagen")
    {
        $id = rand(999999, 999999999);
        $xml = '<' . CreateImage::NAMESPACEWORD . ':docPr id="' . $id .
            '" name="' . $name . '" descr="' . $this->getName() .
            '"></' . CreateImage::NAMESPACEWORD .
            ':docPr>__GENERATEINLINE__';

        $this->_xml = str_replace('__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:drawing
     *
     * @access protected
     */
    protected function generateDRAWING()
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':drawing>__GENERATEDRAWING__</' .
            CreateElement::NAMESPACEWORD .
            ':drawing>';

        $this->_xml = str_replace('__GENERATER__', $xml, $this->_xml);
    }

    /**
     * Generate w:effectextent
     *
     * @param string $l
     * @param string $t
     * @param string $r
     * @param string $b
     * @access protected
     */
    protected function generateEFFECTEXTENT($l = "19050", $t = "0", $r = "4307", $b = "0")
    {
        $xml = '<' . CreateImage::NAMESPACEWORD . ':effectExtent l="' . $l .
            '" t="' . $t . '" r="' . $r . '" b="' . $b .
            '"></' . CreateImage::NAMESPACEWORD .
            ':effectExtent>__GENERATEINLINE__';

        $this->_xml = str_replace('__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:ext
     *
     * @param string $cx
     * @param string $cy
     * @access protected
     */
    protected function generateEXT($cx = '2997226', $cy = '2247918')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
            ':ext cx="' . $cx . '" cy="' . $cy .
            '"></' . CreateImage::NAMESPACEWORD1 .
            ':ext>__GENERATEXFRM__';

        $this->_xml = str_replace('__GENERATEXFRM__', $xml, $this->_xml);
    }

    /**
     * Generate w:extent
     *
     * @param string $cx
     * @param string $cy
     * @access protected
     */
    protected function generateEXTENT($cx = '2986543', $cy = '2239906')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD . ':extent cx="' . $cx .
            '" cy="' . $cy . '"></' . CreateImage::NAMESPACEWORD .
            ':extent>__GENERATEINLINE__';

        $this->_xml = str_replace('__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:fillrect
     *
     * @access protected
     */
    protected function generateFILLRECT()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
            ':fillRect></' . CreateImage::NAMESPACEWORD1 .
            ':fillRect>';

        $this->_xml = str_replace('__GENERATESTRETCH__', $xml, $this->_xml);
    }

    /**
     * Generate w:graphic
     *
     * @param string $xmlns
     * @access protected
     */
    protected function generateGRAPHIC(
        $xmlns = 'http://schemas.openxmlformats.org/drawingml/2006/main')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
            ':graphic xmlns:a="' . $xmlns .
            '">__GENERATEGRAPHIC__</' . CreateImage::NAMESPACEWORD1 .
            ':graphic>';

        $this->_xml = str_replace('__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:graphicpframelocks
     *
     * @param string $noChangeAspect
     * @access protected
     */
    protected function generateGRAPHICPRAMELOCKS($noChangeAspect = '')
    {
        $xmlAux = '<' . CreateImage::NAMESPACEWORD1 .
            ':graphicFrameLocks xmlns:a="' .
            'http://schemas.openxmlformats.org/drawingml/2006/main"';

        if ($noChangeAspect != '') {
            $xmlAux .= ' noChangeAspect="' . $noChangeAspect . '"';
        }
        $xmlAux .= '></' . CreateImage::NAMESPACEWORD1 . ':graphicFrameLocks>';

        $this->_xml = str_replace(
            '__GENERATECNVGRAPHICFRAMEPR__', $xmlAux, $this->_xml
        );
    }

    /**
     * Generate w:graphicdata
     *
     * @param string $uri
     * @access protected
     */
    protected function generateGRAPHICDATA(
        $uri = 'http://schemas.openxmlformats.org/drawingml/2006/picture')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
            ':graphicData uri="' . $uri .
            '">__GENERATEGRAPHICDATA__</' . CreateImage::NAMESPACEWORD1 .
            ':graphicData>';

        $this->_xml = str_replace('__GENERATEGRAPHIC__', $xml, $this->_xml);
    }

    /**
     * Generate w:inline
     *
     * @param string $distT
     * @param string $distB
     * @param string $distL
     * @param string $distR
     * @access protected
     */
    protected function generateINLINE($distT = '0', $distB = '0', $distL = '0', $distR = '0')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
            ':inline distT="' . $distT . '" distB="' . $distB .
            '" distL="' . $distL . '" distR="' . $distR .
            '">__GENERATEINLINE__</' . CreateImage::NAMESPACEWORD .
            ':inline>';

        $this->_xml = str_replace('__GENERATEDRAWING__', $xml, $this->_xml);
    }

    /**
     * Generate w:jc
     *
     * @param string $val
     * @access protected
     */
    protected function generateJC($val = '')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':jc ' . CreateElement::NAMESPACEWORD . ':val="' . $val .
            '"></' . CreateElement::NAMESPACEWORD . ':jc>';

        $this->_xml = str_replace('__GENERATEPPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:lineto
     *
     * @param string $x
     * @param string $y
     * @access protected
     */
    protected function generateLINETO($x = '-198', $y = '21342')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
            ':lineTo x="' . $x . '" y="' . $y .
            '"></' . CreateImage::NAMESPACEWORD .
            ':lineTo>__GENERATEWRAPPOLYGON__';

        $this->_xml = str_replace('__GENERATEWRAPPOLYGON__', $xml, $this->_xml);
    }

    /**
     * Generate w:ln
     *
     * @param string $w
     * @access protected
     */
    protected function generateLN($w = '12700')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
            ':ln w="' . $w . '">__GENERATELN__</' .
            CreateImage::NAMESPACEWORD1 .
            ':ln>__GENERATESPPR__';

        $this->_xml = str_replace('__GENERATESPPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:noproof
     *
     * @access protected
     */
    protected function generateNOPROOF()
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':noProof></' . CreateElement::NAMESPACEWORD .
            ':noProof>__GENERATEPPR__';

        $this->_xml = str_replace('__GENERATERPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:nvpicpr
     *
     * @access protected
     */
    protected function generateNVPICPR()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD2 .
            ':nvPicPr>__GENERATENVPICPR__</' . CreateImage::NAMESPACEWORD2 .
            ':nvPicPr>__GENERATEPIC__';

        $this->_xml = str_replace('__GENERATEPIC__', $xml, $this->_xml);
    }

    /**
     * Generate w:off
     *
     * @param string $x
     * @param string $y
     * @access protected
     */
    protected function generateOFF($x = '0', $y = '0')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
            ':off x="' . $x . '" y="' . $y .
            '"></' . CreateImage::NAMESPACEWORD1 .
            ':off>__GENERATEXFRM__';

        $this->_xml = str_replace('__GENERATEXFRM__', $xml, $this->_xml);
    }

    /**
     * Generate w:p
     *
     * @access protected
     */
    protected function generateP()
    {
        $this->_xml = '<' . CreateElement::NAMESPACEWORD .
            ':p>__GENERATEP__</' . CreateElement::NAMESPACEWORD .
            ':p>';
    }

    /**
     * Generate w:pic
     *
     * @param string $pic
     * @access protected
     */
    protected function generatePIC(
        $pic = 'http://schemas.openxmlformats.org/drawingml/2006/picture')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD2 .
            ':pic xmlns:pic="' . $pic .
            '">__GENERATEPIC__</' . CreateImage::NAMESPACEWORD2 .
            ':pic>';

        $this->_xml = str_replace('__GENERATEGRAPHICDATA__', $xml, $this->_xml);
    }

    /**
     * Generate w:pict
     *
     * @access protected
     */
    protected function generatePICT()
    {
        $this->_xml = str_replace(
            '__GENERATER__', '<' . CreateElement::NAMESPACEWORD .
            ':pict>__GENERATEPICT__</' . CreateElement::NAMESPACEWORD .
            ':pict>', $this->_xml
        );
    }

    /**
     * Generate w:positionh
     *
     * @param string $relativeFrom
     * @access protected
     */
    protected function generatePOSITIONH($relativeFrom = 'margin')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
            ':positionH relativeFrom="' . $relativeFrom .
            '">__GENERATEPOSITION__</' . CreateImage::NAMESPACEWORD .
            ':positionH>__GENERATEINLINE__';

        $this->_xml = str_replace('__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:positionv
     *
     * @param string $relativeFrom
     * @access protected
     */
    protected function generatePOSITIONV($relativeFrom = 'line')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
            ':positionV relativeFrom="' . $relativeFrom .
            '">__GENERATEPOSITION__</' . CreateImage::NAMESPACEWORD .
            ':positionV>__GENERATEINLINE__';

        $this->_xml = str_replace('__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:posoffset
     *
     * @param int $num
     * @access protected
     */
    protected function generatePOSOFFSET($num)
    {
        $xml = '<' . CreateImage::NAMESPACEWORD . ':posOffset>' . $num .
            '</' . CreateImage::NAMESPACEWORD . ':posOffset>';

        $this->_xml = str_replace('__GENERATEPOSITION__', $xml, $this->_xml);
    }

    /**
     * Generate w:ppr
     *
     * @access protected
     */
    protected function generatePPR()
    {
        $xml = '<' . CreateElement::NAMESPACEWORD . ':pPr>__GENERATEPPR__</' .
            CreateElement::NAMESPACEWORD . ':pPr>__GENERATER__';

        $this->_xml = str_replace('__GENERATEP__', $xml, $this->_xml);
    }

    /**
     * Generate w:prstdash
     *
     * @param string $val
     * @access protected
     */
    protected function generatePRSTDASH($val = 'sysDash')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 . ':prstDash val="' . $val .
            '"></' . CreateImage::NAMESPACEWORD1 .
            ':prstDash>__GENERATELN__';

        $this->_xml = str_replace('__GENERATELN__', $xml, $this->_xml);
    }

    /**
     * Generate w:prstgeom
     *
     * @param string $prst
     * @access protected
     */
    protected function generatePRSTGEOM($prst = 'rect')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
            ':prstGeom prst="' . $prst .
            '">__GENERATEPRSTGEOM__</' . CreateImage::NAMESPACEWORD1 .
            ':prstGeom>__GENERATESPPR__';

        $this->_xml = str_replace('__GENERATESPPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:pstyle
     *
     * @param string $val
     * @access protected
     */
    protected function generatePSTYLE($val = 'Textonotaalfinal')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':pStyle ' . CreateElement::NAMESPACEWORD .
            ':val="' . $val . '"></' . CreateElement::NAMESPACEWORD .
            ':pStyle>';

        $this->_xml = str_replace('__GENERATEPPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:r
     *
     * @access protected
     */
    protected function generateQUITAR()
    {
        $this->_xml = '<' . CreateElement::NAMESPACEWORD .
            ':r>__GENERATER__</' . CreateElement::NAMESPACEWORD .
            ':r>';
    }

    /**
     * Generate w:r
     *
     * @access protected
     */
    protected function generateR()
    {
        if (!empty($this->_xml)) {
            if (preg_match("/__GENERATEP__/", $this->_xml)) {
                $xml = '<' . CreateElement::NAMESPACEWORD .
                    ':r>__GENERATER__</' . CreateElement::NAMESPACEWORD .
                    ':r>__GENERATESUBR__';

                $this->_xml = str_replace('__GENERATEP__', $xml, $this->_xml);
            } elseif (preg_match("/__GENERATER__/", $this->_xml)) {
                $xml = '<' . CreateElement::NAMESPACEWORD .
                    ':r>__GENERATER__</' . CreateElement::NAMESPACEWORD .
                    ':r>__GENERATESUBR__';

                $this->_xml = str_replace('__GENERATER__', $xml, $this->_xml);
            } elseif (preg_match("/__GENERATESUBR__/", $this->_xml)) {
                $xml = '<' . CreateElement::NAMESPACEWORD .
                    ':r>__GENERATER__</' . CreateElement::NAMESPACEWORD .
                    ':r>__GENERATESUBR__';

                $this->_xml = str_replace(
                    '__GENERATESUBR__', $xml, $this->_xml
                );
            }
        } else {
            $this->_xml = '<' . CreateElement::NAMESPACEWORD .
                ':r>__GENERATER__</' . CreateElement::NAMESPACEWORD .
                ':r>__GENERATESUBR__';
        }
    }

    /**
     * Generate w:rfonts
     *
     * @param string $font
     * @access protected
     */
    protected function generateRFONTS($font)
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':rFonts ' . CreateElement::NAMESPACEWORD .
            ':ascii="' . $font . '" ' . CreateElement::NAMESPACEWORD .
            ':hAnsi="' . $font . '" ' . CreateElement::NAMESPACEWORD .
            ':cs="' . $font . '"></' . CreateElement::NAMESPACEWORD .
            ':rFonts>__GENERATERPR__';

        $this->_xml = str_replace('__GENERATERPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:rpr
     *
     * @access protected
     */
    protected function generateRPR()
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':rPr>__GENERATERPR__</' . CreateElement::NAMESPACEWORD .
            ':rPr>__GENERATER__';

        $this->_xml = str_replace('__GENERATER__', $xml, $this->_xml);
    }

    /**
     * Generate w:rstyle
     *
     * @param string $val
     * @access protected
     */
    protected function generateRSTYLE($val = 'PHPDOCXFootnoteReference')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':rStyle ' . CreateElement::NAMESPACEWORD .
            ':val="' . $val .
            '"></' . CreateElement::NAMESPACEWORD .
            ':rStyle>';

        $this->_xml = str_replace('__GENERATERPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:schemeclr
     *
     * @param string $val
     * @access protected
     */
    protected function generateSCHEMECLR($val = 'tx1')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 . ':schemeClr val="' . $val .
            '"></' . CreateImage::NAMESPACEWORD1 . ':schemeClr>';

        $this->_xml = str_replace('__GENERATESOLIDFILL__', $xml, $this->_xml);
    }

    /**
     * Generate w:simplepos
     *
     * @param string $x
     * @param string $y
     * @access protected
     */
    protected function generateSIMPLEPOS($x = '0', $y = '0')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
            ':simplePos x="' . $x . '" y="' . $y .
            '"></' . CreateImage::NAMESPACEWORD .
            ':simplePos>__GENERATEINLINE__';

        $this->_xml = str_replace('__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:solidfill
     * @param string $color
     * @access protected
     */
    protected function generateSOLIDFILL($color = '000000')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
            ':solidFill><a:srgbClr val="' . $color . '" /></' .
            CreateImage::NAMESPACEWORD1 .
            ':solidFill>__GENERATELN__';
        $this->_xml = str_replace('__GENERATELN__', $xml, $this->_xml);
    }

    /**
     * Generate w:sppr
     *
     * @access protected
     */
    protected function generateSPPR()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD2 .
            ':spPr>__GENERATESPPR__</' . CreateImage::NAMESPACEWORD2 .
            ':spPr>';

        $this->_xml = str_replace('__GENERATEPIC__', $xml, $this->_xml);
    }

    /**
     * Generate w:start
     *
     * @param string $x
     * @param string $y
     * @access protected
     */
    protected function generateSTART($x = '-198', $y = '0')
    {

        $xml = '<' . CreateImage::NAMESPACEWORD .
            ':start x="' . $x . '" y="' . $y .
            '"></' . CreateImage::NAMESPACEWORD .
            ':start>__GENERATEWRAPPOLYGON__';

        $this->_xml = str_replace('__GENERATEWRAPPOLYGON__', $xml, $this->_xml);
    }

    /**
     * Generate w:stretch
     *
     * @access protected
     */
    protected function generateSTRETCH()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
            ':stretch>__GENERATESTRETCH__</' . CreateImage::NAMESPACEWORD1 .
            ':stretch>__GENERATEBLIPFILL__';

        $this->_xml = str_replace('__GENERATEBLIPFILL__', $xml, $this->_xml);
    }

    /**
     * Generate w:t
     *
     * @param string $dat
     * @access protected
     */
    protected function generateT($dat)
    {
        $xml = '<' . CreateElement::NAMESPACEWORD . ':t xml:space="preserve">' .
            htmlspecialchars($dat) . '</' . CreateElement::NAMESPACEWORD . ':t>';

        $this->_xml = str_replace('__GENERATER__', $xml, $this->_xml);
    }

    /**
     * Generate w:wrapnone
     *
     * @access protected
     */
    protected function generateWRAPNONE()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
            ':wrapNone></' . CreateImage::NAMESPACEWORD .
            ':wrapNone>__GENERATEINLINE__';

        $this->_xml = str_replace('__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:wrappolygon
     *
     * @param string $edited
     * @access protected
     */
    protected function generateWRAPPOLYGON($edited = '0')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
            ':wrapPolygon edited="' . $edited .
            '">__GENERATEWRAPPOLYGON__</' . CreateImage::NAMESPACEWORD .
            ':wrapPolygon>';

        $this->_xml = str_replace('__GENERATEWRAPTHROUGH__', $xml, $this->_xml);
    }

    /**
     * Generate w:wrapsquare
     *
     * @param string $wrapText
     * @access protected
     */
    protected function generateWRAPSQUARE($wrapText = "bothSides")
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
            ':wrapSquare wrapText="' . $wrapText .
            '"></' . CreateImage::NAMESPACEWORD .
            ':wrapSquare>__GENERATEINLINE__';

        $this->_xml = str_replace('__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:wrapthrough
     *
     * @param string $wrapText
     * @access protected
     */
    protected function generateWRAPTHROUGH($wrapText = 'bothSides')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
            ':wrapThrough wrapText="' . $wrapText .
            '">__GENERATEWRAPTHROUGH__</' . CreateImage::NAMESPACEWORD .
            ':wrapThrough>__GENERATEINLINE__';

        $this->_xml = str_replace('__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:wraptopandbottom
     *
     * @access protected
     */
    protected function generateWRAPTOPANDBOTTOM()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
            ':wrapTopAndBottom></' . CreateImage::NAMESPACEWORD .
            ':wrapTopAndBottom>__GENERATEINLINE__';

        $this->_xml = str_replace('__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:xfrm
     *
     * @access protected
     */
    protected function generateXFRM()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
            ':xfrm>__GENERATEXFRM__</' . CreateImage::NAMESPACEWORD1 .
            ':xfrm>__GENERATESPPR__';

        $this->_xml = str_replace('__GENERATESPPR__', $xml, $this->_xml);
    }

}
class CreateTables extends CreateElement
{

    /**
     * @access private
     * @var array
     * @static
     */
    private static $_borders = ['top', 'left', 'bottom', 'right'];

    /**
     * @access private
     * @var CreateTable
     * @static
     */
    private static $_instance = NULL;

    /**
     * Construct
     *
     * @access public
     */
    public function __construct()
    {

    }

    /**
     * Destruct
     *
     * @access public
     */
    public function __destruct()
    {

    }

    /**
     *
     * @access public
     * @return string
     */
    public function __toString()
    {
        $this->cleanTemplate();
        return $this->_xml;
    }

    /**
     *
     * @access public
     * @return CreateTable
     * @static
     */
    public static function getInstance()
    {
        if (self::$_instance == NULL) {
            self::$_instance = new CreateTables();
        }
        return self::$_instance;
    }

    /**
     * Create table
     *
     * @access public
     * @param array args[0]
     */
    public function createTable()
    {
        $this->_xml = '';
        $args = func_get_args();
        $args[1] = CreateDocx::translateTableOptions2StandardFormat($args[1]);

        if (is_array($args[0])) {
            //Normalize table data
            $tableData = $this->parseTableData($args[0]);
            $this->generateTBL();
            $this->generateTBLPR();
            if (isset($args[1]['TBLSTYLEval'])) {
                $this->generateTBLSTYLE($args[1]['TBLSTYLEval']);
            } else {
                $this->generateTBLSTYLE();
            }
            if (isset($args[1]['float'])) {
                $this->generateTBLFLOAT($args[1]['float']);
            }
            $this->generateTBLOVERLAP();
            if (isset($args[1]['bidi'])) {
                $this->generateTBLBIDI($args[1]['bidi']);
            }
            if (isset($args[1]['tableWidth']) && is_array($args[1]['tableWidth'])) {
                $this->generateTBLW($args[1]['tableWidth']['type'], $args[1]['tableWidth']['value']);
            } else {
                $this->generateTBLW('auto', 0);
            }
            if (isset($args[1]['jc'])) {
                $this->generateJC($args[1]['jc']);
            }
            if (isset($args[1]['cellSpacing'])) {
                $this->generateTBLCELLSPACING($args[1]['cellSpacing']);
            }
            if (isset($args[1]['indent'])) {
                $this->generateTBLINDENT($args[1]['indent']);
            }
            if (isset($args[1]['border']) ||
                isset($args[1]['border_sz']) ||
                isset($args[1]['border_color']) ||
                isset($args[1]['border_spacing'])) {
                $this->generateTBLBORDERS();
                $sz = 6;
                if (isset($args[1]['border_sz'])) {
                    $sz = $args[1]['border_sz'];
                }
                $color = 'auto';
                if (isset($args[1]['border_color'])) {
                    $color = $args[1]['border_color'];
                }
                $spacing = '0';
                if (isset($args[1]['border_spacing'])) {
                    $spacing = $args[1]['border_spacing'];
                }
                if (isset($args[1]['border'])) {
                    $border = $args[1]['border'];
                } else {
                    $border = 'solid';
                }
                if (!isset($args[1]['border_settings']) ||
                    $args[1]['border_settings'] == 'all' ||
                    $args[1]['border_settings'] == 'outside') {
                    $this->generateTBLTOP($border, $sz, $spacing, $color);
                    $this->generateTBLLEFT($border, $sz, $spacing, $color);
                    $this->generateTBLBOTTOM($border, $sz, $spacing, $color);
                    $this->generateTBLRIGHT($border, $sz, $spacing, $color);
                }
                if (!isset($args[1]['border_settings']) ||
                    $args[1]['border_settings'] == 'all' ||
                    $args[1]['border_settings'] == 'inside') {
                    $this->generateTBLINSIDEH($border, $sz, $spacing, $color);
                    $this->generateTBLINSIDEV($border, $sz, $spacing, $color);
                }
            }
            if (isset($args[1]['tableLayout'])) {
                $this->generateTBLLAYOUT($args[1]['tableLayout']);
            }
            if (isset($args[1]['cellMargin'])) {
                $this->generateTBLCELLMARGIN($args[1]['cellMargin']);
            }
            if (isset($args[1]['conditionalFormatting']) && is_array($args[1]['conditionalFormatting'])) {
                $this->generateTBLLOOK($args[1]['conditionalFormatting']);
            }


            $rowNumber = 0;
            $colNumber = 0;
            $this->generateTBLGRID();
            if (isset($args[1]['size_col']) && is_array($args[1]['size_col'])) {
                foreach ($args[1]['size_col'] as $key => $widthCol) {
                    $this->generateGRIDCOL($widthCol);
                }
            } else {
                foreach ($tableData as $row) {
                    $rowLength = [];
                    $rowLength[] = count($row);
                }
                $numCols = max($rowLength);
                for ($k = 0; $k < $numCols; $k++) {
                    if (isset($args[1]['size_col'])) {
                        $this->generateGRIDCOL($args[1]['size_col']);
                    } else {
                        $this->generateGRIDCOL();
                    }
                }
            }

            foreach ($tableData as $row) {
                $this->generateTR();
                $this->generateTRPR();
                if (isset($args[1]['cantSplitRows']) && $args[1]['cantSplitRows']) {
                    if (isset($args[2][$rowNumber]['cantSplit'])) {
                        $this->generateTRCANTSPLIT($args[2][$rowNumber]['cantSplit']);
                    } else {
                        $this->generateTRCANTSPLIT();
                    }
                } else if (isset($args[2][$rowNumber]['cantSplit']) &&
                    $args[2][$rowNumber]['cantSplit']) {
                    $this->generateTRCANTSPLIT();
                }
                if (isset($args[2][$rowNumber]['height']) ||
                    isset($args[2][$rowNumber]['minHeight'])) {
                    if (isset($args[2][$rowNumber]['height'])) {
                        $height = $args[2][$rowNumber]['height'];
                        $hRule = 'exact';
                    } else {
                        $height = $args[2][$rowNumber]['minHeight'];
                        $hRule = 'atLeast';
                    }
                    $this->generateTRHEIGHT($height, $hRule);
                }
                if (isset($args[2][$rowNumber]['tableHeader']) &&
                    $args[2][$rowNumber]['tableHeader']) {
                    $this->generateTRTABLEHEADER();
                }
                $rowNumber++;
                foreach ($row as $cellContent) {
                    $cellContent = CreateDocx::translateTableOptions2StandardFormat($cellContent);
                    $this->cleanTemplateTrPr();
                    $this->generateTC();
                    $this->generateTCPR();
                    if ($rowNumber == 1 && isset($args[1]['size_col'])) {
                        if (is_array($args[1]['size_col']) &&
                            isset($args[1]['size_col'][$colNumber])) {
                            $this->generateTCW($args[1]['size_col'][$colNumber]);
                        } else if (!is_array($args[1]['size_col'])) {
                            $this->generateTCW($args[1]['size_col']);
                        }
                    } else {
                        if (isset($cellContent['width']) && is_int($cellContent['width'])) {
                            $this->generateCELLWIDTH($cellContent['width']);
                        }
                    }
                    if (isset($cellContent['colspan']) && $cellContent['colspan'] > 1) {
                        $this->generateCELLGRIDSPAN($cellContent['colspan']);
                    }
                    if (isset($cellContent['rowspan']) && $cellContent['rowspan'] >= 1) {
                        if (isset($cellContent['vmerge']) && $cellContent['vmerge'] == 'continue') {
                            $this->generateCELLVMERGE('continue');
                        } else {
                            $this->generateCELLVMERGE('restart');
                        }
                    }
                    //we set the drawCellBorders to false
                    $drawCellBorders = false;
                    $border = [];

                    //Run over the general border properties
                    if (isset($cellContent['border'])) {
                        $drawCellBorders = true;
                        foreach (self::$_borders as $key => $value) {
                            $border[$value]['type'] = $cellContent['border'];
                        }
                    }
                    if (isset($cellContent['border_color'])) {
                        $drawCellBorders = true;
                        foreach (self::$_borders as $key => $value) {
                            $border[$value]['color'] = $cellContent['border_color'];
                        }
                    }
                    if (isset($cellContent['border_spacing'])) {
                        $drawCellBorders = true;
                        foreach (self::$_borders as $key => $value) {
                            $border[$value]['spacing'] = $cellContent['border_spacing'];
                        }
                    }
                    if (isset($cellContent['border_sz'])) {
                        $drawCellBorders = true;
                        foreach (self::$_borders as $key => $value) {
                            $border[$value]['sz'] = $cellContent['border_sz'];
                        }
                    }
                    //Run over the border choices of each side
                    foreach (self::$_borders as $key => $value) {
                        if (isset($cellContent['border_' . $value])) {
                            $drawCellBorders = true;
                            $border[$value]['type'] = $cellContent['border_' . $value];
                        }
                        if (isset($cellContent['border_' . $value . '_color'])) {
                            $drawCellBorders = true;
                            $border[$value]['color'] = $cellContent['border_' . $value . '_color'];
                        }
                        if (isset($cellContent['border_' . $value . '_spacing'])) {
                            $drawCellBorders = true;
                            $border[$value]['spacing'] = $cellContent['border_' . $value . '_spacing'];
                        }
                        if (isset($cellContent['border_' . $value . '_sz'])) {
                            $drawCellBorders = true;
                            $border[$value]['sz'] = $cellContent['border_' . $value . '_sz'];
                        }
                    }
                    if ($drawCellBorders) {
                        $this->generateCELLBORDER($border);
                    }
                    if (isset($cellContent['background_color'])) {
                        $this->generateCELLSHD($cellContent['background_color']);
                    }
                    if (isset($cellContent['noWrap'])) {
                        $this->generateCELLNOWRAP($cellContent['noWrap']);
                    }
                    if (isset($cellContent['cellMargin']) && is_array($cellContent['cellMargin'])) {
                        $this->generateCELLMARGIN($cellContent['cellMargin']);
                    } else if (isset($cellContent['cellMargin']) && !is_array($cellContent['cellMargin'])) {
                        $cellContent['cellMargins']['top'] = $cellContent['cellMargin'];
                        $cellContent['cellMargins']['left'] = $cellContent['cellMargin'];
                        $cellContent['cellMargins']['bottom'] = $cellContent['cellMargin'];
                        $cellContent['cellMargins']['right'] = $cellContent['cellMargin'];
                        $this->generateCELLMARGIN($cellContent['cellMargins']);
                    }
                    if (isset($cellContent['textDirection'])) {
                        $this->generateCELLTEXTDIRECTION($cellContent['textDirection']);
                    }
                    if (isset($cellContent['fitText'])) {
                        $this->generateCELLFITTEXT($cellContent['fitText']);
                    }
                    if (isset($cellContent['vAlign'])) {
                        $this->generateCELLVALIGN($cellContent['vAlign']);
                    }
                    $this->cleanTemplateTcPr();

                    /* if ($cellContent['value'] instanceof CreateText) {
                      if (!empty($cellContent['value']->_embeddedText[0]['cell_color'])) {
                      $this->generateSHD(
                      'solid',
                      $cellContent['value']->_embeddedText[0]['cell_color']
                      );
                      }
                      } else {
                      $this->generateSHD();
                      } */
                    if ($cellContent['value'] instanceof WordFragment || $cellContent['value'] instanceof DOCPathResult) {
                        $this->_xml = str_replace('__GENERATETC__', (string) $cellContent['value'], $this->_xml);
                    } else {
                        $this->generateP($cellContent['value'], $args[1]);
                    }
                    $colNumber++;
                }
                $this->cleanTemplateR();
            }
        }
    }

    /**
     * Add list
     *
     * @param string $list
     * @access protected
     */
    protected function addList($list)
    {
        $this->_xml = str_replace('__GENERATEP__', $list, $this->_xml);
    }

    /**
     * Generate w:cantSplit
     *
     * @param string $val
     * @access protected
     */
    protected function generateTRCANTSPLIT($val = 'true')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD . ':cantSplit w:val="' . $val . '"/>__GENERATETRPR__';
        $this->_xml = str_replace('__GENERATETRPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:tcBorders
     *
     * @param array $border
     * @access protected
     */
    protected function generateCELLBORDER($border)
    {
        $xml = '<w:tcBorders>';
        foreach (self::$_borders as $key => $value) {
            if (isset($border[$value])) {
                if (isset($border[$value]['type'])) {
                    $border_type = $border[$value]['type'];
                } else {
                    $border_type = 'single';
                }
                if (isset($border[$value]['color'])) {
                    $border_color = $border[$value]['color'];
                } else {
                    $border_color = '000000';
                }
                if (isset($border[$value]['sz'])) {
                    $border_sz = $border[$value]['sz'];
                } else {
                    $border_sz = 6;
                }
                if (isset($border[$value]['spacing'])) {
                    $border_spacing = $border[$value]['spacing'];
                } else {
                    $border_spacing = 0;
                }
                $xml .= '<w:' . $value . ' w:val="' . $border_type . '" w:color="' . $border_color . '" w:sz="' . $border_sz . '" w:space="' . $border_spacing . '"/>';
            }
        }
        $xml .= '</w:tcBorders>__GENERATETCPR__';
        $this->_xml = str_replace('__GENERATETCPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:gridSpan
     *
     * @param string $val
     * @access protected
     */
    protected function generateCELLGRIDSPAN($val)
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':gridSpan ' . CreateElement::NAMESPACEWORD . ':val="' . $val . '"/>__GENERATETCPR__';
        $this->_xml = str_replace('__GENERATETCPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:tcMar
     *
     * @param array $cellMargin
     * @access protected
     */
    protected function generateCELLMARGIN($cellMargin)
    {
        $sides = ['top', 'left', 'bottom', 'right'];
        $xml = '<w:tcMar>';
        foreach ($cellMargin as $key => $value) {
            if (in_array($key, $sides)) {
                $xml .= '<w:' . $key . ' w:w="' . $value . '" w:type="dxa" />';
            }
        }
        $xml .= '</w:tcMar>__GENERATETCPR__';
        $this->_xml = str_replace('__GENERATETCPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:noWrap
     *
     * @param string $val
     * @access protected
     */
    protected function generateCELLNOWRAP($val)
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':noWrap ' . CreateElement::NAMESPACEWORD . ':val="' . $val . '"/>__GENERATETCPR__';
        $this->_xml = str_replace('__GENERATETCPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:shd
     *
     * @param string $color
     * @access protected
     */
    protected function generateCELLSHD($color)
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':shd  w:val ="clear" w:fill="' . $color . '"/>__GENERATETCPR__';
        $this->_xml = str_replace('__GENERATETCPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:tcFitText
     *
     * @param string $val
     * @access protected
     */
    protected function generateCELLFITTEXT($val)
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':tcFitText ' . CreateElement::NAMESPACEWORD . ':val="' . $val . '"/>__GENERATETCPR__';
        $this->_xml = str_replace('__GENERATETCPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:textDirection
     *
     * @param string $val
     * @access protected
     */
    protected function generateCELLTEXTDIRECTION($val)
    {
        $textDirections = ['btLr', 'tbRl', 'lrTb', 'tbRl', 'btLr', 'lrTbV', 'tbRlV', 'tbLrV'];
        if (in_array($val, $textDirections)) {
            $xml = '<' . CreateElement::NAMESPACEWORD .
                ':textDirection ' . CreateElement::NAMESPACEWORD . ':val="' . $val . '"/>__GENERATETCPR__';
            $this->_xml = str_replace('__GENERATETCPR__', $xml, $this->_xml);
        }
    }

    /**
     * Generate w:vAlign
     *
     * @param string $val
     * @access protected
     */
    protected function generateCELLVALIGN($val)
    {
        $valign = ['top', 'center', 'both', 'bottom'];
        if (in_array($val, $valign)) {
            $xml = '<' . CreateElement::NAMESPACEWORD .
                ':vAlign ' . CreateElement::NAMESPACEWORD . ':val="' . $val . '"/>__GENERATETCPR__';
            $this->_xml = str_replace('__GENERATETCPR__', $xml, $this->_xml);
        }
    }

    /**
     * Generate w:vmerge
     *
     * @param string $val
     * @access protected
     */
    protected function generateCELLVMERGE($val)
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':vMerge ' . CreateElement::NAMESPACEWORD . ':val="' . $val . '"/>__GENERATETCPR__';
        $this->_xml = str_replace('__GENERATETCPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:vmerge
     *
     * @param string $val
     * @access protected
     */
    protected function generateCELLWIDTH($val)
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':tcW ' . CreateElement::NAMESPACEWORD . ':w="' . $val . '" w:type="dxa" />__GENERATETCPR__';
        $this->_xml = str_replace('__GENERATETCPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:gridcols
     *
     * @param string $w
     * @access protected
     */
    protected function generateGRIDCOLS($w)
    {
        $xml = '<' . CreateElement::NAMESPACEWORD . ':tblGrid ' .
            CreateElement::NAMESPACEWORD . ':w="' . $w . '"></' .
            CreateElement::NAMESPACEWORD . ':tblGrid>__GENERATEGRIDCOLS__';
        $this->_xml = str_replace('__GENERATEGRIDCOLS__', $xml, $this->_xml);
    }

    /**
     * Generate w:gridcol
     *
     * @access protected
     */
    protected function generateGRIDCOL($width = '')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD . ':gridCol';
        if (!empty($width)) {
            $xml .= ' w:w="' . $width . '" ';
        }
        $xml .= '/>__GENERATEGRIDCOL__';
        $this->_xml = str_replace('__GENERATEGRIDCOL__', $xml, $this->_xml);
    }

    /**
     * Generate w:hmerge
     *
     * @access protected
     * @deprecated
     * @param string $val
     */
    protected function generateHMERGE($val = '')
    {

    }

    /**
     * Generate w:jc
     *
     * @param string $val
     * @access protected
     */
    protected function generateJC($val = '')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD . ':jc ' .
            CreateElement::NAMESPACEWORD . ':val="' . $val . '"></' .
            CreateElement::NAMESPACEWORD . ':jc>';
        $this->_xml = str_replace('__GENERATEJC__', $xml, $this->_xml);
    }

    /**
     * Generate w:p
     *
     * @access protected
     */
    protected function generateP($value, $options)
    {
        $xmlWF = new WordFragment();
        $xmlWF->addText($value, $options['textProperties']);
        $xml = (string) $xmlWF;
        $this->_xml = str_replace('__GENERATETC__', $xml, $this->_xml);
    }

    /**
     * Generate w:shd
     *
     * @param string $val
     * @param string $color
     * @param string $fill
     * @param string $bgcolor
     * @param string $themeFill
     * @access protected
     */
    protected function generateSHD($val = 'horz-cross', $color = 'ff0000', $fill = '', $bgcolor = '', $themeFill = '')
    {
        $xmlAux = '<' . CreateElement::NAMESPACEWORD . ':shd w:val="' .
            $val . '"';
        if ($color != '')
            $xmlAux .= ' w:color="' . $color . '"';
        if ($fill != '')
            $xmlAux .= ' w:fill="' . $fill . '"';
        if ($bgcolor != '')
            $xmlAux .= ' wx:bgcolor="' . $bgcolor . '"';
        if ($themeFill != '')
            $xmlAux .= ' w:themeFill="' . $themeFill . '"';
        $xmlAux .= '></' . CreateElement::NAMESPACEWORD . ':shd>';
        $this->_xml = str_replace('__GENERATETCPR__', $xmlAux, $this->_xml);
    }

    /**
     * Generate w:tableLayout
     *
     * @param string $val
     * @access protected
     */
    protected function generateTBLLAYOUT($val = 'autofit')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD . ':tblLayout ' .
            CreateElement::NAMESPACEWORD . ':val="' . $val . '"></' .
            CreateElement::NAMESPACEWORD . ':tblLayout>';
        $this->_xml = str_replace('__GENERATETBLLAYOUT__', $xml, $this->_xml);
    }

    /**
     * Generate w:bidiVisual
     *
     * @param array $float
     * @access protected
     */
    protected function generateTBLBIDI($val)
    {
        $xml = '<w:bidiVisual w:val="' . $val . '" />';
        $this->_xml = str_replace('__GENERATETBLBIDI__', $xml, $this->_xml);
    }

    /**
     * Generate w:tblborders
     *
     * @access protected
     */
    protected function generateTBLBORDERS()
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':tblBorders>__GENERATETBLBORDER__</' .
            CreateElement::NAMESPACEWORD . ':tblBorders>';
        $this->_xml = str_replace('__GENERATETBLBORDERS__', $xml, $this->_xml);
    }

    /**
     * Generate w:tblbottom
     *
     * @param string $val
     * @param string $sz
     * @param string $space
     * @param string $color
     * @access protected
     */
    protected function generateTBLBOTTOM($val = "single", $sz = "4", $space = '0', $color = 'auto')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':bottom ' . CreateElement::NAMESPACEWORD .
            ':val="' . $val . '" ' . CreateElement::NAMESPACEWORD .
            ':sz="' . $sz . '" ' . CreateElement::NAMESPACEWORD .
            ':space="' . $space . '" ' . CreateElement::NAMESPACEWORD .
            ':color="' . $color . '"></' . CreateElement::NAMESPACEWORD .
            ':bottom>__GENERATETBLBORDER__';
        $this->_xml = str_replace('__GENERATETBLBORDER__', $xml, $this->_xml);
    }

    /**
     * Generate w:tbl
     *
     * @access protected
     */
    protected function generateTBL()
    {
        $this->_xml = '<' . CreateElement::NAMESPACEWORD .
            ':tbl>__GENERATETBL__</' . CreateElement::NAMESPACEWORD .
            ':tbl>';
    }

    /**
     * Generate w:tblpPr
     *
     * @param array $float
     * @access protected
     */
    protected function generateTBLFLOAT($float)
    {
        $margin = [];
        foreach (self::$_borders as $value) {
            if (isset($float['textMargin_' . $value])) {
                $margin[$value] = (int) $float['textMargin_' . $value];
            } else {
                $margin[$value] = 0;
            }
        }
        if (isset($float['align'])) {
            $align = $float['align'];
        } else {
            $align = 'left';
        }

        $xml = '<' . CreateElement::NAMESPACEWORD . ':tblpPr ';
        $xml .= 'w:leftFromText="' . $margin['left'] . '" ';
        $xml .= 'w:rightFromText="' . $margin['right'] . '" ';
        $xml .= 'w:topFromText="' . $margin['top'] . '" ';
        $xml .= 'w:bottomFromText="' . $margin['bottom'] . '" ';
        $xml .= 'w:vertAnchor="text" w:horzAnchor ="margin" ';
        $xml .= 'w:tblpXSpec ="' . $align . '" w:tblpYSpec="inside" />';

        $this->_xml = str_replace('__GENERATETBLFLOAT__', $xml, $this->_xml);
        //exit($this->_xml);
    }

    /**
     * Generate w:tblstyle
     *
     * @param string $strVal
     * @access protected
     */
    protected function generateTBLSTYLE($strVal = 'TableGridPHPDOCX')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':tblStyle ' . CreateElement::NAMESPACEWORD .
            ':val="' . $strVal . '"></' . CreateElement::NAMESPACEWORD .
            ':tblStyle>';
        $this->_xml = str_replace('__GENERATETBLSTYLE__', $xml, $this->_xml);
        //exit($this->_xml);
    }

    /**
     * Generate w:tblcellspacing
     *
     * @param string $w
     * @param string $type
     * @access protected
     */
    protected function generateTBLCELLSPACING($w = '', $type = 'dxa')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':tblCellSpacing ' . CreateElement::NAMESPACEWORD .
            ':w="' . $w . '" ' . CreateElement::NAMESPACEWORD .
            ':type="' . $type . '"></' . CreateElement::NAMESPACEWORD .
            ':tblCellSpacing>';
        $this->_xml = str_replace(
            '__GENERATETBLCELLSPACING__', $xml, $this->_xml
        );
    }

    /**
     * Generate w:tblInd
     *
     * @param string $w
     * @param string $type
     * @access protected
     */
    protected function generateTBLINDENT($w = '', $type = 'dxa')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':tblInd ' . CreateElement::NAMESPACEWORD .
            ':w="' . $w . '" ' . CreateElement::NAMESPACEWORD .
            ':type="' . $type . '"></' . CreateElement::NAMESPACEWORD .
            ':tblInd>';
        $this->_xml = str_replace(
            '__GENERATETBLINDENT__', $xml, $this->_xml
        );
    }

    /**
     * Generate w:tblCellMar
     *
     * @param array $cellMargin
     * @access protected
     */
    protected function generateTBLCELLMARGIN($cellMargin)
    {
        if (!is_array($cellMargin)) {
            $cellMargins['top'] = $cellMargin;
            $cellMargins['left'] = $cellMargin;
            $cellMargins['bottom'] = $cellMargin;
            $cellMargins['right'] = $cellMargin;
        } else {
            $cellMargins = $cellMargin;
        }
        $sides = ['top', 'left', 'bottom', 'right'];
        $xml = '<w:tblCellMar>';
        foreach ($cellMargins as $key => $value) {
            if (in_array($key, $sides)) {
                $xml .= '<w:' . $key . ' w:w="' . $value . '" w:type="dxa" />';
            }
        }
        $xml .= '</w:tblCellMar>';
        $this->_xml = str_replace(
            '__GENERATETBLCELLMARGINS__', $xml, $this->_xml
        );
    }

    /**
     * Generate w:tblgrid
     *
     * @access protected
     */
    protected function generateTBLGRID()
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':tblGrid>__GENERATEGRIDCOL__</' .
            CreateElement::NAMESPACEWORD .
            ':tblGrid>__GENERATETBL__';
        $this->_xml = str_replace('__GENERATETBL__', $xml, $this->_xml);
    }

    /**
     * Generate w:tblinsideh
     *
     * @param string $val
     * @param string $sz
     * @param string $space
     * @param string $color
     * @access protected
     */
    protected function generateTBLINSIDEH($val = "single", $sz = "4", $space = '0', $color = 'auto')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':insideH ' . CreateElement::NAMESPACEWORD .
            ':val="' . $val . '" ' . CreateElement::NAMESPACEWORD .
            ':sz="' . $sz . '" ' . CreateElement::NAMESPACEWORD .
            ':space="' . $space . '" ' . CreateElement::NAMESPACEWORD .
            ':color="' . $color . '"></' . CreateElement::NAMESPACEWORD .
            ':insideH>__GENERATETBLBORDER__';
        $this->_xml = str_replace('__GENERATETBLBORDER__', $xml, $this->_xml);
    }

    /**
     * Generate w:tblinsidev
     *
     * @param string $val
     * @param string $sz
     * @param string $space
     * @param string $color
     * @access protected
     */
    protected function generateTBLINSIDEV($val = "single", $sz = "4", $space = '0', $color = 'auto')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD . ':insideV ' .
            CreateElement::NAMESPACEWORD . ':val="' . $val . '" ' .
            CreateElement::NAMESPACEWORD . ':sz="' . $sz . '" ' .
            CreateElement::NAMESPACEWORD . ':space="' . $space . '" ' .
            CreateElement::NAMESPACEWORD . ':color="' . $color . '"></' .
            CreateElement::NAMESPACEWORD . ':insideV>__GENERATETBLBORDER__';
        $this->_xml = str_replace('__GENERATETBLBORDER__', $xml, $this->_xml);
    }

    /**
     * Generate w:tblleft
     *
     * @param string $val
     * @param string $sz
     * @param string $space
     * @param string $color
     * @access protected
     */
    protected function generateTBLLEFT($val = "single", $sz = "4", $space = '0', $color = 'auto')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD . ':left ' .
            CreateElement::NAMESPACEWORD . ':val="' . $val . '" ' .
            CreateElement::NAMESPACEWORD . ':sz="' . $sz . '" ' .
            CreateElement::NAMESPACEWORD . ':space="' . $space . '" ' .
            CreateElement::NAMESPACEWORD . ':color="' . $color . '"></' .
            CreateElement::NAMESPACEWORD . ':left>__GENERATETBLBORDER__';
        $this->_xml = str_replace('__GENERATETBLBORDER__', $xml, $this->_xml);
    }

    /**
     * Generate w:tblLook
     *
     * @param array $conditionalFormatting
     * @access protected
     */
    protected function generateTBLLOOK($conditionalFormatting)
    {
        //0x0020=Apply first row conditional formatting
        //0x0040=Apply last row conditional formatting
        //0x0080=Apply first column conditional formatting
        //0x0100=Apply last column conditional formatting
        //0x0200=Do not apply row banding conditional formatting
        //0x0400=Do not apply column banding conditional formatting

        $mask = [];
        $mask['firstRow'] = 0x0020;
        $mask['lastRow'] = 0x0040;
        $mask['firstCol'] = 0x0080;
        $mask['lastCol'] = 0x0100;
        $mask['noHBand'] = 0x0200;
        $mask['noVBand'] = 0x0400;

        $result = 0;

        foreach ($conditionalFormatting as $key => $value) {
            if (!empty($value)) {
                $result |= $mask[$key];
            }
        }
        $valHex = dechex($result);
        if (strlen($valHex) == 1) {
            $val = '000' . (string) $valHex;
        } else if (strlen($valHex) == 2) {
            $val = '00' . (string) $valHex;
        } else if (strlen($valHex) == 3) {
            $val = '0' . (string) $valHex;
        } else if (strlen($valHex) == 4) {
            $val = (string) $valHex;
        }

        $xml = '<' . CreateElement::NAMESPACEWORD . ':tblLook ' .
            CreateElement::NAMESPACEWORD . ':val="' . $val . '" ></' .
            CreateElement::NAMESPACEWORD . ':tblLook>';
        $this->_xml = str_replace('__GENERATETBLLOOK__', $xml, $this->_xml);
    }

    /**
     * Generate w:tbloverlap
     *
     * @param string $val
     * @access protected
     */
    protected function generateTBLOVERLAP($val = 'never')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD . ':tblOverlap ' .
            CreateElement::NAMESPACEWORD . ':val="' . $val . '"></' .
            CreateElement::NAMESPACEWORD . ':tblOverlap>';
        $this->_xml = str_replace('__GENERATETBLOVERLAP__', $xml, $this->_xml);
    }

    /**
     * Generate w:tblpr
     *
     * @access protected
     */
    protected function generateTBLPR()
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':tblPr>__GENERATETBLSTYLE____GENERATETBLFLOAT____GENERATETBLOVERLAP____GENERATETBLBIDI____GENERATETBLW__' .
            '__GENERATEJC____GENERATETBLCELLSPACING____GENERATETBLINDENT__' .
            '__GENERATETBLBORDERS____GENERATESHD____GENERATETBLLAYOUT____GENERATETBLCELLMARGINS__' .
            '__GENERATETBLLOOK__</' .
            CreateElement::NAMESPACEWORD . ':tblPr>__GENERATETBL__';
        $this->_xml = str_replace('__GENERATETBL__', $xml, $this->_xml);
    }

    /**
     * Generate w:tblright
     *
     * @param string $val
     * @param string $sz
     * @param string $space
     * @param string $color
     * @access protected
     */
    protected function generateTBLRIGHT($val = 'single', $sz = '4', $space = '0', $color = 'auto')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD . ':right ' .
            CreateElement::NAMESPACEWORD . ':val="' . $val . '" ' .
            CreateElement::NAMESPACEWORD . ':sz="' . $sz . '" ' .
            CreateElement::NAMESPACEWORD . ':space="' . $space . '" ' .
            CreateElement::NAMESPACEWORD . ':color="' . $color . '"></' .
            CreateElement::NAMESPACEWORD . ':right>__GENERATETBLBORDER__';
        $this->_xml = str_replace('__GENERATETBLBORDER__', $xml, $this->_xml);
    }

    /**
     * Generate w:tbltop
     *
     * @param string $val
     * @param string $sz
     * @param string $space
     * @param string $color
     * @access protected
     */
    protected function generateTBLTOP($val = 'single', $sz = '4', $space = '0', $color = 'auto')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD . ':top ' .
            CreateElement::NAMESPACEWORD . ':val="' . $val . '" ' .
            CreateElement::NAMESPACEWORD . ':sz="' . $sz . '" ' .
            CreateElement::NAMESPACEWORD . ':space="' . $space . '" ' .
            CreateElement::NAMESPACEWORD . ':color="' . $color . '"></' .
            CreateElement::NAMESPACEWORD . ':top>__GENERATETBLBORDER__';
        $this->_xml = str_replace('__GENERATETBLBORDER__', $xml, $this->_xml);
    }

    /**
     * Generate w:tblw
     *
     * @param string $type
     * @param string $w
     * @access protected
     */
    protected function generateTBLW($type, $value)
    {
        if ($type == 'pct') {
            $value = $value * 50;
        }
        $xml = '<' . CreateElement::NAMESPACEWORD . ':tblW ' .
            CreateElement::NAMESPACEWORD . ':w="' . $value . '" ' .
            CreateElement::NAMESPACEWORD . ':type="' . $type . '"></' .
            CreateElement::NAMESPACEWORD . ':tblW>';
        $this->_xml = str_replace('__GENERATETBLW__', $xml, $this->_xml);
    }

    /**
     * Generate w:tc
     *
     * @access protected
     */
    protected function generateTC()
    {
        $xml = '<' . CreateElement::NAMESPACEWORD . ':tc >__GENERATETC__</' .
            CreateElement::NAMESPACEWORD . ':tc>__GENERATETR__';
        $this->_xml = str_replace('__GENERATETR__', $xml, $this->_xml);
    }

    /**
     * Generate w:tcpr
     *
     * @access protected
     */
    protected function generateTCPR()
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':tcPr>__GENERATETCPR__</' . CreateElement::NAMESPACEWORD .
            ':tcPr>__GENERATETC__';
        $this->_xml = str_replace('__GENERATETC__', $xml, $this->_xml);
    }

    /**
     * Generate w:tcw
     *
     * @param string $w
     * @param string $type
     * @access protected
     */
    protected function generateTCW($w = '', $type = 'dxa')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD . ':tcW ' .
            CreateElement::NAMESPACEWORD . ':w="' . $w . '" ' .
            CreateElement::NAMESPACEWORD . ':type="' . $type . '"></' .
            CreateElement::NAMESPACEWORD . ':tcW>__GENERATETCPR__';
        $this->_xml = str_replace('__GENERATETCPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:tr
     *
     * @access protected
     */
    protected function generateTR()
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':tr >__GENERATETRPR____GENERATETR__</' .
            CreateElement::NAMESPACEWORD . ':tr>__GENERATETBL__';
        $this->_xml = str_replace('__GENERATETBL__', $xml, $this->_xml);
    }

    /**
     * Generate w:trheight
     *
     * @param int $height
     * @param string $hRule
     * @access protected
     */
    protected function generateTRHEIGHT($height = '', $hRule = 'auto')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD . ':trHeight ' .
            CreateElement::NAMESPACEWORD . ':val="' . (int) $height .
            '" w:hRule="' . $hRule . '"></' .
            CreateElement::NAMESPACEWORD . ':trHeight>__GENERATETRPR__';
        $this->_xml = str_replace('__GENERATETRPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:trpr
     *
     * @access protected
     */
    protected function generateTRPR()
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':trPr>__GENERATETRPR__</' . CreateElement::NAMESPACEWORD .
            ':trPr>';
        $this->_xml = str_replace('__GENERATETRPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:tblHeader
     *
     * @access protected
     */
    protected function generateTRTABLEHEADER()
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
            ':tblHeader />__GENERATETRPR__';
        $this->_xml = str_replace('__GENERATETRPR__', $xml, $this->_xml);
    }

    /**
     * Clean template r token
     *
     * @access private
     */
    private function cleanTemplateR()
    {
        $this->_xml = preg_replace('/__GENERATETR__/', '', $this->_xml);
    }

    /**
     * Clean template trpr token
     *
     * @access private
     */
    private function cleanTemplateTrPr()
    {
        $this->_xml = preg_replace('/__GENERATETRPR__/', '', $this->_xml);
    }

    /**
     * Clean template trpr token
     *
     * @access private
     */
    private function cleanTemplateTcPr()
    {
        $this->_xml = preg_replace('/__GENERATETCPR__/', '', $this->_xml);
    }

    /**
     * Prepares the table data for insertion
     * @param array $tableData
     * @access private
     */
    private function parseTableData($tableData)
    {
        $parsedData = [];
        $colCount = [];
        foreach ($tableData as $rowNumber => $row) {
            $parsedData[$rowNumber] = [];
            $colNumber = 0;
            foreach ($row as $col => $cell) {
                //Check if in the previous row there was a cell with rowspan > 1
                while (isset($parsedData[$rowNumber - 1][$colNumber]['rowspan']) &&
                    $parsedData[$rowNumber - 1][$colNumber]['rowspan'] > 1) {
                    //replicate the array
                    $parsedData[$rowNumber][$colNumber] = $parsedData[$rowNumber - 1][$colNumber];
                    //reduce by one the rowspan
                    $parsedData[$rowNumber][$colNumber]['rowspan'] = $parsedData[$rowNumber - 1][$colNumber]['rowspan'] - 1;
                    //set up the vmerge and content values
                    $parsedData[$rowNumber][$colNumber]['vmerge'] = 'continue';
                    $parsedData[$rowNumber][$colNumber]['value'] = NULL;
                    if (isset($parsedData[$rowNumber - 1][$colNumber]['colspan'])) {
                        $colNumber += $parsedData[$rowNumber - 1][$colNumber]['colspan'];
                    } else {
                        $colNumber++;
                    }
                }
                if (is_array($cell)) {
                    $parsedData[$rowNumber][$colNumber] = $cell;
                } else {
                    $parsedData[$rowNumber][$colNumber]['value'] = $cell;
                }
                if (isset($parsedData[$rowNumber][$colNumber]['colspan'])) {
                    $colNumber += $parsedData[$rowNumber][$colNumber]['colspan'];
                } else {
                    $colNumber++;
                }
            }
            //check that there are no trailing rawspans after running through all cols
            if ($rowNumber > 0) {
                $colDiff = $colCount[$rowNumber - 1] - $colNumber;
                if ($colDiff > 0) {
                    for ($k = 0; $k < $colDiff; $k++) {
                        //Check if in the previous row there was a cell with rowspan > 1
                        while (isset($parsedData[$rowNumber - 1][$colNumber]['rowspan']) &&
                            $parsedData[$rowNumber - 1][$colNumber]['rowspan'] > 1) {
                            //replicate the array
                            $parsedData[$rowNumber][$colNumber] = $parsedData[$rowNumber - 1][$colNumber];
                            //reduce by one the rowspan
                            $parsedData[$rowNumber][$colNumber]['rowspan'] = $parsedData[$rowNumber - 1][$colNumber]['rowspan'] - 1;
                            //set up the vmerge and content values
                            $parsedData[$rowNumber][$colNumber]['vmerge'] = 'continue';
                            $parsedData[$rowNumber][$colNumber]['value'] = NULL;
                            if (isset($parsedData[$rowNumber - 1][$colNumber]['colspan'])) {
                                $colNumber += $parsedData[$rowNumber - 1][$colNumber]['colspan'];
                            } else {
                                $colNumber++;
                            }
                        }
                    }
                }
            }
            $colCount[$rowNumber] = $colNumber;
        }
        return $parsedData;
    }

}
class Repair
{

    /**
     *
     * @access private
     * @var string
     */
    private static $_instance = NULL;

    /**
     *
     * @access private
     * @var array
     */
    private $_xml = [];

    /**
     * Construct
     *
     * @access private
     */
    private function __construct()
    {

    }

    /**
     * Destruct
     *
     * @access public
     */
    public function __destruct()
    {

    }

    /**
     * Magic method, returns current XML
     *
     * @access public
     * @return string Return current XML
     */
    public function __toString()
    {
        return $this->_xml;
    }

    /**
     * Singleton, return instance of class
     *
     * @access public
     * @return CreateText
     * @static
     */
    public static function getInstance()
    {
        if (self::$_instance == NULL) {
            self::$_instance = new Repair();
        }
        return self::$_instance;
    }

    /**
     * Getter XML
     *
     * @access public
     */
    public function getXML()
    {
        return $this->_xml;
    }

    /**
     * Setter XML
     *
     * @access public
     */
    public function setXML($xml)
    {
        $this->_xml = $xml;
    }

    /**
     * Add a paragraph to each element in a table that needs it and betweeen
     * tables
     *
     * @access public
     * @param  $path File path
     */
    public function addParapraphEmptyTablesTags()
    {
        // add parapraph to <w:tc></w:tc>
        $this->_xml = preg_replace('/<w:tc>[\s]*?<\/w:tc>/', '<w:tc><w:p /></w:tc>', $this->_xml);

        // add parapraph to </w:tbl></w:tc>
        $this->_xml = preg_replace('/<\/w:tbl>[\s]*?<\/w:tc>/', '</w:tbl><w:p /></w:tc>', $this->_xml);

        // add parapraph to </w:tbl><w:tbl>
        $this->_xml = preg_replace('/<\/w:tbl>[\s]*?<w:tbl>/', '</w:tbl><w:p /><w:tbl>', $this->_xml);
    }

    /**
     * Add a paragraph to each element in a table that needs it and betweeen
     * tables
     *
     * @access public
     * @param  $docXML string
     * @static
     */
    public static function repairTablesPDFConversion($docXML)
    {
        $docDOM = new DOMDocument();
        $docDOM->loadXML($docXML);
        $tblNodes = $docDOM->getElementsByTagName('tbl');
        foreach ($tblNodes as $tblNode) {
            //0. Check if there is a table grid element with well defined vals
            $repairTable = false;
            $tblGridNodes = $tblNode->getElementsByTagName('tblGrid');
            if ($tblGridNodes->length > 0) {
                $gridColNodes = $tblGridNodes->item(0)->getElementsByTagName('gridCol');
                foreach ($gridColNodes as $gridNode) {
                    $wAttribute = $gridNode->getAttribute('w:w');
                    if (empty($wAttribute)) {
                        $repairTable = true;
                    }
                }
            } else {
                $repairTable = true;
            }
            //1. Determine the total table width
            $tblWNodes = $tblNode->getElementsByTagName('tblW');
            if ($tblWNodes->length > 0) {
                //check if the width is given in twips
                $widthUnits = $tblWNodes->item(0)->getAttribute('w:type');
                if ($widthUnits == 'dxa') {
                    $tableWidth = $tblWNodes->item(0)->getAttribute('w:w');
                } else {
                    $tableWidth = false;
                    PhpdocxLogger::logger('For proper conversion to PDF, tables may not have their width set in percentage.', 'info');
                }
            } else {
                $tableWidth = false;
                PhpdocxLogger::logger('For proper conversion to PDF, tables have to have their width set.', 'info');
            }
            if (!empty($tableWidth) && $repairTable) {
                //2. Extract the rows
                $tableRows = $tblNode->getElementsByTagName('tr');
                $rowNumber = 0;
                $grid = [];
                foreach ($tableRows as $row) {
                    $grid[$rowNumber] = [];
                    $weights[$rowNumber] = [];
                    //3. Extract the cells of each row
                    $cellNodes = $row->getElementsByTagName('tc');
                    foreach ($cellNodes as $cellNode) {
                        $gridSpan = 1;
                        $spanNodes = $cellNode->getElementsByTagName('gridSpan');
                        if ($spanNodes->length > 0) {
                            $span = $spanNodes->item(0)->getAttribute('w:val');
                            if (isset($span) && $span > 1) {
                                $gridSpan = $span;
                            }
                        }
                        $tcWidths = $cellNode->getElementsByTagName('tcW');
                        if ($tcWidths->length > 0) {
                            $widthData = $tcWidths->item(0)->getAttribute('w:w');
                            $widthUnits = $tcWidths->item(0)->getAttribute('w:type');
                            if ($widthUnits == 'dxa') {
                                $cellWidth = $widthData;
                            } else if ($widthUnits == 'pct') {
                                //the width is given in fitieths of a percent
                                $cellWidth = floor($widthData * $tableWidth / 5000);
                            } else {
                                $cellWidth = 0;
                            }
                        } else {
                            $cellWidth = 0;
                        }
                        //let us build the grid and weight arrays for this cell
                        if ($gridSpan > 1) {
                            $cellWidth = floor($cellWidth / $gridSpan);
                            for ($j = 0; $j < $gridSpan; $j++) {
                                $grid[$rowNumber][] = $cellWidth;
                                $weights[$rowNumber][] = 0;
                            }
                        } else {
                            $grid[$rowNumber][] = $cellWidth;
                            $weights[$rowNumber][] = 1;
                        }
                    }
                    $rowNumber++;
                }
                //we have now all the required info to build the gridCol array
                $gridCol = [];
                $rowPos = 0;
                foreach ($grid as $row) {
                    $cellPos = 0;
                    foreach ($row as $cell) {
                        if ($weights[$rowPos][$cellPos] == 1 && !empty($grid[$rowPos][$cellPos])) {
                            $gridCol[$cellPos] = $grid[$rowPos][$cellPos];
                        } else if ($weights[$rowPos][$cellPos] == 0 && !empty($grid[$rowPos][$cellPos]) && empty($gridCol[$cellPos])) {
                            $gridCol[$cellPos] = $grid[$rowPos][$cellPos];
                        }
                        $cellPos++;
                    }
                    $rowPos++;
                }
                //create the tblGrid node node and insert it
                $gridColXML = '<w:tblGrid xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">';
                foreach ($gridCol as $col) {
                    $gridColXML .= '<w:gridCol w:w="' . $col . '"/>';
                }
                $gridColXML .= '</w:tblGrid>';
                //remove any previous tblGrid elements if any
                $tblGridNodes = $tblNode->getElementsByTagName('tblGrid');
                if ($tblGridNodes->length > 0) {
                    $tblGridNodes->item(0)->parentNode->removeChild($tblGridNodes->item(0));
                }
                //insert this node just before the first tr node
                $firstRow = $tblNode->getElementsByTagName('tr')->item(0);
                $gridFragment = $docDOM->createDocumentFragment();
                $gridFragment->appendXML($gridColXML);
                $tblNode->insertBefore($gridFragment, $firstRow);
            }
        }
        return $docDOM->saveXML();
    }

    /**
     * Modifies the DOCXPath selections to avoid validation issues
     *
     * @access public
     * @param  DOMNode $node
     * @static
     */
    public static function repairDOCXPath($node)
    {
        //modifies the id attribute of the wp:docPr tag to avoid potential conflicts
        $docPrNodes = $node->getElementsByTagName('docPr');
        foreach ($docPrNodes as $docPrNode) {
            $docPrNode->setAttribute('id', rand(999999, 99999999));
        }
        return $node;
    }

}

interface EmbedDocument
{

    /**
     * Return current Id.
     *
     * @abstract
     * @return void
     */
    function getId();

    /**
     * Embed content or file.
     *
     * @abstract
     * @return void
     */
    function embed($matchSource = null);

    /**
     * Generate w:altChunk.
     *
     * @abstract
     * @return void
     */
    function generateALTCHUNK($matchSource = null);
}

class EmbedDOCX extends CreateElement implements EmbedDocument
{

    /**
     *
     * @access private
     * @var int
     */
    private $_id = 0;

    /**
     *
     * @access private
     * @var string
     */
    private static $_instance = NULL;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_xml = '';

    /**
     * Construct
     *
     * @access public
     */
    public function __construct()
    {

    }

    /**
     * Destruct
     *
     * @access public
     */
    public function __destruct()
    {

    }

    /**
     * Magic method, returns current XML
     *
     * @access public
     * @return string Return current XML
     */
    public function __toString()
    {
        return $this->_xml;
    }

    /**
     * Singleton, return instance of class
     *
     * @access public
     * @return CreateText
     * @static
     */
    public static function getInstance()
    {
        if (self::$_instance == NULL) {
            self::$_instance = new EmbedDOCX();
        }
        return self::$_instance;
    }

    /**
     * Getter. Return current HTML ID
     *
     * @access public
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Embed HTML in DOCX
     *
     * @param bool $matchSource
     * @access public
     */
    public function embed($matchSource = false)
    {
        $this->_xml = '';
        $this->_id++;
        $this->generateALTCHUNK($matchSource);
    }

    /**
     * Generate w:altChunk
     *
     * @param bool $matchSource
     * @access protected
     */
    public function generateALTCHUNK($matchSource = false)
    {
        $this->_xml = '<' . CreateElement::NAMESPACEWORD .
            ':altChunk r:id="rDOCXId' . $this->_id . '" ' .
            'xmlns:r="http://schemas.openxmlformats.org/' .
            'officeDocument/2006/relationships" ' .
            'xmlns:w="http://schemas.openxmlformats.org/' .
            'wordprocessingml/2006/main" >';
        if ($matchSource) {
            $this->_xml .= '<w:altChunkPr><w:matchSrc/></w:altChunkPr>';
        }

        $this->_xml .= '</w:altChunk>';
    }

}

class WordFragment extends CreateDocx
{

    /**
     *
     * @access public
     * @var string
     */
    public $wordML;

    /**
     * Construct
     *
     * @param CreateDocx $docx
     * @param string $target document (default value), defaultHeader, firstHeader, evenHeader, defaultFooter, firstFooter, evenFooter, footnote, endnote, comment
     * @access public
     */
    public function __construct($docx = NULL, $target = 'document')
    {
        $this->wordML = '';
        $this->target = $target;
        if ($docx instanceof CreateDocx || $docx instanceof CreateDocxFromTemplate) {
            $this->_zipDocx = $docx->_zipDocx;
            $this->_contentTypeT = $docx->_contentTypeT;
            $this->_wordRelsDocumentRelsT = $docx->_wordRelsDocumentRelsT;
            $this->_wordFootnotesT = $docx->_wordFootnotesT;
            $this->_wordFootnotesRelsT = $docx->_wordFootnotesRelsT;
            $this->_wordEndnotesT = $docx->_wordEndnotesT;
            $this->_wordEndnotesRelsT = $docx->_wordEndnotesRelsT;
            $this->_wordCommentsT = $docx->_wordCommentsT;
            $this->_wordCommentsRelsT = $docx->_wordCommentsRelsT;
            $this->_wordNumberingT = &$docx->_wordNumberingT;
        }
    }

    /**
     * Destruct
     *
     * @access public
     */
    public function __destruct()
    {

    }

    /**
     * Magic method, returns current XML
     *
     * @access public
     * @return string Return current XML
     */
    public function __toString()
    {
        return $this->wordML;
    }

    /**
     * Adds a chunk of raw WordML
     *
     * @access public
     * @param string $data
     */
    public function addRawWordML($data)
    {
        $this->wordML .= $data;
    }

    /**
     * returns only the runs of content for embedding
     *
     * @access public
     * @param string $data
     */
    public function inlineWordML()
    {
        $namespaces = 'xmlns:ve="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" ';
        $wordML = '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?><w:root ' . $namespaces . '>' . $this->wordML;
        $wordML = $wordML . '</w:root>';
        $wordMLChunk = new DOMDocument();
        $wordMLChunk->loadXML($wordML);
        $wordMLXpath = new DOMXPath($wordMLChunk);
        $wordMLXpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $wordMLXpath->registerNamespace('m', 'http://schemas.openxmlformats.org/wordprocessingml/2006/math');
        $query = '//w:r[not(ancestor::w:hyperlink or ancestor::v:textbox)] | //w:hyperlink | //w:bookmarkStart | //w:bookmarkEnd | //w:commentRangeStart | //w:commentRangeEnd | //m:oMath';
        $wrNodes = $wordMLXpath->query($query);
        $blockCleaned = '';
        foreach ($wrNodes as $node) {
            $nodeR = $node->ownerDocument->saveXML($node);
            $blockCleaned .= $nodeR;
        }
        return $blockCleaned;
    }

}


class CreateText extends CreateElement
{

    const IDTITLE = 229998237;

    /**
     * @access private
     * @var array
     * @static
     */
    private static $_borders = ['top', 'left', 'bottom', 'right'];

    /**
     *
     * @access private
     * @var string
     */
    private static $_instance = NULL;

    /**
     *
     * @access private
     * @var int
     */
    private static $_idTitle = 0;

    /**
     * Construct
     *
     * @access public
     */
    public function __construct()
    {

    }

    /**
     * Destruct
     *
     * @access public
     */
    public function __destruct()
    {

    }

    /**
     * Magic method, returns current XML
     *
     * @access public
     * @return string Return current XML
     */
    public function __toString()
    {
        return $this->_xml;
    }

    /**
     * Singleton, return instance of class
     *
     * @access public
     * @return CreateText
     * @static
     */
    public static function getInstance()
    {
        if (self::$_instance == NULL) {
            self::$_instance = new CreateText();
        }
        return self::$_instance;
    }

    /**
     * Create text
     *
     * @access public
     * @param mixed $args[0]
     * @param array $args[1]
     */
    public function createText()
    {
        $this->_xml = '';
        $args = func_get_args();

        $args[1] = CreateDocx::translateTextOptions2StandardFormat($args[1]);

        $this->generateP();

        $this->generatePPR();
        if (!empty($args[1]['pStyle'])) {
            $this->generatePSTYLE($args[1]['pStyle']);
        }
        if (!empty($args[1]['keepNext'])) {
            $this->generateKEEPNEXT($args[1]['keepNext']);
        }
        if (!empty($args[1]['keepLines'])) {
            $this->generateKEEPLINES($args[1]['keepLines']);
        }
        if (!empty($args[1]['pageBreakBefore'])) {
            $this->generatePAGEBREAKBEFORE($args[1]['pageBreakBefore']);
        }
        if (!empty($args[1]['widowControl'])) {
            $this->generateWIDOWCONTROL($args[1]['widowControl']);
        }
        //we set the drawPBorders to false
        $drawPBorders = false;
        $border = [];

        //Run over the general border properties
        if (isset($args[1]['border'])) {
            $drawPBorders = true;
            foreach (self::$_borders as $key => $value) {
                $border[$value]['type'] = $args[1]['border'];
            }
        }
        if (isset($args[1]['border_color'])) {
            $drawPBorders = true;
            foreach (self::$_borders as $key => $value) {
                $border[$value]['color'] = $args[1]['border_color'];
            }
        }
        if (isset($args[1]['border_spacing'])) {
            $drawPBorders = true;
            foreach (self::$_borders as $key => $value) {
                $border[$value]['spacing'] = $args[1]['border_spacing'];
            }
        }
        if (isset($args[1]['border_sz'])) {
            $drawPBorders = true;
            foreach (self::$_borders as $key => $value) {
                $border[$value]['sz'] = $args[1]['border_sz'];
            }
        }
        //Run over the border choices of each side
        foreach (self::$_borders as $key => $value) {
            if (isset($args[1]['border_' . $value])) {
                $drawPBorders = true;
                $border[$value]['type'] = $args[1]['border_' . $value];
            }
            if (isset($args[1]['border_' . $value . '_color'])) {
                $drawPBorders = true;
                $border[$value]['color'] = $args[1]['border_' . $value . '_color'];
            }
            if (isset($args[1]['border_' . $value . '_spacing'])) {
                $drawPBorders = true;
                $border[$value]['spacing'] = $args[1]['border_' . $value . '_spacing'];
            }
            if (isset($args[1]['border_' . $value . '_sz'])) {
                $drawPBorders = true;
                $border[$value]['sz'] = $args[1]['border_' . $value . '_sz'];
            }
        }
        if ($drawPBorders) {
            $this->generatePBDR($border);
        }
        if (!empty($args[1]['backgroundColor'])) {
            $this->generatePPRSHD($args[1]['backgroundColor']);
        }
        if (!empty($args[1]['jc'])) {
            $this->generateJC($args[1]['jc']);
        }
        if (!empty($args[1]['tabPositions']) && is_array($args[1]['tabPositions'])) {
            $this->generateTABPOSITIONS($args[1]['tabPositions']);
        }
        if (!empty($args[1]['wordWrap'])) {
            $this->generateWORDWRAP($args[1]['wordWrap']);
        }
        if (!empty($args[1]['bidi'])) {
            $this->generateBIDI($args[1]['bidi']);
        }
        if (isset($args[1]['lineSpacing']) ||
            isset($args[1]['spacingTop']) ||
            isset($args[1]['spacingBottom'])) {
            if (!isset($args[1]['lineSpacing'])) {
                $args[1]['lineSpacing'] = 240;
            }
            if (!isset($args[1]['spacingTop'])) {
                $args[1]['spacingTop'] = '';
            }
            if (!isset($args[1]['spacingBottom'])) {
                $args[1]['spacingBottom'] = '';
            }
            $this->generateSPACING($args[1]['lineSpacing'], $args[1]['spacingTop'], $args[1]['spacingBottom']);
        }
        if (
            isset($args[1]['indent_left']) ||
            isset($args[1]['indent_right']) ||
            isset($args[1]['firstLineIndent']) ||
            isset($args[1]['hanging']
            )
        ) {
            $indentation = [];
            if (isset($args[1]['indent_left'])) {
                $indentation['left'] = $args[1]['indent_left'];
            }
            if (isset($args[1]['indent_right'])) {
                $indentation['right'] = $args[1]['indent_right'];
            }
            if (isset($args[1]['hanging'])) {
                $indentation['hanging'] = $args[1]['hanging'];
            }
            if (isset($args[1]['firstLineIndent'])) {
                $indentation['firstLine'] = $args[1]['firstLineIndent'];
            }


            $this->generateINDENT($indentation);
        }
        if (!empty($args[1]['contextualSpacing'])) {
            $this->generateCONTEXTUALSPACING($args[1]['contextualSpacing']);
        }
        if (!empty($args[1]['textDirection'])) {
            $this->generateTEXTDIRECTION($args[1]['textDirection']);
        }
        if (!empty($args[1]['headingLevel'])) {
            $this->generateHEADINGLEVEL($args[1]['headingLevel']);
        }
        //We include now paragraph wide run properties
        $this->generatePPRRPR();
        if (!empty($args[1]['rStyle'])) {
            $this->generateRSTYLE($args[1]['rStyle']);
        }
        if (!empty($args[1]['font'])) {
            $this->generateRFONTS($args[1]['font']);
        }
        if (!empty($args[1]['b'])) {
            $this->generateB($args[1]['b']);
        }
        if (!empty($args[1]['i'])) {
            $this->generateI($args[1]['i']);
        }
        if (!empty($args[1]['caps'])) {
            $this->generateCAPS($args[1]['caps']);
        }
        if (!empty($args[1]['smallCaps'])) {
            $this->generateSMALLCAPS($args[1]['smallCaps']);
        }
        if (!empty($args[1]['color'])) {
            $this->generateCOLOR($args[1]['color']);
        }
        if (!empty($args[1]['sz'])) {
            $this->generateSZ($args[1]['sz']);
        }
        if (!empty($args[1]['u'])) {
            $this->generateU($args[1]['u']);
        }
        if (!empty($args[1]['rtl'])) {
            $this->generateRTL($args[1]['rtl']);
        }
        if (!empty($args[1]['highlightColor'])) {
            $this->generateHIGHLIGHT($args[1]['highlightColor']);
        }
        if (!empty($args[1]['tab']) && $args[1]['tab']) {
            $this->generateTABS();
        }
        $this->cleanTemplateFirstRPR();
        if (!is_array($args[0])) {
            if ($args[0] instanceof WordFragment || $args[0] instanceof DOCXPathResult) {
                if ($args[0] instanceof WordFragment) {
                    $runContent = $args[0]->inlineWordML();
                } else if ($args[0] instanceof DOCXPathResult) {
                    $runContent = $args[0]->inlineXML();
                }
                if (preg_match("/__GENERATEP__/", $this->_xml)) {
                    $this->_xml = str_replace('__GENERATEP__', $runContent . '__GENERATESUBR__', $this->_xml);
                } else {
                    $this->_xml = str_replace('__GENERATESUBR__', $runContent . '__GENERATESUBR__', $this->_xml);
                }
            } else {
                $this->generateR();
                $this->generateRPR();
                if (!empty($args[1]['rStyle'])) {
                    $this->generateRSTYLE($args[1]['rStyle']);
                }
                if (!empty($args[1]['font'])) {
                    $this->generateRFONTS($args[1]['font']);
                }
                if (!empty($args[1]['b'])) {
                    $this->generateB($args[1]['b']);
                }
                if (!empty($args[1]['i'])) {
                    $this->generateI($args[1]['i']);
                }
                if (!empty($args[1]['caps'])) {
                    $this->generateCAPS($args[1]['caps']);
                }
                if (!empty($args[1]['smallCaps'])) {
                    $this->generateSMALLCAPS($args[1]['smallCaps']);
                }
                if (!empty($args[1]['color'])) {
                    $this->generateCOLOR($args[1]['color']);
                }
                if (!empty($args[1]['sz'])) {
                    $this->generateSZ($args[1]['sz']);
                }
                if (!empty($args[1]['u'])) {
                    $this->generateU($args[1]['u']);
                }
                if (!empty($args[1]['rtl'])) {
                    $this->generateRTL($args[1]['rtl']);
                }
                if (!empty($args[1]['highlightColor'])) {
                    $this->generateSHD($args[1]['highlightColor']);
                }
                if (!empty($args[1]['tab']) && $args[1]['tab']) {
                    $this->generateTABS();
                }
                if (empty($args[1]['spaces'])) {
                    $args[1]['spaces'] = '';
                }
                if (!isset($args[1]['lineBreak'])) {
                    $args[1]['lineBreak'] = false;
                }
                if (!isset($args[1]['columnBreak'])) {
                    $args[1]['columnBreak'] = false;
                }

                $this->generateT($args[0], $args[1]['spaces'], $args[1]['lineBreak'], $args[1]['columnBreak']);
                $this->cleanTemplateFirstRPR();
            }
        } else {
            foreach ($args[0] as $texts) {
                $texts = CreateDocx::translateTextOptions2StandardFormat($texts);
                if ($texts instanceof WordFragment || $texts instanceof DOCXPathResult) {
                    if ($texts instanceof WordFragment) {
                        $runContent = $texts->inlineWordML();
                    } else if ($texts instanceof DOCXPathResult) {
                        $runContent = $texts->inlineXML();
                    }
                    if (preg_match("/__GENERATEP__/", $this->_xml)) {
                        $this->_xml = str_replace('__GENERATEP__', $runContent . '__GENERATESUBR__', $this->_xml);
                    } else if (preg_match("/__GENERATER__/", $this->_xml)) {
                        $this->_xml = str_replace('__GENERATER__', $runContent . '__GENERATER__', $this->_xml);
                    } else {
                        $this->_xml = str_replace('__GENERATESUBR__', $runContent . '__GENERATESUBR__', $this->_xml);
                    }
                } else {
                    $texts = CreateDocx::setRTLOptions($texts);
                    $this->generateR();
                    //Inherit run styles from paragraph styles if they have not been
                    //explicitely set
                    if (empty($texts['b']) && !empty($args[1]['b'])) {
                        $texts['b'] = $args[1]['b'];
                    }
                    if (empty($texts['i']) && !empty($args[1]['i'])) {
                        $texts['i'] = $args[1]['i'];
                    }
                    if (empty($texts['caps']) && !empty($args[1]['caps'])) {
                        $texts['caps'] = $args[1]['caps'];
                    }
                    if (empty($texts['smallCaps']) && !empty($args[1]['smallCaps'])) {
                        $texts['smallCaps'] = $args[1]['smallCaps'];
                    }
                    if (empty($texts['u']) && !empty($args[1]['u'])) {
                        $texts['u'] = $args[1]['u'];
                    }
                    if (empty($texts['rtl']) && !empty($args[1]['rtl'])) {
                        $texts['rtl'] = $args[1]['rtl'];
                    }
                    if (empty($texts['highlightColor']) && !empty($args[1]['highlightColor'])) {
                        $texts['highlightColor'] = $args[1]['highlightColor'];
                    }
                    if (empty($texts['sz']) && !empty($args[1]['sz'])) {
                        $texts['sz'] = $args[1]['sz'];
                    }
                    if (empty($texts['color']) && !empty($args[1]['color'])) {
                        $texts['color'] = $args[1]['color'];
                    }
                    if (empty($texts['font']) && !empty($args[1]['font'])) {
                        $texts['font'] = $args[1]['font'];
                    }
                    if (empty($texts['tab']) && !empty($args[1]['tab'])) {
                        $texts['tab'] = $args[1]['tab'];
                    }


                    $this->generateRPR();
                    if (!empty($texts['font'])) {
                        $this->generateRFONTS($texts['font']);
                    }
                    if (!empty($texts['b'])) {
                        $this->generateB($texts['b']);
                    }
                    if (!empty($texts['i'])) {
                        $this->generateI($texts['i']);
                    }
                    if (!empty($texts['caps'])) {
                        $this->generateCAPS($texts['caps']);
                    }
                    if (!empty($texts['smallCaps'])) {
                        $this->generateSMALLCAPS($texts['smallCaps']);
                    }
                    if (!empty($texts['u'])) {
                        $this->generateU($texts['u']);
                    }
                    if (!empty($texts['rtl'])) {
                        $this->generateRTL($texts['rtl']);
                    }
                    if (!empty($texts['highlightColor'])) {
                        $this->generateSHD($texts['highlightColor']);
                    }
                    if (!empty($texts['sz'])) {
                        $this->generateSZ($texts['sz']);
                    }
                    if (!empty($texts['color'])) {
                        $this->generateCOLOR($texts['color']);
                    }
                    if (!empty($texts['tab']) && $texts['tab']) {
                        $this->generateTABS();
                    }


                    if (empty($texts['spaces'])) {
                        $texts['spaces'] = '';
                    }
                    if (!isset($texts['lineBreak'])) {
                        $texts['lineBreak'] = false;
                    }
                    if (!isset($texts['columnBreak'])) {
                        $texts['columnBreak'] = false;
                    }
                    if (empty($texts['text'])) {
                        $texts['text'] = '';
                    }

                    $this->generateT($texts['text'], $texts['spaces'], $texts['lineBreak'], $texts['columnBreak']);
                    $this->cleanTemplateFirstRPR();
                }
            }
        }
    }

    /**
     * Create title
     *
     * @access protected
     * @param string $arrArgs[0]
     * @param array $arrArgs[1]
     */
    public function createTitle()
    {
        $this->_xml = '';
        $args = func_get_args();
        if (isset($args[0])) {
            $this->generateP();
            $this->generatePPR();
            if (!isset($args[1]['val'])) {
                $args[1]['val'] = '';
            }
            if (isset($args[1]['type'])) {
                if ($args[1]['type'] == 'subtitle') {
                    $this->generatePSTYLE('SubtitlePHPDOCX');
                } else {
                    $this->generatePSTYLE('TitlePHPDOCX');
                }
            } else {
                $this->generatePSTYLE('TitlePHPDOCX');
            }
            if (isset($args[1]['pageBreakBefore'])) {
                $this->generatePAGEBREAKBEFORE($args[1]['pageBreakBefore']);
            }
            if (isset($args[1]['widowControl'])) {
                $this->generateWIDOWCONTROL($args[1]['widowControl']);
            }
            if (!empty($args[1]['tabPositions']) && is_array($args[1]['tabPositions'])) {
                $this->generateTABPOSITIONS($args[1]['tabPositions']);
            }
            if (isset($args[1]['wordWrap'])) {
                $this->generateWORDWRAP($args[1]['wordWrap']);
            }
            if (isset($args[1]['bidi'])) {
                $this->generateBIDI($args[1]['bidi']);
            }
            self::$_idTitle++;
            $this->generateBOOKMARKSTART(
                self::$_idTitle, '_Toc' . (self::$_idTitle + self::IDTITLE)
            );
            $this->generateR();
            if (
                isset($args[1]['b']) ||
                isset($args[1]['i']) ||
                isset($args[1]['u']) ||
                isset($args[1]['rtl']) ||
                isset($args[1]['sz']) ||
                isset($args[1]['color']) ||
                isset($args[1]['font'])
            ) {
                $this->generateRPR();
                if (isset($args[1]['font'])) {
                    $this->generateRFONTS($args[1]['font']);
                }
                if (isset($args[1]['b'])) {
                    $this->generateB($args[1]['b']);
                }
                if (isset($args[1]['i'])) {
                    $this->generateI($args[1]['i']);
                }
                if (isset($args[1]['color'])) {
                    $this->generateCOLOR($args[1]['color']);
                }
                if (isset($args[1]['sz'])) {
                    $this->generateSZ($args[1]['sz']);
                }
                if (isset($args[1]['u'])) {
                    $this->generateU($args[1]['u']);
                }
                if (isset($args[1]['rtl'])) {
                    $this->generateRTL($args[1]['rtl']);
                }
            }
            $this->generateT($args[0]);
            $this->generateBOOKMARKEND(self::$_idTitle);
            $this->cleanTemplate();
        }
    }

    /**
     * Init text
     *
     * @access public
     * @param array $args[0]
     */
    public function initText()
    {
        $args = func_get_args();

        $this->_embeddedText = $args[0];
    }

    /**
     * Generate w:bidi
     *
     * @access protected
     * @param string $val
     */
    protected function generateBIDI($val = 'on')
    {
        $this->_xml = str_replace(
            '__GENERATEPPR__', '<' . CreateElement::NAMESPACEWORD .
            ':bidi w:val="' . $val . '"></' . CreateElement::NAMESPACEWORD .
            ':bidi>__GENERATEPPR__', $this->_xml
        );
    }

    /**
     * Generate w:bookmarkend
     *
     * @access protected
     * @param int $id
     */
    protected function generateBOOKMARKEND($id)
    {
        $this->_xml = str_replace(
            '__GENERATEBOOKMARKEND__', '<' . CreateElement::NAMESPACEWORD .
            ':bookmarkEnd ' . CreateElement::NAMESPACEWORD . ':id="' . $id .
            '"></' . CreateElement::NAMESPACEWORD . ':bookmarkEnd>', $this->_xml
        );
    }

    /**
     * Generate w:bookmarkstart
     *
     * @access protected
     * @param int $id
     * @param string $name
     */
    protected function generateBOOKMARKSTART($id, $name)
    {
        $this->_xml = str_replace(
            '__GENERATER__', '<' . CreateElement::NAMESPACEWORD .
            ':bookmarkStart ' . CreateElement::NAMESPACEWORD . ':id="' . $id .
            '" ' . CreateElement::NAMESPACEWORD . ':name="' . $name . '"></' .
            CreateElement::NAMESPACEWORD .
            ':bookmarkStart>__GENERATER____GENERATEBOOKMARKEND__', $this->_xml
        );
    }

    /**
     * Generate w:color
     *
     * @access protected
     * @param string $val
     */
    protected function generateCOLOR($val = '000000')
    {
        $this->_xml = str_replace(
            '__GENERATERPR__', '<' . CreateElement::NAMESPACEWORD . ':color ' .
            CreateElement::NAMESPACEWORD . ':val="' . $val . '"></' .
            CreateElement::NAMESPACEWORD . ':color>__GENERATERPR__', $this->_xml
        );
    }

    /**
     * Generate w:contextualSpacing
     *
     * @access protected
     * @param string $val
     */
    protected function generateCONTEXTUALSPACING($val = 'on')
    {
        $this->_xml = str_replace(
            '__GENERATEPPR__', '<' . CreateElement::NAMESPACEWORD .
            ':contextualSpacing w:val="' . $val . '"></' .
            CreateElement::NAMESPACEWORD . ':contextualSpacing>__GENERATEPPR__', $this->_xml
        );
    }

    /**
     * Generate w:caps
     *
     * @access protected
     * @param string $val
     */
    protected function generateCAPS($val = 'on')
    {
        $this->_xml = str_replace(
            '__GENERATERPR__', '<' . CreateElement::NAMESPACEWORD . ':caps ' .
            CreateElement::NAMESPACEWORD . ':val="' . $val . '"></' .
            CreateElement::NAMESPACEWORD . ':caps>__GENERATERPR__', $this->_xml
        );
    }

    /**
     * Generate w:outlineLvl
     *
     * @access protected
     * @param string $val
     */
    protected function generateHEADINGLEVEL($val)
    {
        if (is_integer($val) && $val > 0) {
            $this->_xml = str_replace(
                '__GENERATEPPR__', '<' . CreateElement::NAMESPACEWORD .
                ':outlineLvl w:val="' . $val . '"></' .
                CreateElement::NAMESPACEWORD . ':outlineLvl>__GENERATEPPR__', $this->_xml
            );
        }
    }

    /**
     * Generate w:highlight
     *
     * @access protected
     * @param string $val
     */
    protected function generateHIGHLIGHT($val)
    {
        $this->_xml = str_replace(
            '__GENERATERPR__', '<' . CreateElement::NAMESPACEWORD . ':highlight ' .
            CreateElement::NAMESPACEWORD . ':val="' . $val . '"></' .
            CreateElement::NAMESPACEWORD . ':highlight>__GENERATERPR__', $this->_xml
        );
    }

    /**
     * Generate w:i and w:iCs
     *
     * @access protected
     * @param string $val
     */
    protected function generateI($val = 'single')
    {
        $this->_xml = str_replace(
            '__GENERATERPR__', '<' . CreateElement::NAMESPACEWORD . ':i ' .
            CreateElement::NAMESPACEWORD . ':val="' . $val . '"></' .
            CreateElement::NAMESPACEWORD . ':i><' . CreateElement::NAMESPACEWORD . ':iCs ' .
            CreateElement::NAMESPACEWORD . ':val="' . $val . '"></' .
            CreateElement::NAMESPACEWORD . ':iCs>__GENERATERPR__', $this->_xml
        );
    }

    /**
     * Generate w:ind
     *
     * @access protected
     * @param string $indentation
     */
    protected function generateINDENT($indentation = [])
    {
        $xmlInd = '<' . CreateElement::NAMESPACEWORD . ':ind ';
        foreach ($indentation as $key => $value) {
            $xmlInd .= CreateElement::NAMESPACEWORD . ':' . $key . '="' . $value . '" ';
        }
        $xmlInd .= '></' . CreateElement::NAMESPACEWORD . ':ind>__GENERATEPPR__';
        $this->_xml = str_replace('__GENERATEPPR__', $xmlInd, $this->_xml);
    }

    /**
     * Generate w:keepLines
     *
     * @access protected
     * @param string $val
     */
    protected function generateKEEPLINES($val = 'on')
    {
        $this->_xml = str_replace(
            '__GENERATEPPR__', '<' . CreateElement::NAMESPACEWORD .
            ':keepLines w:val="' . $val . '"></' .
            CreateElement::NAMESPACEWORD . ':keepLines>__GENERATEPPR__', $this->_xml
        );
    }

    /**
     * Generate w:keepNext
     *
     * @access protected
     * @param string $val
     */
    protected function generateKEEPNEXT($val = 'on')
    {
        $this->_xml = str_replace(
            '__GENERATEPPR__', '<' . CreateElement::NAMESPACEWORD .
            ':keepNext w:val="' . $val . '"></' .
            CreateElement::NAMESPACEWORD . ':keepNext>__GENERATEPPR__', $this->_xml
        );
    }

    /**
     * Generate w:jc
     *
     * @access protected
     * @param string $val
     */
    protected function generateJC($val = '')
    {
        $this->_xml = str_replace(
            '__GENERATEPPR__', '<' . CreateElement::NAMESPACEWORD . ':jc ' .
            CreateElement::NAMESPACEWORD . ':val="' . $val . '"></' .
            CreateElement::NAMESPACEWORD . ':jc>__GENERATEPPR__', $this->_xml
        );
    }

    /**
     * Generate w:pagebreakbefore
     *
     * @access protected
     * @param string $val
     */
    protected function generatePAGEBREAKBEFORE($val = 'on')
    {
        $this->_xml = str_replace(
            '__GENERATEPPR__', '<' . CreateElement::NAMESPACEWORD .
            ':pageBreakBefore val="' . $val . '"></' .
            CreateElement::NAMESPACEWORD . ':pageBreakBefore>__GENERATEPPR__', $this->_xml
        );
    }

    /**
     * Generate w:tcBorders
     *
     * @param array $border
     * @access protected
     */
    protected function generatePBDR($border)
    {
        $xml = '<w:pBdr>';
        foreach (self::$_borders as $key => $value) {
            if (isset($border[$value])) {
                if (isset($border[$value]['type'])) {
                    $border_type = $border[$value]['type'];
                } else {
                    $border_type = 'single';
                }
                if (isset($border[$value]['color'])) {
                    $border_color = $border[$value]['color'];
                } else {
                    $border_color = '000000';
                }
                if (isset($border[$value]['sz'])) {
                    $border_sz = $border[$value]['sz'];
                } else {
                    $border_sz = 6;
                }
                if (isset($border[$value]['spacing'])) {
                    $border_spacing = $border[$value]['spacing'];
                } else {
                    $border_spacing = 0;
                }
                $xml .= '<w:' . $value . ' w:val="' . $border_type . '" w:color="' . $border_color . '" w:sz="' . $border_sz . '" w:space="' . $border_spacing . '"/>';
            }
        }
        $xml .= '</w:pBdr>__GENERATEPPR__';
        $this->_xml = str_replace('__GENERATEPPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:ppr
     *
     * @access protected
     */
    protected function generatePPR()
    {
        $xml = '<' . CreateElement::NAMESPACEWORD . ':pPr>__GENERATEPPR__</' . CreateElement::NAMESPACEWORD .
            ':pPr>__GENERATER__';

        $this->_xml = str_replace('__GENERATEP__', $xml, $this->_xml);
    }

    /**
     * Generate w:rPr within a w:pPr tag
     *
     * @access protected
     */
    protected function generatePPRRPR()
    {
        /* $xml = '<' . CreateElement::NAMESPACEWORD .
          ':rPr>__GENERATERPR__</' . CreateElement::NAMESPACEWORD .
          ':rPr>__GENERATER__';

          $this->_xml = str_replace('__GENERATER__', $xml, $this->_xml); */

        $this->_xml = str_replace(
            '__GENERATEPPR__', '<' . CreateElement::NAMESPACEWORD . ':rPr >__GENERATERPR__</' .
            CreateElement::NAMESPACEWORD . ':rPr>__GENERATEPPR__', $this->_xml
        );
    }

    /**
     * Generate w:shd
     *
     * @access protected
     * @param string $val
     */
    protected function generatePPRSHD($val = 'FFFFFF')
    {
        $this->_xml = str_replace(
            '__GENERATEPPR__', '<' . CreateElement::NAMESPACEWORD . ':shd ' .
            CreateElement::NAMESPACEWORD . ':val="clear" ' .
            CreateElement::NAMESPACEWORD . ':fill="' . $val . '"></' .
            CreateElement::NAMESPACEWORD . ':shd>__GENERATEPPR__', $this->_xml
        );
    }

    /**
     * Generate w:pstyle
     *
     * @access protected
     * @param string $val
     */
    protected function generatePSTYLE($val = 'TitlePHPDOCX')
    {
        $this->_xml = str_replace(
            '__GENERATEPPR__', '<' . CreateElement::NAMESPACEWORD . ':pStyle ' .
            CreateElement::NAMESPACEWORD . ':val="' . $val . '"></' .
            CreateElement::NAMESPACEWORD . ':pStyle>__GENERATEPPR__', $this->_xml
        );
    }

    /**
     * Generate w:rtl
     *
     * @access protected
     * @param string $val
     */
    protected function generateRTL($val = 'on')
    {
        $this->_xml = str_replace(
            '__GENERATERPR__', '<' . CreateElement::NAMESPACEWORD . ':rtl ' .
            CreateElement::NAMESPACEWORD . ':val="' . $val . '"></' .
            CreateElement::NAMESPACEWORD . ':rtl>__GENERATERPR__', $this->_xml
        );
    }

    /**
     * Generate w:shd
     *
     * @access protected
     * @param string $val
     */
    protected function generateSHD($val = 'FFFFFF')
    {
        $this->_xml = str_replace(
            '__GENERATERPR__', '<' . CreateElement::NAMESPACEWORD . ':shd ' .
            CreateElement::NAMESPACEWORD . ':val="clear" ' .
            CreateElement::NAMESPACEWORD . ':fill="' . $val . '"></' .
            CreateElement::NAMESPACEWORD . ':shd>__GENERATERPR__', $this->_xml
        );
    }

    /**
     * Generate w:smallCaps
     *
     * @access protected
     * @param string $val
     */
    protected function generateSMALLCAPS($val = 'on')
    {
        $this->_xml = str_replace(
            '__GENERATERPR__', '<' . CreateElement::NAMESPACEWORD . ':smallCaps ' .
            CreateElement::NAMESPACEWORD . ':val="' . $val . '"></' .
            CreateElement::NAMESPACEWORD . ':smallCaps>__GENERATERPR__', $this->_xml
        );
    }

    /**
     * Generate w:spacing
     *
     * @access protected
     */
    protected function generateSPACING($line = '240', $spacingTop, $spacingBottom)
    {
        $xml = '<' . CreateElement::NAMESPACEWORD . ':spacing ';
        if (isset($spacingTop) && $spacingTop !== '') {
            $xml .= CreateElement::NAMESPACEWORD . ':before="' . (int) $spacingTop . '" ';
        }
        if (isset($spacingBottom) && $spacingBottom !== '') {
            $xml .= CreateElement::NAMESPACEWORD . ':after="' . (int) $spacingBottom . '" ';
        }
        $xml .= CreateElement::NAMESPACEWORD . ':line="' . $line .
            '" ' . CreateElement::NAMESPACEWORD . ':lineRule="auto"/>__GENERATEPPR__';

        $this->_xml = str_replace('__GENERATEPPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:sz and w:szCs
     *
     * @access protected
     * @param string $val
     */
    protected function generateSZ($val = '11')
    {
        $val *= 2;
        $this->_xml = str_replace(
            '__GENERATERPR__', '<' . CreateElement::NAMESPACEWORD . ':sz ' .
            CreateElement::NAMESPACEWORD . ':val="' . $val . '"></' .
            CreateElement::NAMESPACEWORD . ':sz>' .
            '<' . CreateElement::NAMESPACEWORD . ':szCs ' .
            CreateElement::NAMESPACEWORD . ':val="' . $val . '"></' .
            CreateElement::NAMESPACEWORD . ':szCs>' .
            '__GENERATERPR__', $this->_xml
        );
    }

    /**
     * Generate w:t
     *
     * @access protected
     * @param string $dat
     * @param int $spaces
     * @param string $lineBreak
     * @param string $columnBreak
     */
    protected function generateT($dat, $spaces = 0, $lineBreak = false, $columnBreak = false)
    {
        $strSpaces = '';
        if ($spaces) {
            $i = 0;
            while ($i < $spaces) {
                $strSpaces .= ' ';
                $i++;
            }
        }
        if ($lineBreak == 'before') {
            $this->_xml = str_replace(
                '__GENERATER__', '<w:br /><' . CreateElement::NAMESPACEWORD .
                ':t xml:space="preserve">' . $strSpaces . htmlspecialchars($dat) . '</' .
                CreateElement::NAMESPACEWORD . ':t>', $this->_xml
            );
        } else if ($lineBreak == 'after') {
            $this->_xml = str_replace(
                '__GENERATER__', '<' . CreateElement::NAMESPACEWORD .
                ':t xml:space="preserve">' . $strSpaces . htmlspecialchars($dat) . '</' .
                CreateElement::NAMESPACEWORD . ':t><w:br />', $this->_xml
            );
        } else if ($lineBreak == 'both') {
            $this->_xml = str_replace(
                '__GENERATER__', '<w:br /><' . CreateElement::NAMESPACEWORD .
                ':t xml:space="preserve">' . $strSpaces . htmlspecialchars($dat) . '</' .
                CreateElement::NAMESPACEWORD . ':t><w:br />', $this->_xml
            );
        } else if ($columnBreak == 'before') {
            $this->_xml = str_replace(
                '__GENERATER__', '<w:br w:type="column" /><' . CreateElement::NAMESPACEWORD .
                ':t xml:space="preserve">' . $strSpaces . htmlspecialchars($dat) . '</' .
                CreateElement::NAMESPACEWORD . ':t>', $this->_xml
            );
        } else if ($columnBreak == 'after') {
            $this->_xml = str_replace(
                '__GENERATER__', '<' . CreateElement::NAMESPACEWORD .
                ':t xml:space="preserve">' . $strSpaces . htmlspecialchars($dat) . '</' .
                CreateElement::NAMESPACEWORD . ':t><w:br w:type="column" />', $this->_xml
            );
        } else if ($columnBreak == 'both') {
            $this->_xml = str_replace(
                '__GENERATER__', '<w:br w:type="column" /><' . CreateElement::NAMESPACEWORD .
                ':t xml:space="preserve">' . $strSpaces . htmlspecialchars($dat) . '</' .
                CreateElement::NAMESPACEWORD . ':t><w:br w:type="column" />', $this->_xml
            );
        } else {
            $this->_xml = str_replace(
                '__GENERATER__', '<' . CreateElement::NAMESPACEWORD .
                ':t xml:space="preserve">' . $strSpaces . htmlspecialchars($dat) . '</' .
                CreateElement::NAMESPACEWORD . ':t>', $this->_xml
            );
        }
    }

    /**
     * Generate w:abs
     *
     * @access protected
     * @param array $tabs
     */
    protected function generateTABPOSITIONS($tabs)
    {
        $typesArray = ['clear', 'left', 'center', 'right', 'decimal', 'bar', 'num'];
        $leaderArray = ['none', 'dot', 'hyphen', 'underscore', 'heavy', 'middleDot'];
        $xml = '<w:tabs>';
        foreach ($tabs as $key => $tab) {
            if (isset($tab['type']) && in_array($tab['type'], $typesArray)) {
                $type = $tab['type'];
            } else {
                $type = 'left';
            }
            if (isset($tab['leader']) && in_array($tab['leader'], $leaderArray)) {
                $leader = $tab['leader'];
            } else {
                $leader = 'none';
            }
            if (isset($tab['position']) && is_int($tab['position'])) {
                $xml .='<w:tab w:val="' . $type . '" w:leader="' . $leader . '" w:pos="' . (int) $tab['position'] . '" />';
            }
        }
        $xml .='</w:tabs>';
        $this->_xml = str_replace('__GENERATEPPR__', $xml . '__GENERATEPPR__', $this->_xml);
    }

    /**
     * Generate w:abs
     *
     * @access protected
     */
    protected function generateTABS()
    {
        $this->_xml = str_replace(
            '__GENERATER__', '<' . CreateElement::NAMESPACEWORD .
            ':tab/>__GENERATER__', $this->_xml
        );
    }

    /**
     * Generate w:textDirection
     *
     * @access protected
     * @param string $val
     */
    protected function generateTEXTDIRECTION($val = 'lrTb')
    {
        $this->_xml = str_replace(
            '__GENERATEPPR__', '<' . CreateElement::NAMESPACEWORD .
            ':textDirection w:val="' . $val . '"></' .
            CreateElement::NAMESPACEWORD . ':textDirection>__GENERATEPPR__', $this->_xml
        );
    }

    /**
     * Generate w:u
     *
     * @access protected
     * @param string $val
     */
    protected function generateU($val = 'single')
    {
        $this->_xml = str_replace(
            '__GENERATERPR__', '<' . CreateElement::NAMESPACEWORD . ':u ' .
            CreateElement::NAMESPACEWORD . ':val="' . $val . '"></' .
            CreateElement::NAMESPACEWORD . ':u>__GENERATERPR__', $this->_xml
        );
    }

    /**
     * Generate w:widowcontrol
     *
     * @access protected
     * @param string $val
     */
    protected function generateWIDOWCONTROL($val = 'on')
    {
        $this->_xml = str_replace(
            '__GENERATEPPR__', '<' . CreateElement::NAMESPACEWORD .
            ':widowControl ' . CreateElement::NAMESPACEWORD . ':val="' . $val . '"></' .
            CreateElement::NAMESPACEWORD . ':widowControl>__GENERATEPPR__', $this->_xml
        );
    }

    /**
     * Generate w:wordwrap
     *
     * @access protected
     * @param string $val
     */
    protected function generateWORDWRAP($val = 'on')
    {
        $this->_xml = str_replace(
            '__GENERATEPPR__', '<' . CreateElement::NAMESPACEWORD .
            ':wordWrap w:val="' . $val . '"></' . CreateElement::NAMESPACEWORD .
            ':wordWrap>__GENERATEPPR__', $this->_xml
        );
    }

}


class HTML2WordML
{

    /**
     *
     * @access public
     * @static
     * @var aray
     */
    public static $borderRow;

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $colors;

    /**
     *
     * @access public
     * @static
     * @var string
     */
    public static $currentCustomList;

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $customLists;

    /**
     *
     * @access public
     * @var string
     */
    public $customListStyles;

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $linkImages;

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $linkTargets;

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $borders;

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $borderStyles;

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $imageBorderStyles;

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $imageVertAlignProps;

    /**
     *
     * @access public
     * @static
     * @var int
     */
    public static $openBookmark;

    /**
     *
     * @access public
     * @static
     * @var int
     */
    public static $openBr;

    /**
     *
     * @access public
     * @static
     * @var boolean
     */
    public static $openLinks;

    /**
     *
     * @access public
     * @static
     * @var boolean
     */
    public static $openPs;

    /**
     *
     * @access public
     * @static
     * @var boolean
     */
    public static $openSelect;

    /**
     *
     * @access public
     * @static
     * @var string
     */
    public static $openScript;

    /**
     *
     * @access public
     * @static
     * @var integer
     */
    public static $openTable;

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $openTags;

    /**
     *
     * @access public
     * @static
     * @var boolean
     */
    public static $openTextArea;

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $orderedLists;

    /**
     *
     * @access public
     * @static
     * @var string
     */
    public static $rowColor;

    /**
     *
     * @access public
     * @static
     * @var boolean
     */
    public static $selectedOption;

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $selectOptions;

    /**
     *
     * @access public
     * @var boolean
     */
    public $strictWordStyles;

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $tableGrid;

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $text_align;

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $text_direction;

    /**
     *
     * @access public
     * @static
     * @var string
     */
    public static $textArea;

    /**
     *
     * @access public
     * @static
     * @var string
     */
    public static $WordML;

    /**
     *
     * @access public
     * @static
     * @var string
     */
    public static $zipDocx;

    /**
     *
     * @access private
     * @var Logger
     */
    private $log;

    /**
     * Class constructor
     */
    public function __construct($zipDocx)
    {
        self::$zipDocx = $zipDocx;
        self::$openBookmark = 0;
        self::$openBr = 0;
        self::$openTags = [];
        self::$openPs = false;
        self::$openSelect = false;
        self::$selectOptions = [];
        self::$openTextArea = false;
        self::$textArea = '';
        self::$tableGrid = [];
        self::$openScript = '';
        self::$currentCustomList = NULL;
        self::$customLists = [];
        self::$orderedLists = [];
        self::$openTable = 0;
        self::$openLinks = false;
        self::$WordML = '';
        self::$linkTargets = [];
        self::$linkImages = [];
        self::$borderRow = [];
        self::$borders = ['top', 'left', 'bottom', 'right'];
        self::$colors = [
            'AliceBlue' => 'F0F8FF',
            'AntiqueWhite' => 'FAEBD7',
            'Aqua' => '00FFFF',
            'Aquamarine' => '7FFFD4',
            'Azure' => 'F0FFFF',
            'Beige' => 'F5F5DC',
            'Bisque' => 'FFE4C4',
            'Black' => '000000',
            'BlanchedAlmond' => 'FFEBCD',
            'Blue' => '0000FF',
            'BlueViolet' => '8A2BE2',
            'Brown' => 'A52A2A',
            'BurlyWood' => 'DEB887',
            'CadetBlue' => '5F9EA0',
            'Chartreuse' => '7FFF00',
            'Chocolate' => 'D2691E',
            'Coral' => 'FF7F50',
            'CornflowerBlue' => '6495ED',
            'Cornsilk' => 'FFF8DC',
            'Crimson' => 'DC143C',
            'Cyan' => '00FFFF',
            'DarkBlue' => '00008B',
            'DarkCyan' => '008B8B',
            'DarkGoldenRod' => 'B8860B',
            'DarkGray' => 'A9A9A9',
            'DarkGrey' => 'A9A9A9',
            'DarkGreen' => '006400',
            'DarkKhaki' => 'BDB76B',
            'DarkMagenta' => '8B008B',
            'DarkOliveGreen' => '556B2F',
            'Darkorange' => 'FF8C00',
            'DarkOrchid' => '9932CC',
            'DarkRed' => '8B0000',
            'DarkSalmon' => 'E9967A',
            'DarkSeaGreen' => '8FBC8F',
            'DarkSlateBlue' => '483D8B',
            'DarkSlateGray' => '2F4F4F',
            'DarkSlateGrey' => '2F4F4F',
            'DarkTurquoise' => '00CED1',
            'DarkViolet' => '9400D3',
            'DeepPink' => 'FF1493',
            'DeepSkyBlue' => '00BFFF',
            'DimGray' => '696969',
            'DimGrey' => '696969',
            'DodgerBlue' => '1E90FF',
            'FireBrick' => 'B22222',
            'FloralWhite' => 'FFFAF0',
            'ForestGreen' => '228B22',
            'Fuchsia' => 'FF00FF',
            'Gainsboro' => 'DCDCDC',
            'GhostWhite' => 'F8F8FF',
            'Gold' => 'FFD700',
            'GoldenRod' => 'DAA520',
            'Gray' => '808080',
            'Grey' => '808080',
            'Green' => '008000',
            'GreenYellow' => 'ADFF2F',
            'HoneyDew' => 'F0FFF0',
            'HotPink' => 'FF69B4',
            'IndianRed' => 'CD5C5C',
            'Indigo' => '4B0082',
            'Ivory' => 'FFFFF0',
            'Khaki' => 'F0E68C',
            'Lavender' => 'E6E6FA',
            'LavenderBlush' => 'FFF0F5',
            'LawnGreen' => '7CFC00',
            'LemonChiffon' => 'FFFACD',
            'LightBlue' => 'ADD8E6',
            'LightCoral' => 'F08080',
            'LightCyan' => 'E0FFFF',
            'LightGoldenRodYellow' => 'FAFAD2',
            'LightGray' => 'D3D3D3',
            'LightGrey' => 'D3D3D3',
            'LightGreen' => '90EE90',
            'LightPink' => 'FFB6C1',
            'LightSalmon' => 'FFA07A',
            'LightSeaGreen' => '20B2AA',
            'LightSkyBlue' => '87CEFA',
            'LightSlateGray' => '778899',
            'LightSlateGrey' => '778899',
            'LightSteelBlue' => 'B0C4DE',
            'LightYellow' => 'FFFFE0',
            'Lime' => '00FF00',
            'LimeGreen' => '32CD32',
            'Linen' => 'FAF0E6',
            'Magenta' => 'FF00FF',
            'Maroon' => '800000',
            'MediumAquaMarine' => '66CDAA',
            'MediumBlue' => '0000CD',
            'MediumOrchid' => 'BA55D3',
            'MediumPurple' => '9370D8',
            'MediumSeaGreen' => '3CB371',
            'MediumSlateBlue' => '7B68EE',
            'MediumSpringGreen' => '00FA9A',
            'MediumTurquoise' => '48D1CC',
            'MediumVioletRed' => 'C71585',
            'MidnightBlue' => '191970',
            'MintCream' => 'F5FFFA',
            'MistyRose' => 'FFE4E1',
            'Moccasin' => 'FFE4B5',
            'NavajoWhite' => 'FFDEAD',
            'Navy' => '000080',
            'OldLace' => 'FDF5E6',
            'Olive' => '808000',
            'OliveDrab' => '6B8E23',
            'Orange' => 'FFA500',
            'OrangeRed' => 'FF4500',
            'Orchid' => 'DA70D6',
            'PaleGoldenRod' => 'EEE8AA',
            'PaleGreen' => '98FB98',
            'PaleTurquoise' => 'AFEEEE',
            'PaleVioletRed' => 'D87093',
            'PapayaWhip' => 'FFEFD5',
            'PeachPuff' => 'FFDAB9',
            'Peru' => 'CD853F',
            'Pink' => 'FFC0CB',
            'Plum' => 'DDA0DD',
            'PowderBlue' => 'B0E0E6',
            'Purple' => '800080',
            'Red' => 'FF0000',
            'RosyBrown' => 'BC8F8F',
            'RoyalBlue' => '4169E1',
            'SaddleBrown' => '8B4513',
            'Salmon' => 'FA8072',
            'SandyBrown' => 'F4A460',
            'SeaGreen' => '2E8B57',
            'SeaShell' => 'FFF5EE',
            'Sienna' => 'A0522D',
            'Silver' => 'C0C0C0',
            'SkyBlue' => '87CEEB',
            'SlateBlue' => '6A5ACD',
            'SlateGray' => '708090',
            'SlateGrey' => '708090',
            'Snow' => 'FFFAFA',
            'SpringGreen' => '00FF7F',
            'SteelBlue' => '4682B4',
            'Tan' => 'D2B48C',
            'Teal' => '008080',
            'Thistle' => 'D8BFD8',
            'Tomato' => 'FF6347',
            'Turquoise' => '40E0D0',
            'Violet' => 'EE82EE',
            'Wheat' => 'F5DEB3',
            'White' => 'FFFFFF',
            'WhiteSmoke' => 'F5F5F5',
            'Yellow' => 'FFFF00',
            'YellowGreen' => '9ACD32'
        ];

        self::$borderStyles = [
            'none' => 'nil',
            'dotted' => 'dotted',
            'dashed' => 'dashed',
            'solid' => 'single',
            'double' => 'double',
            'groove' => 'threeDEngrave',
            'ridge' => 'single', //threeDEmboss: we have overriden this border style that is the one by default in HTML tables
            'inset' => 'inset',
            'outset' => 'outset'
        ];
        self::$imageBorderStyles = [
            'none' => 'nil',
            'dotted' => 'dot',
            'dashed' => 'dash',
            'solid' => 'solid',
            //By the time being we parse all other types as solid
            'double' => 'solid',
            'groove' => 'solid',
            'ridge' => 'solid',
            'inset' => 'solid',
            'outset' => 'solid'
        ];
        self::$imageVertAlignProps = [
            'top' => 'top',
            'text-top' => 'top',
            'middle' => 'center'
        ];

        self::$text_align = [
            'left' => 'left',
            'center' => 'center',
            'right' => 'right',
            'justify' => 'both'
        ];

        self::$text_direction = [
            'ltr' => 'lrTb', //Left to Right, Top to Bottom
            'rtl' => 'tbRl', //Right to Left, Top to Bottom
            'lrTb' => 'lrTb', //Left to Right, Top to Bottom
            'tbRl' => 'tbRl', //	Top to Bottom, Right to Left
            'btLr' => 'btLr', //	Bottom to Top, Left to Right
            'lrTbV' => 'lrTbV', //Left to Right, Top to Bottom Rotated
            'tbRlV' => 'tbRlV', //Top to Bottom, Right to Left Rotated
            'tbLrV' => 'tbLrV', //Top to Bottom, Left to Right Rotated
            'lrtb' => 'lrTb', //Left to Right, Top to Bottom
            'tbrl' => 'tbRl', //	Top to Bottom, Right to Left
            'btlr' => 'btLr', //	Bottom to Top, Left to Right
            'lrtbv' => 'lrTbV', //Left to Right, Top to Bottom Rotated
            'tbrlv' => 'tbRlV', //Top to Bottom, Right to Left Rotated
            'tblrv' => 'tbLrV', //Top to Bottom, Left to Right Rotated
        ];

        $this->isFile = false;
        $this->baseURL = '';
        $this->context = '';
        $this->customListStyles = false;
        $this->parseDivs = false;
        $this->parseFloats = false;
        $this->wordStyles = [];
        $this->tableStyle = ''; //FIXME deprecated
        $this->paragraphStyle = ''; //FIXME deprecated
        $this->downloadImages = false;
        $this->parseAnchors = false;
        $this->strictWordStyles = false;
    }

    /**
     * Class destructor
     */
    public function __destruct()
    {

    }

    /**
     * This is the function that launches the HTML parsing
     *
     * @access public
     * @param string $html
     * @param array $options
     * @param mixed $filter
     * @return array
     */
    public function render($html, $options)
    {
        if (isset($options['isFile'])) {
            $this->isFile = $options['isFile'];
        }
        if (isset($options['baseURL'])) {
            $this->baseURL = $options['baseURL'];
        } else if (!empty($options['isFile'])) {
            if ($html[strlen($html) - 1] == '/') {
                $this->baseURL = $html;
            } else {
                $parsedURL = parse_url($html);
                $pathParts = @explode('/', $parsedURL['path']); //TODO bad parsing if "http://domain.tld" or if "http://domain.tld/path/path.with.point"
                $last = array_pop($pathParts);
                if (strpos($last, '.') > 0) {
                    //Do nothing
                } else {
                    $pathParts[] = $last;
                }
                $newPath = implode('/', $pathParts);
                $this->baseURL = $parsedURL['scheme'] . '://' . $parsedURL['host'] . $newPath . '/';
            }
        }
        if (isset($options['context'])) {
            $this->context = $options['context'];
        }
        if (isset($options['customListStyles'])) {
            $this->customListStyles = $options['customListStyles'];
        }
        if (isset($options['parseAnchors'])) {
            $this->parseAnchors = $options['parseAnchors'];
        }
        if (isset($options['parseDivsAsPs']) && $options['parseDivsAsPs']) {//For backwards compatibility with v2.7
            $options['parseDivs'] = 'paragraph';
        }
        if (isset($options['parseDivs'])) {
            if ($options['parseDivs'] == 'table' || $options['parseDivs'] == 'paragraph')
                $this->parseDivs = $options['parseDivs'];
            else
                $this->parseDivs = false;
        }
        if (isset($options['parseFloats'])) {
            $this->parseFloats = empty($options['parseFloats']) ? false : true;
        }
        if (isset($options['tableStyle'])) { //FIXME deprecated
            //$this->tableStyle = $options['tableStyle'];
            $this->wordStyles['<table>'] = $options['tableStyle'];
            PhpdocxLogger::logger('"tableStyle" option is DEPRECATED, use "wordStyles" instead. ', 'info');
        }
        if (isset($options['paragraphStyle'])) { //FIXME deprecated
            //$this->paragraphStyle = $options['paragraphStyle'];
            $this->wordStyles['<p>'] = $options['paragraphStyle'];
            PhpdocxLogger::logger('"paragraphStyle" option is DEPRECATED, use "wordStyles" instead. ', 'info');
        }
        if (isset($options['strictWordStyles'])) {
            $this->strictWordStyles = $options['strictWordStyles'];
        }
        if (isset($options['wordStyles']) && is_array($options['wordStyles'])) {
            if (empty($this->wordStyles)) {
                $this->wordStyles = $options['wordStyles'];
            } else { //FIXME change this when "tableStyle" and "paragraphStyle" dissapears
                foreach ($options['wordStyles'] as $key => $value) {
                    $this->wordStyles[$key] = $value;
                }
            }
        }
        if (isset($options['downloadImages'])) {
            $this->downloadImages = $options['downloadImages'];
        }

        $filter = isset($options['filter']) ? $options['filter'] : '*';
        $dompdfTree = $this->renderDompdf($html, $this->isFile, $filter, $this->parseDivs, $this->baseURL);
        $this->_render($dompdfTree);

        if (self::$openPs) {
            self::$WordML .= '</w:p>';
        }

        self::$WordML = $this->repairWordML(self::$WordML);

        return([self::$WordML, self::$linkTargets, self::$linkImages, self::$orderedLists, self::$customLists]);
    }

    /**
     * Get the HTML DOM tree from DOMPDF
     *
     * @access private
     * @param string $html
     * @param boolean $isFile
     * @param string $filter
     * @return array
     */
    private function renderDompdf($html, $isFile = false, $filter = '*', $parseDivs = false, $baseURL = '')
    {
        /* require_once(DIR_DOMPDF . "/dompdf_config.inc.php");
          require_once(DOMPDF_INC_DIR . '/dompdf_treeOut.php');
          $dompdf = new dompdf_treeOut(); */
        require_once PHPDOCX_DIR_PARSER . '/parserhtml_config.inc.php';
        $dompdf = new PARSERHTML();
        $aTemp = $dompdf->getDompdfTree($html, $isFile, $filter, $parseDivs, $baseURL);
        return($aTemp);
    }

    /**
     * This function renders the HTML DOM elements recursively
     *
     * @access private
     * @param array $nodo
     * @param integer $depth
     * @return array
     */
    private function _render($nodo, $depth = 0)
    {
        $this->_level = $depth;
        if (isset($nodo['attributes']['id']) && $this->parseAnchors) {
            $bookmarkId = rand(999999, 99999999);
            self::$WordML .= '<w:bookmarkStart w:id="' . $bookmarkId . '" w:name="' . $nodo['attributes']['id'] . '" /><w:bookmarkEnd w:id="' . $bookmarkId . '" />';
        }
        $properties = isset($nodo['properties']) ? $nodo['properties'] : [];
        switch ($nodo['nodeName']) {
            case 'div':
                if (!$this->parseDivs) {
                    self::$WordML .= $this->closePreviousTags($depth, $nodo['nodeName']);
                    self::$openTags[$depth] = $nodo['nodeName'];
                    //Test if the page_break_before property is set up
                    if (isset($properties['page_break_before']) && $properties['page_break_before'] == 'always') {
                        //Take care of open p tags
                        if (self::$openPs) {
                            if (self::$openLinks) {
                                self::$WordML .= '</w:hyperlink>';
                                self::$openLinks = false;
                            }
                            if (self::$openBookmark > 0) {
                                $sRet.= '<w:bookmarkEnd w:id="' . self::$openBookmark . '" />';
                                self::$openBookmark = 0;
                            }
                            self::$WordML .= '<w:r><w:br w:type="page"/></w:r></w:p>';
                            self::$openPs = false;
                        } else {
                            //insert a page break within a paragraph
                            self::$WordML .= '<w:p><w:pPr><w:pageBreakBefore w:val="on" /></w:pPr><w:r></w:r></w:p>';
                        }
                    }
                    break;
                }
            case 'h1':
            case 'h2':
            case 'h3':
            case 'h4':
            case 'h5':
            case 'h6':
            case 'p':
            case 'dt':
            case 'dd':
                // extract the heading level
                $level = substr($nodo['nodeName'], 1, 1);
                self::$WordML .= $this->closePreviousTags($depth, $nodo['nodeName']);
                if (self::$openPs) {
                    if (self::$openLinks) {
                        self::$WordML .= '</w:hyperlink>';
                        self::$openLinks = false;
                    }
                    if (self::$openBookmark > 0) {
                        $sRet.= '<w:bookmarkEnd w:id="' . self::$openBookmark . '" />';
                        self::$openBookmark = 0;
                    }
                    self::$WordML .= '</w:p><w:p>';
                } else {
                    self::$WordML .= '<w:p>';
                    self::$openPs = true;
                }
                self::$WordML .= $this->generatePPr($properties, $level, $nodo['attributes'], $nodo['nodeName']);
                self::$openTags[$depth] = $nodo['nodeName'];
                break;
            case 'dl':
                self::$openTags[$depth] = $nodo['nodeName'];
                break;
            case 'ol':
                self::$WordML .= $this->closePreviousTags($depth, $nodo['nodeName']);

                $this->countTags = array_count_values(self::$openTags);
                $listLevel = max((@$this->countTags['ul'] + @$this->countTags['ol']), 0);

                if ($listLevel == 0) {
                    createDocx::$numOL++;
                    self::$orderedLists[] = createDocx::$numOL;
                    self::$currentCustomList = NULL;
                }
            case 'ul':
                self::$WordML .= $this->closePreviousTags($depth, $nodo['nodeName']);
                if ($this->customListStyles) {
                    //Check if it is the first list or is nested within a existing list
                    //and if custom list styles are to be used
                    $this->countTags = array_count_values(self::$openTags);
                    $listLevel = max((@$this->countTags['ul'] + @$this->countTags['ol']), 0);
                    if ($listLevel == 0) {
                        if (isset($nodo['attributes']) && isset($nodo['attributes']['class'])) {
                            $currentListStyle = NULL;
                            foreach ($nodo['attributes']['class'] as $value) {
                                if (!empty(CreateDocx::$customLists[$value])) {
                                    $currentListStyle = $value;
                                }
                            }
                        }
                        if (!empty($currentListStyle)) {
                            self::$currentCustomList = rand(9999, 999999999);
                            self::$customLists[] = ['name' => $currentListStyle . '_' . self::$currentCustomList, 'id' => self::$currentCustomList];
                        } else {
                            self::$currentCustomList = NULL;
                        }
                    }
                }
                self::$openTags[$depth] = $nodo['nodeName'];
                break;
            case 'li':
                self::$WordML .= $this->closePreviousTags($depth, $nodo['nodeName']);
                if (self::$openPs) {
                    if (self::$openLinks) {
                        self::$WordML .= '</w:hyperlink>';
                        self::$openLinks = false;
                    }
                    if (self::$openBookmark > 0) {
                        $sRet.= '<w:bookmarkEnd w:id="' . self::$openBookmark . '" />';
                        self::$openBookmark = 0;
                    }
                    self::$WordML .= '</w:p><w:p>';
                } else {
                    self::$WordML .= '<w:p>';
                    self::$openPs = true;
                }
                self::$openTags[$depth] = $nodo['nodeName'];
                self::$WordML .= $this->generateListPr($properties);
                break;
            case 'table':
                self::$WordML .= $this->closePreviousTags($depth, $nodo['nodeName']);
                self::$openTable++;
                self::$tableGrid[self::$openTable] = [];
                if (self::$openPs) {
                    if (self::$openLinks) {
                        self::$WordML .= '</w:hyperlink>';
                        self::$openLinks = false;
                    }
                    if (self::$openBookmark > 0) {
                        $sRet.= '<w:bookmarkEnd w:id="' . self::$openBookmark . '" />';
                        self::$openBookmark = 0;
                    }
                    if (self::$openBr) {
                        self::$WordML .= '<w:r>';
                        for ($j = 0; $j < self::$openBr; $j++) {
                            self::$WordML .= '<w:br />';
                        }
                        self::$WordML .= '</w:r>';
                        self::$openBr = 0;
                    }
                    self::$WordML .= '</w:p><w:tbl>';
                    self::$openPs = false;
                } else {
                    self::$WordML .= '<w:tbl>';
                }
                self::$WordML .= $this->generateTblPr($properties, $nodo['attributes']);
                self::$openTags[$depth] = $nodo['nodeName'];
                break;
            case 'tr':
                self::$WordML .= $this->closePreviousTags($depth, $nodo['nodeName']);
                array_push(self::$tableGrid[self::$openTable], []);
                self::$WordML .= '<w:tr>';
                self::$WordML .= $this->generateTrPr($properties);
                self::$openTags[$depth] = $nodo['nodeName'];
                // Hack to circumvent the fact that in WordML it is not posible to give a background color to a whole row
                self::$rowColor = $properties['background_color'];
                // Hack to circumvent the fact that in WordML w:trPr has no border property, although it can be set trough table style
                if (!isset($properties['border_top_color'])) {
                    $properties['border_top_color'] = '';
                }
                if (!isset($properties['border_top_width'])) {
                    $properties['border_top_width'] = '';
                }
                if (!isset($properties['border_top_style'])) {
                    $properties['border_top_style'] = '';
                }
                if (!isset($properties['border_bottom_color'])) {
                    $properties['border_bottom_color'] = '';
                }
                if (!isset($properties['border_bottom_width'])) {
                    $properties['border_bottom_width'] = '';
                }
                if (!isset($properties['border_bottom_style'])) {
                    $properties['border_bottom_style'] = '';
                }
                self::$borderRow = ['top' => ['color' => $properties['border_top_color'],
                    'width' => $properties['border_top_width'],
                    'style' => $properties['border_top_style']],
                    'bottom' => ['color' => $properties['border_bottom_color'],
                        'width' => $properties['border_bottom_width'],
                        'style' => $properties['border_bottom_style']],
                ];

                break;
            case 'th':
            case 'td':
                self::$WordML .= $this->closePreviousTags($depth, $nodo['nodeName']);
                $firstRow = $nodo['nodeName'] == 'th' ? true : false;

                //Now we have to deal with posible rowspans coming from previous rows
                $row = count(self::$tableGrid[self::$openTable]) - 1;
                $column = count(self::$tableGrid[self::$openTable][$row]);
                $this->countEmptyColumns($row, $column);

                //Now we have to deal with the current td
                $colspan = (int) $nodo['attributes']['colspan'];
                $rowspan = (int) $nodo['attributes']['rowspan'];
                self::$WordML .= '<w:tc>';
                for ($k = 0; $k < $colspan; $k++) {
                    array_push(self::$tableGrid[self::$openTable][count(self::$tableGrid[self::$openTable]) - 1], [$rowspan, $colspan - $k, $properties]);
                }
                self::$WordML .= $this->generateTcPr($properties, $nodo['attributes'], $colspan, $rowspan, $firstRow);
                self::$openTags[$depth] = $nodo['nodeName'];
                break;
            case 'a':
                self::$WordML .= $this->closePreviousTags($depth, $nodo['nodeName']);
                if (isset($nodo['attributes']['href']) && $nodo['attributes']['href'] != '') {//FIXME: by the time being we do not parse anchors
                    $aId = 'rId' . uniqid(mt_rand(999, 9999));
                    if (self::$openPs) {
                        if ($nodo['attributes']['href'][0] != '#') {
                            self::$openLinks = true;
                            self::$WordML .= '<w:hyperlink r:id="' . $aId . '" w:history="1">';
                            self::$linkTargets[$aId] = htmlspecialchars($this->parseURL($nodo['attributes']['href']));
                        } else if ($nodo['attributes']['href'][0] == '#' && $this->parseAnchors) {
                            self::$openLinks = true;
                            self::$WordML .= '<w:hyperlink w:anchor="' . substr($nodo['attributes']['href'], 1) . '" w:history="1">';
                        }
                    } else {
                        if ($nodo['attributes']['href'][0] != '#') {
                            self::$openLinks = true;
                            self::$WordML .= '<w:p>';
                            self::$WordML .= $this->generatePPr($properties);
                            self::$WordML .= '<w:hyperlink r:id="' . $aId . '" w:history="1">';
                            self::$linkTargets[$aId] = htmlspecialchars($this->parseURL($nodo['attributes']['href']));
                            self::$openPs = true;
                        } else if ($nodo['attributes']['href'][0] == '#' && $this->parseAnchors) {
                            self::$openLinks = true;
                            self::$WordML .= '<w:hyperlink w:anchor="' . substr($nodo['attributes']['href'], 1) . '" w:history="1">';
                            self::$openPs = true;
                        }
                    }
                } else if (isset($nodo['attributes']['name']) && $nodo['attributes']['name'] != '' && $this->parseAnchors) {
                    $tempId = rand(999999999, 9999999999999);
                    self::$WordML .= '<w:bookmarkStart w:id="' . $tempId . '" w:name="' . $nodo['attributes']['name'] . '" />';
                    self::$openBookmark = $tempId;
                }
                self::$openTags[$depth] = $nodo['nodeName'];
                break;
            case 'sub':
                if ($nodo['nodeName'] == 'sub') {
                    self::$openScript = 'subscript';
                }
            case 'sup':
                if ($nodo['nodeName'] == 'sup') {
                    self::$openScript = 'superscript';
                }
                self::$WordML .= $this->closePreviousTags($depth, $nodo['nodeName']);
                self::$openTags[$depth] = $nodo['nodeName'];
                break;
            case '#text':
                self::$WordML .= $this->closePreviousTags($depth, $nodo['nodeName']);
                if (self::$openSelect) {
                    if (count(self::$selectOptions) < 25) {
                        if (self::$selectedOption) {
                            array_unshift(self::$selectOptions, htmlspecialchars($nodo['nodeValue']));
                        } else {
                            self::$selectOptions[] = htmlspecialchars($nodo['nodeValue']);
                        }
                    } else {
                        echo 'The 25 limit of items that Word has stablished for a dropdown list has been exceeded' . PHP_EOL;
                    }
                } else if (self::$openTextArea) {
                    self::$textArea = htmlspecialchars($nodo['nodeValue']);
                } else {
                    if (self::$openPs) {
                        self::$WordML .= '<w:r>';
                    } else {
                        self::$WordML .= '<w:p>';
                        // if we are creating the paragraph by hand we have to take care of certain styles
                        // that are important to keep like inherited justification
                        $style = [];
                        if (@$properties['text_align'] != '' || @$properties['text_align'] != 'left') {
                            $style['text_align'] = $properties['text_align'];
                        }
                        if (isset($properties['direction']) && strtolower($properties['direction']) == 'rtl') {
                            $style['direction'] = 'rtl';
                        }
                        if (!empty($style))
                            self::$WordML .= $this->generatePPr($style);
                        self::$WordML .= '<w:r>';
                        self::$openPs = true;
                    }
                    self::$WordML .= $this->generateRPr($properties);
                    if (self::$openBr) {
                        for ($j = 0; $j < self::$openBr; $j++) {
                            self::$WordML .= '<w:br />';
                        }
                        self::$openBr = 0;
                    }
                    self::$WordML .= '<w:t xml:space="preserve">' . htmlspecialchars($nodo['nodeValue']) . '</w:t>';
                    self::$WordML .= '</w:r>';
                }
                self::$openTags[$depth] = $nodo['nodeName'];
                break;
            case 'br':
                self::$WordML .= $this->closePreviousTags($depth, $nodo['nodeName']);
                if (self::$openPs) {
                    self::$openBr++;
                } else {
                    self::$WordML .= '<w:p />';
                }
                break;
            case 'img':
                self::$WordML .= $this->closePreviousTags($depth, $nodo['nodeName']);
                //We first check if the image has an allowed extension
                $descrArray = explode('/', $nodo['attributes']['src']);
                $arrayExtension = explode('.', $this->parseURL($nodo['attributes']['src']));
                $descr = array_pop($descrArray);
                $descr = array_shift(explode('?', $descr));
                $extension = strtolower(array_pop($arrayExtension));
                $extension = array_shift(explode('?', $extension));
                $predefinedExtensions = explode(',', PHPDOCX_ALLOWED_IMAGE_EXT);
                $hiddenExtension = '';
                if (!in_array($extension, $predefinedExtensions)) {
                    $extensionId = exif_imagetype($this->parseURL($nodo['attributes']['src']));
                    $extensionArray = [];
                    $extensionArray[1] = 'gif';
                    $extensionArray[2] = 'jpg';
                    $extensionArray[3] = 'png';
                    $extensionArray[6] = 'bmp';
                    $extension = $extensionArray[$extensionId];
                    $hiddenExtension = $extension;
                }


                if (!in_array($extension, $predefinedExtensions)) {
                    continue;
                }
                $photo = @file_get_contents($this->parseURL($nodo['attributes']['src']));
                if (!$photo)
                    continue;

                if (self::$openPs) {
                    self::$WordML .= '<w:r>';
                } else {
                    self::$WordML .= '<w:p>';
                    self::$WordML .= '<w:r>';
                    self::$openPs = true;
                }
                $imgId = 'rId' . uniqid(mt_rand(999, 9999));
                $tempName = 'name' . uniqid(mt_rand(999, 9999));
                //We get the photos to parse their properties
                //$size = getimagesizefromstring($photo); only works for > 5.4
                $tempDir = CreateDocx::getTempDir();
                $photoHandle = fopen($tempDir . '/img' . $imgId . '.' . $extension, "w+");
                $contents = fwrite($photoHandle, $photo);
                fclose($photoHandle);
                $size = getimagesize($tempDir . '/img' . $imgId . '.' . $extension);
                unlink($tempDir . '/img' . $imgId . '.' . $extension);
                if ($this->downloadImages) {
                    self::$zipDocx->addFromString('word/media/img' . $imgId . '.' . $extension, $photo);
                }
                //Check if the size is defined in the attributes or in the CSS styles
                $imageSize = [];
                if (isset($nodo['attributes']['width'])) {
                    $imageSize['width'] = $nodo['attributes']['width'];
                }
                if (isset($nodo['attributes']['height'])) {
                    $imageSize['height'] = $nodo['attributes']['height'];
                }
                if (isset($properties['width']) && $properties['width'] != 'auto') {
                    $properties['width'] = str_replace(' ', '', $properties['width']);
                    $imageSize['width'] = $this->CSSUnits2Pixels($properties['width'], $properties['font_size']);
                }
                if (isset($properties['height']) && $properties['height'] != 'auto') {
                    $properties['height'] = str_replace(' ', '', $properties['height']);
                    $imageSize['height'] = $this->CSSUnits2Pixels($properties['height'], $properties['font_size']);
                }

                $c = $this->getImageDimensions($size, $imageSize);
                $cx = $c[0];
                $cy = $c[1];
                self::$WordML .= $this->generateImageRPr($properties, $cy);

                self::$openTags[$depth] = $nodo['nodeName'];



                //Now we will manage the image borders if any
                if (isset($properties['border_top_style']) && $properties['border_top_style'] != 'none') {
                    $imageBorderWidth = $properties['border_top_width'] * 9600;
                    $imageBorderStyle = self::$imageBorderStyles[$properties['border_top_style']];
                    $imageBorderColor = $this->wordMLColor($properties['border_top_color']);
                } else {
                    $imageBorderWidth = 0;
                    $imageBorderStyle = '';
                    $imageBorderColor = '';
                }
                //We now take care of paddings and margins
                $distance = [];
                foreach (self::$borders as $key => $value) {
                    $distance[$value] = $this->imageMargins($properties['margin_' . $value], $properties['padding_' . $value], $properties['font_size']);
                }
                //Positioning
                if (isset($properties['float']) && ($properties['float'] == 'left' || $properties['float'] == 'right')) {
                    $docPr = rand(99999, 99999999);
                    self::$WordML .= '<w:drawing><wp:anchor distT="' . $distance['top'] . '" distB="' . $distance['bottom'] . '" distL="' . $distance['left'] . '" distR="' . $distance['right'] . '" simplePos="0" relativeHeight="251658240" behindDoc="0" locked="0" layoutInCell="1" allowOverlap="0"><wp:simplePos x="0" y="0" />';
                    self::$WordML .= '<wp:positionH relativeFrom="column"><wp:align>' . $properties['float'] . '</wp:align></wp:positionH>';
                    self::$WordML .= '<wp:positionV relativeFrom="line"><wp:posOffset>40000</wp:posOffset></wp:positionV>';
                    self::$WordML .= '<wp:extent cx="' . $cx . '" cy="' . $cy . '" /><wp:wrapSquare wrapText="bothSides" /><wp:docPr id="' . $docPr . '" name="' . $tempName . '" descr="' . rawurlencode($descr) . '" />';
                    self::$WordML .= '<wp:cNvGraphicFramePr><a:graphicFrameLocks xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main" noChangeAspect="1" /></wp:cNvGraphicFramePr><a:graphic xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main">';
                    self::$WordML .= '<a:graphicData uri="http://schemas.openxmlformats.org/drawingml/2006/picture"><pic:pic xmlns:pic="http://schemas.openxmlformats.org/drawingml/2006/picture"><pic:nvPicPr><pic:cNvPr id="0" name="' . rawurlencode($descr) . '"/><pic:cNvPicPr/></pic:nvPicPr><pic:blipFill>';
                    if ($this->downloadImages) {
                        self::$WordML .= '<a:blip r:embed="' . $imgId . '" cstate="print"/>';
                    } else {
                        self::$WordML .= '<a:blip r:link="' . $imgId . '" cstate="print"/>';
                    }
                    self::$WordML .= '<a:stretch><a:fillRect/></a:stretch></pic:blipFill><pic:spPr><a:xfrm><a:off x="0" y="0"/><a:ext cx="' . $cx . '" cy="' . $cy . '" /></a:xfrm><a:prstGeom prst="rect"><a:avLst/></a:prstGeom>';
                    self::$WordML .= $this->imageBorders($imageBorderWidth, $imageBorderStyle, $imageBorderColor);
                    self::$WordML .= '</pic:spPr></pic:pic></a:graphicData></a:graphic></wp:anchor></w:drawing>';
                } else {
                    self::$WordML .= '<w:drawing><wp:inline distT="' . $distance['top'] . '" distB="' . $distance['bottom'] . '" distL="' . $distance['left'] . '" distR="' . $distance['right'] . '"><wp:extent cx="' . $cx . '" cy="' . $cy . '" />';
                    self::$WordML .= '<wp:docPr id="' . rand(99999, 99999999) . '" name="' . $tempName . '" descr="' . rawurlencode($descr) . '" /><wp:cNvGraphicFramePr><a:graphicFrameLocks xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main" noChangeAspect="1" /></wp:cNvGraphicFramePr>';
                    self::$WordML .= '<a:graphic xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main"><a:graphicData uri="http://schemas.openxmlformats.org/drawingml/2006/picture"><pic:pic xmlns:pic="http://schemas.openxmlformats.org/drawingml/2006/picture">';
                    self::$WordML .= '<pic:nvPicPr><pic:cNvPr id="0" name="' . rawurlencode($descr) . '"/><pic:cNvPicPr/></pic:nvPicPr><pic:blipFill>';
                    if ($this->downloadImages) {
                        self::$WordML .= '<a:blip r:embed="' . $imgId . '" cstate="print"/>';
                    } else {
                        self::$WordML .= '<a:blip r:link="' . $imgId . '" cstate="print"/>';
                    }
                    self::$WordML .= '<a:stretch><a:fillRect/></a:stretch></pic:blipFill><pic:spPr><a:xfrm><a:off x="0" y="0"/><a:ext cx="' . $cx . '" cy="' . $cy . '" /></a:xfrm><a:prstGeom prst="rect"><a:avLst/></a:prstGeom>';
                    self::$WordML .= $this->imageBorders($imageBorderWidth, $imageBorderStyle, $imageBorderColor);
                    self::$WordML .= '</pic:spPr></pic:pic></a:graphicData></a:graphic></wp:inline></w:drawing>';
                }
                self::$WordML .= '</w:r>';
                if (empty($hiddenExtension)) {
                    self::$linkImages[$imgId] = $this->parseURL($nodo['attributes']['src']);
                } else {
                    self::$linkImages[$imgId] = $this->parseURL($nodo['attributes']['src']) . '.' . $hiddenExtension;
                }
                break;
            case 'hr':
                self::$WordML .= $this->closePreviousTags($depth, $nodo['nodeName']);
                if (self::$openPs) {
                    self::$WordML .= '<w:r><w:pict><v:rect id="_x0000_i1026" style="width:0;height:1.5pt" o:hralign="center" o:hrstd="t" o:hr="t" fillcolor="#aca899" stroked="f" /></w:pict></w:r>';
                } else {
                    self::$WordML .= '<w:p><w:r><w:pict><v:rect id="_x0000_i1026" style="width:0;height:1.5pt" o:hralign="center" o:hrstd="t" o:hr="t" fillcolor="#aca899" stroked="f" /></w:pict></w:r></w:p>';
                }
                break;
            case 'input':
                self::$WordML .= $this->closePreviousTags($depth, $nodo['nodeName']);
                if (isset($nodo['attributes']['type']) && $nodo['attributes']['type'] == 'text') {
                    if (self::$openPs) {
                        //do not do anything
                    } else {
                        self::$WordML .= '<w:p>';
                        // if we are creating the paragraph by hand we have to take care of certain styles
                        // that are important to keep like inherited justification
                        $style = [];
                        if (@$properties['text_align'] != '' || @$properties['text_align'] != 'left') {
                            $style['text_align'] = $properties['text_align'];
                        }
                        if (!empty($style))
                            self::$WordML .= $this->generatePPr($style);
                        self::$openPs = true;
                    }
                    //we check if there is a br open
                    if (self::$openBr) {
                        self::$WordML .= '<w:rPr>';
                        for ($j = 0; $j < self::$openBr; $j++) {
                            self::$WordML .= '<w:br />';
                        }
                        self::$openBr = 0;
                        self::$WordML .= '</w:rPr>';
                    }
                    //Now we insert the corresponding XML
                    $bookmarkId = rand(99999, 9999999);
                    $uniqueName = uniqid(mt_rand(999, 9999));
                    self::$WordML .= '<w:r><w:fldChar w:fldCharType="begin"><w:ffData><w:name w:val="Texto' . $uniqueName . '"/><w:enabled/><w:calcOnExit w:val="0"/><w:textInput/></w:ffData></w:fldChar></w:r><w:bookmarkStart w:id="' . $bookmarkId . '" w:name="Texto' . $uniqueName . '"/><w:r><w:instrText xml:space="preserve"> FORMTEXT </w:instrText></w:r><w:r><w:fldChar w:fldCharType="separate"/></w:r><w:r><w:rPr><w:noProof/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r><w:rPr><w:noProof/></w:rPr><w:t xml:space="preserve">';
                    if (isset($nodo['attributes']['value']) && $nodo['attributes']['value'] != '') {
                        self::$WordML .= $nodo['attributes']['value'];
                    } else {
                        if (isset($nodo['attributes']['size']) && $nodo['attributes']['size'] > 0) {
                            $size = $nodo['attributes']['size'];
                        } else {
                            $size = 18;
                        }
                        for ($k = 0; $k <= $size; $k++) {
                            self::$WordML .=' '; //blank characters for Word
                        }
                    }
                    self::$WordML .='</w:t></w:r><w:r><w:rPr><w:noProof/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r><w:rPr><w:noProof/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r><w:fldChar w:fldCharType="end"/></w:r><w:bookmarkEnd w:id="' . $bookmarkId . '"/>';
                } else if (isset($nodo['attributes']['type']) && ($nodo['attributes']['type'] == 'checkbox' || $nodo['attributes']['type'] == 'radio')) {
                    if (self::$openPs) {
                        //do not do anything
                    } else {
                        self::$WordML .= '<w:p>';
                        // if we are creating the paragraph by hand we have to take care of certain styles
                        // that are important to keep like inherited justification
                        $style = [];
                        if (@$properties['text_align'] != '' || @$properties['text_align'] != 'left') {
                            $style['text_align'] = $properties['text_align'];
                        }
                        if (!empty($style))
                            self::$WordML .= $this->generatePPr($style);
                        self::$openPs = true;
                    }
                    //Now we insert the corresponding XML
                    $bookmarkId = rand(99999, 9999999);
                    $uniqueName = uniqid(mt_rand(999, 9999));
                    if (isset($nodo['attributes']['checked']) && $nodo['attributes']['checked']) {
                        $selected = 1;
                    } else {
                        $selected = 0;
                    }
                    //we check if there is a br open
                    if (self::$openBr) {
                        self::$WordML .= '<w:rPr>';
                        for ($j = 0; $j < self::$openBr; $j++) {
                            self::$WordML .= '<w:br />';
                        }
                        self::$openBr = 0;
                        self::$WordML .= '</w:rPr>';
                    }
                    self::$WordML .= '<w:r><w:fldChar w:fldCharType="begin"><w:ffData><w:name w:val="cbox' . $uniqueName . '"/><w:enabled/><w:calcOnExit w:val="0"/><w:checkBox><w:sizeAuto/><w:default w:val="' . $selected . '"/></w:checkBox></w:ffData></w:fldChar></w:r><w:bookmarkStart w:id="' . $bookmarkId . '" w:name="cbox' . $uniqueName . '"/><w:r><w:instrText xml:space="preserve"> FORMCHECKBOX </w:instrText></w:r><w:r><w:fldChar w:fldCharType="separate"/></w:r><w:r><w:fldChar w:fldCharType="end"/></w:r><w:bookmarkEnd w:id="' . $bookmarkId . '"/>';
                }
                break;
            case 'select':
                self::$WordML .= $this->closePreviousTags($depth, $nodo['nodeName']);
                self::$openTags[$depth] = $nodo['nodeName'];
                self::$selectOptions = [];
                if (self::$openPs) {
                    //do not do anything
                } else {
                    self::$WordML .= '<w:p>';
                    // if we are creating the paragraph by hand we have to take care of certain styles
                    // that are important to keep like inherited justification
                    $style = [];
                    if (@$properties['text_align'] != '' || @$properties['text_align'] != 'left') {
                        $style['text_align'] = $properties['text_align'];
                    }
                    if (!empty($style))
                        self::$WordML .= $this->generatePPr($style);
                    self::$openPs = true;
                }
                break;
            case 'option':
                self::$WordML .= $this->closePreviousTags($depth, $nodo['nodeName']);
                self::$openTags[$depth] = $nodo['nodeName'];
                self::$openSelect = true;
                if (isset($nodo['attributes']['selected']) && $nodo['attributes']['selected']) {
                    self::$selectedOption = 1;
                } else {
                    self::$selectedOption = 0;
                }
                break;
            case 'textarea':
                self::$WordML .= $this->closePreviousTags($depth, $nodo['nodeName']);
                self::$openTags[$depth] = $nodo['nodeName'];
                self::$openTextArea = true;
                if (self::$openPs) {
                    //do not do anything
                } else {
                    self::$WordML .= '<w:p>';
                    // if we are creating the paragraph by hand we have to take care of certain styles
                    // that are important to keep like inherited justification
                    $style = [];
                    if (@$properties['text_align'] != '' || @$properties['text_align'] != 'left') {
                        $style['text_align'] = $properties['text_align'];
                    }
                    if (!empty($style))
                        self::$WordML .= $this->generatePPr($style);
                    self::$openPs = true;
                }
                break;
            case 'samp':
                self::$WordML .= $this->closePreviousTags($depth, $nodo['nodeName']);
                self::$openTags[$depth] = $nodo['nodeName'];
                //we use this tag also for Word footnotes if the attribute title has the
                //structure phpdocx_footnote_number or phpdocx_endnote_number
                $title = $nodo['attributes']['title'];
                $titArray = explode('_', $title);
                if ($titArray[0] == 'phpdocx') {
                    if ($titArray[1] == 'footnote') {
                        self::$WordML .= '<w:r><w:rPr>';
                        if (isset($properties['font_family']) && $properties['font_family'] != 'serif' && $properties['font_family'] != 'fixed') {
                            $arrayCSSFonts = explode(',', $properties['font_family']);
                            $font = trim($arrayCSSFonts[0]);
                            $font = str_replace('"', '', $font);
                            self::$WordML .= '<w:rFonts w:ascii="' . $font . '" w:hAnsi="' . $font . '" w:eastAsia="' . $font . '" w:cs="' . $font . '" /> ';
                        }
                        if (@$properties['color'] != '' && is_array($properties['color'])) {
                            $color = $properties['color'];
                            $color = $this->wordMLColor($color);
                            self::$WordML .='<w:color w:val="' . $color . '" />';
                        }
                        self::$WordML .='<w:vertAlign w:val="superscript" /></w:rPr><w:footnoteReference w:id="' . $titArray[2] . '" /></w:r>';
                    } else if ($titArray[1] == 'endnote') {
                        self::$WordML .= '<w:r><w:rPr>';
                        if (isset($properties['font_family']) && $properties['font_family'] != 'serif') {
                            $arrayCSSFonts = explode(',', $properties['font_family']);
                            $font = trim($arrayCSSFonts[0]);
                            $font = str_replace('"', '', $font);
                            self::$WordML .= '<w:rFonts w:ascii="' . $font . '" w:hAnsi="' . $font .'" w:eastAsia="' . $font . '" w:cs="' . $font . '" /> ';
                        }
                        if (@$properties['color'] != '' && is_array($properties['color'])) {
                            $color = $properties['color'];
                            $color = $this->wordMLColor($color);
                            self::$WordML .='<w:color w:val="' . $color . '" />';
                        }
                        self::$WordML .='<w:vertAlign w:val="superscript" /></w:rPr><w:endnoteReference w:id="' . $titArray[2] . ' " /></w:r>';
                    }
                }
                break;
            case 'close':
                self::$WordML .= $this->closePreviousTags($depth, $nodo['nodeName']);
                break;
            default:
                self::$WordML .= $this->closePreviousTags($depth, $nodo['nodeName']);
                self::$openTags[$depth] = $nodo['nodeName'];
                break;
        }
        ++$depth;
        /* if($nodo['nodeName'] == 'table'){
          var_dump($properties);
          var_dump($nodo['attributes']);
          } */
        if (isset($properties['display']) && $properties['display'] == 'none') {
            //do not render that subtree
        } else {

            if (!empty($nodo['children'])) {
                foreach ($nodo['children'] as $child) {
                    $this->_render($child, $depth);
                }
            }
        }
    }

    /**
     * This function takes care that all nodes are properly closed
     *
     * @access private
     * @param integer $depth
     * @param string $currentTag
     */
    private function closePreviousTags($depth, $currentTag = '')
    {
        $sRet = '';

        $counter = count(self::$openTags);
        for ($j = $counter; $j >= $depth - 1; $j--) {
            $tag = array_pop(self::$openTags);

            switch ($tag) {
                case 'div':
                    if (!$this->parseDivs)
                        break;
                case 'h1':
                case 'h2':
                case 'h3':
                case 'h4':
                case 'h5':
                case 'h6':
                case 'p':
                case 'dt':
                case 'dd':
                case 'li':
                    if (self::$openPs) {
                        if (self::$openLinks) {
                            $sRet.= '</w:hyperlink>';
                            self::$openLinks = false;
                        }
                        if (self::$openBookmark > 0) {
                            $sRet.= '<w:bookmarkEnd w:id="' . self::$openBookmark . '" />';
                            self::$openBookmark = 0;
                        }
                        $sRet .= '</w:p>';
                        self::$openPs = false;
                    }
                    break;
                case 'table':
                    if (self::$openPs) {
                        if (self::$openLinks) {
                            $sRet.= '</w:hyperlink>';
                            self::$openLinks = false;
                        }
                        if (self::$openBookmark > 0) {
                            $sRet.= '<w:bookmarkEnd w:id="' . self::$openBookmark . '" />';
                            self::$openBookmark = 0;
                        }
                        $sRet .= '</w:p></w:tbl>';
                        self::$openPs = false;
                    } else {
                        if (self::$openTable > 1) {
                            //This is to fix a Word bug that does not allow to close a table and write just after a </w:tc>
                            $sRet .= '</w:tbl><w:p />';
                        } else {
                            $sRet .= '</w:tbl>';
                        }
                    }
                    self::$openTable--;
                    break;
                case 'tr':
                    //Before closing a row we should make sure that there are no lacking cells due to a previous rowspan
                    $row = count(self::$tableGrid[self::$openTable]) - 1;
                    $column = count(self::$tableGrid[self::$openTable][$row]);
                    $sRet .= $this->closeTr($row, $column);
                    if (strpos(self::$WordML, '#<w:gridCol/>#') !== false) {
                        self::$WordML = str_replace('#<w:gridCol/>#', str_repeat('<w:gridCol/>', $column), self::$WordML);
                    }
                    //We now may close the tr tag
                    $sRet .= '</w:tr>';
                    break;
                case 'td':
                case 'th':
                    if (self::$openPs) {
                        if (self::$openLinks) {
                            $sRet.= '</w:hyperlink>';
                            self::$openLinks = false;
                        }
                        if (self::$openBookmark > 0) {
                            $sRet.= '<w:bookmarkEnd w:id="' . self::$openBookmark . '" />';
                            self::$openBookmark = 0;
                        }
                        $sRet .= '</w:p>';
                        if (self::$openBr) {
                            for ($p = 0; $p < self::$openBr; $p++) {
                                $sRet .= '<w:p />';
                            }
                            self::$openBr = 0;
                        }
                        $sRet .= '</w:tc>';
                        self::$openPs = false;
                    } else {
                        if (self::$openBr) {
                            for ($p = 0; $p < self::$openBr; $p++) {
                                $sRet .= '<w:p />';
                            }
                            self::$openBr = 0;
                        }
                        $sRet .= '</w:tc>';
                    }
                    break;
                case 'a':
                    if (self::$openLinks) {
                        $sRet.= '</w:hyperlink>';
                        self::$openLinks = false;
                    }
                    if (self::$openBookmark > 0) {
                        $sRet.= '<w:bookmarkEnd w:id="' . self::$openBookmark . '" />';
                        self::$openBookmark = 0;
                    }
                    break;
                case 'sub':
                case 'sup':
                    self::$openScript = '';
                    break;
                case '#text':
                    if ($currentTag == 'close' && !self::$openSelect && !self::$openTextArea) {
                        if (self::$openLinks) {
                            $sRet.= '</w:hyperlink>';
                            self::$openLinks = false;
                        }
                        if (self::$openBookmark > 0) {
                            $sRet.= '<w:bookmarkEnd w:id="' . self::$openBookmark . '" />';
                            self::$openBookmark = 0;
                        }
                        $sRet .= '</w:p>';
                        self::$openPs = false;
                    }
                    break;
                case 'select':
                    self::$openSelect = false;
                    $dropdownId = uniqid(mt_rand(999, 9999));
                    $bookmarkId = rand(99999, 99999999);
                    //Now we have to write the whole wordML
                    $sRet .= '<w:bookmarkStart w:id="' . $bookmarkId . '" w:name="d_' . $dropdownId . '"/><w:r><w:fldChar w:fldCharType="begin"><w:ffData><w:name w:val="d_' . $dropdownId . '"/><w:enabled/><w:calcOnExit w:val="0"/><w:ddList>';
                    foreach (self::$selectOptions as $key => $value) {
                        $sRet .= '<w:listEntry w:val="' . $value . '"/>';
                    }
                    $sRet .= '</w:ddList></w:ffData></w:fldChar></w:r><w:r><w:instrText xml:space="preserve"> FORMDROPDOWN </w:instrText></w:r><w:r><w:fldChar w:fldCharType="end"/></w:r><w:bookmarkEnd w:id="' . $bookmarkId . '"/>';
                    if ($currentTag == 'close' && self::$openPs) {
                        $sRet .= '</w:p>';
                        self::$openPs = false;
                    }
                    break;
                case 'option':
                    self::$openSelect = false;
                    break;
                case 'textarea':
                    self::$openTextArea = false;
                    $bookmarkId = rand(99999, 9999999);
                    $uniqueName = uniqid(mt_rand(999, 9999));
                    $sRet .= '<w:r><w:fldChar w:fldCharType="begin"><w:ffData><w:name w:val="Texto' . $uniqueName . '"/><w:enabled/><w:calcOnExit w:val="0"/><w:textInput/></w:ffData></w:fldChar></w:r><w:bookmarkStart w:id="' . $bookmarkId . '" w:name="Texto' . $uniqueName . '"/><w:r><w:instrText xml:space="preserve"> FORMTEXT </w:instrText></w:r><w:r><w:fldChar w:fldCharType="separate"/></w:r><w:r><w:rPr><w:noProof/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r><w:rPr><w:noProof/></w:rPr><w:t xml:space="preserve">';
                    if (self::$textArea != '') {
                        $sRet .= self::$textArea;
                    } else {
                        if (isset($nodo['attributes']['size']) && $nodo['attributes']['size'] > 0) {
                            $size = $nodo['attributes']['size'];
                        } else {
                            $size = 18;
                        }
                        for ($k = 0; $k <= $size; $k++) {
                            $sRet .= ' '; //blank characters for Word
                        }
                    }
                    $sRet .= '</w:t></w:r><w:r><w:rPr><w:noProof/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r><w:rPr><w:noProof/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r><w:fldChar w:fldCharType="end"/></w:r><w:bookmarkEnd w:id="' . $bookmarkId . '"/>';
                    if ($currentTag == 'close' && self::$openPs) {
                        $sRet .= '</w:p>';
                        self::$openPs = false;
                    }
                    break;
                default:
                    if ($currentTag == 'close') {
                        if (self::$openLinks) {
                            $sRet.= '</w:hyperlink>';
                            self::$openLinks = false;
                        }
                        if (self::$openBookmark > 0) {
                            $sRet.= '<w:bookmarkEnd w:id="' . self::$openBookmark . '" />';
                            self::$openBookmark = 0;
                        }
                        if (self::$openPs) {
                            $sRet .= '</w:p >';
                            if (self::$openBr) {
                                $sRet .= '<w:p />';
                                self::$openBr = false;
                            }
                            self::$openPs = false;
                        }
                    }
            }
        }

        return($sRet);
    }

    /**
     * This function returns the default style for paragraphs inside a list
     *
     * @access private
     * @return string
     */
    private function listStyle()
    {
        return 'ListParagraphPHPDOCX';
    }

    /**
     * This function returns the default types of lists
     *
     * @access private
     * @param array $tipo
     * @return string
     */
    private function listType($tipo = [1, 2])
    {
        $counter = count(self::$openTags);
        for ($j = $counter; $j >= ($this->_level - 1); $j--) {
            if (@self::$openTags[$j] == 'ul') {
                $num = $tipo[0];
                break;
            } else if (@self::$openTags[$j] == 'ol') {
                $num = $tipo[1];
                break;
            }
        }
        if (isset($num)) {
            return $num;
        } else {
            return $tipo[0];
        }
    }

    /**
     * This function returns the WordML formatting for a paragraph
     * Support:
     * w:pStyle,
     * w:keepNext (page-break-after="avoid"),
     * w:keepLines (page-break-inside="avoid"),
     * w:pageBreakBefore (page-break-before="always"),
     * w:widowControl (page-break-before="avoid"),
     * w:pBdr (border-[top|left|bottom|right]-style!="none")(border-[top|left|bottom|right]-color)(border-[top|left|bottom|right]-width)(border!="none"),
     * w:shd (background-color)(background),
     * w:bidi (attribute dir="rtl"),
     * w:spacing ([margin|padding]-top)([margin|padding]-bottom)(font-size)(line-height),
     * w:ind ([margin|padding]-left)([margin|padding]-right)(font-size)(text-indent),
     * w:jc (text-align),
     * w:textDirection (attribute dir="rtl"),
     * w:textAlignment (vertical-align!="baseline")(font-size),
     * w:outlineLvl
     *
     * @access private
     * @param array $properties
     * @param array $level
     * @return string
     */
    private function generatePPr($properties, $level = '', $attributes = [], $nodeName = false)
    {
        $stringPPr = '<w:pPr>';
        $sTempStyle = $this->generateWordStyle($nodeName, $attributes);
        if ($sTempStyle) {
            $stringPPr .= '<w:pStyle w:val="' . $sTempStyle . '"/>';
        }

        if (isset($properties['page_break_after']) && $properties['page_break_after'] == 'avoid') {
            $stringPPr .= '<w:keepNext w:val="on" />';
        }
        if (isset($properties['page_break_inside']) && $properties['page_break_inside'] == 'avoid') {
            $stringPPr .= '<w:keepLines w:val="on" />';
        }
        if (isset($properties['page_break_before']) && $properties['page_break_before'] == 'always') {
            $stringPPr .= '<w:pageBreakBefore w:val="on" />';
        }
        if (isset($properties['float']) && ($properties['float'] == 'left' || $properties['float'] == 'right') && $this->parseFloats) {
            $distance = [];
            foreach (self::$borders as $key => $value) {
                $distance[$value] = $this->imageMargins($properties['margin_' . $value], $properties['padding_' . $value], $properties['font_size']);
            }
            $stringPPr .= '<w:framePr w:w="' . ($distance['right'] - $distance['left']) . '" w:h="' . ($distance['top'] - $distance['bottom']) . '" w:vSpace="' . $distance['top'] . '" w:hSpace="' . $distance['right'] . '" w:wrap="around" w:hAnchor="text" w:vAnchor="text" w:xAlign="' . $properties['float'] . '" w:yAlign="inside" />';
        }
        if (isset($properties['page_break_before']) && $properties['page_break_before'] == 'avoid') {
            $stringPPr .= '<w:widowControl w:val="off" />';
        } else {
            $stringPPr .= '<w:widowControl w:val="on" />';
        }
        if (!$this->strictWordStyles) {
            $stringPPr .= '<w:pBdr>';
            foreach (self::$borders as $key => $value) {
                if (isset($properties['border_' . $value . '_style']) && $properties['border_' . $value . '_style'] != 'none') {
                    $stringPPr .= '<w:' . $value . ' w:val="' . $this->getBorderStyles($properties['border_' . $value . '_style']) . '"  w:color="' . $this->wordMLColor($properties['border_' . $value . '_color']) . '" w:sz="' . $this->wordMLLineWidth(isset($properties['border_' . $value . '_width']) ? $properties['border_' . $value . '_width'] : '') . '" />';
                }
            }
            $stringPPr .= '</w:pBdr>';
            if (isset($properties['background_color']) && is_array($properties['background_color'])) {
                $color = $properties['background_color'];
                $color = $this->wordMLColor($color);
                $stringPPr .='<w:shd w:val="clear"  w:color="auto" w:fill="' . $color . '" />';
            }
        }
        //w:wordWrap //css3
        if ((isset($attributes['dir']) && strtolower($attributes['dir']) == 'rtl') ||
            (isset($properties['direction']) && strtolower($properties['direction']) == 'rtl')) {
            $stringPPr .= '<w:bidi w:val="1" />';
        }
        if (!$this->strictWordStyles) {
            $stringPPr .= $this->pPrSpacing($properties);
            $stringPPr .= $this->pPrIndent($properties);

            if (isset($properties['text_align'])) {
                $textAlign = self::$text_align[$properties['text_align']];
                if (empty($textAlign)) {
                    $textAlign = 'left';
                }
                $stringPPr .= '<w:jc w:val="' . $textAlign . '" />';
            }
        }
        if (isset($attributes['dir']) && array_key_exists($attributes['dir'], self::$text_direction)) {
            $stringPPr .= '<w:textDirection w:val="' . self::$text_direction[$attributes['dir']] . '" />';
        }
        if (!$this->strictWordStyles) {
            if (isset($properties['vertical_align']) && $properties['vertical_align'] != 'baseline') {
                $stringPPr .='<w:textAlignment w:val="' . $this->_verticalAlign($properties['vertical_align']) . '" />';
            }
        }
        if (is_numeric($level)) {
            $stringPPr .= $this->setHeading($level);
        }

        $stringPPr .= '</w:pPr>';
        return $stringPPr;
    }

    /**
     * This function returns the WordML formatting for a run of text
     * Support:
     * w:rFonts (font-family!="serif"),
     * w:b (font-weight="[bold|bolder]"),
     * w:i (font-style=["italic|oblique"),
     * w:caps (text-transform="uppercase"),
     * w:smallCaps (font-variant="small-caps"),
     * w:strike (text-decoration="line-through"),
     * w:color (color),
     * w:position (vertical-align!="baseline")(font-size),
     * w:sz (font-size),
     * w:u (text-decoration="underline")
     *
     * @access private
     * @param array $properties
     * @return string
     */
    private function generateRPr($properties, $level = '', $attributes = [], $nodeName = false)
    {
        $stringRPr = '<w:rPr>';
        $sTempStyle = $this->generateWordStyle($nodeName, $attributes);
        if ($sTempStyle) {
            $stringRPr .= '<w:rStyle w:val="' . $sTempStyle . '"/>';
        }
        if (!$this->strictWordStyles) {
            if (isset($properties['font_family']) && $properties['font_family'] != 'serif') {
                $arrayCSSFonts = explode(',', $properties['font_family']);
                $font = trim($arrayCSSFonts[0]);
                $font = str_replace('"', '', $font);
                $stringRPr .= '<w:rFonts w:ascii="' . $font . '" w:hAnsi="' . $font . '" w:eastAsia="' . $font . '" w:cs="' . $font . '" /> ';
            }
        }
        if (@$properties['font_weight'] == 'bold' || @$properties['font_weight'] == 'bolder') {
            $stringRPr .='<w:b /><w:bCs />';
        }
        if (@$properties['font_style'] == 'italic' || @$properties['font_style'] == 'oblique') {
            $stringRPr .='<w:i /><w:iCs />';
        }
        if (isset($properties['text_transform']) && $properties['text_transform'] == 'uppercase') {
            $stringRPr .='<w:caps />';
        }
        if (isset($properties['font_variant']) && $properties['font_variant'] == 'small-caps') {
            $stringRPr .='<w:smallCaps />';
        }
        if (isset($properties['text_decoration']) && $properties['text_decoration'] == 'line-through') {
            $stringRPr .='<w:strike />';
        }
        if (!$this->strictWordStyles) {
            if (@$properties['color'] != '' && is_array($properties['color'])) {
                $color = $properties['color'];
                $color = $this->wordMLColor($color);
                $stringRPr .='<w:color w:val="' . $color . '" />';
            }
            if (isset($properties['vertical_align']) && $properties['vertical_align'] != 'baseline') {
                $stringRPr .='<w:position w:val="' . $this->_rprPosition($properties['vertical_align'], $properties['font_size']) . '" />';
            }
            if (@$properties['font_size'] != '') {
                $stringRPr .='<w:sz w:val="' . (int) round($properties['font_size'] * 2) . '" />';
                $stringRPr .='<w:szCs w:val="' . (int) round($properties['font_size'] * 2) . '" />';
            }
            /* The higlights in Word have their own simple type: ST_HighlightColor
             * if (isset($properties['background_color']) && is_array($properties['background_color'])) {
             * $color = $this->wordMLNamedColor($properties['background_color']);
             * $stringRPr .='<w:highlight w:val="' . $color . '" />';
              } */
        }
        if ((self::$openLinks && @$properties['text_decoration'] != 'none') || @$properties['text_decoration'] == 'underline') {
            $stringRPr .='<w:u w:val="single" />';
        }
        if (!$this->strictWordStyles) {
            //w:bdr
            if (@$properties['background_color'] != '' && is_array($properties['background_color'])) {
                $color = $properties['background_color'];
                $color = $this->wordMLColor($color);
                $stringRPr .='<w:shd w:val="clear" w:color="auto" w:fill="' . $color . '" />';
            }
        }
        if (self::$openScript != '') {
            $stringRPr .='<w:vertAlign w:val="' . self::$openScript . '" />';
        }
        //w:rtl
        if (isset($properties['direction']) && strtolower($properties['direction']) == 'rtl') {
            $stringRPr .='<w:rtl w:val="1" />';
        }
        //w:em //text-emphasis (css 3)
        //w:oMath
        $stringRPr .= '</w:rPr>';
        return $stringRPr;
    }

    /**
     * This function returns the WordML formatting for a table
     * Support:
     * w:tblStyle (border),
     * w:bidiVisual (attribute dir="rtl"),
     * w:tblW (width),
     * w:jc (attribute align),
     * w:tblCellSpacing ([attribute cellspacing|border-spacing]),
     * w:tblInd (text-indent),
     * w:tblBorders (border_width)(border-[top|left|bottom|right]-style)(border-[top|left|bottom|right]-color)(border-[top|left|bottom|right]-width),
     * w:shd (background)(background-color),
     *
     * @access private
     * @param array $properties
     * @param integer $border
     * @return string
     */
    private function generateTblPr($properties, $attributes)
    {
        $stringTblPr = '<w:tblPr>';
        $sTempStyle = $this->generateWordStyle('table', $attributes);
        if (empty($sTempStyle)) {
            if (isset($attributes['border']) && ((int) $attributes['border']) >= 1) {
                $stringTblPr .= '<w:tblStyle w:val="TableGridPHPDOCX" />';
            } else {
                $stringTblPr .= '<w:tblStyle w:val="NormalTablePHPDOCX" />';
            }
        } else {
            $stringTblPr .= '<w:tblStyle w:val="' . $sTempStyle . '"/>';
        }
        if (isset($properties['float']) && ($properties['float'] == 'left' || $properties['float'] == 'right') && $this->parseFloats) {
            $distance = [];
            foreach (self::$borders as $key => $value) {
                $distance[$value] = $this->imageMargins($properties['margin_' . $value], $properties['padding_' . $value], $properties['font_size']);
            }
            $stringTblPr .= '<w:tblpPr w:leftFromText="' . $distance['left'] . '" w:rightFromText="' . $distance['right'] . '" w:topFromText="' . $distance['top'] . '" w:bottomFromText="' . $distance['bottom'] . '" w:horzAnchor="text" w:vertAnchor="text" w:tblpXSpec="' . $properties['float'] . '" w:tblpYSpec="inside" />';
        }
        if ((isset($attributes['dir']) && strtolower($attributes['dir']) == 'rtl') ||
            (isset($properties['direction']) && strtolower($properties['direction']) == 'rtl')) {
            $stringTblPr .= '<w:bidiVisual w:val="1" />';
        }

        //TODO OpenOffice needs $tableWidth > 0; else paints a table with double page width; don't work <w:tblW w:w="0" w:type="auto"/>
        if (!empty($properties['width'])) {
            list($tableWidth, $tableWidthType) = $this->_wordMLUnits($properties['width']);
            $stringTblPr .= '<w:tblW w:w="' . (int) ceil($tableWidth) . '" w:type="' . (empty($tableWidth) ? 'auto' : $tableWidthType) . '" />';
        }
        if (!$this->strictWordStyles) {
            if (!empty($attributes['align'])) {
                $stringTblPr .= '<w:jc w:val="' . $attributes['align'] . '" />';
            }
            if ((!empty($attributes['cellspacing']) || !empty($properties['border_spacing'])) && isset($properties['border_collapse']) && $properties['border_collapse'] != 'collapse') {
                $temp = trim(empty($properties['border_spacing']) ? (empty($attributes['cellspacing']) ? 0 : $attributes['cellspacing']) : $properties['border_spacing']);
                //border_spacing -> 1 or 2 values (horizontal, vertical); using only first (horizontal) //TODO calculate media (border_spacing="30px 10%")
                if (strpos($temp, ' ') !== false)
                    $temp = substr($temp, 0, strpos($temp, ' '));
                $temp = $this->_wordMLUnits($temp);
                $stringTblPr .= '<w:tblCellSpacing w:w="' . $temp[0] . '" w:type="' . (empty($temp[0]) ? 'auto' : $temp[1]) . '" />';
            }
            if (isset($properties['margin_left'])) {
                $temp = $this->_wordMLUnits($properties['margin_left']);
                $stringTblPr .= '<w:tblInd w:w="' . $temp[0] . '" w:type="' . (empty($temp[0]) ? 'auto' : $temp[1]) . '" />';
            }
            if ($this->tableStyle == '') {
                if (!empty($properties['border_width']) ||
                    !empty($properties['border_top_width']) ||
                    !empty($properties['border_right_width']) ||
                    !empty($properties['border_bottom_width']) ||
                    !empty($properties['border_left_width'])) {
                    $stringTblPr .= '<w:tblBorders>';
                    foreach (self::$borders as $key => $value) {
                        if (isset($properties['border_' . $value . '_style']) && $properties['border_' . $value . '_color'] != 'none' && $properties['border_' . $value . '_width'] != NULL) {
                            $stringTblPr .= '<w:' . $value . ' w:val="' . $this->getBorderStyles($properties['border_' . $value . '_style']) . '"  w:color="' . $this->wordMLColor($properties['border_' . $value . '_color']) . '" w:sz="' . $this->wordMLLineWidth(isset($properties['border_' . $value . '_width']) ? $properties['border_' . $value . '_width'] : '') . '" />';
                        }
                    }
                    $stringTblPr .= '</w:tblBorders>';
                }
                if (isset($properties['background_color']) && is_array($properties['background_color'])) {
                    $color = $properties['background_color'];
                    $color = $this->wordMLColor($color);
                    $stringTblPr .='<w:shd w:val="clear" w:color="auto" w:fill="' . $color . '" />';
                } else if (isset(self::$rowColor) && is_array(self::$rowColor)) {
                    $color = self::$rowColor;
                    $color = $this->wordMLColor($color);
                    $stringTblPr .='<w:shd w:val="clear" w:color="auto" w:fill="' . $color . '" />';
                }
            }
            //w:tblLayout
            //w:tblCellMar
        }
        $stringTblPr .= '</w:tblPr>';
        $stringTblPr .= '<w:tblGrid>#<w:gridCol/>#</w:tblGrid>';
        return $stringTblPr;
    }

    /**
     * This function returns the WordML formatting for a table row
     * Support:
     * w:trHeight (height),
     * w:tblHeader (display="table-header-group"),
     * w:jc (text_align)
     *
     * @access private
     * @param array $properties
     * @return string
     */
    private function generateTrPr($properties)
    {
        $stringTrPr = '<w:trPr>';
        //w:gridBefore
        //w:gridAfter
        //w:wBefore
        //w:wAfter
        if (isset($properties['page_break_inside']) && $properties['page_break_inside'] == 'avoid') {
            $stringTrPr .= '<w:cantSplit />';
        }
        if (!empty($properties['height'])) {
            $temp = $this->_wordMLUnits($properties['height']);
            $stringTrPr .= '<w:trHeight w:val="' . $temp[0] . '" w:hRule="atLeast" />';
        }
        if (isset($properties['display']) && $properties['display'] == 'table-header-group') {
            $stringTrPr .='<w:tblHeader />';
        }
        //the trPr jc property is commented because it overrides the global table align properties!!!
        /* if (!$this->strictWordStyles) {
          //w:tblCellSpacing
          if (isset($properties['text_align'])) {
          $textAlign = self::$text_align[$properties['text_align']];
          if (empty($textAlign)) {
          $textAlign = 'left';
          }
          $stringTrPr .= '<w:jc w:val="' . $textAlign . '" />';
          }
          } */
        $stringTrPr .= '</w:trPr>';
        return $stringTrPr;
    }

    /**
     * This function returns the WordML formatting for a table cell
     * Support:
     * w:tcW (width),
     * w:gridSpan (attribute colspan),
     * w:vMerge (attribute rowspan),
     * w:tcBorders (border-[top|left|bottom|right]-style!="none")(border-[top|left|bottom|right]-color)(border-[top|left|bottom|right]-width)(border),
     * w:shd (background-color)(background),
     * w:vAlign (vertical-align)
     *
     * @access private
     * @param array $properties
     * @param integer $colspan
     * @param integer $rowspan
     * @param boolean $firstRow
     * @return string
     */
    private function generateTcPr($properties, $attributes, $colspan, $rowspan, $firstRow)
    {
        $stringTcPr = '<w:tcPr>';
        if (@$properties['width'] != '') {
            list($cellWidth, $cellWidthType) = $this->_wordMLUnits($properties['width']);
            if ($cellWidth != 0 || $cellWidth != '') {
                $stringTcPr .= '<w:tcW w:w="' . $cellWidth . '" w:type="' . (empty($cellWidth) ? 'auto' : $cellWidthType) . '" />';
            }
        }
        if ($colspan > 1) {
            $stringTcPr .= '<w:gridSpan w:val="' . $colspan . '" />';
        }
        //w:hMerge
        if ($rowspan > 1) {
            $stringTcPr .= '<w:vMerge w:val="restart" />';
        }
        if (!$this->strictWordStyles) {
            if ($this->tableStyle == '') {
                $sTemp = '';
                foreach (self::$borders as $key => $value) {
                    if (!empty($properties['border_' . $value . '_width']) && @$properties['border_' . $value . '_style'] != 'none') {
                        $sTemp .= '<w:' . $value . ' w:val="' . $this->getBorderStyles(isset($properties['border_' . $value . '_style']) ? $properties['border_' . $value . '_style'] : false) . '"  w:color="' . (isset($properties['border_' . $value . '_color']) ? $this->wordMLColor($properties['border_' . $value . '_color']) : 0) . '" w:sz="' . $this->wordMLLineWidth(isset($properties['border_' . $value . '_width']) ? $properties['border_' . $value . '_width'] : false) . '" />';
                    } else if (!empty(self::$borderRow[$value]['width']) && @self::$borderRow[$value]['width'] != 'none') {
                        $sTemp .= '<w:' . $value . ' w:val="' . $this->getBorderStyles(isset(self::$borderRow[$value]['style']) ? self::$borderRow[$value]['style'] : false) . '"  w:color="' . (isset(self::$borderRow[$value]['color']) ? $this->wordMLColor(self::$borderRow[$value]['color']) : 0) . '" w:sz="' . $this->wordMLLineWidth(isset(self::$borderRow[$value]['width']) ? self::$borderRow[$value]['width'] : false) . '" />';
                    }
                }
                if (!empty($sTemp))
                    $stringTcPr .= '<w:tcBorders>' . $sTemp . '</w:tcBorders>';

                if (isset($properties['background_color']) && is_array($properties['background_color'])) {
                    $color = $properties['background_color'];
                    $color = $this->wordMLColor($color);
                    $stringTcPr .='<w:shd w:val="clear" w:color="auto" w:fill="' . $color . '" />';
                } else if (isset(self::$rowColor) && is_array(self::$rowColor)) {
                    $color = self::$rowColor;
                    $color = $this->wordMLColor($color);
                    $stringTcPr .='<w:shd w:val="clear" w:color="auto" w:fill="' . $color . '" />';
                }
            }
            //w:noWrap
            $stringTcPr .= $this->tcPrSpacing($properties);
            if (isset($attributes['dir']) && array_key_exists($attributes['dir'], self::$text_direction)) {
                $stringTcPr .= '<w:textDirection w:val="' . self::$text_direction[$attributes['dir']] . '" />';
            }
            //w:tcFitText
            if (isset($properties['vertical_align']) && $properties['vertical_align'] != 'baseline') {
                $stringTcPr .= '<w:vAlign w:val="' . $this->_verticalAlign($properties['vertical_align']) . '"/>';
            }
        }
        $stringTcPr .= '</w:tcPr>';
        return $stringTcPr;
    }

    /**
     * This function returns the WordML formatting for a list
     * Support:
     * w:pStyle,
     * w:numPr (tag [ol|ul]),
     * w:shd (background-color)(background),
     * w:spacing ([margin|padding]-top)([margin|padding]-bottom)(font-size)(line-height),
     * w:contextualSpacing,
     * w:jc (text-align)
     *
     * @todo openoffice don't change bullets size
     * @access private
     * @param array $properties
     * @return string
     */
    private function generateListPr($properties)
    {
        $stringListPr = '<w:pPr>';
        if (isset($properties['list_style_type']) && $properties['list_style_type'] == 'none') {
            //We do not include numberings
        } else {
            // $stringListPr .= '<w:pStyle w:val="'.$this->listStyle().'"/>'; It does not seem necessary because the spacing is properly handled by the parser
            $stringListPr .= '<w:numPr><w:ilvl w:val="';
            $this->countTags = array_count_values(self::$openTags);
            $stringListPr .= max((@$this->countTags['ul'] + @$this->countTags['ol'] - 1), 0);
            $stringListPr .= '"/><w:numId w:val="';
            if (!empty(self::$currentCustomList)) {
                $stringListPr .= self::$currentCustomList;
            } else {
                $stringListPr .= $this->listType([CreateDocx::$numUL, CreateDocx::$numOL]);
            }
            $stringListPr .= '"/></w:numPr>';
        }
        if (!$this->strictWordStyles) {
            if (isset($properties['background_color']) && is_array($properties['background_color'])) {
                $color = $properties['background_color'];
                $color = $this->wordMLColor($color);
                $stringListPr .='<w:shd w:val="clear"  w:color="auto" w:fill="' . $color . '" />';
            }
            $stringListPr .= $this->pPrSpacing($properties);
        }
        if (isset($properties['list_style_type']) && $properties['list_style_type'] == 'none') {
            $stringListPr .= $this->pPrIndent($properties);
        }
        //$stringListPr .= '<w:contextualSpacing />'; It does not seem necessary because the spacing is properly handled by the parser
        if (!$this->strictWordStyles) {
            if (isset($properties['text_align'])) {
                $textAlign = self::$text_align[$properties['text_align']];
                if (empty($textAlign)) {
                    $textAlign = 'left';
                }
                $stringListPr .= '<w:jc w:val="' . $textAlign . '" />';
            }
        }
        $stringListPr .= '<w:rPr>';

        if (!$this->strictWordStyles) {
            if (isset($properties['font_family']) && $properties['font_family'] != 'serif') {
                $arrayCSSFonts = explode(',', $properties['font_family']);
                $font = trim($arrayCSSFonts[0]);
                $font = str_replace('"', '', $font);
                $stringListPr .= '<w:rFonts w:ascii="' . $font . '" w:hAnsi="' . $font . '" w:eastAsia="' . $font . '" w:cs="' . $font . '" /> ';
            }
        }
        if (@$properties['font_weight'] == 'bold' || @$properties['font_weight'] == 'bolder') {
            $stringListPr .='<w:b /><w:bCs />';
        }
        if (@$properties['font_style'] == 'italic' || @$properties['font_style'] == 'oblique') {
            $stringListPr .='<w:i /><w:iCs />';
        }
        if (!$this->strictWordStyles) {
            if (@$properties['color'] != '' && is_array($properties['color'])) {
                $color = $properties['color'];
                $color = $this->wordMLColor($color);
                $stringListPr .='<w:color w:val="' . $color . '" />';
            }
            if (@$properties['font_size'] != '') {
                $stringListPr .='<w:sz w:val="' . (int) round($properties['font_size'] * 2) . '" />';
                $stringListPr .='<w:szCs w:val="' . (int) round($properties['font_size'] * 2) . '" />';
            }
            if (isset($properties['background_color']) && is_array($properties['background_color'])) {
                $color = $this->wordMLNamedColor($properties['background_color']);
                $stringListPr .='<w:highlight w:val="' . $color . '" />';
            }
        }
        $stringListPr .= '</w:rPr>';

        $stringListPr .= '</w:pPr>';
        return $stringListPr;
    }

    /**
     * This function returns the applicable Word style if any
     * wordStyles = array('#id|.class|<tag>' => 'style1', '#id|.class|<tag>' => 'style2', [...])
     * @access private
     * @param string $tag
     * @param array $attributes
     * @return string
     */
    private function generateWordStyle($tag, $attributes)
    {
        $sTempStyle = false;
        if (!empty($this->wordStyles)) {
            $attId = empty($attributes['id']) ? '' : $attributes['id'];
            $attClass = empty($attributes['class']) ? [] : $attributes['class'];
            $attTag = $tag;
            //First we check if there is a Word Style for the tag
            if (!empty($this->wordStyles['<' . $attTag . '>'])) {
                $sTempStyle = $this->wordStyles['<' . $attTag . '>'];
            }
            //Now we check for the classes
            foreach ($attClass as $key => $value) {
                if (!empty($this->wordStyles['.' . $value])) {
                    $sTempStyle = $this->wordStyles['.' . $value];
                }
            }
            //And now for the id
            if (!empty($this->wordStyles['#' . $attId])) {
                $sTempStyle = $this->wordStyles['#' . $attId];
            }
        }
        return $sTempStyle;
    }

    /**
     * This function is used to take care of rowspans and colspans
     *
     * @access private
     * @param integer $row
     * @param integer $column
     * @return integer
     */
    private function countEmptyColumns($row, $column)
    {
        if (isset(self::$tableGrid[self::$openTable][$row - 1][$column]) && self::$tableGrid[self::$openTable][$row - 1][$column][0] > 1) {
            $merge = [self::$tableGrid[self::$openTable][$row - 1][$column][0], self::$tableGrid[self::$openTable][$row - 1][$column][1]];
            if ($merge[0] > 1) {
                self::$WordML .= '<w:tc><w:tcPr><w:gridSpan  w:val="' . $merge[1] . '" /><w:vMerge w:val="continue" />';
                //Now we have to take care of inherited tc borders
                $properties = self::$tableGrid[self::$openTable][$row - 1][$column][2];
                $sTemp = '';
                foreach (self::$borders as $key => $value) {
                    if (!empty($properties['border_' . $value . '_width']) && @$properties['border_' . $value . '_style'] != 'none') {
                        $sTemp .= '<w:' . $value . ' w:val="' . $this->getBorderStyles(isset($properties['border_' . $value . '_style']) ? $properties['border_' . $value . '_style'] : false) . '"  w:color="' . (isset($properties['border_' . $value . '_color']) ? $this->wordMLColor($properties['border_' . $value . '_color']) : 0) . '" w:sz="' . $this->wordMLLineWidth(isset($properties['border_' . $value . '_width']) ? $properties['border_' . $value . '_width'] : false) . '" />';
                    } else if (!empty(self::$borderRow[$value]['width']) && @self::$borderRow[$value]['width'] != 'none') {
                        $sTemp .= '<w:' . $value . ' w:val="' . $this->getBorderStyles(isset(self::$borderRow[$value]['style']) ? self::$borderRow[$value]['style'] : false) . '"  w:color="' . (isset(self::$borderRow[$value]['color']) ? $this->wordMLColor(self::$borderRow[$value]['color']) : 0) . '" w:sz="' . $this->wordMLLineWidth(isset(self::$borderRow[$value]['width']) ? self::$borderRow[$value]['width'] : false) . '" />';
                    }
                }
                if (!empty($sTemp))
                    self::$WordML .= '<w:tcBorders>' . $sTemp . '</w:tcBorders>';
                self::$WordML .= '</w:tcPr><w:p /></w:tc>';
                for ($k = 0; $k < $merge[1]; $k++) {
                    array_push(self::$tableGrid[self::$openTable][count(self::$tableGrid[self::$openTable]) - 1], [self::$tableGrid[self::$openTable][$row - 1][$column][0] - 1, $merge[1] - $k, $properties]);
                }
            }
            $this->countEmptyColumns($row, $column + $merge[1]);
        }
    }

    /**
     * This function is used to make sure that all table rows have the same grid
     *
     * @access private
     * @param integer $row
     * @param integer $column
     * @return integer
     */
    private function closeTr($row, $column, $colString = '')
    {
        if (isset(self::$tableGrid[self::$openTable][$row - 1][$column]) && self::$tableGrid[self::$openTable][$row - 1][$column][0] > 1) {
            $merge = [self::$tableGrid[self::$openTable][$row - 1][$column][0], self::$tableGrid[self::$openTable][$row - 1][$column][1]];
            if ($merge[0] > 1) {
                $colString .= '<w:tc><w:tcPr><w:gridSpan  w:val="' . $merge[1] . '" /><w:vMerge w:val="continue" />';
                //Now we have to take care of inherited tc borders
                $properties = self::$tableGrid[self::$openTable][$row - 1][$column][2];
                $sTemp = '';
                foreach (self::$borders as $key => $value) {
                    if (!empty($properties['border_' . $value . '_width']) && @$properties['border_' . $value . '_style'] != 'none') {
                        $sTemp .= '<w:' . $value . ' w:val="' . $this->getBorderStyles(isset($properties['border_' . $value . '_style']) ? $properties['border_' . $value . '_style'] : false) . '"  w:color="' . (isset($properties['border_' . $value . '_color']) ? $this->wordMLColor($properties['border_' . $value . '_color']) : 0) . '" w:sz="' . $this->wordMLLineWidth(isset($properties['border_' . $value . '_width']) ? $properties['border_' . $value . '_width'] : false) . '" />';
                    } else if (!empty(self::$borderRow[$value]['width']) && @self::$borderRow[$value]['width'] != 'none') {
                        $sTemp .= '<w:' . $value . ' w:val="' . $this->getBorderStyles(isset(self::$borderRow[$value]['style']) ? self::$borderRow[$value]['style'] : false) . '"  w:color="' . (isset(self::$borderRow[$value]['color']) ? $this->wordMLColor(self::$borderRow[$value]['color']) : 0) . '" w:sz="' . $this->wordMLLineWidth(isset(self::$borderRow[$value]['width']) ? self::$borderRow[$value]['width'] : false) . '" />';
                    }
                }
                if (!empty($sTemp))
                    $colString .= '<w:tcBorders>' . $sTemp . '</w:tcBorders>';
                $colString .= '</w:tcPr><w:p /></w:tc>';
                for ($k = 0; $k < $merge[1]; $k++) {
                    array_push(self::$tableGrid[self::$openTable][count(self::$tableGrid[self::$openTable]) - 1], [self::$tableGrid[self::$openTable][$row - 1][$column][0] - 1, $merge[1] - $k, $properties]);
                }
            }

            $colString = $this->closeTr($row, $column + $merge[1], $colString);
        }
        return $colString;
    }

    /**
     * This function is used to make sure that the url has the desired format
     *
     * @access private
     * @param string $url
     * @return string
     */
    private function parseURL($url)
    {
        $urlParts = explode('//', $url);
        if ($urlParts[0] == 'http:' || $urlParts[0] == 'https:' || $urlParts[0] == 'file:') {
            return $url;
        } else if (($urlParts[0] == '' && count($urlParts) > 0)) {
            return 'http:' . $url;
        } else {
            if ($url[0] == '/') {
                $url = substr($url, 1);
            }
        }
        return $this->baseURL . $url;
    }

    /**
     * This function returns the parent element HTML tag
     *
     * @access private
     * @return string
     */
    private function getParentHTMLElementTag($depth)
    {
        if (isset(self::$openTags[$depth - 1])) {
            $HTMLTag = self::$openTags[$depth - 1];
        } else {
            $HTMLTag = '';
        }
        return $HTMLTag;
    }

    /**
     * This function is used to determine the spacing before and after a paragraph
     *
     * @access private
     * @return string
     */
    private function pPrSpacing($properties)
    {
        $before = 0;
        $after = 0;
        $line = 240;
        //let us look at the margin top
        if (!empty($properties['margin_top'])) {
            $temp = $this->_wordMLUnits($properties['margin_top'], $properties['font_size']);
            $before += (int) round($temp[0]);
        }
        //let us look now at the padding top
        if (!empty($properties['padding_top'])) {
            $temp = $this->_wordMLUnits($properties['padding_top'], $properties['font_size']);
            $before += (int) round($temp[0]);
        }
        //let us look at the margin bottom
        if (!empty($properties['margin_bottom'])) {
            $temp = $this->_wordMLUnits($properties['margin_bottom'], $properties['font_size']);
            $after += (int) round($temp[0]);
        }
        //let us look now at the padding bottom
        if (!empty($properties['padding_bottom'])) {
            $temp = $this->_wordMLUnits($properties['padding_bottom'], $properties['font_size']);
            $after += (int) round($temp[0]);
        }

        $before = max(0, $before);
        $after = max(0, $after);

        //we now check the line height property

        if (isset($properties['line_height'])) {
            if (isset($properties['font_size']) && $properties['font_size'] != 0) {
                $lineHeight = ( (float) $properties['line_height']) / ((float) $properties['font_size']);
                $line = (int) round($lineHeight * 200);
            } else {
                $lineHeight = ( (float) $properties['line_height']) / 12;
                $line = (int) round($lineHeight * 200);
            }
        }

        $spacing = '<w:spacing w:before="' . $before . '" w:after="' . $after . '" ';
        $spacing .= 'w:line="' . $line . '" w:lineRule="auto"';
        $spacing .= ' />';
        return $spacing;
    }

    /**
     * This function is used to determine the spacing before and after a cell
     *
     * @access private
     * @return string
     */
    private function tcPrSpacing($properties)
    {
        $top = $left = $bottom = $right = [0, 'auto'];

        if (!empty($properties['margin_top'])) {
            $top = $this->_wordMLUnits($properties['margin_top'], $properties['font_size']);
        }
        if (!empty($properties['padding_top'])) {
            $temp = $this->_wordMLUnits($properties['padding_top'], $properties['font_size']);
            if ($temp[0] > $top[0])
                $top = $temp;
        }

        if (!empty($properties['margin_bottom'])) {
            $bottom = $this->_wordMLUnits($properties['margin_bottom'], $properties['font_size']);
        }
        //let us look now at the padding bottom
        if (!empty($properties['padding_bottom'])) {
            $temp = $this->_wordMLUnits($properties['padding_bottom'], $properties['font_size']);
            if ($temp[0] > $bottom[0])
                $bottom = $temp;
        }

        $spacing = '<w:tcMar>';
        $spacing .= '<w:top w:w="' . $top[0] . '" w:type="' . $top[1] . '"/>';
        //$spacing .= '<w:left w:w="" w:type=""/>';
        $spacing .= '<w:bottom w:w="' . $bottom[0] . '" w:type="' . $bottom[1] . '"/>';
        //$spacing .= '<w:right w:w="" w:type=""/>';
        $spacing .= '</w:tcMar>';
        return $spacing;
    }

    /**
     * This function is used to determine the left and right indent of the paragraph
     *
     * @access private
     * @return string
     */
    private function pPrIndent($properties)
    {
        $left = 0;
        $right = 0;
        $firstLineIndent = 0;
        //let us look at the margin left
        if (!empty($properties['margin_left'])) {
            $temp = $this->_wordMLUnits($properties['margin_left'], $properties['font_size']);
            $left += (int) round($temp[0]);
        }
        //let us look now at the padding left
        if (!empty($properties['padding_left'])) {
            $temp = $this->_wordMLUnits($properties['padding_left'], $properties['font_size']);
            $left += (int) round($temp[0]);
        }
        //let us look at the margin right
        if (!empty($properties['margin_right'])) {
            $temp = $this->_wordMLUnits($properties['margin_right'], $properties['font_size']);
            $right += (int) round($temp[0]);
        }
        //let us look now at the padding right
        if (!empty($properties['padding_right'])) {
            $temp = $this->_wordMLUnits($properties['padding_right'], $properties['font_size']);
            $right += (int) round($temp[0]);
        }
        if (!empty($properties['text_indent'])) {
            $temp = $this->_wordMLUnits($properties['text_indent'], $properties['font_size']);
            $firstLineIndent = (int) round($temp[0]);
        }

        $indent = '<w:ind w:left="' . $left . '" w:right="' . $right . '" ';
        if ($firstLineIndent != 0) {
            $indent .= 'w:firstLine="' . $firstLineIndent . '" ';
        }
        $indent .= '/>';
        return $indent;
    }

    /**
     * This function converts the paragraph into a heading
     *
     * @access private
     * @return string
     */
    private function setHeading($level)
    {
        $heading = '<w:outlineLvl w:val="' . ($level - 1) . '"/>';
        return $heading;
    }

    /**
     * This function returns the width of a line in eigths of a point (the measure used in WordML)
     *
     * @access private
     * @param integer $size
     * @return integer
     */
    private function wordMLLineWidth($size)
    {
        return (int) round($size * 5 / 0.75);
    }

    /**
     * This function returns the colour as is used by WordML
     *
     * @access private
     * @param array $color
     * @return string
     */
    private function wordMLColor($color)
    {
        if (strtolower($color['hex']) == 'transparent') {
            return '';
        } else {
            return strtoupper(str_replace('#', '', $color['hex']));
        }
    }

    /**
     * This function returns the colour name as is used by WordML in highlighted text
    black	Black Highlighting Color
    blue	Blue Highlighting Color
    cyan	Cyan Highlighting Color
    green	Green Highlighting Color
    magenta	Magenta Highlighting Color
    red	Red Highlighting Color
    yellow	Yellow Highlighting Color
    white	White Highlighting Color
    darkBlue	Dark Blue Highlighting Color
    darkCyan	Dark Cyan Highlighting Color
    darkGreen	Dark Green Highlighting Color
    darkMagenta	Dark Magenta Highlighting Color
    darkRed	Dark Red Highlighting Color
    darkYellow	Dark Yellow Highlighting Color
    darkGray	Dark Gray Highlighting Color
    lightGray	Light Gray Highlighting Color
    none	No Text Highlighting
     *
     * @access private
     * @param string $color
     * @return string
     */
    private function wordMLNamedColor($color)
    {
        $color = strtoupper(str_replace('#', '', $color["hex"]));
        $wordMLColors = ['000000' => 'black', '0000ff' => 'blue', '00ffff' => 'cyan', '00ff00' => 'green', 'ff00ff' => 'magenta', 'ff0000' => 'red',
            'ffff00' => 'yellow', 'ffffff' => 'white', '00008b' => 'darkBlue', '008b8b' => 'darkCyan', '006400' => 'darkGreen', '8b008b' => 'darkMagenta',
            '8b0000' => 'darkRed', '808000' => 'darkYellow', 'a9a9a9' => 'darkGray', 'd3d3d3' => 'lightGray', '' => 'none'];

        if (isset($wordMLColors[$color]))
            return($wordMLColors[$color]); //exact color




//return closest color
        $hex24 = 16777215;
        $retCol = '000000';
        $red_color = hexdec(substr($color, 0, 2));
        $green_color = hexdec(substr($color, 2, 4));
        $blue_color = hexdec(substr($color, 4));
        foreach ($wordMLColors as $key => $val) {
            $red = $red_color - hexdec(substr($key, 0, 2));
            $green = $green_color - hexdec(substr($key, 2, 4));
            $blue = $blue_color - hexdec(substr($key, 4));

            $dist = $red * $red + $green * $green + $blue * $blue; //distance between colors

            if ($dist <= $hex24) {
                $hex24 = $dist;
                $retCol = $key;
            }
        }

        return $wordMLColors[$retCol];



        //return strtoupper(str_replace('#', '', $color["hex"]));
    }

    /**
     * This function returns the border style if it is correct CSS, else it returns nil
     *
     * @access private
     * @param string $borderStyle
     * @return string
     */
    private function getBorderStyles($borderStyle)
    {
        if (!empty($borderStyle) && array_key_exists($borderStyle, self::$borderStyles)) {
            return self::$borderStyles[$borderStyle];
        } else {
            return 'nil';
        }
    }

    /**
     * This function returns the border style of an embeded image
     *
     * @access private
     * @param int $borderWidth
     * @param string $borderStyle
     * @return string
     */
    private function imageBorders($borderWidth, $borderStyle, $borderColor)
    {

        if ($borderWidth == 0) {
            $borderXML = '<a:ln w="0"><a:noFill/></a:ln>';
        } else {
            $borderXML = '<a:ln w="' . $borderWidth . '">
                            <a:solidFill>
                                <a:srgbClr val="' . $borderColor . '" />
                            </a:solidFill>
                            <a:prstDash val="' . self::$imageBorderStyles[$borderStyle] . '" />
                        </a:ln>';
        }

        return $borderXML;
    }

    /**
     * This function returns the image dimensions
     *
     * @access private
     * @param array $size
     * @param array $attributes
     * @return array
     */
    private function getImageDimensions($size, $attributes)
    {
        $width = $size[0];
        $height = $size[1];
        if (isset($attributes['width']) && is_numeric($attributes['width']) && $attributes['width'] > 1) {
            $cx = $attributes['width'] * 7200;
        } else if (empty($attributes['width']) && isset($attributes['height']) && is_numeric($attributes['height']) && $attributes['height'] > 1) {
            $cx = (int) ceil($width * $attributes['height'] / $height) * 7200;
        } else {
            $cx = $width * 7200;
        }
        if (isset($attributes['height']) && is_numeric($attributes['height']) && $attributes['height'] > 1) {
            $cy = $attributes['height'] * 7200;
        } else if (empty($attributes['height']) && isset($attributes['width']) && is_numeric($attributes['width']) && $attributes['width'] > 1) {
            $cy = (int) ceil($height * $attributes['width'] / $width) * 7200;
        } else {
            $cy = $height * 7200;
        }

        return [$cx, $cy];
    }

    /**
     * This function returns the margin for the image
     *
     * @access private
     * @param string $margin
     * @param string $padding
     * @return string
     */
    private function imageMargins($margin, $padding, $fontSize)
    {

        $distance = 0;

        //let us look at the margin
        if ($margin != 0) {
            $temp = $this->_wordMLUnits($margin, $fontSize);
            $distance += (int) round($temp[0]);
        }

        //let us look at the padding
        if ($padding != 0) {
            $temp = $this->_wordMLUnits($padding, $fontSize);
            $distance += (int) round($temp[0]);
        }

        return (int) round($distance * 635 * 0.75); //we are multypling by the scaling factor between twips and emus. The factor of 0.75 is ours to keep the extra scaling ratio we use on images
    }

    /**
     * This function repairs the problem of empty cells in a table
     *
     * @access private
     * @return string
     */
    private function repairWordML($data)
    {
        //This is to fix the problem with empty cells in a table (a Word bug)
        $data = str_replace('</w:tcPr></w:tc>', '</w:tcPr><w:p /></w:tc>', $data);
        //We also clean extra line feeds generated by the parser after <br /> tags that may give problems with the rendering of WordML
        $data = preg_replace('/<w:br \/><w:t xml:space="preserve">[\n\r]/', '<w:br /><w:t xml:space="preserve">', $data);
        //can not put two tables together
        $data = preg_replace('/<\/w:tbl><w:tbl>/i', '</w:tbl><w:p /><w:tbl>', $data);
        return $data;
    }

    /**
     * Translates HTML units to Word ML units
     *
     * @access private
     * @param string $sHtmlUnit Units in HTML format
     * @param string $fontSize Font size, if applicable
     * @return array
     */
    private function _wordMLUnits($sHtmlUnit, $fontSize = false)
    {
        if (!preg_match('/^(-?\d*\.?\d*)(%|em|pt|px)?$/i', trim($sHtmlUnit), $match))
            return([0, 'dxa']);

        $match[1] = (strpos($match[1], '.') === 0 ? '0' : '') . $match[1];
        $match[2] = empty($match[2]) ? '' : $match[2];

        //if($match[2] != 'em' && $match[2] != 'px' && !empty($fontSize)) $match[2] = 'pt';

        switch ($match[2]) {
            case '%': //in WordML the precentage is given in fiftieths of a percent
                $widthType = 'pct';
                $width = 50 * $match[1];
                break;
            case 'em':
                $widthType = 'dxa';
                $width = 20 * $match[1] * $fontSize;
                break;
            case 'pt': //in WordML the width is given in twentieths of a point
                $widthType = 'dxa';
                $width = 20 * $match[1];
                break;
            case 'px': //a pixel is around 3/4 of a point
            default: //if no unit we asume is given in pixels
                $widthType = 'dxa';
                $width = 15 * $match[1];
        }

        return([$width, $widthType]);
    }

    /**
     * Translates CSS units to pixels
     *
     * @access private
     * @param string $value CSS property value
     * @param string $fontSize
     * @return array
     */
    private function CSSUnits2Pixels($value, $fontSize = 12)
    {
        if (!preg_match('/^(-?\d*\.?\d*)(%|em|pt|px)?$/i', trim($value), $match))
            return;

        $match[1] = (strpos($match[1], '.') === 0 ? '0' : '') . $match[1];
        $match[2] = empty($match[2]) ? '' : $match[2];

        switch ($match[2]) {
            case '%':
                return;
            case 'em':
                $pixels = ceil($match[1] / 0.75) * $fontSize;
                break;
            case 'pt': //in WordML the width is given in twentieths of a point
                $pixels = ceil($match[1] / 0.75);
                break;
            case 'px': //a pixel is around 3/4 of a point
            default: //if no unit we asume is given in pixels
                $pixels = $match[1];
        }

        return $pixels;
    }

    /**
     * Parse image vertical align property
     *
     * @access private
     * @param array $properties
     * @return array
     */
    private function generateImageRPr($properties, $height = 0)
    {
        //Notice: the position is given in half-points
        //get the height of the image in points
        $ptHeight = ceil(0.58 * $height / 7200);
        if (preg_match('/^(-?\d*\.?\d*)(%|em|pt|px)?$/i', trim($properties['vertical_align']), $match)) {
            $match[1] = (strpos($match[1], '.') === 0 ? '0' : '') . $match[1];
            $match[2] = empty($match[2]) ? '' : $match[2];

            switch ($match[2]) {
                case '%':
                    $position = ceil(2 * $match[1] * $ptHeight / 100);
                case 'em':
                    $position = ceil(2 * $match[1] * $properties['font_size']);
                    break;
                case 'pt':
                    $position = ceil(2 * $match[1]);
                    break;
                case 'px': //a pixel is around 3/4 of a point
                default: //if no unit we asume is given in pixels
                    $position = ceil(2 * $match[1] * 0.75);
            }
        } else if (array_key_exists($properties['vertical_align'], self::$imageVertAlignProps)) {
            if ($properties['vertical_align'] == 'middle') {
                $position = - 1 * ceil($ptHeight - 0.75 * $properties['font_size']);
            } else {
                $position = - 2 * ceil($ptHeight - 0.75 * $properties['font_size']);
            }
        } else {
            return;
        }
        return '<w:rPr><w:position w:val="' . $position . '"/></w:rPr>';
    }

    /**
     * Vertical position
     *
     * @access private
     * @param string $valign Vertical align
     * @param string $fontSize Font size, if applicable
     * @return array
     */
    private function _rprPosition($valign, $font_size)
    {
        $measureUnit = substr($valign, -2);
        $quantity = (int) substr($valign, 0, -2); //TODO: parse other posible non-numerical values like top.
        if ($valign == 'middle') {
            $measureUnit = 'em';
            $quantity = -0.5;
        }
        if ($valign == 'super') {
            $measureUnit = 'em';
            $quantity = 0.75;
        }
        if ($valign == 'sub') {
            $measureUnit = 'em';
            $quantity = -0.75;
        }
        if ($measureUnit == 'em') {
            $vertDisplacement = (int) round($quantity * 0.5 * $font_size);
        } else if ($measureUnit == 'px') {
            $vertDisplacement = (int) round($quantity * 0.5 * 0.75);
        } else {
            $vertDisplacement = (int) round($quantity * 0.5);
        }
        return($vertDisplacement);
    }

    /**
     * Vertical align
     *
     * @access private
     * @param string $valign Vertical align
     * @return string
     */
    private function _verticalAlign($valign = 'baseline')
    {
        $temp = $valign;
        switch ($temp) {
            case 'super':
            case 'top':
            case 'text-top':
                $temp = 'top';
                break;
            case 'middle':
                $temp = 'center';
                break;
            case 'sub':
            case 'baseline':
            case 'bottom':
            case 'text-bottom':
            default:
                $temp = 'bottom';
        }

        return($temp);
    }

}

class CreateListStyle
{

    /**
     * @access protected
     * @var string
     */
    protected $_xml;

    /**
     * @access private
     * @var CreateStyle
     * @static
     */
    private static $_instance = NULL;

    /**
     * Construct
     *
     * @access public
     */
    public function __construct()
    {

    }

    /**
     * Destruct
     *
     * @access public
     */
    public function __destruct()
    {

    }

    /**
     *
     * @access public
     * @return string
     */
    public function __toString()
    {
        return $this->_xml;
    }

    /**
     *
     * @access public
     * @param string $name
     * @param array $styleOptions
     * @return string
     */
    public function addListStyle($name, $styleOptions)
    {
        $defaultBullets = ['', 'o', '', '', 'o', '', '', 'o', ''];
        $defaultFont = ['Symbol', 'Courier New', 'Wingdings', 'Symbol', 'Courier New', 'Wingdings', 'Symbol', 'Courier New', 'Wingdings'];
        //Set default
        foreach ($styleOptions as $index => $value) {
            if (empty($value['type'])) {
                $styleOptions[$index]['type'] = 'decimal';
            }
            if (empty($value['format']) && $styleOptions[$index]['type'] != 'bullet') {
                $styleOptions[$index]['format'] = '%' . ($index + 1) . '.';
            } else if (empty($value['format']) && $styleOptions[$index]['type'] == 'bullet') {
                $styleOptions[$index]['format'] = $defaultBullets[$index];
                $styleOptions[$index]['font'] = $defaultFont[$index];
            }
            if (empty($value['hanging'])) {
                $styleOptions[$index]['hanging'] = 360;
            }
            if (empty($value['left'])) {
                $styleOptions[$index]['left'] = 720 * ($index + 1);
            }
        }


        //Repeat ciclically if not defined up to level 9
        $entries = count($styleOptions);
        if ($entries < 9) {
            for ($k = $entries; $k < 9; $k++) {
                $styleOptions[$k]['type'] = $styleOptions[$k % $entries]['type'];
                if ($styleOptions[$k]['type'] == 'bullet') {
                    $styleOptions[$k]['format'] = $defaultBullets[$k];
                    $styleOptions[$k]['font'] = $defaultFont[$k];
                } else {
                    $styleOptions[$k]['format'] = '%' . ($k + 1) . '.';
                }
                $styleOptions[$k]['hanging'] = 360;
                $styleOptions[$k]['left'] = 720 * ($k + 1);
            }
        }
        $baseList = '<w:abstractNum w:abstractNumId="" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" >
                        <w:multiLevelType w:val="hybridMultilevel"/>';

        for ($k = 0; $k < 9; $k++) {
            $baseList .= '<w:lvl w:ilvl="' . $k . '">';
            $baseList .= '<w:start w:val="1"/>';
            $baseList .= '<w:numFmt w:val="' . $styleOptions[$k]['type'] . '"/>';
            $baseList .= '<w:lvlText w:val="' . $styleOptions[$k]['format'] . '"/>';
            $baseList .= '<w:lvlJc w:val="left"/>';
            $baseList .= '<w:pPr><w:ind w:left="' . $styleOptions[$k]['left'] . '" w:hanging="' . $styleOptions[$k]['hanging'] . '"/></w:pPr>';
            $baseList .= '<w:rPr>';
            if (isset($styleOptions[$k]['font'])) {
                $baseList .= '<w:rFonts w:ascii="' . $styleOptions[$k]['font'] . '" w:hAnsi="' . $styleOptions[$k]['font'] . '" w:cs="' . $styleOptions[$k]['font'] . '" w:hint="default"/>';
            }
            if (isset($styleOptions[$k]['fontSize'])) {
                $baseList .= '<w:sz w:val="' . ($styleOptions[$k]['fontSize'] * 2) . '" />';
                $baseList .= '<w:szCs w:val="' . ($styleOptions[$k]['fontSize'] * 2) . '" />';
            }
            $baseList .= '</w:rPr>';
            $baseList .= '</w:lvl>';
        }

        $baseList .= '</w:abstractNum>';

        return $baseList;
    }

}

class CreateImage extends CreateElement
{

	const NAMESPACEWORD = 'wp';
	const NAMESPACEWORD1 = 'a';
	const NAMESPACEWORD2 = 'pic';
	const CONSTWORD = 360000;
	const TAMBORDER = 12700;
	const PNG_SCALE_FACTOR = 29.5;

	/**
	 * @access private
	 * @var CreateImage
	 * @static
	 */
	private static $_instance = NULL;

	/**
	 *
	 * @access private
	 * @var string
	 */
	private $_name;

	/**
	 *
	 * @access private
	 * @var int
	 */
	private $_rId;

	/**
	 *
	 * @access private
	 * @var string
	 */
	private $_ajusteTexto;

	/**
	 *
	 * @access private
	 * @var int
	 */
	private $_sizeX;

	/**
	 *
	 * @access private
	 * @var int
	 */
	private $_sizeY;

	/**
	 *
	 * @access private
	 * @var int
	 */
	private $_dpi;

	/**
	 *
	 * @access private
	 * @var int
	 */
	private $_dpiCustom;

	/**
	 *
	 * @access private
	 * @var int
	 */
	private $_spacingTop;

	/**
	 *
	 * @access private
	 * @var int
	 */
	private $_spacingBottom;

	/**
	 *
	 * @access private
	 * @var int
	 */
	private $_spacingLeft;

	/**
	 *
	 * @access private
	 * @var int
	 */
	private $_spacingRight;

	/**
	 *
	 * @access private
	 * @var int
	 */
	private $_jc;

	/**
	 *
	 * @access private
	 * @var string
	 */
	private $_border;

	/**
	 *
	 * @access private
	 * @var string
	 */
	private $_borderDiscontinuo;

	/**
	 *
	 * @access private
	 * @var int
	 */
	private $_scaling;

	/**
	 * Construct
	 *
	 * @access public
	 */
	public function __construct()
	{
		$this->_name = '';
		$this->_rId = '';
		$this->_ajusteTexto = '';
		$this->_sizeX = '';
		$this->_sizeY = '';
		$this->_spacingTop = '';
		$this->_spacingBottom = '';
		$this->_spacingLeft = '';
		$this->_spacingRight = '';
		$this->_jc = '';
		$this->_border = '';
		$this->_borderDiscontinuo = '';
		$this->_scaling = '';
		$this->_dpiCustom = 0;
		$this->_dpi = 96;
	}

	/**
	 * Destruct
	 *
	 * @access public
	 */
	public function __destruct()
	{

	}

	/**
	 *
	 * @return string
	 * @access public
	 */
	public function __toString()
	{
		return $this->_xml;
	}

	/**
	 *
	 * @return CreateImage
	 * @access public
	 * @static
	 */
	public static function getInstance()
	{
		if (self::$_instance == NULL) {
			self::$_instance = new CreateImage();
		}
		return self::$_instance;
	}

	/**
	 * Setter. Name
	 *
	 * @access public
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->_name = $name;
	}

	/**
	 * Getter. Name
	 *
	 * @access public
	 * @return <type>
	 */
	public function getName()
	{
		return $this->_name;
	}

	/**
	 * Setter. Rid
	 *
	 * @access public
	 * @param string $rId
	 */
	public function setRId($rId)
	{
		$this->_rId = $rId;
	}

	/**
	 * Getter. Rid
	 *
	 * @access public
	 * @return <type>
	 */
	public function getRId()
	{
		return $this->_rId;
	}

	/**
	 * Create image
	 *
	 * @access public
	 * @param array $args[0]
	 */
	public function createImage()
	{
		$this->_xml = '';
		$this->_name = '';
		$this->_rId = '';
		$this->_ajusteTexto = '';
		$this->_sizeX = '';
		$this->_sizeY = '';
		$this->_spacingTop = '';
		$this->_spacingBottom = '';
		$this->_spacingLeft = '';
		$this->_spacingRight = '';
		$this->_jc = '';
		$this->_border = '';
		$this->_borderDiscontinuo = '';
		$this->_scaling = '';
		$this->_dpiCustom = 0;
		$this->_dpi = 96;
		$args = func_get_args();

		if (isset($args[0]['rId']) && (isset($args[0]['src']))) {
			$attributes = getimagesize($args[0]['src']);

			if (!isset($args[0]['textWrap']) || $args[0]['textWrap'] < 0 ||
			    $args[0]['textWrap'] > 5
			) {
				$ajusteTexto = 0;
			} else {
				$ajusteTexto = $args[0]['textWrap'];
			}

			if (isset($args[0]['sizeX'])) {
				$tamPxX = $args[0]['sizeX'];
			} elseif (isset($args[0]['scaling'])) {
				$tamPxX = $attributes[0] * $args[0]['scaling'] / 100;
			} else {
				$tamPxX = $attributes[0];
			}

			if (isset($args[0]['scaling'])) {
				$tamPxY = $attributes[1] * $args[0]['scaling'] / 100;
			} elseif (isset($args[0]['sizeY'])) {
				$tamPxY = $args[0]['sizeY'];
			} else {
				$tamPxY = $attributes[1];
			}
			if (isset($args[0]['dpi'])) {
				$this->_dpiCustom = $args[0]['dpi'];
			}
			$this->setName($args[0]['src']);
			$this->setRId($args[0]['rId']);
			$top = '0';
			$bottom = '0';
			$left = '0';
			$right = '0';

			switch ($attributes['mime']) {
				case 'image/png':
					list($dpiX, $dpiY) = $this->getDpiPng($args[0]['src']);
					$tamWordX = round($tamPxX * 2.54 / $dpiX * CreateImage::CONSTWORD);
					$tamWordY = round($tamPxY * 2.54 / $dpiY * CreateImage::CONSTWORD);

					if (isset($args[0]['spacingTop'])) {
						$top = round(
							$args[0]['spacingTop'] * 2.54 /
							$dpiX * CreateImage::CONSTWORD
						);
					}
					if (isset($args[0]['spacingBottom'])) {
						$bottom = round(
							$args[0]['spacingBottom'] * 2.54 /
							$dpiX * CreateImage::CONSTWORD
						);
					}
					if (isset($args[0]['spacingLeft'])) {
						$left = round(
							$args[0]['spacingLeft'] * 2.54 /
							$dpiX * CreateImage::CONSTWORD
						);
					}
					if (isset($args[0]['spacingRight'])) {
						$right = round(
							$args[0]['spacingRight'] * 2.54 /
							$dpiX * CreateImage::CONSTWORD
						);
					}
					break;
				case 'image/jpg':
				case 'image/jpeg':
					list($dpiX, $dpiY) = $this->getDpiJpg($args[0]['src']);
					$tamWordX = round(
						$tamPxX * 2.54 /
						$dpiX * CreateImage::CONSTWORD
					);
					$tamWordY = round(
						$tamPxY * 2.54 /
						$dpiY * CreateImage::CONSTWORD
					);
					if (isset($args[0]['spacingTop'])) {
						$top = round(
							$args[0]['spacingTop'] * 2.54 /
							$dpiX * CreateImage::CONSTWORD
						);
					}
					if (isset($args[0]['spacingBottom'])) {
						$bottom = round(
							$args[0]['spacingBottom'] * 2.54 /
							$dpiX * CreateImage::CONSTWORD
						);
					}
					if (isset($args[0]['spacingLeft'])) {
						$left = round(
							$args[0]['spacingLeft'] * 2.54 /
							$dpiX * CreateImage::CONSTWORD
						);
					}
					if (isset($args[0]['spacingRight'])) {
						$right = round(
							$args[0]['spacingRight'] * 2.54 /
							$dpiX * CreateImage::CONSTWORD
						);
					}
					break;
				case 'image/gif':
					if ($this->_dpiCustom > 0) {
						$this->_dpi = $this->_dpiCustom;
					}
					$tamWordX = round(
						$tamPxX * 2.54 /
						$this->_dpi * CreateImage::CONSTWORD
					);
					$tamWordY = round(
						$tamPxY * 2.54 /
						$this->_dpi * CreateImage::CONSTWORD
					);
					if (isset($args[0]['spacingTop'])) {
						$top = round(
							$args[0]['spacingTop'] * 2.54 /
							$this->_dpi * CreateImage::CONSTWORD
						);
					}
					if (isset($args[0]['spacingBottom'])) {
						$bottom = round(
							$args[0]['spacingBottom'] * 2.54 /
							$this->_dpi * CreateImage::CONSTWORD
						);
					}
					if (isset($args[0]['spacingLeft'])) {
						$left = round(
							$args[0]['spacingLeft'] * 2.54 /
							$this->_dpi * CreateImage::CONSTWORD
						);
					}
					if (isset($args[0]['spacingRight'])) {
						$right = round(
							$args[0]['spacingRight'] * 2.54 /
							$this->_dpi * CreateImage::CONSTWORD
						);
					}
					break;
			}

			$this->generateP();
			if (isset($args[0]['imageAlign'])) {
				$this->generatePPR();
				$this->generateJC($args[0]['imageAlign']);
			}
			$this->generateR();
			$this->generateRPR();
			$this->generateNOPROOF();
			$this->generateDRAWING();
			if ($ajusteTexto == 0) {
				$this->generateINLINE();
			} else {
				if ($ajusteTexto == 3) {
					$this->generateANCHOR(1);
				} else {
					$this->generateANCHOR();
				}
				$this->generateSIMPLEPOS();
				$this->generatePOSITIONH();
				if (isset($args[0]['float']) && ($args[0]['float'] == 'left' || $args[0]['float'] == 'right' || $args[0]['float'] == 'center')) {
					$this->generateALIGN($args[0]['float']);
				}
				if (isset($args[0]['horizontalOffset']) && is_numeric($args[0]['horizontalOffset'])) {
					$this->generatePOSOFFSET($args[0]['horizontalOffset']);
				} else {
					$this->generatePOSOFFSET(0);
				}
				$this->generatePOSITIONV();
				if (isset($args[0]['verticalOffset']) && is_numeric($args[0]['verticalOffset'])) {
					$this->generatePOSOFFSET($args[0]['verticalOffset']);
				} else {
					$this->generatePOSOFFSET(0);
				}
			}

			$this->generateEXTENT($tamWordX, $tamWordY);
			$this->generateEFFECTEXTENT($left, $top, $right, $bottom);

			switch ($ajusteTexto) {
				case 1:
					$this->generateWRAPSQUARE();
					break;
				case 2:
				case 3:
					$this->generateWRAPNONE();
					break;
				case 4:
					$this->generateWRAPTOPANDBOTTOM();
					break;
				case 5:
					$this->generateWRAPTHROUGH();
					$this->generateWRAPPOLYGON();
					$this->generateSTART();
					$this->generateLINETO();
					break;
				default:
					break;
			}
			$this->generateDOCPR();
			$this->generateCNVGRAPHICFRAMEPR();
			$this->generateGRAPHICPRAMELOCKS(1);
			$this->generateGRAPHIC();
			$this->generateGRAPHICDATA();
			$this->generatePIC();
			$this->generateNVPICPR();
			$this->generateCNVPR();
			$this->generateCNVPICPR();
			$this->generateBLIPFILL();
			$this->generateBLIP();
			$this->generateSTRETCH();
			$this->generateFILLRECT();
			$this->generateSPPR();
			$this->generateXFRM();
			$this->generateOFF();
			$this->generateEXT($tamWordX, $tamWordY);
			$this->generatePRSTGEOM();
			$this->generateAVLST();
			if (isset($args[0]['borderStyle']) ||
			    isset($args[0]['borderWidth']) ||
			    isset($args[0]['borderColor'])) {
				//width
				if (isset($args[0]['borderWidth'])) {
					$this->generateLN($args[0]['borderWidth'] * CreateImage::TAMBORDER);
				} else {
					$this->generateLN(CreateImage::TAMBORDER);
				}
				//color
				if (isset($args[0]['borderColor'])) {
					$this->generateSOLIDFILL($args[0]['borderColor']);
				} else {
					$this->generateSOLIDFILL('000000');
				}
				//style
				if (isset($args[0]['borderStyle'])) {
					$this->generatePRSTDASH($args[0]['borderStyle']);
				} else {
					$this->generatePRSTDASH('solid');
				}
			}

			$this->cleanTemplate();
		} else {
			echo 'There was an error adding the image';
		}
	}

	/**
	 * Init image
	 *
	 * @access public
	 * @param array $args[0]
	 */
	public function initImage()
	{
		$args = func_get_args();

		if (!isset($args[0]['src'])) {
			$args[0]['src'] = '';
		}
		if (!isset($args[0]['textWrap'])) {
			$args[0]['textWrap'] = '';
		}
		if (!isset($args[0]['sizeX'])) {
			$args[0]['sizeX'] = '';
		}
		if (!isset($args[0]['sizeY'])) {
			$args[0]['sizeY'] = '';
		}
		if (!isset($args[0]['spacingTop'])) {
			$args[0]['spacingTop'] = '';
		}
		if (!isset($args[0]['spacingBottom'])) {
			$args[0]['spacingBottom'] = '';
		}
		if (!isset($args[0]['spacingLeft'])) {
			$args[0]['spacingLeft'] = '';
		}
		if (!isset($args[0]['spacingRight'])) {
			$args[0]['spacingRight'] = '';
		}
		if (!isset($args[0]['imageAlign'])) {
			$args[0]['imageAlign'] = '';
		}
		if (!isset($args[0]['border'])) {
			$args[0]['border'] = '';
		}
		if (!isset($args[0]['borderDiscontinuous'])) {
			$args[0]['borderDiscontinuous'] = '';
		}
		if (!isset($args[0]['scaling'])) {
			$args[0]['scaling'] = '';
		}
		if (!isset($args[0]['dpi'])) {
			$args[0]['dpi'] = '';
		}



		$this->_name = $args[0]['src'];
		$this->_ajusteTexto = $args[0]['textWrap'];
		$this->_sizeX = $args[0]['sizeX'];
		$this->_sizeY = $args[0]['sizeY'];
		$this->_spacingTop = $args[0]['spacingTop'];
		$this->_spacingBottom = $args[0]['spacingBottom'];
		$this->_spacingLeft = $args[0]['spacingLeft'];
		$this->_spacingRight = $args[0]['spacingRight'];
		$this->_jc = $args[0]['imageAlign'];
		$this->_border = $args[0]['border'];
		$this->_borderDiscontinuo = $args[0]['borderDiscontinuous'];
		$this->_scaling = $args[0]['scaling'];
		$this->_dpiCustom = $args[0]['dpi'];
	}

	/**
	 * Get image jpg dpi
	 *
	 * @access private
	 * @param string $filename
	 * @return array
	 */
	private function getDpiJpg($filename)
	{
		if ($this->_dpiCustom > 0) {
			return [$this->_dpiCustom, $this->_dpiCustom];
		}
		$a = fopen($filename, 'r');
		$string = fread($a, 20);
		fclose($a);
		$type = hexdec(bin2hex(substr($string, 13, 1)));
		$data = bin2hex(substr($string, 14, 4));
		if ($type == 1) {
			$x = substr($data, 0, 4);
			$y = substr($data, 4, 4);
			return [hexdec($x), hexdec($y)];
		} else if ($type == 2) {
			$x = floor(hexdec(substr($data, 0, 4)) / 2.54);
			$y = floor(hexdec(substr($data, 4, 4)) / 2.54);
			return [$x, $y];
		} else {
			return [$this->_dpi, $this->_dpi];
		}
	}

	/**
	 * Get image png dpi
	 *
	 * @access private
	 * @param string $filename
	 * @return array
	 */
	private function getDpiPng($filename)
	{
		if ($this->_dpiCustom > 0) {
			return [$this->_dpiCustom, $this->_dpiCustom];
		}
		$a = fopen($filename, 'r');
		$string = fread($a, 1000);
		$aux = strpos($string, 'pHYs');
		if ($aux > 0) {
			$type = hexdec(bin2hex(substr($string, $aux + strlen('pHYs') + 16, 1)));
		}
		if ($aux > 0 && $type = 1) {
			$data = bin2hex(substr($string, $aux + strlen('pHYs'), 16));
			fclose($a);
			$x = substr($data, 0, 8);
			$y = substr($data, 8, 8);
			return [round(hexdec($x) / CreateImage::PNG_SCALE_FACTOR), round(hexdec($y) / CreateImage::PNG_SCALE_FACTOR)];
		} else {
			return [$this->_dpi, $this->_dpi];
		}
	}

}
class CreateChartFactory
{

    /**
     * Create an object
     *
     * @access public
     * @param string $type Object type
     * @return mixed
     * @static
     */
    public static function createObject($type)
    {
        $type = substr($type, 0, strpos($type, 'Chart') + 5);
        $type = str_replace('3D', '', $type);
        $type = 'Create' . ucwords($type);
        $type = str_replace('Col', 'Bar', $type);
        return new $type();
    }

}

class CreateChartRels extends CreateElement
{

    /**
     *
     * @access protected
     */
    protected $_xml;

    /**
     *
     * @access private
     * @static
     */
    private static $_instance = NULL;

    /**
     * Construct
     *
     * @access public
     */
    public function __construct()
    {

    }

    /**
     * Destruct
     *
     * @access public
     */
    public function __destruct()
    {

    }

    /**
     * Magic method, returns current XML
     *
     * @access public
     * @return string Return current XML
     */
    public function __toString()
    {
        return $this->_xml;
    }

    /**
     * Singleton, return instance of class
     *
     * @access public
     * @return CreateChartRels
     */
    public static function getInstance()
    {
        if (self::$_instance == NULL) {
            self::$_instance = new CreateChartRels();
        }
        return self::$_instance;
    }

    /**
     * Create relationship document to use in DOCX file
     *
     * @access public
     * @param int $idChart
     */
    public function createRelationship($idChart)
    {
        $this->generateRELATIONSHIPS();
        $this->generateRELATIONSHIP($idChart);
        $this->cleanTemplate();
    }

    /**
     * New relationship, added to relationships XML
     *
     * @access protected
     * @param int $idChart
     * @param int $id Optional, use 1 as default
     */
    protected function generateRELATIONSHIP($idChart, $id = 1)
    {
        $xml = '<Relationship Id="rId' . $id . '" Type="http://schemas.open'
            . 'xmlformats.org/officeDocument/2006/relationships/package" '
            . 'Target="../embeddings/datos' . $idChart
            . '.xlsx"></Relationship>__GENERATECHARTSPACE__';

        $tag = '__GENERATERELATIONSHIPS__';

        $this->_xml = str_replace($tag, $xml, $this->_xml);
    }

    /**
     * Main tags of relationships XML
     *
     * @access protected
     */
    protected function generateRELATIONSHIPS()
    {
        $this->_xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/'
            . 'package/2006/relationships">__GENERATERELATIONSHIPS__'
            . '</Relationships>';
    }

}
class CreateLineChart extends CreateGraphic implements InterfaceGraphic
{

    /**
     * Construct
     *
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create embedded xml chart
     *
     * @access public
     */
    public function createEmbeddedXmlChart()
    {
        $this->_xmlChart = '';
        $args = func_get_args();
        $this->generateCHARTSPACE();
        $this->generateDATE1904(1);
        $this->generateLANG();
        $color = 2;
        if ($this->_color) {
            $color = $this->_color;
        }
        $this->generateSTYLE($color);
        $this->generateCHART();
        if ($this->_title != '') {
            $this->generateTITLE();
            $this->generateTITLETX();
            $this->generateRICH();
            $this->generateBODYPR();
            $this->generateLSTSTYLE();
            $this->generateTITLEP();
            $this->generateTITLEPPR();
            $this->generateDEFRPR();
            $this->generateTITLER();
            $this->generateTITLERPR();
            $this->generateTITLET($this->_title);
            $this->generateTITLELAYOUT();
            $this->cleanTemplateFonts();
        } else {
            $this->generateAUTOTITLEDELETED();
            $title = '';
        }
        if (strpos($this->_type, '3D') !== false) {
            $this->generateVIEW3D();
            $rotX = 30;
            $rotY = 30;
            $perspective = 30;
            if ($this->_rotX != '') {
                $rotX = $this->_rotX;
            }
            if ($this->_rotY != '') {
                $rotY = $this->_rotY;
            }
            if ($this->_perspective != '') {
                $perspective = $this->_perspective;
            }
            $this->generateROTX($rotX);
            $this->generateROTY($rotY);
            $this->generateRANGAX($this->_rAngAx);
            $this->generatePERSPECTIVE($perspective);
        }
        if ($this->values == '') {
            exit('You haven`t added data');
        }
        $this->generatePLOTAREA();
        $this->generateLAYOUT();

        if (strpos($this->_type, '3D') !== false) {
            $this->generateLINE3DCHART();
        } else {
            $this->generateLINECHART();
        }
        $groupBar = 'standard';
        if (!empty($this->_groupBar) && in_array($this->_groupBar, ['stacked', 'standard', 'percentStacked'])) {
            $groupBar = $this->_groupBar;
        }
        $this->generateGROUPING($groupBar);
        if (isset($this->values['legend'])) {
            $legends = $this->values['legend'];
        } else {
            echo('You haven`t added legends');
            return false;
        }
        $numValues = count($this->values) - 1;
        $this->generateVARYCOLORS($this->_varyColors);
        $letter = 'A';
        for ($i = 0; $i < count($legends); $i++) {
            $this->generateSER();
            $this->generateIDX($i);
            $this->generateORDER($i);
            $letter++;

            $this->generateTX();
            $this->generateSTRREF();
            $this->generateF('Sheet1!$' . $letter . '$1');
            $this->generateSTRCACHE();
            $this->generatePTCOUNT();
            $this->generatePT();
            $this->generateV($legends[$i]);

            if (!empty($this->_symbol)) {
                $sizeSimbol = NULL;
                if (is_numeric($this->_symbolSize)) {
                    $sizeSimbol = $this->_symbolSize;
                }
                if (is_array($this->_symbol)) {
                    $this->generateMARKER($this->_symbol[$i], $sizeSimbol);
                } else {
                    $this->generateMARKER($this->_symbol, $sizeSimbol);
                }
            }
            $this->cleanTemplate2();

            $this->generateCAT();
            $this->generateSTRREF();
            $this->generateF('Sheet1!$A$2:$A$' . ($numValues + 1));
            $this->generateSTRCACHE();
            $this->generatePTCOUNT($numValues);

            $num = 0;
            foreach ($this->values as $legend => $value) {
                if ($legend == 'legend') {
                    continue;
                }
                $this->generatePT($num);
                $this->generateV($legend);
                $num++;
            }
            $this->cleanTemplate2();
            if ($this->_type == 'radar' && $style == 'marker' && $marker == false) {
                $this->generateMARKER();
            }
            $this->generateVAL();
            $this->generateNUMREF();
            $this->generateF('Sheet1!$' . $letter . '$2:$' . $letter . '$' . ($numValues + 1));
            $this->generateNUMCACHE();
            $this->generateFORMATCODE();
            $this->generatePTCOUNT($numValues);
            $num = 0;
            foreach ($this->values as $legend => $value) {
                if ($legend == 'legend') {
                    continue;
                }
                $this->generatePT($num);
                $this->generateV($value[$i]);
                $num++;
            }


            $this->cleanTemplate3();
        }

        //Generate labels
        $this->generateSERDLBLS();
        $this->generateSHOWLEGENDKEY($this->_showLegendKey);
        $this->generateSHOWVAL($this->_showValue);
        $this->generateSHOWCATNAME($this->_showCategory);
        $this->generateSHOWSERNAME($this->_showSeries);
        $this->generateSHOWPERCENT($this->_showPercent);
        $this->generateSHOWBUBBLESIZE($this->_showBubbleSize);

        if (isset($args[0][1]['groupBar']) && ($args[0][1]['groupBar'] == 'stacked' ||
                $args[0][1]['groupBar'] == 'percentStacked')
        ) {
            $this->generateOVERLAP();
        }
        $this->generateAXID();
        $this->generateAXID(59040512);
        if (strpos($this->_type, '3D') !== false) {
            $this->generateAXID(83319040);
        }
        $this->generateVALAX();
        $this->generateAXAXID(59040512);
        $this->generateSCALING(true);
        $this->generateDELETE($this->_delete);
        $this->generateORIENTATION();
        $this->generateAXPOS('l');

        switch ($this->_hgrid) {
            case 1:
                $this->generateMAJORGRIDLINES();
                break;
            case 2:
                $this->generateMINORGRIDLINES();
                break;
            case 3:
                $this->generateMAJORGRIDLINES();
                $this->generateMINORGRIDLINES();
                break;
            default:
                break;
        }

        if (!empty($this->_vaxLabel)) {
            $this->generateAXLABEL($this->_vaxLabel);
            $vert = 'horz';
            $rot = 0;
            if ($this->_vaxLabelDisplay == 'vertical') {
                $vert = 'wordArtVert';
            }
            if ($this->_vaxLabelDisplay == 'rotated') {
                $rot = '-5400000';
            }
            $this->generateAXLABELDISP($vert, $rot);
        }
        $this->generateNUMFMT();
        $this->generateTICKLBLPOS($this->_tickLblPos, true);
        $this->generateMAJORUNIT($this->_majorUnit);
        $this->generateMINORUNIT($this->_minorUnit);
        $this->generateCROSSAX(59034624);
        $this->generateCROSSES();
        $this->generateCROSSBETWEEN();
        $this->generateCATAX();
        $this->generateAXAXID(59034624);
        $this->generateSCALING();
        $this->generateDELETE($this->_delete);
        $this->generateORIENTATION();
        $this->generateAXPOS();


        if (!empty($this->_haxLabel)) {
            $this->generateAXLABEL($this->_haxLabel);
            $vert = 'horz';
            $rot = 0;
            if ($this->_haxLabelDisplay == 'vertical') {
                $vert = 'wordArtVert';
            }
            if ($this->_haxLabelDisplay == 'rotated') {
                $rot = '-5400000';
            }
            $this->generateAXLABELDISP($vert, $rot);
        }
        switch ($this->_vgrid) {
            case 1:
                $this->generateMAJORGRIDLINES();
                break;
            case 2:
                $this->generateMINORGRIDLINES();
                break;
            case 3:
                $this->generateMAJORGRIDLINES();
                $this->generateMINORGRIDLINES();
                break;
            default:
                break;
        }

        if (strpos($this->_type, 'surface') !== false) {
            $this->generateMAJORTICKMARK();
        }
        $this->generateTICKLBLPOS();
        $this->generateCROSSAX();
        $this->generateCROSSES();
        $this->generateAUTO();
        $this->generateLBLALGN();
        $this->generateLBLOFFSET();
        if (!empty($this->_showtable)) {
            $this->generateDATATABLE();
        }

        $this->generateLEGEND();
        $this->generateLEGENDPOS($this->_legendPos);
        $this->generateLEGENDOVERLAY($this->_legendOverlay);

        $this->generatePLOTVISONLY();

        if ((!isset($this->_border) || $this->_border == 0 || !is_numeric($this->_border))
        ) {
            $this->generateSPPR();
            $this->generateLN();
            $this->generateNOFILL();
        } else {
            $this->generateSPPR();
            $this->generateLN($this->_border);
        }

        if ($this->_font != '') {
            $this->generateTXPR();
            $this->generateLEGENDBODYPR();
            $this->generateLSTSTYLE();
            $this->generateAP();
            $this->generateAPPR();
            $this->generateDEFRPR();
            $this->generateRFONTS($this->_font);
            $this->generateENDPARARPR();
        }


        $this->generateEXTERNALDATA();
        $this->cleanTemplateDocument();
        return $this->_xmlChart;
    }

    public function dataTag()
    {
        return ['val'];
    }

    /**
     * retrun the type of the xlsx object
     *
     * @access public
     */
    public function getXlsxType()
    {
        return CreateCompletedXlsx::getInstance();
    }

}

class CreateCompletedXlsx extends CreateXlsx
{

    /**
     * @access private
     * @var CreateFooter
     * @static
     */
    private static $_instance = NULL;

    /**
     *
     * @access public
     * @return CreateXlsx
     * @static
     */
    public static function getInstance()
    {
        if (self::$_instance == NULL) {
            self::$_instance = new CreateCompletedXlsx();
        }
        return self::$_instance;
    }

    /**
     * Create excel sheet
     *
     * @access public
     * @param string $args[0]
     * @param array $args[1]
     */
    public function createExcelSheet($dats)
    {
        $this->_xml = '';
        $sizeDats = count($dats);
        foreach ($dats as $ind => $data) {
            $sizeCols = count($data);
            break;
        }
        $sizeDats--;
        $this->generateWORKSHEET();
        $this->generateDIMENSION($sizeDats, $sizeCols);
        $this->generateSHEETVIEWS();
        $this->generateSHEETVIEW();
        $this->generateSELECTION($sizeDats + $sizeCols);
        $this->generateSHEETFORMATPR();
        $this->generateCOLS();
        $this->generateCOL();
        $this->generateSHEETDATA();
        $row = 1;
        foreach ($dats as $ind => $val) {
            $col = 1;
            $letter = 'A';
            $this->generateROW($row, $sizeCols);
            $this->generateC($letter . $row, '', 's');
            $this->generateV($sizeDats + $sizeCols);
            $letter++;
            foreach ($val as $valores) {
                $this->generateC($letter . $row, '', 's');
                $this->generateV($col - 1);
                $col++;
                $letter++;
            }
            $this->cleanTemplateROW();
            $row++;
            break;
        }
        foreach ($dats as $ind => $val) {
            if ($ind == 'legend') {
                continue;
            }
            $this->generateROW($row, $sizeCols);
            $col = 1;
            $letter = 'A';
            $this->generateC($letter . $row, 1, 's');
            $this->generateV($sizeCols + $row - 2);
            $letter++;
            foreach ($val as $valores) {
                $s = '';
                if ($col != $sizeCols)
                    $s = 1;
                $this->generateC($letter . $row, $s);
                $this->generateV($valores);
                $col++;
                $letter++;
            }
            $row++;
            $this->cleanTemplateROW();
        }
        $this->generateROW($row + 1, $sizeCols);
        $row++;
        $this->generateC('B' . $row, 2, 's');
        $this->generateV($sizeDats + $sizeCols + 1);
        $this->generatePAGEMARGINS();
        $this->generateTABLEPARTS();
        $this->generateTABLEPART(1);
        $this->cleanTemplate();
        return $this->_xml;
    }

    /**
     * Create excel shared strings
     *
     * @param string $args[0]
     * @param string $args[1]
     * @access public
     */
    public function createExcelSharedStrings($dats)
    {
        $this->_xml = '';
        $szDats = count($dats);
        foreach ($dats as $ind => $data) {
            $szCols = count($data);
            break;
        }
        $szDats--;
        $this->generateSST($szDats + $szCols + 2);

        for ($i = 0; $i < $szCols; $i++) {
            $this->generateSI();
            if (!isset($dats['legend'][$i])) {
                $dats['legend'][$i] = '';
            }
            $this->generateT($dats['legend'][$i]);
        }

        foreach ($dats as $ind => $val) {
            if ($ind == 'legend') {
                continue;
            }
            $this->generateSI();
            $this->generateT($ind);
        }
        $this->generateSI();
        $this->generateT(' ', 'preserve');

        $msg = 'To change the range size of values,' .
            'drag the bottom right corner';
        $this->generateSI();
        $this->generateT($msg);

        $this->cleanTemplate();
        return $this->_xml;
    }

    /**
     * Create excel table
     *
     * @access public
     * @param string args[0]
     * @param string args[1]
     */
    public function createExcelTable($dats)
    {
        $this->_xml = '';
        $szDats = count($dats);
        foreach ($dats as $ind => $data) {
            $szCols = count($data);
            break;
        }
        $szDats--;
        $this->generateTABLE($szDats, $szCols);
        $this->generateTABLECOLUMNS($szCols + 1);
        $this->generateTABLECOLUMN(1, ' ');
        for ($i = 0; $i < $szCols; $i++) {
            $this->generateTABLECOLUMN($i + 2, $dats['legend'][$i]);
        }
        $this->generateTABLESTYLEINFO();
        $this->cleanTemplate();
        return $this->_xml;
    }

}
class CreateGraphic extends CreateElement
{

    const NAMESPACEWORD = 'c';

    /**
     *
     * @access protected
     * @var string
     */
    protected $_xmlChart;

    /**
     *
     * @access protected
     * @var string
     */
    protected static $_rId;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_textalign;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_jc;

    /**
     *
     * @access protected
     * @var int
     */
    protected $_sizeX;

    /**
     *
     * @access protected
     * @var int
     */
    protected $_sizeY;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_type;

    /**
     *
     * @access protected
     * @var int
     */
    protected $_showPercent;

    /**
     *
     * @access protected
     * @var int
     */
    protected $_showCategory;

    /**
     *
     * @access protected
     * @var int
     */
    protected $_showValue;

    /**
     *
     * @access protected
     * @var <type>
     */
    protected $_data;

    /**
     *
     * @access protected
     * @var int
     */
    protected $_rotX;

    /**
     *
     * @access protected
     * @var int
     */
    protected $_rotY;

    /**
     *
     * @access protected
     * @var int
     */
    protected $_perspective;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_color;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_float;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_groupBar;

    /**
     *
     * @access protected
     * @var int
     */
    protected $_horizontalOffset;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_title;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_name;

    /**
     * @access protected
     * @var string
     */
    protected $_font;

    /**
     * @access protected
     * @var string
     */
    protected $_legendPos;

    /**
     * @access protected
     * @var string
     */
    protected $_legendOverlay;

    /**
     * @access protected
     * @var string
     */
    protected $_border;

    /**
     * @access protected
     * @var string
     */
    protected $_haxLabel;

    /**
     * @access protected
     * @var string
     */
    protected $_vaxLabel;

    /**
     * @access protected
     * @var string
     */
    protected $_haxLabelDisplay;

    /**
     * @access protected
     * @var string
     */
    protected $_vaxLabelDisplay;

    /**
     * @access protected
     * @var string
     */
    protected $_showtable;

    /**
     * @access protected
     * @var string
     */
    protected $_hgrid;

    /**
     * @access protected
     * @var string
     */
    protected $_vgrid;

    /**
     * @access protected
     * @var string
     */
    protected $_explosion;

    /**
     * @access protected
     * @var string
     */
    protected $_holeSize;

    /**
     * @access protected
     * @var string
     */
    protected $_symbol;

    /**
     * @access protected
     * @var string
     */
    protected $_symbolSize;

    /**
     * @access protected
     * @var string
     */
    protected $_style;

    /**
     * @access protected
     * @var boolean
     */
    protected $_smooth;

    /**
     *
     * @access protected
     * @var int
     */
    protected $_verticalOffset;

    /**
     * @access protected
     * @var boolean
     */
    protected $_wireframe;

    /**
     * @access protected
     * @var float
     */
    protected $_scalingMax;

    /**
     * @access protected
     * @var float
     */
    protected $_scalingMin;

    /**
     * @access protected
     * @var string
     */
    protected $_tickLblPos;

    /**
     * @access protected
     * @var float
     */
    protected $_majorUnit;

    /**
     * @access protected
     * @var float
     */
    protected $_minorUnit;

    /**
     * @access protected
     * @var CreateGraphic
     * @static
     */
    protected static $_instance = null;

    /**
     * Construct
     *
     * @access public
     */
    public function __construct()
    {
        //set for 2010 compatibility
        $this->_varyColors = 0;
        $this->_autoUpdate = 0;
        $this->_delete = 0; //removes the axis if set to 1
        $this->_rAngAx = 0;
        $this->_roundedCorners = 0;

        $this->_rId = '';
        $this->_textalign = '';
        $this->_jc = '';
        $this->_sizeX = '';
        $this->_sizeY = '';
        $this->_type = '';
        $this->_data = '';
        $this->_rotX = '';
        $this->_rotY = '';
        $this->_perspective = '';
        $this->_color = '';
        $this->_groupBar = '';
        $this->_title = '';
        $this->_font = '';
        $this->_xml = '';
        $this->_name = '';
        $this->_legendPos = 'r';
        $this->_legendOverlay = 0;
        $this->_border = '';
        $this->_haxLabel = '';
        $this->_vaxLabel = '';
        $this->_haxLabelDisplay = '';
        $this->_vaxLabelDisplay = '';
        $this->_showtable = '';
        $this->_hgrid = '';
        $this->_vgrid = '';

        $this->_gapWidth = '';
        $this->_secondPieSize = '';
        $this->_splitType = '';
        $this->_splitPos = '';
        $this->_custSplit = '';
        $this->_subtype = '';

        $this->_explosion = '';
        $this->_holeSize = '';
        $this->_symbol = '';
        $this->_symbolSize = '';
        $this->_style = '';
        $this->_smooth = false;
        $this->_wireframe = false;
        //Default values for c:dLbls
        $this->_showLegendKey = 0;
        $this->_showBubbleSize = 0;
        $this->_showPercent = 0;
        $this->_showValue = 0;
        $this->_showCategory = 0;
        $this->_showSeries = 0;

        $this->_scalingMax = null;
        $this->_scalingMin = null;

        $this->_tickLblPos = 'nextTo';

        $this->_majorUnit = null;
        $this->_minorUnit = null;
    }

    /**
     * Destruct
     *
     * @access public
     */
    public function __destruct()
    {

    }

    /**
     *
     * @access public
     * @return CreateGraphic
     * @static
     */
    public static function getInstance()
    {
        if (self::$_instance == NULL) {
            self::$_instance = new CreatePieChart();
        }
        return self::$_instance;
    }

    /**
     *
     * @access public
     * @return string
     */
    public function __toString()
    {
        return $this->_xml;
    }

    /**
     * Setter. Rid
     *
     * @access public
     * @param string $rId
     */
    public function setRId($rId)
    {
        $this->_rId = $rId;
    }

    /**
     * Getter. Rid
     *
     * @access public
     * @return string
     */
    public function getRId()
    {
        return $this->_rId;
    }

    /**
     * Setter. Name
     *
     * @access public
     * @param string $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * Getter. Name
     *
     * @access public
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Setter. Xml chart
     *
     * @access public
     * @param string $xmlChart
     */
    public function setXmlChart($xmlChart)
    {
        $this->_xmlChart = $xmlChart;
    }

    /**
     * Getter. Xml chart
     *
     * @access public
     * @return string
     */
    public function getXmlChart()
    {
        return $this->_xmlChart;
    }

    /**
     * Create embedded graphic
     *
     * @access public
     * @param array $args[0]
     * @param array $args[1]
     * @return boolean
     */
    public function createEmbeddedGraphic()
    {
        $this->_xmlChart = '';
        if ($this->_type != '') {
            $this->createEmbeddedDocumentXml();
            return true;
        } else {
            echo 'You haven`t added a chart type';
            return false;
        }
    }

    /**
     * Create graphic
     *
     * @access public
     * @param array $args[0]
     * @param array $args[1]
     * @return boolean
     */
    public function CreateGraphic()
    {
        $this->_xmlChart = '';
        $args = func_get_args();
        $this->setRId($args[0]);
        $this->initGraphic($args[1]);
        if (isset($this->_type) && isset($args[0])) {
            if ($this->createEmbeddedXmlChart() == false) {
                echo 'You haven`t added legends';
                return false;
            }
            $this->createDOCUEMNTXML();
            return true;
        } else {
            echo 'You haven`t added a chart type';
            return false;
        }
    }

    /**
     * Init graphic
     *
     * @access public
     * @param array $args[0]
     */
    public function initGraphic()
    {
        $args = func_get_args();
        $this->_type = $args[0]['type'];
        $this->values = $args[0]['data'];
        if (isset($args[0]['float'])) {
            $this->_float = $args[0]['float'];
        }
        if (isset($args[0]['horizontalOffset'])) {
            $this->_horizontalOffset = $args[0]['horizontalOffset'];
        }
        if (isset($args[0]['verticalOffset'])) {
            $this->_verticalOffset = $args[0]['verticalOffset'];
        }
        if (isset($args[0]['textWrap'])) {
            $this->_textalign = $args[0]['textWrap'];
        }
        if (isset($args[0]['jc'])) {
            $this->_jc = $args[0]['jc'];
        }
        if (isset($args[0]['sizeX'])) {
            $this->_sizeX = $args[0]['sizeX'];
        }
        if (isset($args[0]['sizeY'])) {
            $this->_sizeY = $args[0]['sizeY'];
        }
        if (isset($args[0]['showPercent']) && !empty($args[0]['showPercent'])) {
            $this->_showPercent = 1;
        }
        if (isset($args[0]['showValue']) && !empty($args[0]['showValue'])) {
            $this->_showValue = 1;
        }
        if (isset($args[0]['showCategory']) && !empty($args[0]['showCategory'])) {
            $this->_showCategory = 1;
        }
        if (isset($args[0]['rotX'])) {
            $this->_rotX = $args[0]['rotX'];
        }
        if (isset($args[0]['rotY'])) {
            $this->_rotY = $args[0]['rotY'];
        }
        if (isset($args[0]['perspective'])) {
            $this->_perspective = $args[0]['perspective'];
        }
        if (isset($args[0]['color'])) {
            $this->_color = $args[0]['color'];
        }
        if (isset($args[0]['groupBar'])) {
            $this->_groupBar = $args[0]['groupBar'];
        }
        if (isset($args[0]['title'])) {
            $this->_title = $args[0]['title'];
        }
        if (isset($args[0]['font'])) {
            $this->_font = $args[0]['font'];
        }
        if (isset($args[0]['legendPos'])) {
            $this->_legendPos = $args[0]['legendPos'];
        }
        if (isset($args[0]['legendOverlay']) && !empty($args[0]['legendOverlay'])) {
            $this->_legendOverlay = 1;
        }
        if (isset($args[0]['border'])) {
            $this->_border = $args[0]['border'];
        }
        if (isset($args[0]['haxLabel'])) {
            $this->_haxLabel = $args[0]['haxLabel'];
        }
        if (isset($args[0]['vaxLabel'])) {
            $this->_vaxLabel = $args[0]['vaxLabel'];
        }
        if (isset($args[0]['haxLabelDisplay'])) {
            $this->_haxLabelDisplay = $args[0]['haxLabelDisplay'];
        }
        if (isset($args[0]['vaxLabelDisplay'])) {
            $this->_vaxLabelDisplay = $args[0]['vaxLabelDisplay'];
        }
        if (isset($args[0]['showtable'])) {
            $this->_showtable = $args[0]['showtable'];
        }
        if (isset($args[0]['hgrid'])) {
            $this->_hgrid = $args[0]['hgrid'];
        }
        if (isset($args[0]['vgrid'])) {
            $this->_vgrid = $args[0]['vgrid'];
        }
        if (isset($args[0]['style'])) {
            $this->_style = $args[0]['style'];
        }
        if (isset($args[0]['gapWidth'])) {
            $this->_gapWidth = $args[0]['gapWidth'];
        }
        if (isset($args[0]['secondPieSize'])) {
            $this->_secondPieSize = $args[0]['secondPieSize'];
        }
        if (isset($args[0]['splitType'])) {
            $this->_splitType = $args[0]['splitType'];
        }
        if (isset($args[0]['splitPos'])) {
            $this->_splitPos = $args[0]['splitPos'];
        }
        if (isset($args[0]['custSplit'])) {
            $this->_custSplit = $args[0]['custSplit'];
        }
        if (isset($args[0]['subtype'])) {
            $this->_subtype = $args[0]['subtype'];
        }
        if (isset($args[0]['explosion'])) {
            $this->_explosion = $args[0]['explosion'];
        }
        if (isset($args[0]['holeSize'])) {
            $this->_holeSize = $args[0]['holeSize'];
        }
        if (isset($args[0]['majorUnit'])) {
            $this->_majorUnit = $args[0]['majorUnit'];
        }
        if (isset($args[0]['minorUnit'])) {
            $this->_minorUnit = $args[0]['minorUnit'];
        }
        if (isset($args[0]['scalingMax'])) {
            $this->_scalingMax = $args[0]['scalingMax'];
        }
        if (isset($args[0]['scalingMin'])) {
            $this->_scalingMin = $args[0]['scalingMin'];
        }
        if (isset($args[0]['symbol'])) {
            $this->_symbol = $args[0]['symbol'];
        }
        if (isset($args[0]['symbolSize'])) {
            $this->_symbolSize = $args[0]['symbolSize'];
        }
        if (isset($args[0]['smooth'])) {
            $this->_smooth = $args[0]['smooth'];
        }
        if (isset($args[0]['tickLblPos'])) {
            $this->_tickLblPos = $args[0]['tickLblPos'];
        }
        if (isset($args[0]['wireframe'])) {
            $this->_wireframe = $args[0]['wireframe'];
        }
    }

    /**
     * Create embedded document xml
     *
     * @access protected
     * @return array $args
     */
    protected function createEmbeddedDocumentXml()
    {
        if ($this->_textalign != '' &&
            ($this->_textalign < 0 || $this->_textalign > 5)
        ) {
            $textalign = 0;
        } else {
            $textalign = $this->_textalign;
        }
        if ($this->_sizeX != '') {
            $sizeX = $this->_sizeX * CreateImage::CONSTWORD;
        } else {
            $sizeX = 2993296;
        }
        if ($this->_sizeY != '') {
            $sizeY = $this->_sizeY * CreateImage::CONSTWORD;
        } else {
            $sizeY = 2238233;
        }

        $this->_xml = '';
        $this->generateQUITAR();
        $this->generateRPR();
        $this->generateNOPROOF();
        $this->generateDRAWING();
        if ($textalign == 0) {
            $this->generateINLINE();
        } else {
            if ($textalign == 3) {
                $this->generateANCHOR(1);
            } else {
                $this->generateANCHOR();
            }
            $this->generateSIMPLEPOS();
            $this->generatePOSITIONH();
            if (isset($this->_float) && ($this->_float == 'left' || $this->_float == 'right' || $this->_float == 'center')) {
                $this->generateALIGN($this->_float);
            }
            if (isset($this->_horizontalOffset) && is_numeric($this->_horizontalOffset)) {
                $this->generatePOSOFFSET($this->_horizontalOffset);
            } else {
                $this->generatePOSOFFSET(0);
            }
            $this->generatePOSITIONV();
            if (isset($this->_verticalOffset) && is_numeric($this->_verticalOffset)) {
                $this->generatePOSOFFSET($this->_verticalOffset);
            } else {
                $this->generatePOSOFFSET(0);
            }
        }

        $this->generateEXTENT($sizeX, $sizeY);
        $this->generateEFFECTEXTENT();
        switch ($textalign) {
            case 1:
                $this->generateWRAPSQUARE();
                break;
            case 2:
            case 3:
                $this->generateWRAPNONE();
                break;
            case 4:
                $this->generateWRAPTOPANDBOTTOM();
                break;
            case 5:
                $this->generateWRAPTHROUGH();
                $this->generateWRAPPOLYGON();
                $this->generateSTART();
                $this->generateLINETO();
                $this->generateLINETO('21540', '21342');
                $this->generateLINETO('21540', '0');
                $this->generateLINETO('-198', '0');
                break;
            default:
                break;
        }
        $this->generateDOCPR($this->getRId());
        $this->generateCNVGRAPHICFRAMEPR();
        $this->generateGRAPHIC();
        $this->generateGRAPHICDATA(
            'http://schemas.openxmlformats.org/' .
            'drawingml/2006/chart'
        );
        $this->generateDOCUMENTCHART();
        $this->cleanTemplate();
        return true;
    }

    /**
     * return the transposed matrix
     *
     * @access public
     * @param array
     */
    public function transposed($matrix)
    {
        $data = [];
        foreach ($matrix as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $data[$key2][$key] = $value2;
            }
        }
        return $data;
    }

    /**
     * return the array with just 1 deep
     *
     * @access public
     * @param array
     */
    public function linear($matrix)
    {
        $data = [];
        foreach ($matrix as $key => $value) {
            foreach ($value as $ind => $val) {
                $data[] = $val;
            }
        }
        return $data;
    }

    /**
     * return the array of data prepared to modify the chart data
     *
     * @access public
     * @param array
     */
    public function prepareData($data)
    {
        $newData = [];
        $simple = true;
        if (isset($data['legend'])) {
            unset($data['legend']);
        }
        foreach ($data as $dat) {
            if (count($dat) > 1) {
                $simple = false;
            }
            break;
        }
        foreach ($data as $dat) {
            if ($simple) {
                $newData[] = $dat[0];
            } else {
                $newData[] = $dat;
            }
        }
        if ($simple) {
            return $this->linear([$newData]);
        } else {
            return $this->linear($this->transposed($newData));
        }
    }

    /**
     * Create document xml
     *
     * @access protected
     * @param array $args[0]
     */
    protected function createDOCUEMNTXML()
    {
        if (empty($this->_textalign) ||
            $this->_textalign < 0 ||
            $this->_textalign > 5) {
            $textalign = 0;
        } else {
            $textalign = $this->_textalign;
        }

        if (!empty($this->_sizeX)) {
            $sizeX = $this->_sizeX * CreateImage::CONSTWORD;
        } else {
            $sizeX = 2993296;
        }

        if (!empty($this->_sizeY)) {
            $sizeY = $this->_sizeY * CreateImage::CONSTWORD;
        } else {
            $sizeY = 2238233;
        }

        $this->_xml = '';
        $this->generateP();
        if (!empty($this->_jc)) {
            $this->generatePPR();
            $this->generateJC($this->_jc);
        }
        $this->generateR();
        $this->generateRPR();
        $this->generateNOPROOF();
        $this->generateDRAWING();
        if ($textalign == 0) {
            $this->generateINLINE();
        } else {
            if ($textalign == 3) {
                $this->generateANCHOR(1);
            } else {
                $this->generateANCHOR();
            }
            $this->generateSIMPLEPOS();
            $this->generatePOSITIONH();
            if (isset($this->_float) && ($this->_float == 'left' || $this->_float == 'right' || $this->_float == 'center')) {
                $this->generateALIGN($this->_float);
            }
            if (isset($this->_horizontalOffset) && is_numeric($this->_horizontalOffset)) {
                $this->generatePOSOFFSET($this->_horizontalOffset);
            } else {
                $this->generatePOSOFFSET(0);
            }
            $this->generatePOSITIONV();
            if (isset($this->_verticalOffset) && is_numeric($this->_verticalOffset)) {
                $this->generatePOSOFFSET($this->_verticalOffset);
            } else {
                $this->generatePOSOFFSET(0);
            }
        }

        $this->generateEXTENT($sizeX, $sizeY);
        $this->generateEFFECTEXTENT();
        switch ($textalign) {
            case 1:
                $this->generateWRAPSQUARE();
                break;
            case 2:
            case 3:
                $this->generateWRAPNONE();
                break;
            case 4:
                $this->generateWRAPTOPANDBOTTOM();
                break;
            case 5:
                $this->generateWRAPTHROUGH();
                $this->generateWRAPPOLYGON();
                $this->generateSTART();
                $this->generateLINETO();
                $this->generateLINETO('21540', '21342');
                $this->generateLINETO('21540', '0');
                $this->generateLINETO('-198', '0');
                break;
            default:
                break;
        }
        $this->generateDOCPR($this->getRId());
        $this->generateCNVGRAPHICFRAMEPR();
        $this->generateGRAPHIC();
        $this->generateGRAPHICDATA(
            'http://schemas.openxmlformats.org/' .
            'drawingml/2006/chart'
        );
        $this->generateDOCUMENTCHART();
        $this->cleanTemplate();
        return true;
    }

    /**
     * Generate w:autotitledeleted
     *
     * @access protected
     * @param string $val
     */
    protected function generateAUTOTITLEDELETED($val = '1')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':autoTitleDeleted val="' . $val .
            '"></' . CreateGraphic::NAMESPACEWORD .
            ':autoTitleDeleted>__GENERATECHART__';
        $this->_xmlChart = str_replace(
            '__GENERATECHART__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:bar3DChart
     *
     * @access protected
     */
    protected function generateBAR3DCHART()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':bar3DChart>__GENERATETYPECHART__</' .
            CreateGraphic::NAMESPACEWORD . ':bar3DChart>__GENERATEPLOTAREA__';
        $this->_xmlChart = str_replace(
            '__GENERATEPLOTAREA__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:barChart
     *
     * @access protected
     */
    protected function generateBARCHART()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':barChart>__GENERATETYPECHART__</' .
            CreateGraphic::NAMESPACEWORD .
            ':barChart>__GENERATEPLOTAREA__';
        $this->_xmlChart = str_replace(
            '__GENERATEPLOTAREA__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:barDir
     *
     * @access protected
     * @param string $val
     */
    protected function generateBARDIR($val = 'bar')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':barDir val="' .
            $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':barDir>__GENERATETYPECHART__';
        $this->_xmlChart = str_replace(
            '__GENERATETYPECHART__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:bodypr
     *
     * @access protected
     */
    protected function generateBODYPR()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 . ':bodyPr></' .
            CreateImage::NAMESPACEWORD1 . ':bodyPr>__GENERATERICH__';
        $this->_xmlChart = str_replace(
            '__GENERATERICH__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:chart
     *
     * @access protected
     */
    protected function generateCHART()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':chart>__GENERATECHART__</' . CreateGraphic::NAMESPACEWORD .
            ':chart>__GENERATECHARTSPACE__';
        $this->_xmlChart = str_replace(
            '__GENERATECHARTSPACE__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate chartspace XML
     *
     * @access protected
     */
    protected function generateCHARTSPACE()
    {
        $this->_xmlChart = '<?xml version="1.0" encoding="UTF-8" ' .
            'standalone="yes" ?><' . CreateGraphic::NAMESPACEWORD .
            ':chartSpace xmlns:c="http://schemas.openxmlformats.o' .
            'rg/drawingml/2006/chart" xmlns:a="http://schemas.open' .
            'xmlformats.org/drawingml/2006/main" xmlns:r="http://s' .
            'chemas.openxmlformats.org/officeDocument/2006/relatio' .
            'nships">__GENERATECHARTSPACE__</' .
            CreateGraphic::NAMESPACEWORD . ':chartSpace>';
    }

    /**
     * Generate w:date1904
     *
     * @access protected
     * @param string $val
     */
    protected function generateDATE1904($val = '1')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':date1904 val="' .
            $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':date1904>__GENERATECHARTSPACE__';
        $this->_xmlChart = str_replace(
            '__GENERATECHARTSPACE__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:defrpr
     *
     * @access protected
     */
    protected function generateDEFRPR()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
            ':defRPr>__GENERATEDEFRPR__</' . CreateImage::NAMESPACEWORD1 .
            ':defRPr>__GENERATETITLEPPR__';
        $this->_xmlChart = str_replace(
            '__GENERATETITLEPPR__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:lang
     *
     * @access protected
     * @param string $val
     */
    protected function generateLANG($val = 'en-US')
    {
        $phpdocxconfig = PhpdocxUtilities::parseConfig();
        if (isset($phpdocxconfig['language'])) {
            $val = $phpdocxconfig['language'];
        }
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':lang val="' .
            $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':lang>__GENERATECHARTSPACE__';
        $this->_xmlChart = str_replace(
            '__GENERATECHARTSPACE__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:line3DChart
     *
     * @access protected
     */
    protected function generateLINE3DCHART()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':line3DChart>__GENERATETYPECHART__</' .
            CreateGraphic::NAMESPACEWORD .
            ':line3DChart>__GENERATEPLOTAREA__';
        $this->_xmlChart = str_replace(
            '__GENERATEPLOTAREA__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:lineChart
     *
     * @access protected
     */
    protected function generateLINECHART()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':lineChart>__GENERATETYPECHART__</' .
            CreateGraphic::NAMESPACEWORD .
            ':lineChart>__GENERATEPLOTAREA__';
        $this->_xmlChart = str_replace(
            '__GENERATEPLOTAREA__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:area3DChart
     *
     * @access protected
     */
    protected function generateAREA3DCHART()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':area3DChart>__GENERATETYPECHART__</' .
            CreateGraphic::NAMESPACEWORD .
            ':area3DChart>__GENERATEPLOTAREA__';
        $this->_xmlChart = str_replace(
            '__GENERATEPLOTAREA__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:areaChart
     *
     * @access protected
     */
    protected function generateAREACHART()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':areaChart>__GENERATETYPECHART__</' .
            CreateGraphic::NAMESPACEWORD .
            ':areaChart>__GENERATEPLOTAREA__';
        $this->_xmlChart = str_replace(
            '__GENERATEPLOTAREA__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:perspective
     *
     * @access protected
     * @param string $val
     */
    protected function generatePERSPECTIVE($val = '30')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':perspective val="' . $val . '"></' .
            CreateGraphic::NAMESPACEWORD . ':perspective>';
        $this->_xmlChart = str_replace(
            '__GENERATEVIEW3D__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:pie3DChart
     *
     * @access protected
     */
    protected function generatePIE3DCHART()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':pie3DChart>__GENERATETYPECHART__</' .
            CreateGraphic::NAMESPACEWORD .
            ':pie3DChart>__GENERATEPLOTAREA__';
        $this->_xmlChart = str_replace(
            '__GENERATEPLOTAREA__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:piechart
     *
     * @access protected
     */
    protected function generatePIECHART()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':pieChart>__GENERATETYPECHART__</' .
            CreateGraphic::NAMESPACEWORD .
            ':pieChart>__GENERATEPLOTAREA__';
        $this->_xmlChart = str_replace(
            '__GENERATEPLOTAREA__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:surfaceChart
     *
     * @access protected
     */
    protected function generateSURFACECHART()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':surfaceChart>__GENERATETYPECHART__</' .
            CreateGraphic::NAMESPACEWORD .
            ':surfaceChart>__GENERATEPLOTAREA__';
        $this->_xmlChart = str_replace(
            '__GENERATEPLOTAREA__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:wireframe
     *
     * @access protected
     */
    protected function generateWIREFRAME($val = 1)
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':wireframe val="' . $val . '" />__GENERATETYPECHART__';
        $this->_xmlChart = str_replace(
            '__GENERATETYPECHART__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:bubbleChart
     *
     * @access protected
     */
    protected function generateBUBBLECHART()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':bubbleChart>__GENERATETYPECHART__</' .
            CreateGraphic::NAMESPACEWORD .
            ':bubbleChart>__GENERATEPLOTAREA__';
        $this->_xmlChart = str_replace(
            '__GENERATEPLOTAREA__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:plotarea
     *
     * @access protected
     */
    protected function generatePLOTAREA()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':plotArea>__GENERATEPLOTAREA__</' . CreateGraphic::NAMESPACEWORD .
            ':plotArea>__GENERATECHART__';
        $this->_xmlChart = str_replace(
            '__GENERATECHART__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:radarChart
     *
     * @access protected
     */
    protected function generateRADARCHART()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':radarChart>__GENERATETYPECHART__</' .
            CreateGraphic::NAMESPACEWORD .
            ':radarChart>__GENERATEPLOTAREA__';
        $this->_xmlChart = str_replace(
            '__GENERATEPLOTAREA__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:radarChart
     *
     * @access protected
     */
    protected function generateRADARCHARTSTYLE($style = 'radar')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':radarStyle val="' . $style . '" />__GENERATETYPECHART__';
        $this->_xmlChart = str_replace(
            '__GENERATETYPECHART__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:rich
     *
     * @access protected
     */
    protected function generateRICH()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':rich>__GENERATERICH__</' . CreateGraphic::NAMESPACEWORD .
            ':rich>__GENERATETITLETX__';
        $this->_xmlChart = str_replace(
            '__GENERATETITLETX__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:rotx
     *
     * @access protected
     * @param string $val
     */
    protected function generateROTX($val = '30')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':rotX val="' .
            $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':rotX>__GENERATEVIEW3D__';
        $this->_xmlChart = str_replace(
            '__GENERATEVIEW3D__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:roty
     *
     * @access protected
     * @param string $val
     */
    protected function generateROTY($val = '30')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':rotY val="' . $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':rotY>__GENERATEVIEW3D__';
        $this->_xmlChart = str_replace(
            '__GENERATEVIEW3D__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate rAngAx
     *
     * @access protected
     * @param string $val
     */
    protected function generateRANGAX($val = 0)
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':rAngAx val="' . $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':rAngAx>__GENERATEVIEW3D__';
        $this->_xmlChart = str_replace(
            '__GENERATEVIEW3D__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate roundedCorners
     *
     * @access protected
     * @param string $val
     */
    protected function generateROUNDEDCORNERS($val = 0)
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':roundedCorners val="' . $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':roundedCorners>__GENERATECHARTSPACE__';
        $this->_xmlChart = str_replace(
            '__GENERATECHARTSPACE__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:style
     *
     * @access protected
     * @param string $val
     */
    protected function generateSTYLE($val = '2')
    {
        $style_2010 = (int) $val + 100;
        $xml = '<mc:AlternateContent xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006">
                    <mc:Choice xmlns:c14="http://schemas.microsoft.com/office/drawing/2007/8/2/chart" Requires="c14">
                        <c14:style val="' . $style_2010 . '"/>
                    </mc:Choice>
                    <mc:Fallback>
                        <c:style val="' . $val . '"/>
                    </mc:Fallback>
                  </mc:AlternateContent>__GENERATECHARTSPACE__';
        $this->_xmlChart = str_replace(
            '__GENERATECHARTSPACE__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:title
     *
     * @access protected
     */
    protected function generateTITLE()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':title>__GENERATETITLE__<c:overlay val="0" /></' . //We include the overlay=0 as a hack for Word 2010
            CreateGraphic::NAMESPACEWORD . ':title>__GENERATECHART__';
        $this->_xmlChart = str_replace(
            '__GENERATECHART__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:layout
     *
     * @access protected
     */
    protected function generateLAYOUT()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':layout></' . CreateGraphic::NAMESPACEWORD .
            ':layout>__GENERATEPLOTAREA__';
        $this->_xmlChart = str_replace(
            '__GENERATEPLOTAREA__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:titlelayout
     *
     * @access protected
     * @param string $nombre
     */
    protected function generateTITLELAYOUT($nombre = '')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
            ':layout></' . CreateImage::NAMESPACEWORD1 .
            ':layout>';
        $this->_xmlChart = str_replace(
            '__GENERATETITLE__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:titlep
     *
     * @access protected
     */
    protected function generateTITLEP()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
            ':p>__GENERATETITLEP__</' . CreateImage::NAMESPACEWORD1 .
            ':p>__GENERATERICH__';
        $this->_xmlChart = str_replace(
            '__GENERATERICH__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:titleppr
     *
     * @access protected
     */
    protected function generateTITLEPPR()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
            ':pPr>__GENERATETITLEPPR__</' . CreateImage::NAMESPACEWORD1 .
            ':pPr>__GENERATETITLEP__';
        $this->_xmlChart = str_replace(
            '__GENERATETITLEP__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:titler
     *
     * @access protected
     */
    protected function generateTITLER()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
            ':r>__GENERATETITLER__</' . CreateImage::NAMESPACEWORD1 .
            ':r>__GENERATETITLEP__';
        $this->_xmlChart = str_replace(
            '__GENERATETITLEP__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:titlerfonts
     *
     * @access protected
     * @param string $font
     */
    protected function generateTITLERFONTS($font = '')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 . ':latin typeface="' .
            $font . '" pitchFamily="34" charset="0"></' .
            CreateImage::NAMESPACEWORD1 . ':latin ><' .
            CreateImage::NAMESPACEWORD1 .
            ':cs typeface="' . $font . '" pitchFamily="34" charset="0"></' .
            CreateImage::NAMESPACEWORD1 . ':cs>';
        $this->_xmlChart = str_replace(
            '__GENERATETITLERPR__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:titlerpr
     *
     * @access protected
     */
    protected function generateTITLERPR($lang = 'es-ES')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 . ':rPr lang="' .
            $lang . '">__GENERATETITLERPR__</' . CreateImage::NAMESPACEWORD1 .
            ':rPr>__GENERATETITLER__';
        $this->_xmlChart = str_replace(
            '__GENERATETITLER__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:titlet
     *
     * @access protected
     * @param string $nombre
     */
    protected function generateTITLET($nombre = '')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 . ':t>' .
            $nombre . '</' . CreateImage::NAMESPACEWORD1 .
            ':t>__GENERATETITLER__';
        $this->_xmlChart = str_replace(
            '__GENERATETITLER__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:titletx
     *
     * @access protected
     */
    protected function generateTITLETX()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':tx>__GENERATETITLETX__</' . CreateGraphic::NAMESPACEWORD .
            ':tx>__GENERATETITLE__';
        $this->_xmlChart = str_replace(
            '__GENERATETITLE__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:varyColors
     *
     * @access protected
     * @param string $val
     */
    protected function generateVARYCOLORS($val = '1')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':varyColors val="' .
            $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':varyColors>__GENERATETYPECHART__';
        $this->_xmlChart = str_replace(
            '__GENERATETYPECHART__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:view3D
     *
     * @access protected
     */
    protected function generateVIEW3D()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':view3D>__GENERATEVIEW3D__</' . CreateGraphic::NAMESPACEWORD .
            ':view3D>__GENERATECHART__';
        $this->_xmlChart = str_replace(
            '__GENERATECHART__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:grouping
     *
     * @access protected
     * @param string $val
     */
    protected function generateGROUPING($val = 'stacked')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':grouping val="' . $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':grouping>__GENERATETYPECHART__';
        $this->_xmlChart = str_replace(
            '__GENERATETYPECHART__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:ser
     *
     * @access protected
     */
    protected function generateSER()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':ser>__GENERATESER__</' . CreateGraphic::NAMESPACEWORD .
            ':ser>__GENERATETYPECHART__';
        $this->_xmlChart = str_replace(
            '__GENERATETYPECHART__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:idx
     *
     * @access protected
     * @param string $val
     */
    protected function generateIDX($val = '0')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':idx val="' . $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':idx>__GENERATESER__';
        $this->_xmlChart = str_replace(
            '__GENERATESER__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:order
     *
     * @access protected
     * @param string $val
     */
    protected function generateORDER($val = '0')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':order val="' . $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':order>__GENERATESER__';
        $this->_xmlChart = str_replace(
            '__GENERATESER__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:tx
     *
     * @access protected
     */
    protected function generateTX()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':tx>__GENERATETX__</' . CreateGraphic::NAMESPACEWORD .
            ':tx>__GENERATESER__';
        $this->_xmlChart = str_replace(
            '__GENERATESER__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:dLbls
     *
     * @access protected
     */
    protected function generateSERDLBLS()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':dLbls>__GENERATEDLBLS__</' . CreateGraphic::NAMESPACEWORD .
            ':dLbls>__GENERATETYPECHART__';
        $this->_xmlChart = str_replace(
            '__GENERATETYPECHART__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:showBubbleSize
     *
     * @access protected
     */
    protected function generateSHOWBUBBLESIZE($val = 1)
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':showBubbleSize val="' . $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':showBubbleSize>';
        $this->_xmlChart = str_replace(
            '__GENERATEDLBLS__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:showLegendKey
     *
     * @access protected
     */
    protected function generateSHOWLEGENDKEY($val = 1)
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':showLegendKey val="' . $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':showLegendKey>__GENERATEDLBLS__';
        $this->_xmlChart = str_replace(
            '__GENERATEDLBLS__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:showVal
     *
     * @access protected
     */
    protected function generateSHOWVAL($val = 1)
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':showVal val="' . $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':showVal>__GENERATEDLBLS__';
        $this->_xmlChart = str_replace(
            '__GENERATEDLBLS__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:showCatName
     *
     * @access protected
     */
    protected function generateSHOWCATNAME($val = 1)
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':showCatName val="' . $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':showCatName>__GENERATEDLBLS__';
        $this->_xmlChart = str_replace(
            '__GENERATEDLBLS__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:showSerName
     *
     * @access protected
     */
    protected function generateSHOWSERNAME($val = 1)
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':showSerName val="' . $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':showSerName>__GENERATEDLBLS__';
        $this->_xmlChart = str_replace(
            '__GENERATEDLBLS__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:strref
     *
     * @access protected
     */
    protected function generateSTRREF()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':strRef>__GENERATESTRREF__</' . CreateGraphic::NAMESPACEWORD .
            ':strRef>__GENERATETX__';
        $this->_xmlChart = str_replace(
            '__GENERATETX__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:f
     *
     * @access protected
     * @param string $val
     */
    protected function generateF($val = 'Sheet1!$B$1')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':f>' .
            $val . '</' . CreateGraphic::NAMESPACEWORD .
            ':f>__GENERATESTRREF__';
        $this->_xmlChart = str_replace(
            '__GENERATESTRREF__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:strcache
     *
     * @access protected
     */
    protected function generateSTRCACHE()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':strCache>__GENERATESTRCACHE__</' . CreateGraphic::NAMESPACEWORD .
            ':strCache>__GENERATESTRREF__';
        $this->_xmlChart = str_replace(
            '__GENERATESTRREF__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:ptcount
     *
     * @access protected
     * @param string $val
     */
    protected function generatePTCOUNT($val = '1')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':ptCount val="' .
            $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':ptCount>__GENERATESTRCACHE__';
        $this->_xmlChart = str_replace(
            '__GENERATESTRCACHE__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:pt
     *
     * @access protected
     * @param string $idx
     */
    protected function generatePT($idx = '0')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':pt idx="' .
            $idx . '">__GENERATEPT__</' . CreateGraphic::NAMESPACEWORD .
            ':pt>__GENERATESTRCACHE__';
        $this->_xmlChart = str_replace(
            '__GENERATESTRCACHE__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:v
     *
     * @access protected
     * @param string $idx
     */
    protected function generateV($idx = 'Ventas')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':v>' .
            $idx . '</' . CreateGraphic::NAMESPACEWORD . ':v>';
        $this->_xmlChart = str_replace(
            '__GENERATEPT__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:cat
     *
     * @access protected
     */
    protected function generateCAT()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':cat>__GENERATETX__</' . CreateGraphic::NAMESPACEWORD .
            ':cat>__GENERATESER__';
        $this->_xmlChart = str_replace(
            '__GENERATESER__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:val
     *
     * @access protected
     */
    protected function generateVAL()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':val>__GENERATETX__</' . CreateGraphic::NAMESPACEWORD .
            ':val>__GENERATESER__';
        $this->_xmlChart = str_replace(
            '__GENERATESER__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:numcache
     *
     * @access protected
     */
    protected function generateNUMCACHE()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':numCache>__GENERATESTRCACHE__</' .
            CreateGraphic::NAMESPACEWORD . ':numCache>__GENERATESTRREF__';
        $this->_xmlChart = str_replace(
            '__GENERATESTRREF__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:layout
     *
     * @access protected
     * @param string $font
     */
    protected function generateLEGENDLAYOUT()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':layout />__GENERATELEGEND__';
        $this->_xmlChart = str_replace(
            '__GENERATELEGEND__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:xVal
     *
     * @access protected
     */
    protected function generateXVAL()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':xVal>__GENERATETX__</' . CreateGraphic::NAMESPACEWORD .
            ':xVal>__GENERATESER__';
        $this->_xmlChart = str_replace(
            '__GENERATESER__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:spPr
     *
     * @access protected
     */
    protected function generateSPPR_SER()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':spPr>__GENERATESPPR__</' . CreateGraphic::NAMESPACEWORD .
            ':spPr>__GENERATESER__';
        $this->_xmlChart = str_replace(
            '__GENERATESER__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:yVal
     *
     * @access protected
     */
    protected function generateYVAL()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':yVal>__GENERATETX__</' . CreateGraphic::NAMESPACEWORD .
            ':yVal>__GENERATESER__';
        $this->_xmlChart = str_replace(
            '__GENERATESER__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:bubbleSize
     *
     * @access protected
     */
    protected function generateBUBBLESIZE()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':bubbleSize>__GENERATETX__</' . CreateGraphic::NAMESPACEWORD .
            ':bubbleSize>__GENERATESER__';
        $this->_xmlChart = str_replace(
            '__GENERATESER__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:smooth
     *
     * @access protected
     */
    protected function generateSMOOTH($val = 1)
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':smooth val="' . $val . '">__GENERATETX__</' . CreateGraphic::NAMESPACEWORD .
            ':smooth>__GENERATESER__';
        $this->_xmlChart = str_replace(
            '__GENERATESER__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:bubble3D
     *
     * @access protected
     */
    protected function generateBUBBLES3D($val = 1)
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':bubble3D val="' . $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':bubble3D>__GENERATESER__';
        $this->_xmlChart = str_replace(
            '__GENERATESER__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:bubbleScale
     *
     * @access protected
     */
    protected function generateBUBBLESCALE($val = 100)
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':bubbleScale val="' . $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':bubbleScale>__GENERATETYPECHART__';
        $this->_xmlChart = str_replace(
            '__GENERATETYPECHART__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate a:txPr
     *
     * @access protected
     * @param string $font
     */
    protected function generateTXPR()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':txPr>__GENERATETXPR__</' . CreateGraphic::NAMESPACEWORD . ':txPr>__GENERATECHARTSPACE__';
        $this->_xmlChart = str_replace(
            '__GENERATECHARTSPACE__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:bodyPr
     *
     * @access protected
     */
    protected function generateLEGENDBODYPR()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 . ':bodyPr></' . CreateImage::NAMESPACEWORD1 . ':bodyPr>__GENERATERICH__';
        $this->_xmlChart = str_replace(
            '__GENERATETXPR__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:lststyle
     *
     * @access protected
     */
    protected function generateLSTSTYLE()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
            ':lstStyle></' . CreateImage::NAMESPACEWORD1 .
            ':lstStyle>__GENERATERICH__';
        $this->_xmlChart = str_replace(
            '__GENERATERICH__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate a:p
     *
     * @access protected
     */
    protected function generateAP()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 . ':p>__GENERATEAP__</' . CreateImage::NAMESPACEWORD1 . ':p>__GENERATERICH__';
        $this->_xmlChart = str_replace(
            '__GENERATERICH__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate a:pPr
     *
     * @access protected
     */
    protected function generateAPPR($rtl = 0)
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 . ':pPr rtl="' . $rtl . '">__GENERATETITLEPPR__</' . CreateImage::NAMESPACEWORD1 . ':pPr>__GENERATEAP__';
        $this->_xmlChart = str_replace(
            '__GENERATEAP__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate a:endParaRPr
     *
     * @access protected
     */
    protected function generateENDPARARPR($lang = "es-ES_tradnl")
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 . ':endParaRPr lang="' . $lang . '" />__GENERATEAP__';
        $this->_xmlChart = str_replace(
            '__GENERATEAP__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:numRef
     *
     * @access protected
     */
    protected function generateNUMREF()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':numRef>__GENERATESTRREF__</' . CreateGraphic::NAMESPACEWORD .
            ':numRef>__GENERATETX__';
        $this->_xmlChart = str_replace(
            '__GENERATETX__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:formatCode
     *
     * @access protected
     * @param string $val
     */
    protected function generateFORMATCODE($val = 'General')
    {
        $this->_xmlChart = str_replace(
            '__GENERATESTRCACHE__', '<' . CreateGraphic::NAMESPACEWORD . ':formatCode>' . $val .
            '</' . CreateGraphic::NAMESPACEWORD .
            ':formatCode>__GENERATESTRCACHE__', $this->_xmlChart
        );
    }

    /**
     * Generate w:legend
     *
     * @access protected
     */
    protected function generateLEGEND()
    {
        if ($this->_legendPos != 'none') {
            $xml = '<' . CreateGraphic::NAMESPACEWORD .
                ':legend>__GENERATELEGEND__</' .
                CreateGraphic::NAMESPACEWORD . ':legend>__GENERATECHART__';
            $this->_xmlChart = str_replace(
                '__GENERATECHART__', $xml, $this->_xmlChart
            );
        }
    }

    /**
     * Generate c:legendPos
     *
     * @access protected
     * @param string $val
     */
    protected function generateLEGENDPOS($val = 'r')
    {
        if ($val != 'none') {
            $xml = '<' . CreateGraphic::NAMESPACEWORD . ':legendPos val="' .
                $val . '"></' . CreateGraphic::NAMESPACEWORD .
                ':legendPos>__GENERATELEGEND__';
            $this->_xmlChart = str_replace(
                '__GENERATELEGEND__', $xml, $this->_xmlChart
            );
        }
    }

    /**
     * Generate c:layout
     *
     * @access protected
     * @param string $font
     */
    protected function generateLEGENDFONT($font = '')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':layout />' .
            '<' . CreateGraphic::NAMESPACEWORD . ':txPr>' .
            '<a:bodyPr /><a:lstStyle /><a:p><a:pPr><a:defRPr>' .
            '<a:latin typeface="' . $font . '" pitchFamily="34" charset="0" />' .
            '<a:cs typeface="' . $font . '" pitchFamily="34" charset="0" />' .
            '</a:defRPr></a:pPr><a:endParaRPr lang="es-ES" /></a:p>' .
            '</' . CreateGraphic::NAMESPACEWORD . ':txPr>';
        $this->_xmlChart = str_replace(
            '__GENERATELEGEND__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:overlay
     *
     * @access protected
     * @param string $val
     */
    protected function generateLEGENDOVERLAY($val = 0)
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':overlay val="' .
            $val . '" />__GENERATELEGEND__';
        $this->_xmlChart = str_replace(
            '__GENERATELEGEND__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:poltVisOnly
     *
     * @access protected
     * @param string $val
     */
    protected function generatePLOTVISONLY($val = '1')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':plotVisOnly val="' .
            $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':plotVisOnly>__GENERATECHART__';
        $this->_xmlChart = str_replace(
            '__GENERATECHART__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:externalData
     *
     * @access protected
     * @param string $val
     */
    protected function generateEXTERNALDATA($val = 'rId1')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':externalData r:id="' . $val . '"></' .
            CreateGraphic::NAMESPACEWORD . ':externalData>';
        $this->_xmlChart = str_replace(
            '__GENERATECHARTSPACE__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:spPr
     *
     * @access protected
     */
    protected function generateSPPR()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':spPr>__GENERATESPPR__</' . CreateGraphic::NAMESPACEWORD .
            ':spPr>__GENERATECHARTSPACE__';
        $this->_xmlChart = str_replace(
            '__GENERATECHARTSPACE__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:ln
     *
     * @access protected
     */
    protected function generateLN($w = NULL)
    {
        if (is_numeric($w)) {
            $xml = '<' . CreateImage::NAMESPACEWORD1 . ':ln w="' . ($w * 12700) . '">__GENERATELN__</' .
                CreateImage::NAMESPACEWORD1 . ':ln>';
        } else {
            $xml = '<' . CreateImage::NAMESPACEWORD1 . ':ln>__GENERATELN__</' .
                CreateImage::NAMESPACEWORD1 . ':ln>';
        }
        $this->_xmlChart = str_replace(
            '__GENERATESPPR__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:noFill
     *
     * @access protected
     */
    protected function generateNOFILL()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 . ':noFill></' .
            CreateImage::NAMESPACEWORD1 . ':noFill>';
        $this->_xmlChart = str_replace(
            '__GENERATELN__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:overlap
     *
     * @access protected
     * @param string $val
     */
    protected function generateOVERLAP($val = '100')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':overlap val="' .
            $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':overlap>__GENERATETYPECHART__';
        $this->_xmlChart = str_replace(
            '__GENERATETYPECHART__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:shape
     *
     * @access protected
     * @param string $val
     */
    protected function generateSHAPE($val = 'box')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':shape val="' .
            $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':shape>__GENERATETYPECHART__';
        $this->_xmlChart = str_replace(
            '__GENERATETYPECHART__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:bandFmts
     *
     * @access protected
     * @param string $val
     */
    protected function generateBANDFMTS($val = 'box')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':bandFmts />__GENERATETYPECHART__';
        $this->_xmlChart = str_replace(
            '__GENERATETYPECHART__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:axid
     *
     * @access protected
     * @param string $val
     */
    protected function generateAXID($val = '59034624')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':axId val="' .
            $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':axId>__GENERATETYPECHART__';
        $this->_xmlChart = str_replace(
            '__GENERATETYPECHART__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:firstSliceAng
     *
     * @access protected
     * @param string $val
     */
    protected function generateFIRSTSLICEANG($val = '0')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':firstSliceAng val="' . $val . '"></' .
            CreateGraphic::NAMESPACEWORD . ':firstSliceAng>' . '__GENERATETYPECHART__';
        $this->_xmlChart = str_replace(
            '__GENERATETYPECHART__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:dLbls
     *
     * @access protected
     */
    protected function generateDLBLS()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':dLbls>__GENERATEDLBLS__</' . CreateGraphic::NAMESPACEWORD .
            ':dLbls>__GENERATETYPECHART__';
        $this->_xmlChart = str_replace(
            '__GENERATETYPECHART__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:holeSize
     *
     * @access protected
     */
    protected function generateHOLESIZE($val = 50)
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':holeSize val="' . $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':holeSize>__GENERATETYPECHART__';
        $this->_xmlChart = str_replace(
            '__GENERATETYPECHART__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:showPercent
     *
     * @access protected
     * @param string $val
     */
    protected function generateSHOWPERCENT($val = '0')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':showPercent val="' . $val . '"></' .
            CreateGraphic::NAMESPACEWORD . ':showPercent>__GENERATEDLBLS__';
        $this->_xmlChart = str_replace(
            '__GENERATEDLBLS__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:chart
     *
     * @access protected
     */
    protected function generateDOCUMENTCHART()
    {
        $this->_xml = str_replace(
            '__GENERATEGRAPHICDATA__', '<' . CreateGraphic::NAMESPACEWORD .
            ':chart xmlns:c="http://schemas.openxmlformats.org/drawingml/' .
            '2006/chart" xmlns:r="http://schemas.openxmlformats.org/offic' .
            'eDocument/2006/relationships" r:id="rId' . $this->getRId() .
            '"></' . CreateGraphic::NAMESPACEWORD .
            ':chart>', $this->_xml
        );
    }

    /**
     * Generate w:catAx
     *
     * @access protected
     */
    protected function generateCATAX()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':catAx>__GENERATEAX__</' . CreateGraphic::NAMESPACEWORD .
            ':catAx>__GENERATEPLOTAREA__';
        $this->_xmlChart = str_replace(
            '__GENERATEPLOTAREA__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:dTable
     *
     * @access protected
     */
    protected function generateDATATABLE()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':dTable>' .
            '<' . CreateGraphic::NAMESPACEWORD . ':showHorzBorder val="1"/>' .
            '<' . CreateGraphic::NAMESPACEWORD . ':showVertBorder val="1"/>' .
            '<' . CreateGraphic::NAMESPACEWORD . ':showOutline val="1"/>' .
            '<' . CreateGraphic::NAMESPACEWORD . ':showKeys val="1"/>' .
            '</' . CreateGraphic::NAMESPACEWORD . ':dTable>__GENERATEPLOTAREA__';
        $this->_xmlChart = str_replace(
            '__GENERATEPLOTAREA__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:valAx
     *
     * @access protected
     */
    protected function generateVALAX()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':valAx>__GENERATEAX__</' .
            CreateGraphic::NAMESPACEWORD .
            ':valAx>__GENERATEPLOTAREA__';
        $this->_xmlChart = str_replace(
            '__GENERATEPLOTAREA__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:axId
     *
     * @access protected
     * @param <type> $val
     */
    protected function generateAXAXID($val = '59034624')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':axId val="' .
            $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':axId>__GENERATEAX__';
        $this->_xmlChart = str_replace(
            '__GENERATEAX__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:scaling
     *
     * @access protected
     */
    protected function generateDELETE($val = 0)
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':delete val="' . $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':delete>__GENERATEAX__';
        $this->_xmlChart = str_replace(
            '__GENERATEAX__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:scaling
     *
     * @access protected
     * @param bool $addScalingValues
     */
    protected function generateSCALING($addScalingValues = false)
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':scaling>__GENERATESCALING__</' . CreateGraphic::NAMESPACEWORD .
            ':scaling>__GENERATEAX__';

        if ($this->_scalingMax !== null && $addScalingValues) {
            $xml = str_replace(
                '__GENERATESCALING__', '<' . CreateGraphic::NAMESPACEWORD .
                ':max val="'.$this->_scalingMax.'" />__GENERATESCALING__', $xml
            );
        }

        if ($this->_scalingMin !== null && $addScalingValues) {
            $xml = str_replace(
                '__GENERATESCALING__', '<' . CreateGraphic::NAMESPACEWORD .
                ':min val="'.$this->_scalingMin.'" />__GENERATESCALING__', $xml
            );
        }

        $this->_xmlChart = str_replace(
            '__GENERATEAX__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:orientation
     *
     * @access protected
     * @param string $val
     */
    protected function generateORIENTATION($val = 'minMax')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':orientation val="' .
            $val . '"></' . CreateGraphic::NAMESPACEWORD . ':orientation>';
        $this->_xmlChart = str_replace(
            '__GENERATESCALING__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:axPos
     *
     * @access protected
     * @param string $val
     */
    protected function generateAXPOS($val = 'b')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':axPos val="' . $val .
            '"></' . CreateGraphic::NAMESPACEWORD . ':axPos>__GENERATEAX__';
        $this->_xmlChart = str_replace(
            '__GENERATEAX__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:title
     *
     * @access protected
     * @param string $val
     */
    protected function generateAXLABEL($val = 'Axis title')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':title><c:tx><c:rich>' .
            '__GENERATEBODYPR__<a:lstStyle/><a:p><a:pPr><a:defRPr/></a:pPr>' .
            '<a:r><a:t>' . $val . '</a:t></a:r></a:p></c:rich></c:tx>' .
            '</' . CreateGraphic::NAMESPACEWORD . ':title>__GENERATEAX__';
        $this->_xmlChart = str_replace(
            '__GENERATEAX__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate a:bodyPr
     *
     * @access protected
     * @param string $val
     */
    protected function generateAXLABELDISP($val = 'horz', $rot = 0)
    {
        $xml = '<a:bodyPr rot="' . $rot . '" vert="' . $val . '"/>';
        $this->_xmlChart = str_replace(
            '__GENERATEBODYPR__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:surface3DChart
     *
     * @access protected
     */
    protected function generateSURFACE3DCHART()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':surface3DChart>__GENERATETYPECHART__</' .
            CreateGraphic::NAMESPACEWORD .
            ':surface3DChart>__GENERATEPLOTAREA__';
        $this->_xmlChart = str_replace(
            '__GENERATEPLOTAREA__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:serAx
     *
     * @access protected
     */
    protected function generateSERAX()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':serAx>__GENERATEAX__</' .
            CreateGraphic::NAMESPACEWORD .
            ':serAx>__GENERATEPLOTAREA__';
        $this->_xmlChart = str_replace(
            '__GENERATEPLOTAREA__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:scatterStyle
     *
     * @access protected
     */
    protected function generateSCATTERSTYLE($style = 'smoothMarker')
    {
        $possibleStyles = ['none', 'line', 'lineMarker', 'marker', 'smooth', 'smoothMarker'];
        if (!in_array($style, $possibleStyles))
            $style = 'smoothMarker';
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':scatterStyle val="' . $style . '" />__GENERATETYPECHART__';
        $this->_xmlChart = str_replace(
            '__GENERATETYPECHART__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:tickLblPos
     *
     * @access protected
     * @param string $val
     * @param bool $isHorizontal
     */
    protected function generateTICKLBLPOS($val = 'nextTo', $isHorizontal = false)
    {
        if ($isHorizontal) {
            $val = $this->_tickLblPos;
        }

        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':tickLblPos val="' .
            $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':tickLblPos>__GENERATEAX__';
        $this->_xmlChart = str_replace(
            '__GENERATEAX__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:crossAx
     *
     * @access protected
     * @param string $val
     */
    protected function generateCROSSAX($val = '59040512')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':crossAx  val="' .
            $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':crossAx >__GENERATEAX__';
        $this->_xmlChart = str_replace(
            '__GENERATEAX__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:crosses
     *
     * @access protected
     * @param string $val
     */
    protected function generateCROSSES($val = 'autoZero')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':crosses val="' .
            $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':crosses>__GENERATEAX__';
        $this->_xmlChart = str_replace(
            '__GENERATEAX__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:auto
     *
     * @access protected
     * @param string $val
     */
    protected function generateAUTO($val = '1')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':auto val="' .
            $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':auto>__GENERATEAX__';
        $this->_xmlChart = str_replace(
            '__GENERATEAX__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:lblAlgn
     *
     * @access protected
     * @param string $val
     */
    protected function generateLBLALGN($val = 'ctr')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':lblAlgn val="' .
            $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':lblAlgn>__GENERATEAX__';
        $this->_xmlChart = str_replace(
            '__GENERATEAX__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:lblOffset
     *
     * @access protected
     * @param string $val
     */
    protected function generateLBLOFFSET($val = '100')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':lblOffset val="' .
            $val . '"></' . CreateGraphic::NAMESPACEWORD . ':lblOffset>';
        $this->_xmlChart = str_replace(
            '__GENERATEAX__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:majorTickMark
     *
     * @access protected
     */
    protected function generateMAJORTICKMARK($val = 'none')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':majorTickMark val="' . $val . '"></' .
            CreateGraphic::NAMESPACEWORD . ':majorTickMark>__GENERATEAX__';
        $this->_xmlChart = str_replace(
            '__GENERATEAX__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:majorUnit
     *
     * @access protected
     */
    protected function generateMAJORUNIT($val = null)
    {
        if ($val !== null) {
            $xml = '<' . CreateGraphic::NAMESPACEWORD . ':majorUnit val="' . $val . '"></' .
                CreateGraphic::NAMESPACEWORD . ':majorUnit>__GENERATEAX__';
            $this->_xmlChart = str_replace(
                '__GENERATEAX__', $xml, $this->_xmlChart
            );
        }
    }

    /**
     * Generate c:minorUnit
     *
     * @access protected
     */
    protected function generateMINORUNIT($val = null)
    {
        if ($val !== null) {
            $xml = '<' . CreateGraphic::NAMESPACEWORD . ':minorUnit val="' . $val . '"></' .
                CreateGraphic::NAMESPACEWORD . ':minorUnit>__GENERATEAX__';
            $this->_xmlChart = str_replace(
                '__GENERATEAX__', $xml, $this->_xmlChart
            );
        }
    }

    /**
     * Generate c:majorGridlines
     *
     * @access protected
     */
    protected function generateMAJORGRIDLINES()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':majorGridlines></' .
            CreateGraphic::NAMESPACEWORD . ':majorGridlines>__GENERATEAX__';
        $this->_xmlChart = str_replace(
            '__GENERATEAX__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:majorGridlines
     *
     * @access protected
     */
    protected function generateMARKER($symbol = 'none', $size = NULL)
    {
        $symbols = ['circle', 'dash', 'diamond', 'dot', 'none', 'picture', 'plus', 'square', 'star', 'triangle', 'x'];
        if (!in_array($symbol, $symbols)) {
            $symbol = 'none';
        }
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':marker>' .
            '<' . CreateGraphic::NAMESPACEWORD . ':symbol val="' . $symbol . '"/>';
        if (!empty($size) && is_int($size) && $size < 73 && $size > 1) {
            $xml .= '<' . CreateGraphic::NAMESPACEWORD . ':size val="' . $size . '"></' . CreateGraphic::NAMESPACEWORD . ':size>';
        }
        $xml .= '</' . CreateGraphic::NAMESPACEWORD . ':marker>__GENERATESER__';
        $this->_xmlChart = str_replace(
            '__GENERATESER__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:majorGridlines
     *
     * @access protected
     */
    protected function generateMINORGRIDLINES($val = '')
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':minorGridlines></' .
            CreateGraphic::NAMESPACEWORD . ':minorGridlines>__GENERATEAX__';
        $this->_xmlChart = str_replace(
            '__GENERATEAX__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:numFmt
     *
     * @access protected
     * @param string $formatCode
     * @param string $sourceLinked
     */
    protected function generateNUMFMT($formatCode = 'General', $sourceLinked = '1')
    {
        $this->_xmlChart = str_replace(
            '__GENERATEAX__', '<' .
            CreateGraphic::NAMESPACEWORD .
            ':numFmt formatCode="' . $formatCode .
            '" sourceLinked="' . $sourceLinked . '"></' .
            CreateGraphic::NAMESPACEWORD . ':numFmt>__GENERATEAX__', $this->_xmlChart
        );
    }

    /**
     * Generate w:latin
     *
     * @access protected
     * @param string $font
     */
    protected function generateRFONTS($font)
    {
        $this->_xmlChart = str_replace(
            '__GENERATEDEFRPR__', '<' .
            CreateImage::NAMESPACEWORD1 . ':latin typeface="' .
            $font . '" pitchFamily="34" charset="0"></' .
            CreateImage::NAMESPACEWORD1 . ':latin ><' .
            CreateImage::NAMESPACEWORD1 . ':cs typeface="' .
            $font . '" pitchFamily="34" charset="0"></' .
            CreateImage::NAMESPACEWORD1 . ':cs>', $this->_xmlChart
        );
    }

    /**
     * Generate w:crossBetween
     *
     * @access protected
     * @param string $val
     */
    protected function generateCROSSBETWEEN($val = 'between')
    {
        $this->_xmlChart = str_replace(
            '__GENERATEAX__', '<' .
            CreateGraphic::NAMESPACEWORD . ':crossBetween val="' .
            $val . '"></' . CreateGraphic::NAMESPACEWORD .
            ':crossBetween>', $this->_xmlChart
        );
    }

    /**
     * Generate w:ofPieChart
     *
     * @access protected
     * @param string $val
     */
    protected function generateOFPIECHART()
    {
        $this->_xmlChart = str_replace(
            '__GENERATEPLOTAREA__', '<' .
            CreateGraphic::NAMESPACEWORD . ':ofPieChart>' .
            '__GENERATETYPECHART__' .
            '</' . CreateGraphic::NAMESPACEWORD . ':ofPieChart>', $this->_xmlChart
        );
    }

    /**
     * Generate c:ofPieType
     *
     * @access protected
     * @param string $val
     */
    protected function generateOFPIETYPE($val = 'pie')
    {
        if (!in_array($val, ['pie', 'bar'])) {
            $val = 'pie';
        }
        $this->_xmlChart = str_replace(
            '__GENERATETYPECHART__', '<' .
            CreateGraphic::NAMESPACEWORD . ':ofPieType val="' . $val . '">' .
            '</' . CreateGraphic::NAMESPACEWORD . ':ofPieType>' .
            '__GENERATETYPECHART__', $this->_xmlChart
        );
    }

    /**
     * Generate w:scatterChart
     *
     * @access protected
     */
    protected function generateSCATTERCHART()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':scatterChart>__GENERATETYPECHART__</' .
            CreateGraphic::NAMESPACEWORD .
            ':scatterChart>__GENERATEPLOTAREA__';
        $this->_xmlChart = str_replace(
            '__GENERATEPLOTAREA__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate w:doughnutChart
     *
     * @access protected
     */
    protected function generateDOUGHNUTCHART()
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD .
            ':doughnutChart>__GENERATETYPECHART__</' .
            CreateGraphic::NAMESPACEWORD .
            ':doughnutChart>__GENERATEPLOTAREA__';
        $this->_xmlChart = str_replace(
            '__GENERATEPLOTAREA__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:GAPWIDTH
     *
     * @access protected
     * @param string $val
     */
    protected function generateGAPWIDTH($val = 100)
    {
        if (!is_numeric($val)) {
            $val = 100;
        }
        $this->_xmlChart = str_replace(
            '__GENERATETYPECHART__', '<' .
            CreateGraphic::NAMESPACEWORD . ':gapWidth val="' . $val . '">' .
            '</' . CreateGraphic::NAMESPACEWORD . ':gapWidth>' .
            '__GENERATETYPECHART__', $this->_xmlChart
        );
    }

    /**
     * Generate c:secondPieSize
     *
     * @access protected
     * @param string $val
     */
    protected function generateSECONDPIESIZE($val = 75)
    {
        if (!is_numeric($val)) {
            $val = 75;
        }
        $this->_xmlChart = str_replace(
            '__GENERATETYPECHART__', '<' .
            CreateGraphic::NAMESPACEWORD . ':secondPieSize val="' . $val . '">' .
            '</' . CreateGraphic::NAMESPACEWORD . ':secondPieSize>' .
            '__GENERATETYPECHART__', $this->_xmlChart
        );
    }

    /**
     * Generate c:serLines
     *
     * @access protected
     */
    protected function generateSERLINES()
    {
        $this->_xmlChart = str_replace(
            '__GENERATETYPECHART__', '<' .
            CreateGraphic::NAMESPACEWORD . ':serLines>' .
            '</' . CreateGraphic::NAMESPACEWORD . ':serLines>' .
            '__GENERATETYPECHART__', $this->_xmlChart
        );
    }

    /**
     * Generate c:splitType
     *
     * @access protected
     * @param string $val
     */
    protected function generateSPLITTYPE($val)
    {
        if (!in_array($val, ['auto', 'cust', 'percent', 'pos', 'val'])) {
            $xml = '<' . CreateGraphic::NAMESPACEWORD . ':splitType>' .
                '</' . CreateGraphic::NAMESPACEWORD . ':splitType>' .
                '__GENERATETYPECHART__';
        } else {
            $xml = '<' . CreateGraphic::NAMESPACEWORD . ':splitType val="' . $val . '">' .
                '</' . CreateGraphic::NAMESPACEWORD . ':splitType>' .
                '__GENERATETYPECHART__';
        }
        $this->_xmlChart = str_replace(
            '__GENERATETYPECHART__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:custSplit
     *
     * @access protected
     */
    protected function generateCUSTSPLIT()
    {
        $this->_xmlChart = str_replace(
            '__GENERATETYPECHART__', '<' .
            CreateGraphic::NAMESPACEWORD . ':custSplit>' .
            '__GENERATECUSTSPLIT__' .
            '</' . CreateGraphic::NAMESPACEWORD . ':custSplit>' .
            '__GENERATETYPECHART__', $this->_xmlChart
        );
    }

    /**
     * Generate c:splitType
     *
     * @access protected
     * @param string $val
     */
    protected function generateSECONDPIEPT($val)
    {
        $xml = '';
        if (is_array($val)) {
            foreach ($val as $value) {
                $xml .= '<' . CreateGraphic::NAMESPACEWORD . ':secondPiePt val="' . $value . '">' .
                    '</' . CreateGraphic::NAMESPACEWORD . ':secondPiePt>';
            }
        }
        $this->_xmlChart = str_replace(
            '__GENERATECUSTSPLIT__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:splitPos
     *
     * @access protected
     * @param string $val
     */
    protected function generateSPLITPOS($val, $type = "auto")
    {
        if ($type == 'pos') {
            $val = (int) $val;
        }
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':splitPos val="' . $val . '">' .
            '</' . CreateGraphic::NAMESPACEWORD . ':splitPos>' .
            '__GENERATETYPECHART__';
        $this->_xmlChart = str_replace(
            '__GENERATETYPECHART__', $xml, $this->_xmlChart
        );
    }

    /**
     * Generate c:explosion
     *
     * @access protected
     * @param string $val
     */
    protected function generateEXPLOSION($val = 25)
    {
        $xml = '<' . CreateGraphic::NAMESPACEWORD . ':explosion val="' . $val . '">' .
            '</' . CreateGraphic::NAMESPACEWORD . ':explosion>' .
            '__GENERATESER__';
        $this->_xmlChart = str_replace(
            '__GENERATESER__', $xml, $this->_xmlChart
        );
    }

    /**
     * Create chart xml
     *
     * @access protected
     * @param array $args[0]
     */
    protected function createCHARTXML()
    {
        $this->_xmlChart = '';
        $args = func_get_args();
        $this->setRId($args[0][0]);
        $this->initGraphic($args[0][1]);
        $this->createEmbeddedXmlChart();
        return true;
    }

    /**
     * Clean tags in template document
     *
     * @access protected
     */
    protected function cleanTemplateDocument()
    {
        $this->_xmlChart = preg_replace('/__[A-Z]+__/', '', $this->_xmlChart);
    }

    /**
     * Clean tags in template document
     *
     * @access protected
     */
    public static function cleanTemplateChart($xml = "")
    {
        return preg_replace('/__[A-Z]+__/', '', $xml);
    }

    /**
     * Clean tags in template document
     *
     * @access protected
     */
    protected function cleanTemplate2()
    {
        $this->_xmlChart = preg_replace(
            [
                '/__GENERATE[A-B,D-O,Q-R,U-Z][A-Z]+__/',
                '/__GENERATES[A-D,F-Z][A-Z]+__/', '/__GENERATETX__/'], '', $this->_xmlChart
        );
    }

    /**
     * Clean tags in template document
     *
     * @access protected
     */
    protected function cleanTemplateFonts()
    {
        $this->_xmlChart = preg_replace(
            '/__GENERATETITLE[A-Z]+__/', '', $this->_xmlChart
        );
    }

    /**
     * Clean tags in template document
     *
     * @access protected
     */
    protected function cleanTemplate3()
    {
        $this->_xmlChart = preg_replace(
            [
                '/__GENERATE[A-B,D-O,Q-S,U-Z][A-Z]+__/',
                '/__GENERATES[A-D,F-Z][A-Z]+__/',
                '/__GENERATETX__/'
            ], '', $this->_xmlChart
        );
    }

    /**
     * Generate c:txPr
     *
     * @access protected
     * @param string $font
     */
    protected function generateRFONTS2($font)
    {
        $this->_xmlChart = str_replace(
            '__GENERATEAX__', '<c:txPr><a:bodyPr /><a:lstStyle /><a:p>' .
            '<a:pPr><a:defRPr><a:latin typeface="' .
            $font . '" pitchFamily="34" charset="0" /><a:cs typeface="' .
            $font . '" pitchFamily="34" charset="0" /></a:defRPr>' .
            '</a:pPr><a:endParaRPr lang="es-ES" /></a:p></c:txPr>' .
            '__GENERATEAX__', $this->_xmlChart
        );
    }

    /**
     * Generate table
     *
     * @param int $rows
     * @param int $cols
     * @access protected
     */
    protected function generateTABLE($rows, $cols)
    {
        $word = 'A';
        for ($i = 0; $i < $cols; $i++) {
            $word++;
        }
        $rows++;
        $this->_xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' .
            '<table xmlns="http://schemas.openxmlformats.org/spreads' .
            'heetml/2006/main" id="1" name="Tabla1" displayName=' .
            '"Tabla1" ref="A1:' . $word . $rows .
            '" totalsRowShown="0" tableBorderDxfId="0">' .
            '__GENERATETABLE__</table>';
    }

    /**
     * Generate tablecolumn
     *
     * @param string $id
     * @param string $name
     * @access protected
     */
    protected function generateTABLECOLUMN($id = '2', $name = '')
    {
        $xml = '<tableColumn id="' . $id . '" name="' . $name .
            '"></tableColumn >__GENERATETABLECOLUMNS__';

        $this->_xml = str_replace(
            '__GENERATETABLECOLUMNS__', $xml, $this->_xml
        );
    }

    /**
     * Generate tablecolumns
     *
     * @param string $count
     * @access protected
     */
    protected function generateTABLECOLUMNS($count = '2')
    {
        $xml = '<tableColumns count="' . $count .
            '">__GENERATETABLECOLUMNS__</tableColumns>__GENERATETABLE__';

        $this->_xml = str_replace('__GENERATETABLE__', $xml, $this->_xml);
    }

    /**
     * Generate tablestyleinfo
     *
     * @param string $showFirstColumn
     * @param string $showLastColumn
     * @param string $showRowStripes
     * @param string $showColumnStripes
     * @access protected
     */
    protected function generateTABLESTYLEINFO($showFirstColumn = '0', $showLastColumn = "0", $showRowStripes = "1", $showColumnStripes = "0")
    {
        $xml = '<tableStyleInfo   showFirstColumn="' . $showFirstColumn .
            '" showLastColumn="' . $showLastColumn .
            '" showRowStripes="' . $showRowStripes .
            '" showColumnStripes="' . $showColumnStripes .
            '"></tableStyleInfo >';

        $this->_xml = str_replace('__GENERATETABLE__', $xml, $this->_xml);
    }

}

interface InterfaceGraphic
{

    /**
     * Create embedded xml chart
     *
     * @access public
     */
    public function createEmbeddedXmlChart();

    /**
     * return the tags where the data is written
     *
     * @access public
     */
    public function dataTag();

    /**
     * return the object type of the xlsx
     *
     * @access public
     */
    public function getXlsxType();
}

interface InterfaceXlsx
{

    /**
     * Create a excel sheet
     *
     * @access public
     */
    public function createExcelSheet($dats);

    /**
     * Create a shared string file from the xlsx
     *
     * @access public
     */
    public function createExcelSharedStrings($dats);

    /**
     * return a table file from the xlsx
     *
     * @access public
     */
    public function createExcelTable($dats);
}

class CreateXlsx extends CreateElement
{

    /**
     *
     * @access private
     * @var <type>
     */
    private $_zipXlsx;

    /**
     *
     * @access private
     * @var <type>
     */
    private $_xmlXlTablesContent;

    /**
     *
     * @access private
     * @var <type>
     */
    private $_xmlXlSharedStringsContent;

    /**
     *
     * @access private
     * @var <type>
     */
    private $_xmlXlSheetContent;

    /**
     * Construct
     *
     * @access public
     */
    public function __construct()
    {

    }

    /**
     * Destruct
     *
     * @access public
     */
    public function __destruct()
    {

    }

    /**
     *
     * @access public
     * @return string
     */
    public function __toString()
    {
        return $this->_zipXlsx;
    }

    /**
     * Create XLSX
     *
     * @access public
     * @return bool
     */
    public function createXlsx()
    {
        $args = func_get_args();
        $this->_zipXlsx = new DOCXStructure();

        $this->_xmlXlTablesContent = '';
        $this->_xmlXlSharedStringsContent = '';
        $this->_xmlXlSheetContent = '';

        $dirname = dirname(__FILE__) . '/../excel/';

        $this->_zipXlsx->addFile('[Content_Types].xml', $dirname . '[Content_Types].xml');
        $this->_zipXlsx->addFile('docProps/core.xml', $dirname . 'docProps/core.xml');
        $this->_zipXlsx->addFile('docProps/app.xml', $dirname . 'docProps/app.xml');
        $this->_zipXlsx->addFile('_rels/.rels', $dirname . '_rels/.rels');
        $this->_zipXlsx->addFile('xl/_rels/workbook.xml.rels', $dirname . 'xl/_rels/workbook.xml.rels');
        $this->_zipXlsx->addFile('xl/theme/theme1.xml', $dirname . 'xl/theme/theme1.xml');
        $this->_zipXlsx->addFile('xl/worksheets/_rels/sheet1.xml.rels', $dirname . 'xl/worksheets/_rels/sheet1.xml.rels');
        $this->_zipXlsx->addFile('xl/styles.xml', $dirname . 'xl/styles.xml');
        $this->_zipXlsx->addFile('xl/workbook.xml', $dirname . 'xl/workbook.xml');
        $this->_zipXlsx->addContent('xl/tables/table1.xml', $this->createExcelTable($args[1]));
        $this->_zipXlsx->addContent('xl/sharedStrings.xml', $this->createExcelSharedStrings($args[1]));
        $this->_zipXlsx->addContent('xl/worksheets/sheet1.xml', $this->createExcelSheet($args[1]));

        return $this->_zipXlsx;
    }

    /**
     * Generate sst
     *
     * @param string $num
     * @access protected
     */
    protected function generateSST($num)
    {
        $this->_xml = '<?xml version="1.0" encoding="UTF-8" ' .
            'standalone="yes" ?><sst xmlns="http://schemas.' .
            'openxmlformats.org/spreadsheetml/2006/main" ' .
            'count="' . $num . '" uniqueCount="' . $num .
            '">__GENERATESST__</sst>';
    }

    /**
     * Generate si
     * @access protected
     */
    protected function generateSI()
    {
        $xml = '<si>__GENERATESI__</si>__GENERATESST__';
        $this->_xml = str_replace('__GENERATESST__', $xml, $this->_xml);
    }

    /**
     * Generate t
     *
     * @param string $name
     * @param string $space
     * @access protected
     */
    protected function generateT($name, $space = '')
    {
        $xmlAux = '<t';
        if ($space != '') {
            $xmlAux .= ' xml:space="' . $space . '"';
        }
        $xmlAux .= '>' . htmlspecialchars($name) . '</t>';
        $this->_xml = str_replace('__GENERATESI__', $xmlAux, $this->_xml);
    }

    /**
     * Generate c
     *
     * @param string $r
     * @param string $s
     * @param string $t
     * @access protected
     */
    protected function generateC($r, $s, $t = '')
    {
        $xmlAux = '<c r="' . $r . '"';
        if ($s != '') {
            $xmlAux .= ' s="' . $s . '"';
        }
        if ($t != '') {
            $xmlAux .= ' t="' . $t . '"';
        }
        $xmlAux .= '>__GENERATEC__</c>__GENERATEROW__';
        $this->_xml = str_replace('__GENERATEROW__', $xmlAux, $this->_xml);
    }

    /**
     * Generate col
     *
     * @param string $min
     * @param string $max
     * @param string $width
     * @param string $customWidth
     * @access protected
     */
    protected function generateCOL($min = '1', $max = '1', $width = '11.85546875', $customWidth = '1')
    {
        $xml = '<col min="' . $min . '" max="' . $max . '" width="' . $width .
            '" customWidth="' . $customWidth . '"></col>';

        $this->_xml = str_replace('__GENERATECOLS__', $xml, $this->_xml);
    }

    /**
     * Generate cols
     *
     * @access protected
     */
    protected function generateCOLS()
    {
        $xml = '<cols>__GENERATECOLS__</cols>__GENERATEWORKSHEET__';
        $this->_xml = str_replace('__GENERATEWORKSHEET__', $xml, $this->_xml);
    }

    /**
     * Generate dimension
     *
     * @param int $sizeX
     * @param int $sizeY
     * @access protected
     */
    protected function generateDIMENSION($sizeX, $sizeY)
    {
        $char = 'A';
        for ($i = 0; $i < $sizeY; $i++) {
            $char++;
        }
        $sizeX += $sizeY;
        $xml = '<dimension ref="A1:' . $char . $sizeX .
            '"></dimension>__GENERATEWORKSHEET__';

        $this->_xml = str_replace('__GENERATEWORKSHEET__', $xml, $this->_xml);
    }

    /**
     * Generate pagemargins
     *
     * @param string $left
     * @param string $rigth
     * @param string $bottom
     * @param string $top
     * @param string $header
     * @param string $footer
     * @access protected
     */
    protected function generatePAGEMARGINS($left = '0.7', $rigth = '0.7', $bottom = '0.75', $top = '0.75', $header = '0.3', $footer = '0.3')
    {
        $xml = '<pageMargins left="' . $left . '" right="' . $rigth .
            '" top="' . $top . '" bottom="' . $bottom .
            '" header="' . $header . '" footer="' . $footer .
            '"></pageMargins>__GENERATEWORKSHEET__';

        $this->_xml = str_replace('__GENERATEWORKSHEET__', $xml, $this->_xml);
    }

    /**
     * Generate pagesetup
     *
     * @param string $paperSize
     * @param string $orientation
     * @param string $id
     * @access protected
     */
    protected function generatePAGESETUP($paperSize = '9', $orientation = 'portrait', $id = '1')
    {
        $xml = '<pageSetup paperSize="' . $paperSize .
            '" orientation="' . $orientation . '" r:id="rId' . $id .
            '"></pageSetup>__GENERATEWORKSHEET__';

        $this->_xml = str_replace('__GENERATEWORKSHEET__', $xml, $this->_xml);
    }

    /**
     * Generate row
     *
     * @param string $r
     * @param string $spans
     * @access protected
     */
    protected function generateROW($r, $spans)
    {
        $spans = '1:' . ($spans + 1);
        $xml = '<row r="' . $r . '" spans="' . $spans .
            '">__GENERATEROW__</row>__GENERATESHEETDATA__';

        $this->_xml = str_replace('__GENERATESHEETDATA__', $xml, $this->_xml);
    }

    /**
     * Generate selection
     *
     * @param string $num
     * @access protected
     */
    protected function generateSELECTION($num)
    {
        $xml = '<selection activeCell="B' . $num .
            '" sqref="B' . $num . '"></selection>';

        $this->_xml = str_replace('__GENERATESHEETVIEW__', $xml, $this->_xml);
    }

    /**
     * Generate sheetdata
     *
     * @access protected
     */
    protected function generateSHEETDATA()
    {
        $xml = '<sheetData>__GENERATESHEETDATA__</sheetData>' .
            '__GENERATEWORKSHEET__';
        $this->_xml = str_replace('__GENERATEWORKSHEET__', $xml, $this->_xml);
    }

    /**
     * Generate sheetformatpr
     *
     * @param string $baseColWidth
     * @param string $defaultRowHeight
     * @access protected
     */
    protected function generateSHEETFORMATPR($baseColWidth = '10', $defaultRowHeight = '15')
    {
        $xml = '<sheetFormatPr baseColWidth="' . $baseColWidth .
            '" defaultRowHeight="' . $defaultRowHeight .
            '"></sheetFormatPr>__GENERATEWORKSHEET__';

        $this->_xml = str_replace('__GENERATEWORKSHEET__', $xml, $this->_xml);
    }

    /**
     * Generate sheetview
     *
     * @param string $tabSelected
     * @param string $workbookViewId
     * @access protected
     */
    protected function generateSHEETVIEW($tabSelected = '1', $workbookViewId = '0')
    {
        $xml = '<sheetView tabSelected="' . $tabSelected .
            '" workbookViewId="' . $workbookViewId .
            '">__GENERATESHEETVIEW__</sheetView>';

        $this->_xml = str_replace('__GENERATESHEETVIEWS__', $xml, $this->_xml);
    }

    /**
     * Generate sheetviews
     *
     * @access protected
     */
    protected function generateSHEETVIEWS()
    {
        $xml = '<sheetViews>__GENERATESHEETVIEWS__' .
            '</sheetViews>__GENERATEWORKSHEET__';
        $this->_xml = str_replace('__GENERATEWORKSHEET__', $xml, $this->_xml);
    }

    /**
     * Generate tablepart
     *
     * @param string $id
     * @access protected
     */
    protected function generateTABLEPART($id = '1')
    {
        $xml = '<tablePart r:id="rId' . $id . '"></tablePart>';
        $this->_xml = str_replace('__GENERATETABLEPARTS__', $xml, $this->_xml);
    }

    /**
     * Generate tableparts
     *
     * @param string $count
     * @access protected
     */
    protected function generateTABLEPARTS($count = '1')
    {
        $xml = '<tableParts count="' . $count .
            '">__GENERATETABLEPARTS__</tableParts>';

        $this->_xml = str_replace('__GENERATEWORKSHEET__', $xml, $this->_xml);
    }

    /**
     * Generate v
     *
     * @param string $num
     * @access protected
     */
    protected function generateV($num)
    {
        $this->_xml = str_replace(
            '__GENERATEC__', '<v>' . $num . '</v>', $this->_xml
        );
    }

    /**
     * Generate worksheet
     *
     * @access protected
     */
    protected function generateWORKSHEET()
    {
        $this->_xml = '<?xml version="1.0" encoding="UTF-8" ' .
            'standalone="yes" ?><worksheet ' .
            'xmlns="http://schemas.openxmlformats.org/' .
            'spreadsheetml/2006/main" ' . 'xmlns:r="http://schemas.' .
            'openxmlformats.org/officeDocument/2006/relationships"' .
            '>__GENERATEWORKSHEET__</worksheet>';
    }

    /**
     * Clean template row tags
     *
     * @access private
     */
    protected function cleanTemplateROW()
    {
        $this->_xml = str_replace('__GENERATEROW__', '', $this->_xml);
    }

    /**
     * Generate table
     *
     * @param int $rows
     * @param int $cols
     * @access protected
     */
    protected function generateTABLE($rows, $cols)
    {
        $word = 'A';
        for ($i = 0; $i < $cols; $i++) {
            $word++;
        }
        $rows++;
        $this->_xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' .
            '<table xmlns="http://schemas.openxmlformats.org/spreads' .
            'heetml/2006/main" id="1" name="Tabla1" displayName=' .
            '"Tabla1" ref="A1:' . $word . $rows .
            '" totalsRowShown="0" tableBorderDxfId="0">' .
            '__GENERATETABLE__</table>';
    }

    /**
     * Generate tablecolumn
     *
     * @param string $id
     * @param string $name
     * @access protected
     */
    protected function generateTABLECOLUMN($id = '2', $name = '')
    {
        $xml = '<tableColumn id="' . $id . '" name="' . $name .
            '"></tableColumn >__GENERATETABLECOLUMNS__';

        $this->_xml = str_replace(
            '__GENERATETABLECOLUMNS__', $xml, $this->_xml
        );
    }

    /**
     * Generate tablecolumns
     *
     * @param string $count
     * @access protected
     */
    protected function generateTABLECOLUMNS($count = '2')
    {
        $xml = '<tableColumns count="' . $count .
            '">__GENERATETABLECOLUMNS__</tableColumns>__GENERATETABLE__';

        $this->_xml = str_replace('__GENERATETABLE__', $xml, $this->_xml);
    }

    /**
     * Generate tablestyleinfo
     *
     * @param string $showFirstColumn
     * @param string $showLastColumn
     * @param string $showRowStripes
     * @param string $showColumnStripes
     * @access protected
     */
    protected function generateTABLESTYLEINFO($showFirstColumn = '0', $showLastColumn = "0", $showRowStripes = "1", $showColumnStripes = "0")
    {
        $xml = '<tableStyleInfo   showFirstColumn="' . $showFirstColumn .
            '" showLastColumn="' . $showLastColumn .
            '" showRowStripes="' . $showRowStripes .
            '" showColumnStripes="' . $showColumnStripes .
            '"></tableStyleInfo >';

        $this->_xml = str_replace('__GENERATETABLE__', $xml, $this->_xml);
    }

}
class DOCXStructure
{
    /**
     * DOCX structure
     * @access private
     * @var array
     */
    private $docxStructure;

    /**
     * Parse a DOCX file
     *
     * @access public
     * @param string $path File path
     */
    public function __construct() { }

    /**
     * Getter docxStructure
     * @param string $format array or stream
     * @return mixed DOCX structure
     */
    public function getDocx($format) {
        return $docxStructure;
    }

    /**
     * Add new content to the DOCX
     * @param string $internalFilePath Path in the DOCX
     * @param string $content Content to be added
     */
    public function addContent($internalFilePath, $content)
    {
        $this->docxStructure[$internalFilePath] = $content;
    }

    /**
     * Add a new file to the DOCX
     * @param string $internalFilePath Path in the DOCX
     * @param string $file File path to be added
     */
    public function addFile($internalFilePath, $file)
    {
        $this->docxStructure[$internalFilePath] = file_get_contents($file);
    }

    /**
     * Delete content in the DOCX
     * @param string $internalFilePath Path in the DOCX
     */
    public function deleteContent($internalFilePath)
    {
        if (isset($this->docxStructure[$internalFilePath])) {
            unset($this->docxStructure[$internalFilePath]);
        }
    }

    /**
     * Get existing content from the DOCX
     * @param string $internalFilePath Path in the DOCX
     * @param string $content Content to be added
     * @return mixed File content or false
     */
    public function getContent($internalFilePath)
    {
        if (isset($this->docxStructure[$internalFilePath])) {
            return $this->docxStructure[$internalFilePath];
        }

        return false;
    }

    /**
     * Parse an existing DOCX
     * @param string $path File path
     */
    public function parseDocx($path)
    {
        $zip = new ZipArchive();

        if ($zip->open($path) === TRUE) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $fileName = $zip->getNameIndex($i);
                $this->docxStructure[$zip->getNameIndex($i)] = $zip->getFromName($fileName);
            }
        } else {
            throw new Exception('Error while trying to open the (base) template as a zip file');
        }
    }

    /**
     * Save docxStructure as ZIP
     * @param string $path File path
     * @param bool $forceFile Force DOCX as file, needed for charts when working with streams
     */
    public function saveDocx($path, $forceFile = false) {
        // check if the path has as extension
        if(substr($path, -5) !== '.docx') {
            $path .= '.docx';
        }

        // check if stream mode is true
        if (file_exists(dirname(__FILE__) . '/ZipStream.inc') && CreateDocx::$streamMode === true && $forceFile === false) {
            $docxFile = new ZipStream();

            foreach ($this->docxStructure as $key => $value) {
                $docxFile->addFile($key, $value);
            }
            $docxFile->generateStream($path);
        } else {
            $docxFile = new ZipArchive();

            // if dest file exits remove it to avoid duplicate content
            if (file_exists($path) && is_writable($path)) {
                unlink($path);
            }

            if ($docxFile->open($path, ZipArchive::CREATE) === TRUE) {
                foreach ($this->docxStructure as $key => $value) {
                    $docxFile->addFromString($key, $value);
                }

                $docxFile->close();

                if (!is_writable($path) || !is_readable($path)) {
                    die('Error while trying to write to ' . $path . ' please check write access.');
                }
            } else {
                throw new Exception('Error while trying to write to ' . $path);
            }
        }
    }

}
