<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Leo Feyer 2005
 * @author     Leo Feyer <leo@typolight.org>
 * @package    Frontend
 * @license    LGPL
 * @filesource
 */


/**
 * Class ContentWCTabs
 *
 * Front end content element "WC Slider".
 * @copyright  2010 Winans Creative 
 * @author     Blair Winans <blair@winanscreative.com>
 * @package    WC Slider
 * @license    LGPL 
 */
class ContentWCTabs extends ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_wctabs';
	
	/**
	 * Generate content element
	 */
	protected function compile()
	{
		$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/wctabs/html/mootabs.js';
				
		// Accordion start
		switch ($this->wctabsType)
		{
			// Slider start
			case 'wctabsstart':
				if (TL_MODE == 'FE')
				{
					$this->strTemplate = 'ce_wctabs_start';
					$this->Template = new FrontendTemplate($this->strTemplate);
					$this->Template->wctabsID = $this->wctabsID;
					$this->Template->tabsData = deserialize($this->wctabsData);
					//DO NOT ADD SCRIPT IF THE NUMBER OF ELEMENTS IS LESS THAN 2 (static)
					if(!$this->countElements($this->pid, 'wctabsstart')<=1)
					{
$strMootools = "<script type=\"text/javascript\">
<!--//--><![CDATA[//><!--
window.addEvent('domready', tabs_". $this->wctabsID . ");

function tabs_". $this->wctabsID . "()
{
  var tabs, contents;
  tabs = $$('.tabs');
  contents = $$('.contents');
  var tabView = new MooTabs(tabs, contents, {duration: " . $this->wctabsTimer . "});
}
//--><!]]>
</script> ";
	
						$GLOBALS['TL_MOOTOOLS'][] = $strMootools;
					}
					
				}
				else
				{
					$this->strTemplate = 'be_wildcard';
					$this->Template = new BackendTemplate($this->strTemplate);
					$this->Template->wildcard = '### TABS WRAPPER START ###';
					$this->Template->title = $this->headline;
				}
				break;

			// Slider end
			case 'wctabsstop':
				if (TL_MODE == 'FE')
				{
					
					$this->strTemplate = 'ce_wctabs_stop';
					$this->Template = new FrontendTemplate($this->strTemplate);
					$this->Template->disabled = $this->countElements($this->pid, 'wctabsstop')<=1 ? true : false;
				}
				else
				{
					$this->strTemplate = 'be_wildcard';
					$this->Template = new BackendTemplate($this->strTemplate);
					$this->Template->wildcard = '### TABS WRAPPER END ###';
				}
				break;

			// Slider default
			default:			
				$this->import('String');
	
				// Clean RTE output
				$this->Template->text = str_ireplace
				(
					array('<u>', '</u>', '</p>', '<br /><br />', ' target="_self"'),
					array('<span style="text-decoration:underline;">', '</span>', "</p>\n", "<br /><br />\n", ''),
					$this->String->encodeEmail($this->text)
				);
		
				$this->Template->addImage = false;
		
				// Add image
				if ($this->addImage && strlen($this->singleSRC) && is_file(TL_ROOT . '/' . $this->singleSRC))
				{
					$this->addImageToTemplate($this->Template, $this->arrData);
				}

		}
		
		
		$this->Template->groupname = standardize($this->headline . '_' . $this->id);
		$this->Template->headline = $this->headline;
	}
	
	protected function countElements($intPid, $strSliderType)
	{
		switch($strSliderType)
		{
			case 'wctabsstart':
			
				$intStartSorting = $this->sorting;
				$intEndSorting = $this->getTabsElementSorting('wctabsstop',$intPid);
				break;
			case 'wctabsstop':
				$intStartSorting = $this->getTabsElementSorting('wctabsstart',$intPid);
				$intEndSorting = $this->sorting;
				break;
			default:
				return 0;
		}
		
		if($intStartSorting && $intEndSorting)
		{
			$objData = $this->Database->prepare("SELECT COUNT(id) as count FROM tl_content WHERE sorting>? AND sorting<? AND pid=? AND invisible<>?")
									  ->execute($intStartSorting,$intEndSorting,$this->pid,1);
			
						
			if($objData->numRows < 1)
			{
				$intTotalElements = 0;
			}else{
				$intTotalElements = $objData->count;
			}
		}else{
			$intTotalElements = 0;
		}			
			
		return $intTotalElements;
	
	}
	
	
	protected function getTabsElementSorting($strSliderType, $intPid)
	{
		$objData = $this->Database->prepare("SELECT sorting FROM tl_content WHERE wctabsType=? AND pid=?")
								  ->limit(1)
								  ->execute($strSliderType,$intPid);
	
		if($objData->numRows < 1)
		{
			return false;
		}else{
			
			return $objData->sorting;				
		}
	}
}

?>