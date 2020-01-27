<?php namespace Jitterbug\Scopes;

use Adldap\Query\Builder;
use Adldap\Laravel\Scopes\ScopeInterface;

class AdldapLimitationScope implements ScopeInterface
{
  public function apply(Builder $query)
  {
    $filters = env('ADLDAP_LIMITATION_FILTER', '');
    $query->whereMemberOf($filters);
  }
}