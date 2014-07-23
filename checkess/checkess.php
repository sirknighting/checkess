<?php
/* 
    P is a checkers Pawn, C a checkers King, N a chess knight, B a chess Bishop, Q a chess queen, K a chess King, R a chess Rook, and ' ' a chess pawn.
*/
    $checkerBoardRegex = "([W|B][P|C][A-H][1-8]){,24}";
    $checkessBoardRegex="([W|B][P|C|N|B|R|Q|K| ][A-H][1-8]){,48}";
    $chessBoardRegex="([W|B][N|B|R|Q|K| )[A-H][1-8]]{,32}";
    $checkerBoardArray=array(
            array("WP","","WP","","WP","","WP",""),//1
            array("","WP","","WP","","WP","","WP"),
            array("WP","","WP","","WP","","WP",""),//3
            array("","","","","","","",""),
            array("","","","","","","",""),
            array("","BP","","BP","","BP","","BP"),//6
            array("BP","","BP","","BP","","BP",""),
            array("","BP","","BP","","BP","","BP")//8
        );
    $chessBoardArray=array(
            array("WR","WN","WB","WK","WQ","WB ","WN","WR"),//1
            array("W ","W ","W ","W ","W ","W ","W ","W "),
            array("","","","","","","",""),//3
            array("","","","","","","",""),
            array("","","","","","","",""),
            array("","","","","","","",""),//6
            array("B ","B ","B ","B ","B ","B ","B ","B "),
            array("BR","BN","BB","BQ","BK","BB","BN","BR")//8
        );
    $checkessBoardArray=array(
            array("WR","WN","WB","WK","WQ","WB","WN","WR"),//1
            array("W ","W ","W ","W ","W ","W ","W ","W "),
            array("","","","","","","",""),//3
            array("","","","","","","",""),
            array("","","","","","","",""),
            array("","","","","","","",""),//6
            array("B ","B ","B ","B ","B ","B ","B ","B "),
            array("BR","BN","BB","BQ","BK","BB","BN","BR")//8
        );
    function charToInt($c){
        return intval(strtolower($c))-96;
    }
    
    class GameBoard {
        public $board = array(
            array("","","","","","","",""),
            array("","","","","","","",""),
            array("","","","","","","",""),
            array("","","","","","","",""),
            array("","","","","","","",""),
            array("","","","","","","",""),
            array("","","","","","","",""),
            array("","","","","","","","")
            );
        private $moveTypes;
        function setBoard($gameType=0){
            switch($gameType){
                case 0: $this->board=$GLOBAL['checkerBoardArray'];break;
                case 1: $this->board=$GLOBAL['chessBoardArray'];break;
                case 2: $this->board=$GLOBAL['checkessBoardArray'];break;
            }
        }
        function spaceExists($s){
            return isset($this->board[charToInt($s[0])-1][$s[1]-1]);
        }
        function spaceOpen($s){//Checks to see if a space on the board is open. $s is an array of form (A,1)
            if(spaceExists($s)){
                return !($this->board[charToInt($s[0])-1][$s[1]-1]);//this would still throw an error,, wouldn't it 
            }
        }
        function getPieces(){
            $returnValue=Array();
            $array=$this->board;
            for($i=0;$i<8;$i++){
                for($j=0;$j<8;$j++){
                    
                }
            }
        }
        function export(){
            $returnString='';
            
            
            
            return $returnString;
        }
         
    }
    abstract class GamePiece {
        private $name;
        private $position;
        private $pieceType;
        private $theGameBoard;
        private $fromWhite=TRUE;//pieces have a default orientation of coming from the white side   
        private $isWhite=TRUE;    
        function __construct(&$pieceType,$board,$isWhite,$fromWhite,$position=Array(0,0)){
            $this->position=$position;
            
        }
        function getPieceType();
        function getAvailableMoves();
    } 
    class ChessKing extends GamePiece{
        private $hasMoved
    }
    class ChessKnight extends GamePiece {
        
    }
    class PieceType {
        public $moveSet=Array();
        public $name='';
        public $shortHand;
        function __construct($name,$shortHand,$moveSet){
            $this->moveSet=$moveSet;
            $this->name=$name;
            $this->shortHand=$shortHand;
        }
    }
    class PieceMove {
       
        //Will have a way to account for pieces being rec
        public $piecesAt=Array();
        public $noPiecesAt=Array();
        public $forwardMovement;
        public $lateralMovement;
        public $takesPiecesAt=Array();
        function toString(){
        }
        function __construct($lateral,$forward, $piecesAt=Array(),$noPiecesAt=Array(),$takesPiecesAt=Array()){
            $this->piecesAt=$piecesAt;
            $this->lateralMovement=$lateral;
            $this->forwardMovement=$forward;
            $this->noPiecesAt=$noPiecesAt;
            $this->takesPiecesAt=$takesPiecesAt;
        } 
        function isValid($board,GamePiece $piece){
            $board
            
        }
    }
?>