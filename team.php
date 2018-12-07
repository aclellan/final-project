<?php
include 'top.php';

$player_images = array(
    array(1, "Anderson.jpg","Joey Anderson, Right Wing",),
    array(2, "Boyle.jpg","Brian Boyle, Center",),
    array(3, "Bratt.jpg","Jesper Bratt, Left Wing",),
    array(4, "Coleman.jpg","Blake Coleman, Center",),
    array(5, "Hall.jpg","Taylor Hall, Left Wing",),
    array(6, "Hischier.jpg","Nico Hischier, Center",),
    array(7, "Johansson.jpg","Marcus Johansson, Left Wing",),
    array(8, "Noesen.jpg","Stefan Noesen, Right Wing",),
    array(9, "Palmieri.jpg","Kyle Palmieri, Right Wing",),
    array(10, "Quenneville.jpg","John Quenneville, Center",),
    array(11, "Seney.jpg","Brett Seney, Left Wing",),
    array(12, "Stafford.jpg","Drew Stafford, Right Wing",),
    array(13, "Wood.jpg","Miles Wood, Left Wing",),
    array(14, "Zacha.jpg","Pavel Zacha, Center",),
    array(15, "Zajac.jpg","Travis Zajac, Center",),
    array(16, "Butcher.jpg","Will Butcher, Defense",),
    array(17, "Greene.jpg","Andy Greene, Defense",),
    array(18, "Lovejoy.jpg","Ben Lovejoy, Defense",),
    array(19, "Mueller.jpg","Mirco Mueller, Defense",),
    array(20, "Santini.jpg","Steven Santini, Defense",),
    array(21, "Severson.jpg","Damon Severson, Defense",),
    array(22, "Vatanen.jpg","Sami Vatanen, Defense",),
    array(23, "Yakovlev.jpg","Egor Yakovlev, Defense",),
    array(24, "Kinkaid.jpg","Keith Kinkaid, Goalie",),
    array(25, "Schneider.jpg","Cory Schneider, Goalie")
);

?>

<header class="cursive">Meet the Players!</header>

<article>
    <p>
    </p>
        
    <header class="centerText"><STRONG>New Jersey Devils Team History</STRONG></header>
    <p>The New Jersey Devils first hit the ice in the 1932-1983 NHL season, but failed
    to qualify for the Stanley Cup playoffs until 1987-1988. An overtime goal
    scored by famous Devil John Maclane in the last game of the season was the
    deciding factor on the Devils' first NHL playoff berth. The Devils have 3
    Stanley Cup Final wins, in 1995, 2000, and 2003. The 2018-2019 New Jersey
    Devils are currently trying to add to this resume and are hungry to win
    a Stanley Cup this year.</p>
    <h2>More Information:</h2>
    <ol>
        <li><a href="https://www.nhl.com/devils/">New Jersey Devils
            Official Website</a></li>    
    </ol>
</article>

<article class="playerImage">
    <header>
    <h3 class="playerImage">New Jersey Devils Roster</h3>
    </header>
    <?php
    foreach ($player_images as $player_image) {
        print'<figure>';
        print'<img src="images/' . $player_image[1] . '">'. PHP_EOL;
        print'<figcaption>';
        print $player_image[2];
        print'</figcaption>';
        print'</figure>' . PHP_EOL;
    }
    ?>
</article>

</body>
</html>

?>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

