-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Hoszt: localhost
-- Létrehozás ideje: 2014. Jan 17. 14:44
-- Szerver verzió: 5.5.28
-- PHP Verzió: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Adatbázis: `mobilmanager_borsosalberthuV2`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet: `tbl_form_datas`
--

CREATE TABLE IF NOT EXISTS `tbl_form_datas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `input_id` int(11) DEFAULT NULL COMMENT 'Beviteli mező',
  `key` varchar(100) DEFAULT NULL COMMENT 'Kulcs',
  `value` varchar(100) DEFAULT NULL COMMENT 'Érték',
  `order_num` int(11) DEFAULT NULL,
  `user_create` int(11) DEFAULT NULL COMMENT 'Létrehozta',
  `date_create` datetime DEFAULT NULL COMMENT 'Létrehozás ideje',
  `user_update` int(11) DEFAULT NULL COMMENT 'Módosította',
  `date_update` datetime DEFAULT NULL COMMENT 'Módosítás ideje',
  `status` varchar(1) DEFAULT NULL COMMENT 'Státusz',
  PRIMARY KEY (`id`),
  KEY `input_id` (`input_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Tábla adatok: `tbl_form_datas`
--


-- --------------------------------------------------------

--
-- Tábla szerkezet: `tbl_form_forms`
--

