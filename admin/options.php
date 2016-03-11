<div class="wrap" style="margin-top: 15px;">
    <h2>
        <a href="http://www.justimmo.at"><img src="/wp-content/plugins/justimmo/img/logo.png" alt="" style="vertical-align: middle; margin-right: 15px"></a>
        JUSTIMMO API Settings</h2>
    <br>

    <form name="ji_admin_form" method="post" action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <p>
            <input type="hidden" name="ji_admin_form[action]" value="Y">
            <label for="ji_admin_form[user]"><strong>Benutzername</strong></label>
            <input type="text" name="ji_admin_form[user]" value="<?php echo get_option('justimmo_plugin_username'); ?>">
            <label for="ji_admin_form[password]"><strong>Passwort</strong></label>
            <input type="password" name="ji_admin_form[password]"
                   value="<?php echo get_option('justimmo_plugin_password'); ?>">
            <input type="submit" value="Speichern" class="button">
        </p>
        <?php /*
        <p>
        <label for="ji_admin_form[url_prefix]"><strong>Url-Prefix</strong></label>
        <input type="text" name="ji_admin_form[url_prefix]" value="<?php echo get_option('justimmo_plugin_url_prefix', 'immobilien'); ?>">
        </p>
        */ ?>
    </form>

    <div style="float: left; width: 300px; margin-right: 15px;"><h3>Das JUSTIMMO API Plugin</h3>

        <p>Um dieses Plugin erfolgreich nutzen zu können, benötigen Sie einen gültigen JUSTIMMO Zugang.<br/>Ihre API
            Zugangsdaten finden Sie unter:
            <br/><em>Exporte &raquo; JUSTIMMO API</em></p>
    </div>

    <div style="float: left; width: 250px;">
        <h3>Wichtige JUSTIMMO Links</h3>

        <p>&raquo; <a href="http://www.justimmo.at" target="_blank">JUSTIMMO Homepage</a><br/>
            &raquo; <a href="http://www.justimmo.at/wordpress-plugin" target="_blank">JUSTIMMO Wordpress Plugin</a><br/>
            &raquo; <a href="https://service.justimmo.at" target="_blank">JUSTIMMO Verwaltungssoftware</a>
        </p>

    </div>
    <div style="clear:both;"></div>

    <div style="width: 720px;">
        <h3>Dokumentation / Setup</h3>
        <h4>1.) Hinterlegen des API Usernamens und API Passwortes</h4>

        <p>
            Bitte geben Sie Ihren <strong>API USERNAMEN</strong> und <strong>API PASSWORT</strong> in die vorgesehenen
            Felder ein und klicken Sie den Button <strong>speichern</strong>.
        </p>

        <h4>2.) Menüpunkt anlegen</h4>

        <p>
            Bitte navigieren Sie zu dem Menüpunkt "Design &raquo; Menüs". Hier finden Sie die Box "Links" fügen Sie dort
            folgenden Text ein "index.php?ji_plugin=search&reset=filter" und geben Sie z.B. als Titel Immobilien an. Nun
            klicken Sie auf den Button
            "Zum Menü hinzufügen" und speichern Sie Ihre Änderungen.
        </p>


        <h4>3.) Widget hinzufügen</h4>

        <p>
            Das JUSTIMMO WP Plugin ist "widget ready". Widget "JUSTIMMO Suchbox". <br/><br/>
            <strong><em>Wie aktiviere ich das Widget?</em></strong><br/>
            Bitte navigieren Sie zum dem Menüpunkt "Design &raquo; Widgets" und ziehen einfach das Widget "JUSTIMMO
            Suchbox" in die JUSTIMMO Sidebar. Hier haben Sie noch die Möglichkeit, einen Titel für die Suchbox zu
            vergeben.
        </p>

        <h4>4.) Shortcodes</h4>

        <p>
            Das Plugin stellt auch zwei Shortcodes zur Verfügung:<br/><br/>
            [justimmo_realty_list]<br/>
            Liste von Immobilien die als Seiteninhalt verwendet werden können (zb. Topimmobilien)<br/><br/>
            [justimmo_search_form]<br/>
            Suchformular das zb. als schneller Einstieg in der Startseite verwendet werden kann.<br/>
        </p>
    </div>
    <div style="border-top:1px solid #efefef; padding-top: 10px;">
        &copy; 2016 by justimmo.at | <a href="http://www.bgcc.at" target="_blank">bgcc.at</a>
    </div>
</div>
