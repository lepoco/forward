![Logo](https://github.com/rapiddev/Forward/blob/master/media/img/forward-logo-bk.png?raw=true)

# Forward

[Created with ![heart](http://i.imgur.com/oXJmdtz.gif) in Poland by RapidDev](https://rdev.cc/)<br />
Now you can have your own Bit.ly or Google URL shortener equivalent.
Forward is a simple PHP-based tool with which you can shorten links and collect statistics about activity.

## What data can I collect?

With the help of Forward you can collect information about:

- The number of clicks on the link
- The language of the browser the user has
- Browser and platform detection
- Where the click comes from (e.g., Facebook / YouTube)

## Dashboard

Simple intuitive interface inspired by Label Theme [https://www.uxcandy.co/](https://www.uxcandy.co/).
<br/><br/>
![Login form](https://github.com/rapiddev/Forward/blob/master/media/img/forward-screen-1.png?raw=true)
<br/><br/>
![Dashboard](https://github.com/rapiddev/Forward/blob/master/media/img/forward-screen-2.png?raw=true)
<br/><br/>
![Options](https://github.com/rapiddev/Forward/blob/master/media/img/forward-screen-3.png?raw=true)

## Security

Forward uses a number of security features. User passwords are encrypted via SHA256 and Argon 2.
The session has a generated token, saved in the database, which is verified each time.
Each Ajax query is verified by the SHA1 encrypted Nonce.

## Roles

- Administrator<br/>Has full permissions to do everything.
- Manager<br/>Can add and delete records. Cannot change settings or add users.
- Analyst<br/>Can only view data.

## What do we get?

- [x] Fast link management system
- [x] Automatic installation
- [x] Animated charts
- [x] Administration panel
- [x] User roles
- [x] Global statistics
- [x] Multilingual dashboard
- [x] The ability to create multiple users

## How to install it?

Simply upload files to your hosting using FTP or on your test environment. Installation will start from the root directory.
Just press "Install". It's easy: D

### Available full language versions

- [x] English
- [x] Polish

### Third party solutions

- Chart.js by the Chart.js Contributors<br/>[https://github.com/chartjs/Chart.js](https://github.com/chartjs/Chart.js)
- Bootstrap by the Bootstrap team<br/>[https://getbootstrap.com/](https://getbootstrap.com/)
- jQuery by the jQuery Foundation<br/>[https://jquery.org/](https://jquery.org/)
- Clipboard.js by the Zeno Rocha<br/>[https://github.com/zenorocha/clipboard.js/](https://github.com/zenorocha/clipboard.js/)
- Browser.php by Chris Schuld<br/>[https://github.com/cbschuld/Browser.php](https://github.com/cbschuld/Browser.php)
- Bootstrap Icons by the Bootstrap team<br/>[https://icons.getbootstrap.com/](https://icons.getbootstrap.com/)
- Material Design Icons by the Google and other creators | Maintained by Austin Andrews<br/>[https://materialdesignicons.com/](https://materialdesignicons.com/)
- Questrial font by the Joe Prince<br/>[https://fonts.google.com/specimen/Questrial](https://fonts.google.com/specimen/Questrial)
- node-qrcode by the Ryan Day<br/>[https://github.com/soldair/node-qrcode](https://github.com/soldair/node-qrcode)
- Design inspired by the Label Theme<br/>[https://www.uxcandy.co/](https://www.uxcandy.co/)
- Background images by Marcin Jóźwiak<br/>[https://www.pexels.com/@marcin-jozwiak-199600](https://www.pexels.com/@marcin-jozwiak-199600)
- Background images by Adam Borkowski<br/>[https://www.pexels.com/@borkography](https://www.pexels.com/@borkography)
- Background images by Josh Hild<br/>[https://www.pexels.com/@josh-hild-1270765](https://www.pexels.com/@josh-hild-1270765)
