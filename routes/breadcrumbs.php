<?php
use Illuminate\Support\Facades\Log;
/*
|--------------------------------------------------------------------------
| Audio Visual Items
|--------------------------------------------------------------------------
*/

// Items
Breadcrumbs::for('items.index', function($trail)
{
  $trail->push('Items', route('items.index'));
});

// Items / View Item
Breadcrumbs::for('items.show', function($trail, $item)
{
  $trail->parent('items.index');
  $trail->push('View Item', route('items.show', $item->id));
});

// Items / Edit Item
Breadcrumbs::for('items.edit', function($trail, $item)
{
  $trail->parent('items.index');
  $param = getParam($item->id);
  $trail->push('Edit Item', route('items.edit', $param));
});

// Items / Create Item
Breadcrumbs::for('items.create', function($trail)
{
  $trail->parent('items.index');
  $trail->push('Create Item', route('items.create'));
});

/*
|--------------------------------------------------------------------------
| Preservation Masters
|--------------------------------------------------------------------------
*/

// Masters
Breadcrumbs::for('masters.index', function($trail)
{
  $trail->push('Masters', route('masters.index'));
});

// Masters / View Master
Breadcrumbs::for('masters.show', function($trail, $master)
{
  $trail->parent('masters.index');
  $trail->push('View Master', route('masters.show', $master->id));
});

// Masters / Edit Master
Breadcrumbs::for('masters.edit', function($trail, $master)
{
  $trail->parent('masters.index');
  $param = getParam($master->id);
  $trail->push('Edit Master', route('masters.edit', $param));
});

// Masters / View Master / View Cut
Breadcrumbs::for('masters.cuts.show', function($trail, $master, $cut)
{
  $trail->parent('masters.show', $master);
  $trail->push('View Cut', route('masters.cuts.show', [$master->id, $cut->id]));
});

// Masters / View Master / Edit Cut
Breadcrumbs::for('masters.cuts.edit', function($trail, $master, $cut)
{
  $trail->parent('masters.show', $master);
  $trail->push('Edit Cut', route('masters.cuts.edit', [$master->id, $cut->id]));
});

// Masters / View Master / Create Cut
Breadcrumbs::for('masters.cuts.create', function($trail, $master)
{
  $trail->parent('masters.show', $master);
  $trail->push('Create Cut', route('masters.cuts.create', $master->id));
});

// Masters / Create Master
Breadcrumbs::for('masters.create', function($trail)
{
  $trail->parent('masters.index');
  $trail->push('Create Master', route('masters.create'));
});

/*
|--------------------------------------------------------------------------
| Transfers
|--------------------------------------------------------------------------
*/

// Transfers
Breadcrumbs::for('transfers.index', function($trail)
{
  $trail->push('Transfers', route('transfers.index'));
});

// Transfers / View Transfer
Breadcrumbs::for('transfers.show', function($trail, $transfer)
{
  $trail->parent('transfers.index');
  $trail->push('View Transfer', route('transfers.show', $transfer->id));
});

// Transfers / Edit Transfer
Breadcrumbs::for('transfers.edit', function($trail, $transfer)
{
  $trail->parent('transfers.index');
  $param = getParam($transfer->id);
  $trail->push('Edit Transfer', route('transfers.edit', $param));
});

// Transfers / Create Transfer
Breadcrumbs::for('transfers.create', function($trail)
{
  $trail->parent('transfers.index');
  $trail->push('Create Transfer', route('transfers.create'));
});

function getParam($id) {
  // if there is no ID, it's a batch edit
  return $id ?? 'batch';
}

