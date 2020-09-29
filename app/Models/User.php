<?php namespace Jitterbug\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Arr;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract, 
                                    CanResetPasswordContract {

  use Authenticatable, Authorizable, CanResetPassword;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'users';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name', 'username', 'password'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = ['password', 'remember_token'];

  public function isAdmin()
  {
    return $this->admin === 1;
  }

  /**
   * Return the marks for this user.
   */
  public function marks()
  {
    return $this->hasMany('Jitterbug\Models\Mark');
  }

  /**
   * Return users that have logged into the system. Basically
   * filters out legacy users and the system user.
   */
  public function scopeHasLoggedIn($query)
  {
      return $query->where('password', '<>', 'null');
  }

  /**
   * Return the user's full name or, in the case of legacy
   * users, their initials.
   */
  public function fullName()
  {
    $fullName = null;
    if ($this->legacy()) {
      $fullName = $this->legacy_initials;
    } else {
      $fullName = $this->first_name . ' ' . $this->last_name;
    }
    return trim($fullName);
  }

  /**
   * Used by Revisionable to get a display name for the model.
   */
  public function identifiableName()
  {
    return $this->username;
  }

  /**
   * Return a list of engineer users, suitable for use in dropdown
   * menus.
   *
   * @param $originalUserId
   * @return array
   */
  public static function engineerList($originalUserId = null) : array
  {
    $users = self::orderBy('first_name')->get();
    $engineers = array();
    foreach ($users as $user) {
      // Filter out System user
      if ($user->id===1) {
        continue;
      }
      // Filter out legacy engineers with unknown names
      if ($user->legacy()) {
        continue;
      }
      // Filter out inactive users
      if ($user->inactive) {
        continue;
      }
      $engineers[$user->id] = $user->fullName();
    }

    // if a user ID is sent in, it is attached to an existing transfer
    // it may be inactive and/or legacy, so we need it to show up in the list
    // so that the original user can show up in an edit form dropdown
    if ($originalUserId !== null && !Arr::exists($engineers, $originalUserId)) {
      $originalUser = self::findOrFail($originalUserId);
      // if the user is legacy, use the legacy initials. otherwise use the full name.
      $name = $originalUser->legacy() ? $originalUser->legacy_initials : $originalUser->fullName();
      $engineers = Arr::prepend($engineers, $name, $originalUserId);
    }
    return $engineers;
  }

  /**
   * Legacy users are those individuals we only have initials for.
   * Nobody can remember who they were, and thus we have no first
   * or last name.
   * 
   * @return boolean
   */
  public function legacy()
  {
    return $this->legacy_initials !== null;
  }
}
