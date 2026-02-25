<?php
define("DOMAIN_CMS", "moira.club");
define("DOMAIN", "sensiboagency.com");
define("EMAIL", "info@sensiboagency.com");
define("SUBJECT", "Contact sensiboagency.com");
define("PASSWORD", 'mwseoOU820&e$thdjKKdl2');
define("APIURL", "https://cms-cache-api.d1b.pw/");
define("APIURL_NOCACHE", "https://cms-nocache-api.d1b.pw/");
define("STORAGE", "https://cms.d1b.pw/storage/");


function setSession()
{
    $domain_meta = [];


    $url = APIURL_NOCACHE . "domain/" . DOMAIN_CMS . "";


    if (empty($_SESSION['site_domain']) || (isset($_SESSION['site_domain']) && $_SESSION['site_domain'] != DOMAIN_CMS)) {

        if (null === ($domain_meta = fetch_domain_metadata($url))) {
            die("Error fetching domain!");
        }

        $_SESSION['access_token'] = $domain_meta['access_token'];
        $_SESSION['default_lang'] = $domain_meta['default_lang'];

        if ($_SESSION['default_lang'] == 'esp') {

            $_SESSION['default_lang'] = 'es';
        }

        $_SESSION['country'] = $domain_meta['countries']->default;
        $_SESSION['multi-country'] = "false";

        if (sizeof($domain_meta['countries']->supported) > 1) {

            $_SESSION['multi-country'] = "true";
        }

        foreach ($domain_meta['countries']->supported as $country) {

            if (isset($_GET['country']) && $_GET['country'] == $country->code) {

                $_SESSION['country'] = $country;
            }
        }

        $_SESSION['site_domain'] = $domain_meta['site_domain'];
        $_SESSION['site_name'] = $domain_meta['site_name'];
        $_SESSION['site_url'] = $domain_meta['site_url'];
        $_SESSION['site_email'] = $domain_meta['site_email'];
        $_SESSION['site_email_password'] = $domain_meta['site_email_password'];
        $_SESSION['homepage'] = $domain_meta['homepage'];
        $_SESSION['access_token'] = $domain_meta['access_token'];
        $_SESSION['logo'] = $domain_meta['logo'];
        $_SESSION['favicon'] = $domain_meta['favicon'];
        $_SESSION['header'] = $domain_meta['header'];
        $_SESSION['footer'] = $domain_meta['footer'];
        $_SESSION['web_menu'] = $domain_meta['web_menu'];
        $_SESSION['sidebar'] = $domain_meta['sidebar'];
        $_SESSION['css_file'] = $domain_meta['css_file'];
        $_SESSION['terms_disclaimer'] = $domain_meta['terms_disclaimer'];
        $_SESSION['template_option'] = $domain_meta['template_option'];
        $_SESSION['supported_langs'] = $domain_meta['supported_langs'];
        $_SESSION['default_lang'] = $domain_meta['default_lang'];
        $_SESSION['countries'] = $domain_meta['countries'];
        $_SESSION['details'] = $domain_meta['details'];
        $_SESSION['terms'] = $domain_meta['terms_disclaimer']['terms'];
        $_SESSION['disclaimer'] = $domain_meta['terms_disclaimer']['disclaimer'];
    }
}

function fetch_domain_metadata($url): array
{

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Cache-Control: no-cache'
    ]);

    $buffer = curl_exec($ch);
    curl_close($ch);
    $obj = json_decode($buffer);

    if (empty($obj) || ($obj->status !== 200 && !property_exists($obj, 'domain'))) {

        return [];
    }

    try {

        $domain = $obj->domain;

        $siteName = $domain->name;
        $siteUrl = "https://" . $domain->url;
        $siteDomain = $domain->url;
        $siteEmail = $domain->email;
        $siteEmailPassword = $domain->email_pass;
        $header = $domain->header ?? null;
        $footer = $domain->footer ?? null;
        $menu = $domain->web_menu ?? null;
        $sidebar = $domain->sidebar ?? null;
        $css_file = $domain->css_file ?? null;
        $access_token = $domain->access_token ?? null;
        $terms_disclaimer = $domain->terms_disclaimer ?? null;
        $logo = $domain->logo ?? null;
        $favicon = $domain->favicon ?? null;
        $homepage = $domain->homepage ?? null;
        $template_option = $domain->template_option ?? null;
        $supported_langs = $domain->supported_langs ?? null;
        $default_lang = $domain->default_lang ?? null;
        $countries = $domain->countries ?? null;
        $details = $domain->details ?? null;
        $terms = $terms_disclaimer->terms ?? null;
        $disclaimer = $terms_disclaimer->disclaimer ?? null;

        $t_c = [
            'terms' => $terms_disclaimer->terms,
            'disclaimer' => $terms_disclaimer->disclaimer,
        ];
    } catch (\Throwable $th) {
        throw $th;
        return [];
    }

    return [
        'site_name' => $siteName,
        'site_domain' => $siteDomain,
        'site_url' => $siteUrl,
        'site_email' => $siteEmail,
        'site_email_password' => $siteEmailPassword,
        'homepage' => $homepage,
        'access_token' => $access_token,
        'logo' => $logo,
        'favicon' => $favicon,
        'header' => $header,
        'footer' => $footer,
        'web_menu' => $menu,
        'sidebar' => $sidebar,
        'css_file' => $css_file,
        'terms_disclaimer' => $t_c,
        'template_option' => $template_option,
        'supported_langs' => $supported_langs,
        'default_lang' => $default_lang,
        'countries' => $countries,
        'details' => $details,
        'terms' => $terms,
        'disclaimer' => $disclaimer,
    ];
}


function getSection($section, $lang, $type)
{
    $url = APIURL . "content/section/" . $section . "/$lang";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $_SESSION['access_token'],
    ]);

    $response = json_decode(curl_exec($ch));
    $statusRequest = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($statusRequest == 200 && $response->status == 200) {

        return [$response->content->$type, $response->section_display_title];
    } elseif ($statusRequest == 401) {

        unset($_SESSION['site_domain']);

        if (isset($_SESSION['retries'])) {

            $_SESSION['retries'] = $_SESSION['retries'] + 1;
        } else {

            $_SESSION['retries'] = 1;
        }

        if ($_SESSION['retries'] > 2) {

            die("Error getting content!!");
        } else {

            setSession();
            return getSection($section, $lang, $type);
        }
    } else {

        die("Error getting content!");
    }
}

function get_item($article)
{
    $url = APIURL . "content/single-item/articles/" . $article . "/en";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $_SESSION['access_token'],
    ]);

    $response = json_decode(curl_exec($ch));
    $response = $response->content;
    $statusRequest = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $response;

}
?>