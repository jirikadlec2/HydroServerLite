<?php
//check authority to be here
//require_once 'authorization_check.php';
//connect to server and select database
require_once 'database_connection.php';
$SiteID = $_GET['sid'];
$VariableID = $_GET['varid'];
$MethodID = $_GET['mid'];
$DataValue = $_GET['val'];

//Run a query to fetch Source id

$query12 = "Select SourceID FROM seriescatalog WHERE `MethodID`='$MethodID' and `VariableID`='$VariableID' and `SiteID`='$SiteID'";

$result12 = mysql_query($query12,$connection) or die("SQL Error 1: " . mysql_error());
$row = mysql_fetch_array($result12, MYSQL_ASSOC);

$SourceID = $row['SourceID'];

require_once 'AL_hidden_values.php';

//Create Local and UTC DateTimes
$LocalDate = $_GET['dt'];
$LocalTime = $_GET['time'];

$timepieces = explode(":", $LocalTime);
$timepieces[0]; // piece1 (hours)
$timepieces[1]; // piece2 (minutes)

// the UTC Offset time is 7 hours in this location
$newUTCpiece = ($timepieces[0] + $UTCOffset2); 

	// this checks to see if adding the hours puts us into the next day period
	if ($newUTCpiece > 24) {

		$NewTimePiece = ($newUTCpiece - 24);
	
		//this creates the complete new time for a new day
		$newUTCtime = "0" . $NewTimePiece . ":" . $timepieces[1]; 

		$DatePiece = explode("-", $LocalDate);
		$DP0 = $DatePiece[0]; // piece1 (year as YYYY)
		$DP1 = $DatePiece[1]; // piece2 (month as MM)
		$DP2 = $DatePiece[2]; // piece3 (day as DD)

		// Adds one day to the date
		$NewDay = $DP2 + 1; 
		
	// Checks to see if the day puts it into the next month during a non-leap year
	if ($NewDay > 28 && $DP1 == 02 && $DP0 == 2013 || 2014 || 2015 || 2017 || 2018 || 2019 || 2021 || 2022 || 2023 || 2025 || 2026 || 2027 || 2029 || 2030 || 2031 || 2033 || 2034 || 2035 || 2037 || 2038 || 2039 || 2041 || 2042 || 2043 || 2045 || 2046 || 2047 || 2049 || 2050 || 2051 || 2053 || 2054 || 2055 || 2057 || 2058 || 2059 || 2061 || 2062 || 2063){  
	
	// Bumps the month to the next one and makes the day 1
	$NewYear = $DP0;
	$NewMonth = $DP1 + 1;
	$NewDay = 01;

		// Checks to see if the month puts it into the next year
		if ($NewMonth > 12){

			$NewYear = $DP0 + 1;
			$NewMonth = 01;
			$NewDay = 01;
			}
		// then build this yyyy-mm-dd hh:mm:ss
		$DateTimeUTC = $NewYear . "-" . $NewMonth . "-" . $NewDay . " " . $newUTCtime . ":00";
		}

	// Checks to see if the day puts it into the next month during a leap year
	elseif ($NewDay > 29 && $DP1 == 02 && $DP0 == 2012 || 2016 || 2020 || 2024 || 2028 || 2032 || 2036 || 2040 || 2044 || 2048 || 2052 || 2056 || 2060 || 2064){ 

	// Bumps the month to the next one and makes the day 1
	$NewYear = $DP0;
	$NewMonth = $DP1 + 1;
	$NewDay = 01;

		// Checks to see if the month puts it into the next year
		if ($NewMonth > 12) {

			$NewYear = $DP0 + 1;
			$NewMonth = 01;
			$NewDay = 01;
			}
		// then build this yyyy-mm-dd hh:mm:ss
		$DateTimeUTC = $NewYear . "-" . $NewMonth . "-" . $NewDay . " " . $newUTCtime . ":00";
		}
		
	// Checks to see if the day puts it into the next month
	elseif ($NewDay > 30 && $DP1 == 04 || 06 || 09 || 11){ 

	// Bumps the month to the next one and makes the day 1
	$NewYear = $DP0;
	$NewMonth = $DP1 + 1;
	$NewDay = 01;

		// Checks to see if the month puts it into the next year
		if ($NewMonth > 12) {

			$NewYear = $DP0 + 1;
			$NewMonth = 01;
			$NewDay = 01;
			}
		// then build this yyyy-mm-dd hh:mm:ss
		$DateTimeUTC = $NewYear . "-" . $NewMonth . "-" . $NewDay . " " . $newUTCtime . ":00";
		}

	// Checks to see if the day puts it into the next month
	elseif ($NewDay > 31 && $DP1 == 01 || 03 || 05 || 07 || 08 || 10 || 12){

	// Bumps the month to the next one and makes the day 1
	$NewYear = $DP0;
	$temp = $DP1 + 1;
		if ($temp < 10) {
			$NewMonth = "0" . $temp;
			}
			else {
				$NewMonth = $temp;
				}
	$NewDay = 01;

		// Checks to see if the month puts it into the next year
		if ($NewMonth > 12) {
			$NewYear = $DP0 + 1;
			$NewMonth = 01;
			$NewDay = 01;
			}
		// then build this yyyy-mm-dd hh:mm:ss
		$DateTimeUTC = $NewYear . "-" . $NewMonth . "-" . $NewDay . " " . $newUTCtime . ":00";
		} 
	
	} else {
	$DateTimeUTC = $LocalDate . " " . $newUTCpiece . ":" . $timepieces[1] . ":00";
	}
$LocalDateTime = $LocalDate . " " . $LocalTime . ":00";
	


//add the all variables to the datavalues table
$sql7 ="INSERT INTO `datavalues`(`ValueID`, `DataValue`, `ValueAccuracy`, `LocalDateTime`, `UTCOffset`, `DateTimeUTC`, `SiteID`, `VariableID`, `OffsetValue`, `OffsetTypeID`, `CensorCode`, `QualifierID`, `MethodID`, `SourceID`, `SampleID`, `DerivedFromID`, `QualityControlLevelID`) VALUES ('$ValueID', '$DataValue', '$ValueAccuracy', '$LocalDateTime', '$UTCOffset', '$DateTimeUTC', '$SiteID', '$VariableID', '$OffsetValue', $OffsetTypeID, '$CensorCode', '$QualifierID', '$MethodID', '$SourceID', $SampleID, '$DerivedFromID', '$QualityControlLevelID')";

$result7 = @mysql_query($sql7,$connection)or die(mysql_error());

require_once 'update_series_catalog_function.php';

update_series_catalog($SiteID, $VariableID, $MethodID, $SourceID, $QualityControlLevelID);

if($result7==1)
{

echo ($ValueID);
	
	
}

?>
