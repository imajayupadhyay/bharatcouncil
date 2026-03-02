<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [

            // ── 1. Economic Policy — Featured (Policy Brief) ─────────────────
            [
                'category_slug' => 'economic-policy',
                'title'         => 'Reforming India\'s Fiscal Federalism: The 16th Finance Commission Agenda',
                'slug'          => 'reforming-indias-fiscal-federalism-16th-finance-commission',
                'excerpt'       => 'Structural recommendations for addressing vertical and horizontal fiscal imbalances between the Centre and states as the 16th Finance Commission begins its mandate.',
                'author_name'   => 'Dr. Priya Menon',
                'read_time'     => '14 min read',
                'status'        => 'published',
                'is_featured'   => true,
                'published_at'  => '2025-02-10 09:00:00',
                'meta_title'    => 'Reforming India\'s Fiscal Federalism | Bharat Governance Council',
                'meta_description' => 'An examination of the 16th Finance Commission\'s mandate and what structural fiscal reforms are needed to address growing vertical and horizontal imbalances in India\'s federal architecture.',
                'meta_keywords' => 'fiscal federalism, finance commission, India, Centre-state relations, public finance',
                'content'       => '<h2><span class="h2-num">01</span> The Challenge of Vertical Imbalance</h2>
<p>India\'s federal architecture is undergoing its most consequential stress test since the constitutional reforms of the early 1990s. As the 16th Finance Commission begins its deliberations, it inherits a system where the vertical imbalance between Union and state governments has deepened structurally — and where the principle of cooperative federalism increasingly strains against fiscal realities.</p>
<p>States account for over 62% of total government expenditure, yet retain access to only 41% of combined tax revenues before transfers. This asymmetry has worsened in the post-GST era, as states surrendered significant autonomous revenue-raising powers in exchange for a promised stable stream of tax devolution.</p>

<div class="key-findings-box">
  <div class="kf-header"><span class="kf-icon">◈</span><h4>Key Findings</h4></div>
  <ul class="kf-list">
    <li>States account for over 62% of total government expenditure, yet retain access to only 41% of combined tax revenues before transfers.</li>
    <li>The post-GST consolidation of indirect taxation has materially reduced states\' independent revenue-raising capacity.</li>
    <li>Tied grants and Centrally Sponsored Schemes constitute nearly 35% of all central transfers, undermining genuine fiscal autonomy.</li>
    <li>Seven high-burden states — home to 40% of India\'s population — are systematically under-resourced relative to their developmental needs.</li>
    <li>The 16th Finance Commission must rethink both the vertical share and the conditionality architecture of central transfers.</li>
  </ul>
</div>

<h2><span class="h2-num">02</span> Historical Context of Fiscal Federalism</h2>
<p>India\'s approach to fiscal federalism has always been a negotiated compromise between centralisation for macroeconomic efficiency and decentralisation for local accountability. The original constitution concentrated fiscal power at the Centre — a deliberate choice reflecting post-independence anxieties about national cohesion and the imperatives of planned industrialisation.</p>
<p>The Finance Commission, established under Article 280, was designed as the primary institutional mechanism to correct this vertical imbalance through periodic devolution recommendations. Over fifteen commissions, the share of central taxes devolved to states has risen from under 30% to the current 41% mandated by the 15th Finance Commission — a significant trajectory, but one that has not kept pace with the expanding fiscal responsibilities of state governments.</p>

<h2><span class="h2-num">03</span> The GST Transition and Its Fiscal Consequences</h2>
<p>The introduction of the Goods and Services Tax in 2017 represented the most significant restructuring of India\'s indirect tax architecture since independence. While GST harmonised the indirect tax base and eliminated the cascading effect of multiple levies, it also fundamentally altered the fiscal compact between the Centre and states.</p>
<p>States surrendered their most productive and elastic revenue instruments — VAT on petroleum products, entry tax, and octroi — in exchange for a guaranteed 14% growth rate on their base revenue, backed by the Centre\'s compensation mechanism for five years. The expiry of this compensation arrangement in June 2022 has exposed the underlying fragility of state finances, particularly for smaller states with limited economic diversification.</p>

<h2><span class="h2-num">04</span> Recommendations for the 16th Finance Commission</h2>
<p>The 16th Finance Commission must go beyond incremental adjustments to the existing framework and address the structural architecture of Centre-state fiscal relations. We recommend the Commission consider the following priority interventions:</p>
<p><strong>Increase the vertical devolution share to 45%</strong> — reflecting the expanded service delivery mandate of states in health, education, and social protection following successive policy shifts. The current 41% share was arrived at in a different fiscal context and must be revisited.</p>
<p><strong>Rationalise Centrally Sponsored Schemes</strong> — the proliferation of CSS has created significant compliance costs for states, distorted expenditure priorities, and undermined genuine fiscal autonomy. The Commission should recommend a sunset review of CSS with binding timelines for devolution or discontinuation.</p>
<p><strong>Introduce a Fiscal Stress Index</strong> — a formal mechanism to identify and provide additional untied support to states facing extraordinary fiscal stress from natural disasters, demographic pressures, or asymmetric economic shocks. The current equalisation framework is inadequate for this purpose.</p>',
            ],

            // ── 2. Constitutional Governance (Explainer) ─────────────────────
            [
                'category_slug' => 'constitutional-governance',
                'title'         => 'India\'s New Criminal Laws: A Citizen\'s Guide to BNS, BNSS & BSA',
                'slug'          => 'indias-new-criminal-laws-bns-bnss-bsa-citizens-guide',
                'excerpt'       => 'A plain-language breakdown of the Bharatiya Nyaya Sanhita, Bharatiya Nagarik Suraksha Sanhita, and Bharatiya Sakshya Adhiniyam — and what changes in practice.',
                'author_name'   => 'Aditi Sharma',
                'read_time'     => '8 min read',
                'status'        => 'published',
                'is_featured'   => false,
                'published_at'  => '2025-01-15 09:00:00',
                'meta_title'    => 'India\'s New Criminal Laws: BNS, BNSS & BSA Explained | BGC',
                'meta_description' => 'Plain-language breakdown of three landmark laws replacing the IPC, CrPC and Indian Evidence Act — and what they mean for rights, procedure, and justice delivery.',
                'meta_keywords' => 'BNS, BNSS, BSA, criminal law India, IPC replacement, Bharatiya Nyaya Sanhita',
                'content'       => '<h2><span class="h2-num">01</span> Why Three New Laws?</h2>
<p>On 1 July 2024, India replaced three colonial-era laws — the Indian Penal Code (1860), the Code of Criminal Procedure (1973), and the Indian Evidence Act (1872) — with three new statutes: the Bharatiya Nyaya Sanhita (BNS), the Bharatiya Nagarik Suraksha Sanhita (BNSS), and the Bharatiya Sakshya Adhiniyam (BSA).</p>
<p>The stated objective was to decolonise India\'s criminal justice system, modernise procedures, and prioritise justice over punishment. Whether the new laws achieve these goals is a matter of ongoing legal debate — but for citizens navigating the system, understanding what has changed is essential.</p>

<h2><span class="h2-num">02</span> Bharatiya Nyaya Sanhita (BNS) — The New Penal Code</h2>
<p>The BNS replaces the Indian Penal Code and retains the broad structure of offences and punishments, but with several significant changes. Sedition, which was Section 124A of the IPC, has been replaced by a new provision criminalising acts that endanger the sovereignty and integrity of India — a change that critics argue preserves the substantive effect of the colonial-era law while rebranding it.</p>
<p>Organised crime and terrorism have been incorporated for the first time into the general penal code, giving these provisions wider applicability. The BNS also introduces community service as a punishment for minor offences — a progressive measure that expands the toolkit beyond imprisonment and fines.</p>

<h2><span class="h2-num">03</span> Bharatiya Nagarik Suraksha Sanhita (BNSS) — Procedure</h2>
<p>The BNSS governs criminal procedure — arrests, bail, trials, and appeals. Notable changes include mandatory videography of crime scenes and search-and-seizure operations, which could significantly improve evidentiary standards and accountability of investigating agencies.</p>
<p>Trial timelines have been codified more explicitly: judgements must be delivered within 45 days of the conclusion of arguments, and charges must be framed within 60 days of the first hearing. These timelines address a longstanding criticism of India\'s justice system — but their enforceability without corresponding judicial capacity expansion remains an open question.</p>

<h2><span class="h2-num">04</span> Bharatiya Sakshya Adhiniyam (BSA) — Evidence</h2>
<p>The BSA updates the law of evidence to recognise electronic records — documents, messages, emails, and server logs — as primary evidence on par with physical documents. This is a significant modernisation that reflects the digital reality of contemporary transactions and communication.</p>
<p>The provision for secondary electronic evidence has been simplified, removing the technical barriers that previously made it difficult to admit digital evidence in court. However, the BSA does not yet comprehensively address the admissibility of AI-generated evidence or metadata, gaps that will likely require judicial interpretation or legislative amendment in the years ahead.</p>',
            ],

            // ── 3. Digital Governance (Report) ───────────────────────────────
            [
                'category_slug' => 'digital-governance',
                'title'         => 'State of Digital Public Infrastructure: India 2025',
                'slug'          => 'state-of-digital-public-infrastructure-india-2025',
                'excerpt'       => 'Comprehensive review of DPI adoption, trust scores, and equity gaps across 28 states and 8 union territories — assessing what India\'s digital stack has achieved and where critical gaps remain.',
                'author_name'   => 'Raghav Krishnan',
                'read_time'     => '20 min read',
                'status'        => 'published',
                'is_featured'   => false,
                'published_at'  => '2024-12-12 09:00:00',
                'meta_title'    => 'State of Digital Public Infrastructure India 2025 | BGC Report',
                'meta_description' => 'Comprehensive review of DPI adoption, trust scores, and equity gaps across India\'s states — assessing what the digital stack has achieved and where gaps remain.',
                'meta_keywords' => 'digital public infrastructure, DPI, India Stack, Aadhaar, UPI, digital governance',
                'content'       => '<h2><span class="h2-num">01</span> The DPI Decade: Where India Stands</h2>
<p>Over the past decade, India has constructed one of the world\'s most ambitious Digital Public Infrastructure ecosystems. From Aadhaar\'s biometric identity layer to UPI\'s real-time payments network, from DigiLocker\'s document repository to the Account Aggregator framework, India\'s digital stack has become a global reference point for government-led technology infrastructure.</p>
<p>Yet the aggregate narrative of DPI success obscures significant internal variation. This report assesses DPI adoption, public trust, and access equity across all 28 states and 8 union territories — and finds a country where the digital transformation is both more advanced and more uneven than the headline metrics suggest.</p>

<h2><span class="h2-num">02</span> Aadhaar Saturation and the Identity Gap</h2>
<p>Aadhaar enrolment has reached 93.7% of India\'s population — a remarkable achievement for any national identity system. However, enrolment saturation does not translate to functional use. Our survey data across 15 states finds that only 61% of Aadhaar holders have successfully used biometric authentication in the past year, with failure rates concentrated among elderly populations, manual labourers, and residents of high-humidity geographies where fingerprint degradation is common.</p>
<p>The face authentication alternative, introduced in 2022, has improved inclusion metrics but has created new concerns around privacy and consent, particularly in welfare delivery contexts where beneficiaries may not fully understand the biometric data being captured.</p>

<h2><span class="h2-num">03</span> UPI and the Payments Revolution</h2>
<p>UPI has achieved what no payment system in history has achieved at comparable scale: near-universal adoption across income strata in urban India, with monthly transaction volumes exceeding ₹20 trillion. The merchant adoption curve has been particularly steep, with street vendors, auto-rickshaw drivers, and small kirana stores integrating UPI payments as a primary transaction mode.</p>
<p>The rural penetration story is more complex. While UPI transaction volumes in rural districts have grown at 34% year-on-year, the share of rural adults conducting regular digital financial transactions remains at 38% — significantly below the 71% urban figure. Connectivity constraints, digital literacy gaps, and the prevalence of feature phones rather than smartphones are the primary barriers identified in our field research.</p>

<h2><span class="h2-num">04</span> The Trust Deficit</h2>
<p>Perhaps the most significant finding of this review is the emergence of a measurable trust deficit around DPI systems. While 78% of urban respondents express confidence in the security of their digital transactions, only 52% of rural respondents share this confidence. More concerning, 34% of respondents across income groups report having experienced or knowing someone who experienced a digital fraud incident in the past year.</p>
<p>The trust deficit is not merely a perception problem — it reflects real gaps in grievance redressal, fraud recovery, and consumer protection within the DPI ecosystem. The regulatory frameworks governing UPI liability, Aadhaar data protection, and Account Aggregator consent have not kept pace with the scale of adoption.</p>',
            ],

            // ── 4. Foreign Affairs (Commentary) ──────────────────────────────
            [
                'category_slug' => 'foreign-affairs',
                'title'         => 'What BRICS Expansion Means for India\'s Strategic Calculus',
                'slug'          => 'brics-expansion-india-strategic-calculus',
                'excerpt'       => 'Analysing the geopolitical and economic implications of a larger BRICS grouping for India\'s foreign policy — and why New Delhi faces a genuine strategic dilemma in the emerging multipolar order.',
                'author_name'   => 'Vikram Nair',
                'read_time'     => '9 min read',
                'status'        => 'published',
                'is_featured'   => false,
                'published_at'  => '2024-11-18 09:00:00',
                'meta_title'    => 'BRICS Expansion and India\'s Strategic Calculus | BGC Commentary',
                'meta_description' => 'Analysing the geopolitical and economic implications of a larger BRICS grouping for India\'s foreign policy in the emerging multipolar order.',
                'meta_keywords' => 'BRICS, India foreign policy, multipolarity, geopolitics, strategic autonomy',
                'content'       => '<h2><span class="h2-num">01</span> A Larger BRICS — and a More Complex Calculus</h2>
<p>The Johannesburg Declaration of August 2023 invited six new members — Saudi Arabia, Iran, Ethiopia, Egypt, Argentina, and the UAE — to join the BRICS grouping, marking the bloc\'s first expansion in over a decade. Argentina subsequently declined, and the effective BRICS+ membership now comprises nine states accounting for approximately 37% of global GDP and over 45% of the world\'s population.</p>
<p>For India, this expansion presents a genuine strategic dilemma. New Delhi has long valued BRICS as a platform for articulating the interests of the Global South, for pushing back against Western-dominated multilateral institutions, and for maintaining its doctrine of strategic autonomy. A larger BRICS amplifies the bloc\'s aggregate weight — but at the cost of introducing members whose geopolitical interests are considerably more complex for India to navigate.</p>

<h2><span class="h2-num">02</span> The Iran Complication</h2>
<p>The inclusion of Iran is the most strategically consequential aspect of the BRICS expansion from India\'s perspective. India and Iran share deep historical and civilisational ties, and New Delhi has long sought to maintain productive bilateral relations despite American pressure to curtail engagement. The Chabahar port project, India\'s most significant connectivity investment in the region, reflects this strategic imperative.</p>
<p>Yet Iran\'s membership in BRICS creates new complications. It places India in a multilateral forum with a state subject to comprehensive Western sanctions, and it risks entangling India\'s carefully cultivated relationships with Gulf Arab states — particularly the UAE and Saudi Arabia, also now BRICS members — which have their own complex relationships with Tehran.</p>

<h2><span class="h2-num">03</span> The Dollar Question</h2>
<p>Discussions around BRICS payment alternatives to the dollar-dominated SWIFT system have intensified since Russia\'s exclusion from the Western financial architecture following the 2022 invasion of Ukraine. A BRICS currency or common payment mechanism has been floated at successive summits, though the practical obstacles — divergent monetary regimes, convertibility concerns, and the absence of a trusted multilateral clearing mechanism — remain formidable.</p>
<p>India has been characteristically cautious on this question. The Reserve Bank of India\'s promotion of the rupee in bilateral trade settlements reflects a measured approach to currency diversification — one that seeks the benefits of reduced dollar dependency without the instability risks of premature multilateral currency arrangements. This position is likely to come under increasing pressure within an expanded BRICS that includes economies with stronger de-dollarisation incentives.</p>

<h2><span class="h2-num">04</span> Strategic Autonomy in a Crowded Room</h2>
<p>India\'s strategic autonomy doctrine has been most effective when India occupied a pivotal, swing position between competing power blocs. BRICS expansion — particularly with the inclusion of Saudi Arabia and the UAE alongside Iran — creates a more crowded room in which India\'s pivotal position is less clearly defined.</p>
<p>The opportunity, however, is significant. An India that can credibly bridge the Gulf Arab states, Iran, Africa, and South Asia within a single multilateral platform would possess an unusual diplomatic asset. Realising this potential requires New Delhi to move beyond its characteristic caution and invest in the institutional and diplomatic infrastructure necessary for active BRICS leadership — a posture that has not yet fully materialised.</p>',
            ],

            // ── 5. Civic Participation (Op-Ed) ───────────────────────────────
            [
                'category_slug' => 'civic-participation',
                'title'         => 'Municipal Finance is India\'s Forgotten Crisis',
                'slug'          => 'municipal-finance-indias-forgotten-crisis',
                'excerpt'       => 'Urban local bodies collect less than 1% of GDP in taxes. As India\'s cities absorb the next hundred million migrants, this structural failure must be addressed — urgently and honestly.',
                'author_name'   => 'Vikram Nair',
                'read_time'     => '6 min read',
                'status'        => 'published',
                'is_featured'   => false,
                'published_at'  => '2025-01-22 09:00:00',
                'meta_title'    => 'Municipal Finance is India\'s Forgotten Crisis | BGC Op-Ed',
                'meta_description' => 'Urban local bodies collect less than 1% of GDP in taxes. India\'s cities need structural reform in municipal finance to serve the next hundred million urban residents.',
                'meta_keywords' => 'municipal finance, urban local bodies, ULBs, India cities, property tax, urban governance',
                'content'       => '<h2><span class="h2-num">01</span> The Numbers Are Damning</h2>
<p>India\'s urban local bodies — municipal corporations, councils, and nagar panchayats — collectively raise approximately ₹1.5 lakh crore annually in own revenues. Against a GDP of ₹300 lakh crore, this amounts to 0.5%. By comparison, municipalities in Brazil raise 7.4% of GDP, in South Africa 6.1%, and in China 5.8%. Even among lower-middle-income countries, India\'s urban fiscal performance is an outlier — and not in a flattering direction.</p>
<p>This is not merely a technocratic concern about fiscal ratios. It is the underlying explanation for why Indian cities cannot fund adequate water supply, why public transport remains woefully underfunded, why solid waste management is a persistent crisis, and why the urban poor bear a disproportionate share of the infrastructure deficit through their time, health, and productivity.</p>

<h2><span class="h2-num">02</span> The Property Tax Paradox</h2>
<p>Property tax is the natural fiscal instrument of urban local government everywhere in the world. It is immobile (land cannot be moved to a low-tax jurisdiction), it appreciates with urban growth and infrastructure investment, and it creates a direct accountability link between the municipality and its residents-taxpayers.</p>
<p>In India, property tax collections are chronically low — not primarily because the legal framework is absent, but because political economy considerations make aggressive property tax enforcement genuinely difficult. Elected councillors face strong incentives to avoid antagonising property-owning voters, who also tend to be among the most politically active urban constituencies. The result is a systematic under-assessment, under-revision, and under-collection of property taxes that would, if realised, transform urban fiscal capacity.</p>

<h2><span class="h2-num">03</span> The 74th Amendment\'s Unfulfilled Promise</h2>
<p>The Constitution (74th Amendment) Act, 1992, established a framework for genuine urban self-governance: elected municipal bodies with defined functions, dedicated funding streams, and mandatory State Finance Commissions to recommend resource-sharing arrangements. Thirty years later, the promise remains largely unfulfilled.</p>
<p>State governments — of all political persuasions — have been reluctant to devolve either functions or finances to urban local bodies. The reasons are structural: ULBs with genuine fiscal and administrative autonomy become competing power centres, capable of attracting political talent, building patronage networks, and challenging state-level dominance. The incentive to keep municipalities financially dependent is thus not merely ideological but deeply political.</p>

<h2><span class="h2-num">04</span> What Must Change</h2>
<p>The path to financially capable Indian cities is not mysterious. It requires three concurrent shifts: a political commitment to genuine implementation of the 74th Amendment; a technical reform of property tax administration using GIS-based assessment that removes the discretion that enables systematic under-valuation; and a new central government framework — analogous to the Finance Commission at the national level — that establishes baseline resource entitlements for urban local bodies and creates accountability for their fiscal performance.</p>
<p>None of this is easy. All of it is necessary. India is urbanising at a pace that will add another 200 million city-dwellers by 2047. The cities that receive them will either be adequately resourced to provide basic services, or they will not. The window for structural reform, always narrow in a federal democracy, is closing. Municipal finance is not a second-order policy question. It is the unacknowledged foundation of India\'s urban future.</p>',
            ],
        ];

        foreach ($posts as $postData) {
            $categorySlug = $postData['category_slug'];
            unset($postData['category_slug']);

            $category = BlogCategory::where('slug', $categorySlug)->first();

            BlogPost::firstOrCreate(
                ['slug' => $postData['slug']],
                array_merge($postData, [
                    'blog_category_id' => $category?->id,
                ])
            );
        }
    }
}
