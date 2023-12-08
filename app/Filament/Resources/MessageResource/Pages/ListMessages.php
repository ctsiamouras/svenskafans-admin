<?php

namespace App\Filament\Resources\MessageResource\Pages;

use App\Filament\Resources\MessageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMessages extends ListRecords
{
    protected static string $resource = MessageResource::class;

    public function mount(): void
    {
//        $test = $this->getResource()::authorizeResourceAccess();
//        $test = $this->getResource()::getUrl('index');
//        abort_unless(auth()->user()->canManageSettings(), 403);
        $test = true;
        abort_unless($test, 403);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }



//    public function filterForm()
//    {
//        return Filament\Forms\Components\Filter::make()
//            ->except(['reset']); // Exclude the reset option
//    }

}
