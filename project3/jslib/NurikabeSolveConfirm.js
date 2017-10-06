/**
 * Created by agbaydan on 6/28/2017.
 */
Nurikabe.prototype.solveConfirm = function () {
    console.log("solve confirm!!");

    // hide check solution, solve, clear buttons
    $("#checkSolution").hide();
    $("#solve").hide();
    $("#clear").hide();

    // show yes no buttons and message
    $("#solveYes").show();
    $("#solveNo").show();
    $("#message-solve").show();
};