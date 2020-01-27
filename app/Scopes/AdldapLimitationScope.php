<?php
namespace App\Scopes;

use Adldap\Laravel\Scopes\ScopeInterface;

class AdldapLimitationScope implements ScopeInterface
{
  public function apply($query)
  {
    $filters = env('ADLDAP_LIMITATION_FILTER', '');
    $query->rawFilter($filters);
  }
}