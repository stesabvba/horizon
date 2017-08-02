<?php
//V1.21: validate_bedate nauwkeuriger gemaakt
//V1.2: functie addErrorClass
//V1.1: volledig anders (meertaligheid mogelijk.
//V1.0

class Validate {
	public $defaultMsgs = array(
		'validate_email' => ' ongeldig',
		'validate_date' => ' ongeldig',
		'validate_bedate' => ' ongeldig',
		'validate_notempty' => ' ongeldig (mag niet leeg zijn)',
	);
		
    public function validate_email($data, $waarde) {
        if (!preg_match("/^[A-Z0-9._%-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i", $waarde)) {
            return false; //'Ongeldig email adres ingegeven.';
        } else {
            return true;
        }
    }
    
    public function validate_date($data, $waarde) {
        //validate datum van formaat YY-mm-dd
        $ts = strtotime($waarde);
        if ($ts === FALSE) {
            return false; //' datum ongeldig';
        } else {
            return checkdate(date('n', $ts), date('d', $ts), date('Y', $ts));
        }
    }
    
    public function validate_bedate($data, $waarde) {
        //validate datum van formaat dd-mm-YY (01-12-2011) zonder tijdstip!
        if (strlen(trim($waarde)) != 10) {
            return false; //' datum ongeldig';
        } else {
            $arr_date = explode('/', $waarde);
            $aantal = count($arr_date);
            if ($aantal != 3) {
                return FALSE; //' datum ongeldig';	
            } else {
				return checkdate($arr_date[1], $arr_date[0], $arr_date[2]);
			}
        }
        
        return TRUE;
    }    
    
    public function validate_notempty($data, $waarde) {
            
            if (strlen(trim($waarde)) == 0) {
            //if (empty($data)) {
                    return false; //' mag niet leeg zijn';
            } else {
                    return true;
            }
    }
    
    public function __construct() {
    }
    
	/*
	* validatieMsgs bevat array met key => val
	* waarbij key ofwel: label naam is (om 1 aparte msg in te stellen voor 1 veld)
	* ofwel waarbij  key: validatie functie naam (bvb validate_notempty).
	* in dit geval (validatie functie naam), zullen alle items met deze validatieregel deze msg krijgen
	*/
    public function validate(array $data, array $validatieregels, array $validatieMsgs) {
        $errors = array();    
		if (!empty($validatieregels)) {
			foreach($validatieregels as $veldnaam => $regel) {
				$waarde = isset($data[$veldnaam])?$data[$veldnaam]:NULL;
				//if (!empty($item)) {
                    if (is_array($regel)) {
                        $obj = $regel[0];
                        $func = $regel[1];
                    } else {
                        $obj = $this;
                        $func = $regel;                    
                    }

                    if (method_exists($obj, $func)) {
                        $return = $obj->$func($data, $waarde);    
                    } else {
                        die('validatie functie '.$func.' niet gevonden!');
                    }

					/*if (function_exists($regel)) {
                        $return = $regel($waarde);
                    } elseif (method_exists ($this, $regel)) {
                        $return = $this->$regel($waarde);    
                    } else {
                        die('validatie functie '.$regel.' niet gevonden!');
                    }*/
					
					if (!$return) {
                        if (isset($validatieMsgs[$veldnaam])) {
							$errorMsg = $validatieMsgs[$veldnaam];
						} elseif (isset($validatieMsgs[$func])) {
							$errorMsg = $validatieMsgs[$func];						
						} elseif (isset($this->defaultMsgs[$func])) {
							$errorMsg = $this->defaultMsgs[$func];
						} else {
							$errorMsg = 'ongeldig';
						}
						$errors[$veldnaam] = $errorMsg;
					}
					/*
					if (!is_bool($return)) {										
                        $errors[$veldnaam] = $return;
                    }
					*/
				//}
			}			
		}
		return $errors;
    }
	
	/*
	* wordt gebruikt op textvelden, voor css style
	*/
	function addErrorClass($veld, $errors) {
		if (!empty($errors[$veld])) {
			return ' has-error';
		}
	}

    function getError($veld, $errors) {
        if (!empty($errors[$veld])) {
            return '<span class="help-block">'.$errors[$veld].'</span>';
        } else {
            return '';
        }
    }
}