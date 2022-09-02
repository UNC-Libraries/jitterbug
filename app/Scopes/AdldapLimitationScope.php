<?php

namespace Jitterbug\Scopes;

use Adldap\Laravel\Scopes\ScopeInterface;
use Adldap\Query\Builder;

class AdldapLimitationScope implements ScopeInterface
{
    public function apply(Builder $query)
    {
        $filters = env('LDAP_LIMITATION_FILTER', '');
        $query->whereMemberOf($filters);
    }
}
