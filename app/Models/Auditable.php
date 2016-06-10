<?php namespace Junebug\Models;

use Carbon\Carbon;
use DB;
use Log;
use ReflectionClass;
use Request;

trait Auditable {
  
  private $originalAttributes = array();
  private $changedAttributes = array();


  public static function bootAuditable()
  {
    static::created(function($model) {
      $model->afterCreate();
    });

    static::saving(function($model) {
      Log::info("In auditable saving() " . get_class($model));
      $model->beforeSave();
    });
    
    static::saved(function($model) {
      Log::info("In auditable saved() " . get_class($model));
      $model->afterSave();
    });

    static::updating(function($model) {
      Log::info("In auditable updating() " . get_class($model));
    });
    
    static::updated(function($model) {
      Log::info("In auditable updated() " . get_class($model));
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
       /* 'auditable_type' => (new ReflectionClass($this))->getShortName(), */
        'auditable_type' => get_class($this),
        'auditable_id' => $this->getKey(),
        'ip_address' => Request::ip(),
        'transaction_id' => $this->getTransactionId(),
        'attribute' => $key,
        'old_value' => $this->originalAttributes[$key],
        'new_value' => $value,
        'user_id' => $this->getUserId(),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      );
    }
    DB::table((new AuditRecord)->getTable())->insert($auditRecords);
  }

  public function getUserId() {
    return 42;
  }

  public function getTransactionId() {
    return DB::select('select @transaction_id as id;')[0]->id;
  }

  public function auditRecords() {
    return $this->morphMany(AuditRecord::class, 'auditable');
  }

}
