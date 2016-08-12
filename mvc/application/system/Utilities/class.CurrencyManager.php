<?php
abstract class CurrencyManager {

	protected static $currencychar = '€';

	public static final function formatValue($value){
		return number_format($value, 2, ',', '');
	}

	public static final function formatCurrency($value, $currencychar = false){
		return number_format($value, 0, ',', '.').',-'.( !$currencychar ? ' '.self::$currencychar : ' '.$currencychar);
	}

}
