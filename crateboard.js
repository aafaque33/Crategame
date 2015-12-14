'use strict';

var Game = function()
{
	var dr = [-1,0,1,0] , dc=[0,1,0,-1];  // Index = 0: F , 1:R , 2:D , 3:L
	var bobcatpos = [10, 100 , 190 , 280] ; // [0,90,280,270]
	// angles in which direction to turn to be safe side angle+10
	// +10 did as having problem with 0 to separate from 0 weight
	
	//var bobcatpos = ['^', '>' , 'v' , '<'] ;
	var brd = [] ;
	var n;
	var target = { row: 0 , col: 0 , weight: 0 } ;
	var bobcat = { row: 0 , col: 0, direction: 0 } ;
	var bobcatstart = { row: 0 , col: 0} ;
	var min = 8 ;
	var max = 12 ;
	var out = "" ;
	var score;
	var canvas = document.getElementById('canvas');
	var board  = canvas.getContext("2d");
	var recordscore = getUrlVars()["recscore"];

	n = Math.floor(Util.random() * (max - min + 1)) + min;

	canvas.width= window.innerWidth;
    canvas.height = window.innerHeight;

	var tileSize= canvas.height / n ;

	// Initialize the Crate Board 

	this.init = function()
	{
		// Initialize board randomly with target crate and bobcat position

		var createboard = function(dim)
		{

			for(var r = 0 ; r < dim; r++)
				brd[r] = [] ;

			for(var r=0 ; r<dim ; r++)
			{
				for(var c=0 ; c<dim ; c++)
				{
					var randomnumber=Util.random();

					if( randomnumber < 0.2 ) {
							brd[r][c] = 1;
					}
					else if (randomnumber < 0.3) {
							brd[r][c] = 2;
					}
					else if(randomnumber < 0.4) {
							brd[r][c] = 3;
					}
					else
					{
							brd[r][c] = 0;
					}
				}
			}

			getbobcatposition();
			brd[bobcat.row][bobcat.col] = '^'

			gettargetposition();
			target.weight = brd[target.row][target.col] ;
			brd[target.row][target.col] = 'T';
		};

		var getbobcatposition = function()
		{
			var bparr = [] ;
			var br = n-1 ;
			bobcat.row = br ;
			for(var c=0; c<n ; c++) // store all the empty locations in an array
			{
				if(brd[br][c] === 0)
					bparr.push(c);
			}
			var pushercol = Math.floor(Util.random() * ((bparr.length-1) - 0 + 1)) + 0;
			bobcat.col = bparr[pushercol];

			// start bobcat starting row and col
			bobcatstart.row = bobcat.row ;
			bobcatstart.col = bobcat.col;
		};

		var gettargetposition = function()
		{
			var targetrow;
			var targetcol;
			do
			{
				targetrow = Math.floor(Util.random() * ((n-2) - 1 + 1)) + 1;
				targetcol = Math.floor(Util.random() * ((n-2) - 1 + 1)) + 1;
			} while ( brd[targetrow][targetcol] === 0 );

			target.row = targetrow;
			target.col = targetcol;
		};

		createboard(n);
		score = 0 ;

	};

	// Move the bobcat , target and other crates based on command Input

	this.move = function(cmd)  // commands: f , l  , r , x
	{
		var command = function()
		{
			if(brd[bobcatstart.row][bobcatstart.col] === 'T')
			{
				var resultdisp = document.getElementById('result');
				resultdisp.style.display = "block" ;

				if( score < recordscore || recordscore == 0)
				{
					resultdisp.innerHTML = "Congratulations, You have a New High Score, Please save your Reord !! \n Your Final Score: " + score;
					$('#addscore').show();
				}
				else
				resultdisp.innerHTML = "Game Over !!! Congratulations, your target reached the bobcat position \n Your Final Score: " + score;
			}
			else if(cmd === 38)
			{
				movefwd();
			}

			else if(cmd === 37)
			{
				turnleft();
			}

			else if(cmd === 39)
			{
				turnright();
			}

			else if(cmd === 32)
			{
				destroycrate();
			}

			else
			{
				//alert("Invalid Move: Please select correct move ");
			}
		}

		// Move fwd in any position facing

		var movefwd = function()
		{
			var saudio = document.getElementById('stepaudio') ;
			saudio.src = "fwd.mp3" ;
			saudio.play();
			var newr = bobcat.row + dr[bobcat.direction];
			var newc = bobcat.col + dc[bobcat.direction];
			var wt = 0 ;
			var newrw = newr;
			var newcw = newc;
			
			// Calculate the total weights of all the crates in front of bobcat

			while(onboard(newrw,newcw) > 0 || brd[newrw][newcw] > 0 || brd[newrw][newcw] === 'T' )
			{
				if(brd[newrw][newcw] === 'T')
					wt += target.weight ;
				else
					wt += brd[newrw][newcw];

				newrw = newrw + dr[bobcat.direction] ; newcw = newcw + dc[bobcat.direction] ;
			}

			//if weight more than 3 than throw error

			if(wt > 3)
			{
				//alert("Invalid Move: Crates cannot be moved b/c sum of crate weights > 3" );
				return;
			}

			// Otherwise move bobcat and all other crates forward 
			else
			{
				//If crates to move are not moving outside box

				if(onboard(newrw,newcw) >= 0)
				{
					while(brd[newrw][newcw] !== brd[bobcat.row][bobcat.col])
					{
						brd[newrw][newcw] = brd[newrw  - dr[bobcat.direction]][newcw  - dc[bobcat.direction]];
						if(brd[newrw][newcw] === 'T') 
						{
							target.row = newrw;
							target.col = newcw ;
						}
						// check target reached at bobcat starting position
						if(newrw === bobcatstart.row && newcw === bobcatstart.col && brd[newrw][newcw] === 'T')
						{
							brd[bobcat.row][bobcat.col] = 0;
							bobcat.row = newr;
							bobcat.col = newc;
						
							brd[bobcat.row][bobcat.col] = bobcatpos[bobcat.direction];

							score = score + 1 ;

							var resultdisp = document.getElementById('result');
							resultdisp.style.display = "block" ;
							if( score < recordscore || recordscore == 0)
							{
								resultdisp.innerHTML = "Congratulations, You have a New High Score, Please save your Reord !! \n Your Final Score: " + score;
								$('#addscore').show();
							}
							else
							resultdisp.innerHTML = "Game Over !!! Congratulations, your target reached the bobcat position \n Your Final Score: " + score;
							//alert("Game is Over, your target reached the bobcat position \n Your Final Score: " + score);
							return;
						}

						newrw = newrw - dr[bobcat.direction] ;
						newcw = newcw - dc[bobcat.direction] ;
					}

					brd[bobcat.row][bobcat.col] = 0;
					bobcat.row = newr;
					bobcat.col = newc;
						
					brd[bobcat.row][bobcat.col] = bobcatpos[bobcat.direction];
				}

				// if there is no crate in front of bobcat so move one blockahead 
				else if ( wt === 0)
				{
					if(onboard(newr,newc) >= 0)
					{
						brd[bobcat.row][bobcat.col] = 0;
						bobcat.row = newr;
						bobcat.col = newc;
							
						brd[bobcat.row][bobcat.col] = bobcatpos[bobcat.direction];
					}
					else
					{
						//alert("Invalid Move: Bobcat can't be moved outside the box" );
						return;
					}
				}
				else
				{
					//alert("Invalid Move: Crate can't be moved outside the box" );
					return;
				}
			}

			score += 1 ;
		}

		// change position to left according to current position 

		var turnleft = function()
		{
			var saudio = document.getElementById('stepaudio') ;
			saudio.src = "turn.mp3" ;
			saudio.play();
			// for changing the direction and display of bobcat using bobcatpos array
			brd[bobcat.row][bobcat.col] =  bobcatpos[(((bobcat.direction - 1 )%4)+4)%4] ; 
			bobcat.direction = (((bobcat.direction - 1 )%4)+4)%4;

			score += 1 ;
		}

		// change position to right according to current position

		var turnright = function()
		{
			var saudio = document.getElementById('stepaudio') ;
			saudio.src = "turn.mp3" ;
			saudio.play();
			// for changing the direction and display of bobcat using bobcatpos array
			brd[bobcat.row][bobcat.col] =  bobcatpos[(bobcat.direction + 1)%4] ;
			bobcat.direction = (bobcat.direction + 1)%4;

			score += 1 ;
		}

		// destroy crate : penalty 100 points

		var destroycrate = function()
		{
			var saudio = document.getElementById('stepaudio') ;
			saudio.src = "explosion.mp3" ;
			saudio.play();
			var newr = bobcat.row + dr[bobcat.direction];
			var newc = bobcat.col + dc[bobcat.direction];
			
			if(brd[newr][newc] === 'T' || brd[newr][newc] === 0	)
			{
				//alert("Invalid Move: Target Crate cannot be destroyed");
				return;
			}
			else
			{
				brd[newr][newc] = 0 ;
				score += 100 ;
			}
		}

		// check if bobcat and other boxes are still on board 

		var onboard = function(brdrow,brdcol)
		{
			if(brdrow < 0)
				return -1 ;
			else if(brdcol < 0)
				return -1 ;
			else if(brdrow > n-1)
				return -1 ;
			else if(brdcol > n-1)
				return -1 ;
			else
				return 0 ;
		}

		command(cmd);
	};

	// Show the Crate Board with bobcat and target box and other crates

	this.drawboard = function()
	{
		var x=0 ;
		var y=0 ;
		var wid=0 ;
		var ht=0 ;
		var angle = 0;

		var scoredisp = document.getElementById('score');
		scoredisp.innerHTML = "Current Score: " + score;
		document.getElementById("finalscore").value = score;

		if(recordscore == 0)
		{
			var recscoredisp = document.getElementById('recscore');
			recscoredisp.innerHTML = "Record Score: UNSOLVED";
		}
		else
		{
			var recscoredisp = document.getElementById('recscore');
			recscoredisp.innerHTML = "Record Score: " + recordscore;
		}

		for(var r=0 ; r<n ; r++)
		{
			for(var c=0 ; c<n ; c++)
			{
				if(r === bobcatstart.row && c === bobcatstart.col)
				{
					board.strokeStyle  = "red";
					board.lineWidth=5;
					board.strokeRect((c * tileSize), (r * tileSize), tileSize, tileSize);
				}
				else
				{
					//board.strokeStyle  = "#CE8C42";
					board.fillStyle = '#CE8C42';

					board.fillRect((c * tileSize), (r * tileSize), tileSize, tileSize);
					//board.strokeRect((c * tileSize), (r * tileSize), tileSize, tileSize);
					board.fillStyle = "black";
      				board.font =  (tileSize / 2) + "pt sans-serif";
      			}

      			if(r === bobcat.row && c === bobcat.col)
      			{
      				var img = new Image();
      				img.onload = function() {
      					x = (bobcat.col * tileSize)+1;
      					y = (bobcat.row  * tileSize)+1;
      					wid = tileSize-2;
      					ht = tileSize-2;
      					angle = bobcatpos[bobcat.direction] - 10 ;
      					Util.drawRotatedImage(board,angle,img,x,y,wid,ht);
					//board.drawImage(img,(bobcat.col * tileSize)+1, (bobcat.row  * tileSize)+1,tileSize-2,tileSize-2); 
      				};
      				img.src = 'bobcat.png';
      			}
      			else if(brd[r][c] === 'T')
      			{
      				var img1 = new Image();
      				img1.onload = function() {
						board.drawImage(img1,(target.col * tileSize)+1, (target.row  * tileSize)+1,tileSize-2,tileSize-2); 
      				};
      				img1.src = 'boxtarget' + target.weight + '.png';
      			}
      			else
      			{
      				//board.fillText(brd[r][c], (c * tileSize)+(tileSize/2), (r * tileSize)+(tileSize/2));
      				var img2 = new Image();
					drawImage(img2,c, r); 
      			}

			}
		}

	}

	// User defined function for DrawImage to draw multiple images on board for boxes 0,1,2,3 weight

	var drawImage = function(img2,x,y)
	{
		img2.onload = function() {
		board.drawImage(img2,(x * tileSize)+1, (y  * tileSize)+1,tileSize-2,tileSize-2); 
      	};
      	img2.src = 'box' + brd[y][x] + '.png';
	}

};



