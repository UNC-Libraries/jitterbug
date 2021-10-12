<?php
namespace Tests\Helpers;
use Venturecraft\Revisionable\Revision;

class TestHelper
{
  // when a factory object is generated, if that model uses Revisionable
  // a revision is automatically created without a user_id
  // this adds a necessary user_id to to that revision
  public static function addUserIdToRevision($revisionableType, $revisionableId, $userId) : void
  {
    $revision = Revision::where('revisionable_type', $revisionableType)
      ->where('revisionable_id', $revisionableId)
      ->get()
      ->first();
    $revision->user_id = $userId;
    $revision->save();
  }
}