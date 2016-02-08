/**
 * Created by Jason on 1/28/2016.
 */

/*
 * Helper file
 *
 * Always have one of these. All quick and dirty functions here. For example, a
 * function that adds the proper ordinal (1st, 2nd, 3rd) to a number. Speaking of which...
 */

// Adds the 'st','nd','rd' or 'th' to a number. 1 -> 1st
function addOrdinal(num) {
    var ordinalObj = {
        1:"st",
        2:"nd",
        3:"rd",
    }
    var ord = ordinalObj[Math.abs(num)] || "th";
    return num + ord;
}

// Makes a price pretty. 4.99 -> $4.00, 1 -> $1.00, 0 -> Free!
function numToPrice(num) {
    if (num < 0) {
        // Negative? WHY??
        console.error("num:" + num);
        console.error("Stop being silly.");
    }   else if (num == 0) {
        // 0 -> Free!
        return "Free!";
    }   else if (num >= 1 && num.toString().split('.').length == 1) {
        // 1 -> $1.00, 27 -> $27.00
        return "$" + num + ".00";
    }   else if (!isNaN(num)) {
        return "$" + num;
    }   else {
        return "Not a number -> " + num;
    }
}