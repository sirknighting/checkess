<?php
/* 
    P is a checkers Pawn, C a checkers King, N a chess knight, B a chess Bishop, Q a chess queen, K a chess King, R a chess Rook, and ' ' a chess pawn.
*/
$move='';
    $checkerBoardRegex = "([W|B][P|C][A-H][1-8]){,24}";  //match and confirm Andrew's incoming string  __NEEDS TO BE TESTED
    function charToInt($c){
        return ord(strtolower($c))-96;
    }//upper case
    function intToChar($int){
        return strtoupper(chr($int+96));
    }//upper case
    function positionArrayToChessSquare($array){
        return intToChar($array[0]+1).($array[1]+1);
    }
    function chessSquareToPositionArray($chessSquare){
        return Array((charToInt(substr($chessSquare,0,1))-1),(intval(substr($chessSquare,1,1)))-1);
    }
    function createGamePiece($string){
        switch(substr($string,0,1)){
        }
        
    }//ANDREW
    function catchParseInput(){
		if(isset($_POST['fsend'])){
			$move = $_POST['fsend'];
			return $move;
		}
		return '    ';
    }//ANDREW, include pieces taken
    function main(){
    }//create objects of classes, start things etc --SAM
    function getVectorBetween($space1,$space2){
        $pos1=chessSquareToPositionArray($space1);
        $pos2=chessSquareToPositionArray($space2);
        return Array($pos2[0]-$pos1[0],$pos2[1]-$pos1[1]);
    }
    function applyVector($space, $vector){
        $pos=chessSquareToPositionArray($space);
        $pos[0]+=$vector[0];
        $pos[1]+=$vector[1];
        return positionArrayToChessSquare($pos);
    }
    class GameBoard {
		function __autoload(){
		}
        public $board = array(
            array("WP","","WP","","WP","","WP",""),//1
            array("","WP","","WP","","WP","","WP"),
            array("WP","","WP","","WP","","WP",""),//3
            array("","","","","","","",""),
            array("","","","","","","",""),
            array("","BP","","BP","","BP","","BP"),//6
            array("BP","","BP","","BP","","BP",""),
            array("","BP","","BP","","BP","","BP")//8
         );
        public $isWhitesTurn=TRUE;//is it white's turn?
        public $wasLastMoveCheckerJump=FALSE;//could just use a 'jumpingchecker'
        
        function spaceExists($space){//$space should be a string of form A1,B6, etc.
            return isset($this->board[$space[1]-1][charToInt($space[0])-1]);
        }
        
        function isValid($moveString){//UNTESTED
            $oldSquare=substr($moveString,0,2);
            $newSquare=substr($moveString,2,2);
            $changeVector=getVectorBetween($oldSquare,$newSquare);
            $xChange=$changeVector[0];//sideways
            $yChange=$changeVector[1];//forward/backward on the square
            unset($changeVector);
            if(!$this->spaceOpen($newSquare)){//if the space doesn't exist, or is not open, how could we move to it?(only for checkers pieces)
                return FALSE;
            }
            if(abs($xChange)!==abs($yChange)){//if the space isn't along a diagonal, of course it is invalid.
                return FALSE;
            }
            $piece=$this->getSpace($oldSquare);//now we look at what piece we are moving.
            $color=substr($piece,0,1);//W or B
            if(substr($piece,1,1)=='P'){//if the piece we are moving is a pawn, we need to test if the move is going in the right direction
                if(!(($yChange*(2*($color=='W')-1))>0)){//the ychange is negative if the piece is black, positive if the piece is white -- why does that look so racist...
                    return FALSE;
                }
            }
            switch(abs($xChange)){
                case 1: {//we are not jumping
                    return $this->spaceOpen($newSquare);//if we are only moving a single vector, is the target square empty?
                    //we have already made sure that the target square is empty, so we can just return true(sloppy/risky coding argument)
                }
                case 2: {//piece is jumping
                    //let's get the space that is in the middle of the two.
                    $midpoint=applyVector($oldSquare,Array($xChange/2,$yChange/2));
                    $pieceAtMidpoint=$this->getSpace($midpoint);
                    //If the space we are jumping over is empty, return false;
                    if($pieceAtMidpoint==''){
                        return FALSE;
                    }
                    //If the piece we are jumping over is of the same color, return false;
                    if(substr($pieceAtMidpoint,0,1)==$color){
                        return FALSE;
                    }
                    return TRUE;//If none of the above are conflicting, the move is good, and it can be done!       
                }
                default: return FALSE;//someone is a troll and tried to move farther than a jump can, or not at all
            }
            return TRUE;
        }
        function getSpace($space){//gets the contents of the space.
            if($this->spaceExists($space)){
                return $this->board[$space[1]-1][charToInt($space[0])-1];
            }
            else return FALSE;
        }
        function setSpace($space,$value){//returns true if the setting was successful, false otherwise.
            if($this->spaceExists($space)){//SUCCESS
                $this->board[$space[1]-1][charToInt($space[0])-1]=$value;
                return TRUE;
            }
            else return FALSE;//FAILURE
        }
        function spaceOpen($s){//Checks to see if a space on the board is open. $s is an array of form (A,1)
            if($this->spaceExists($s)){
                return !($this->getSpace($s));//this would still throw an error,, wouldn't it 
            } else return FALSE;
        }
        
        function getPieces(){//returns what pieces exist and where they are UNUSED
            $returnValue=Array();
            $array=$this->board;
            for($i=0;$i<8;$i++){
                for($j=0;$j<8;$j++){
                    if(!($array[$i][$j]=='')){
                        array_push($returnValue,"".$array[$i][$j].positionArrayToChessSquare(Array($i,$j)));
                    }
                }
            }
            return $returnValue;
        }
        function exportForClient(){//UNUSED, not finished.
            $returnString='';
            $arrayOfPieces=$this->getPieces();
            for($i=0;$i<count($arrayOfPieces);$i++){
                
            }
            return $returnString;
        }//turn's it into the thing for andrew
        function executeMove($moveString){//returns FALSE if the move is invalid or failed, TRUE if the move worked.
            if(!$this->isValid($moveString)){
                return FALSE;
            }
            $oldSquare=substr($moveString,0,2);
            $newSquare=substr($moveString,2,2);
            $changeVector=getVectorBetween($oldSquare,$newSquare);
            $xChange=$changeVector[0];//sideways
            $yChange=$changeVector[1];
            unset($changeVector);
            $piece=$this->getSpace($oldSquare);
            $this->setSpace($newSquare,$piece);//move the piece to the new space
            if(abs($xChange)==2){//if we jumped, remove the jumped piece
                $midpoint=applyVector($oldSquare,Array($xChange/2,$yChange/2));
                $this->setSpace($midpoint,'');
            }
            unset($xChange);
            unset($yChange);
            $this->setSpace($oldSquare,'');
            $color=substr($piece,0,1);
            if((($color=='W')*7+1)==substr($newSquare,1,1)){//King the piece if it has made it to the other side of the board.
                $this->setSpace($newSquare,$color.'C');
            }
            return TRUE;
        } //takes in the move string and attempts to execute the move
    }
    abstract class GamePiece {
        private $name;
        private static $typeShorthand;//not sure if name and shorthand should be static.
        private $position;//array with two coordinates
        private $theGameBoard;
        private $fromWhite=TRUE;//pieces have a default orientation of coming from the white side   
        private $isWhite=TRUE;    
        function __construct(&$board,$isWhite,$fromWhite,$position=Array('A',I)){
            $this->position=$position;
            $this->board=&$board;
            $this->isWhite=$isWhite;
            $this->fromWhite=$fromWhite;
            $this->position=$position;
        }
        abstract function getAvailableMoves();//returns an array of squares (A1,B5, H8, etc.) to which the piece can move
        abstract function executeMove($squareFrom,$squareTo);//returns false if the move is invalid.
        function __toString(){
            
        }
    }
    class CheckersPawn extends GamePiece {
        private $name='Checker';
        private static $typeShorthand='P';
        function getAvailableMoves(){
            $returnVal=Array();
            $board=&$this->theGameBoard;
            if($board->wasLastMoveCheckerJump==FALSE){
                
            }
            else{
                
            }
        }
        function executeMove($squareFrom, $squareTo){
            
        }
    }
    class CheckersKing extends GamePiece {
        private $name='King Checker';
        private static $typeShorthand='C';
        function getAvailableMoves(){
            $returnVal=Array();
            $board=&$this->theGameBoard;
            if($board->wasLastMoveCheckerJump==FALSE){
                
            }
            else{
                
            }
        }
        function executeMove($squareFrom, $squareTo){
            
        }
    }
    class PieceMove {//Simple piece movement, without special conditions other than pieces being in specific locations.
       
        //Will have a way to account for pieces being rec
        public $piecesAt=Array();
        public $noPiecesAt=Array();
        public $forwardMovement;
        public $lateralMovement;
        public $takesPiecesAt=Array();
        function __construct($lateral,$forward, $piecesAt=Array(),$noPiecesAt=Array(),$takesPiecesAt=Array()){
            $this->piecesAt=$piecesAt;
            $this->lateralMovement=$lateral;
            $this->forwardMovement=$forward;
            $this->noPiecesAt=$noPiecesAt;
            $this->takesPiecesAt=$takesPiecesAt;
        } 
        function isValid($board,GamePiece $piece){// $board is the array of the game board;
            /*for($i=0;$i<count($this->piecesAt);$i++){
                if(){
                
                    return FALSE;
                }
            }
            if(){
                
                return FALSE;
            }
            if(){
                
                return FALSE;
            }
            if(){
                
                return FALSE;
            }
            return TRUE;*/
        }
    }
?>

<!---->