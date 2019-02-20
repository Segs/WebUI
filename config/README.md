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
_default:_ `$site_title             = "SEGS";`

#### $site_name  
_default:_ `$site_name              = "SEGS";`

#### $site_url   
_default:_ `$site_url               = "https://segs.io";`

#### $site_logo  
_default:_ `$site_logo              = "https://github.com/Segs/Segs/raw/develop/docs/segs-medallion-med.png";`

#### $site_admin 
_default:_ `$site_admin             = "webmaster@example.com";`

#### $site_color        
_default:_ `$site_color             = "gold";`

Some Site colors are able to be customized using this setting. also changes web page card colors. The following
colors are available: `dark | gold | purple | azure | green | orange | danger`

#### $site_navbar_title
_default:_ `$site_navbar_title      = "SEGS WebUI";`


### Database Settings
#### $dbhost
_default:_ `$dbhost                 = "localhost";`

#### $dbuser
_default:_ `$dbuser                 = "segsadmin";`

#### $dbpass
_default:_ `$dbpass                 = "segs123";`

#### $accdb 
_default:_ `$accdb                  = "segs";`

#### $chardb
_default:_ `$chardb                 = "segs_game";`


### User Account Settings;

#### $min_username_len
_default:_ `$min_username_len       = 6;`

#### $min_password_len
_default:_ `$min_password_len       = 6;`

#### $complex_password
_default:_ `$complex_password       = true;`

#### $login_users_on_create
_default:_ `$login_users_on_create  = false;`


### WebSocket connection

#### $ws_target
_default:_ `$ws_target              = "ws://localhost/";`

#### $ws_port
_default:_ `$ws_port                = 6001;`

#### $ws_use_ssl
_default:_ `$ws_use_ssl             = false;`


### Date and Time

#### $timezone
_default:_ `$timezone               = "UTC";`
