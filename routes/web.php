<?php

use Jitterbug\Http\Controllers\CutsController;
use Illuminate\Support\Facades\Route;
use Jitterbug\Http\Controllers\Admin;
use Jitterbug\Http\Controllers\AlertsController;
use Jitterbug\Http\Controllers\Auth;
use Jitterbug\Http\Controllers\CallNumbersController;
use Jitterbug\Http\Controllers\DashboardController;
use Jitterbug\Http\Controllers\InstancesController;
use Jitterbug\Http\Controllers\ItemsController;
use Jitterbug\Http\Controllers\MarksController;
use Jitterbug\Http\Controllers\SuggestionsController;
use Jitterbug\Http\Controllers\TransfersController;

Route::get('/', function () {
    return redirect()->route('dashboard.index');
});

/*
|--------------------------------------------------------------------------
| Alerts
|--------------------------------------------------------------------------
*/

Route::get('alerts', [AlertsController::class, 'index']);
Route::delete('alerts', [AlertsController::class, 'destroy']);

/*
|--------------------------------------------------------------------------
| Suggestions
|--------------------------------------------------------------------------
*/

Route::prefix('suggestions')->group(function () {
    Route::get('recording-locations',
        [SuggestionsController::class, 'recordingLocations']);
    Route::get('speeds', [SuggestionsController::class, 'speeds']);
    Route::get('track-configurations',
        [SuggestionsController::class, 'trackConfigurations']);
    Route::get('audio-bases', [SuggestionsController::class, 'audioBases']);
    Route::get('film-elements', [SuggestionsController::class, 'filmElements']);
    Route::get('film-bases', [SuggestionsController::class, 'filmBases']);
});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::get('admin', [Admin\AdminController::class, 'index'])->name('admin.index');
Route::post('admin/make-admin', [Admin\AdminController::class, 'makeAdmin']);
Route::post('admin/remove-admin', [Admin\AdminController::class, 'removeAdmin']);
Route::get('users', [Admin\UsersController::class, 'index']);
Route::resource('collections',
    Admin\CollectionsController::class)->except('show', 'create', 'edit');
Route::resource('formats',
    Admin\FormatsController::class)->except('create', 'edit');
Route::resource('projects',
    Admin\ProjectsController::class)->except('show', 'create', 'edit');
Route::resource('vendors',
    Admin\VendorsController::class)->except('show', 'create', 'edit');
Route::resource('departments',
    Admin\DepartmentsController::class)->except('show', 'create', 'edit');
Route::resource('playback-machines',
    Admin\PlaybackMachinesController::class)->except('show', 'create', 'edit');
Route::resource('reproduction-machines',
    Admin\ReproductionMachinesController::class)->except('show', 'create', 'edit');
Route::resource('sampling-rates',
    Admin\SamplingRatesController::class)->except('show', 'create', 'edit');
Route::resource('pm-speeds',
    Admin\PmSpeedsController::class)->except('show', 'create', 'edit');
Route::resource('tape-brands',
    Admin\TapeBrandsController::class)->except('show', 'create', 'edit');
Route::resource('collection-types',
    Admin\CollectionTypesController::class)->except('show', 'create', 'edit');
Route::resource('prefixes',
    Admin\PrefixesController::class)->except('show', 'create', 'edit');
Route::post('prefixes/set-legacy-status', [Admin\PrefixesController::class, 'setLegacyStatus']);
Route::post('prefixes/remove-legacy-status', [Admin\PrefixesController::class, 'removeLegacyStatus']);
Route::post('formats/detach_prefixes', [Admin\FormatsController::class, 'detachPrefixes']);
Route::post('formats/attach_prefixes', [Admin\FormatsController::class, 'attachPrefixes']);
Route::post('users/inactivate', [Admin\UsersController::class, 'inactivate']);
Route::post('users/reactivate', [Admin\UsersController::class, 'reactivate']);

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('dashboard/marks-for-user', [DashboardController::class, 'marksForUser']);

/*
|--------------------------------------------------------------------------
| Marks
|--------------------------------------------------------------------------
*/

Route::post('marks', [MarksController::class, 'store'])->name('marks.store');
Route::delete('marks', [MarksController::class, 'destroy'])->name('marks.destroy');

/*
|--------------------------------------------------------------------------
| Audio Visual Items
|--------------------------------------------------------------------------
*/

