<?php

namespace App\Filament\Resources\LoginActivityResource\Pages;

use App\Filament\Resources\LoginActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLoginActivity extends ViewRecord
{
    protected static string $resource = LoginActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
