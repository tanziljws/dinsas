<?php

namespace App\Filament\Resources\PerjalananDinasResource\Pages;

use App\Exports\PerjalananDinasExport;
use App\Filament\Resources\PerjalananDinasResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class ListPerjalananDinas extends ListRecords
{
    protected static string $resource = PerjalananDinasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): ?Builder
    {
        $query = parent::getTableQuery();

        if ($jenis = request()->query('filter_jenis')) {
            $query->where('jenis', $jenis);
        }

        return $query;
    }
}
