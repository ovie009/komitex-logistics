<header>
    <nav class="main-nav">
        <a class="logo-container" href="index.php">
            <div class="logo"></div>
            <img src="icons/logistics/018-motorcycle.png" alt="">
        </a>
        <button type="button" class="dropdown">
            <img src="icons/dropdown/interface.png" alt="">
        </button>
        <?php
            if (!isset($_SESSION['komitexLogisticsEmail'])) {
                ?>      
                <div class="form-wrapper">
                    <form action="includes/login.inc.php" method="POST" id="main-login-form">
                        <input type="text" name="user" id="nav-user" placeholder="email or Username" title="e.g. Janedoe@gmail.com OR Janedoe007" required>
                        <input type="password" name="password" id="nav-password" placeholder="password" title="password" required>
                        <button type="submit" name="login" id="nav-submit">login</button>
                    </form>
                    <p>
                        I don't have an account? <a href="signup.php">signup</a>
                    </p>
                </div>
                <?php
            }
        ?>
    </nav>
    <?php
        if (isset($_SESSION['komitexLogisticsEmail'])) {
            ?>  
            <nav class="link-wrapper">
                <ul>
                    <?php
                        if ($_SESSION['komitexLogisticsAccountType'] == NULL) {
                            ?>
                            <li class="index-li"><a class="index-li-a" href="index.php">Home</a></li>
                            <li class="orders-li"><a href="orders.php">Orders</a></li>
                            <li class="mydeliveries-li"><a href="mydeliveries.php">My Deliveries</a></li>
                            <li class="otherdeliveries-li"><a href="otherdeliveries.php">OtherDeliveries</a></li>
                            <li class="ranking-li"><a href="ranking.php">Ranking</a></li>
                            <li class="report-li"><a href="report.php">Report</a></li>
                            <li class="transactions-li"><a href="transactions.php">Transcations</a></li>
                            <li class="waybill-li"><a href="waybill.php">Waybill/Products</a></li>
                            <li class="accountinfo-li"><a href="accountinfo.php">Account Info</a></li>
                            <li><a href="logout.php">logout</a></li>
                            <?php
                        }else if ($_SESSION['komitexLogisticsAccountType'] == 'Affiliate'){ 
                            ?>
                            <li class="index-li"><a href="index.php">Home</a></li>
                            <li class="orders-li"><a href="orders.php">Orders</a></li>
                            <li class="ranking-li"><a href="ranking.php">Ranking</a></li>
                            <li class="report-li"><a href="report.php">Report</a></li>
                            <li class="transactions-li"><a href="transactions.php">Transcations</a></li>
                            <li class="waybill-li"><a href="waybill.php">Waybill/Products</a></li>
                            <li class="accountinfo-li"><a href="accountinfo.php">Account Info</a></li>
                            <li><a href="logout.php">logout</a></li>
                            <?php
                        }else if ($_SESSION['komitexLogisticsAccountType'] == 'Agent'){ 
                            ?>
                            <li class="index-li"><a href="index.php">Home</a></li>
                            <li class="mydeliveries-li"><a href="mydeliveries.php">My Deliveries</a></li>
                            <li class="otherdeliveries-li"><a href="otherdeliveries.php">OtherDeliveries</a></li>
                            <li class="ranking-li"><a href="ranking.php">Ranking</a></li>
                            <li class="report-li"><a href="report.php">Report</a></li>
                            <li class="transactions-li"><a href="transactions.php">Transcations</a></li>
                            <li class="accountinfo-li"><a href="accountinfo.php">Account Info</a></li>
                            <li><a href="logout.php">logout</a></li>
                            <?php
                        }else if ($_SESSION['komitexLogisticsAccountType'] == 'Logistics'){ 
                            ?>
                            <li class="index-li"><a href="index.php">Home</a></li>
                            <li class="mydeliveries-li"><a href="mydeliveries.php">My Deliveries</a></li>
                            <li class="otherdeliveries-li"><a href="otherdeliveries.php">OtherDeliveries</a></li>
                            <li class="ranking-li"><a href="ranking.php">Ranking</a></li>
                            <li class="report-li"><a href="report.php">Report</a></li>
                            <li class="transactions-li"><a href="transactions.php">Transcations</a></li>
                            <li class="waybill-li"><a href="waybill.php">Waybill/Products</a></li>
                            <li class="accountinfo-li"><a href="accountinfo.php">Account Info</a></li>
                            <li><a href="logout.php">logout</a></li>
                            <?php
                        }else if ($_SESSION['komitexLogisticsAccountType'] == 'Merchant'){ 
                            ?>
                            <li class="index-li"><a href="index.php">Home</a></li>
                            <li class="orders-li"><a href="orders.php">Orders</a></li>
                            <li class="ranking-li"><a href="ranking.php">Ranking</a></li>
                            <li class="report-li"><a href="report.php">Report</a></li>
                            <li class="transactions-li"><a href="transactions.php">Transcations</a></li>
                            <li class="waybill-li"><a href="waybill.php">Waybill/Products</a></li>
                            <li class="accountinfo-li"><a href="accountinfo.php">Account Info</a></li>
                            <li><a href="logout.php">logout</a></li>
                            <?php
                        }
                    ?>
                </ul>
            </nav>
            <?php
        }
    ?>
        
    <nav class="side-nav">
        <div class="side-nav-wrapper">
            <?php
                if (!isset($_SESSION['komitexLogisticsEmail'])) {
                    ?>  
                    <div class="side-nav-form-wrapper">
                        <form action="includes/login.inc.php" method="POST" id="side-login-form">
                            <input type="text" name="user" id="side-nav-user" placeholder="email or username" title="e.g. Janedoe@gmail.com OR Janedoe007" required>
                            <input type="password" name="password" id="side-nav-password" placeholder="password" title="password" required>
                            <button type="submit" name="login" id="side-nav-submit">login</button>
                        </form>
                        <p>
                            I don't have an account? <a href="signup.php">signup</a>
                        </p>
                    </div>
                    <?php
                } else{ 
                    ?>
                    <ul>
                        <?php
                            if ($_SESSION['komitexLogisticsAccountType'] == NULL) {
                                ?>
                                <li class="index-li"><a href="index.php">Home</a></li>
                                <li class="orders-li"><a href="orders.php">Orders</a></li>
                                <li class="mydeliveries-li"><a href="mydeliveries.php">My Deliveries</a></li>
                                <li class="otherdeliveries-li"><a href="otherdeliveries.php">OtherDeliveries</a></li>
                                <li class="ranking-li"><a href="ranking.php">Ranking</a></li>
                                <li class="report-li"><a href="report.php">Report</a></li>
                                <li class="transactions-li"><a href="transactions.php">Transcations</a></li>
                                <li class="waybill-li"><a href="waybill.php">Waybill/Products</a></li>
                                <li class="accountinfo-li"><a href="accountinfo.php">Account Info</a></li>
                                <li><a href="logout.php">logout</a></li>
                                <?php
                            }else if ($_SESSION['komitexLogisticsAccountType'] == 'Affiliate'){ 
                                ?>
                                <li class="index-li"><a href="index.php">Home</a></li>
                                <li class="orders-li"><a href="orders.php">Orders</a></li>
                                <li class="ranking-li"><a href="ranking.php">Ranking</a></li>
                                <li class="report-li"><a href="report.php">Report</a></li>
                                <li class="transactions-li"><a href="transactions.php">Transcations</a></li>
                                <li class="waybill-li"><a href="waybill.php">Waybill/Products</a></li>
                                <li class="accountinfo-li"><a href="accountinfo.php">Account Info</a></li>
                                <li><a href="logout.php">logout</a></li>
                                <?php
                            }else if ($_SESSION['komitexLogisticsAccountType'] == 'Agent'){ 
                                ?>
                                <li class="index-li"><a href="index.php">Home</a></li>
                                <li class="mydeliveries-li"><a href="mydeliveries.php">My Deliveries</a></li>
                                <li class="otherdeliveries-li"><a href="otherdeliveries.php">OtherDeliveries</a></li>
                                <li class="ranking-li"><a href="ranking.php">Ranking</a></li>
                                <li class="report-li"><a href="report.php">Report</a></li>
                                <li class="transactions-li"><a href="transactions.php">Transcations</a></li>
                                <li class="accountinfo-li"><a href="accountinfo.php">Account Info</a></li>
                                <li><a href="logout.php">logout</a></li>
                                <?php
                            }else if ($_SESSION['komitexLogisticsAccountType'] == 'Logistics'){ 
                                ?>
                                <li class="index-li"><a href="index.php">Home</a></li>
                                <li class="mydeliveries-li"><a href="mydeliveries.php">My Deliveries</a></li>
                                <li class="otherdeliveries-li"><a href="otherdeliveries.php">OtherDeliveries</a></li>
                                <li class="ranking-li"><a href="ranking.php">Ranking</a></li>
                                <li class="report-li"><a href="report.php">Report</a></li>
                                <li class="transactions-li"><a href="transactions.php">Transcations</a></li>
                                <li class="waybill-li"><a href="waybill.php">Waybill/Products</a></li>
                                <li class="accountinfo-li"><a href="accountinfo.php">Account Info</a></li>
                                <li><a href="logout.php">logout</a></li>
                                <?php
                            }else if ($_SESSION['komitexLogisticsAccountType'] == 'Merchant'){ 
                                ?>
                                <li class="index-li"><a href="index.php">Home</a></li>
                                <li class="orders-li"><a href="orders.php">Orders</a></li>
                                <li class="ranking-li"><a href="ranking.php">Ranking</a></li>
                                <li class="report-li"><a href="report.php">Report</a></li>
                                <li class="transactions-li"><a href="transactions.php">Transcations</a></li>
                                <li class="waybill-li"><a href="waybill.php">Waybill/Products</a></li>
                                <li class="accountinfo-li"><a href="accountinfo.php">Account Info</a></li>
                                <li><a href="logout.php">logout</a></li>
                                <?php
                            }
                        ?>
                    </ul>
                    <?php
                }
            ?>
        </div>
    </nav>
</header>