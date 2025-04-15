<?php

namespace App\Observers;

use App\Models\Role;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $users = User::whereHas('roles', function (Builder $query) {
            auth()->user()
                ? $query->where('level', '<=', auth()->user()->roles->last()->level)
                : $query->where('level', '<=', Role::LEVEL_ADMIN);
        })->get();

        Notification::make()
            ->title('Nuevo usuario')
            ->success()
            ->body('Se registro exitosamente un nuevo usuario.')
            ->sendToDatabase($users);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
