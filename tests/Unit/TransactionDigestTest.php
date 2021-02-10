<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\ImportTransaction;
use Jitterbug\Presenters\TransactionDigest;
use Venturecraft\Revisionable\Revision;
use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\User;

class TransactionDigestTest extends TestCase
{
  use RefreshDatabase;
  private $transactionId;
  private $importTransaction;
  private $revision;

  protected function setUp() : void
  {
    parent::setUp();
    $this->transactionId = '12dh56kw345';
    // unable to use a factory for Revision as it's a model in a separate package
    $this->revision = new Revision;
    $this->revision->transaction_id = $this->transactionId;
    $this->revision->revisionable_type = 'AudioVisualItem';
    $this->revision->revisionable_id = AudioVisualItem::factory()->create()->id;
    $this->revision->user_id = User::factory()->create()->id;
    $this->revision->save();
  }
  /**
   * A basic unit test example.
   *
   * @return void
   */
  public function testAnalyzeRevisionsWithUpdateImport() : void
  {
    $this->importTransaction = ImportTransaction::factory()->create([
      'transaction_id' => $this->transactionId,
      'import_action' => 'update'
    ]);

    $transactionDigest = new TransactionDigest($this->transactionId);
    $this->assertEquals('updated via import', $transactionDigest->action);
  }

  public function testAnalyzeRevisionsWithCreateImport() : void
  {
    $this->importTransaction = ImportTransaction::factory()->create([
      'transaction_id' => $this->transactionId,
      'import_action' => 'create'
    ]);

    $transactionDigest = new TransactionDigest($this->transactionId);
    $this->assertEquals('created via import', $transactionDigest->action);
  }

  public function testAnalyzeRevisionsWithCreate() : void
  {
    $this->revision->field = 'created_at';
    $this->revision->save();

    $transactionDigest = new TransactionDigest($this->transactionId);
    $this->assertEquals('created', $transactionDigest->action);
  }

  public function testAnalyzeRevisionsWithUpdate() : void
  {
    $this->revision->field = 'content_description';
    $this->revision->save();

    $transactionDigest = new TransactionDigest($this->transactionId);
    $this->assertEquals('updated', $transactionDigest->action);
  }

  public function testAnalyzeRevisionsWithDelete() : void
  {
    $this->revision->field = 'deleted_at';
    $this->revision->save();

    $transactionDigest = new TransactionDigest($this->transactionId);
    $this->assertEquals('deleted', $transactionDigest->action);
  }
}
