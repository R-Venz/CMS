<?php
	/*
		Jun Gie Abad Casuyac
		www.facebook.com/jungiec1
		jungiecasuyac@gmail.com
		09466240347
		March 30, 2019
		10:33 PM
		Navalan, Tukuran, Zamboanga del Sur
	*/
	class Encryption{
		//private $key = md5('australia');
		//private $salt = md5('australia'); // for hashing
		
		//Encrypt
		function Encrypt($string){
			$string=rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5('australia'), $string, MCRYPT_MODE_ECB)));
			return $string;
		}
		//Decrypt
		function Decrypt($string){
			$string=rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($string), MCRYPT_MODE_ECB));
			return $string;
		}
		//Hashing
		function Hashword($string){
			$string=crypt($string, '$1$' . md5('australia') . '$');
			return $string;
		}
		//Filter
		function DataFilter($Data){ 
			$Connection=$this->OpenDatabase();
			$Data=mysqli_real_escape_string($Connection, $Data);
			return $Data;
		}
		//Based 64 encode/decode
		//-------------------------------------------------------------------------------------------------------------		  
		function DataCrypt($Data,$DecodeType){  
			$Temp="";
			if ($DecodeType=='ENCODE'){
				$Temp=base64_encode($Data);
			}
			elseif ($DecodeType=='DECODE'){
				$Temp=base64_decode($Data);
			}
			return $Temp;
		}
		//-------------------------------------------------------------------------------------------------------------		  
	}
?>