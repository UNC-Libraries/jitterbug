<?php namespace Junebug\Export;

use Auth;
use Log;
use DateTime;
use DateTimeZone;

abstract class Export {
  
  private $fields = null;

  /**
   * Create a new export instance.
   *
   * @return void
   */
  public function __construct()
  {

  }

  public function build($selectedFields)
  {
    // Create the export file
    $fileDir = base_path() . '/storage/app/downloads';
    $fileName = Auth::user()->username . '-' . 
      $this->exportClass . 's-' . fileTimestamp() . '.csv';
    $filePath = $fileDir . '/' . $fileName;
    $handle = fopen($filePath, 'w+');

    // Get headings for the selected fields and write to file
    $fields = $this->exportableFields();
    $fields = array_merge($fields[0], $fields[1]);
    $headings = array();
    foreach ($selectedFields as $field) {
      $heading = array_search($field, $fields);
      $heading = str_replace(' ', '', $heading);
      array_push($headings, $heading);
    }
    fputcsv($handle, $headings);

    // For some bizarre reason that only the PHP gods know,
    // we have to copy the export class from the subclass
    // into a *local* variable (instead of just using it 
    // directly in the next line) or the very next line will
    // throw the exception: 
    // 'syntax error, unexpected '::' (T_PAAMAYIM_NEKUDOTAYIM)'
    // https://philsturgeon.uk/php/2013/09/09/t-paamayim-nekudotayim-v-sanity/
    $class = $this->exportClass;
    $records = $class::whereIn('id', $this->ids)->get();
    foreach ($records as $record) {
      $attributes = $this->getSnakeAttributes($record);
      $line = array();
      foreach ($selectedFields as $fieldName) {
        $fieldValue = null;
        if (array_key_exists($fieldName, $attributes)) {
          $fieldValue = $this->getFieldValue($record, $fieldName);
        } else {
          $subclass = $record->subclass;
          $fieldValue = $this->getFieldValue($subclass, $fieldName);
        }
        array_push($line, $fieldValue);
      }
      fputcsv($handle, $line);
    }

    fclose($handle);

    return $filePath;
  }

  private function getFieldValue($model, $fieldName)
  {
    $fieldValue = null;
    if ($this->isForeignKey($fieldName)) {
      $fieldWithoutId = 
        substr($fieldName, 0, strlen($fieldName) - strlen("_id"));
      $relation = camel_case($fieldWithoutId);
      // Check for a relation method
      if(method_exists($model, $relation)) {
        $fieldValue = $model->$relation->identifiableName();
      } else {
        $fieldValue = $model->$fieldName;
      }
    } else if ($this->hasDisplayAccessor($model, $fieldName)) {
      $accessor = $this->displayAccessorFor($fieldName);
      $fieldValue = $model->$accessor(null);
    } else {
      $fieldValue = $model->$fieldName;
    }
    return $fieldValue;
  }

  private function hasDisplayAccessor($model, $fieldName)
  {
    return method_exists($model, $this->displayAccessorFor($fieldName));
  }

  private function displayAccessorFor($fieldName)
  {
    return 'get' . studly_case($fieldName) . 'DisplayAttribute';
  }

  private function getSnakeAttributes($model)
  {
    return $model->toSnakeCase($model->attributesToArray());
  }

  private function isForeignKey($fieldName)
  {
    return ends_with($fieldName, '_id');
  }

}
