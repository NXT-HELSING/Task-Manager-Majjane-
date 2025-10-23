<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects;
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        // Enum in DB only accepts: 'active', 'on_hold', 'completed'
        // French labels for UI support (in case): 'Actif' => 'active', 'En pause' => 'on_hold', 'Terminé' => 'completed'
        $statusInput = $request->input('status');

        $statusMap = [
            'active'     => 'active',
            'on_hold'    => 'on_hold',
            'completed'  => 'completed',
            // French/legacy mappings
            'Actif'      => 'active',
            'En pause'   => 'on_hold',
            'Terminé'    => 'completed',
            // Fallback for old value after enum change
            'archived'   => 'on_hold', // archived → on_hold; disallow otherwise if stricter preferred
            'Archivé'    => 'on_hold',
        ];

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'nullable|date',
        ]);

        $data = $validated;

        // Set status with mapping and validation
        if ($statusInput && array_key_exists($statusInput, $statusMap)) {
            $data['status'] = $statusMap[$statusInput];
        } else {
            // Fallback to default to avoid enum error
            $data['status'] = 'active';
        }

        // Validate enum against allowed DB values
        if (!in_array($data['status'], ['active', 'on_hold', 'completed'])) {
            abort(422, "Invalid status value");
        }

        auth()->user()->projects()->create($data);

        return redirect()->route('projects.index')->with('success', 'Projet créé avec succès !');
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $statusInput = $request->input('status');
        $statusMap = [
            'active'     => 'active',
            'on_hold'    => 'on_hold',
            'completed'  => 'completed',
            'Actif'      => 'active',
            'En pause'   => 'on_hold',
            'Terminé'    => 'completed',
            'archived'   => 'on_hold',
            'Archivé'    => 'on_hold',
        ];

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required',
            'progress' => 'nullable|integer|min:0|max:100',
            'due_date' => 'nullable|date',
        ]);

        // Remap status if needed
        if ($statusInput && array_key_exists($statusInput, $statusMap)) {
            $validated['status'] = $statusMap[$statusInput];
        } else {
            $validated['status'] = 'active';
        }

        // Validate that status is one of the allowed enum values
        if (!in_array($validated['status'], ['active', 'on_hold', 'completed'])) {
            abort(422, "Invalid status value");
        }

        $project->update($validated);

        return redirect()->route('projects.show', $project)->with('success', 'Projet mis à jour avec succès !');
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Projet supprimé avec succès !');
    }

    public function assignedTasks()
    {
        $assignedTasks = auth()->user()->tasksAssigned()
            ->with(['project', 'assignee'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('projects.assigned-tasks', compact('assignedTasks'));
    }
}
