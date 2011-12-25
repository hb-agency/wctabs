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
 * @copyright  2010 Winans Creative 
 * @author     Blair Winans <blair@winanscreative.com>
 * @package    WC Slider
 * @license    LGPL 
 * @filesource
 */


/**
 * Table tl_content 
 */
 
$GLOBALS['TL_DCA']['tl_content']['fields']['text']['eval']['mandatory'] = false;
$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'wctabsType';
$GLOBALS['TL_DCA']['tl_content']['palettes']['wctabs'] = 'type,wctabsType';
$GLOBALS['TL_DCA']['tl_content']['palettes']['wctabswctabssingle'] = '{type_legend},type,wctabsType;{text_legend},headline,text;{image_legend},addImage;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_content']['palettes']['wctabswctabsstart'] = '{type_legend},type,wctabsType,wctabsID;{config_legend},wctabsTimer,wctabsData;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_content']['palettes']['wctabswctabsstop'] = '{type_legend},type,wctabsType;{protected_legend:hide},protected;{expert_legend:hide},guests,';


// Fields		
$GLOBALS['TL_DCA']['tl_content']['fields']['wctabsType'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['wctabsType'],
	'default'                 => 'wctabssingle',
	'exclude'                 => true,
	'inputType'               => 'radio',
	'options'                 => array('wctabssingle', 'wctabsstart', 'wctabsstop'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_content'],
	'eval'                    => array('submitOnChange'=>true)
);
		
$GLOBALS['TL_DCA']['tl_content']['fields']['wctabsID'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['wctabsID'],
	'default'                 => 'tabs',
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50')
);
		

$GLOBALS['TL_DCA']['tl_content']['fields']['wctabsTimer'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['wctabsTimer'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'default'				  => '400',
	'eval'                    => array('maxlength'=>255, 'rgxp'=>'digit', 'nospace'=>true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_content']['fields']['wctabsData'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['wctabsData'],
	'exclude'                 => true,
	'inputType'               => 'listWizard',
	'eval'                    => array('allowHtml'=>true, 'tl_class'=>'clr')
);
		
		
?>