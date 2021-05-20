<html>
    <title>Rapple</title>
<head><meta name="viewport" content="width=device-width, initial-scale=1"></head>
    <script type="text/javascript" src="script.js"></script>
	<body style="background-color: lightcyan; color:blue; font-family:monospace;">
        <div id ="mainsysscr">
            <form method="post" autocomplete="off" onsubmit="return false">
                <style>
                #lgpass:focus {background-color: cornflowerblue;}
                #lguser:focus {background-color: cornflowerblue;}
                #lgsubmit:focus {background-color: cornflowerblue;}
                </style>
                <p style="font-size: 50PX; border-bottom: 2px solid blue;">Rapple Core Banking System Login</p>
                <table style="margin-left: 500px; margin-top: 150px; font-size: 25PX;">
                    <tr>
                    <td>User</td>
                    <td><input type="text" id="lguser"/></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td><input type="password" id="lgpass"/></td>
                    </tr>
                    <tr>
                        <td><input type="submit" value="Login" id="lgsubmit"/></td>
                    </tr>
                </table>
            </form>
        </div>
	</body>
<script type="text/javascript" src="code.js"></script>
</html>