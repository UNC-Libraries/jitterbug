<?php

function routeName()
{
    return app('request')->route()->getName();
}

/**
 * Used for imports and exports to produce a timestamp string
 * for the uploaded or downloaded file.
 */
function fileTimestamp()
{
    $date = new DateTime;
    $date->setTimezone(new DateTimeZone('America/New_York'));
    $timestamp = $date->format('Y-m-d-H-i-sO');

    return $timestamp;
}

/**
 * Used for displaying revision timestamps.
 */
function revisionTimestamp($timestamp)
{
    $timestamp->setTimezone(new DateTimeZone('America/New_York'));

    return $timestamp->format('m/d/Y h:i a');
}
