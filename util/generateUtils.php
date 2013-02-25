<?php

class generateUtils {
	/*
	 * GERAR UMA CHAVE A PARTIR DE UM ID
	 * */

	static function chaves_gera_chave($id, $lenghtchave = 20) {
		// Configuração do gerador de chaves...
		$caracteres = '0123456789abcdefghijklmnopqrtuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$len = strlen($caracteres);
		$chave = '';
		// Numero de série, que garante unicidade
		while ($id > 0) {
			$chave = $caracteres[intval($id % $len)] . $chave;
			$id = intval($id / $len);
		}
		// Um separador, para a parte aleatória não estragar a unicidade...
		$chave = 's' . $chave;
		// O resto da chave é preenchido aleatoriamente
		while (strlen($chave) < $lenghtchave) {
			$chave = $caracteres[rand(0, $len - 1)] . $chave;
		}
		return $chave;
	}

}