<?php namespace Mvdstam\ArdentTranslatable;
  
  use LaravelBook\Ardent;
  use Dimsav\Translatable\Translatable;

  abstract class ArdentTranslatable extends Ardent {

    use Translatable {
      Translatable::save as translatableSave;
    }

    public function save(array $rules = array(),
    array $customMessages = array(),
    array $options = array(),
    Closure $beforeSave = null,
    Closure $afterSave = null)
    {
    if ($this->translatableSave($options))
    {
    return parent::save($rules, $customMessages, $options, $beforeSave, $afterSave);
    }
    return false;
    }

    public function getDirty() {
      $data = parent::getDirty();

      foreach($this->translations() as $translations) {
        $data += $translations->getDirty();
      }

      return $data;
    }

    public function getAttributes() {
        $data = parent::getAttributes();

        if ($this->translatedAttributes) {
          foreach($this->translatedAttributes as $field) {
            $data[$field] = $this->$field;
          }
        }

        return $data;
    }
  }