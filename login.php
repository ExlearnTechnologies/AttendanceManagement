<?php 
@require_once 'config/config.php';
?>
<html>
    <head>
        <?php @require_once 'config/commonJS.php'; ?>		
    </head>
    <body>
        <!-- wrap starts here -->
        <div id="wrap">
            <!--header -->
            <?php //@require_once 'menu/header.php'; ?>
            <div id="header">
                <h1 id="logo-text"><a href=".">Kashipara Group</a></h1>
                <p id="slogan">Software Solution</p>
                <div id="header-links">
                </div>
            </div>
            <!-- navigation -->	
            <?php //@require_once 'menu/menu.php'; ?>
            <!-- content-wrap starts here -->
            <div id="content-wrap">
                <div id="main">
                	<?php echo $_SESSION['Msg']; ?>
                    <form id="formSubmit" method="post" action="process/processLogin.php">
                    <input type="hidden" name="type" value="login" />
                    <table class="tbl" width="700px">
                        <tr>
                            <td>User Name</td>
                            <td><input type="text" id="UserName" class="validate[required]" name="UserName" /></td>
                        </tr>
                        <tr>
                            <td>Password</td>
                            <td><input type="password" id="Password" class="validate[required]" name="Password" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" value="Login" name="submit" /></td>
                        </tr>
                    </table>
                    </form>    
                    <div class="clear"></div>
                </div>
            <?php @require_once 'menu/sidemenu.php'; ?>	
            <!-- content-wrap ends here -->
            </div>
            <!--footer starts here-->
            <?php @require_once 'menu/footer.php'; ?>
            <!-- wrap ends here -->
        </div>
    </body>
</html>