<?php namespace Jitterbug\Export;

use Auth;

/**
 * Abstract base class for export types. Subclasses must define the 
 * exportableFields() method and 2 properties: an $exportClass property 
 * that specifies the base class to be exported, and an $ids property
 * that specifies the ids of the records (of type $exportClass) to 
 * be exported.
 *
 * This class assumes the specified $exportClass uses the 
 * Jitterbug\Models\CamelCasing trait, as it uses the toSnakeCase()
 * method for getting the attributes in snake case.
 * 
 * This class also assumes the specified $exportClass uses the
 * Venturecraft\Revisionable\RevisionableTrait trait, as it
 * uses the identifiableName() method/convention on relations to get
 * values for fields that are foreign keys.
 */
abstract class Export {
  
  private $fields = null;

  /**
   * Build the export file for the given selected fields, which should
   * be snake cased field names.
   *
   * @param array selectedFields 
   */
  public function build($selectedFields)
  {
    // Create the export file
    $fileDir = base_path() . '/storage/app/exports';
    $fileName = Auth::user()->username . '-' . 
      $this->exportClass . 's-' . fileTimestamp() . '.csv';
    $filePath = $fileDir . '/' . $fileName;
    $handle = fopen($filePath, 'w+');

    // Get headings for the selected fields and write to file
    $fields = $this->exportableFields();
    // Flatten the fields array
    $fields = array_merge($fields[0], $fields[1]);
    $headings = array();
    foreach ($selectedFields as $selectedField) {
      // Cuts are a special case field that represents its
      // own array of headings and fields, defined in a 
      // $cutExportFields variable.
      if ($selectedField === 'cut') {
        $cutHeadings = array_keys($this->cutExportFields);
        foreach ($cutHeadings as $heading) {
          $heading = str_replace(' ', '', $heading);
          array_push($headings, $heading);
        }
      } else {
        $heading = array_search($selectedField, $fields);
        // Remove the spaces from the heading labels
        $heading = str_replace(' ', '', $heading);
        array_push($headings, $heading);
      }
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
      $row = array();
      foreach ($selectedFields as $selectedField) {
        if ($selectedField === 'cut') {
          if (method_exists($record, 'cut') && $record->cut !== null) {
            $cut = $record->cut;
            $cutFields = array_values($this->cutExportFields);
            foreach ($cutFields as $cutField) {
              $fieldValue = $this->getFieldValue($cut, $cutField);
              array_push($row, $fieldValue);
            }
          }
        } else {
          $fieldValue = null;
          if (array_key_exists($selectedField, $attributes)) {
            $fieldValue = $this->getFieldValue($record, $selectedField);
          } else if (array_key_exists($selectedField, 
              $this->getSnakeAttributes($record->subclass))) {
            $subclass = $record->subclass;
            $fieldValue = $this->getFieldValue($subclass, $selectedField);
          }
          array_push($row, $fieldValue);
        }
      }
      fputcsv($handle, $row);
    }

    fclose($handle);

    return $filePath;
  }

  /**
   * Get the exportable fields for the specified $exportableClass.
   * The returned array should be an array of arrays: a top level array
   * that has 2 other arrays which correspond to a 2 column user
   * interface for the fields. The fields at array[0] will be rendered
   * on the left in the user interface, and the fields at array[1] will
   * be rendered on the right. Each contained array should be an 
   * associative array with keys that are the display name of the field
   * and values that are the field name. The order of the fields in
   * the user interface will be derived from the order of the fields in
   * the arrays.
   *
   * @return array
   */
  abstract public function exportableFields();

  /**
   * Get the value for the specified field from the specified model instance.
   *
   * @param mixed model
   * @param string fieldName
   */
  private function getFieldValue($model, $fieldName)
  {
    $fieldValue = null;
    if ($this->isForeignKey($fieldName)) {
      $fieldWithoutId = 
        substr($fieldName, 0, strlen($fieldName) - strlen("_id"));
      $relation = camel_case($fieldWithoutId);
      // Check for a relation method
      if(method_exists($model, $relation)) {
        $builder = $model->$relation;
        if ($builder !== null) {
          $fieldValue = $model->$relation->identifiableName();
        }
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
