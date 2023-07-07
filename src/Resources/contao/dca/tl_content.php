<?php

$GLOBALS['TL_DCA']['tl_content']['palettes']['team_viewer'] = '{type_legend},type;{team_legend},team;{protected_legend:hide},protected;{expert_legend:hide},cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['fields']['team'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['team'],
	'inputType'               => 'select',
	'options_callback'        => array('tl_content_team', 'getTeam'),
	'eval'                    => array('mandatory'=>true, 'chosen'=>true, 'submitOnChange'=>true),
	'wizard' 				  => array(array('tl_content_team', 'editTeam')),
	'sql'                     => "int(10) unsigned NOT NULL default '0'"
);


class tl_content_team extends Backend 
{

	public function getTeam()
	{
		$objTeams = \TeamModel::findAll();
		$arrTeams = array();
		foreach ($objTeams as $objTeam)
		{
			$arrTeams[$objTeam->id] = '[ID ' . $objTeam->id . '] - '. $objTeam->title;
		}
		return $arrTeams;
	}

	public function editTeam(DataContainer $dc)
	{
		$this->loadLanguageFile('tl_team');
		return ($dc->value < 1) ? '' : ' <a href="contao/main.php?do=team&amp;act=edit&amp;id=' . $dc->value . '&amp;popup=1&amp;nb=1&amp;rt=' . REQUEST_TOKEN . '" title="' . sprintf(StringUtil::specialchars($GLOBALS['TL_LANG']['tl_team']['editheader'][1]), $dc->value) . '" onclick="Backend.openModalIframe({\'title\':\'' . StringUtil::specialchars(str_replace("'", "\\'", sprintf($GLOBALS['TL_LANG']['tl_team']['editheader'][1], $dc->value))) . '\',\'url\':this.href});return false">' . Image::getHtml('alias.svg', $GLOBALS['TL_LANG']['tl_team']['editheader'][0]) . '</a>';
	}

}