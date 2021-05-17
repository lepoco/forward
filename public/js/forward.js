/*!
 * Forward 2.0.2 (https://github.com/rapiddev/Forward)
 * Copyright 2018-2021 RapidDev
 * Licensed under MIT (https://github.com/rapiddev/Forward/blob/master/LICENSE)
 */

'use strict';
Array.prototype.forEach || (Array.prototype.forEach = function(r) { let t = this.length; if ("function" != typeof r) throw new TypeError; for (let o = arguments[1], h = 0; h < t; h++) h in this && r.call(o, this[h], h, this) });

import Forward from './common/core.min.js';

const importPageModule = async(modulePath) => {
    let module
    try {
        module = await
        import (modulePath)
    } catch (e) {
        Forward.console(`Unable to import module ${modulePath}`)
    }
    return module
}

console.log("==============================\nForward \nversion: " + forward._version + "\nCopyright © 2019-2021 RapidDev\nhttps://rdev.cc/\n==============================");
document.addEventListener('DOMContentLoaded', function() {

    if (forward.usernonce != jQuery('head').attr('user-nonce')) {
        console.log(forward);
        if (forward.page == 'install') {
            import ('./page-install.min.js').then(obj => Install).catch(err => function() { Forward.console('Failed to load Install module') });
        } else {
            throw new Error('User nonce compliance not detected.!');
        }
    }
    Forward.console('Base url: ' + forward.baseurl);
    if (forward.pagenow != 'home') {
        Forward.console('Ajax gate: ' + forward.ajax);
    }
    Forward.console('Page now: ' + forward.pagenow);
    Forward.console('Nonce: ' + forward.usernonce);

    (async() => {
        await
        import ('./common/forms.min.js').then(obj => Forms).catch(err => function() { Forward.console('Failed to load Forms module') });
        await
        import ('./common/globals.min.js').then(obj => Globals).catch(err => function() { Forward.console('Failed to load Globals module') });

        (function() {
            //Current view model
            importPageModule('./views/page-' + forward.pagenow + '.min.js');
        }());

        Forward.console('Forward have loaded correctly.');
    })();
});