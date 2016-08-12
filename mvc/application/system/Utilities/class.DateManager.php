<?
#ä
abstract class DateManager {

	public static $timestamp;
	public static $t;
	public static $today;

	/*
	 *
	 * get und set-methoden
	 *
	 */
	function getTimestamp() {
		return ( empty(self::$timestamp) ? time() : self::$timestamp );
	}

	function getToday() {
		return ( empty(self::$today) ? time() : self::$today );
	}

	function setTimestamp($timestamp) {
		self::$timestamp = $timestamp;
	}

	function setValues() {
		if (empty(self::$timestamp)) {
			self::setTimestamp(time());
			self::$t = getdate(self::$timestamp);
			self::$today = self::$timestamp;
		}
	}

  // heute: 0 Uhr
  public static final function getDayStart() {
  	self::setValues();
		return mktime(0,0,0,self::$t['mon'],self::$t['mday'],self::$t['year']);
	}

	//diese Woche (Anfang und Ende)
	public static final function getThisWeekStartEnd() {
		self::setValues();
		$start = self::$t[0] - (86400 * self::$t['wday']);
		$end = $start + 518400;
		$thisWeekStart = $start;
		$thisWeekEnd = $end;
		return array($thisWeekStart, $thisWeekEnd);
	}

	//letzte Woche (Anfang und Ende)
	public static final function getLastWeekStartEnd() {
		self::setValues();
		$lastWeekStart = (self::$t[0] - (86400 * self::$t['wday'])) - 604800;
		$lastWeekEnd = $lastWeekStart + 518400;
		$lastWeekStart = $lastWeekStart;
		$lastWeekEnd = $lastWeekEnd;

		return array($lastWeekStart, $lastWeekEnd);
	}

	//dieser Monat (Anfang und Ende)
	public static final function getThisMonthStartEnd() {
		$thisMonthStart = mktime(0,0,0,date('m',time()),1,date('Y',time()));
		$thisMonthEnd = mktime(0,0,0,(date('m',time())+1),-1,date('Y',time()));
		return array($thisMonthStart, $thisMonthEnd);
	}

	//letzter Monat (Anfang und Ende)
	public static final function getLastMonthStartEnd() {
		$lastMonthStart = mktime(0,0,0,(date('m',time())-1),1,date('Y',time()));
		$lastMonthEnd = mktime(0,0,0,(date('m',time())),-1,date('Y',time()));
		return array($lastMonthStart, $lastMonthEnd);
	}

	//dieses Quartal (Anfang und Ende)
	public static final function getThisQuarterStartEnd() {
		$thisQuarterStart;
		$thisQuarterEnd;

		if(self::$t['mon'] == '1' OR self::$t['mon'] == '2' OR self::$t['mon'] == '3') {
			$thisQuarterStart = self::$t['year'].'-01-01';
			$thisQuarterEnd = self::$t['year'].'-03-31';
		} elseif(self::$t['mon'] == '4' OR self::$t['mon'] == '5' OR self::$t['mon'] == '6') {
			$thisQuarterStart = self::$t['year'].'-04-01';
			$thisQuarterEnd = self::$t['year'].'-06-30';
		} elseif(self::$t['mon'] == '7' OR self::$t['mon'] == '8' OR self::$t['mon'] == '9') {
			$thisQuarterStart = self::$t['year'].'-07-01';
			$thisQuarterEnd = self::$t['year'].'-09-30';
		}	else {
			$thisQuarterStart = self::$t['year'].'-10-01';
			$thisQuarterEnd = self::$t['year'].'-12-31';
		}

		return array(strtotime($thisQuarterStart), strtotime($thisQuarterEnd));
	}

	//letztes Quartal (Anfang und Ende)
	public static final function getLastQuarterStartEnd() {
		$lastQuarterStart;
		$lastQuarterEnd;

		if(self::$t['mon'] == '1' OR self::$t['mon'] == '2' OR self::$t['mon'] == '3') {
			$lastQuarterStart = (self::$t['year']-1).'-10-01';
			$lastQuarterEnd = (self::$t['year']-1).'-12-31';
		} elseif(self::$t['mon'] == '4' OR self::$t['mon'] == '5' OR self::$t['mon'] == '6') {
			$lastQuarterStart = self::$t['year'].'-01-01';
			$lastQuarterEnd = self::$t['year'].'-03-31';
		} elseif(self::$t['mon'] == '7' OR self::$t['mon'] == '8' OR self::$t['mon'] == '9') {
			$lastQuarterStart = self::$t['year'].'-04-01';
			$lastQuarterEnd = self::$t['year'].'-06-30';
		} else {
			$lastQuarterStart = self::$t['year'].'-07-01';
			$lastQuarterEnd = self::$t['year'].'-09-30';
		}
		return array(strtotime($lastQuarterStart), strtotime($lastQuarterEnd));
	}


