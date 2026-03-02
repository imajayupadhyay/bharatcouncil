<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogPublicationTypeSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Seed publication-type categories ────────────────────────────
        $categories = [
            [
                'name'        => 'Policy Brief',
                'slug'        => 'policy-brief',
                'description' => 'Concise, evidence-based policy recommendations on India\'s most pressing governance and institutional challenges.',
                'sort_order'  => 10,
            ],
            [
                'name'        => 'Report',
                'slug'        => 'report',
                'description' => 'In-depth research reports and multi-state studies on governance, public finance, and institutional performance.',
                'sort_order'  => 11,
            ],
            [
                'name'        => 'Op-Ed',
                'slug'        => 'op-ed',
                'description' => 'Expert opinion and analysis on current policy debates from BGC researchers and fellows.',
                'sort_order'  => 12,
            ],
            [
                'name'        => 'Explainer',
                'slug'        => 'explainer',
                'description' => 'Plain-language explanations of complex legislation, policy frameworks, and institutional arrangements.',
                'sort_order'  => 13,
            ],
            [
                'name'        => 'Commentary',
                'slug'        => 'commentary',
                'description' => 'Timely commentary on emerging developments in Indian governance, foreign policy, and public affairs.',
                'sort_order'  => 14,
            ],
        ];

        foreach ($categories as $cat) {
            BlogCategory::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // ── 2. Seed one post per publication-type category ─────────────────
        $posts = [

            // ── Policy Brief ──────────────────────────────────────────────
            [
                'category_slug' => 'policy-brief',
                'title'         => 'Electoral Finance Reform: Pathways to Transparency and Accountability',
                'slug'          => 'electoral-finance-reform-pathways-transparency-accountability',
                'excerpt'       => 'Following the Supreme Court\'s invalidation of the Electoral Bond Scheme, India must design a new architecture for political funding — one that balances disclosure, privacy, and the integrity of democratic competition.',
                'author_name'   => 'Dr. Priya Menon',
                'read_time'     => '11 min read',
                'status'        => 'published',
                'is_featured'   => false,
                'published_at'  => '2025-02-20 09:00:00',
                'meta_title'    => 'Electoral Finance Reform: Pathways to Transparency | BGC Policy Brief',
                'meta_description' => 'Following the Supreme Court\'s invalidation of the Electoral Bond Scheme, India must design a new architecture for political funding that balances disclosure and democratic integrity.',
                'meta_keywords' => 'electoral bonds, political funding, campaign finance, India elections, transparency',
                'content'       => '<h2><span class="h2-num">01</span> The Post-Electoral Bond Moment</h2>
<p>In February 2024, a five-judge Constitution Bench of the Supreme Court unanimously struck down the Electoral Bond Scheme as unconstitutional, holding that it violated the voter\'s fundamental right to information under Article 19(1)(a). The judgement was a landmark intervention in the regulation of political finance — but it also left India without a viable mechanism for legitimate anonymous corporate political donations, creating a regulatory vacuum that demands a principled policy response.</p>
<p>This policy brief examines the architecture of electoral finance reform required in the post-Electoral Bond moment. It argues that reform must pursue three simultaneous objectives: enhancing disclosure to voters; reducing the dominance of unaccounted cash in political spending; and creating regulatory institutions capable of credible enforcement.</p>

<h2><span class="h2-num">02</span> The Structural Problem with Indian Political Finance</h2>
<p>Indian political parties collectively spend an estimated ₹55,000–60,000 crore per election cycle — a figure that dwarfs declared expenditures by several multiples. The gap between declared and actual spending is financed primarily through three channels: undisclosed cash donations from businesses and individuals; the diversion of public resources through state-level patronage networks; and, until February 2024, Electoral Bonds purchased from the State Bank of India.</p>
<p>The Electoral Bond Scheme, introduced in 2018, was designed to shift corporate political funding from cash to banking channels. It partially achieved this objective — over ₹16,500 crore in bonds were purchased between 2018 and 2024 — but at the cost of complete opacity about donor-party relationships, enabling what the Supreme Court characterised as a "quid pro quo" environment for regulatory favour.</p>

<h2><span class="h2-num">03</span> Key Recommendations</h2>
<p><strong>Establish a Political Finance Regulator</strong> within the Election Commission of India, with independent statutory powers to audit party accounts, impose penalties for disclosure violations, and publish real-time donation records. The current framework, where parties self-report to a non-enforcement body, is structurally incapable of producing reliable disclosure.</p>
<p><strong>Introduce a Capped Anonymous Donation Window</strong> for small donors — allowing anonymous contributions up to ₹2,000 per donor per party per year through a state-managed intermediary that aggregates and transfers funds without revealing individual donor identity. This preserves legitimate privacy while eliminating the large anonymous corporate donations that distort democratic competition.</p>
<p><strong>Mandate Real-Time Digital Disclosure</strong> of all donations above ₹10,000 within 72 hours of receipt, published on a publicly accessible Election Commission portal with machine-readable data formats that enable independent analysis and media scrutiny.</p>

<h2><span class="h2-num">04</span> The Path Forward</h2>
<p>Electoral finance reform is not merely a technical exercise in regulatory design. It is a test of whether India\'s democracy can hold its most powerful actors — political parties — to the same standards of transparency and accountability that are demanded of corporations, civil society organisations, and individual citizens. The Supreme Court has set the constitutional standard. Parliament must now provide the legislative architecture to meet it.</p>',
            ],

            // ── Report ────────────────────────────────────────────────────
            [
                'category_slug' => 'report',
                'title'         => 'The State of Gram Panchayats: Finances, Capacity & Accountability',
                'slug'          => 'state-of-gram-panchayats-finances-capacity-accountability',
                'excerpt'       => 'A 10-state study of Panchayati Raj institutions examining fiscal transfers, administrative capacity, and accountability mechanisms — and what genuine decentralisation requires.',
                'author_name'   => 'BGC Research Team',
                'read_time'     => '18 min read',
                'status'        => 'published',
                'is_featured'   => false,
                'published_at'  => '2024-10-08 09:00:00',
                'meta_title'    => 'State of Gram Panchayats: Finances, Capacity & Accountability | BGC Report',
                'meta_description' => 'A 10-state study of Panchayati Raj institutions examining fiscal transfers, administrative capacity, and what genuine decentralisation of governance requires.',
                'meta_keywords' => 'gram panchayat, panchayati raj, rural governance, decentralisation, fiscal transfers, India',
                'content'       => '<h2><span class="h2-num">01</span> The Scale of the Challenge</h2>
<p>India has approximately 2.55 lakh gram panchayats — the foundational unit of rural self-governance established by the Constitution (73rd Amendment) Act, 1992. These institutions collectively govern a population of over 850 million people across India\'s villages and are constitutionally mandated with 29 subjects ranging from agriculture and minor irrigation to primary education and health sanitation.</p>
<p>This report, based on a comprehensive 10-state study covering Rajasthan, Madhya Pradesh, Maharashtra, Odisha, Tamil Nadu, Karnataka, Uttar Pradesh, Bihar, Assam, and Himachal Pradesh, examines the financial resources available to gram panchayats, the administrative capacity of their elected and appointed officials, and the accountability mechanisms that govern their functioning.</p>

<div class="key-findings-box">
  <div class="kf-header"><span class="kf-icon">◈</span><h4>Key Findings</h4></div>
  <ul class="kf-list">
    <li>Average per-capita own revenue of gram panchayats across our 10-state sample is ₹148 per year — insufficient to fund even basic administrative costs.</li>
    <li>73% of gram panchayat expenditure is tied to centrally-sponsored programmes, leaving less than 27% as discretionary spending for locally determined priorities.</li>
    <li>Only 34% of gram panchayat secretaries in our sample have received any formal training in the past three years.</li>
    <li>Social audits — mandated under MGNREGS — are conducted regularly in only 6 of the 10 states studied.</li>
    <li>Female-headed panchayats perform comparably to male-headed counterparts on financial management, but face significantly higher barriers to administrative access.</li>
  </ul>
</div>

<h2><span class="h2-num">02</span> The Fiscal Architecture of Rural Self-Governance</h2>
<p>Gram panchayat finances flow from three principal sources: own revenues (property tax, profession tax, fees for services); state government devolution through State Finance Commission awards; and central transfers through the Finance Commission grants and scheme-tied funds. The relative weight of these three sources varies dramatically across states, but the overwhelming dependence on tied external transfers is a consistent pattern across our entire sample.</p>
<p>In Uttar Pradesh, own revenue constitutes just 4% of gram panchayat receipts. In Tamil Nadu — consistently among the best performers on panchayat finances — own revenue reaches 18%, still far below the share needed for genuine fiscal autonomy. The property tax, which should be the natural own-revenue instrument of local government, is virtually non-functional in most gram panchayats: rates have not been revised in decades, assessment is largely notional, and collection enforcement is politically untenable for elected sarpanchas dependent on their village communities for re-election.</p>

<h2><span class="h2-num">03</span> Administrative Capacity: The Human Resource Gap</h2>
<p>Financial resources without administrative capacity produce neither service delivery nor accountability. Our field research documents a pervasive capacity deficit at the gram panchayat level that constitutes an independent constraint on effective local governance, distinct from and in addition to the fiscal constraints.</p>
<p>The gram panchayat secretary — typically a state government employee serving multiple panchayats — is the fulcrum of administrative capacity at the village level. In our sample, the average secretary manages 2.8 panchayats simultaneously, limiting the time available for any single panchayat to less than two working days per week. Secretary vacancies, temporary postings, and frequent transfers compound the continuity problem.</p>

<h2><span class="h2-num">04</span> What Genuine Decentralisation Requires</h2>
<p>The 73rd Amendment created the constitutional framework for decentralisation. Three decades later, the substance of that framework — genuinely empowered local governments with adequate finances, functional staff, and meaningful accountability mechanisms — remains unrealised in most of India. The barriers are well understood: state governments retain strong incentives to maintain administrative and fiscal control over rural areas; the political economy of gram panchayat elections creates patron-client relationships that complicate impersonal governance; and the capacity of gram panchayats to absorb and productively deploy larger fiscal transfers is genuinely limited by current human resource constraints.</p>
<p>Resolving these barriers requires sustained political commitment at the state level, backed by central government incentives through Finance Commission conditionalities and scheme design reforms. The evidence from best-performing states — Tamil Nadu, Kerala, and Karnataka — demonstrates that meaningful panchayat empowerment is achievable within India\'s federal framework. The question is one of political will, not institutional feasibility.</p>',
            ],

            // ── Op-Ed ─────────────────────────────────────────────────────
            [
                'category_slug' => 'op-ed',
                'title'         => 'Rethinking Urban Local Body Finances in Tier-2 Cities',
                'slug'          => 'rethinking-urban-local-body-finances-tier-2-cities',
                'excerpt'       => 'India\'s fastest-growing cities — Indore, Surat, Coimbatore, Visakhapatnam — are structurally starved of funds while absorbing millions of new residents. The fiscal architecture must change.',
                'author_name'   => 'Vikram Nair',
                'read_time'     => '6 min read',
                'status'        => 'published',
                'is_featured'   => false,
                'published_at'  => '2025-01-08 09:00:00',
                'meta_title'    => 'Rethinking Urban Local Body Finances in Tier-2 Cities | BGC Op-Ed',
                'meta_description' => 'India\'s fastest-growing tier-2 cities are structurally starved of funds. The fiscal architecture governing urban local bodies must change urgently.',
                'meta_keywords' => 'tier-2 cities, urban local bodies, ULBs, municipal finance, India urbanisation, smart cities',
                'content'       => '<h2><span class="h2-num">01</span> India\'s Growth Story Has a Tier-2 Problem</h2>
<p>The narrative of India\'s urban transition has been dominated by its megacities — Mumbai, Delhi, Bengaluru, Hyderabad, Chennai. Yet the fastest-growing segment of India\'s urban population is not in these metros but in its tier-2 cities: Indore, Surat, Coimbatore, Visakhapatnam, Rajkot, Jaipur, Lucknow, Patna. These cities are absorbing hundreds of thousands of new residents annually, driven by industrial decentralisation, real estate affordability differentials, and deliberate government policy through the Smart Cities Mission.</p>
<p>The problem is that these cities are growing faster than their fiscal capacity to serve their residents. The structural reasons are well-understood: property tax regimes that have not been revised in decades; state governments unwilling to devolve financial autonomy; and a constitutional framework that creates the appearance of urban self-governance without the substance.</p>

<h2><span class="h2-num">02</span> The Tier-2 Specific Challenge</h2>
<p>Tier-2 cities face a distinct set of fiscal challenges compared to both megacities and small towns. Unlike megacities, they lack the economic density and commercial property tax base that gives Mumbai\'s BMC or Delhi\'s MCD meaningful own-revenue capacity. Unlike small towns, they are receiving infrastructure demands — expressway connectivity, metro rail, large-scale industrial estates — that require capital investment well beyond their current fiscal envelope.</p>
<p>The Smart Cities Mission, launched in 2015, provided a one-time capital injection to 100 selected cities. The mission has delivered visible infrastructure — command centres, smart poles, integrated traffic management — but has been criticised for prioritising visible technology over invisible essentials: water supply networks, underground drainage, solid waste processing. More fundamentally, it did not address the underlying fiscal architecture that will determine whether these cities can maintain and expand infrastructure beyond the mission period.</p>

<h2><span class="h2-num">03</span> Three Structural Reforms</h2>
<p><strong>GIS-based Property Tax Modernisation</strong> is the single highest-return fiscal reform available to tier-2 cities. Several municipalities — Pune, Ahmedabad, Bengaluru — have demonstrated that modern property survey and assessment technology can increase property tax collections by 40–70% without increasing effective tax rates, simply by bringing under-assessed and un-assessed properties into the tax net. The political barriers are real but surmountable with state government backing.</p>
<p><strong>Municipal Bond Market Development</strong> has worked in Pune, Ahmedabad, and Hyderabad — and could be extended to a wider set of creditworthy tier-2 cities. SEBI\'s municipal bond framework has been strengthened, and CRISIL ratings now cover a growing number of urban local bodies. The bottleneck is not market infrastructure but the absence of reliable, independently audited ULB accounts that investors require for credit assessment.</p>
<p><strong>Performance-Linked Central Transfers</strong> — analogous to the 15th Finance Commission\'s performance grants for states — could incentivise tier-2 cities to undertake the difficult fiscal reforms that pure devolution frameworks cannot compel. Central transfers conditioned on property tax reform milestones, account modernisation, and citizen service delivery metrics have shown positive results in the limited pilots conducted under the Atal Mission for Rejuvenation and Urban Transformation.</p>

<h2><span class="h2-num">04</span> The Window Is Narrowing</h2>
<p>India\'s tier-2 cities are at an inflection point. In the next decade, they will either develop the fiscal and institutional capacity to manage rapid urbanisation effectively — or they will follow the trajectory of an earlier generation of secondary cities that grew faster than their infrastructure, producing the endemic congestion, water stress, and service deficits that now characterise much of urban India. The policy choices made in the next five years will determine which trajectory prevails. The window for getting the fiscal architecture right is narrowing.</p>',
            ],

            // ── Explainer ─────────────────────────────────────────────────
            [
                'category_slug' => 'explainer',
                'title'         => 'How India\'s Account Aggregator Framework Works: A Plain-Language Guide',
                'slug'          => 'india-account-aggregator-framework-plain-language-guide',
                'excerpt'       => 'The Account Aggregator system is one of the most significant — and least understood — elements of India\'s digital finance stack. Here is what it does, how it works, and why it matters for financial inclusion.',
                'author_name'   => 'Aditi Sharma',
                'read_time'     => '7 min read',
                'status'        => 'published',
                'is_featured'   => false,
                'published_at'  => '2024-12-20 09:00:00',
                'meta_title'    => 'How India\'s Account Aggregator Framework Works | BGC Explainer',
                'meta_description' => 'The Account Aggregator system is one of the most significant elements of India\'s digital finance stack. Here is what it does, how it works, and why it matters.',
                'meta_keywords' => 'account aggregator, India fintech, digital finance, AA framework, financial inclusion, RBI',
                'content'       => '<h2><span class="h2-num">01</span> What is the Account Aggregator?</h2>
<p>The Account Aggregator (AA) framework is a consent-based financial data-sharing system regulated by the Reserve Bank of India. In simple terms, it allows individuals and businesses to share their financial data — bank statements, tax records, insurance policies, securities holdings — with lenders and service providers, with their explicit consent, in a standardised machine-readable format.</p>
<p>Think of it as a consent layer for your financial life. Instead of manually collecting bank statements, salary slips, and tax filings every time you apply for a loan, you can authorise a lender to access specific data from specific accounts for a specific period — and revoke that access at any time. The Account Aggregator sits between your financial data providers (banks, insurers, tax authorities) and the data consumers (lenders, financial advisors) and manages the consent flow.</p>

<h2><span class="h2-num">02</span> The Three Parties</h2>
<p><strong>Financial Information Providers (FIPs)</strong> hold your data — banks, NBFCs, insurance companies, depositories, pension funds, and now the Income Tax Department through Form 26AS. All major scheduled commercial banks are now live on the AA ecosystem as FIPs, meaning your account data can be shared through the system.</p>
<p><strong>Financial Information Users (FIUs)</strong> are the entities that want to access your data — primarily lenders seeking to assess creditworthiness, but also financial planning tools, insurance underwriters, and regulatory bodies. FIUs must be registered with the relevant financial regulator and must specify precisely what data they need, from which FIPs, and for what duration.</p>
<p><strong>Account Aggregators</strong> are the licensed intermediaries — currently there are nine RBI-licensed AAs including Finvu, OneMoney, CAMSFinServ, and Perfios — that manage the consent artefact and facilitate the data flow. Crucially, AAs cannot store, read, or monetise the data they transmit. They are purely technical intermediaries for consent and data transfer.</p>

<h2><span class="h2-num">03</span> Why Does It Matter for Financial Inclusion?</h2>
<p>The AA framework\'s most significant potential impact is on the 160 million small businesses and informal sector workers who currently have limited or no access to formal credit — not because they lack financial activity, but because that activity is either undocumented or trapped in siloed databases that lenders cannot access.</p>
<p>A vegetable vendor with a consistent UPI transaction history, a small manufacturer with regular GST filings, a gig worker with regular platform income — all of these individuals now have the ability to consent to share this financial data with lenders seeking alternative creditworthiness signals. Early data from MSME lenders using the AA framework shows that approval rates for first-time borrowers improve significantly when AA-sourced cash flow data supplements or replaces traditional credit bureau scores.</p>

<h2><span class="h2-num">04</span> What to Watch</h2>
<p>The AA ecosystem is growing rapidly — over 1.1 billion accounts were live on the framework by mid-2024 — but adoption remains concentrated among urban, digitally active users. Extending the framework\'s benefits to rural and semi-urban populations will require both demand-side interventions (financial literacy) and supply-side expansion (more FIPs including cooperative banks, microfinance institutions, and rural credit societies).</p>
<p>The framework\'s consent architecture is robust, but questions remain about informed consent in practice — whether users fully understand what they are sharing, with whom, and for how long. The RBI\'s evolving guidance on consent dashboards and grievance redressal will be critical in ensuring that the framework delivers on its inclusion promise without creating new forms of data exploitation.</p>',
            ],

            // ── Commentary ────────────────────────────────────────────────
            [
                'category_slug' => 'commentary',
                'title'         => 'India\'s G20 Presidency: Strategic Achievements and the Unfinished Agenda',
                'slug'          => 'india-g20-presidency-strategic-achievements-unfinished-agenda',
                'excerpt'       => 'India\'s G20 Presidency delivered the New Delhi Declaration and the African Union\'s historic inclusion — but the deeper reform of global governance institutions remains an unfinished agenda.',
                'author_name'   => 'Vikram Nair',
                'read_time'     => '8 min read',
                'status'        => 'published',
                'is_featured'   => false,
                'published_at'  => '2024-11-05 09:00:00',
                'meta_title'    => 'India\'s G20 Presidency: Achievements and Unfinished Agenda | BGC',
                'meta_description' => 'India\'s G20 Presidency delivered the New Delhi Declaration and the African Union\'s inclusion, but the deeper reform of global governance institutions remains unfinished.',
                'meta_keywords' => 'G20, India G20 presidency, New Delhi Declaration, African Union, global governance, multilateralism',
                'content'       => '<h2><span class="h2-num">01</span> What India\'s Presidency Achieved</h2>
<p>India\'s G20 Presidency, held from December 2022 to November 2023, delivered outcomes that exceeded the expectations of most observers at the outset. The New Delhi Leaders\' Declaration — adopted by consensus despite the deep geopolitical fault lines opened by Russia\'s invasion of Ukraine — represented a significant diplomatic achievement, threading a careful formulation on the Ukraine conflict that all nineteen member states and the European Union could accept.</p>
<p>The most historic achievement of India\'s presidency was the inclusion of the African Union as a permanent G20 member — elevating the continental body to the same status as the European Union and giving a permanent voice to 1.4 billion Africans in the world\'s premier economic governance forum. This outcome, championed by Prime Minister Modi from the outset of the presidency, has lasting structural significance for the architecture of global governance.</p>

<h2><span class="h2-num">02</span> The Digital Public Infrastructure Agenda</h2>
<p>India used its presidency to advance the case for Digital Public Infrastructure as a model for developing country technology policy — a significant reframing of the global tech governance conversation, which had previously been dominated by debates about large platform regulation in advanced economies.</p>
<p>The G20 Framework for Systems of DPI, adopted under India\'s presidency, establishes voluntary principles for DPI design that emphasise interoperability, open standards, privacy protection, and inclusion. India\'s own experience with Aadhaar, UPI, and the emerging Account Aggregator framework provided the credibility behind this agenda — though critics noted that the framework\'s voluntary nature limits its practical enforceability.</p>

<h2><span class="h2-num">03</span> The Unfinished Agenda: Multilateral Finance Reform</h2>
<p>Where India\'s G20 presidency made less progress was on the structural reform of multilateral development banks — an agenda that developing countries, including India, have consistently identified as their most important G20 priority. The World Bank and IMF governance reform process, initiated under previous G20 presidencies, advanced incrementally but without the fundamental recapitalisation and voting share rebalancing that would meaningfully increase developing country voice in global financial institutions.</p>
<p>The G20\'s Independent Expert Group on MDB Reform — co-chaired by N.K. Singh and Lawrence Summers — delivered recommendations for a tripling of MDB lending capacity over the next decade. Some of these recommendations were reflected in the New Delhi Declaration, but the financing commitments required to operationalise them have not yet materialised from major shareholder governments.</p>

<h2><span class="h2-num">04</span> India\'s Post-Presidency Strategic Position</h2>
<p>The G20 presidency gave India an unprecedented platform to articulate its vision of a reformed multilateral order — one that reflects the weight of the Global South while working within rather than against the existing rules-based international system. This positioning, distinct from both alignment with the Western bloc and membership in a Chinese-led revisionist coalition, is the essential foundation of India\'s strategic autonomy doctrine applied to multilateral governance.</p>
<p>The challenge for Indian foreign policy in the post-presidency period is to translate the visibility and convening power of the G20 year into durable institutional outcomes — particularly on climate finance, debt restructuring for vulnerable developing countries, and the reform of global financial architecture. These objectives require sustained multilateral engagement, coalition-building with like-minded states, and a willingness to invest diplomatic capital beyond the high-visibility moments that characterised the G20 year itself.</p>',
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
