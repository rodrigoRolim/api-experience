<?php

namespace Experience\Report\Laudo;

class Cabecalho{
	protected $html;

	public function make($xml){
		$this->html = '';

		foreach ($xml->bands->band as $key => $band){
			$type = $band['bandType'];

			if($type == 'cabecalhoLaudo'){
				foreach ($band->components->component as $key => $component){
					$this->html .= $this->makeComponents($component);
				}
			}
		}
	}

	private function makeComponents($component){
		$render = '';

		$style = 'margin:0px;position:relative;top:'.$component->position['positionX'].';left:'.$component->position['positionY'].';';
		$style.= 'width:'.$component->size['width'].';height:'.$component->size['height'].';';
		$style.= 'background-color:'.$component->componentColor.';';

		//ComponentCaption
		$style.= 'padding-top:'.$component->componentCaption->padding['paddingTop'].';padding-bottom:'.$component->componentCaption->padding['paddingTop'].';';
		$style.= 'padding-left:'.$component->componentCaption->padding['paddingLeft'].';';
		$style.= 'border: solid '.$component->componentCaption['border'].'px #000;';

		$style.= 'text-align:'.$component->componentCaption->align['alignHor'].';vertical-align:'.$component->componentCaption->align['alignVer'].';';

		$style.= 'font-family:'.$component->componentCaption->font['fontName'].';font-size:'.$component->componentCaption->font['fontSize'].';color:'.$component->componentCaption->font['fontColor'].';';

		$fontStyle = explode(" ",$component->componentCaption->font['fontStyle']);

		foreach ($fontStyle as $key => $fs){
			if($fs == 'bold'){
				$style.= 'font-weight:'.$fs.';';
			}else{
				$style.= 'font-style:'.$fs.';';
			}
		}

		switch ($component->componentType){
			case 'label':
					$render = '<p style="'.$style.'" id="'.$component->componentId.'">'.$component->componentCaption['captionText'].'</p>';
				break;
			case 'dataField':
					$render = '<p style="'.$style.'" id="'.$component->componentId.'">'.$component->componentCaption['captionText'].'</p>';
				break;
		}

		return $render;
	}

	public function render(){
		return $this->html;
	}
}