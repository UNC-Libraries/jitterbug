<?php

function routeName()
{
  return app('request')->route()->getName();
}

function fileTimestamp()
{
  $date = new DateTime();
  $date->setTimezone(new DateTimeZone('America/New_York'));
  $timestamp = $date->format('Y-m-d-H-i-sO');
  return $timestamp;
}