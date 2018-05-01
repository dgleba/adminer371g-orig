<?php

function adminer_object()
{
    // Required to run any plugin.
    include_once "./plugins/plugin.php";

    // Plugins auto-loader.
    foreach (glob("plugins/*.php") as $filename) {
        include_once "./$filename";
    }

    // Specify enabled plugins here.
    $plugins = [
        // new AdminerDatabaseHide(["mysql", "information_schema", "performance_schema"]),
        // new AdminerLoginServers([
            // filter_input(INPUT_SERVER, 'HTTP_HOST') => filter_input(INPUT_SERVER, 'SERVER_NAME')
        // ]),
        // new AdminerSimpleMenu(),
        // new AdminerCollations(),
        // new AdminerJsonPreview(),
        
        // AdminerTheme has to be the last one.
        // new AdminerTheme(),
    ];
        
        
    /* It is possible to combine customization and plugins:
       // https://stackoverflow.com/questions/46186925/how-do-i-extend-adminer-to-support-sqlite-databases-with-login
        https://sourceforge.net/p/adminer/discussion/1095138/thread/7dcb8ebf/
    */
    class AdminerCustomization extends AdminerPlugin {
      
        function login($login, $password) {
            global $jush;
            if ($jush == "sqlite")
                return ($login === 'admin') && ($password === 'changeme');
            return true;
        }

        function name() {
          return "<a href='adminer-theme-switcher.php'" . target_blank()  . " id='h5'>(ChangeTheme)</a>";
        }        
              
    }
   
    return new AdminerCustomization($plugins);
          

    // return new AdminerPlugin($plugins);
}

// Include original Adminer or Adminer Editor.
include "./adminer.php";

