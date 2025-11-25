<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class RecurringTaskTemplateController extends Controller
{
    public function recurring(): Response
    {
        return Inertia::render('recurring/Recurring', []);
    }
}
