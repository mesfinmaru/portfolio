/**
 * Default portfolio data.
 * When VITE_API_URL is set, this is overridden by the Laravel API response.
 * Shape matches the Laravel API contract exactly.
 */

export const defaultData = {
  hero: {
    name: 'Mesfin Maru',
    roles: [
      'Information Systems Student',
      'Full-Stack Software Developer',
      'System Architecture Enthusiast'
    ],
    bio: 'Software developer based in Ethiopia, specializing in Information Systems. Engineered modular platforms, core APIs, and decoupled application architectures.',
    available: true,
    availableText: 'Available for work & freelance',
    profileImage: '/me.jpg',
    profileFallback: 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png',
    logoImage: '/logo.png',
    picTag: 'mes<span>.dev</span>'
  },

  about: {
    paragraphs: [
      'I am a system builder focused on structuring data workflows. Studying Information Systems at Debre Berhan University has allowed me to map operational patterns directly to secure software frameworks.',
      'My learning tenure involves providing enterprise automation architectures, structural dashboard configurations, and robust transactional software tools for global standard projects.'
    ],
    chips: [
      { label: 'Base Location', value: 'Ethiopia' },
      { label: 'Department',    value: 'Information Systems' }
    ],
    timeline: [
      {
        id: 1,
        date:  '2024 - Present',
        title: 'Software Developer',
        desc:  'Writing custom script pipelines, integration APIs, and database routing layers.'
      },
      {
        id: 2,
        date:  '2023 - 2024',
        title: 'System Layout Planner',
        desc:  'Modeled simulation frameworks, network logic maps, and factory process diagrams.'
      }
    ]
  },

  projects: [
    {
      id: 1,
      tags:  ['Odoo ERP', 'System Architecture'],
      title: 'Debre Berhan Blanket Factory ERP',
      desc:  'Authored system architecture implementations and structured manufacturing workflows blueprints for factory optimization loops.',
      codeSnippet: [
        { n: '1', html: '<span class="cp-cm">&lt;!-- Odoo Cloud Custom Module --&gt;</span>' },
        { n: '2', html: '<span class="cp-kw">&lt;record</span> <span class="cp-ty">id=</span><span class="cp-st">"dbbf_workflow"</span><span class="cp-kw">&gt;</span>' },
        { n: '3', html: '  <span class="cp-kw">&lt;field</span> <span class="cp-ty">name=</span><span class="cp-st">"factory_code"</span><span class="cp-kw">&gt;</span>DBBF-BLANKET<span class="cp-kw">&lt;/field&gt;</span>' },
        { n: '4', html: '<span class="cp-kw">&lt;/record&gt;</span>' }
      ],
      linkType: 'docs',
      linkUrl:  '',
      linkLabel: 'Documentation'
    },
    {
      id: 2,
      tags:  ['C#', '.NET Core API'],
      title: 'Car Rental System',
      desc:  'Architected a multi-tier management environment connecting decoupling desktop interfaces to an encrypted REST API service base.',
      codeSnippet: [
        { n: '1', html: '[<span class="cp-ty">HttpPost</span>, <span class="cp-st">"auth"</span>]' },
        { n: '2', html: '<span class="cp-kw">public</span> <span class="cp-ty">Token</span> <span class="cp-fn">Login</span>(<span class="cp-ty">User</span> u) {' },
        { n: '3', html: '  <span class="cp-kw">return</span> _jwt.<span class="cp-fn">Generate</span>(u);' },
        { n: '4', html: '}' }
      ],
      linkType: 'github',
      linkUrl:  'https://github.com/mesfinmaru/Car-Rental-Management-System.git',
      linkLabel: 'View on GitHub'
    },
    {
      id: 3,
      tags:  ['Python', 'CRISP-DM'],
      title: 'Wealth Prediction Model',
      desc:  'Parsed public socio-economic datasets to train predictive analytics algorithms mapping metrics against development metrics.',
      codeSnippet: [
        { n: '1', html: '<span class="cp-kw">import</span> sklearn' },
        { n: '2', html: 'model = <span class="cp-fn">GradientBoosting</span>()' },
        { n: '3', html: 'model.<span class="cp-fn">fit</span>(X_ethiopia, y_wealth)' },
        { n: '4', html: '' }
      ],
      linkType: 'github',
      linkUrl:  'https://github.com/mesfinmaru/Ethiopian-Household-Wealth-Prediction.git',
      linkLabel: 'View on GitHub'
    },
    {
      id: 4,
      tags:  ['PHP', 'PDO', 'RBAC', 'Scheduling'],
      title: 'DBU EduFlow',
      desc:  'Built a web-based academic timetable and exam scheduler for Debre Berhan University Computing college with secure roles, approval flow, and collision checks.',
      codeSnippet: [
        { n: '1', html: '<span class="cp-kw">$courses</span> = <span class="cp-fn">generateTimetable</span>(<span class="cp-st">$dbuCourses</span>);' },
        { n: '2', html: '<span class="cp-kw">if</span> (<span class="cp-fn">hasCollision</span>(<span class="cp-st">$room</span>, <span class="cp-st">$slot</span>)) {' },
        { n: '3', html: '  <span class="cp-kw">return</span> <span class="cp-st">\'Draft\'</span>;' },
        { n: '4', html: '}' }
      ],
      linkType: 'github',
      linkUrl:  'https://github.com/mesfinmaru/DBU-EduFlow.git',
      linkLabel: 'View on GitHub'
    },
    {
      id: 5,
      tags:  ['Python', 'TF-IDF', 'GUI'],
      title: 'Amharic IR System',
      desc:  'Built a searchable Amharic text retrieval tool with indexing, TF-IDF ranking, and a simple desktop interface.',
      codeSnippet: [
        { n: '1', html: '<span class="cp-kw">from</span> core.indexer <span class="cp-kw">import</span> InvertedIndex' },
        { n: '2', html: '<span class="cp-kw">from</span> core.searcher <span class="cp-kw">import</span> AmharicSearcher' },
        { n: '3', html: 'results = <span class="cp-fn">search</span>(query, <span class="cp-st">top_k</span>=20)' },
        { n: '4', html: '' }
      ],
      linkType: 'github',
      linkUrl:  'https://github.com/mesfinmaru/Amharic-IR-System.git',
      linkLabel: 'View on GitHub'
    },
    {
      id: 6,
      tags:  ['Java', 'Android', 'Firebase', 'Room'],
      title: 'E-KIRAY',
      desc:  'Built an Android rental marketplace with listings, authentication, Room storage, and Firebase sync.',
      codeSnippet: [
        { n: '1', html: '<span class="cp-kw">public</span> <span class="cp-ty">void</span> <span class="cp-fn">postItem</span>() {' },
        { n: '2', html: '  FirebaseRepository.<span class="cp-fn">saveListing</span>(item);' },
        { n: '3', html: '  SessionManager.<span class="cp-fn">saveUser</span>(user);' },
        { n: '4', html: '}' }
      ],
      linkType: 'github',
      linkUrl:  'https://github.com/Ayires/E-KIRAY.git',
      linkLabel: 'View on GitHub'
    }
  ],

  skills: {
    languages: [
      { id: 1, icon: 'fab fa-php',    iconColor: '#777bb4', label: 'PHP Core / Laravel' },
      { id: 2, icon: 'fas fa-code',   iconColor: '#178600', label: 'C# / ASP.NET API' },
      { id: 3, icon: 'fab fa-java',   iconColor: '#ea2d2e', label: 'Java Enterprise / Mobile' },
      { id: 4, icon: 'fab fa-python', iconColor: '#3776ab', label: 'Python Analytic Engineering' }
    ],
    infrastructure: [
      { id: 5, icon: 'fas fa-database', iconColor: '#00758f', label: 'MySQL / Relational SQL' },
      { id: 6, icon: 'fab fa-linux',    iconColor: '#ecc81a', label: 'Ubuntu/Linux Basics' },
      { id: 7, icon: 'fas fa-server',   iconColor: '#0078d4', label: 'Windows Server Basics' }
    ]
  },

  contact: {
    email:       'mesfinmaru121@gmail.com',
    university:  'Debre Berhan University, IS Department',
    phone:       '+251 92 008 9841',
    phoneRaw:    '+251920089841',
    github:      'https://github.com/mesfinmaru',
    linkedin:    'https://www.linkedin.com/in/mesfinmaru',
    telegram:    'https://t.me/mesfinmaru',
    copyrightName: 'Mesfin Maru',
    copyrightYear: 2026
  }
}
