![Banner](https://github.com/rapiddev/Forward/blob/master/admin/img/forward-screen-1.png?raw=true)
# Forward
[Created with ![heart](http://i.imgur.com/oXJmdtz.gif) in Poland by RapidDev](https://rdev.cc/)<br />
Now you can have your own Bit.ly or Google URL shortener equivalent.
Forward is a simple PHP-based tool with which you can shorten links and collect statistics about activity.

## What data can I collect?
With the help of Forward you can collect information about:
- The number of clicks on the link
- The language of the browser the user has
- Where the click comes from (e.g., Facebook / YouTube)

## Dashboard
Simple intuitive interface modeled on Adobe and Bit.ly websites.
![Logo](https://github.com/rapiddev/Forward/blob/master/admin/img/forward-screen-2.png?raw=true)

## Database
The database is stored in the Flat-File format. That is, data was saved on the server in files.
Thanks to this you don't need MySQL or other expensive server like SQL. This solution is super fast and sufficient for Forward needs.

This wonderful solution was created by [Timothy Marois](https://github.com/tmarois/Filebase)

## Security
Forward uses a number of security features. User passwords are encrypted via SHA256 and Argon 2.
The session has a generated token, saved in the database, which is verified each time.
The htaccess blocks access to the database files.
Each Ajax query is verified by the SHA1 encrypted Nonce.

## What do we get?
- [x] Fast link management system
- [x] Automatic installation
- [x] A Flat-File database. You don't need MySQL!
- [x] Administration panel
- [x] Global statistics
- [x] The ability to create multiple users

## How to install it?
Simply upload files to your hosting using FTP or on your test environment. Installation will start from the root directory.
Just press "Install". It's easy: D

## Available full language versions
- [x] English