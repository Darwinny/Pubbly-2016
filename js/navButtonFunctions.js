/**
 * Created by Jason on 2/18/2016.
 */

$(document).ready(function() {
    $("#mybooksbutton").click(function() {
        toggleLoginFirstCont();
    });

})

function toggleLoginFirstCont(force) {
    var THIS = this;
    var targHeight = $(".mainContent").first().height();
    var targWidth = $(".mainContent").first().width();
    this.openElem = function() {
        $("#loginFirstCover").attr("status","opened");
        $("#loginFirstCover").addClass("opened");
        $("#loginFirstCover").removeClass("closed");
        $("#loginFirstCover").css("height",targHeight);
        $("#loginFirstCover").css("width",targWidth);
    }
    this.closeElem = function() {
        $("#loginFirstCover").attr("status","closed");
        $("#loginFirstCover").addClass("closed");
        $("#loginFirstCover").removeClass("opened");
        $("#loginFirstCover").css("height",0);
        $("#loginFirstCover").css("width",0);
    }
    if (force) {
        if (force == "open") {
            THIS.openElem();
        }   else if (force == "close") {
            THIS.closeElem();
        }
    }   else    {
        var status = $("#loginFirstCover").attr("status");
        if (status == "opened") {
            THIS.closeElem();
        }   else if (status == "closed") {
            THIS.openElem();
        }
    }
}