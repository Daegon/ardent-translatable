<?php namespace Mvdstam\ArdentTranslatable\Test\Model;

use Mvdstam\ArdentTranslatable\ArdentTranslatable;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Post extends ArdentTranslatable {

  public $translatedAttributes = array('name', 'slug');
  protected $fillable = ['name', 'email'];

  public static $rules = [
    'name' => 'required',
    'email' => 'required|email'
  ];
}