(function()
{
	var seed;
	var seedval = getUrlVars()["seed"];

	seed = getseedval(seedval);
	document.getElementById("currentseed").value = seed;
	document.getElementById("puzzlename").value = getUrlVars()["puzname"];
	var relink = document.getElementById("resetlink");

	var resultdisp = document.getElementById('puzheading');
	resultdisp.innerHTML = "Puzzle: " + getUrlVars()["puzname"];
				

	relink.href = "crategame.php?seed=" + seed + "&recscore=" + getUrlVars()["recscore"] + "&puzname=" + getUrlVars()["puzname"];
	//alert(document.getElementById("currentseed").value);

	//alert(seed);
	Util.random(seed);
	var game = new Game();

	// Inititalize the /Crate Board
	game.init();
	game.drawboard();

	// Move the Crates based on keys 

	window.onkeydown = function(e)
	{
		game.move(e.keyCode);
		game.drawboard();
	}
	

})();

function getUrlVars() {
var vars = {};
var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
vars[key] = value;
});
return vars;
}

function getseedval(seedval) {

	var seed;
	// this is only in case some one open url without seedval in url
	if(typeof(seedval) == 'undefined')
	{
		seed = 100000000 * Math.random();
	    seed = parseInt(seed);
	}
	else
	{
		if(seedval == 0)
		{
			seed = 100000000 * Math.random();
	        seed = parseInt(seed);
		}
		else
		{
			seed = seedval ;
		}
	}
	return seed;
}

function newpuzzlelink()
{
	// var newpuzzlename = prompt('Please give a name to your new puzzle');

	// if( newpuzzlename == '' )
	// {
	// 	alert('sddfdsd');
	// }

	// $.ajax({ 
	// 	type: "POST",
	// 	url: 'newpuzzleajax.php',
 //         data: {"action": "test"},
 //         success: function(output) {
 //                      alert(output);
 //                  }
	// });

	//var relink = document.getElementById("newpuzlink");			

	//relink.href = "crategame.php?seed=" + 0 + "&recscore=" + 0 + "&puzname=new";
}

$( document ).ready(function() {
    $("#afterscoreadd").delay(2000).fadeOut("slow");
});
