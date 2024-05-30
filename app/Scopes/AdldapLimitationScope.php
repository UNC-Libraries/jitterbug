<?php

namespace Jitterbug\Scopes;

use LdapRecord\Models\Model;
use LdapRecord\Models\Scope;
use LdapRecord\Query\Model\Builder;

class AdldapLimitationScope implements Scope
{
    public function apply(Builder $query, Model $model): void
    {
        $filters = env('LDAP_LIMITATION_FILTER', '');
        $query->whereMemberOf($filters);
    }
}
