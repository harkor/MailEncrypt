<?php

/*
 *  Copyright (C) 2018
 *	Julien Winant (http://github.com/harkor)
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/*

    Example
    echo (new MailEncrypt('<a href="mailto:albert@pouet.com">albert@pouet.com</a>'))->get();

*/

class MailEncrypt {

    private $string = "";
    private $key = 6;

    public function __construct($string){
        $this->string = $string;
    }

    private function encryptString(){

        $chars = str_split($this->string, 1);

        $output = '';
        foreach($chars as $char):
            $output .= chr(($this->key ^ ord($char)));
        endforeach;

        return $output;

    }

    private function getJavaScript($string){

        $myVar = 'a'.md5(random_bytes(15)+time()+random_bytes(15));

        $result = '<script language="JavaScript">
        <!--
            var '.$myVar.'_enc= \''.$string.'\';
            for('.$myVar.'_i=0;'.$myVar.'_i<'.$myVar.'_enc.length;++'.$myVar.'_i)
            {
                document.write(String.fromCharCode('.$this->key.'^'.$myVar.'_enc.charCodeAt('.$myVar.'_i)));
            }
            //-->
        </script>';

        return $result;

    }

    public function get(){

        return $this->getJavaScript($this->encryptString());

    }

}
