<?php

/*
|--------------------------------------------------------------------------
| Audio Visual Items
|--------------------------------------------------------------------------
*/

// Items
Breadcrumbs::register('items.index', function($breadcrumbs)
{
    $breadcrumbs->push('Items', route('items.index'));
});

// Items / View Item
Breadcrumbs::register('items.show', function($breadcrumbs, $item)
{
    $breadcrumbs->parent('items.index');
    $breadcrumbs->push('View Item', route('items.show', $item->id));
});

// Items / Edit Item
Breadcrumbs::register('items.edit', function($breadcrumbs, $item)
{
    $breadcrumbs->parent('items.index');
    $breadcrumbs->push('Edit Item', route('items.edit', $item->id));
});

// Items / Create Item
Breadcrumbs::register('items.create', function($breadcrumbs, $item)
{
    $breadcrumbs->parent('items.index');
    $breadcrumbs->push('Create Item', route('items.create', $item->id));
});

/*
|--------------------------------------------------------------------------
| Preservation Masters
|--------------------------------------------------------------------------
*/

// Masters
Breadcrumbs::register('masters.index', function($breadcrumbs)
{
    $breadcrumbs->push('Masters', route('masters.index'));
});

// Masters / View Master
Breadcrumbs::register('masters.show', function($breadcrumbs, $master)
{
    $breadcrumbs->parent('masters.index');
    $breadcrumbs->push('View Master', route('masters.show', $master->id));
});

// Masters / Edit Master
Breadcrumbs::register('masters.edit', function($breadcrumbs, $master)
{
    $breadcrumbs->parent('masters.index');
    $breadcrumbs->push('Edit Master', route('masters.edit', $master->id));
});

// Masters / View Master / View Cut
Breadcrumbs::register('masters.cuts.show', function($breadcrumbs, $master, $cut)
{
    $breadcrumbs->parent('masters.show', $master);
    $breadcrumbs->push('View Cut', route('masters.cuts.show', [$master->id, $cut->id]));
});

// Masters / Create Master
Breadcrumbs::register('masters.create', function($breadcrumbs, $master)
{
    $breadcrumbs->parent('masters.index');
    $breadcrumbs->push('Create Master', route('masters.create', $master->id));
});

/*
|--------------------------------------------------------------------------
| Transfers
|--------------------------------------------------------------------------
*/

// Transfers
Breadcrumbs::register('transfers.index', function($breadcrumbs)
{
    $breadcrumbs->push('Transfers', route('transfers.index'));
});

// Transfers / View Transfer
Breadcrumbs::register('transfers.show', function($breadcrumbs, $transfer)
{
    $breadcrumbs->parent('transfers.index');
    $breadcrumbs->push('View Transfer', route('transfers.show', $transfer->id));
});

// Transfers / Edit Transfer
Breadcrumbs::register('transfers.edit', function($breadcrumbs, $transfer)
{
    $breadcrumbs->parent('masters.index');
    $breadcrumbs->push('Edit Transfer', route('transfers.edit', $transfer->id));
});

// Transfers / Create Transfer
Breadcrumbs::register('transfers.create', function($breadcrumbs, $transfer)
{
    $breadcrumbs->parent('transfers.index');
    $breadcrumbs->push('Create Transfer', route('transfers.create', $transfer->id));
});

