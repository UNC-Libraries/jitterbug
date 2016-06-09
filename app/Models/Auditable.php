<?php namespace Junebug\Models;

use Carbon\Carbon;
use DB;
use Log;

trait Auditable {
  
  private $originalAttributes = array();
  private $changedAttributes = array();

  public static function bootAuditable()
  {
    static::created(function($model) {
      $model->afterCreate();
    });

    static::saving(function($model) {
      Log::info("In auditable saving()");
      $model->beforeSave();
    });
    
    static::saved(function($model) {
      Log::info("In auditable saved()");
      $model->afterSave();
    });

    static::deleted(function($model) {
      $model->afterDelete();
    });
  }

  public function beforeSave()
  {
    $this->originalAttributes=$this->original;
    $this->changedAttributes=$this->getDirty();
  }

  public function afterSave()
  {
    $auditRecords = array();
    foreach($this->changedAttributes as $key => $value) {
      $auditRecords[] = array(
        'auditable_type' => get_class($this),
        'auditable_id' => $this->getKey(),
        'attribute' => $key,
        'old_value' => $this->originalAttributes[$key],
        'new_value' => $this->$value,
        'user_id' => $this->getUserId(),
        'created_at' => new Carbon(),
        'updated_at' => new Carbon(),
      );
    }
    dd($auditRecords);
    //DB::table((new AuditRecord)->getTable())->insert($auditRecords);
  }

  public function getUserId() {
    return 42;
  }
}
