<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // ─── POST /api/portfolio/projects ────────────────────────────────────────

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:200',
            'tags'        => 'nullable|array',
            'tags.*'      => 'string|max:50',
            'desc'        => 'required|string',
            'codeSnippet' => 'nullable|array',
            'linkType'    => 'required|in:github,docs,none',
            'linkUrl'     => 'nullable|url|max:500',
            'linkLabel'   => 'nullable|string|max:100',
            'sort_order'  => 'nullable|integer',
        ]);

        $project = Project::create([
            'title'        => $validated['title'],
            'tags'         => $validated['tags']        ?? [],
            'description'  => $validated['desc'],
            'code_snippet' => $validated['codeSnippet'] ?? [],
            'link_type'    => $validated['linkType'],
            'link_url'     => $validated['linkUrl']     ?? null,
            'link_label'   => $validated['linkLabel']   ?? null,
            'sort_order'   => $validated['sort_order']  ?? 0,
        ]);

        return response()->json($project->toVueArray(), 201);
    }

    // ─── PUT /api/portfolio/projects/{project} ────────────────────────────────

    public function update(Request $request, Project $project): JsonResponse
    {
        $validated = $request->validate([
            'title'       => 'sometimes|required|string|max:200',
            'tags'        => 'nullable|array',
            'tags.*'      => 'string|max:50',
            'desc'        => 'sometimes|required|string',
            'codeSnippet' => 'nullable|array',
            'linkType'    => 'sometimes|required|in:github,docs,none',
            'linkUrl'     => 'nullable|url|max:500',
            'linkLabel'   => 'nullable|string|max:100',
            'sort_order'  => 'nullable|integer',
        ]);

        $project->update([
            'title'        => $validated['title']       ?? $project->title,
            'tags'         => $validated['tags']        ?? $project->tags,
            'description'  => $validated['desc']        ?? $project->description,
            'code_snippet' => $validated['codeSnippet'] ?? $project->code_snippet,
            'link_type'    => $validated['linkType']    ?? $project->link_type,
            'link_url'     => $validated['linkUrl']     ?? $project->link_url,
            'link_label'   => $validated['linkLabel']   ?? $project->link_label,
            'sort_order'   => $validated['sort_order']  ?? $project->sort_order,
        ]);

        return response()->json($project->fresh()->toVueArray());
    }

    // ─── DELETE /api/portfolio/projects/{project} ─────────────────────────────

    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

        return response()->json(['message' => 'Project deleted.']);
    }
}