<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;

class DefaultOrganizationSeeder extends Seeder
{
    public function run(): void
    {
        // Cari akun admin lama sebagai pemilik organization default
        $ownerUser = User::where('role', 'admin')->first();

        $organization = Organization::firstOrCreate(
            ['slug' => 'amikom-event-hub'],
            [
                'name' => 'AmikomEventHub (Default)',
                'owner_user_id' => $ownerUser?->id,
                'status' => 'approved',
            ]
        );

        // Assign semua event lama yang belum punya organization
        Event::whereNull('organization_id')->update(['organization_id' => $organization->id]);

        // Assign admin lama ke organization default ini juga
        if ($ownerUser) {
            $ownerUser->update(['organization_id' => $organization->id]);
        }

        $this->command->info('Organization default dibuat, event & admin lama sudah diassign.');
    }
}