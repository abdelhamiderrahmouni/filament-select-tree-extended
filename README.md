# Filament Select Tree

[![Latest Version on Packagist](https://img.shields.io/packagist/v/abdelhamiderrahmouni/filament-select-tree-extended.svg?style=flat-square)](https://packagist.org/packages/abdelhamiderrahmouni/filament-select-tree-extended)
[![Total Downloads](https://img.shields.io/packagist/dt/abdelhamiderrahmouni/filament-select-tree-extended.svg?style=flat-square)](https://packagist.org/packages/abdelhamiderrahmouni/filament-select-tree-extended)

> **Notice:** This package is for my personal use, use it at your own risk!

This package adds a dynamic select tree field to your Laravel / Filament application, allowing you to create interactive hierarchical selection dropdowns based on relationships. It's handy for building selection dropdowns with various customization options.

![thumbnail](https://raw.githubusercontent.com/abdelhamiderrahmouni/filament-select-tree-extended/main/resources/images/thumbnail.jpg)

## Installation

You can install the package via composer:

```bash
composer require abdelhamiderrahmouni/filament-select-tree-extended
```

```bash
php artisan filament:assets
```

## Relationships

Use the tree for a `BelongsToMany` relationship

```PHP
SelectTree::make('categories')
    ->relationship('categories', 'name', 'parent_id')
```

Use the tree for a `BelongsTo` relationship

```PHP
SelectTree::make('category_id')
    ->relationship('category', 'name', 'parent_id')
```

## Custom Query

Customize the parent query

```PHP
SelectTree::make('categories')
    ->relationship(relationship: 'categories', titleAttribute: 'name', parentAttribute: 'parent_id', modifyQueryUsing: fn($query) => $query));
```

Customize the child query

```PHP
SelectTree::make('categories')
    ->relationship(relationship: 'categories', titleAttribute: 'name', parentAttribute: 'parent_id', modifyChildQueryUsing: fn($query) => $query));
```

## Methods

Set a custom placeholder when no items are selected

```PHP
->placeholder(__('Please select a category'))
```

Enable the selection of groups

```PHP
->enableBranchNode()
```

Customize the label when there are zero search results

```PHP
->emptyLabel(__('Oops, no results have been found!'))
```

Display the count of children alongside the group's name

```PHP
->withCount()
```

Keep the dropdown open at all times

```PHP
->alwaysOpen()
```

Set nodes as dependent

```PHP
->independent(false)
```

Expand the tree with selected values (only works if field is dependent)

```PHP
->expandSelected(false)
```

Set the parent's null value to -1, allowing you to use -1 as a sentinel value (default = null)

```PHP
->parentNullValue(-1)
```

All groups will be opened to this level

```PHP
->defaultOpenLevel(2)
```

Specify the list's force direction. Options include: auto (default), top, and bottom.

```PHP
->direction('top')
```

Display individual leaf nodes instead of the main group when all leaf nodes are selected

```PHP
->grouped(false)
```

Hide the clearable icon

```PHP
->clearable(false)
```

Activate the search functionality

```PHP
->searchable();
```

Disable specific options in the tree

```PHP
->disabledOptions([2, 3, 4])
```

Hide specific options in the tree

```PHP
->hiddenOptions([2, 3, 4])
```

Allow soft deleted items to be displayed

```PHP
->withTrashed()
```

Specify a different key for your model.
For example: you have id, code and parent_code. Your model uses id as key, but the parent-child relation is established between code and parent_code

```PHP
->withKey('code')
```

Store fetched models for additional functionality

```PHP
->storeResults()
```

Now you can access the results in `disabledOptions` or `hiddenOptions`

```PHP
->disabledOptions(function ($state, SelectTree $component) {
    $results = $component->getResults();
})
```

## Filters

Use the tree in your table filters. Here's an example to show you how.

```bash
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use AbdelhamidErrahmouni\FilamentSelectTreeExtended\SelectTree;
```

```php
->filters([
    Filter::make('tree')
        ->form([
            SelectTree::make('categories')
                ->relationship('categories', 'name', 'parent_id')
                ->independent(false)
                ->enableBranchNode(),
        ])
        ->query(function (Builder $query, array $data) {
            return $query->when($data['categories'], function ($query, $categories) {
                return $query->whereHas('categories', fn($query) => $query->whereIn('id', $categories));
            });
        })
        ->indicateUsing(function (array $data): ?string {
            if (! $data['categories']) {
                return null;
            }

            return __('Categories') . ': ' . implode(', ', Category::whereIn('id', $data['categories'])->get()->pluck('name')->toArray());
        })
])
```

## Screenshots
![example-1](https://raw.githubusercontent.com/abdelhamiderrahmouni/filament-select-tree-extended/main/resources/images/example-1.jpg)
![example-2](https://raw.githubusercontent.com/abdelhamiderrahmouni/filament-select-tree-extended/main/resources/images/example-2.jpg)
![example-3](https://raw.githubusercontent.com/abdelhamiderrahmouni/filament-select-tree-extended/main/resources/images/example-3.jpg)

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [AbdelhamidErrahmouni](https://github.com/abdelhamiderrahmouni)
- [Dipson88](https://github.com/dipson88/treeselectjs)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
