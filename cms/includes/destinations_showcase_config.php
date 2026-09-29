<?php
/**
 * destinations_showcase_config.php — Central Configuration for Homepage 3D Destinations Showcase
 * "Explore The World's Leading Study & Visa Hubs" (#destinationsTrack / #destinations)
 * 
 * Provides complete data structure, default texts, images, preset catalog,
 * and dynamic country add/remove/reorder management functions.
 */

if (!function_exists('cms_get_destinations_catalog')) {

/**
 * Complete catalog of available destination presets
 */
function cms_get_destinations_catalog(): array
{
    return [
        'canada' => [
            'key'              => 'canada',
            'flag_code'        => 'ca',
            'country_name'     => 'Canada',
            'title'            => 'Canada 🇨🇦',
            'desc'             => 'Top-ranked universities, post-graduation work permits & direct PR routes',
            'cta_url'          => '#book',
            'cta_aria'         => 'Explore Canada Visas',
            'bg_image'         => 'https://images.unsplash.com/photo-1517935703635-27c946e65452?auto=format&fit=crop&w=1920&q=80',
            'bg_alt'           => 'Canada scenic skyline background',
            'card_image'       => 'https://images.unsplash.com/photo-1503614472-8c93d56e92ce?auto=format&fit=crop&w=800&q=80',
            'card_alt'         => 'Canada Banff Rocky Mountains',
            'mini_left_img'    => 'https://images.unsplash.com/photo-1519817650390-64a93db51149?auto=format&fit=crop&w=300&q=80',
            'mini_left_alt'    => 'University of Toronto',
            'mini_center_img'  => 'https://images.unsplash.com/photo-1588733103629-b77afe0425ce?auto=format&fit=crop&w=300&q=80',
            'mini_center_alt'  => 'Vancouver British Columbia',
            'mini_right_img'   => 'https://images.unsplash.com/photo-1569974498991-d3c12a504f95?auto=format&fit=crop&w=300&q=80',
            'mini_right_alt'   => 'Montreal McGill University',
        ],
        'uk' => [
            'key'              => 'uk',
            'flag_code'        => 'uk',
            'country_name'     => 'United Kingdom',
            'title'            => 'United Kingdom 🇬🇧',
            'desc'             => "1-year Master's degrees, 2-year Graduate Route work visa & Russell Group prestige",
            'cta_url'          => '#book',
            'cta_aria'         => 'Explore UK Visas',
            'bg_image'         => 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?auto=format&fit=crop&w=1920&q=80',
            'bg_alt'           => 'United Kingdom London background',
            'card_image'       => 'https://images.unsplash.com/photo-1526129318478-62ed807ebdf9?auto=format&fit=crop&w=800&q=80',
            'card_alt'         => 'London Big Ben and Westminster, UK',
            'mini_left_img'    => 'https://images.unsplash.com/photo-1529655683826-aba9b3e77383?auto=format&fit=crop&w=300&q=80',
            'mini_left_alt'    => 'Oxford University',
            'mini_center_img'  => 'https://images.unsplash.com/photo-1508739773434-c26b3d09e071?auto=format&fit=crop&w=300&q=80',
            'mini_center_alt'  => 'Manchester cityscape',
            'mini_right_img'   => 'https://images.unsplash.com/photo-1543783207-ec64e4d95325?auto=format&fit=crop&w=300&q=80',
            'mini_right_alt'   => 'Cambridge historic campus',
        ],
        'germany' => [
            'key'              => 'germany',
            'flag_code'        => 'de',
            'country_name'     => 'Germany',
            'title'            => 'Germany 🇩🇪',
            'desc'             => 'Zero/low tuition fees, Opportunity Card (Chancenkarte) & powerhouse industry',
            'cta_url'          => '#book',
            'cta_aria'         => 'Explore Germany Visas',
            'bg_image'         => 'https://images.unsplash.com/photo-1467269204594-9661b134dd2b?auto=format&fit=crop&w=1920&q=80',
            'bg_alt'           => 'Germany historic background',
            'card_image'       => 'https://framerusercontent.com/images/M2egTeKnNQIzIFaVSX6x4kziaWs.jpg',
            'card_alt'         => 'Germany Berlin landmarks and castles',
            'mini_left_img'    => 'https://images.unsplash.com/photo-1560969184-10fe8719e047?auto=format&fit=crop&w=300&q=80',
            'mini_left_alt'    => 'Berlin Brandenburg gate',
            'mini_center_img'  => 'https://images.unsplash.com/photo-1595867818082-083862f3d630?auto=format&fit=crop&w=300&q=80',
            'mini_center_alt'  => 'Munich Technical University',
            'mini_right_img'   => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=300&q=80',
            'mini_right_alt'   => 'Frankfurt modern hub',
        ],
        'australia' => [
            'key'              => 'australia',
            'flag_code'        => 'au',
            'country_name'     => 'Australia',
            'title'            => 'Australia 🇦🇺',
            'desc'             => 'High standard of living, extended work rights & world-class research universities',
            'cta_url'          => '#book',
            'cta_aria'         => 'Explore Australia Visas',
            'bg_image'         => 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?auto=format&fit=crop&w=1920&q=80',
            'bg_alt'           => 'Australia Sydney harbour background',
            'card_image'       => 'https://framerusercontent.com/images/f103CLxkNZC2uJepoNQIt3D4xU.jpg',
            'card_alt'         => 'Sydney Opera House, Australia',
            'mini_left_img'    => 'https://images.unsplash.com/photo-1514395462725-fb4566210144?auto=format&fit=crop&w=300&q=80',
            'mini_left_alt'    => 'Sydney Harbour',
            'mini_center_img'  => 'https://images.unsplash.com/photo-1545044846-351ba102b6d5?auto=format&fit=crop&w=300&q=80',
            'mini_center_alt'  => 'Melbourne Monash campus',
            'mini_right_img'   => 'https://images.unsplash.com/photo-1524293581917-878a6d017cba?auto=format&fit=crop&w=300&q=80',
            'mini_right_alt'   => 'Brisbane skyline',
        ],
        'usa' => [
            'key'              => 'usa',
            'flag_code'        => 'us',
            'country_name'     => 'United States',
            'title'            => 'United States 🇺🇸',
            'desc'             => 'Ivy League & top STEM universities with up to 3 years OPT work authorization',
            'cta_url'          => '#book',
            'cta_aria'         => 'Explore USA Visas',
            'bg_image'         => 'https://images.unsplash.com/photo-1508433957232-3107f5fd5995?auto=format&fit=crop&w=1920&q=80',
            'bg_alt'           => 'United States New York skyline background',
            'card_image'       => 'https://images.unsplash.com/photo-1485738422979-f5c462d49f74?auto=format&fit=crop&w=800&q=80',
            'card_alt'         => 'United States Statue of Liberty',
            'mini_left_img'    => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=300&q=80',
            'mini_left_alt'    => 'Harvard University campus',
            'mini_center_img'  => 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?auto=format&fit=crop&w=300&q=80',
            'mini_center_alt'  => 'San Francisco Silicon Valley',
            'mini_right_img'   => 'https://images.unsplash.com/photo-1506146332389-18140dc7b2fb?auto=format&fit=crop&w=300&q=80',
            'mini_right_alt'   => 'Columbia University library',
        ],
        'ireland' => [
            'key'              => 'ireland',
            'flag_code'        => 'ie',
            'country_name'     => 'Ireland',
            'title'            => 'Ireland 🇮🇪',
            'desc'             => 'European tech hub, English-speaking education & 2-year Third Level Graduate scheme',
            'cta_url'          => '#book',
            'cta_aria'         => 'Explore Ireland Visas',
            'bg_image'         => 'https://images.unsplash.com/photo-1590089415225-401ed6f9db8e?auto=format&fit=crop&w=1920&q=80',
            'bg_alt'           => 'Ireland Dublin cityscape background',
            'card_image'       => 'https://images.unsplash.com/photo-1549918864-48ac978761a4?auto=format&fit=crop&w=800&q=80',
            'card_alt'         => 'Trinity College Dublin, Ireland',
            'mini_left_img'    => 'https://images.unsplash.com/photo-1564959130746-175c5d0124a2?auto=format&fit=crop&w=300&q=80',
            'mini_left_alt'    => 'Dublin tech hub docklands',
            'mini_center_img'  => 'https://images.unsplash.com/photo-1518005020951-eccb494ad742?auto=format&fit=crop&w=300&q=80',
            'mini_center_alt'  => 'Galway historic streets',
            'mini_right_img'   => 'https://images.unsplash.com/photo-1579783902614-a3fb3927b675?auto=format&fit=crop&w=300&q=80',
            'mini_right_alt'   => 'Cork University campus',
        ],
        'dubai' => [
            'key'              => 'dubai',
            'flag_code'        => 'ae',
            'country_name'     => 'Dubai',
            'title'            => 'Dubai 🇦🇪',
            'desc'             => 'Tax-free income, 100% foreign company ownership & 10-year Golden Visa pathways',
            'cta_url'          => '#book',
            'cta_aria'         => 'Explore Dubai Visas',
            'bg_image'         => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=1920&q=80',
            'bg_alt'           => 'Dubai futuristic skyline background',
            'card_image'       => 'https://images.unsplash.com/photo-1518684079-3c830dcef090?auto=format&fit=crop&w=800&q=80',
            'card_alt'         => 'Burj Khalifa, Dubai UAE',
            'mini_left_img'    => 'https://images.unsplash.com/photo-1580674684081-7617fbf3d745?auto=format&fit=crop&w=300&q=80',
            'mini_left_alt'    => 'Dubai Marina waterfront',
            'mini_center_img'  => 'https://images.unsplash.com/photo-1546412414-e1885259563a?auto=format&fit=crop&w=300&q=80',
            'mini_center_alt'  => 'Dubai Knowledge Park campus',
            'mini_right_img'   => 'https://images.unsplash.com/photo-1506665531195-3566af2b4dfa?auto=format&fit=crop&w=300&q=80',
            'mini_right_alt'   => 'DIFC Financial Center',
        ],
        'france' => [
            'key'              => 'france',
            'flag_code'        => 'fr',
            'country_name'     => 'France',
            'title'            => 'France 🇫🇷',
            'desc'             => 'Top European business schools, subsidized tuition & 5-year Schengen travel rights',
            'cta_url'          => '#book',
            'cta_aria'         => 'Explore France Visas',
            'bg_image'         => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=1920&q=80',
            'bg_alt'           => 'Paris Eiffel Tower and Seine background',
            'card_image'       => 'https://images.unsplash.com/photo-1499856871958-5b9627545d1a?auto=format&fit=crop&w=800&q=80',
            'card_alt'         => 'Louvre Museum and Paris landmarks',
            'mini_left_img'    => 'https://images.unsplash.com/photo-1509439581779-6298f75bf6e5?auto=format&fit=crop&w=300&q=80',
            'mini_left_alt'    => 'Sorbonne University Paris',
            'mini_center_img'  => 'https://images.unsplash.com/photo-1511739001486-6bfe10ce785f?auto=format&fit=crop&w=300&q=80',
            'mini_center_alt'  => 'Parisian architecture',
            'mini_right_img'   => 'https://images.unsplash.com/photo-1520939817895-060bdef4ad1b?auto=format&fit=crop&w=300&q=80',
            'mini_right_alt'   => 'Lyon European hub',
        ],
        'europe' => [
            'key'              => 'europe',
            'flag_code'        => 'eu',
            'country_name'     => 'Europe (Schengen)',
            'title'            => 'Europe 🇪🇺',
            'desc'             => 'Border-free access to 29 Schengen countries with EU Blue Card work pathways',
            'cta_url'          => '#book',
            'cta_aria'         => 'Explore Europe Visas',
            'bg_image'         => 'https://images.unsplash.com/photo-1467269204594-9661b134dd2b?auto=format&fit=crop&w=1920&q=80',
            'bg_alt'           => 'European historic skyline background',
            'card_image'       => 'https://images.unsplash.com/photo-1516483638261-f4dbaf036963?auto=format&fit=crop&w=800&q=80',
            'card_alt'         => 'Cinque Terre and European landscapes',
            'mini_left_img'    => 'https://images.unsplash.com/photo-1534351590666-13e3e96b5017?auto=format&fit=crop&w=300&q=80',
            'mini_left_alt'    => 'Amsterdam canals and university',
            'mini_center_img'  => 'https://images.unsplash.com/photo-1513622470522-26c3c8a854bc?auto=format&fit=crop&w=300&q=80',
            'mini_center_alt'  => 'Prague historic center',
            'mini_right_img'   => 'https://images.unsplash.com/photo-1509356843151-3e7d96241e11?auto=format&fit=crop&w=300&q=80',
            'mini_right_alt'   => 'Vienna university library',
        ],
        'italy' => [
            'key'              => 'italy',
            'flag_code'        => 'it',
            'country_name'     => 'Italy',
            'title'            => 'Italy 🇮🇹',
            'desc'             => 'Centuries of academic excellence, regional scholarship options & vibrant culture',
            'cta_url'          => '#book',
            'cta_aria'         => 'Explore Italy Visas',
            'bg_image'         => 'https://images.unsplash.com/photo-1516483638261-f4dbaf036963?auto=format&fit=crop&w=1920&q=80',
            'bg_alt'           => 'Rome Colosseum and Italian background',
            'card_image'       => 'https://images.unsplash.com/photo-1529260830199-42c24126f198?auto=format&fit=crop&w=800&q=80',
            'card_alt'         => 'Milan Duomo and University campus',
            'mini_left_img'    => 'https://images.unsplash.com/photo-1534447677768-be436bb09401?auto=format&fit=crop&w=300&q=80',
            'mini_left_alt'    => 'Bologna oldest university',
            'mini_center_img'  => 'https://images.unsplash.com/photo-1543429776-2782fc8e1acd?auto=format&fit=crop&w=300&q=80',
            'mini_center_alt'  => 'Florence Renaissance landmarks',
            'mini_right_img'   => 'https://images.unsplash.com/photo-1520175480921-4edfa2983e0f?auto=format&fit=crop&w=300&q=80',
            'mini_right_alt'   => 'Venice historic lagoon',
        ],
        'newzealand' => [
            'key'              => 'newzealand',
            'flag_code'        => 'nz',
            'country_name'     => 'New Zealand',
            'title'            => 'New Zealand 🇳🇿',
            'desc'             => 'Peaceful lifestyle, high safety rankings & up to 3-year Post-Study Work Visas',
            'cta_url'          => '#book',
            'cta_aria'         => 'Explore New Zealand Visas',
            'bg_image'         => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=1920&q=80',
            'bg_alt'           => 'New Zealand mountains and fjord background',
            'card_image'       => 'https://images.unsplash.com/photo-1507699622108-4be3abd695ad?auto=format&fit=crop&w=800&q=80',
            'card_alt'         => 'Auckland harbour and Sky Tower, New Zealand',
            'mini_left_img'    => 'https://images.unsplash.com/photo-1589871973318-9ca1258faa5d?auto=format&fit=crop&w=300&q=80',
            'mini_left_alt'    => 'Auckland University campus',
            'mini_center_img'  => 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?auto=format&fit=crop&w=300&q=80',
            'mini_center_alt'  => 'Queenstown landscape',
            'mini_right_img'   => 'https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?auto=format&fit=crop&w=300&q=80',
            'mini_right_alt'   => 'Wellington capital city',
        ],
        'singapore' => [
            'key'              => 'singapore',
            'flag_code'        => 'sg',
            'country_name'     => 'Singapore',
            'title'            => 'Singapore 🇸🇬',
            'desc'             => 'Asia top-ranked universities (NUS, NTU), global finance hub & fast career launchpad',
            'cta_url'          => '#book',
            'cta_aria'         => 'Explore Singapore Visas',
            'bg_image'         => 'https://images.unsplash.com/photo-1525625293386-3f8f99389edd?auto=format&fit=crop&w=1920&q=80',
            'bg_alt'           => 'Singapore Marina Bay Sands background',
            'card_image'       => 'https://images.unsplash.com/photo-1565967511849-76a60a516170?auto=format&fit=crop&w=800&q=80',
            'card_alt'         => 'Gardens by the Bay and Singapore skyline',
            'mini_left_img'    => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=300&q=80',
            'mini_left_alt'    => 'National University of Singapore (NUS)',
            'mini_center_img'  => 'https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?auto=format&fit=crop&w=300&q=80',
            'mini_center_alt'  => 'Singapore central business district',
            'mini_right_img'   => 'https://images.unsplash.com/photo-1518684079-3c830dcef090?auto=format&fit=crop&w=300&q=80',
            'mini_right_alt'   => 'NTU campus innovation hub',
        ]
    ];
}

}

