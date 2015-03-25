<?php namespace Mvdstam\ArdentTranslatable\Test\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class PostTranslation extends Eloquent {

    public $timestamps  = false;
    protected $fillable = ['name'];
}