<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jitterbug\Models\ImportTransaction;
use Jitterbug\Presenters\TransactionDigest;
use Venturecraft\Revisionable\Revision;

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
    $this->revision = factory(Revision::class)->create(['transaction_id' => $this->transactionId]);
  }
  /**
   * A basic unit test example.
   *
   * @return void
   */
  public function testAnalyzeRevisionsWithUpdateImport() : void
  {
    $this->importTransaction = factory(ImportTransaction::class)->create([
      'transaction_id' => $this->transactionId,
      'import_action' => 'update'
    ]);

    $transactionDigest = new TransactionDigest($this->transactionId);
    $this->assertEquals('updated via import', $transactionDigest->action);
  }

  public function testAnalyzeRevisionsWithCreateImport() : void
  {
    $this->importTransaction = factory(ImportTransaction::class)->create([
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
