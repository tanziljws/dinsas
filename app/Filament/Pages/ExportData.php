<?php

namespace App\Filament\Pages;

use App\Exports\PerjalananDinasExport;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;

class ExportData extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';

    protected static ?string $navigationLabel = 'Export Data';

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?string $title = 'Export Data Perjalanan Dinas';

    protected static string $view = 'filament.pages.export-data';

    protected static ?int $navigationSort = 3;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('startDate')
                    ->label('Tanggal Mulai')
                    ->required(),
                DatePicker::make('endDate')
                    ->label('Tanggal Akhir')
                    ->required()
                    ->afterOrEqual('startDate'),
                \Filament\Forms\Components\Select::make('jenis')
                    ->label('Jenis Perjalanan')
                    ->options([
                        'Semua' => 'Semua',
                        'Dalam Kota' => 'Dalam Kota',
                        'Luar Kota' => 'Luar Kota',
                    ])
                    ->default('Semua')
                    ->required(),
            ])
            ->statePath('data');
    }

    public function export()
    {
        $data = $this->form->getState();

        Notification::make()
            ->title('Export berhasil')
            ->success()
            ->send();

        return Excel::download(
            new PerjalananDinasExport($data['startDate'], $data['endDate'], $data['jenis']),
            'laporan-perjalanan-dinas-' . now()->timestamp . '.xlsx'
        );
    }
}
