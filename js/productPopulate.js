/**
 * Created by Jason on 1/25/2016.
 */

// Book Object constructor
Book = function(parseRef) {
    var pobj = parseRef;
    this.name = pobj.get("name");
    var coverObj = pobj.get("cover");
    if (this.coverObj) {
        this.coverSrc = coverObj.url();
    }   else    {
        this.coverSrc = window.rootURL + window.brokenBookCoverURL;
    }
    this.authors = pobj.get("authors");
    this.designer = pobj.get("designer");
    this.bookID = pobj.get("bookID");
    this.bookURL = pobj.get("url");

    // DOM element creation (lazy boolean for pretty folding)
    if (true) {
        this.elem = document.createElement("article");
        var contDiv = document.createElement("div");
        var coverImg = document.createElement("img");
        var priceP = document.createElement("p");
        var productP = document.createElement("p");
        var selectInput = document.createElement("input");

        coverImg.setAttribute("alt","sample");
        coverImg.setAttribute("src",this.coverSrc);
        priceP.setAttribute("class","price");
        productP.setAttribute("class","productContent");
        selectInput.setAttribute("type","button");
        selectInput.setAttribute("name","button");
        selectInput.setAttribute("value","Buy");
        selectInput.setAttribute("class","buyButton");

        this.elem.appendChild(contDiv);
        contDiv.appendChild(coverImg);
        // Can't get img into contDiv?
        this.elem.appendChild(coverImg);
        this.elem.appendChild(priceP);
        this.elem.appendChild(productP);
        this.elem.appendChild(selectInput);

        // Append this.elem to book pages divs.
    }
};

// productRow Object constructor
ProductRow = function(num) {
    //
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
            console.log(books[0]);
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
        if (endCount > books.length) {
            console.warn("Function call warning: endCount is greater than" +
                " window.books.length. endCount manually set to length of global array.");
            endCount = books.length;
        }
        var curRow = 0;
        for (var b = startCount; b < endCount; b++) {
            var cur = books[b];
            console.log("Append book " + b + " to row " + curRow);
            // ProductRow[curRow]
            if ((b + 1) % 4 == 0) {
                curRow++;
            }
        }
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