if (!function_exists('cms_get_active_showcase_keys')) {

/**
 * Returns ordered array of active showcase country keys.
 * Reads from DB (cms_pages table, section_key = 'dest_showcase_header', field_key = 'active_countries').
 */
function cms_get_active_showcase_keys(array $dataStore = []): array
{
    $raw = '';
    if (isset($dataStore['dest_showcase_header']['active_countries'])) {
        $raw = $dataStore['dest_showcase_header']['active_countries'];
    } elseif (isset($dataStore['active_countries'])) {
        $raw = $dataStore['active_countries'];
    }

    if (!empty($raw)) {
        if (is_array($raw)) {
            $keys = array_values(array_unique(array_filter(array_map('trim', $raw))));
            if (!empty($keys)) return $keys;
        }
        $decoded = json_decode($raw, true);
        if (is_array($decoded) && !empty($decoded)) {
            $keys = array_values(array_unique(array_filter(array_map('trim', $decoded))));
            if (!empty($keys)) return $keys;
        }
    }

    return ['canada', 'uk', 'germany', 'australia'];
}

}

if (!function_exists('cms_get_destinations_showcase_config')) {

function cms_get_destinations_showcase_config(array $dataStore = []): array
{
    $catalog    = cms_get_destinations_catalog();
    $activeKeys = cms_get_active_showcase_keys($dataStore);

    $cards = [];
    $idx   = 0;
    foreach ($activeKeys as $key) {
        $cleanKey = strtolower(preg_replace('/[^a-zA-Z0-9_-]/', '', $key));
        if (!$cleanKey) continue;

        if (isset($catalog[$cleanKey])) {
            $card = $catalog[$cleanKey];
        } else {
            // Dynamic custom country fallback
            $name = ucwords(str_replace(['-', '_'], ' ', $cleanKey));
            $card = [
                'key'              => $cleanKey,
                'flag_code'        => substr($cleanKey, 0, 2),
                'country_name'     => $name,
                'title'            => $name,
                'desc'             => 'Leading universities, work opportunities and visa pathways.',
                'cta_url'          => '#book',
                'cta_aria'         => 'Explore ' . $name . ' Visas',
                'bg_image'         => 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=1920&q=80',
                'bg_alt'           => $name . ' scenic landscape background',
                'card_image'       => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80',
                'card_alt'         => $name . ' study destination card',
                'mini_left_img'    => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=300&q=80',
                'mini_left_alt'    => $name . ' campus preview 1',
                'mini_center_img'  => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=300&q=80',
                'mini_center_alt'  => $name . ' campus preview 2',
                'mini_right_img'   => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=300&q=80',
                'mini_right_alt'   => $name . ' campus preview 3',
            ];
        }

        $card['index']   = $idx;
        $card['sec_key'] = 'dest_showcase_' . $cleanKey;
        $card['card_id'] = 'destCard' . ucfirst($cleanKey);
        $card['btn_id']  = 'explore' . ucfirst($cleanKey) . 'Btn';

        $cards[$cleanKey] = $card;
        $idx++;
    }

    return [
        'header' => [
            'sec_key'          => 'dest_showcase_header',
            'eyebrow'          => 'Top Global Destinations',
            'default_title'    => "Explore The World's Leading\nStudy & Visa Hubs",
            'active_countries' => json_encode($activeKeys),
        ],
        'cards' => $cards
    ];
}

}

