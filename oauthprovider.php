<?php
/**
 * Name: Manage OAuth clients
 * Description: Manage apps that use Friendica as an OAuth provider
 * Version: 0.1
 * Author: Ben Millwood <https://superstimul.us/profile/meblin>
 * Maintainer: Ben Millwood <https://superstimul.us/profile/meblin>
 * Status: Unsupported
 */

use Friendica\Core\Hook;
use Friendica\Core\Logger;
use Friendica\Core\Renderer;
use Friendica\Database\DBA;

function oauthprovider_install() {
    Hook::register('head', __FILE__, 'oauthprovider_head');
    Logger::notice("oauthprovider installed");
}

function oauthprovider_head() {
    \Friendica\DI::page()->registerStylesheet("addon/oauthprovider/style.css");
}

function oauthprovider_uninstall() {
    Logger::notice("oauthprovider uninstalled");
}

function oauthprovider_addon_admin(string &$o) {
    $apps = DBA::toArray(DBA::select(
        "application",
        ["name", "client_id", "client_secret", "redirect_uri", "website", "scopes"],
        []
    ));
    $t = Renderer::getMarkupTemplate("admin.tpl", "addon/oauthprovider");

    $o = Renderer::replaceMacros($t, [
        '$head_name' => 'Name',
        '$head_website' => 'Website',
        '$optional' => '(optional)',
        '$head_client_id' => 'Client ID',
        '$head_client_secret' => 'Client secret',
        '$head_redirect_uri' => 'Redirect URI',
        '$head_scopes' => 'Scopes',
        '$apps' => $apps,
        '$submit' => 'Generate client ID and secret',
    ]);
}

function base64url($bytes) {
    return rtrim(strtr(base64_encode($bytes), "+/", "-_"), "=");
}

function oauthprovider_addon_admin_post() {
    if(isset($_POST["delete"])) {
        DBA::delete("application", ["name" => $_POST["delete"]]);
        return;
    } else {
        $copy_keys = ["name", "redirect_uri", "website"];
        foreach($copy_keys as $k) {
            $app[$k] = $_POST[$k];
        }
        $scopes = [];
        foreach(["read", "write", "follow", "push"] as $scope) {
            $app[$scope] = isset($_POST[$scope]) && $_POST[$scope] == "on";
            if($app[$scope]) {
                $scopes[] = $scope;
            }
        }
        $app["scopes"] = implode(" ", $scopes);
        $app["client_id"] = base64url(random_bytes(24));
        $app["client_secret"] = base64url(random_bytes(32));
        if (!DBA::insert("application", $app)) {
            throw new HTTPException\ServiceUnavailableException(DBA::errorMessage());
        }
    }
}
?>
