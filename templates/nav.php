<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bidpro-menu">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="index.php">
                <img class="setHeight" src="images/jack.png" alt="Jack"/>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="bidpro-menu">
            <ul class="nav navbar-nav navbar-right">

                <li>
                    <a href="aboutus.php">About Us</a>
                </li>
                <li>
                    <a href="contactus.php">Contact US</a>
                </li>
                <li>
                    <a href="products.php">Products</a>
                </li>
                <li>
                    <a href="blog.php">Blog</a>
                </li>
                <li>
                    <a href="calendar.php">Calendar</a>
                </li>
                <li>
                    <a href="articles.php">Articles</a>
                </li>
                <?php
                if(!isset($_SESSION['username'])){
                    echo "<li>
                    <a href=\"login.php\">Login</a>
                </li>";
                    echo "
                <li>
                    <a></a>
                </li>";
                }
                ?>

                <?php
                if(isset($_SESSION['username'])){
                    echo "
                      <li>
                    <a href=\"preferences.php\">Preferences</a>
                </li>";
                    echo "
                <li>
                    <a href=\"logout.php\">Logout</a>
                </li>";

                    $loggeduser = $_SESSION['username'];
                    echo "
                <li>
                    <a href=''>Welcome, $loggeduser</a>
                </li>";
                }
                ?>


            </ul>
        </div>
    </div>
</nav>