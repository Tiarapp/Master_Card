<?php

namespace Tests\Unit;

use App\Http\Controllers\MastercardApprovalController;
use App\Http\Controllers\MastercardController;
use App\Models\Mastercard;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use ReflectionMethod;
use Tests\TestCase;

class MastercardApprovalTest extends TestCase
{
    private $storageRoot;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.connections.approval_test' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ],
            'database.default' => 'approval_test',
        ]);
        DB::setDefaultConnection('approval_test');
        $this->assertSame(':memory:', DB::connection()->getDatabaseName());

        Schema::create('mc', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode');
            $table->timestamps();
        });
        Schema::create('mastercard_approvals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mastercard_id');
            $table->string('original_name');
            $table->string('path');
            $table->string('mime_type');
            $table->timestamps();
        });

        $this->storageRoot = sys_get_temp_dir() . '/mc-approval-test-' . bin2hex(random_bytes(8));
        mkdir($this->storageRoot);
        config(['filesystems.disks.local.root' => $this->storageRoot]);
        Storage::forgetDisk('local');
    }

    protected function tearDown(): void
    {
        foreach (Storage::disk('local')->allFiles('mastercard-approvals') as $path) {
            Storage::disk('local')->delete($path);
        }
        if (is_dir($this->storageRoot . '/mastercard-approvals')) {
            rmdir($this->storageRoot . '/mastercard-approvals');
        }
        rmdir($this->storageRoot);
        DB::disconnect('approval_test');
        parent::tearDown();
    }

    private function callPrivate($object, $method, array $arguments)
    {
        $reflection = new ReflectionMethod($object, $method);
        $reflection->setAccessible(true);

        return $reflection->invokeArgs($object, $arguments);
    }

    public function test_upload_and_revision_copy_keep_original_files(): void
    {
        $controller = new MastercardController();
        $source = Mastercard::create(['kode' => 'MC1']);
        $request = Request::create('/', 'POST', [], [], [
            'approval_files' => [UploadedFile::fake()->createWithContent('approval.pdf', "%PDF-1.4\n%%EOF")],
        ]);

        $this->callPrivate($controller, 'validateApprovals', [$request]);
        $this->callPrivate($controller, 'saveApprovals', [$source, $request]);
        $original = $source->approvals()->firstOrFail();
        $this->assertTrue(Storage::disk('local')->exists($original->path));
        $this->assertSame('application/pdf', $original->mime_type);

        $revision = Mastercard::create(['kode' => 'MC1']);
        $this->callPrivate($controller, 'saveApprovals', [$revision, Request::create('/'), $source]);
        $copy = $revision->approvals()->firstOrFail();
        $this->assertNotSame($original->id, $copy->id);
        $this->assertSame($original->path, $copy->path);
        $this->assertSame($original->original_name, $copy->original_name);

        $response = (new MastercardApprovalController())->file($revision->id, $copy->id);
        $this->assertSame('application/pdf', $response->headers->get('Content-Type'));
    }

    public function test_invalid_file_is_rejected(): void
    {
        $request = Request::create('/', 'POST', [], [], [
            'approval_files' => [UploadedFile::fake()->createWithContent('approval.txt', 'not an approval')],
        ]);

        $this->expectException(ValidationException::class);
        $this->callPrivate(new MastercardController(), 'validateApprovals', [$request]);
    }

    public function test_jpeg_and_additional_revision_upload_are_supported(): void
    {
        $controller = new MastercardController();
        $source = Mastercard::create(['kode' => 'MC1']);
        $revision = Mastercard::create(['kode' => 'MC1']);
        $request = Request::create('/', 'POST', [], [], [
            'approval_files' => [UploadedFile::fake()->image('approval.jpg')],
        ]);

        $this->callPrivate($controller, 'validateApprovals', [$request]);
        $this->callPrivate($controller, 'saveApprovals', [$revision, $request, $source]);
        $approval = $revision->approvals()->firstOrFail();
        $this->assertSame('image/jpeg', $approval->mime_type);
        $this->assertTrue(Storage::disk('local')->exists($approval->path));
    }

    public function test_file_cannot_be_accessed_through_another_mastercard(): void
    {
        $source = Mastercard::create(['kode' => 'MC1']);
        $other = Mastercard::create(['kode' => 'MC2']);
        $approval = $source->approvals()->create([
            'original_name' => 'approval.pdf',
            'path' => 'mastercard-approvals/example.pdf',
            'mime_type' => 'application/pdf',
        ]);

        $this->expectException(ModelNotFoundException::class);
        (new MastercardApprovalController())->file($other->id, $approval->id);
    }

    public function test_file_larger_than_five_megabytes_is_rejected(): void
    {
        $file = UploadedFile::fake()->createWithContent('approval.pdf', "%PDF-1.4\n%%EOF")->size(5121);
        $request = Request::create('/', 'POST', [], [], ['approval_files' => [$file]]);

        $this->expectException(ValidationException::class);
        $this->callPrivate(new MastercardController(), 'validateApprovals', [$request]);
    }

    public function test_failed_transaction_removes_new_file_and_rolls_back_record(): void
    {
        $controller = new MastercardController();
        $mastercard = Mastercard::create(['kode' => 'MC1']);
        $request = Request::create('/', 'POST', [], [], [
            'approval_files' => [UploadedFile::fake()->createWithContent('approval.pdf', "%PDF-1.4\n%%EOF")],
        ]);

        try {
            $this->callPrivate($controller, 'withApprovalTransaction', [function () use ($controller, $mastercard, $request) {
                $this->callPrivate($controller, 'saveApprovals', [$mastercard, $request]);
                throw new \RuntimeException('Test rollback');
            }]);
            $this->fail('Transaksi seharusnya gagal.');
        } catch (\RuntimeException $exception) {
            $this->assertSame('Test rollback', $exception->getMessage());
        }

        $this->assertSame(0, $mastercard->approvals()->count());
        $this->assertSame([], Storage::disk('local')->allFiles('mastercard-approvals'));
    }
}
