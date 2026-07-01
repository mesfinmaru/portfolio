<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    // ─── POST /api/portfolio/skills ───────────────────────────────────────────

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category'   => 'required|in:languages,infrastructure',
            'icon'       => 'required|string|max:100',
            'iconColor'  => 'required|string|max:30',
            'label'      => 'required|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $skill = Skill::create([
            'category'   => $validated['category'],
            'icon'       => $validated['icon'],
            'icon_color' => $validated['iconColor'],
            'label'      => $validated['label'],
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return response()->json($skill->toVueArray(), 201);
    }

    // ─── PUT /api/portfolio/skills/{skill} ────────────────────────────────────

    public function update(Request $request, Skill $skill): JsonResponse
    {
        $validated = $request->validate([
            'icon'       => 'sometimes|required|string|max:100',
            'iconColor'  => 'sometimes|required|string|max:30',
            'label'      => 'sometimes|required|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $skill->update([
            'icon'       => $validated['icon']       ?? $skill->icon,
            'icon_color' => $validated['iconColor']  ?? $skill->icon_color,
            'label'      => $validated['label']      ?? $skill->label,
            'sort_order' => $validated['sort_order'] ?? $skill->sort_order,
        ]);

        return response()->json($skill->fresh()->toVueArray());
    }

    // ─── DELETE /api/portfolio/skills/{skill} ─────────────────────────────────

    public function destroy(Skill $skill): JsonResponse
    {
        $skill->delete();

        return response()->json(['message' => 'Skill deleted.']);
    }
}