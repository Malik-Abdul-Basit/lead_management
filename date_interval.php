

//Create a new DateInterval.
//$interval = new DateInterval('P1D');
//$interval = new DateInterval('P1M');
//$interval = new DateInterval('P1Y');

$interval = new DateInterval('P1D');

//Add the DateInterval object to our DateTime object.
//$date->add($interval);

//Subtract the DateInterval object to our DateTime object.
$date->sub($interval);

//Print out the result.
$last_date = $date->format("Y-m-d");// subtract 1 days 2021-07-03



$last_date = $date->format("Y-m-d");// subtract 30 days 2021-07-03


exit();



//echo $dt = new DateTime('2014-08-31 23:06:00');



//echo date('Y-m-d', strtotime('today - 30 days'));
/*
* $lastmonth = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
* $dt = new DateTime('2014-08-31 23:06:00');
$dt->sub(new DateInterval('P30D'));
$date->sub(new DateInterval('P1M'));
$date->add($interval);
echo $dt->format('Y-m-d G:i:s');
*
*
*
*
*SELECT date_time  FROM dsr_data
WHERE date_time
between DATEADD(DAY,-30,GETDATE()) and  GETDATE();
*
*
*
*
*
*
*
*
*
*
* $today     = new DateTime(); // today
$begin     = $today->sub(new DateInterval('P30D')); //created 30 days interval back
$end       = new DateTime();
$end       = $end->modify('+1 day'); // interval generates upto last day
$interval  = new DateInterval('P1D'); // 1d interval range
$daterange = new DatePeriod($begin, $interval, $end); // it always runs forwards in date
foreach ($daterange as $date) { // date object
$d[] = $date->format("Y-m-d"); // your date
}
print_r($d);
*
*
*
*/