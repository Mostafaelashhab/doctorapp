<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Social;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SocialResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SocialResource\RelationManagers;
use Filament\Forms\Components\Fieldset;

class SocialResource extends Resource
{
    protected static ?string $model = Social::class;

    protected static ?string $navigationIcon = 'heroicon-o-hashtag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Social Details')
                    ->schema([
                        TextInput::make('link')->label('URL')->placeholder('https://www.example.com')->required(),
                        Select::make('type')->options(['facebook' => 'Facebook', 'instagram' => 'Instagram', 'linkedin' => 'Linkedin', 'tiktok' => 'Tiktok', 'youtube' => 'Youtube'])->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('tag'),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('link'),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListSocials::route('/'),
            'create' => Pages\CreateSocial::route('/create'),
            'edit' => Pages\EditSocial::route('/{record}/edit'),
        ];
    }
}
