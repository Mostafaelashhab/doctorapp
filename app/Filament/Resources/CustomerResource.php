<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CustomerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Filament\Resources\CustomerResource\Pages\EditCustomer;
use App\Filament\Resources\CustomerResource\Pages\CreateCustomer;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Customer Details')
                    ->schema([
                        TextInput::make('name'),
                        FileUpload::make('image')->rules(['image', 'max:1024']),
                        TextInput::make('email')->email()->required()->rules([
                            'required',
                            'string',

                        ])->hiddenOn(CreateCustomer::class),
                        TextInput::make('email')->email()->required()->rules([
                            'required',
                            'string',
                            Rule::unique('customers', 'email')->ignore(request()->route('customer')),
                        ])->hiddenOn(EditCustomer::class),
                        TextInput::make('phone')->required()->tel()->rules([
                            'required',
                            'string',
                            Rule::unique('customers', 'phone')->ignore(request()->route('customer')),
                        ])->hiddenOn(EditCustomer::class),
                        TextInput::make('phone')->tel()->rules([
                            'required',
                            'string',

                        ])->hiddenOn(CreateCustomer::class),
                        TextInput::make('password')->password()->required()->rules(['required', 'min:8'])->dehydrateStateUsing(fn($state) => Hash::make($state))->hiddenOn(Pages\EditCustomer::class),
                        TextInput::make('password')->dehydrateStateUsing(fn($state) => Hash::make($state))->hiddenOn(Pages\CreateCustomer::class)->default(null)->password(),
                        TextInput::make('address'),
                        TextInput::make('height')->numeric()->prefix('cm'),
                        TextInput::make('weight')->numeric()->prefix('kg'),
                        Textarea::make('status')->label('Health Status'),
                        Textarea::make('health_goal')->label('Health Goal'),
                        Select::make('blood_type')->options([
                            'A+' => 'A+',
                            'B+' => 'B+',
                            'AB+' => 'AB+',
                            'O+' => 'O+',
                            'A-' => 'A-',
                            'B-' => 'B-',
                            'AB-' => 'AB-',
                            'O-' => 'O-',
                            'Other' => 'Other',
                        ]),
                        Select::make('gender')->options([
                            'male' => 'Male',
                            'female' => 'Female',
                        ]),
                        TextInput::make('age')->numeric(),
                        DatePicker::make('birth_day'),
                        TextInput::make('point_booking')->default(500)->readOnly(true),
                        TextInput::make('point_refaral')->default(0)->readOnly(true),
                        TextInput::make('point_shop')->default(0)->readOnly(true),
                        TextInput::make('wallet_balance')->default(0)->readOnly(true),
                        TextInput::make('referal_code')->default(rand('100000', '999999'))->readOnly(true),
                        TextInput::make('code')->default(rand('100000', '999999'))->readOnly(true),
                        // TextInput::make('is_active'),

                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('gender'),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
