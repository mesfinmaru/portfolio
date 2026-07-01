<?php

namespace App\Http\Controllers;

use App\Models\PortfolioSetting;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    // ─── Default data (used as fallback if DB rows don't exist yet) ──────────

    private function defaultHero(): array
    {
        return [
            'name'          => 'Mesfin Maru',
            'roles'         => [
                'Information Systems Student',
                'Full-Stack Software Developer',
                'System Architecture Enthusiast',
            ],
            'bio'           => 'Software developer based in Ethiopia, specializing in Information Systems. Engineered modular platforms, core APIs, and decoupled application architectures.',
            'available'     => true,
            'availableText' => 'Available for work & freelance',
            'profileImage'  => '/me.jpg',
            'profileFallback' => 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png',
            'logoImage'     => '/logo.png',
            'picTag'        => 'mes<span>.dev</span>',
        ];
    }

    private function defaultAbout(): array
    {
        return [
            'paragraphs' => [
                'I am a system builder focused on structuring data workflows. Studying Information Systems at Debre Berhan University has allowed me to map operational patterns directly to secure software frameworks.',
                'My learning tenure involves providing enterprise automation architectures, structural dashboard configurations, and robust transactional software tools for global standard projects.',
            ],
            'chips' => [
                ['label' => 'Base Location', 'value' => 'Ethiopia'],
                ['label' => 'Department',    'value' => 'Information Systems'],
            ],
            'timeline' => [
                ['id' => 1, 'date' => '2024 - Present', 'title' => 'Software Developer',    'desc' => 'Writing custom script pipelines, integration APIs, and database routing layers.'],
                ['id' => 2, 'date' => '2023 - 2024',    'title' => 'System Layout Planner', 'desc' => 'Modeled simulation frameworks, network logic maps, and factory process diagrams.'],
            ],
        ];
    }

    private function defaultContact(): array
    {
        return [
            'email'         => 'mesfinmaru121@gmail.com',
            'university'    => 'Debre Berhan University, IS Department',
            'phone'         => '+251 92 008 9841',
            'phoneRaw'      => '+251920089841',
            'github'        => 'https://github.com/mesfinmaru',
            'linkedin'      => 'https://www.linkedin.com/in/mesfinmaru',
            'telegram'      => 'https://t.me/mesfinmaru',
            'copyrightName' => 'Mesfin Maru',
            'copyrightYear' => 2026,
        ];
    }

    // ─── GET /api/portfolio ───────────────────────────────────────────────────

    public function index(): JsonResponse
    {
        // Sections
        $hero    = PortfolioSetting::getSection('hero')    ?? $this->defaultHero();
        $about   = PortfolioSetting::getSection('about')   ?? $this->defaultAbout();
        $contact = PortfolioSetting::getSection('contact') ?? $this->defaultContact();

        // Projects
        $projects = Project::orderBy('sort_order')->orderBy('id')
            ->get()
            ->map(fn($p) => $p->toVueArray())
            ->values()
            ->toArray();

        // Skills grouped by category
        $allSkills = Skill::orderBy('sort_order')->orderBy('id')->get();
        $skills = [
            'languages'      => $allSkills->where('category', 'languages')->map(fn($s) => $s->toVueArray())->values()->toArray(),
            'infrastructure' => $allSkills->where('category', 'infrastructure')->map(fn($s) => $s->toVueArray())->values()->toArray(),
        ];

        return response()->json(compact('hero', 'about', 'projects', 'skills', 'contact'));
    }

    // ─── PUT /api/portfolio/hero ──────────────────────────────────────────────

    public function updateHero(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:100',
            'bio'           => 'required|string',
            'roles'         => 'required|array',
            'roles.*'       => 'string',
            'available'     => 'boolean',
            'availableText' => 'nullable|string|max:100',
            'profileImage'  => 'nullable|string|max:255',
            'picTag'        => 'nullable|string|max:100',
        ]);

        $data = PortfolioSetting::setSection('hero', $validated);

        return response()->json($data);
    }

    // ─── PUT /api/portfolio/about ─────────────────────────────────────────────

    public function updateAbout(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'paragraphs'     => 'required|array',
            'paragraphs.*'   => 'string',
            'chips'          => 'required|array',
            'chips.*.label'  => 'required|string',
            'chips.*.value'  => 'required|string',
            'timeline'       => 'required|array',
            'timeline.*.id'    => 'required',
            'timeline.*.date'  => 'required|string',
            'timeline.*.title' => 'required|string',
            'timeline.*.desc'  => 'required|string',
        ]);

        $data = PortfolioSetting::setSection('about', $validated);

        return response()->json($data);
    }

    // ─── PUT /api/portfolio/contact ───────────────────────────────────────────

    public function updateContact(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email'         => 'required|email',
            'university'    => 'nullable|string|max:255',
            'phone'         => 'nullable|string|max:30',
            'phoneRaw'      => 'nullable|string|max:30',
            'github'        => 'nullable|url|max:255',
            'linkedin'      => 'nullable|url|max:255',
            'telegram'      => 'nullable|url|max:255',
            'copyrightName' => 'nullable|string|max:100',
            'copyrightYear' => 'nullable|integer|min:2000|max:2100',
        ]);

        $data = PortfolioSetting::setSection('contact', $validated);

        return response()->json($data);
    }
}