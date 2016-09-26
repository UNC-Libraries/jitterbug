<?php

function routeName()
{
  return app('request')->route()->getName();
}