if (!function_exists('cms_dest_flag_svg')) {

function cms_dest_flag_svg(string $slug, int $w = 20, int $h = 14): string {
    $s = strtolower(trim($slug));
    switch ($s) {
        case 'canada':
        case 'ca':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" style="border-radius:2px;box-shadow:0 0 1px rgba(0,0,0,0.3);flex-shrink:0;" aria-hidden="true"><rect width="15" height="40" fill="#D80027"/><rect x="15" width="30" height="40" fill="#ffffff"/><rect x="45" width="15" height="40" fill="#D80027"/><path d="M30 10l1.4 4.2 3.6-1.4-1.2 4.2 4 1-3.6 2.8 1.8 4.2-4.8-1.8v3.8h-2.4V27l-4.8 1.8 1.8-4.2-3.6-2.8 4-1-1.2-4.2 3.6 1.4z" fill="#D80027"/></svg>';
        case 'uk':
        case 'gb':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" style="border-radius:2px;box-shadow:0 0 1px rgba(0,0,0,0.3);flex-shrink:0;" aria-hidden="true"><rect width="60" height="40" fill="#012169"/><path d="M0,0 L60,40 M60,0 L0,40" stroke="#fff" stroke-width="8"/><path d="M0,0 L60,40 M60,0 L0,40" stroke="#C8102E" stroke-width="4"/><path d="M30,0 v40 M0,20 h60" stroke="#fff" stroke-width="12"/><path d="M30,0 v40 M0,20 h60" stroke="#C8102E" stroke-width="7"/></svg>';
        case 'germany':
        case 'de':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" style="border-radius:2px;box-shadow:0 0 1px rgba(0,0,0,0.3);flex-shrink:0;" aria-hidden="true"><rect width="60" height="13.33" fill="#000000"/><rect y="13.33" width="60" height="13.33" fill="#DD0000"/><rect y="26.66" width="60" height="13.34" fill="#FFCE00"/></svg>';
        case 'australia':
        case 'au':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" style="border-radius:2px;box-shadow:0 0 1px rgba(0,0,0,0.3);flex-shrink:0;" aria-hidden="true"><rect width="60" height="40" fill="#00008B"/><path d="M0,0 L30,20 M30,0 L0,20" stroke="#fff" stroke-width="4"/><path d="M0,0 L30,20 M30,0 L0,20" stroke="#CC0000" stroke-width="2"/><path d="M15,0 v20 M0,10 h30" stroke="#fff" stroke-width="6"/><path d="M15,0 v20 M0,10 h30" stroke="#CC0000" stroke-width="3"/><circle cx="45" cy="10" r="1.5" fill="#fff"/><circle cx="50" cy="18" r="1.5" fill="#fff"/><circle cx="45" cy="30" r="2.5" fill="#fff"/><circle cx="40" cy="22" r="1.5" fill="#fff"/><circle cx="47" cy="24" r="1.5" fill="#fff"/><polygon points="15,26 16.5,30 20,29 18,32 20.5,35 17,35 15,38 13,35 9.5,35 12,32 10,29 13.5,30" fill="#fff"/></svg>';
        case 'usa':
        case 'us':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" style="border-radius:2px;box-shadow:0 0 1px rgba(0,0,0,0.3);flex-shrink:0;" aria-hidden="true"><rect width="60" height="40" fill="#fff"/><path d="M0,3.1h60 M0,9.2h60 M0,15.4h60 M0,21.5h60 M0,27.7h60 M0,33.8h60 M0,40h60" stroke="#B22234" stroke-width="3.1"/><rect width="26" height="21.5" fill="#3C3B6E"/><circle cx="5.5" cy="4.5" r="1.1" fill="#fff"/><circle cx="13" cy="4.5" r="1.1" fill="#fff"/><circle cx="20.5" cy="4.5" r="1.1" fill="#fff"/><circle cx="9.25" cy="9.5" r="1.1" fill="#fff"/><circle cx="16.75" cy="9.5" r="1.1" fill="#fff"/><circle cx="5.5" cy="14.5" r="1.1" fill="#fff"/><circle cx="13" cy="14.5" r="1.1" fill="#fff"/><circle cx="20.5" cy="14.5" r="1.1" fill="#fff"/></svg>';
        case 'ireland':
        case 'ie':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" style="border-radius:2px;box-shadow:0 0 1px rgba(0,0,0,0.3);flex-shrink:0;" aria-hidden="true"><rect width="20" height="40" fill="#169B62"/><rect x="20" width="20" height="40" fill="#ffffff"/><rect x="40" width="20" height="40" fill="#FF883E"/></svg>';
        case 'dubai':
        case 'ae':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" style="border-radius:2px;box-shadow:0 0 1px rgba(0,0,0,0.3);flex-shrink:0;" aria-hidden="true"><rect width="60" height="13.33" fill="#00732F"/><rect y="13.33" width="60" height="13.33" fill="#ffffff"/><rect y="26.66" width="60" height="13.34" fill="#000000"/><rect width="17" height="40" fill="#FF0000"/></svg>';
        case 'france':
        case 'fr':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" style="border-radius:2px;box-shadow:0 0 1px rgba(0,0,0,0.3);flex-shrink:0;" aria-hidden="true"><rect width="20" height="40" fill="#002654"/><rect x="20" width="20" height="40" fill="#ffffff"/><rect x="40" width="20" height="40" fill="#CE1126"/></svg>';
        case 'europe':
        case 'eu':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" style="border-radius:2px;box-shadow:0 0 1px rgba(0,0,0,0.3);flex-shrink:0;" aria-hidden="true"><rect width="60" height="40" fill="#003399"/><circle cx="30" cy="8" r="1.4" fill="#FFCC00"/><circle cx="36" cy="9.6" r="1.4" fill="#FFCC00"/><circle cx="40.4" cy="14" r="1.4" fill="#FFCC00"/><circle cx="42" cy="20" r="1.4" fill="#FFCC00"/><circle cx="40.4" cy="26" r="1.4" fill="#FFCC00"/><circle cx="36" cy="30.4" r="1.4" fill="#FFCC00"/><circle cx="30" cy="32" r="1.4" fill="#FFCC00"/><circle cx="24" cy="30.4" r="1.4" fill="#FFCC00"/><circle cx="19.6" cy="26" r="1.4" fill="#FFCC00"/><circle cx="18" cy="20" r="1.4" fill="#FFCC00"/><circle cx="19.6" cy="14" r="1.4" fill="#FFCC00"/><circle cx="24" cy="9.6" r="1.4" fill="#FFCC00"/></svg>';
        case 'italy':
        case 'it':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" style="border-radius:2px;box-shadow:0 0 1px rgba(0,0,0,0.3);flex-shrink:0;" aria-hidden="true"><rect width="20" height="40" fill="#009246"/><rect x="20" width="20" height="40" fill="#ffffff"/><rect x="40" width="20" height="40" fill="#CE2B37"/></svg>';
        case 'newzealand':
        case 'nz':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" style="border-radius:2px;box-shadow:0 0 1px rgba(0,0,0,0.3);flex-shrink:0;" aria-hidden="true"><rect width="60" height="40" fill="#00247D"/><path d="M0,0 L30,20 M30,0 L0,20" stroke="#fff" stroke-width="4"/><path d="M0,0 L30,20 M30,0 L0,20" stroke="#CC142B" stroke-width="2"/><path d="M15,0 v20 M0,10 h30" stroke="#fff" stroke-width="6"/><path d="M15,0 v20 M0,10 h30" stroke="#CC142B" stroke-width="3"/><polygon points="45,8 46.2,11.7 50,11.7 47,13.9 48.2,17.5 45,15.3 41.8,17.5 43,13.9 40,11.7 43.8,11.7" fill="#CC142B" stroke="#fff" stroke-width="0.8"/><polygon points="52,18 53,20.8 56,20.8 53.6,22.4 54.5,25.2 52,23.5 49.5,25.2 50.4,22.4 48,20.8 51,20.8" fill="#CC142B" stroke="#fff" stroke-width="0.8"/><polygon points="45,30 46.2,33.7 50,33.7 47,35.9 48.2,39.5 45,37.3 41.8,39.5 43,35.9 40,33.7 43.8,33.7" fill="#CC142B" stroke="#fff" stroke-width="0.8"/><polygon points="38,20 39,22.8 42,22.8 39.6,24.4 40.5,27.2 38,25.5 35.5,27.2 36.4,24.4 34,22.8 37,22.8" fill="#CC142B" stroke="#fff" stroke-width="0.8"/></svg>';
        case 'singapore':
        case 'sg':
            return '<svg viewBox="0 0 60 40" width="' . $w . '" height="' . $h . '" style="border-radius:2px;box-shadow:0 0 1px rgba(0,0,0,0.3);flex-shrink:0;" aria-hidden="true"><rect width="60" height="20" fill="#ED2939"/><rect y="20" width="60" height="20" fill="#fff"/><circle cx="12" cy="10" r="6" fill="#fff"/><circle cx="14" cy="10" r="5" fill="#ED2939"/><circle cx="18" cy="10" r="1" fill="#fff"/><circle cx="16" cy="7" r="1" fill="#fff"/><circle cx="16" cy="13" r="1" fill="#fff"/><circle cx="13" cy="8" r="1" fill="#fff"/><circle cx="13" cy="12" r="1" fill="#fff"/></svg>';
        default:
            return '<svg width="' . $w . '" height="' . $h . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;"><circle cx="12" cy="12" r="10"/><path d="m4.93 4.93 4.24 4.24"/><path d="m14.83 9.17 4.24-4.24"/><path d="m14.83 14.83 4.24 4.24"/><path d="m9.17 14.83-4.24 4.24"/></svg>';
    }
}

}
