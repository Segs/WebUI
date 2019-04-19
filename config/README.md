# SEGS WEBUI Configuration Settings

## Overview

The file `config_example.php` contains default settings for the SEGS WegUI. Copy the file to `config.php`, and at
minimum, change the following settings:

- $dbhost
- $dbuser
- $dbpass

## Setting Descriptions

### Site Settings

#### $site_title
_Default:_ `$site_title             	= "SEGS";`

_Description:_ The title that is displayed in the browser for the WebUI.

#### $site_name  
_Default:_ `$site_name              	= "SEGS";`

_Description:_ 

#### $site_url   
_Default:_ `$site_url               	= "https://segs.io";`

_Description:_ The URL for the site.

#### $site_logo  
_Default:_ `$site_logo              	= "//github.com/Segs/Segs/raw/develop/docs/segs-medallion-med.png";`

_Description:_ The location for the sidebar logo. It should be no larger than 250px x 250px.

#### $site_admin 
_Default:_ `$site_admin             	= "webmaster@example.com";`

_Description:_ The email users should contact if they run into an issue. 

#### $site_color        
_Default:_ `$site_color             	= "gold";`

_Description:_ Some Site colors are able to be customized using this setting. also changes web page card colors. The
following colors are available: `dark | gold | purple | azure | green | orange | danger`

#### $site_navbar_title
_Default:_ `$site_navbar_title      	= "SEGS WebUI";`

_Description:_ The text that is displayed on the horizontal navbar.


### Database Settings
#### $dbhost
_Default:_ `$dbhost                 	= "localhost";`

_Description:_ The IP or FQDN of the database server.

#### $dbport
_Default:_ `$dbport                 	= 3306;`

_Description:_ The port used by the database server.

#### $dbuser
_Default:_ `$dbuser                 	= "segsadmin";`

_Description:_ The username for the SEGS databases on the database server.

#### $dbpass
_Default:_ `$dbpass                 	= "segs123";`

_Description:_ The password for the SEGS databases on the database server.

#### $accdb 
_Default:_ `$accdb                  	= "segs";`

_Description:_ The name of the SEGS account database.

#### $chardb
_Default:_ `$chardb                 	= "segs_game";`

_Description:_ The name of the SEGS game database.


### User Account Settings;

#### $min_username_len
_Default:_ `$min_username_len       	= 6;`

_Description:_ Minimum number of characters required for a username. To disable, set to 1 or less. Any number less than
1 is automatically changed to 1 when evaluated, since at least one character is required for a username.

#### $min_password_len
_Default:_ `$min_password_len       	= 6;`

_Description:_ Minimum number of characters required for a password. To disable, set to 1 or less. Any number less than
0 is automatically changed to 0 when evaluated. This allows you to allow empty passwords using 0, or at least one or
more character using 1.

#### $complex_password
_Default:_ `$complex_password       	= true;`

_Description:_ Require complex passwords: At least 1 number, 1 lowercase letter, 1 uppercase letter, and 1 special
character (#$^+=!*()@%&). It is not evaluated if `$min_password_len` is less than 4.

#### $login_users_on_create
_Default:_ `$login_users_on_create  	= true;`

_Description:_ Enable or disable automatic user login after an account is successfully created.

#### $warn_pwned_password
_Default:_ `$warn_pwned_password        = false;`

_Description:_ Enable or disable Passprotect by Okta. See the 
[GitHub page](https://github.com/OktaSecurityLabs/passprotect-js) for more information.


### WebSocket connection

#### $ws_target
_Default:_ `$ws_target              	= "ws://localhost/";`

_Description:_ The target location for the WebSocket server. Verify that the SEGS AdminRPC server is using WebSocket and
not TCP. The AdminRPC server settings are configured and managed on the SEGS server in `settings.cfg`.

#### $ws_port
_Default:_ `$ws_port                	= 6001;`

_Description:_ The port that the SEGS AdminRPC server is using for WebSocket. The AdminRPC server settings are
configured and managed on the SEGS server in `settings.cfg`.

#### $ws_use_ssl
_Default:_ `$ws_use_ssl             	= false;`

_Description:_ Determines whether the WebUI connects to the AdminRPC WebSocket server using SSL/TLS encryption The
AdminRPC server settings are configured and managed on the SEGS server in `settings.cfg`.


### Date and Time

#### $timezone
_Default:_ `$timezone               	= "UTC";`

_Description:_ The timezone you want to use when displaying times in the dashboard. See the [List of Supported
 Timezones](http://php.net/manual/en/timezones.php).
