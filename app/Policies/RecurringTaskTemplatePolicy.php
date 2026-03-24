<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\RecurringTaskTemplate;
use App\Models\User;

class RecurringTaskTemplatePolicy
{
    public function update(User $user, RecurringTaskTemplate $template): bool
    {
        return $template->user_id === $user->id;
    }

    public function delete(User $user, RecurringTaskTemplate $template): bool
    {
        return $template->user_id === $user->id;
    }

    public function materialize(User $user, RecurringTaskTemplate $template): bool
    {
        return $template->user_id === $user->id;
    }
}
