/**
 * Created by Jason on 1/25/2016.
 *
 */

/* HERE BE GLOBALS
 *
 * And big global object declarations go here.
 * NOTE, value globals only.
 * Object constructors are still in their respective js file.
 */

/*
 * Book is a global array with each book object.
 * Created only once and attached to rows on the fly, all books can be reattached.
 * This should make the category reshuffle a bit easier.
 *
 * Books have an elem attribute, which contains all the dom elements required for
 * display. They also have the basic book info as root attributes.
 *
 */
window.books = [];

/*
 * productRows is an array of productRow elements. Each productRow has 4 book
 * elements, a method for attaching and clearing for category reshuffle.
 */
window.productRows = [];



/* AND NOW...!
 *
 * All the tweakable stuff, hopefully readable.
 * Susan,
 * before you ask me to change a specific color
 * or animation length or url come here first and see if
 * you can make the change yourself.
 */


/* TODO:
 *
 * Put in a check for what URL we're currently at, if it is the amazon server
 * then change this to www.Pubbly.com/Pubbly-2016, otherwise don't touch it.
 *
 * Switch to www.Pubbly.com/ once we go public.
 */
window.rootURL = "";

// No cover file in Parse database (Pubbly Market -> Books)
window.brokenBookCoverURL = "homepageAssets/brokenCover.png";

