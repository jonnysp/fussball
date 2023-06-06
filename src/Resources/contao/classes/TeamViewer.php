<?php

class TeamViewer extends ContentElement
{
	protected $strTemplate = 'ce_teamviewer';

	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTeam = \TeamModel::findByPK($this->team);
			$objTemplate = new \BackendTemplate('be_wildcard');
			$objTemplate->title = '['. $objTeam->id.'] - '. $objTeam->title;
			return $objTemplate->parse();	
		}
		return parent::generate();
	}//end generate

	protected function compile()
	{
		global $objPage;
		$this->loadLanguageFile('tl_team');
		$this->loadLanguageFile('tl_position');
		$this->loadLanguageFile('tl_player');

		//get team Data
		$objTeam= \TeamModel::findByPK($this->team);


		$filterPositions = \PositionModel::findAll(
			array('column' => array('pid=?','published=?'),'value' => array($this->team,1) ,'order' => 'sorting')
		);

		if (isset($filterPositions) && count($filterPositions) > 0){

			
			foreach ($filterPositions as $poskey => $posvalue) {


				$filterPlayer = \PlayerModel::findAll(
					array('column' => array('pid=?','published=?'),'value' => array($posvalue->id,1) ,'order' => 'sorting')
				);

				if (isset($filterPlayer) && count($filterPlayer) > 0){
					foreach ($filterPlayer as $playerkey => $playervalue) {


						$PlayerImage = \FilesModel::findByPk($playervalue->image);
						$Player[$playerkey] = array(
							"id" => $playervalue->id,
							"title" => $playervalue->title,
							"number" => $playervalue->number,
							"image" => array(
								"meta" => $this->getMetaData($PlayerImage->meta, $objPage->language),
								"path" => $PlayerImage->path,
								"name" => $PlayerImage->name,
								"extension" => $PlayerImage->extension
							),
							"nickname" => $playervalue->nickname,
							"birthday" => !empty($playervalue->birthday) ? date('d.m.Y',(int)$playervalue->birthday) : '',
							"size" => $playervalue->size,
							"country" => $playervalue->country,
							"contract" => !empty($playervalue->contract) ? date('d.m.Y',(int)$playervalue->contract) : '',
							"position" => $playervalue->position
						);
					}
				}

				$Positions[$poskey] = array(
					"id" => $posvalue->id,
					"title" => $posvalue->title,
					"player" => $Player
				);
				$Player = null;
			}
		}

		$TeamImage = \FilesModel::findByPk($objTeam->image);
		$Team = array(
			"id" => $objTeam->id,
			"title" => $objTeam->title,
			"description" => $objTeam->description,
			"positions" => $Positions,
			"image" => array(
					"meta" => $this->getMetaData($TeamImage->meta, $objPage->language),
					"path" => $TeamImage->path,
					"name" => $TeamImage->name,
					"extension" => $TeamImage->extension
			)
		);
		$Positions = null;

		$this->Template->Team = $Team;

	}//end compile

}
//end class