	/**
	 * get quarter from begindate to enddate in an array
	 *
	 * @author Mario Rimpler 2008-10-13
	 * @see [silly code but works ...]
	 * @param string $begindate
	 * @param string $enddate
	 * @return array
	 *
	 * @example $myQuarters = getQuartersBetweenDatesAsArray( '2005-04-20' , time() );
	 */
	public function getQuartersBetweenDatesAsArray( $begindate, $enddate ) {

		$begindate = (int) ( is_numeric($begindate) ? $begindate : strtotime( $begindate ) );
		$enddate = (int) ( is_numeric($enddate) ? time() : strtotime( $enddate ) );

		$startyear = (int) date('Y', $begindate);
		$startmonth = (int) date('m', $begindate);
		$endyear = (int) date('Y', $enddate);
		$endmonth = (int) date('m', $enddate);
		$myQuartal = array();
		$i = (int) 0;

		for( $y = $startyear; $y <= $endyear;  $y++ ){
			for( $m = $startmonth; $m <= 12;  $m++ ){
				if ( $y >= $endyear AND $m > $endmonth ){
					break;
				}

				switch( $m ){
					case 1:
					case 2:
					case 3:
						$myQuartal[$y][1]['von'] = mktime(0, 0, 0, 1, 1, $y);
						$myQuartal[$y][1]['bis'] = mktime(0, 0, 0, 4, 0, $y);
						break;
					case 4:
					case 5:
					case 6:
						$myQuartal[$y][2]['von'] = mktime(0, 0, 0, 4, 1, $y);
						$myQuartal[$y][2]['bis'] = mktime(0, 0, 0, 7, 0, $y);
						break;
					case 7:
					case 8:
					case 9:
						$myQuartal[$y][3]['von'] = mktime(0, 0, 0, 7, 1, $y);
						$myQuartal[$y][3]['bis'] = mktime(0, 0, 0, 10, 0, $y);
						break;
					case 10:
					case 11:
					case 12:
						$myQuartal[$y][4]['von'] = mktime(0, 0, 0, 10, 1, $y);
						$myQuartal[$y][4]['bis'] = mktime(0, 0, 0, 13, 0, $y);
						break;
				}
				$i++;

				if( $m >= 12 AND $y < $endyear ){
					$y++; $m = 0;
				}
			}
		}
		return $myQuartal;
	}


	public function getMonthsBetweenDates($begindate,$enddate){
		$months = array();
		$startyear = (int) date('Y', (is_numeric($begindate) ? $begindate : strtotime($begindate)));
		$startmonth = (int) date('m', (is_numeric($begindate) ? $begindate : strtotime($begindate)));
		$endyear = (int) date('Y', (is_numeric($enddate) ? $enddate : strtotime($enddate)));
		$endmonth = (int) date('m', (is_numeric($enddate) ? $enddate : strtotime($enddate)));

		$smonth = $startmonth;

		for( $y = $startyear; $y <= $endyear;  $y++ ){
			for( $m = $smonth; $m <= 12;  $m++ ){
				if ( $y >= $endyear AND $m > $endmonth )
				break;
				$myString = $y.'-'.(strlen($m) < 2 ? '0'.$m : $m).'-01';
				$months[$myString] = $myString;
			}
			$smonth = 1;
		}
		return $months;
	}

	//dieses Jahr (Anfang und Ende)
	public static final function getThisYearStartEnd() {
		$thisYearStart = self::$t['year'].'-01-01';
		$thisYearEnd = self::$t['year'].'-12-31';
		return array($thisYearStart, $thisYearEnd);
	}

	//letztes Jahr (Anfang und Ende)
	public static final function getLastYearStartEnd() {
		$lastYearStart = (self::$t['year'] - 1).'-01-01';
		$lastYearEnd = (self::$t['year'] - 1).'-12-31';
		return array($lastYearStart, $lastYearEnd);
	}

	//letztes Jahr, gleiches Datum
	public static final function getLastYearSameDate() {
		$lastYearSateDate = (self::$t[0] - 31536000);
		$lastYearSateDate= date('Y-m-d', $lastYearSateDate);
		return $lastYearSateDate;
	}


