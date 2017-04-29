<?php
/*
 * This file is part of the Codeninja/iCal package.
 *
 * @Copyright (C) Daniel Blum. All rights reserved.
 * @website http://codeninja.eu
 *
 * Use of this source code is governed by an MIT-style license that can be
 * found in the LICENSE file.
 */

require __DIR__ . '/../autoload.php';

// 1. Create new calendar  component object
$calendar = new \Codeninja\iCal\Calendar('www.example-site.com');

// 2. Create an event component object
$firstEvent = new \Codeninja\iCal\Event();
$firstEvent->setUniqueId('123456789');

// 3. Prepare Date object (today + 10 days)
$dtDate = new DateTime();
$dtDate->add(new DateInterval('P10D'));

$firstEvent->setDtStart($dtDate);
$firstEvent->setDtEnd($dtDate);
//$firstEvent->setisAllDay(true);

// 4. Title & Description
$firstEvent->setSummary('Summary: Lorem Ipsum');
$firstEvent->setDescription('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.');

//Location informations (optional)
$firstEvent->setLocation("Frankfurt Airport (FRA)\n Frankfurt DE 60547");

// Adding Timezone (optional)
$firstEvent->setUseTimezone(true);
#$firstEvent->setTimezoneString("Europe/Berlin");
$firstEvent->setTimezoneString("Europe/London");

// 5. Add event to calendar object
$calendar->addEvent($firstEvent);

// 6. Generate output
$content = $calendar->render();

//Download file
if($_GET['isDownload'] == true)
{
	header('Content-Type: text/calendar; charset=utf-8');
	header('Content-Disposition: attachment; filename="filename.ics"');
	echo $content;
} else {
?>

<h1>Codeninja iCal Demo 1:</h1>

<p>	This is a small demonstration of how you could use the iCal library to generate a iCal file within you project. </p>
<p>
In case you need further informations please take a look into the readme.md or  According to RFC 5545 @see <a href="https://tools.ietf.org/html/rfc5545" target="_blank">https://tools.ietf.org/html/rfc5545</a>.
</p>

<br>The generated file (filename.ics) content look like:
<pre style="color:red;"><?php echo $content; ?></pre>

<button onclick="window.location.href='?isDownload=1';">Download as file</button>

<?php } ?>