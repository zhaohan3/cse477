/**
 * Created by agbaydan on 6/28/2017.
 */

Nurikabe.prototype.clear = function() {
    var that = this;
    console.log("clear function called!!");

    /************ LOOP THRU BOARD ************/
    // if cell is not int, set to vacant
    for(var r=0; r<this.gameBoard.length; r++){
        var row = this.gameBoard[r];
        for(var c=0; c<row.length; c++){
            var gameCell = this.gameBoard[r][c];
            if( isNaN(gameCell) ){
                console.log("NaN found!!");
                // set value and class to vacant
                this.gameBoard[r][c] = this.consts.VACANT;
                var boardCell = $(this.sel + " td#" + r+c);
                var currentClass = boardCell.attr('class');
                console.log(currentClass);
                boardCell.removeClass(currentClass);
                boardCell.addClass('vacant');
                boardCell.children('button').html('&nbsp;');
            }
        }
    }
};