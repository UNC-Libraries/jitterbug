<?php

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