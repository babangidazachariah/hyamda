<?php

	function Encrypt($strInput){
		// Store the cipher method
		$ciphering = "AES-128-CTR";
		  
		// Use OpenSSl Encryption method
		$iv_length = openssl_cipher_iv_length($ciphering);
		$options = 0;
		  
		// Non-NULL Initialization Vector for encryption
		$encryption_iv = '1029384857601987';
		
		// Store the encryption key
		$encryption_key = "HA@12tsp78mn48#ghdGH";
		  
		// Use openssl_encrypt() function to encrypt the data
		return openssl_encrypt($strInput, $ciphering, $encryption_key, $options, $encryption_iv);
	}  
	
	function Decrypt($strInput){
		/// Store the cipher method
		$ciphering = "AES-128-CTR";
		  
		// Use OpenSSl Encryption method
		$iv_length = openssl_cipher_iv_length($ciphering);
		$options = 0;
		  
		// Non-NULL Initialization Vector for encryption
		$decryption_iv = '1029384857601987';
		
		// Store the encryption key
		$decryption_key = "HA@12tsp78mn48#ghdGH";
		  
		// Use openssl_decrypt() function to decrypt the data
		return openssl_decrypt ($strInput, $ciphering, $decryption_key, $options, $decryption_iv);
	}
?>