CREATE TABLE IF NOT EXISTS `tbl_form_forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL COMMENT 'Megnevezés',
  `name` varchar(160) DEFAULT NULL COMMENT 'name mező',
  `name_replace` varchar(100) DEFAULT NULL COMMENT 'Csere kód',
  `method` varchar(10) DEFAULT NULL COMMENT 'method',
  `action` varchar(160) DEFAULT NULL,
  `class` varchar(100) DEFAULT NULL COMMENT 'class',
  `style` varchar(100) DEFAULT NULL COMMENT 'style',
  `bizlogic` mediumtext,
  `message_success` varchar(100) DEFAULT NULL,
  `user_create` int(11) DEFAULT NULL COMMENT 'Létrehozta',
  `date_create` datetime DEFAULT NULL COMMENT 'Létrehozás ideje',
  `user_update` int(11) DEFAULT NULL COMMENT 'Módosította',
  `date_update` datetime DEFAULT NULL COMMENT 'Módosítás ideje',
  `status` varchar(1) DEFAULT NULL COMMENT 'Státusz',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Tábla adatok: `tbl_form_forms`
--

INSERT INTO `tbl_form_forms` (`id`, `title`, `name`, `name_replace`, `method`, `action`, `class`, `style`, `bizlogic`, `message_success`, `user_create`, `date_create`, `user_update`, `date_update`, `status`) VALUES
(2, 'Emailküldő űrlap', 'levelkuldes', '[#urlap-levelkuldes]', 'POST', NULL, 'form-horizontal', NULL, '\r\n    /** array (size=2)\r\n     *   ''levelkuldes'' => \r\n     *     array (size=2)\r\n     *       ''Users'' => \r\n     *         array (size=4)\r\n     *           ''name_last'' => string ''Borsos'' (length=6)\r\n     *           ''name_first'' => string ''Albert'' (length=6)\r\n     *           ''email'' => string ''albert@mail.hu'' (length=14)\r\n     *           ''phone'' => string '''' (length=0)\r\n     *       ''message'' => string ''<p>\r\n     *                          	teszt üzenet\r\n     *                            </p>'' (length=25)\r\n     *   ''yt0'' => string ''Elküldés'' (length=10)\r\n     **/\r\n    $name_first = Yii::app()->request->getPost(''levelkuldes'')[''Users''][''name_first''];\r\n    $name_last  = Yii::app()->request->getPost(''levelkuldes'')[''Users''][''name_last''];\r\n    $fullname   = $name_first.'' ''.$name_last;\r\n    $phone      = Yii::app()->request->getPost(''levelkuldes'')[''Users''][''phone''];\r\n    $website    = Yii::app()->request->getPost(''levelkuldes'')[''Users''][''website''];\r\n    $email      = Yii::app()->request->getPost(''levelkuldes'')[''Users''][''email''];\r\n    \r\n    $message  = ''<p><b>Feladó:</b> ''.$fullname.''<br />'';\r\n	$message .= ''<b>Telefon:</b> ''.$phone.''<br />'';\r\n	if ($website != '''' && $website !== null){\r\n		$message .= ''<b>Web:</b> ''.$website.''<br />'';\r\n	}\r\n	$message .= ''<b>E-mail:</b> ''.$email.''</p>'';\r\n	$message .= Yii::app()->request->getPost(''levelkuldes'')[''message''];\r\n	\r\n    Yii::app()->phpmailer->send_mail(\r\n                $fullname,\r\n                $email,\r\n                ''[''.$fullname.''] Üzenet a weblapról'',\r\n                $message\r\n            );\r\n\r\n    Yii::app()->user->setFlash(''success'', ''<h4>Köszönöm ''.$name_first.'', a leveledet megkaptam!</h4><p>Hamarosan válaszolok neked!</p>'');\r\n    \r\n    try{\r\n        // logolnom kell a felhasználót\r\n        // ha még nem szerepel ezzel az e-mailcímmel\r\n        // vagy ha nincs belépve\r\n        $user = Users::model()->find(array(\r\n            ''condition'' => ''email=:email AND status<>:status_d'',\r\n            ''params'' => array(\r\n                '':email'' => $email,\r\n                '':status_d'' => ''d'',\r\n                ),\r\n            ''order'' => ''id DESC'',\r\n        ));\r\n        \r\n        if (!isset($user)){\r\n            // ha még nincs logolva, akkor mentem\r\n            $user = new Users();\r\n            $user->email  = $email;\r\n            $user->status = ''m'';\r\n            if ($user->save()){\r\n                $userdetails = new UserDetails();\r\n                $userdetails->user_id    = $user->getPrimaryKey();\r\n            }else{\r\n                $user->throw_exception(''Felhasználó mentési hiba!'');\r\n            }\r\n        }else{\r\n            $userdetails = UserDetails::model()->find(array(\r\n                ''condition'' => ''user_id=:user_id'',\r\n                ''params'' => array(\r\n                    '':user_id'' => $user->id,\r\n                ),\r\n            ));\r\n            if (!isset($userdetails)){\r\n                $userdetails = new UserDetails();\r\n                $userdetails->user_id    = $user->getPrimaryKey();\r\n            }\r\n        }\r\n        //userdetails-t mindenképp mentem\r\n        $userdetails->name_first = $name_first;\r\n    	$userdetails->name_last  = $name_last;\r\n    	$userdetails->phone_1    = $phone;\r\n    	$userdetails->status     = ''a'';\r\n    	$userdetails->website    = $website;\r\n    	$userdetails->email      = $email;\r\n    	\r\n    	$userdetails->comment_private .= ''<p>==== Üzenetet küldött: ''.date(''Y-m-d H:i'').'' ====</p>'';\r\n    	$userdetails->comment_private .= $message;\r\n    \r\n    	if (!$userdetails->save()){\r\n    	    $user->throw_exception(''Felhasználó adatainak mentése nem sikerült!'');\r\n    	}\r\n        	\r\n    	if (Yii::app()->user->isGuest){\r\n            // ha nincs belépve\r\n        	// elmentem a user_id-ját sessionbe, hogy a cimkéket hozzá lehessen rendelni\r\n        	Yii::app()->user->setState(''id'', $user->id);\r\n        }else{\r\n            // ha be van lépve, akkor nem írom felül a session_id-ját\r\n        }\r\n    } catch (Exception $e){\r\n        AErrorHandler::send_error_message_to_developer($e->getMessage());\r\n    }', NULL, NULL, NULL, NULL, NULL, 'a');

-- --------------------------------------------------------

--
-- Tábla szerkezet: `tbl_form_inputs`
--

CREATE TABLE IF NOT EXISTS `tbl_form_inputs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) DEFAULT NULL COMMENT 'Form',
  `type` varchar(100) DEFAULT NULL COMMENT 'Típus',
  `model_class` varchar(100) DEFAULT NULL COMMENT 'Model Osztály',
  `model_attribute` varchar(100) DEFAULT NULL COMMENT 'Model mező',
  `label` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL COMMENT 'name',
  `value` varchar(100) DEFAULT NULL COMMENT 'value',
  `placeholder` varchar(100) DEFAULT NULL COMMENT 'Placeholder',
  `class` varchar(100) DEFAULT NULL,
  `style` varchar(100) DEFAULT NULL,
  `order_num` int(11) DEFAULT NULL,
  `user_create` int(11) DEFAULT NULL COMMENT 'Létrehozta',
  `date_create` datetime DEFAULT NULL COMMENT 'Létrehozás ideje',
  `user_update` int(11) DEFAULT NULL COMMENT 'Módosította',
  `date_update` datetime DEFAULT NULL COMMENT 'Módosítás ideje',
  `status` varchar(1) DEFAULT NULL COMMENT 'Státusz',
  PRIMARY KEY (`id`),
  KEY `form_id` (`form_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Tábla adatok: `tbl_form_inputs`
--

INSERT INTO `tbl_form_inputs` (`id`, `form_id`, `type`, `model_class`, `model_attribute`, `label`, `name`, `value`, `placeholder`, `class`, `style`, `order_num`, `user_create`, `date_create`, `user_update`, `date_update`, `status`) VALUES
(1, 2, 'textField', NULL, NULL, 'Vezetékneved', 'Users[name_last]', NULL, NULL, 'span12', NULL, 1, NULL, NULL, NULL, NULL, 'r'),
(2, 2, 'textField', NULL, NULL, 'Keresztneved', 'Users[name_first]', NULL, NULL, 'span12', NULL, 2, NULL, NULL, NULL, NULL, 'r'),
(3, 2, 'emailField', NULL, NULL, 'E-mail címed', 'Users[email]', NULL, NULL, 'span12', NULL, 3, NULL, NULL, NULL, NULL, 'r'),
(4, 2, 'telField', NULL, NULL, 'Telefonszámod', 'Users[phone]', NULL, NULL, 'span12', NULL, 4, NULL, NULL, NULL, NULL, 'a'),
(5, 2, 'textField', NULL, NULL, 'Weboldalad', 'Users[website]', NULL, 'http://', 'span12', NULL, 5, NULL, NULL, NULL, NULL, 'a'),
(6, 2, 'redactor', NULL, NULL, 'Üzeneted', 'message', NULL, 'Ide írd az üzeneted!', NULL, NULL, 6, NULL, NULL, NULL, NULL, 'r'),
(7, 2, 'submitButton', NULL, NULL, NULL, 'sendmail', 'Elküldöm!', NULL, 'btn btn-primary span12', NULL, 7, NULL, NULL, NULL, NULL, 'a');

--
-- Kikötések a kiírt táblákhoz
--

--
-- Kikötések a táblához `tbl_form_datas`
--
ALTER TABLE `tbl_form_datas`
  ADD CONSTRAINT `tbl_form_datas_ibfk_1` FOREIGN KEY (`input_id`) REFERENCES `tbl_form_inputs` (`id`);

--
-- Kikötések a táblához `tbl_form_inputs`
--
ALTER TABLE `tbl_form_inputs`
  ADD CONSTRAINT `tbl_form_inputs_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `tbl_form_forms` (`id`);

