<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('project_name')
                    ->label('Project Name')
                    ->required(),
                TextInput::make('year')
                    ->numeric()
                    ->required(),
                Textarea::make('description')
                    ->rows(5)
                    ->columnSpan(2),
                Select::make('company_id')
                    ->label('Company Name')
                    ->relationship('company', 'alias'),
                TextInput::make('url')
                    ->label('URL'),
                Select::make('skills')
                    ->multiple()
                    ->label('Tech Stack')
                    ->relationship('skills', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project_name')
                    ->label('Project Name'),
                TextColumn::make('year'),
                TextColumn::make('description')
                    ->limit(30),
                TextColumn::make('company.company_name')
                    ->label('Company'),
                TextColumn::make('url')
                    ->label('URL'),
                TextColumn::make('skills.name')
                    ->badge()
                    ->color('success')
                    ->label('Tech Stack'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
