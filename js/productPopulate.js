/**
 * Created by Jason on 1/25/2016.
 */
/*
 <article class="productInfo"><!-- Each individual product description -->
 <div><img alt="sample" src="homepageAssets/whendots.png"></div>
 <p class="price">$4.99</p>

 <p class="productContent">When?</p>
 <input type="button" name="button" value="Buy" class="buyButton">
 </article>
 */

// Book Object constructor
Book = function(parseRef) {
    this.pobj = parseRef;
    var pobj = this.pobj;

    this.name = pobj.get("name");
    this.coverObj = pobj.get("cover");
    if (this.coverObj) {
        this.coverSrc = this.coverObj.url();
    }   else    {
        this.coverSrc = window.rootURL + window.brokenBookCoverURL;
    }
    this.authors = pobj.get("authors");
    this.designer = pobj.get("designer");
    this.bookID = pobj.get("bookID");
    this.bookURL = pobj.get("url");

    // Things not yet in the database, or not yet populated.
    this.price = pobj.get("price");

    // DOM element creation (lazy boolean for pretty folding)
    if (true) {
        this.elem = document.createElement("article");
        this.elem.setAttribute("class","productInfo");
        var contDiv = document.createElement("div");
        var coverImg = document.createElement("img");
        var priceP = document.createElement("p");
        var productP = document.createElement("p");
        var selectInput = document.createElement("input");

        coverImg.setAttribute("alt","sample");
        coverImg.setAttribute("src",this.coverSrc);
        priceP.setAttribute("class","price");
        priceP.innerHTML = numToPrice(this.price);
        productP.setAttribute("class","productContent");
        productP.innerHTML = this.name;
        selectInput.setAttribute("type","button");
        selectInput.setAttribute("name","button");
        selectInput.setAttribute("value","Buy");
        selectInput.setAttribute("class","buyButton");

        this.elem.appendChild(contDiv);
        contDiv.appendChild(coverImg);
        this.elem.appendChild(priceP);
        this.elem.appendChild(productP);
        this.elem.appendChild(selectInput);

        // Append this.elem to book pages divs.
    }
};

// productRow Object constructor
ProductRow = function(num) {
    this.num = num;
    this.slots = [];
    this.elem = document.createElement("div");
    this.elem.setAttribute("class","productRow");
    var rowComment = document.createComment(" " +
        addOrdinal(this.num + 1) + " row of book products (4 in row) ");
    this.elem.appendChild(rowComment);
    this.attachToDom = function() {
        $(".mainContent")[0].appendChild(this.elem);
    }
    this.addBook = function(ref) {
        if (this.slots.length < 4) {
            this.slots.push(ref);
            this.elem.appendChild(this.slots[this.slots.length-1].elem);
        }   else    {
            console.warn("Cannot attach book, all slots full. Please call the clear" +
                " method to make space");
            return false;
        }
    }
}

function loadBooks() {
    var P_Book = Parse.Object.extend("Books");
    var bookQuery = new Parse.Query(P_Book);
    bookQuery.equalTo("public",true);
    bookQuery.find({
        success: function(res) {
            for (var b = 0; b < res.length; b++) {
                window.books.push(new Book(res[b],false));
            }
            attachBooks(0,books.length);
        },
        error: function(e) {
            console.error("Parse database problem, error object:");
            console.error(e);
        }
    });
}
function attachBooks(startCount,endCount) {

    if (startCount != undefined && endCount != undefined) {
        // Make sure we've got some decent params
        if (endCount > books.length) {
            console.warn("Function call warning: endCount is greater than" +
                " window.books.length. endCount manually set to length of global array.");
            endCount = books.length;
        }

        // Clear out the mainContent of all dummy (init) or old stuff (recreate)
        $(".mainContent").html('');

        // TODO: Restructure this whole damn this as a do while. If you care enough.
        var createRow = function(which) {
            console.log("Make row " + which);
            if (productRows[which] == undefined) {
                productRows[which] = new ProductRow(which);
                productRows[which].attachToDom();
            }   else    {
                // Row already exists, clear it and reinsert book elements
            }
        }
        createRow(0);
        var curRow = 0;
        for (var b = startCount; b < endCount; b++) {
            var cur = books[b];
            productRows[curRow].addBook(books[b]);
            // ProductRow[curRow]
            if ((b + 1) % 4 == 0) {
                curRow++;
                createRow(curRow);
            }
        }
        console.clear();
        console.log(productRows[0]);
    }   else    {
        console.error("Function call error: No startCount or endCount given");
        return false;
    }
}


/*
<article class="productInfo">
    <div>
        <img alt="sample" src="pigswithdots.png" />
    </div>
    <p class="price">Free!</p>
    <p class="productContent">The Fourth Little Pig</p>
    <input type="button" name="button" value="Buy" class="buyButton">
</article>
 */