<?php
// session_start();

/**
 * Verifies if the given $locale is supported in the project
 * @param string $locale
 * @return bool
 */
function valid($locale) {
    return in_array($locale, ['en_US', 'en', 'es_MX', 'es', 'id']);
}

$lang = 'es_MX';
//setting the source/default locale, for informational purposes
if(empty(session()->get('lang')) || !empty($_GET['lang'])){
    // echo "AAA";
    $lang = 'es_MX';

    if (isset($_GET['lang']) && valid($_GET['lang'])) {
        // the locale can be changed through the query-string
        $lang = $_GET['lang'];    //you should sanitize this!
        setcookie('lang', $lang); //it's stored in a cookie so it can be reused
    } elseif (isset($_COOKIE['lang']) && valid($_COOKIE['lang'])) {
        // if the cookie is present instead, let's just keep it
        $lang = $_COOKIE['lang']; //you should sanitize this!
    } elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        // default: look for the languages the browser says the user accepts
        $langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        array_walk($langs, function (&$lang) { $lang = strtr(strtok($lang, ';'), ['-' => '_']); });
        foreach ($langs as $browser_lang) {
            if (valid($browser_lang)) {
                $lang = $browser_lang;
                break;
            }
        }
        setcookie('lang', $lang, time() + (86400 * 30), "/");
    }
    session()->set('lang',$lang);
    // $_SESSION['CM']['lang'] = $lang;
}else{
    $lang = session()->get('lang');
    // $lang = $_SESSION['CM']['lang'];
}

$lang = explode("_", $lang)[0];

$jsonLang = file_get_contents(APPPATH."ThirdParty/locale/i18n_$lang.json");
$_TR = json_decode($jsonLang, true);
// print2(APPPATH."ThirdParty/locale/i18n_$lang.json");
// print2($_TR);
// exit();

define ('TR',$_TR);

function TR($strId){
    // global $_TR;

    if (empty(TR[$strId])) {
        return "*** $strId ***";
    }else{
        return TR[$strId];
    }
}


?>
