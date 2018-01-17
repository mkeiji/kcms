
/*
 Script name: kScript.js
 Description: Used to manage the K' website
 Author: Keiji (guilherme maeda)
 Date Created: 2016 nov 03
 */

/************************* INITIALIZERS *****************************/

/*
 Script LOADER
 */
function load() {

    /*JQuery for animated scrolling*/
    $(document).ready(function(){
        $('a[href*=#]').click(function() {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
                && location.hostname == this.hostname) {
                var $target = $(this.hash);
                $target = $target.length && $target
                    || $('[name=' + this.hash.slice(1) +']');
                if ($target.length) {
                    var targetOffset = $target.offset().top;
                    $('html,body')
                        .animate({scrollTop: targetOffset}, 1000);
                    return false;
                }
            }
        });
    });
}

/************************* EVENT LISTENERS *****************************/
//executing functions onLoad
document.addEventListener('DOMContentLoaded', load, false);