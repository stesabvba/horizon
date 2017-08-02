<?php
//V1.03, volledige aanpassing, zodat je meerdere messages op 1 pg kan tonen
//V1.02 msg_cls aangepast
//V1.01 status 2 info cls toegevoegd
//V1.0

class MsgHelper {
	/*
	status 0 = danger
	status 1 = success
	status 2 = info
	status 3 = warning
	*/
	public function __construct() {
	}
	
	public function set($key, $status, $msg) {
		if (in_array($status, array(0,1,2,3))) {
			if (!isset($_SESSION['messages'][$key][$status])) {
				$_SESSION['messages'][$key][$status] = array();
			}
			array_push($_SESSION['messages'][$key][$status], $msg);
		}
	}
	
	public function delete($key, $status) {		
		if ($status == -1) {
			$tmpStatussen = array(0,1,2,3);
		} else {
			$tmpStatussen = array($status);
		}
		foreach($tmpStatussen as $status) {
			if (isset($_SESSION['messages'][$key][$status])) {
				unset($_SESSION['messages'][$key][$status]);
			}
		}
	}
	
	public function show($key, $status) {
		if ($status == -1) {
			$tmpStatussen = array(0,1,2,3);
		} else {
			$tmpStatussen = array($status);
		}
				
		foreach($tmpStatussen as $status) {
			$cls = $this->getCls($status);
			
			if (isset($_SESSION['messages'][$key][$status])) {
				if (!empty($_SESSION['messages'][$key][$status])) {
					echo '<div class="alert '.$cls.'">';
						echo '<ul>';
						foreach($_SESSION['messages'][$key][$status] as $item) {
								echo '<li>'.$item.'</li>';
						}
						echo '</ul>';	
					echo '</div>';
				}
			}
		}
	}

	private function getCls($status) {
		$cls = '';
		if ($status == 0) {
			$cls = 'alert-danger';
		} elseif ($status == 1) {
			$cls = 'alert-success';
		} elseif ($status == 2) {
			$cls = 'alert-info';
		} elseif ($status == 3) {
			$cls = 'alert-warning';
		}

		return $cls;
	}

	public function get($key, $status)
	{
		/*
		 * smarty function
		 */
		if ($status == -1) {
			$tmpStatussen = array(0,1,2,3);
		} else {
			$tmpStatussen = array($status);
		}

		$ret = '';
		foreach($tmpStatussen as $status) {
			$cls = $this->getCls($status);

			if (isset($_SESSION['messages'][$key][$status])) {
				if (!empty($_SESSION['messages'][$key][$status])) {
					$ret .= '<div class="alert '.$cls.'">';
					$ret .= '<ul>';
					foreach($_SESSION['messages'][$key][$status] as $item) {
						$ret .= '<li>'.$item.'</li>';
					}
					$ret .= '</ul>';
					$ret .= '</div>';
				}
			}
		}
		return $ret;
	}
}
