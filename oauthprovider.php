<?php
/**
 * Name: oauthprovider
 * Description: Manage apps that support "log in with Friendica"
 * Version: 0.1
 * Author: Ben Millwood <https://superstimul.us/profile/meblin>
 * Maintainer: Ben Millwood <https://superstimul.us/profile/meblin>
 * Status: Unsupported
 */

use Friendica\Core\Logger;
use Friendica\Core\Renderer;
use Friendica\Database\DBA;

function oauthprovider_install() {
    Logger::notice("oauthprovider installed");
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
        '$optional' => ' (optional)',
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
        $copy_keys = ["name", "redirect_uri", "website", "scopes"];
        foreach($copy_keys as $k) {
            $app[$k] = $_POST[$k];
        }
        $app["client_id"] = base64url(random_bytes(24));
        $app["client_secret"] = base64url(random_bytes(32));
        if (!DBA::insert("application", $app)) {
            throw new HTTPException\ServiceUnavailableException(DBA::errorMessage());
        }
    }
}
?>
