# Who's there?!

I wrote this tool because I had to confirm (every day!) the presence of a group of people. To do this,
everyone can click on his name after _login_, so he can confirm his presence and in the overview
his name comes green.

## Requirements
I wanted to keep it flexible, so the requirements are not that much:
  * Webserver running PHP
  * PHP must have write access to project directory

## Installation
```bash
$ cd /var/www/html  # or whatever document root
$ git clone https://github.com/h4ckct1c/whos-there
$ chown -R www-data:www-data .  # or whatever user php is running
$ echo '<?php $pins = [ "user1" => "1337", "user2" => "1338"]; ?>' > users.php
// optional:
$ echo '<?php $password = "myresetpassword"; ?>' > reset-password.php
```

## How it works
### Technical explanation
- File `users.php` stores "_credentials_" in PHP array variable called `$pins`
- Ever user in `$pins` array will be displayed as a button
- If a button is clicked and no _usr_ and _pin_ cookie is present, a login prompt appears
- If a button is clicked, cookies are present, and the user is matching the button, the user _is there_ and the color changes from red to green
and the timestamp is stored comma seperated in guys.txt
- If user _logs in_, a cookie storing _usr_ and _pin_ value is placed to remember the user
- Logout button removes _usr_ and _pin_ cookie

### Usage
- Click on your name (if not logged in), enter your pin and _you're there_
- To reset presence of guys:
    - visit `document_root/reset.php`, enter password (see optional step in Installation) OR
    - create a cronjob executing `/bin/sh -c ">/path/to/guys.txt"`

### Screenshots
[![](screenshots/Whos-There-Screenshot-1.png?raw=true)]
[![](screenshots/Whos-There-Screenshot-2.png?raw=true)]
[![](screenshots/Whos-There-Screenshot-3.png?raw=true)]
[![](screenshots/Whos-There-Screenshot-4.png?raw=true)]

## TODO:
- Write Readme
- Make screenshots
- Add Copyright / License
