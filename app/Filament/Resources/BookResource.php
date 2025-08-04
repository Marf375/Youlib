<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Название')
                ->required(),

            TextInput::make('img')
                ->label('Обложка'),

            TextInput::make('price')
                ->numeric()
                ->label('Цена')
                ->required(),

            Textarea::make('description')
                ->label('Описание')
                ->rows(4),

            TextInput::make('copyright_holder')
                ->label('Правообладатель'),

            TextInput::make('rating')
                ->numeric()
                ->step(0.1)
                ->label('Рейтинг'),

            Select::make('type')
                ->options([
                    'comics' => 'comics',
                    'books' => 'books',
                    'audiobook' => 'Аудиокнига',
                ])
                ->label('Тип'),

            FileUpload::make('file_path') // имя поля в базе
            ->label('Файл книги')
                ->disk('s3') // используем Yandex Object Storage
                ->directory('books') // путь в бакете
                ->acceptedFileTypes(['application/pdf', 'application/epub+zip']) // только PDF и EPUB
                ->preserveFilenames() // сохраняет оригинальные имена файлов
                ->visibility('private') // чтобы не было публичного доступа
                ->helperText('Форматы: PDF, EPUB'),

            TextInput::make('year')
                ->numeric()
                ->label('Год'),

            TextInput::make('timer')
                ->numeric()
                ->default(0)
                ->label('Длительность (мин)')
                ->helperText('Для аудиокниг'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->label('Название'),
            TextColumn::make('price')->label('Цена')->money('rub'),
            TextColumn::make('year')->label('Год'),
            TextColumn::make('type')->label('Тип'),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit'   => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
