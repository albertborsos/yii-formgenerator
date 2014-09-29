<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CMSDataProvider
 *
 * @author borsosalbert
 */
class FormDataProvider
{
	public static function items($category, $id = NULL){
        $array = array();
        switch ($category){
			case 'yesno':
				$array = array(
					'1' => 'Igen',
					'0' => 'Nem',
				);
				break;
			case 'order':
				for($i = 1; $i <= 20; $i++){
					$array[$i] = $i.".";
				}
				break;
			case 'method':
				$array = array(
					'POST' => 'POST',
					'GET'  => 'GET',
				);
				break;
			case 'input_type':
				$array = array(
					'textField'    => 'Normál (szöveg)',
					'emailField'   => 'Normál (e-mail)',
					'telField'     => 'Normál (telefonszám)',
					'textArea'     => 'Szövegbeviteli mező',
					'redactor'     => 'Formázható szövegbeviteli mező (HTML)',
					'dropDownList' => 'Legördülő lista',
					'hiddenField'  => 'Rejtett',
					'submitButton' => 'Elküldő gomb',
				);
				break;
			case 'status':
				$array = array(
					'r' => 'Kötelező mező',
					'a' => 'Aktív',
					'i' => 'Inaktív',
				);
				break;
        }
        if (is_null($id)){
			return $array;
		}
        else{
            if (!isset($array[$id])) return $id;
            else return $array[$id];
        }
    }
}
