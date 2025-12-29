<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreLabelRequest;
use App\Http\Requests\UpdateLabelRequest;
use App\Models\Label;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class LabelController extends Controller
{
    /**
     * Inertia props:
     *   labels: Collection<int, Label>
     *   Shared globally via AppServiceProvider::boot()
     */
    public function index(): Response
    {
        return Inertia::render('labels/Labels', []);
    }

    public function show(Label $label): Response
    {
        $label->load([
            'tasks' => fn ($query) => $query->whereDate('date', '>=', today())->orderBy('date')->with('labels')
        ]);
        return Inertia::render('labels/ShowLabel', [
            'label' => $label,
        ]);
    }

    public function destroy(Label $label): RedirectResponse
    {
        $label->delete();
        return redirect()
            ->route('labels.index')
            ->with('success', 'Label deleted successfully.');
    }

    public function update(UpdateLabelRequest $request, Label $label): RedirectResponse
    {
        $label->update($request->validated());
        return redirect()
            ->route('labels.index')
            ->with('success', 'Label updated successfully.');
    }

    public function store(StoreLabelRequest $request): RedirectResponse
    {
        $request->user()->labels()->create($request->validated());
        return redirect()
            ->route('labels.index')
            ->with('success', 'Label created successfully.');
    }
}
