<?php namespace Jitterbug\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract, 
                                    CanResetPasswordContract {
  use CamelCasing;
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

  /**
   * Return the user's full name or, in the case of legacy
   * users, their initials.
   */
  public function fullName()
  {
    $fullName = null;
    if ($this->legacy()) {
      $fullName = $this->legacyInitials;
    } else {
      $fullName = $this->firstName . ' ' . $this->lastName;
    }
    return $fullName;
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
   * @return array
   */
  static public function engineerList()
  {
    $users = User::orderBy('first_name')->get();
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
      $engineers[$user->id] = $user->fullName();
    }
    return $engineers;
  }

  /**
   * Legacy users are those individuals we only have initials for.
   * Nobody can remember who they were, and thus we have no first
   * or last name.
   * 
   * @return string
   */
  public function legacy()
  {
    return $this->legacyInitials !== null;
  }
}
