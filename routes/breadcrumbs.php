<?php

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
  $trail->push('Edit Item', route('items.edit', getParam($item->id)));
});

// Items / Create Item
Breadcrumbs::for('items.create', function($trail)
{
  $trail->parent('items.index');
  $trail->push('Create Item', route('items.create'));
});

/*
|--------------------------------------------------------------------------
| Preservation Instances
|--------------------------------------------------------------------------
*/

// Instances
Breadcrumbs::for('instances.index', function($trail)
{
  $trail->push('Instances', route('instances.index'));
});

// Instances / View Instance
Breadcrumbs::for('instances.show', function($trail, $instance)
{
  $trail->parent('instances.index');
  $trail->push('View Preservation Instance', route('instances.show', $instance->id));
});

// Instances / Edit Instance
Breadcrumbs::for('instances.edit', function($trail, $instance)
{
  $trail->parent('instances.index');
  $trail->push('Edit Preservation Instance', route('instances.edit', getParam($instance->id)));
});

// Instances / View Instance / View Cut
Breadcrumbs::for('instances.cuts.show', function($trail, $instance, $cut)
{
  $trail->parent('instances.show', $instance);
  $trail->push('View Cut', route('cuts.show', [$instance->id, $cut->id]));
});

// Instances / View Instance / Edit Cut
Breadcrumbs::for('instances.cuts.edit', function($trail, $instance, $cut)
{
  $trail->parent('instances.show', $instance);
  $trail->push('Edit Cut', route('cuts.edit', [$instance->id, $cut->id]));
});

// Instances / View Instance / Create Cut
Breadcrumbs::for('instances.cuts.create', function($trail, $instance)
{
  $trail->parent('instances.show', $instance);
  $trail->push('Create Cut', route('cuts.create', $instance->id));
});

// Instances / Create Instance
Breadcrumbs::for('instances.create', function($trail)
{
  $trail->parent('instances.index');
  $trail->push('Create Preservation Instance', route('instances.create'));
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
  $trail->push('Edit Transfer', route('transfers.edit', getParam($transfer->id)));
});

// Transfers / Create Transfer
Breadcrumbs::for('transfers.create', function($trail)
{
  $trail->parent('transfers.index');
  $trail->push('Create Transfer', route('transfers.create'));
});

if (! function_exists('getParam')) {
  function getParam($id) {
    // if there is no ID, it's a batch edit
    return $id ?? 'batch';
  }
}


