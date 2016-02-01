/**
 * Created by Jason on 1/27/2016.
 */
/*
 Purpose of a chainLoader you ask?

 I want to keep my head buried in javascript exclusively. And yes, github is amazing
 and stuff, but if the one and only link between Susan's HTML and my JS is a single
 custom js file, things just work better.
 */

var scriptsToLoad = [
    "js/globals",
    "js/helper",
    "js/productPopulate"
];
$(document).ready(function () {
    for (var s = 0; s < scriptsToLoad.length; s++) {
        $.getScript(scriptsToLoad[s] + ".js")
            .done(function (script, textStatus) {
                scriptLoadedCallback();
            })
            .fail(function (jqxhr, settings, exception) {
                console.error("Fatal script load error on " + exception + "");
                console.error(jqxhr);
                // TODO: Better error handling. Can't hide a "FATAL MISSING SCRIPT"
                // error in the damn console.
            });
    }
    var scriptsNeeded = scriptsToLoad.length;
    var scriptsGot = 0;

    function scriptLoadedCallback() {
        scriptsGot++;
        if (scriptsGot >= scriptsNeeded) {
            allScriptsLoaded();
        }
    }
});

// First function called.
function allScriptsLoaded() {
    loadBooks();
}