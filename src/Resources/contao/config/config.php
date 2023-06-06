<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2019 Jonny Spitzner
 *
 * @license LGPL-3.0+
 */

array_insert($GLOBALS['BE_MOD']['teams'], 100, array
	(
		'teams' => array('tables' => array('tl_team', 'tl_position', 'tl_player'))
	)
);



/**
 * Style sheet
 */
if (TL_MODE == 'BE')
{
	$GLOBALS['TL_CSS'][] = 'bundles/jonnyspfussball/team.css|static';
}


/**
 * Front end modules
 */
array_insert($GLOBALS['TL_CTE'], 1, array
	(
		'includes' 	=> array
			(
				'team_viewer'	=> 'TeamViewer'
			)
	)
);

