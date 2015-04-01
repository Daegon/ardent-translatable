<?php namespace Mvdstam\ArdentTranslatable;
  
  use LaravelBook\Ardent\Ardent;
  use Dimsav\Translatable\Translatable;

  abstract class ArdentTranslatable extends Ardent {

    use Translatable {
      Translatable::save as translatableSave;
    }

    protected static $debugBackTraceHashes = [];

    public function save(
      array $rules = array(),
      array $customMessages = array(),
      array $options = array(),
      Closure $beforeSave = null,
      Closure $afterSave = null
    ) {

      if ($this->translatableSave($options)) {
        return parent::save($rules, $customMessages, $options, $beforeSave, $afterSave);
      }

      return false;
    }

    public function getAttributes() {
        $data = parent::getAttributes();

        if ($this->translatedAttributes && $this->translatedAttributesNecessary()) {
          foreach($this->translatedAttributes as $field) {
            $data[$field] = $this->$field;
          }
        }

        return $data;
    }

    /**
     * Checks if the translated attributes (and thus an extra DB query)
     * is actually necessary or not.
     * 
     * @return boolean
     */
    protected function translatedAttributesNecessary() {
      foreach(debug_backtrace() as $trace) {
        if (
          $trace['function'] === 'cleanPivotAttributes'
        &&
          ($trace['object'] instanceof \Illuminate\Database\Eloquent\Relations\BelongsToMany)
        ) return false;
      }

      return true;
    }
  }