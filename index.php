<?php

//don't show strict warnings.  xataface group.. Re: Getting messages: Strict Standards: Only variables should be assigned by reference errors
//  ini_set('display_errors', '0');     # don't show any errors...
//  error_reporting(E_ALL | E_STRICT);  # ...but do log them
//report all errors for debugging...
// error_reporting(E_ALL);
// ini_set('display_errors', 'on');
//

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
        // new AdminerLoginServers(),

        // new AdminerSimpleMenu(),
        new AdminerCollations(),
        new AdminerJsonPreview(),
        
        // these don't show on pematon adminer-custom..
        
        // adminer orig tables-filter
        // new AdminerTablesFilter(),
        // https://github.com/zhgabor/adminer-table-filter
        // new AdminerQuickFilterTables,
        
        // https://github.com/arxeiss/Adminer-HideTables
        new AdminerTablesHide(),
        
        
        //  allow sqlite with login-sqlite plugin and selecting sqlite3 system type and put full path to sqlite database file in database field.
        //  username and password on next line..
        new AdminerLoginSqlite("sladmin", password_hash("sl", PASSWORD_DEFAULT)),

        // pematon - AdminerTheme has to be the last one.
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
