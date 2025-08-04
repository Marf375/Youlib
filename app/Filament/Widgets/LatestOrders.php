<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use App\Models\Order;
use App\Models\User;
class LatestOrders extends BaseWidget
{
    public function table(Table $table): Table
    {
  
           return $table
           ->query(Order::query())
        ->columns([
           TextColumn::make('id'),
            TextColumn::make('user_id'),
            TextColumn::make('total_price'),
            TextColumn::make('created_at'),
            IconColumn::make('is_featured')
                ->boolean(),
        ])
        ->filters([
            Filter::make('is_featured')
                ->query(fn (Builder $query) => $query->where('is_featured', true)),
            SelectFilter::make('status')
                ->options([
                    'draft' => 'Draft',
                    'reviewing' => 'Reviewing',
                    'published' => 'Published',
                ]),
        ]);

    }
}
