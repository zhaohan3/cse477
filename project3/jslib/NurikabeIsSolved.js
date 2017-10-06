/**
 * Created by agbaydan on 6/28/2017.
 */
Nurikabe.prototype.isSolved = function () {
    var that = this;

    if( this.gameBoard.toString() === this.gameSolution.toString() ){
        console.log("********** WINNER **********");
        // hide everything except for winner message
        $("#checkSolution").hide();
        $("#solve").hide();
        $("#clear").hide();

        $("#solveYes").hide();
        $("#solveNo").hide();
        $("#message-solve").hide();

        // show winning message
        $("#winner-message").show();

        // disable all cell buttons
        console.log($(this.sel + " td").children());
        $(this.sel + " td").children().attr("disabled", true);
        $(this.sel + " td").children().css("color", "black");
    }
};