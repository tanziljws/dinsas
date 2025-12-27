<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PerjalananDinasResource\Pages;
use App\Models\PerjalananDinas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Support\Facades\Storage;

class PerjalananDinasResource extends Resource
{
    protected static ?string $model = PerjalananDinas::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Laporan Perjalanan Dinas';

    protected static ?string $modelLabel = 'Perjalanan Dinas';

    protected static ?string $pluralModelLabel = 'Laporan Perjalanan Dinas';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Laporan';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Guru')
                    ->schema([
                        Forms\Components\Select::make('guru_id')
                            ->label('Nama Guru')
                            ->relationship('guru', 'nama')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->disabled(),
                    ]),

                Forms\Components\Section::make('Data Pengikut')
                    ->description('Daftar pengikut perjalanan dinas')
                    ->schema([
                        Forms\Components\TagsInput::make('pengikut')
                            ->label('Nama Pengikut')
                            ->placeholder('Tambah nama pengikut')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Data Surat & Perjalanan')
                    ->schema([
                        Forms\Components\TextInput::make('nomor_surat')
                            ->label('Nomor Surat')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\DatePicker::make('tanggal_surat')
                            ->label('Tanggal Surat')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                        Forms\Components\DatePicker::make('tanggal_berangkat')
                            ->label('Tanggal Berangkat')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                        Forms\Components\Select::make('jenis')
                            ->label('Jenis Perjalanan Dinas')
                            ->options([
                                'Dalam Kota' => 'Dalam Kota',
                                'Luar Kota' => 'Luar Kota',
                            ])
                            ->required()
                            ->native(false),
                        Forms\Components\TextInput::make('lama')
                            ->label('Lama Perjalanan')
                            ->required()
                            ->placeholder('Contoh: 3 hari')
                            ->maxLength(50),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Data Kegiatan')
                    ->schema([
                        Forms\Components\Textarea::make('nama_kegiatan')
                            ->label('Nama Kegiatan')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('nama_instansi')
                            ->label('Nama Instansi/Tempat Kegiatan')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('alamat_instansi')
                            ->label('Alamat Instansi/Tempat Kegiatan')
                            ->required()
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('File Dokumen')
                    ->schema([
                        Forms\Components\FileUpload::make('file_path')
                            ->label('File PDF')
                            ->disk('public')
                            ->directory('uploads')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(10240)
                            ->downloadable()
                            ->openable()
                            ->previewable(false)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status Verifikasi')
                            ->options([
                                'Belum Dicek' => 'Belum Dicek',
                                'Sedang Diproses' => 'Sedang Diproses',
                                'Disetujui' => 'Disetujui',
                                'Ditolak' => 'Ditolak',
                            ])
                            ->required()
                            ->native(false)
                            ->default('Belum Dicek'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Personil column (always visible)
                Tables\Columns\TextColumn::make('guru.nama')
                    ->label('Personil')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->html()
                    ->formatStateUsing(function ($state, PerjalananDinas $record) {
                        $html = "<div>{$state}</div>";
                        if (!empty($record->pengikut) && is_array($record->pengikut)) {
                            $html .= '<ul class="mt-1 pl-0 list-none space-y-1">';
                            foreach ($record->pengikut as $pengikut) {
                                if (is_string($pengikut)) {
                                    $html .= "<li class='text-sm text-gray-500'>- {$pengikut}</li>";
                                }
                            }
                            $html .= '</ul>';
                        }
                        return $html;
                    }),

                // Nama Instansi (always visible)
                Tables\Columns\TextColumn::make('nama_instansi')
                    ->label('Nama Instansi')
                    ->searchable(),

                // --- CATEGORY TABS ONLY (Dalam/Luar Kota) ---
                Tables\Columns\TextColumn::make('lama')
                    ->label('Hari')
                    ->hidden(fn() => !request()->query('filter_jenis')),
                Tables\Columns\TextColumn::make('nominal')
                    ->label('Nominal')
                    ->money('IDR')
                    ->hidden(fn() => !request()->query('filter_jenis')),
                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->getStateUsing(function (PerjalananDinas $record) {
                        $hari = (int) preg_replace('/[^0-9]/', '', $record->lama ?? '0');
                        return $hari * ($record->nominal ?? 0);
                    })
                    ->hidden(fn() => !request()->query('filter_jenis')),
                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->color('gray')
                    ->hidden(fn() => !request()->query('filter_jenis')),

                // --- REKAP TAB ONLY ---
                Tables\Columns\TextColumn::make('nomor_surat')
                    ->label('No. Surat & Tgl')
                    ->searchable()
                    ->toggleable()
                    ->description(fn(PerjalananDinas $record): string => $record->created_at->format('d M Y H:i'))
                    ->hidden(fn() => request()->query('filter_jenis')),
                Tables\Columns\TextColumn::make('tanggal_berangkat')
                    ->label('Tgl Berangkat')
                    ->date('d M Y')
                    ->sortable()
                    ->hidden(fn() => request()->query('filter_jenis')),
                Tables\Columns\TextColumn::make('nama_kegiatan')
                    ->label('Kegiatan')
                    ->limit(30)
                    ->tooltip(fn(PerjalananDinas $record): string => $record->nama_kegiatan ?? '')
                    ->searchable()
                    ->hidden(fn() => request()->query('filter_jenis')),
                Tables\Columns\TextColumn::make('jenis')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Dalam Kota' => 'info',
                        'Luar Kota' => 'warning',
                        default => 'gray',
                    })
                    ->hidden(fn() => request()->query('filter_jenis')),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'Terkirim' => 'Terkirim',
                        'Diproses' => 'Diproses',
                        'Ditolak' => 'Ditolak',
                        'Sudah Dibayar' => 'Sudah Dibayar',
                    ]),
                Tables\Filters\SelectFilter::make('jenis')
                    ->label('Jenis Perjalanan')
                    ->options([
                        'Dalam Kota' => 'Dalam Kota',
                        'Luar Kota' => 'Luar Kota',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->hidden(fn() => request()->query('filter_jenis')),
                Tables\Actions\Action::make('edit_nominal')
                    ->label('Input Nominal')
                    ->icon('heroicon-o-currency-dollar')
                    ->color('warning')
                    ->modalHeading('Input Nominal & Kategori')
                    ->form([
                        Forms\Components\TextInput::make('nominal')
                            ->label('Nominal per Hari')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),
                        Forms\Components\Select::make('kategori')
                            ->label('Kategori')
                            ->options([
                                'Umum' => 'Umum',
                                'PKL PPLG' => 'PKL PPLG',
                                'PKL TKJ' => 'PKL TKJ',
                                'PKL TP' => 'PKL TP',
                                'PKL TO' => 'PKL TO',
                            ])
                            ->required(),
                    ])
                    ->fillForm(fn($record) => [
                        'nominal' => $record->nominal,
                        'kategori' => $record->kategori,
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'nominal' => $data['nominal'],
                            'kategori' => $data['kategori'],
                        ]);
                    })
                    ->visible(fn() => request()->query('filter_jenis')),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('set_diproses')
                        ->label('Diproses')
                        ->icon('heroicon-o-clock')
                        ->color('info')
                        ->requiresConfirmation()
                        ->modalHeading('Ubah Status ke Diproses')
                        ->modalDescription('Apakah Anda yakin ingin mengubah status menjadi Diproses?')
                        ->action(fn($record) => $record->update(['status' => 'Diproses']))
                        ->visible(fn($record) => $record->status === 'Terkirim'),
                    Tables\Actions\Action::make('set_sudah_dibayar')
                        ->label('Sudah Dibayar')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Ubah Status ke Sudah Dibayar')
                        ->modalDescription('Apakah Anda yakin pengajuan ini sudah dibayar?')
                        ->action(fn($record) => $record->update(['status' => 'Sudah Dibayar']))
                        ->visible(fn($record) => $record->status === 'Diproses'),
                ])->label('Aksi')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->color('gray')
                    ->size('sm')
                    ->dropdown(true),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada laporan perjalanan dinas')
            ->emptyStateDescription('Laporan akan muncul setelah guru mengisi form.');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Data Guru')
                    ->schema([
                        Infolists\Components\TextEntry::make('guru.nama')
                            ->label('Nama Pegawai'),
                        Infolists\Components\TextEntry::make('guru.nomor')
                            ->label('NIP'),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Data Pengikut')
                    ->schema([
                        Infolists\Components\TextEntry::make('pengikut')
                            ->label('Daftar Pengikut')
                            ->html()
                            ->formatStateUsing(function ($state) {
                                if (empty($state))
                                    return '<span class="text-gray-400 italic">Tidak ada pengikut</span>';

                                // Ensure state is an array
                                if (!is_array($state)) {
                                    $state = is_string($state) ? [$state] : (array) $state;
                                }

                                // Fetch NIPs for these names
                                $nips = \App\Models\Guru::whereIn('nama', $state)->pluck('nomor', 'nama');

                                $html = '<div class="flex flex-col gap-3">';
                                foreach ($state as $nama) {
                                    if (!is_string($nama))
                                        continue;
                                    $nip = $nips[$nama] ?? '-';
                                    $html .= "
                                        <div class='flex flex-col border-b border-gray-100 last:border-0 pb-2 last:pb-0'>
                                            <span class='font-medium text-gray-900'>{$nama}</span>
                                            <span class='text-xs text-gray-500'>NIP. {$nip}</span>
                                        </div>";
                                }
                                $html .= '</div>';
                                return $html;
                            })
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('Data Surat & Perjalanan')
                    ->schema([
                        Infolists\Components\TextEntry::make('nomor_surat')
                            ->label('Nomor Surat'),
                        Infolists\Components\TextEntry::make('tanggal_surat')
                            ->label('Tanggal Surat')
                            ->date('d M Y'),
                        Infolists\Components\TextEntry::make('tanggal_berangkat')
                            ->label('Tanggal Berangkat')
                            ->date('d M Y'),
                        Infolists\Components\TextEntry::make('jenis')
                            ->label('Jenis Perjalanan')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'Dalam Kota' => 'info',
                                'Luar Kota' => 'warning',
                                default => 'gray',
                            }),
                        Infolists\Components\TextEntry::make('lama')
                            ->label('Lama Perjalanan'),
                    ])
                    ->columns(3),

                Infolists\Components\Section::make('Data Kegiatan')
                    ->schema([
                        Infolists\Components\TextEntry::make('nama_kegiatan')
                            ->label('Nama Kegiatan')
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('nama_instansi')
                            ->label('Nama Instansi'),
                        Infolists\Components\TextEntry::make('alamat_instansi')
                            ->label('Alamat Instansi')
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('Status & File')
                    ->schema([
                        Infolists\Components\TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'Terkirim' => 'warning',
                                'Diproses' => 'info',
                                'Sudah Dibayar' => 'success',
                                'Ditolak' => 'danger',
                                default => 'gray',
                            }),
                        Infolists\Components\TextEntry::make('file_path')
                            ->label('File Dokumen')
                            ->formatStateUsing(fn($state) => $state ? 'Download PDF' : 'Tidak ada file')
                            ->url(fn($record) => $record->file_path ? Storage::url($record->file_path) : null)
                            ->openUrlInNewTab(),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Tanggal Submit')
                            ->dateTime('d M Y H:i'),
                    ])
                    ->columns(3),
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
            'index' => Pages\ListPerjalananDinas::route('/'),
            'create' => Pages\CreatePerjalananDinas::route('/create'),
            'view' => Pages\ViewPerjalananDinas::route('/{record}'),
            'edit' => Pages\EditPerjalananDinas::route('/{record}/edit'),
        ];
    }
}
