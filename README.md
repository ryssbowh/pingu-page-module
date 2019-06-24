# Page module

Tools to create simple landing pages, define regions for them, and assign blocks to those regions.

Provides a block api to easily define new type of blocks.

## v2.0.0

## v1.1.3
- adapted to Core Contracts renaming
- give perms to admin at install
- added docs

## v1.1.2
- renamed all api to ajax
- block use morphTo
- edit block functionnality

## v1.1
- refactored controllers
- added Routes/admin.php
- refactored routes with url slugs
- added pingu-page as js module
- adaptation to jsgrid refactoring
- adaptation to Model controller refactoring
- adaptation to Adminable interface
- added menu items in seeder
- 

## v1.0.12 Integrated permissions
## v1.0.10 First working version, added README

## TODO

- [ ] Define a model block provider

## Providers

Each block is saved in database with a record of its provider. A provider is a class implementing `BlockProviderContract` and using the trait `BlockProvidable`

This module provides with a simplistic 'Text' block provider.

To add a new provider, set up your tables as wanted and add a line in the table providers with the associated provider class.

## Pages

Each page has a layout, a url and a name.

## Layouts

Layouts can be added as any other model, once saved you can define regions for them.

## Regions

Blocks can be added to regions in the page 'blocks' contextual link in the back end

## Blocks

Each provider defined block has a generic block associated to it, this generic bock is saved in the table blocks.

It then defines a specific block in its own table, that can be retrieved using the `$block->instance` through [laravel morphing](https://laravel.com/docs/5.8/eloquent-relationships#polymorphic-relationships)