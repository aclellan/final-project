<!-- ######################     Main Navigation   ########################## -->
<nav>
    <ol>
        <?php
        // Repeat this if block for each menu item 
        // designed to give the current page a class but also allows
        // you to have more classes if you need them
        print '<li class="';
        if ($path_parts['filename'] == "index") {
            print ' activePage ';
        }
        print '">';
        print '<a href="index.php">Home</a>';
        print '</li>';
        /* example of repeating */
        
        print '<li class="';
        if ($path_parts['filename'] == "team") {
            print ' activePage ';
        }
        print '">';
        print '<a href="team.php">Players</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "form1") {
            print ' activePage ';
        }
        print '">';
        print '<a href="form1.php">Ticket Signups!</a>';
        print '</li>';
        
         print '<li class="';
        if ($path_parts['filename'] == "ticketform") {
            print ' activePage ';
        }
        print '">';
        print '<a href="ticketform.php">Update</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "Forwards") {
            print ' activePage ';
        }
        print '">';
        print '<a href="Forwards.php">Forwards</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "Defensemen") {
            print ' activePage ';
        }
        print '">';
        print '<a href="Defensemen.php">Defensemen</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "Goalies") {
            print ' activePage ';
        }
        print '">';
        print '<a href="Goalies.php">Goalies</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "Tables") {
            print ' activePage ';
        }
        print '">';
        print '<a href="tables.php">Tables</a>';
        print '</li>';
        ?>
    </ol>
</nav>