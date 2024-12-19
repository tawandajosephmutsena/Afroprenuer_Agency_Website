<?php

namespace App\Filament\Resources\LeadResource\Actions;

use App\Models\Lead;
use App\Models\Client;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;

class MoveToClientsAction extends Action
{
    public static function make(?string $name = null): static
    {
        return parent::make($name ?? 'move_to_clients')
            ->label('Convert to Client')
            ->color('success')
            ->icon('heroicon-o-arrows-right-left')
            ->action(function (Lead $record) {
                \DB::transaction(function () use ($record) {
                    $full_name = trim(($record->first_name ?? '') . ' ' . ($record->second_name ?? ''));

                    if (!$full_name) {
                        throw new \Exception('The full name cannot be empty.');
                    }

                    $client = Client::create([
                        'name' => $full_name, // Ensure this maps to the required 'name' column
                        'email' => $record->email,
                        'phone' => $record->phone,
                    ]);

                    // Update the lead's status to converted and link the client
                    $record->update([
                        'converted_to_client_id' => $client->id,
                        'status' => 'converted',
                    ]);

                    // Delete the lead after conversion
                    $record->delete(); // Soft delete if `SoftDeletes` is used, otherwise hard delete
                });

                Notification::make()
                    ->success()
                    ->title('Lead Converted')
                    ->body('Lead has been successfully converted to a client and deleted.')
                    ->send();
            })
            ->requiresConfirmation()
            ->modalHeading('Convert Lead to Client')
            ->modalDescription('Are you sure you want to convert this lead to a client? This action is irreversible.')
            ->modalSubmitActionLabel('Yes, Convert and Delete');
    }
}