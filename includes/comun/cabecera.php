<?php
    echo '<nav class="navbar navbar-expand-md "> <!-- añadir sticky-top para que se quede arriba-->
    <a class="navbar-brand navTitle" href="../../">Graph</a>
       <div class="navbar-collapse">
           <ul class="navbar-nav ml-auto">'; //Bara de la derecha
    if (isset($_SESSION["login"]) && ($_SESSION["login"]===true))
    {
        echo '<li><a class="nav-link" href="index.php?logout">Log out</a></li>';
        echo '<li><a class="nav-link" href="myViews.php">My views</a></li>';
    }
    else
    {
        echo '<li><a class="nav-link" href="login.php">Log In</a></li>
               <li><a class="nav-link" href="registro.php">Sign In</a></li>';
    }
    echo '</ul>
    </div>
</nav>';