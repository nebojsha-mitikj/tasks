<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function today(): Response
    {
        return Inertia::render('tasks/Today', []);
    }

    public function upcoming(): Response
    {
        return Inertia::render('tasks/Upcoming', []);
    }

    public function history(): Response
    {
        return Inertia::render('tasks/History', []);
    }
}
