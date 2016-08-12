<?php
abstract class CurrencyManager {
	
	public static final function formatValue($value){
		return number_format($value, 2);
	}
	
}