	// Y-m-d in d.m.Y
	public static final function dateYmdToDateDmy($dateStr) {
		if(preg_match('/^([0-9]{4}|[0-9]{2})\-[0-9]{2}\-[0-9]{2}$/', $dateStr)) {
			return implode('.', array_reverse(explode('-', $dateStr)));
		} else {
			return false;
		}
	}

	// d.m.Y in Y-m-d
	public static final function dateDmyToDateYmd($dateStr) {
		if(preg_match('/^[0-9]{2}\.[0-9]{2}\.([0-9]{4}|[0-9]{2})$/', $dateStr)) {
			return implode('-', array_reverse(explode('.', $dateStr)));
		} else {
			return false;
		}
	}

	// Y-m-d in Timestamp
	public static final function dateYmdToDateTimestamp($dateStr) {
		if(preg_match('/^([0-9]{4}|[0-9]{2})\-[0-9]{2}\-[0-9]{2}$/', $dateStr)) {
			$datearray = explode('-', $dateStr);
			return mktime(0,0,0, $datearray[1], $datearray[2], $datearray[0]);
		} else {
			return false;
		}
	}

	// d.m.Y in Timestamp
	public static final function dateDmyToDateTimestamp($dateStr) {
		if(preg_match('/^[0-9]{2}\.[0-9]{2}\.([0-9]{4}|[0-9]{2})$/', $dateStr)) {
			$datearray = explode('.', $dateStr);
			return mktime(0,0,0, $datearray[1], $datearray[0], $datearray[2]);
		} else {
			return false;
		}
	}

	// Timestamp in d.m.Y
	public static final function dateTimestampToDateDmy($timestamp) {
		return date(getTrans('LANG_DATEFORMAT_SHORT', true), $timestamp);
	}

	// Timestamp in d.m.Y
	public static final function dateTimestampToDateDmyhis($timestamp) {
		return
		(is_null($timestamp) ?
		null
		:
		date(getTrans('LANG_DATEFORMAT', true), ( is_numeric($timestamp) ? $timestamp : strtotime($timestamp)))
		);
	}

	// Timestamp in Y-m-d
	public static final function dateTimestampToDateYmd($timestamp) {
		return date("Y-m-d", $timestamp);
	}

	// Ymd for <form><option> - shows 3 select fields with current date
	public static final function dateYmdForHtmlFormSelect($dateStr){

		$datepiece 	= explode ('-', $dateStr);
		$year 			= $datepiece[0];
		$month 			= $datepiece[1];
		//if( strlen($month) == 1 ) $month = '0'.$month;
		$day				= $datepiece[2];
		//if( strlen($day) == 1 )	$day = '0'.$day;

		// day
		$result .=  '<select name="date_day" title="Day">';
		for ($i=1;$i<=31;$i++){
			if ( $i == $day ){ $xa = 'selected'; }else{ $xa = ''; }
			$result .= '<option value="'.$i.'" '.$xa.'>'.$i.'</option>';
		}
		$result .= '</select>';

		// month
		$result .= '<select name="date_month" title="Month">';
		for ($i=1;$i<=12;$i++){
			if ( $month == $i ){ $xb = 'selected'; }else{ $xb = ''; }
			$result .= '<option value="'.$i.'" '.$xb.'>'.$i.'</option>';
		}
		$result .= '</select>';

		// year
		$j = date('Y')-18;
		$result .= '<select name="date_year" title="Year">';
		for ($i=$j;$i>(date('Y')-110);$i--){
			if ($i == $year){ $xc = 'selected'; }else{ $xc = ''; }
			$result .= '<option value="'.$i.'" '.$xc.'>'.$i.'</option>';
		}
		$result .= '</select>';

		return $result;

	}

	public static final function getWeekdaynameByNumber($number){
		// später gegen konstanten austauschen
		switch ($number){
			case 1: $name = 'LANG_MONDAY'; break;
			case 2: $name = 'LANG_TUESDAY'; break;
			case 3: $name = 'LANG_WEDNESDAY'; break;
			case 4: $name = 'LANG_THURSDAY'; break;
			case 5: $name = 'LANG_FRIDAY'; break;
			case 6: $name = 'LANG_SATURDAY'; break;
			case 7:	$name = 'LANG_SUNDAY'; break;
		}
		return getTrans($name, true);
	}


}