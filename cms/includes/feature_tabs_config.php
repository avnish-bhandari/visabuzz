<?php
/**
 * feature_tabs_config.php — Central Configuration for Homepage Feature Tabs
 * "Comprehensive Visa Services & Pathways"
 * 
 * Provides complete data structure, default texts, icons, and helper functions
 * used by both the front-end (index.php) and CMS editors (services.php, home.php).
 */

if (!function_exists('cms_get_feature_tabs_config')) {

function cms_get_feature_tabs_config(): array
{
    return [
        'header' => [
            'sec_key' => 'tabs_header',
            'default_title' => 'Comprehensive Visa Services & Pathways',
            'pills' => [
                'study'     => ['key' => 'pill_study',     'label' => 'Study Global'],
                'offerings' => ['key' => 'pill_offerings', 'label' => 'Offerings'],
                'platform'  => ['key' => 'pill_platform',  'label' => 'Platform'],
                'resources' => ['key' => 'pill_resources', 'label' => 'Resources'],
            ]
        ],
        'categories' => [
            'study' => [
                'pane_id'     => 'category-pane-study',
                'pill_id'     => 'catPillStudy',
                'pill_key'    => 'pill_study',
                'pill_label'  => 'Study Global',
                'pill_icon'   => '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>',
                'pill_class'  => '',
                'vtab_id'     => 'studyVerticalTab',
                'content_id'  => 'studyInnerContent',
                'vtab_aria'   => 'Study Destinations',
                'tabs' => [
                    'study-uk' => [
                        'sec_key'   => 'tabs_study_uk',
                        'tab_label' => 'Study in UK',
                        'flag'      => 'uk',
                        'items' => [
                            1 => [
                                'title' => 'Russell Group & Tier-1 Admissions',
                                'desc'  => "Direct placement guidance for Oxford, Cambridge, Imperial, UCL, King's, and Manchester with personalized portfolio optimization."
                            ],
                            2 => [
                                'title' => "Accelerated 1-Year Master's Degrees",
                                'desc'  => 'Complete globally recognized postgraduate programs in 12 months, reducing tuition costs and accelerating your return on investment.'
                            ],
                            3 => [
                                'title' => '2-Year Graduate Route Work Visa',
                                'desc'  => 'Post-study employment authorization across England, Scotland, Wales, and Northern Ireland with employer sponsorship transition.'
                            ],
                        ],
                        'cta_label' => 'Explore UK Programs',
                        'cta_url'   => 'study-global.php?country=uk',
                        'image'     => 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'Students studying in the United Kingdom',
                    ],
                    'study-usa' => [
                        'sec_key'   => 'tabs_study_usa',
                        'tab_label' => 'Study in USA',
                        'flag'      => 'usa',
                        'items' => [
                            1 => [
                                'title' => 'Ivy League & Top STEM Universities',
                                'desc'  => 'Targeted applications for MIT, Stanford, UC Berkeley, Columbia, and Carnegie Mellon with comprehensive GRE and profile evaluation.'
                            ],
                            2 => [
                                'title' => 'Up to 3-Year STEM OPT Work Rights',
                                'desc'  => 'Qualify for 36 months of lawful full-time work authorization upon graduating from STEM-eligible degree programs across the United States.'
                            ],
                            3 => [
                                'title' => 'F-1 Visa Auditing & TA/RA Scholarships',
                                'desc'  => 'High-approval consular filing with mock visa interviews, assistantship applications, and merit fee waiver assistance.'
                            ],
                        ],
                        'cta_label' => 'Explore US Programs',
                        'cta_url'   => 'study-global.php?country=usa',
                        'image'     => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'Students on a university campus in the USA',
                    ],
                    'study-ireland' => [
                        'sec_key'   => 'tabs_study_ireland',
                        'tab_label' => 'Study in Ireland',
                        'flag'      => 'ireland',
                        'items' => [
                            1 => [
                                'title' => 'European Hub for Tech & Pharma Giants',
                                'desc'  => 'Study alongside EMEA headquarters of Google, Apple, Meta, Pfizer, and Stripe with industry co-op placements.'
                            ],
                            2 => [
                                'title' => '2-Year Post-Graduation Stay-Back Visa',
                                'desc'  => 'Third Level Graduate Scheme grants master\'s graduates two full years to work and convert into Critical Skills Employment Permits.'
                            ],
                            3 => [
                                'title' => 'Trinity College Dublin, UCD & Galway',
                                'desc'  => 'Globally ranked English-speaking higher education with tuition fees significantly lower than the US and UK.'
                            ],
                        ],
                        'cta_label' => 'Explore Ireland Programs',
                        'cta_url'   => 'study-global.php?country=ireland',
                        'image'     => 'https://images.unsplash.com/photo-1549918864-48ac978761a4?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'Students studying in Ireland',
                    ],
                    'study-canada' => [
                        'sec_key'   => 'tabs_study_canada',
                        'tab_label' => 'Study in Canada',
                        'flag'      => 'canada',
                        'items' => [
                            1 => [
                                'title' => 'Designated Learning Institutions (DLI)',
                                'desc'  => 'Direct admissions to premier universities like University of Toronto, UBC, McGill, Waterloo, and leading post-grad colleges.'
                            ],
                            2 => [
                                'title' => 'Up to 3-Year PGWP Work Permit',
                                'desc'  => 'Earn an open post-graduation work permit allowing you to work full-time for any Canadian employer anywhere in the country.'
                            ],
                            3 => [
                                'title' => 'Seamless Pathway to Canada PR',
                                'desc'  => 'Canadian degree credentials and Canadian work experience earn substantial bonus CRS points for Express Entry and Provincial Nominees.'
                            ],
                        ],
                        'cta_label' => 'Explore Canada Programs',
                        'cta_url'   => 'study-global.php?country=canada',
                        'image'     => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'Students studying in Canada',
                    ],
                    'study-germany' => [
                        'sec_key'   => 'tabs_study_germany',
                        'tab_label' => 'Study in Germany',
                        'flag'      => 'germany',
                        'items' => [
                            1 => [
                                'title' => 'Zero or Near-Zero Tuition Public Universities',
                                'desc'  => 'World-class engineering and IT education at TU Munich, RWTH Aachen, and Heidelberg with virtually no tuition fees.'
                            ],
                            2 => [
                                'title' => '18-Month Job Seeking Stay-Back Visa',
                                'desc'  => 'Generous post-study transition visa to secure professional employment, leading swiftly to the EU Blue Card.'
                            ],
                            3 => [
                                'title' => 'APS Certification & Blocked Account',
                                'desc'  => 'Complete end-to-end guidance for APS verification, blocked account funding, and German embassy visa appointments.'
                            ],
                        ],
                        'cta_label' => 'Explore Germany Programs',
                        'cta_url'   => 'study-global.php?country=germany',
                        'image'     => 'https://images.unsplash.com/photo-1564981797816-1043664bf78d?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'Students studying in Germany',
                    ],
                    'study-dubai' => [
                        'sec_key'   => 'tabs_study_dubai',
                        'tab_label' => 'Study in Dubai',
                        'flag'      => 'dubai',
                        'items' => [
                            1 => [
                                'title' => 'Prestigious International Branch Campuses',
                                'desc'  => 'Earn accredited British, Australian, and US degrees in Dubai from campuses like Heriot-Watt, Wollongong, and Middlesex.'
                            ],
                            2 => [
                                'title' => 'Fast-Track 2-Week Student Visa',
                                'desc'  => 'Hassle-free visa documentation with near 100% approval rates, minimal financial red tape, and part-time work rights.'
                            ],
                            3 => [
                                'title' => 'Tax-Free Career Hub & Green Visas',
                                'desc'  => 'Step directly into high-growth corporate careers in finance, technology, logistics, and AI with zero personal income tax.'
                            ],
                        ],
                        'cta_label' => 'Explore Dubai Programs',
                        'cta_url'   => 'study-global.php?country=dubai',
                        'image'     => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'Students studying in Dubai UAE',
                    ],
                    'study-france' => [
                        'sec_key'   => 'tabs_study_france',
                        'tab_label' => 'Study in France',
                        'flag'      => 'france',
                        'items' => [
                            1 => [
                                'title' => 'Elite Grandes Écoles & Universities',
                                'desc'  => 'Top global management and engineering schools including HEC Paris, INSEAD, ESSEC, and Sorbonne with English curricula.'
                            ],
                            2 => [
                                'title' => 'CAF Government Housing Allowance',
                                'desc'  => 'All international students are eligible for up to 40% government rent subsidies (CAF) plus free French state healthcare.'
                            ],
                            3 => [
                                'title' => '2-Year Post-Study Visa (APS / RECE)',
                                'desc'  => 'Master\'s degree holders receive 2 years of residence authorization with fast transition to the prestigious French Talent Passport.'
                            ],
                        ],
                        'cta_label' => 'Explore France Programs',
                        'cta_url'   => 'study-global.php?country=france',
                        'image'     => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'Students studying in France',
                    ],
                    'study-europe' => [
                        'sec_key'   => 'tabs_study_europe',
                        'tab_label' => 'Study in Europe',
                        'flag'      => 'europe',
                        'items' => [
                            1 => [
                                'title' => '27+ Schengen Countries Mobility',
                                'desc'  => 'A single national student visa allows seamless travel, internships, and cultural discovery across the entire European Schengen zone.'
                            ],
                            2 => [
                                'title' => 'Netherlands, Sweden & Switzerland',
                                'desc'  => 'High English proficiency rates, innovative tech incubators, and exceptional quality of life across top European destinations.'
                            ],
                            3 => [
                                'title' => 'Erasmus+ & Double Degree Options',
                                'desc'  => 'Gain credentials from multiple universities through funded European Union exchange programs and dual master\'s degrees.'
                            ],
                        ],
                        'cta_label' => 'Explore Europe Options',
                        'cta_url'   => 'study-global.php?country=europe',
                        'image'     => 'https://images.unsplash.com/photo-1467269204594-9661b134dd2b?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'Students studying across Continental Europe',
                    ],
                    'study-italy' => [
                        'sec_key'   => 'tabs_study_italy',
                        'tab_label' => 'Study in Italy',
                        'flag'      => 'italy',
                        'items' => [
                            1 => [
                                'title' => 'Historic World-Class Institutions',
                                'desc'  => 'Study design, fashion, architecture, and engineering at Politecnico di Milano, University of Bologna, and Sapienza Rome.'
                            ],
                            2 => [
                                'title' => 'DSU Regional Scholarships & Free Tuition',
                                'desc'  => 'Need-based DSU scholarships offer complete tuition waivers, free cafeteria meals, and up to €7,000 annual living stipends.'
                            ],
                            3 => [
                                'title' => '1-Year Stay-Back & DOV Assistance',
                                'desc'  => 'Declaration of Value (DOV) filing, Universitaly pre-enrollment management, and Post-Study Search of Employment Permit support.'
                            ],
                        ],
                        'cta_label' => 'Explore Italy Programs',
                        'cta_url'   => 'study-global.php?country=italy',
                        'image'     => 'https://images.unsplash.com/photo-1534447677768-be436bb09401?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'Students studying in Italy',
                    ],
                ]
            ],
            'offerings' => [
                'pane_id'     => 'category-pane-offerings',
                'pill_id'     => 'catPillOfferings',
                'pill_key'    => 'pill_offerings',
                'pill_label'  => 'Offerings',
                'pill_icon'   => '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>',
                'pill_class'  => 'cat-icon-amber',
                'vtab_id'     => 'offeringsVerticalTab',
                'content_id'  => 'offeringsInnerContent',
                'vtab_aria'   => 'Offerings Categories',
                'tabs' => [
                    'off-study' => [
                        'sec_key'   => 'tabs_off_study',
                        'tab_label' => 'Study Global',
                        'flag'      => '',
                        'items' => [
                            1 => [
                                'title' => 'End-to-End Overseas Placement',
                                'desc'  => 'Personalized course evaluation, university shortlisting, and direct partner applications across 800+ top universities worldwide.'
                            ],
                            2 => [
                                'title' => 'Admissions & Visa Assurance',
                                'desc'  => 'Dedicated counseling mentors ensuring 98.7% visa success rates with rigorous document audits and mock interview sessions.'
                            ],
                            3 => [
                                'title' => 'Guaranteed Scholarship Guidance',
                                'desc'  => 'Access exclusive institutional fee waivers, departmental bursaries, and merit-based international scholarships.'
                            ],
                        ],
                        'cta_label' => 'Explore Study Pathways',
                        'cta_url'   => '#book',
                        'image'     => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'Students graduating from global universities',
                    ],
                    'off-work' => [
                        'sec_key'   => 'tabs_off_work',
                        'tab_label' => 'Work Global',
                        'flag'      => '',
                        'items' => [
                            1 => [
                                'title' => 'Skilled Migration & Points Evaluation',
                                'desc'  => 'Points assessment and filing for Germany Opportunity Card (Chancenkarte), UK Skilled Worker, and Canada Express Entry.'
                            ],
                            2 => [
                                'title' => 'Employer Sponsorship & Compliance',
                                'desc'  => 'Complete assistance for LMIA certifications, Certificate of Sponsorship (CoS), and employer compliance requirements.'
                            ],
                            3 => [
                                'title' => 'International Relocation Onboarding',
                                'desc'  => 'Biometric scheduling, visa stamping follow-ups, tax residency guidance, and overseas banking setup before departure.'
                            ],
                        ],
                        'cta_label' => 'Explore Work Visas',
                        'cta_url'   => '#book',
                        'image'     => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'Professionals working globally',
                    ],
                    'off-online' => [
                        'sec_key'   => 'tabs_off_online',
                        'tab_label' => 'Learn Online',
                        'flag'      => '',
                        'items' => [
                            1 => [
                                'title' => 'Accredited International Online Degrees',
                                'desc'  => 'Earn recognized master\'s and bachelor\'s degrees from accredited US and UK universities at up to 70% lower tuition costs.'
                            ],
                            2 => [
                                'title' => 'Flexible Working Professional Curricula',
                                'desc'  => 'Self-paced modules in AI, Data Science, Cyber Security, and Global MBA designed for busy working professionals.'
                            ],
                            3 => [
                                'title' => 'Hybrid On-Campus Transfer Options',
                                'desc'  => 'Study Year 1 online from home and transfer directly to an overseas campus for final year completion and work permits.'
                            ],
                        ],
                        'cta_label' => 'Explore Online Programs',
                        'cta_url'   => '#book',
                        'image'     => 'https://images.unsplash.com/photo-1501504905252-473c47e087f8?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'Online learning and executive education',
                    ],
                    'off-local' => [
                        'sec_key'   => 'tabs_off_local',
                        'tab_label' => 'Study Local',
                        'flag'      => '',
                        'items' => [
                            1 => [
                                'title' => 'Premier Domestic Universities',
                                'desc'  => 'Discover top-tier national institutions offering industry-aligned degrees, state-of-the-art labs, and strong placement cells.'
                            ],
                            2 => [
                                'title' => 'International 2+2 Twinning Programs',
                                'desc'  => 'Complete two foundational years locally and transition abroad to graduate with an international degree at half the total cost.'
                            ],
                            3 => [
                                'title' => 'Credit Transfer & Articulation',
                                'desc'  => 'Verified university credit evaluation ensuring smooth academic equivalence for future global higher education pursuits.'
                            ],
                        ],
                        'cta_label' => 'Explore Local Options',
                        'cta_url'   => '#book',
                        'image'     => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'Students in a university classroom',
                    ],
                ]
            ],
            'platform' => [
                'pane_id'     => 'category-pane-platform',
                'pill_id'     => 'catPillPlatform',
                'pill_key'    => 'pill_platform',
                'pill_label'  => 'Platform',
                'pill_icon'   => '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M4 4h7v7H4V4zm10 0h6v7h-6V4zM4 14h7v6H4v-6zm10 0h6v6h-6v-6z"/></svg>',
                'pill_class'  => 'cat-icon-purple',
                'vtab_id'     => 'platformVerticalTab',
                'content_id'  => 'platformInnerContent',
                'vtab_aria'   => 'Platform Services',
                'tabs' => [
                    'plat-finance' => [
                        'sec_key'   => 'tabs_plat_finance',
                        'tab_label' => 'Financial Services',
                        'flag'      => '',
                        'items' => [
                            1 => [
                                'title' => 'Collateral-Free Education Loans',
                                'desc'  => 'Fast sanctioning up to ₹1.5 Crore ($180K USD) across 15+ premier public, private banks, and global international NBFCs.'
                            ],
                            2 => [
                                'title' => 'Germany Blocked Account & Canada GIC',
                                'desc'  => 'Instant digital setup for German blocked accounts (Fintiba/Expatrio) and Canadian GIC accounts with zero paperwork friction.'
                            ],
                            3 => [
                                'title' => 'Zero-Markup Forex Cards & Wire Transfers',
                                'desc'  => 'Save up to 3% on university tuition fee transfers and international student debit cards with real-time exchange rates.'
                            ],
                        ],
                        'cta_label' => 'Explore Financial Services',
                        'cta_url'   => '#book',
                        'image'     => 'https://images.unsplash.com/photo-1559526324-4b87b5e36e44?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'Student education finance and loan services',
                    ],
                    'plat-housing' => [
                        'sec_key'   => 'tabs_plat_housing',
                        'tab_label' => 'Affordable & Safe Housing',
                        'flag'      => '',
                        'items' => [
                            1 => [
                                'title' => 'Verified Student Accommodations',
                                'desc'  => 'Search over 50,000 vetted rooms, shared apartments, and student dormitories within walking distance of global campuses.'
                            ],
                            2 => [
                                'title' => 'Furnished Living with All Bills Included',
                                'desc'  => 'High-speed Wi-Fi, electricity, water, and central heating fully covered in rent with 24/7 on-site concierge and security.'
                            ],
                            3 => [
                                'title' => 'Zero Brokerage & Visa Cancellation Guarantee',
                                'desc'  => 'Direct landlord agreements with zero middleman fees and 100% refund policy in the rare event of visa delay or refusal.'
                            ],
                        ],
                        'cta_label' => 'Find Student Housing',
                        'cta_url'   => '#book',
                        'image'     => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'Safe and affordable modern student housing',
                    ],
                    'plat-visa' => [
                        'sec_key'   => 'tabs_plat_visa',
                        'tab_label' => 'Visa & Citizen Services',
                        'flag'      => '',
                        'items' => [
                            1 => [
                                'title' => 'Embassy Dossier Auditing & Compliance',
                                'desc'  => 'Strict verification of sponsorship affidavits, source of funds, income proofs, and bank statements to eliminate refusal risks.'
                            ],
                            2 => [
                                'title' => 'VFS & Consular Biometrics Scheduling',
                                'desc'  => 'Early slot notifications, rapid biometric appointment booking, and direct liaison with consular processing centers.'
                            ],
                            3 => [
                                'title' => 'Mock Interviews with Visa Specialists',
                                'desc'  => 'Realistic interview drills simulating US F-1, German consular, and UK credibility interviews to build complete confidence.'
                            ],
                        ],
                        'cta_label' => 'Book Visa Consultation',
                        'cta_url'   => '#book',
                        'image'     => 'https://images.unsplash.com/photo-1450133064473-71024230f91b?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'Visa and consular legal consultation',
                    ],
                    'plat-career' => [
                        'sec_key'   => 'tabs_plat_career',
                        'tab_label' => 'Continuous Career Support',
                        'flag'      => '',
                        'items' => [
                            1 => [
                                'title' => 'ATS-Optimized Global Resumes & CVs',
                                'desc'  => 'Professional transformation of your CV into country-compliant formats (Europass, US Resume, UK CV) tailored for recruiters.'
                            ],
                            2 => [
                                'title' => 'Global Alumni & Corporate Mentorship',
                                'desc'  => '1-on-1 networking with alumni currently working in high-growth companies across London, Toronto, Berlin, and Dublin.'
                            ],
                            3 => [
                                'title' => 'Post-Study Career Placement Bootcamps',
                                'desc'  => 'Interview preparation masterclasses, LinkedIn personal branding, and direct referrals to hiring corporate partners.'
                            ],
                        ],
                        'cta_label' => 'Access Career Support',
                        'cta_url'   => '#book',
                        'image'     => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'Career mentorship and global employment training',
                    ],
                ]
            ],
            'resources' => [
                'pane_id'     => 'category-pane-resources',
                'pill_id'     => 'catPillResources',
                'pill_key'    => 'pill_resources',
                'pill_label'  => 'Resources',
                'pill_icon'   => '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>',
                'pill_class'  => 'cat-icon-emerald',
                'vtab_id'     => 'resourcesVerticalTab',
                'content_id'  => 'resourcesInnerContent',
                'vtab_aria'   => 'Resources Categories',
                'tabs' => [
                    'res-lor' => [
                        'sec_key'   => 'tabs_res_lor',
                        'tab_label' => 'LOR',
                        'flag'      => '',
                        'items' => [
                            1 => [
                                'title' => 'Academic & Professional Draft Frameworks',
                                'desc'  => 'Structuring high-credibility recommendation letters emphasizing research rigor, intellectual curiosity, and workplace leadership.'
                            ],
                            2 => [
                                'title' => 'Professor & Manager Briefing Kits',
                                'desc'  => 'Ready-to-use recommendation questionnaire sheets for faculty and supervisors to draft strong, personalized endorsements.'
                            ],
                            3 => [
                                'title' => 'Tone & Plagiarism Audits',
                                'desc'  => 'Thorough reviews verifying distinct writing tones across multiple recommenders and ensuring 100% originality.'
                            ],
                        ],
                        'cta_label' => 'Download LOR Guides',
                        'cta_url'   => '#book',
                        'image'     => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'Letter of recommendation and academic writing',
                    ],
                    'res-sop' => [
                        'sec_key'   => 'tabs_res_sop',
                        'tab_label' => 'SOP',
                        'flag'      => '',
                        'items' => [
                            1 => [
                                'title' => 'Compelling Personal Narrative Frameworks',
                                'desc'  => 'Transforming your background into a coherent story that highlights intellectual passion, resilience, and vision.'
                            ],
                            2 => [
                                'title' => 'University-Specific Motivation Alignment',
                                'desc'  => 'Tailor each statement to exact lab faculty research, curriculum electives, campus centers, and community values.'
                            ],
                            3 => [
                                'title' => 'Senior Admissions Editors Review',
                                'desc'  => 'Multi-tier editing by ivy-league graduates checking rhetorical structure, clarity, word economy, and impact.'
                            ],
                        ],
                        'cta_label' => 'Request SOP Review',
                        'cta_url'   => '#book',
                        'image'     => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'Student drafting statement of purpose',
                    ],
                    'res-ielts' => [
                        'sec_key'   => 'tabs_res_ielts',
                        'tab_label' => 'IELTS',
                        'flag'      => '',
                        'items' => [
                            1 => [
                                'title' => 'Band 8+ Targeted 4-Module Strategy',
                                'desc'  => 'Specialized coaching across Academic Reading skimming, Listening note-taking, and cohesive Writing Task 1 & 2 structures.'
                            ],
                            2 => [
                                'title' => '1-on-1 Certified Examiner Speaking Drills',
                                'desc'  => 'Live face-to-face mock speaking evaluations grading fluency, lexical resource, grammatical accuracy, and pronunciation.'
                            ],
                            3 => [
                                'title' => 'Full Computer-Delivered Mock Tests',
                                'desc'  => 'Access timed practice simulations replicating official British Council and IDP test screen interfaces with instant feedback.'
                            ],
                        ],
                        'cta_label' => 'Start IELTS Prep',
                        'cta_url'   => '#book',
                        'image'     => 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'IELTS study and examination preparation',
                    ],
                    'res-gmat' => [
                        'sec_key'   => 'tabs_res_gmat',
                        'tab_label' => 'GMAT',
                        'flag'      => '',
                        'items' => [
                            1 => [
                                'title' => 'GMAT Focus Edition 705+ Blueprint',
                                'desc'  => 'Targeted drills covering Data Insights, Problem Solving, and Critical Reasoning with proprietary time-management formulas.'
                            ],
                            2 => [
                                'title' => 'Adaptive Computer Algorithm Simulations',
                                'desc'  => 'Practice on calibrated adaptive mock test engines that adjust question difficulty dynamically just like GMAC\'s real test.'
                            ],
                            3 => [
                                'title' => 'Top 1% Percentile MBA Mentorship',
                                'desc'  => 'Weekly live problem-solving clinics mentored by 99th-percentile scorers and top global business school alumni.'
                            ],
                        ],
                        'cta_label' => 'Start GMAT Prep',
                        'cta_url'   => '#book',
                        'image'     => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'GMAT business analysis and quantitative study',
                    ],
                    'res-gre' => [
                        'sec_key'   => 'tabs_res_gre',
                        'tab_label' => 'GRE',
                        'flag'      => '',
                        'items' => [
                            1 => [
                                'title' => 'GRE 325+ High Score Roadmap',
                                'desc'  => 'Master high-yield vocabulary mnemonics, Text Completion patterns, and Sentence Equivalence logic shortcuts.'
                            ],
                            2 => [
                                'title' => 'Advanced Quantitative Problem-Solving',
                                'desc'  => 'Comprehensive coverage of Algebra, Geometry, and Data Interpretation for engineering and STEM graduate admissions.'
                            ],
                            3 => [
                                'title' => 'Analytical Writing (AWA) Templates',
                                'desc'  => 'Issue task frameworks and argumentation templates designed to consistently secure a 4.5+ score on the essay section.'
                            ],
                        ],
                        'cta_label' => 'Start GRE Prep',
                        'cta_url'   => '#book',
                        'image'     => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'GRE graduate exam preparation and quantitative math',
                    ],
                    'res-sat' => [
                        'sec_key'   => 'tabs_res_sat',
                        'tab_label' => 'SAT',
                        'flag'      => '',
                        'items' => [
                            1 => [
                                'title' => 'Digital SAT 1500+ Preparation',
                                'desc'  => 'Master the adaptive Bluebook testing format with built-in Desmos graphing calculator hacks and timing pacing.'
                            ],
                            2 => [
                                'title' => 'Reading & Writing Module Drills',
                                'desc'  => 'Rapid rhetorical analysis, transitions, and standard English punctuation rules for maximum verbal point accumulation.'
                            ],
                            3 => [
                                'title' => 'AI Diagnostics & Score Improvement Guarantee',
                                'desc'  => 'Targeted diagnostic analytics identifying exact concept vulnerabilities for fast, measurable score jumps.'
                            ],
                        ],
                        'cta_label' => 'Start SAT Prep',
                        'cta_url'   => '#book',
                        'image'     => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'Students studying for the SAT test',
                    ],
                    'res-toefl' => [
                        'sec_key'   => 'tabs_res_toefl',
                        'tab_label' => 'TOEFL',
                        'flag'      => '',
                        'items' => [
                            1 => [
                                'title' => 'TOEFL iBT 105+ Score Guarantee',
                                'desc'  => 'Specialized strategies for the streamlined 2-hour TOEFL iBT format, including Writing for an Academic Discussion.'
                            ],
                            2 => [
                                'title' => 'Speech Clarity & Acoustic Analysis',
                                'desc'  => 'AI voice feedback coaching on pauses, intonation, and response structure for integrated speaking tasks.'
                            ],
                            3 => [
                                'title' => 'Official ETS Practice Tests',
                                'desc'  => 'Full-length authentic retired test papers graded using official ETS SpeechRater and e-rater scoring algorithms.'
                            ],
                        ],
                        'cta_label' => 'Start TOEFL Prep',
                        'cta_url'   => '#book',
                        'image'     => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'Student with headphones preparing for TOEFL exam',
                    ],
                    'res-pte' => [
                        'sec_key'   => 'tabs_res_pte',
                        'tab_label' => 'PTE',
                        'flag'      => '',
                        'items' => [
                            1 => [
                                'title' => 'PTE Academic 79+ (Band 8 Equivalent)',
                                'desc'  => 'Master Pearson AI scoring logic for Read Aloud, Repeat Sentence, and Re-tell Lecture to secure maximum points.'
                            ],
                            2 => [
                                'title' => 'High-Weight Task Templates & Formulas',
                                'desc'  => 'High-scoring grammar templates for Summarize Spoken Text and Write From Dictation with 100% spelling precision.'
                            ],
                            3 => [
                                'title' => '14-Day Intensive Fast-Track Bootcamp',
                                'desc'  => 'Daily computer mock tests with AI score breakdown, pronunciation metrics, and personalized booster sessions.'
                            ],
                        ],
                        'cta_label' => 'Start PTE Prep',
                        'cta_url'   => '#book',
                        'image'     => 'https://images.unsplash.com/photo-1488190211105-8b0e65b80b4e?auto=format&fit=crop&w=900&q=80',
                        'image_alt' => 'Student preparing for PTE academic certification on laptop',
                    ],
                ]
            ],
        ]
    ];
}

} // function_exists
