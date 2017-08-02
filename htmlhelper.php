<?php
class HtmlHelper {
	private $_css = array();
	private $_scripts = array();
	public $_js_vars = array();
	public $meta_title = null;
	public $meta_description = null;
	public $meta_keywords = null;
	public $_meta_lines = array();

	public function addMeta($meta_line) {
		if (is_array($meta_line)) {
			foreach($meta_line as $line) {
				array_push($this->_meta_lines, $line);
			}
		} else {
			array_push($this->_meta_lines, $meta_line);		
		}
	}

	public function writeMetas() {
		self::write($this->_meta_lines);
	}


	public function addCss($cssFile) {	
		if (is_array($cssFile)) {
			foreach($cssFile as $file) {
				array_push($this->_css, $file);
			}
		} else {
			array_push($this->_css, $cssFile);		
		}
	}

	public function addScript($scriptFile) {
		if (is_array($scriptFile)) {
			foreach($scriptFile as $file) {
				array_push($this->_scripts, $file);
			}
		} else {
			array_push($this->_scripts, $scriptFile);		
		}
	}

	public function writeScripts() {
		self::write($this->_scripts);
	}

	public function writeCss() {
		self::write($this->_css);
	}

	private function write($arr) {
		$str = '';
		if (!empty($arr)) {
			foreach($arr as $item) {
				$str .= $item."\r\n";
			} 
		}
		echo $str;
	}

	public function addJsVar($vars) {
		//var item = ['name': 'value']
		if (is_array($vars)) {
			foreach($vars as $name => $val) {
				$this->_js_vars[$name] = $val;
			}
		} else {
			$this->_js_vars[$name] = $val;
		}
	}

	public function writeJsVars($arrayname = null) {
		if (!empty($this->_js_vars)) {
			foreach($this->_js_vars as $name => $val) {
				if($arrayname!=null)
				{
					echo $arrayname . '.globals.'.$name.' = "'.$val.'";';
				}else{
					echo 'config.globals.'.$name.' = "'.$val.'";';
				}
				
				echo "\r\n";
			}
		}
	}

	public function setMetaTitle($title) {
		$this->meta_title = $title;
	}

	public function getMetaTitle() {
		return $this->meta_title;
	}

	public function setMetaDescription($desc) {
		$this->meta_description = $desc;
	}

	public function getMetaDescription() {
		return $this->meta_description;
	}

	public function setMetaKeywords($keyw) {
		$this->meta_keywords = $keyw;
	}

	public function getMetaKeywords() {
		return $this->meta_keywords;
	}

	public function pager($url, $nrRecords, $recordsPp, $currentPage, $pagination_var = 'page', $template = 'admin/pager.php') {
		$nr_pages = ceil($nrRecords/$recordsPp);

		if ($nr_pages == 0) {
			return false;
		}
/*		echo 'nrRecords='.$nrRecords;
		echo '<br />';
		echo 'nr_pages='.$nr_pages;
		echo '<br />';
		echo 'recordsPp='.$recordsPp;
		echo '<br />';
		echo 'currentPage='.$currentPage;
		echo '<br />';*/

		$b_show_next = $b_show_prev = false;
		$url_previous = $url_next = false;

		if (substr($url, -1) != '?') {
			$url .= '?';
		}

		if (($currentPage) < $nr_pages) {
			$url_next = $url.'&'.$pagination_var.'='.($currentPage+1);
		}

		if ($currentPage > 1) {
			$url_previous = $url.'&'.$pagination_var.'='.($currentPage-1);
		}

		$template_vars = [
			'url' => $url,
			'url_previous' => $url_previous,
			'url_next' => $url_next,
			'url_first' => $url.'&'.$pagination_var.'=1',
			'url_last' => $url.'&'.$pagination_var.'='.$nr_pages,
			'nr_records' => $nrRecords,
			'nr_pages' => $nr_pages,
			'records_pp' => $recordsPp,
			'current_page' => $currentPage,
			'pagination_var' => $pagination_var,
		];

		ob_start();
		$tpl = $_SERVER['DOCUMENT_ROOT'].'horizon/views/'.$template;
		require_once($_SERVER['DOCUMENT_ROOT'].'horizon/views/'.$template);
		$content = ob_get_contents();
		ob_get_clean();	

		return $content;
	}

	public function md5Reset($basisUrl, $md5Key, $unsetkey) {
		/*
		* bepaalt  of de sessie data (die nodig is voor de validatie) verwijderd moet worden of niet
		* functie moet uitgevoerd worden zodat je via het rechstreeks wijzigen van de &id in de url, geen velden van een record overschrijft met session data die overeenkomt met andere rij
		* vb= je doet &page=menus_edit&id=1
		* daar wijzig je data, maar vult niet alles in.
		* er gebeurt nu validatie, form is ongeldig maar de nieuwe gegevens worden in sessie opgeslagen zodat reeds gemaakte wijzigein in de tekstvelden niet verloren gaan.
		* wanneer je nu in de url &id=1 door &id=2 veranderd, wordt de sessie data van id1 gebruikt voor id 2 wat niet mag.
		* deze functie (md5Reset) zorgt dat een md5hash bijgehouden wordt in een sessie van de basisurl( bvb index.php?page=menu_edit&id=1), en indien deze wijzigt
		* (wat gebeurt als je het id wijzigt), zal deze md5 veranderd zijn wat betekent dat de sessie moet gereset worden
		* basisUrl = url waarop de md5 hash moet
		* md5Var = de sessionkey  waarin de md5 vd url moet opgeslagen worden (wanneer je de hash wilt opslaan in $_SESSION['menus_edit']['md5Url'] geef je 'menus_edit' als sessionkey)
		* te unsetten sessionkey = (is dus bvb 'menus' om $_SESSION['menus'] te unsetten)
		**/

		if (isset($_SESSION[$md5Key]['md5Url'])) {
			if ($_SESSION[$md5Key]['md5Url'] != md5($basisUrl)) {
				if (isset($_SESSION[$unsetkey])) unset($_SESSION[$unsetkey]);
			} else {
			}	
		}
		$_SESSION[$md5Key]['md5Url'] = md5($basisUrl);
	}
}
?>