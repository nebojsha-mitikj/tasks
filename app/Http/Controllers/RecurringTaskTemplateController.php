<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\RecurringTaskTemplate;
use Inertia\Inertia;
use Inertia\Response;

class RecurringTaskTemplateController extends Controller
{
    public function recurring(): Response
    {
        return Inertia::render('recurring/Recurring', [
            'templates' => RecurringTaskTemplate::query()
                ->with('labels', 'periods')
                ->where('user_id', auth()->user()->id)
                ->orderBy('priority', 'desc')
                ->orderBy('created_at', 'desc')
                ->get()
        ]);
    }
}
