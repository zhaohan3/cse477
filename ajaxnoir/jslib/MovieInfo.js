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