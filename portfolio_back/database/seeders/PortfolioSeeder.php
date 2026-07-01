<?php

namespace Database\Seeders;

use App\Models\PortfolioSetting;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        // ── Hero ──────────────────────────────────────────────────────────────
        PortfolioSetting::setSection('hero', [
            'name'            => 'Mesfin Maru',
            'roles'           => [
                'Information Systems Student',
                'Full-Stack Software Developer',
                'System Architecture Enthusiast',
            ],
            'bio'             => 'Software developer based in Ethiopia, specializing in Information Systems. Engineered modular platforms, core APIs, and decoupled application architectures.',
            'available'       => true,
            'availableText'   => 'Available for work & freelance',
            'profileImage'    => '/me.jpg',
            'profileFallback' => 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png',
            'logoImage'       => '/logo.png',
            'picTag'          => 'mes<span>.dev</span>',
        ]);

        // ── About ─────────────────────────────────────────────────────────────
        PortfolioSetting::setSection('about', [
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
        ]);

        // ── Contact ───────────────────────────────────────────────────────────
        PortfolioSetting::setSection('contact', [
            'email'         => 'mesfinmaru121@gmail.com',
            'university'    => 'Debre Berhan University, IS Department',
            'phone'         => '+251 92 008 9841',
            'phoneRaw'      => '+251920089841',
            'github'        => 'https://github.com/mesfinmaru',
            'linkedin'      => 'https://www.linkedin.com/in/mesfinmaru',
            'telegram'      => 'https://t.me/mesfinmaru',
            'copyrightName' => 'Mesfin Maru',
            'copyrightYear' => 2026,
        ]);

        // ── Projects ──────────────────────────────────────────────────────────
        $projects = [
            [
                'title'       => 'Debre Berhan Blanket Factory ERP',
                'tags'        => ['Odoo ERP', 'System Architecture'],
                'description' => 'Authored system architecture implementations and structured manufacturing workflows blueprints for factory optimization loops.',
                'code_snippet'=> [
                    ['n' => '1', 'html' => '<span class="cp-cm">&lt;!-- Odoo Cloud Custom Module --&gt;</span>'],
                    ['n' => '2', 'html' => '<span class="cp-kw">&lt;record</span> <span class="cp-ty">id=</span><span class="cp-st">"dbbf_workflow"</span><span class="cp-kw">&gt;</span>'],
                    ['n' => '3', 'html' => '  <span class="cp-kw">&lt;field</span> <span class="cp-ty">name=</span><span class="cp-st">"factory_code"</span><span class="cp-kw">&gt;</span>DBBF-BLANKET<span class="cp-kw">&lt;/field&gt;</span>'],
                    ['n' => '4', 'html' => '<span class="cp-kw">&lt;/record&gt;</span>'],
                ],
                'link_type'   => 'docs',
                'link_url'    => null,
                'link_label'  => 'Documentation',
                'sort_order'  => 1,
            ],
            [
                'title'       => 'Car Rental System',
                'tags'        => ['C#', '.NET Core API'],
                'description' => 'Architected a multi-tier management environment connecting decoupling desktop interfaces to an encrypted REST API service base.',
                'code_snippet'=> [
                    ['n' => '1', 'html' => '[<span class="cp-ty">HttpPost</span>, <span class="cp-st">"auth"</span>]'],
                    ['n' => '2', 'html' => '<span class="cp-kw">public</span> <span class="cp-ty">Token</span> <span class="cp-fn">Login</span>(<span class="cp-ty">User</span> u) {'],
                    ['n' => '3', 'html' => '  <span class="cp-kw">return</span> _jwt.<span class="cp-fn">Generate</span>(u);'],
                    ['n' => '4', 'html' => '}'],
                ],
                'link_type'   => 'github',
                'link_url'    => 'https://github.com/mesfinmaru/Car-Rental-Management-System.git',
                'link_label'  => 'View on GitHub',
                'sort_order'  => 2,
            ],
            [
                'title'       => 'Wealth Prediction Model',
                'tags'        => ['Python', 'CRISP-DM'],
                'description' => 'Parsed public socio-economic datasets to train predictive analytics algorithms mapping metrics against development metrics.',
                'code_snippet'=> [
                    ['n' => '1', 'html' => '<span class="cp-kw">import</span> sklearn'],
                    ['n' => '2', 'html' => 'model = <span class="cp-fn">GradientBoosting</span>()'],
                    ['n' => '3', 'html' => 'model.<span class="cp-fn">fit</span>(X_ethiopia, y_wealth)'],
                    ['n' => '4', 'html' => ''],
                ],
                'link_type'   => 'github',
                'link_url'    => 'https://github.com/mesfinmaru/Ethiopian-Household-Wealth-Prediction.git',
                'link_label'  => 'View on GitHub',
                'sort_order'  => 3,
            ],
            [
                'title'       => 'DBU EduFlow',
                'tags'        => ['PHP', 'PDO', 'RBAC', 'Scheduling'],
                'description' => 'Built a web-based academic timetable and exam scheduler for Debre Berhan University Computing college with secure roles, approval flow, and collision checks.',
                'code_snippet'=> [
                    ['n' => '1', 'html' => '<span class="cp-kw">$courses</span> = <span class="cp-fn">generateTimetable</span>(<span class="cp-st">$dbuCourses</span>);'],
                    ['n' => '2', 'html' => '<span class="cp-kw">if</span> (<span class="cp-fn">hasCollision</span>(<span class="cp-st">$room</span>, <span class="cp-st">$slot</span>)) {'],
                    ['n' => '3', 'html' => '  <span class="cp-kw">return</span> <span class="cp-st">\'Draft\'</span>;'],
                    ['n' => '4', 'html' => '}'],
                ],
                'link_type'   => 'github',
                'link_url'    => 'https://github.com/mesfinmaru/DBU-EduFlow.git',
                'link_label'  => 'View on GitHub',
                'sort_order'  => 4,
            ],
            [
                'title'       => 'Amharic IR System',
                'tags'        => ['Python', 'TF-IDF', 'GUI'],
                'description' => 'Built a searchable Amharic text retrieval tool with indexing, TF-IDF ranking, and a simple desktop interface.',
                'code_snippet'=> [
                    ['n' => '1', 'html' => '<span class="cp-kw">from</span> core.indexer <span class="cp-kw">import</span> InvertedIndex'],
                    ['n' => '2', 'html' => '<span class="cp-kw">from</span> core.searcher <span class="cp-kw">import</span> AmharicSearcher'],
                    ['n' => '3', 'html' => 'results = <span class="cp-fn">search</span>(query, <span class="cp-st">top_k</span>=20)'],
                    ['n' => '4', 'html' => ''],
                ],
                'link_type'   => 'github',
                'link_url'    => 'https://github.com/mesfinmaru/Amharic-IR-System.git',
                'link_label'  => 'View on GitHub',
                'sort_order'  => 5,
            ],
            [
                'title'       => 'E-KIRAY',
                'tags'        => ['Java', 'Android', 'Firebase', 'Room'],
                'description' => 'Built an Android rental marketplace with listings, authentication, Room storage, and Firebase sync.',
                'code_snippet'=> [
                    ['n' => '1', 'html' => '<span class="cp-kw">public</span> <span class="cp-ty">void</span> <span class="cp-fn">postItem</span>() {'],
                    ['n' => '2', 'html' => '  FirebaseRepository.<span class="cp-fn">saveListing</span>(item);'],
                    ['n' => '3', 'html' => '  SessionManager.<span class="cp-fn">saveUser</span>(user);'],
                    ['n' => '4', 'html' => '}'],
                ],
                'link_type'   => 'github',
                'link_url'    => 'https://github.com/Ayires/E-KIRAY.git',
                'link_label'  => 'View on GitHub',
                'sort_order'  => 6,
            ],
        ];

        foreach ($projects as $data) {
            Project::create($data);
        }

        // ── Skills ────────────────────────────────────────────────────────────
        $skills = [
            ['category' => 'languages',      'icon' => 'fab fa-php',    'icon_color' => '#777bb4', 'label' => 'PHP Core / Laravel',              'sort_order' => 1],
            ['category' => 'languages',      'icon' => 'fas fa-code',   'icon_color' => '#178600', 'label' => 'C# / ASP.NET API',                'sort_order' => 2],
            ['category' => 'languages',      'icon' => 'fab fa-java',   'icon_color' => '#ea2d2e', 'label' => 'Java Enterprise / Mobile',         'sort_order' => 3],
            ['category' => 'languages',      'icon' => 'fab fa-python', 'icon_color' => '#3776ab', 'label' => 'Python Analytic Engineering',       'sort_order' => 4],
            ['category' => 'infrastructure', 'icon' => 'fas fa-database','icon_color'=> '#00758f', 'label' => 'MySQL / Relational SQL',           'sort_order' => 1],
            ['category' => 'infrastructure', 'icon' => 'fab fa-linux',  'icon_color' => '#ecc81a', 'label' => 'Ubuntu/Linux Basics',              'sort_order' => 2],
            ['category' => 'infrastructure', 'icon' => 'fas fa-server', 'icon_color' => '#0078d4', 'label' => 'Windows Server Basics',            'sort_order' => 3],
        ];

        foreach ($skills as $data) {
            Skill::create($data);
        }

        $this->command->info('✓ Portfolio data seeded successfully.');
    }
}