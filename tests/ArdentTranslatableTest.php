<?php

use Mvdstam\ArdentTranslatable\Test\Model\Post;
use Mvdstam\ArdentTranslatable\Test\Model\PostTranslation;

class ArdentTranslatableTest extends TestsBase {

  public function testMissingFieldForValidatedFieldTranslatedResultsInError() {
    $post = new Post([
      'email' => 'foo@faz.org'
    ]);

    $this->assertFalse($post->save());
    $this->assertCount(1, $post->errors());
    $this->assertEquals('validation.required', $post->errors()->getMessages()['name'][0]);
  }

  public function testIncorrectFieldForValidatedNonTranslatedFieldResultsInError() {
    $post = new Post([
      'name'  => 'faz',
      'email' => 'bar'
    ]);

    $this->assertFalse($post->save());
    $this->assertCount(1, $post->errors());
    $this->assertEquals('validation.email', $post->errors()->getMessages()['email'][0]);
  }

  public function testPostFromDataBaseHasCorrectTranslatedFields() {
    $success = with($p = new Post(['name' => 'faz', 'email' => 'faz@baz.org']))->save();

    $this->assertTrue($success);
    $this->assertEquals('faz', $p->name);

    $this->assertCount(1, $p->translations);
    $this->assertInstanceOf('Mvdstam\ArdentTranslatable\Test\Model\PostTranslation', $p->translations[0]);
  }
}