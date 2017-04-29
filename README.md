# Codeninja iCal library

This library offers a abstraction layer for creating iCal Calendars and .ics files. The output will be generated according [RFC 5545] .

The following types are currently supported:

* VCALENDAR
* VEVENT

## Installation
The Codeninja iCal library is available via GitHub download only.

## Usage

### Basic Usage

#### Create a Calendar object

```PHP
$calendar = new \Codeninja\iCal\Calendar('www.example-site.com');
```

#### Create a new Event object

```PHP
$myEvent = new \Codeninja\iCal\Event();
```


#### Add required and optional information to the Event object
```PHP
$myEvent->setDtStart(new \DateTime());
$myEvent->setDtEnd(new \DateTime());
$myEvent->setisAllDay(true);

$myEvent->setSummary('Summary: Lorem Ipsum');
$myEvent->setDescription('Lorem Ipsum is simply dummy text of the printing and typesetting industry.');'
```

#### Add event to calendar object

```PHP
$calendar->addEvent($myEvent);
```

#### Generate & display output

```PHP
$content = $calendar->render();
echo $content;
```


### Timezone support

This component supports three different types of handling timezones:

#### 1. UTC (default)

In the default setting, UTC will be used as Timezone. The time will be formated as following:

```
DTSTART:20170101T180000Z
```

#### Use locale time

You can use the local server time by set `$myEvent->setUseUtc(false);`.

```
DTSTART:20170101T180000
```

## License

This software is distributed under the MIT license license. Please read LICENSE for information on the
software availability and distribution.