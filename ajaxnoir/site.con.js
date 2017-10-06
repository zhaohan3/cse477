/*! DO NOT EDIT ajaxnoir 2017-06-27 */
/**
 * Created by agbaydan on 6/26/2017.
 */
function Login(sel) {
    var form = $(sel);
    form.submit(function(event) {
        event.preventDefault();

        console.log("Submitted");

        $.ajax({
            url: "post/login.php",
            data: form.serialize(),
            method: "POST",
            success: function(data) {
                var json = parse_json(data);
                console.log(json);
                if(json.ok) {
                    // Login was successful
                    window.location.assign("./");

                } else {
                    // Login failed, a message is in json.message
                    $(sel + " .message").html("<p>" + json.message + "</p>");
                }
            },
            error: function(xhr, status, error) {
                // An error!
                console.log(error);
                $(sel + " .message").html("<p>Error: " + error + "</p>");
            }
        });
    });
}
/**
 * Created by agbaydan on 6/26/2017.
 */
function MovieInfo(sel, title, year) {
    console.log("MovieInfo: " + title + "/" + year);
    this.sel = sel;
    var that = this;

    $.ajax({
        url: "https://api.themoviedb.org/3/search/movie",
        data: {api_key: "7732627d0f99b9b50762bfd3a1f4869b", query: title, year: year},
        method: "GET",
        dataType: "text",
        success: function(data) {
            console.log("success");
            var json = parse_json(data);
            if(json.total_results === 0){
                console.log("nothing found");
                $(that.sel).html("<p>No information available</p>");
            }
            else{
                var html = '';
                console.log(json);
                html += that.info(json);
                html += that.plot(json);
                if(json.results[0].poster_path !== null) {
                    html += that.poster(json);
                }
                that.displayMovieInfo(html);
            }
        },
        error: function(xhr, status, error) {
            // Error
            console.log("failure");
            $(that.sel).html("<p>Unable to communicate<br>with themoviedb.org</p>");
        }
    });
}

MovieInfo.prototype.info = function (json) {
    var that = this;
    var result = '<li><a href=""><img src="images/info.png"></a><div>';

    result += '<p>Title: ' + json.results[0].title + '</p>';
    result += '<p>Release Date: ' + json.results[0].release_date + '</p>';
    result += '<p>Vote average: ' + json.results[0].vote_average + '</p>';
    result += '<p>Vote count: ' + json.results[0].vote_count + '</p>';

    result += '</div></li>';
    return result;
};

MovieInfo.prototype.plot = function (json) {
    var that = this;
    var result = '<li><a href=""><img src="images/plot.png"></a><div>';

    result += '<p>' + json.results[0].overview + '</p>';

    result += '</div></li>';
    return result;

};

MovieInfo.prototype.poster = function (json) {
    var that = this;
    var result = '<li><a href=""><img src="images/poster.png"></a><div>';

    result += '<p class="poster"><img src="http://image.tmdb.org/t/p/w500' + json.results[0].poster_path + '">';

    result += '</div></li>';
    return result;

};

MovieInfo.prototype.displayMovieInfo = function (html) {
    var final_html = "<ul>" + html + "</ul>";
    $(this.sel).html(final_html);
    //console.log($("ul > li:first-child").children("a").children());
    var info = $("ul > li:first-child");
    info.children("div").show();
    info.children("a").children().css("opacity", "1");


    $("ul > li > a").click(function (event) {
        event.preventDefault();
        console.log("tag clicked");

        //console.log($(this).parent().siblings().children("a").children());
        $(this).parent().siblings().children("div").fadeOut(750);
        $(this).parent().siblings().children("a").children().css("opacity", "0.3");

        //console.log($(this).parent().children("a").children());
        $(this).parent().children("div").fadeIn(750);
        $(this).parent().children("a").children().css("opacity", "1");
    });
};
/**
 * Created by agbaydan on 6/26/2017.
 */
function parse_json(json) {
    try {
        var data = $.parseJSON(json);
    } catch(err) {
        throw "JSON parse error: " + json;
    }

    return data;
}
/**
 * Created by agbaydan on 6/26/2017.
 */
function Stars(sel) {
    this.sel = sel;
    console.log("Stars constructor");
    var table = $(sel + " table");  // The table tag

    // Loop over the table rows
    var rows = table.find("tr");    // All of the table rows
    for(var r=1; r<rows.length; r++) {
        // Get a row
        var row = $(rows.get(r));

        // Determine the row ID
        var id = row.find('input[name="id"]').val();

        // Find and loop over the stars, installing a listener for each
        var stars = row.find("img");
        for(var s=0; s<stars.length; s++) {
            var star = $(stars.get(s));

            // We are at a star
            this.installListener(row, star, id, s+1);
        }
    }

}

Stars.prototype.installListener = function(row, star, id, rating) {
    var that = this;

    star.click(function() {
        var table = $(that.sel + " table");
        $.ajax({
            url: "post/stars.php",
            data: {id: id, rating: rating},
            method: "POST",
            success: function(data) {
                var json = parse_json(data);
                if(json.ok) {
                    // Successfully updated
                    that.update(row, rating);
                    that.message("<p>Successfully updated</p>");
                    that.updateTable(json.movies);
                    that = new Stars(that.sel);
                }
                else {
                    // Update failed
                    that.message("<p>Update failed</p>");
                }
            },
            error: function(xhr, status, error) {
                // Error
                that.message("<p>Error: " + error + "</p>");
            }
        });
    });
};

Stars.prototype.update = function(row, rating) {

    // Loop over the stars, setting the correct image
    var stars = row.find("img");
    for(var s=0; s<stars.length; s++) {
        var star = $(stars.get(s));

        if(s < rating) {
            star.attr("src", "images/star-green.png")
        } else {
            star.attr("src", "images/star-gray.png");
        }
    }

    var num = row.find("span.num");
    num.text("" + rating + "/10");
};

Stars.prototype.message = function(message) {
    var that = this;
    $(this.sel + " .message").show();
    $(this.sel + " .message").html(message);
    window.setTimeout(function () {
        $(that.sel + " .message").fadeOut(1000);
    }, 2000);
};

Stars.prototype.updateTable = function (table) {
    var that = this;
    $(this.sel + " .table").hide();
    $(this.sel + " .table").html(table);
    $(this.sel + " .table").fadeIn(1000);
};