Route::get('call-numbers/generate', [CallNumbersController::class, 'generate']);
Route::get('call-numbers/for-pm', [CallNumbersController::class, 'forPreservationInstance']);
Route::get('items/resolve-range', [ItemsController::class, 'resolveRange']);
Route::match(['post', 'get'], 'items/batch/edit',
    [ItemsController::class, 'batchEdit'])->name('items.batch.edit');
Route::put('items/batch',
    [ItemsController::class, 'batchUpdate'])->name('items.batch.update');
Route::delete('items/batch',
    [ItemsController::class, 'batchDestroy'])->name('items.batch.destroy');
Route::post('items/batch/export-fields',
    [ItemsController::class, 'batchExportFields'])->name('items.batch.export.fields');
Route::post('items/batch/export-build',
    [ItemsController::class, 'batchExportBuild'])->name('items.batch.export.build');
Route::post('items/batch/export-download',
    [ItemsController::class, 'batchExportDownload'])->name('items.batch.export.download');
Route::post('items/batch/audio-import-upload',
    [ItemsController::class, 'itemsImportUpload'])->name('items.batch.items.import.upload');
Route::post('items/batch/audio-import-execute',
    [ItemsController::class, 'itemsImportExecute'])->name('items.batch.items.import.execute');
Route::resource('items', ItemsController::class);

/*
|--------------------------------------------------------------------------
| Preservation Instances
|--------------------------------------------------------------------------
*/

Route::get('instances/resolve-range', [InstancesController::class, 'resolveRange']);
Route::match(['post', 'get'], 'instances/batch/edit',
    [InstancesController::class, 'batchEdit'])->name('instances.batch.edit');
Route::put('instances/batch',
    [InstancesController::class, 'batchUpdate'])->name('instances.batch.update');
Route::delete('instances/batch',
    [InstancesController::class, 'batchDestroy'])->name('instances.batch.destroy');
Route::post('instances/batch/export-fields',
    [InstancesController::class, 'batchExportFields'])->name('instances.batch.export.fields');
Route::post('instances/batch/export-build',
    [InstancesController::class, 'batchExportBuild'])->name('instances.batch.export.build');
Route::post('instances/batch/export-download',
    [InstancesController::class, 'batchExportDownload'])->name('instances.batch.export.download');
Route::resource('instances', InstancesController::class);

/*
|--------------------------------------------------------------------------
| Cuts
|--------------------------------------------------------------------------
*/
Route::resource('cuts', CutsController::class)->except('index');

/*
|--------------------------------------------------------------------------
| Transfers
|--------------------------------------------------------------------------
*/

Route::get('transfers/resolve-range', [TransfersController::class, 'resolveRange']);
Route::match(['post', 'get'], 'transfers/batch/edit',
    [TransfersController::class, 'batchEdit'])->name('transfers.batch.edit');
Route::put('transfers/batch',
    [TransfersController::class, 'batchUpdate'])->name('transfers.batch.update');
Route::delete('transfers/batch',
    [TransfersController::class, 'batchDestroy'])->name('transfers.batch.destroy');
Route::post('transfers/batch/export-fields',
    [TransfersController::class, 'batchExportFields'])->name('transfers.batch.export.fields');
Route::post('transfers/batch/export-build',
    [TransfersController::class, 'batchExportBuild'])->name('transfers.batch.export.build');
Route::post('transfers/batch/export-download',
    [TransfersController::class, 'batchExportDownload'])->name('transfers.batch.export.download');
Route::post('transfers/batch/audio-import-upload',
    [TransfersController::class, 'audioImportUpload'])->name('transfers.batch.audio.import.upload');
Route::post('transfers/batch/audio-import-execute',
    [TransfersController::class, 'audioImportExecute'])->name('transfers.batch.audio.import.execute');
Route::post('transfers/batch/video-import-upload',
    [TransfersController::class, 'videoImportUpload'])->name('transfers.batch.video.import.upload');
Route::post('transfers/batch/video-import-execute',
    [TransfersController::class, 'videoImportExecute'])->name('transfers.batch.video.import.execute');
Route::resource('transfers', TransfersController::class);

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('login', [Auth\LoginController::class, 'showLoginForm'])->name('loginForm');
Route::post('login', [Auth\LoginController::class, 'login'])->name('login');
Route::get('logout', [Auth\LoginController::class, 'logout'])->name('logout');
