<?php

// get DateTime instance
function datetime( string $datetime = 'now' ) : DateTimeImmutable {
    $timezone = new DateTimeZone( timezone() );
    $datetime = new DateTimeImmutable( $datetime, $timezone );

    return $datetime;
}

// get date range
function daterange( string $start, string $interval, string $end ) : DatePeriod {
    $start = is_numeric( $start ) 
        ? datetime()->setTimestamp( $start ) 
        : datetime( $start );
    $end = is_numeric( $end ) 
        ? datetime()->setTimestamp( $end ) 
        : datetime( $end );
    $interval = new DateInterval( $interval );
    
    $daterange = new DatePeriod( $start, $interval, $end );

    return $daterange;
}

// check if date is current
function is_current_date( DateTimeInterface $date ) {
    $now = datetime();

    return $date->format( 'Y m d' ) == $now->format( 'Y m d' );
}

// get timezone
function timezone() {
    return 'America/New_York';
}

// find event in array by timestamp
function find_event_by_timestamp( $timestamp, array $events ) {
    foreach ( $events as $event ) {
        if ( 
            $event->event_timestamp == $timestamp 
        ) {
            return $event;
        }
    }

    return null;
}