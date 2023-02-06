/*! 
iframe-crossdomain-communication v1.0.0 | (c) 2015 FranceTelevisions Editions Numeriques 

The MIT License (MIT)

Copyright (c) 2015 FranceTelevisions Editions Numériques

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

*/

(function(window, document) {
    "use strict";

    var receiveCallbackList = {};

    var iframeComParent = {

        // Send a message to the iframe. Make sure it can handle it.
        // iframeElement is the domElement of the iframe
        // id can be any string except "width" or "height".
        // payload can be a number, a string, an array, a JSON object.
        sendCustomMessage: function(iframeElement, id, payload) {
            send(iframeElement, id, payload);
        },

        // The callback function is called when the parent window sends a message with the specified id
        // iframeElement is the domElement of the iframe
        onCustomMessageReceived: function(id, callback) {
            receiveCallbackList[id] = callback;
        },

        setFullscreen: function(domElement) {
            enterFullScreen(domElement);
        },

        removeFullscreen: function(domElement) {
            leaveFullScreen(domElement);
        }
    };

    function send(iframeElement, id, payload) {
        if (!iframeElement || !iframeElement.contentWindow || !iframeElement.contentWindow.postMessage) {
            return;
        }

        var stringToSend = JSON.stringify({
            id: id,
            payload: payload
        });

        iframeElement.contentWindow.postMessage(stringToSend, '*');
    }
    
    function onMessageReceived(event) {
        var data = JSON.parse(event.data);

        if (!data.id) {
            return;
        }

        if (data.id === 'width' || data.id === 'height' || data.id === 'autoHeight' || data.id === 'fullscreen') {
            var iframe = findIframeBySrc(data.href);

            if (data.id === 'width') {
                iframe.style.width = data.payload + 'px';
            } else if (data.id === 'height') {
                iframe.style.height = data.payload + 'px';
            } else if (data.id === 'autoHeight') {
                iframe.style.height = 'auto'; // necessary, otherwise a smaller height cannot be detected
                send(iframe, 'whatsYourHeight?');
            } else if (data.id === 'fullscreen') {
                if (data.payload === true) {
                    enterFullScreen(iframe);
                } else {
                    leaveFullScreen(iframe);
                }
            }

        } else {
            
            // Any other message
            var fn = receiveCallbackList[data.id];
            if (typeof fn === 'function') {
                fn(data.payload);
            }
        }
    }

    function enterFullScreen(domElement) {
        if (domElement.requestFullscreen) {
            domElement.requestFullscreen();
        } else if (domElement.mozRequestFullScreen) {
            domElement.mozRequestFullScreen();
        } else if (domElement.webkitRequestFullScreen) {
            domElement.webkitRequestFullScreen();
        } else if (domElement.msRequestFullScreen) {
            domElement.msRequestFullScreen();
        } else {
            // Non compatible browsers (IE 10 and less + mobile browsers)
            alert('Votre navigateur n\'est pas compatible avec le mode "full screen"');
            // TODO one day: enlarge domElement and listen to "Esc" keypress
        }
    }

    function leaveFullScreen(domElement) {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozExitFullscreen) {
            document.mozExitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        } else {
            // Non compatible browsers (IE 10 and less + mobile browsers)
        }
    }

    function findIframeBySrc(href) {
        var iframes = document.querySelectorAll('iframe');
        for (var i = 0; i < iframes.length; i++) {
            if (iframes[i].src === href) {
                return iframes[i];
            }
        }
        return iframes[0];
    }

    if (window.addEventListener) {
        window.addEventListener('message', onMessageReceived, false);
    } else {
        window.attachEvent('onmessage', onMessageReceived);
    }

    window.framester = window.framester || {};
    window.framester.iframeComParent = iframeComParent;

})(this, this.document);