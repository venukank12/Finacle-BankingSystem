<?php
session_start();

function script(){?>
    <script type="text/javascript" src="script.js"></script>
    <script type="text/javascript" src="code.js"></script>
<?php }

function home(){?>
    <body>
		<table style="margin-left:225px; padding-top: 15px;">
            <tr>
                <td>HOME</td>
                <td>Home Page</td>
                <td>HACLI</td>
                <td>Inquire On Accounts</td>
				<td>CNBR</td>
                <td>Crate a New Branch</td>
            </tr>
            <tr>
                <td>HACLI</td>
                <td>Inquire On Accounts</td>
                <td>MANDATE</td>
                <td>Openings of Accounts and CIF Creations</td>
				<td>HACLI</td>
                <td>Inquire On Accounts</td>
            </tr>
            <tr>
                <td>MANDATE</td>
                <td>Openings of Accounts and CIF Creations</td>
                <td>CP</td>
                <td>Change password</td>
				<td>HCRN</td>
                <td>Handle Cheque Returns</td>
            </tr>
            <tr>
                <td>CP</td>
                <td>Change password</td>
                <td>TELLER</td>
				<td>Cash Transaction Postings</td>
				<td>TELLER</td>
				<td>Cash Transaction Postings</td>
            </tr>
            <tr>
                <td>TELLER</td>
				<td>Cash Transaction Postings</td>
                <td>TELLER</td>
				<td>Cash Transaction Postings</td>
				<td>CP</td>
                <td>Change password</td>
            </tr>
		</table>
		<h2 style="padding-top: 10px; font-size: 30px; color: darkblue; text-align:center;">Welcome To Finacle Core Banking System</h2>
		<table style="margin-left:225px;">
            <tr>
                <td>MANDATE</td>
                <td>Openings of Accounts and CIF Creations</td>
                <td>AUTF</td>
                <td>Asaign User for Teller Functions</td>
				<td>AUTF</td>
                <td>Asaign User for Teller Functions</td>
            </tr>
            <tr>
                <td>CTSM</td>
                <td>Cash Transaction Status Modifications</td>
                <td>CNBR</td>
                <td>Crate a New Branch</td>
				<td>CNBR</td>
                <td>Crate a New Branch</td>
            </tr>
            <tr>
                <td>UM</td>
                <td>User Modifications</td>
                <td>MANDATE</td>
                <td>Openings of Accounts and CIF Creations</td>
				<td>NUC</td>
                <td>New User Creation</td>
            </tr>
            <tr>
                <td>NUC</td>
                <td>New User Creation</td>
                <td>NUC</td>
                <td>New User Creation</td>
				<td>NUC</td>
                <td>New User Creation</td>
            </tr>
            <tr>
                <td>CNBR</td>
                <td>Crate a New Branch</td>
                <td>CNBR</td>
                <td>Crate a New Branch</td>
				<td>CNBR</td>
                <td>Crate a New Branch</td>
            </tr>
        </table>
</body>
<?php }

function hacli(){
    $time = time();
    $time_style = date('Y-m-d',$time);
?>
    <div>
        <h2 style="color:blue;">BALANCE INQUIRE</h2>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table style="margin-left:400px;" id="cmmtb">
            <tr>
                <td>Account No</td>
                <td><input type="number" id="accnum"/></td>
                <td><label id="accname" style="color: darkblue;"></label></td>
            </tr>
            <tr>
                <td>Date From</td>
                <td><input type="text" id="fdate" maxlength="10" value="<?php echo $time_style; ?>"/></td>
                <td>Date To</td>
                <td><input type="text" id="tdate" maxlength="10" value="<?php echo $time_style; ?>"/></td>
            </tr>
            <tr>
                <td>Amount From</td>
                <td><input type="number" id="famount"/></td>
                <td>Amount To</td>
                <td><input type="number" id="tamount"/></td>
            </tr>
            <tr>
                <td><input type="submit" id="hacligo" value="Go"/></td>
            </tr>
        </table>
        <table id="acdet" hidden="hidden" style="margin-left:400px;">
            <tr>
                <td>Name</td>
                <td style="width:20px;"></td>
                <td><label id="nam" style="color: darkblue;"></label></td>
                <td style="width:75px;"></td>
                <td>Open Balance</td>
                <td style="width:20px;"></td>
                <td><label style="color: darkblue;" id="opbal"></label></td>
            </tr>
            <tr>
                <td>Status</td>
                <td style="width:20px;"></td>
                <td><label style="color: darkblue;" id="status"></label></td>
                <td style="width:50px;"></td>
                <td>Close Balance</td>
                <td style="width:10px;"></td>
                <td><label style="color: darkblue;" id="clb"></label></td>
            </tr>
            <tr>
                <td>Open Date</td>
                <td style="width:10px;"></td>
                <td><label style="color: darkblue;" id="odate"></label></td>
                <td style="width:50px;"></td>
                <td>Efective Balance</td>
                <td style="width:10px;"></td>
                <td><b><label id="efb" ></label></b></td>
            </tr>
            <tr>
                <td>Close Date</td>
                <td style="width:10px;"></td>
                <td><label style="color: darkblue;" id="cdate"></label></td>
                <td style="width:50px;"></td>
                <td>Scheme</td>
                <td style="width:10px;"></td>
                <td><label style="color: darkblue;" id="scheme"></label></td>
            </tr>
            <tr>
                <td>POD Limit</td>
                <td style="width:10px;"></td>
                <td><label id="pod" style="color: darkblue;"></label></td>
                <td style="width:50px;"></td>
                <td>Hold Amount</td>
                <td style="width:10px;"></td>
                <td><label style="color: darkblue;" id="hold"></label></td>
            </tr>
            <tr>
                <td>DBL</td>
                <td style="width:10px;"></td>
                <td><label id="dbl" style="color: darkblue;"></label></td>
                <td style="width:50px;"></td>
                <td>Nic</td>
                <td style="width:10px;"></td>
                <td><label id="nic" style="color: darkblue;"></label></td>
            </tr>
        </table>
        <table style="margin-left:350px;" id="acstat" hidden="hidden">
        </table>
        <table id="butt" hidden="hidden" style="margin-left:350px;">
            <tr>
                <td><input type="submit" id="hacligoout" value="OK"/></td>
            </tr>
        </table>
        </form>
        </div>
<?php }

function nuc(){?>  
<body>
    <h2 style="color:blue;">NEW USER CREATION</h2>
    <form style="margin-left: 500px;" autocomplete="off" onsubmit="return false">
            <table>
                <tr>
                    <td>Nic</td>
                    <td><input type="text" id="nunic" style="text-transform: uppercase;"/></td>
                    <td><label id="uidname"></label></td>
                </tr>
                <tr>
                    <td>Sol Id</td>
                    <td><lable id="nusol" ></lable></td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input type="text" id="nufname" style="text-transform: capitalize;"/></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type="text" id="nulname" style="text-transform: capitalize;"/></td>
                </tr>
                <tr>
                    <td>Work Class</td>
                    <td><select id="nuwc"><option>Select</option><option>10</option><option>25</option><option>50</option><option>75</option><option>100</option><option>125</option><option>150</option><option>175</option><option>200</option><option>250</option></select></td>
                </tr>
                <tr>
                    <td><input type="submit" id="nucok" value="submit"/> <input type="submit" id="clear" value="Clear"/></td>
                </tr>
            </table>
    </form></body>
<?php }

function um(){?>
    <body style="background-color: aquamarine;">
        <h2 style="color:blue;">USER MODIFICATIONS</h2>
        <form style="margin-left: 500px;" autocomplete="off" onsubmit="return false">
            <table>
                <tr>
                    <td>User ID</td>
                    <td><input type="number" id="uid"/></td>
                    <td><label id="uidname"></label></td>
                </tr>
                <tr>
                    <td>P Work Class</td>
                    <td><label id="mupwc"></label></td>
                </tr>
                <tr>
                    <td>T Work Class</td>
                    <td><label id="mutwc"></label></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td><label id="mus"></label></td>
                </tr>
                <tr>
                    <td>Function</td>
                    <td><select id="mufunc"><option value="Select">Select</option><option value="Up/ Down Grade">Up/ Down Grade</option><option value="Active">Active</option><option value="Inactive">Inactive</option><option value="Password Reset">Password Reset</option></select></td>
                </tr>
                <tr>
                    <td><input type="submit" id="rurfmok"/> <input type="submit" id="clear" value="Clear"/></td>
                </tr>
            </table>
            </form>
</body>
<?php }

function teller(){?>
    <div>
    <h2 style="color:blue;">CASH OPERATIONS</h2>
	<table style="margin-left:400px;"><tr><td>Received</td><td><input type="number" id="tellrec" readonly="readonly"/></td><td>Balance</td><td><input type="number" readonly="readonly" id="tellbal"/></td></tr></table>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table id="tellmainscr" style="margin-left:400px; margin-top:50px;">
            <tr>
                <td>Functions</td>
                <td><select id="tellerfun" name="select"><option value="Select">Select</option><option value="deposit">Deposit</option><option value="withdraw">Withdrawal</option><option value="chqdep">Cheque Deposit</option><option value="chqenc">Cheque Encash</option></select></td>
            </tr>
            <tr>
                <td>AC No</td>
                <td><input type="number" id="telleraccno"/></td>
                <td><label id="accname"></label></td>
            </tr>
			<tr>
                <td>Transaction Amount</td>
                <td><input type="number" id="telleramactu"/></td>
            </tr>
			<tr>
                <td>Amount</td>
                <td><input type="number" readonly="readonly" id="telleram"/></td>
            </tr>
            <tr>
                <td>Cheque No</td>
                <td><input type="text" id="chqno"/></td>
            </tr>
			<tr>
                <td><input type="submit" id="tellerok" value="Submit"/> <input type="submit" id="clear" value="Clear"/></td>
            </tr>
		</table>
		<table id="denocal" hidden="hidden" style="margin-left:400px;">
            <tr>
                <td>Denominations</td>
            </tr>
            <tr>
                <td>5000/-</td>
                <td><input type="number" id="ft" value="0"/></td>
                <td>2000/-</td>
                <td><input type="number" id="tt" value="0"/></td>
                <td>1000/-</td>
                <td><input type="number" id="ot" value="0"/></td>
            </tr>
            <tr>
                <td>500/-</td>
                <td><input type="number" id="fh" value="0"/></td>
                <td>100/-</td>
                <td><input type="number" id="oh" value="0"/></td>
                <td>50/-</td>
                <td><input type="number" id="f" value="0"/></td>
            </tr>
            <tr>
                <td>20/-</td>
                <td><input type="number" id="t" value="0"/></td>
                <td>10/-</td>
                <td><input type="number" id="ten" value="0"/></td>
                <td>5/-</td>
                <td><input type="number" id="five" value="0"/></td>
            </tr>
            <tr>
                <td>2/-</td>
                <td><input type="number" id="two" value="0"/></td>
                <td>1/-</td>
                <td><input type="number" id="one" value="0"/></td>
                <td>Cents</td>
                <td><input type="number" id="cnts" value="0"/></td>
            </tr>
			<tr>
				<td>Total</td>
				<td><input type="number" readonly="readonly" id="denocaltotv"/></td>
			</tr>
			<tr>
                <td><input type="submit" id="denocalok" value="OK"/></td>
            </tr>
		</table>
        </form>
        </div>
<?php }

function nteller(){?>
    <div>
        <h2 style="color:blue;">NON CASH OPERATIONS</h2>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table id='nontellenterscr' style="margin-left:400px;">
			<tr><label style="margin-left:350px; color:red; font-size:20px;" id='msg'></label></tr>
			<tr>
				<td>Type</td>
				<td>Debit</td>
				<td>Type</td>
				<td>Credit</td>
			</tr>
			<tr>
				<td>Account No</td>
				<td><input type="number" id="ntellerdebitacno"/></td>
				<td>Account No</td>
				<td><input type="number" id="ntellercreditacno"/></td>
			</tr>
			<tr>
				<td>Name</td>
				<td><lable id='ntellerdebitacname'></lable></td>
				<td>Name</td>
				<td><lable id='ntellercreditacname'></lable></td>
			</tr>
			<tr>
				<td>Amount</td>
				<td><input type="number" id="ntelleramo"/></td>
			</tr>
			<tr>
				<td>Remarks</td>
				<td><input type="text" id="ntellerdebitrem"/></td>
				<td>Remarks</td>
				<td><input type="text" id="ntellercreditrem"/></td>
			</tr>
            <tr>
                <td><input type="submit" id="nontellerok" value="Submit"/> <input type="submit" id="clear" value="Clear"/></td>
            </tr>
        </table>
		<table id='nontellautscr' hidden="hidden" style="margin-left:400px; margin-top:20px;">
			<tr>
				<td>OverRide User</td>
				<td><input type="number" id="nonoverrideusr"/></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="text" id="nonoverpassaut"/></td>
			</tr>
            <tr>
                <td><input type="submit" id="nontelleroverusraut" value="Submit"/> <input type="submit" id="remoteoverride" value="Remote"/> <input type="submit" id="cancelremoteoverride" value="Cancel"/></td>
            </tr>
        </table>
        </form>
        </div>
<?php }

function cnbr(){?>
    <div>
        <h2 style="color:blue;">CREATE A NEW BRANCH</h2>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table style="margin-left:400px;">
            <tr>
                <td>Branch Name</td>
                <td><input type="text" style="text-transform: capitalize" id="brname"/></td>
            </tr>
            <tr>
                <td><input type="submit" id="bropenok" value="Open"/> <input type="submit" id="clear" value="Clear"/></td>
            </tr>
        </table>
        </form>
        </div>
<?php }

function mandate(){?>
    <div>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table id="cifcrescr" style="margin-left:350px;">
			<h2 style="color:blue;">CIF / ACCOUNT CREATION</h2>
            <tr><label style="margin-left:350px; color:red; font-size:20px;" id='mandatemsg'></label></tr>
            <tr>
                <td>Function</td>
                <td>Add New</td>
                <td>Another CIF</td>
                <td><select id="acctype"><option value="Select">Select</option><option value="No">No</option><option value="Yes">Yes</option></select></td>
            </tr>
            <tr>
                <td>Document</td>
                <td><select id="cusdoc"><option value="Select">Select</option><option value="NIC">NIC</option><option value="NDL">NDL</option><option value="BC">BC</option><option value="PP">PP</option><option value="POSTAL">POSTAL</option></select></td>
                <td>Unique Id</td>
                <td><input type="text" id="cusuid"/></td>
            </tr>
            <tr>
                <td>Title</td>
                <td><select id="custitle"><option value="Select">Select</option><option value="Mr">Mr</option><option value="Mrs">Mrs</option><option value="Mast">Mast</option><option value="Miss">Miss</option><option value="Ms">Ms</option><option value="Hon">Hon</option><option value="Dr">Dr</option><option value="Rev">Rev</option></select></td>
				<td>Full Name</td>
                <td><input type="text" id="cusfname"/></td>
            </tr>
            <tr>
                <td>Name with Initial</td>
                <td><input type="text" id="cusininame"/></td>
				<td>Date Of Birth</td>
                <td><input type="text" id="cusdob" placeholder="YYYY-MM-DD"/></td>
            </tr>
            <tr>
                <td>Gender</td>
                <td><select id="cusgen"><option>Select</option><option>Male</option><option>Female</option></select></td>
				<td>Permanent Address</td>
                <td><textarea id="cuspadd" rows="4"></textarea></td>
            </tr>
            <tr>
				<td>Phone</td>
                <td><input type="number" id="cusphone"/></td>
                <td>Email</td>
				<td><input type="email" id="cusemail"/></td>
            </tr>
            <tr>
                <td>Occupation</td>
                <td><input type="text" id="cusocc"/></td>
                <td>Language</td>
                <td><select id="cifcrelang"><option value="Select">Select</option><option value="Tamil">Tamil</option><option value="Sinhala">Sinhala</option><option value="English">English</option></select></td>
            </tr>
            <tr>
                <td><input type="submit" id="cifopen" value="Create"/> <input type="submit" id="clear" value="Clear"/></td>
            </tr>
        </table>
		<table id='acopscr' hidden="hidden" style="margin-left:350px;">
            <tr><label style="margin-left:350px; color:red; font-size:20px;" id='accmsg'></label></tr>
			<tr>
                <td>Scheme</td>
                <td><select id="schm"><option value="Select">Select</option><option value="SA00">SA00-Staff</option><option value="SA10">SA10-Regular</option><option value="SA20">SA20-Elders</option><option value="SA30">SA30-Special</option><option value="CA00">CA00-Staff</option><option value="CA10">CA10-Regular</option><option value="CA20">CA20-Elders</option><option value="CA30">CA30-Special</option><option value="FD00">FD00-Staff</option><option value="FD10">FD10-Regular</option><option value="FD20">FD20-Elders</option><option value="FD30">FD30-Special</option></select></td>
            </tr>
		</table>
		<table id="autoacsubscr" style="margin-left:350px;">
		</table>
		<table id="acopbutscr" hidden="hidden" style="margin-left:350px;">
		    <tr>
                <td><input style="margin-left:100px;" type="submit" id="accopenok" value="Create"/> <input type="submit" id="cancelacc" value="Cancel"/></td>
            </tr>
        </table>
        </form>
        </div>
<?php }

function cp(){?>
    <div>
        <h2 style="color:blue;">PASSWORD CHANGE PROCESS</h2>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table style="margin-left:400px;">
            <tr>
                <td>Old Password</td>
                <td><input type="password" style="text-transform: capitalize" id="oldpass"/></td>
            </tr>
            <tr>
                <td>New Password</td>
                <td><input type="password" style="text-transform: capitalize" id="newpass"/></td>
            </tr>
            <tr>
                <td>New Password Again</td>
                <td><input type="password" style="text-transform: capitalize" id="newpassag"/></td>
            </tr>
            <tr>
                <td><input type="submit" id="passchg" value="Change"/> <input type="submit" id="clear" value="Clear"/></td>
            </tr>
        </table>
        </form>
        </div>
<?php }

function mandatev(){?>
    <div style="background-color: aquamarine;">
        <h2 style="color:blue;">CUSTOMER INFORMATION FILE AUTHORIZE</h2>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table style="margin-left:350px;">
            <tr>
                <td>Function</td>
                <td>Verify</td>
                <td>Account No</td>
                <td><input type="text" id="aupick"/></td>
            </tr>
            <tr>
                <td>Document</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="cusdoc"/></td>
                <td>Unique Id</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="uidv"/></td>
            </tr>
            <tr>
                <td>Issue Date</td>
                <td><input type="text" readonly="readonly" id="cusisu" disabled="disabled"/></td>
                <td>Title</td>
                <td><input type="text" readonly="readonly" id="custitle" disabled="disabled"/></td>
            </tr>
            <tr>
                <td>Full Name</td>
                <td><input type="text" id="cusfname" readonly="readonly" disabled="disabled"/></td>
                <td>Name with Initial</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="cusininame"/></td>
            </tr>
            <tr>
                <td>Gender</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="cusgen"/></td>
                <td>Date Of Birth</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="cusdob"/></td>
            </tr>
            <tr>
                <td>Resident</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="cusres"/></td>
                <td>Telephone</td>
                <td><input type="number" readonly="readonly" disabled="disabled" id="custel"/></td>
            </tr>
            <tr>
                <td>Phone</td>
                <td><input type="number" readonly="readonly" disabled="disabled" id="cusphone"/></td>
                <td>Email</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="cusemail"/></td>
            </tr>
            <tr>
                <td>Permanent Address</td>
                <td><textarea id="cuspadd" rows="3"readonly="readonly" disabled="disabled"></textarea></td>
                <td>Communication Address</td>
                <td><textarea id="cuscadd" rows="3"readonly="readonly" disabled="disabled"></textarea></td>
            </tr>
            <tr>
                <td>Tax Payer</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="custax"/></td>
                <td>Tax No</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="custaxno"/></td>
            </tr>
            <tr>
                <td>Occupation</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="cusocc"/></td>
                <td>Income Level</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="cusinl"/></td>
            </tr>
            <tr>
                <td><input type="submit" id="cifv" value="Authorize"/> <input type="submit" id="clear" value="Clear"/></td>
            </tr>
        </table>
        </form>
        </div>
<?php }

function uidm(){?>
    <div>
        <h2 style="color:blue;">UNIQUE ID MODIFY</h2>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table style="margin-left:450px;">
            <tr><label style="margin-left:350px; color:red; font-size:20px;" id='uidmmsg'></label></tr>
            <tr>
                <td>CIF NO</td>
                <td><input type="number" id="uidmcif"/>
            </tr>
            <tr>
                <td>Unique Id</td>
                <td><label id="uidm"></label></td>    
            </tr>
            <tr>
                <td>New Unique Id</td>
                <td><input type="text" id="nuidm"/></td>    
            </tr>
            <tr>
                <td><input type="submit" id="uidmod" value="Change"/> <input type="submit" id="clear" value="Clear"/></td>
            </tr>
        </table>
        </form>
        </div>
<?php }

function cifi(){?>
    <div>
        <h2 style="color:blue;">CUSTOMER INFORMATION FILE INQUIR</h2>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table style="margin-left:350px;">
            <tr>
                <td><select id="cifinqby"><option value="Select">Select</option><option value="nic">NIC No</option><option value="accno">Account No</option><option value="cif">CIF No</option></select></td>
                <td><input type="text" id="cifinquniq"/></td>
                <td>CIF</td>
                <td><label id="cifno"></label></td>
            </tr>
            <tr>
                <td>Document</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="idoc"/></td>
                <td>Unique Id</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="iuid"/></td>
            </tr>
            <tr>
                <td>Issue Date</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="iisu"/></td>
                <td>Title</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="ititle"/></td>
            </tr>
            <tr>
                <td>Full Name</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="ifname"/></td>
                <td>Name with Initial</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="iininame"/></td>
            </tr>
            <tr>
                <td>Gender</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="igen"/></td>
                <td>Date Of Birth</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="idob"/></td>
            </tr>
            <tr>
                <td>Resident</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="ires"/></td>
                <td>Telephone</td>
                <td><input type="number" readonly="readonly" id="itele" disabled="disabled"/></td>
            </tr>
            <tr>
                <td>Phone</td>
                <td><input type="number" readonly="readonly" id="iphone" disabled="disabled"/></td>
                <td>Email</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="iemail"/></td>
            </tr>
            <tr>
                <td>Permanent Address</td>
                <td><textarea id="ipadd" rows="3"readonly="readonly" disabled="disabled"></textarea></td>
                <td>Communication Address</td>
                <td><textarea id="icadd" rows="3"readonly="readonly" disabled="disabled"></textarea></td>
            </tr>
            <tr>
                <td>Tax Payer</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="itax"/></td>
                <td>Tax No</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="itaxno"/></td>
            </tr>
            <tr>
                <td>Occupation</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="iocc"/></td>
                <td>Income Level</td>
                <td><input type="text" readonly="readonly" disabled="disabled" id="iinl"/></td>
            </tr>
            <tr>
                <td><input type="submit" id="clear" value="Clear"/></td>
            </tr>
        </table>
        </form>
        </div>
<?php }

function ctsm(){?>
    <div>
        <h2 style="color:blue;">CASH TRANSACTION STATUS MODIFICATION</h2>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table style="margin-left:400px;">
            <tr>
                <td>SOL ID</td>
                <td><lable></lable></td>
            </tr>
            <tr>
                <td>Function</td>
                <td><select id="ctschangefun"><option value="Select">Select</option><option>Open / Close</option></select></td>
            </tr>
            <tr>
                <td><input type="submit" id="ctschk" value="Check Status"/><input type="submit" id="ctschange" value="Submit"/> <input type="submit" id="clear" value="Clear"/></td>
            </tr>
        </table>
        </form>
        </div>
<?php }

function autf(){?>
    <div>
        <h2 style="color:blue;">ASIGN USER FOR TELLER FUNCTIONS</h2>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table style="margin-left:400px;">
            <tr>
                <td>User ID</td>
                <td><input type="number" id="autbuid"/></td>
            </tr>
            <tr>
                <td>Function</td>
                <td><select id="autbfun"><option value="Select">Select</option><option value="Add">Add</option><option value="Delete">Delete</option></select></td>
            </tr>
            <tr>
                <td>Teller GL</td>
                <td><input type="text" id="autbgl"/></td>
            </tr>
            <tr>
                <td><input type="submit" id="autbsub" value="Submit"/> <input type="submit" id="clear" value="Clear"/></td>
            </tr>
        </table>
        </form>
        </div>
<?php }

function hcrn(){?>
    <div>
        <h2 style="color:blue;">HANDLE CHEQUE RETURNS</h2>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table style="margin-left:400px;">
            <tr>
                <td>Debit Account Status</td>
                <td><select id="autbfun"><option value="Select">Select</option><option value="Open">Open</option><option value="Closed">Closed</option></select></td>
            </tr>
            <tr>
                <td>Debit Account No</td>
                <td><input type="number" id="hcrndebitacno"/></td>
				<td><lable id='hcrndebitacname'></lable></td>
            </tr>
			<tr>
                <td>Return Remark</td>
                <td><select id="autbfun"><option value="Select">Select</option><option value="RD">Refer To Drawer</option><option value="STOP">Payment Stoped By The Drawer</option><option value="AC">Account Closed</option><option value="CV">Credit Not Verified</option></select></td>
            </tr>
			<tr>
                <td>Cheque No</td>
                <td><input type="number" id="hcrndebitchqno"/></td>
            </tr>
			<tr>
                <td>Credit Account No</td>
                <td><input type="number" id="hcrncreditacno"/></td>
				<td><lable id='hcrncreditacname'></lable></td>
            </tr>
            <tr>
                <td><input type="submit" id="hcrnsubpost" value="Submit"/> <input type="submit" id="clear" value="Clear"/></td>
            </tr>
        </table>
        </form>
        </div>
<?php }

function genrep(){?>
    <div>
        <h2 style="color:blue;">REPORTS GENERATIONS</h2>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table style="margin-left:400px;">
            <tr>
                <td>User ID</td>
                <td><input type="number" id="autbuid"/></td>
            </tr>
            <tr>
                <td>Function</td>
                <td><select id="autbfun"><option value="Select">Select</option><option value="Add">Add</option><option value="Delete">Delete</option></select></td>
            </tr>
            <tr>
                <td>Teller GL</td>
                <td><input type="text" id="autbgl"/></td>
            </tr>
            <tr>
                <td><input type="submit" id="autbsub" value="Submit"/> <input type="submit" id="clear" value="Clear"/></td>
            </tr>
        </table>
        </form>
        </div>
<?php }

function nao(){?>
    <div>
        <h2 style="color:blue;">NOTE ACCOUNT OPENINGS</h2>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table style="margin-left:400px;">
            <tr>
                <td>User ID</td>
                <td><input type="number" id="autbuid"/></td>
            </tr>
            <tr>
                <td>Function</td>
                <td><select id="autbfun"><option value="Select">Select</option><option value="Add">Add</option><option value="Delete">Delete</option></select></td>
            </tr>
            <tr>
                <td>Teller GL</td>
                <td><input type="text" id="autbgl"/></td>
            </tr>
            <tr>
                <td><input type="submit" id="autbsub" value="Submit"/> <input type="submit" id="clear" value="Clear"/></td>
            </tr>
        </table>
        </form>
        </div>
<?php }

function nac(){?>
    <div>
        <h2 style="color:blue;">NOTE ACCOUNT CLOSING</h2>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table style="margin-left:400px;">
            <tr>
                <td>User ID</td>
                <td><input type="number" id="autbuid"/></td>
            </tr>
            <tr>
                <td>Function</td>
                <td><select id="autbfun"><option value="Select">Select</option><option value="Add">Add</option><option value="Delete">Delete</option></select></td>
            </tr>
            <tr>
                <td>Teller GL</td>
                <td><input type="text" id="autbgl"/></td>
            </tr>
            <tr>
                <td><input type="submit" id="autbsub" value="Submit"/> <input type="submit" id="clear" value="Clear"/></td>
            </tr>
        </table>
        </form>
        </div>
<?php }

function nam(){?>
    <div>
        <h2 style="color:blue;">NOTE ACCOUNT MAINTAINING</h2>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table style="margin-left:400px;">
            <tr>
                <td>User ID</td>
                <td><input type="number" id="autbuid"/></td>
            </tr>
            <tr>
                <td>Function</td>
                <td><select id="autbfun"><option value="Select">Select</option><option value="Add">Add</option><option value="Delete">Delete</option></select></td>
            </tr>
            <tr>
                <td>Teller GL</td>
                <td><input type="text" id="autbgl"/></td>
            </tr>
            <tr>
                <td><input type="submit" id="autbsub" value="Submit"/> <input type="submit" id="clear" value="Clear"/></td>
            </tr>
        </table>
        </form>
        </div>
<?php }

function hold(){?>
    <div>
        <h2 style="color:blue;">HOLD HANDLING FUNCTIONS</h2>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table style="margin-left:400px;">
            <tr>
                <td>User ID</td>
                <td><input type="number" id="autbuid"/></td>
            </tr>
            <tr>
                <td>Function</td>
                <td><select id="autbfun"><option value="Select">Select</option><option value="Add">Add</option><option value="Delete">Delete</option></select></td>
            </tr>
            <tr>
                <td>Teller GL</td>
                <td><input type="text" id="autbgl"/></td>
            </tr>
            <tr>
                <td><input type="submit" id="autbsub" value="Submit"/> <input type="submit" id="clear" value="Clear"/></td>
            </tr>
        </table>
        </form>
        </div>
<?php }

function inqv(){?>
    <div>
        <h2 style="color:blue;">INQUIRE VIEW</h2>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table style="margin-left:400px;">
            <tr>
                <td>Inquire By</td>
                <td><select id="inqvfunsel"><option value="Select">Select</option><option value="NIC">NIC</option><option value="CIF">CIF</option><option value="PHN">Phone No</option><option value="USR">User Id</option><option value="SNAM">Short Name</option></select></td>
                <td><input type="text" id="inqvfinpu"/></td>
            </tr>
            <tr>
                <td><input type="submit" id="autbsub" value="View"/> <input type="submit" id="clear" value="Clear"/></td>
            </tr>
        </table>
		<table id="inqvfunscrv">
		</table>
        </form>
		</div>
<?php }

function opt(){?>
    <div>
        <h2 style="color:blue;">OPEN TILL FOR CASH TRANSACTION</h2>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table style="margin-left:400px;">
            <tr>
                <td>Function</td>
                <td><input type='text' value='Open' readonly='readonly'/></td>
            </tr>
            <tr>
                <td><input type="submit" id="optsubok" value="Submit"/> <input type="submit" id="clear" value="Clear"/></td>
            </tr>
        </table>
        </form>
        </div>
<?php }

function der(){?>
    <div>
        <h2 style="color:blue;">DAY END RUN</h2>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table style="margin-left:400px;">
            <tr>
                <td>User ID</td>
                <td><input type="number" id="autbuid"/></td>
            </tr>
            <tr>
                <td>Function</td>
                <td><select id="autbfun"><option value="Select">Select</option><option value="Add">Add</option><option value="Delete">Delete</option></select></td>
            </tr>
            <tr>
                <td>Teller GL</td>
                <td><input type="text" id="autbgl"/></td>
            </tr>
            <tr>
                <td><input type="submit" id="autbsub" value="Submit"/> <input type="submit" id="clear" value="Clear"/></td>
            </tr>
        </table>
        </form>
        </div>
<?php }

function uup(){?>
    <div>
        <h2 style="color:blue;">UPDATE USER PERMANENTLY</h2>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table style="margin-left:400px;">
            <tr>
                <td>User ID</td>
                <td><input type="number" id="autbuid"/></td>
            </tr>
            <tr>
                <td>Function</td>
                <td><select id="autbfun"><option value="Select">Select</option><option value="Add">Add</option><option value="Delete">Delete</option></select></td>
            </tr>
            <tr>
                <td>Teller GL</td>
                <td><input type="text" id="autbgl"/></td>
            </tr>
            <tr>
                <td><input type="submit" id="autbsub" value="Submit"/> <input type="submit" id="clear" value="Clear"/></td>
            </tr>
        </table>
        </form>
        </div>
<?php }

function clst(){?>
    <div>
        <h2 style="color:blue;">ASIGN USER FOR TELLER FUNCTIONS</h2>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table style="margin-left:400px;">
            <tr>
                <td>User ID</td>
                <td><input type="number" id="autbuid"/></td>
            </tr>
            <tr>
                <td>Function</td>
                <td><select id="autbfun"><option value="Select">Select</option><option value="Add">Add</option><option value="Delete">Delete</option></select></td>
            </tr>
            <tr>
                <td>Teller GL</td>
                <td><input type="text" id="autbgl"/></td>
            </tr>
            <tr>
                <td><input type="submit" id="autbsub" value="Submit"/> <input type="submit" id="clear" value="Clear"/></td>
            </tr>
        </table>
        </form>
        </div>
<?php }

function cshbal(){?>
    <div>
        <h2 style="color:blue;">TELLER CASH BALANCING</h2>
    <form autocomplete="off" method="post" onsubmit="return false">
		<table style="margin-left:500px;" id="deev">
			<tr><td><input type="submit" id="cshbalvok" value="Balance View"/></td></tr>
		</table>
        <table id="cshbaldeev" style="margin-left:300px;" hidden="hidden">
			<tr>
				<td>System Cash Balance</td>
				<td><input type="number" id="syscshbal" readonly="readonly"/></td>
				<td>Physical Cash Balance</td>
				<td><input type="number" id="denocaltotv" readonly="readonly"/></td>
			</tr>
			<tr>
				<td>Shortage / Excess</td>
				<td><input type="number" id="cshexsh" readonly="readonly"/></td>
			</tr>
            <tr>
                <td>5000/-</td>
                <td><input type="number" id="ft" value="0"/></td>
                <td>2000/-</td>
                <td><input type="number" id="tt" value="0"/></td>
                <td>1000/-</td>
                <td><input type="number" id="ot" value="0"/></td>
            </tr>
            <tr>
                <td>500/-</td>
                <td><input type="number" id="fh" value="0"/></td>
                <td>100/-</td>
                <td><input type="number" id="oh" value="0"/></td>
                <td>50/-</td>
                <td><input type="number" id="f" value="0"/></td>
            </tr>
            <tr>
                <td>20/-</td>
                <td><input type="number" id="t" value="0"/></td>
                <td>10/-</td>
                <td><input type="number" id="ten" value="0"/></td>
                <td>5/-</td>
                <td><input type="number" id="five" value="0"/></td>
            </tr>
            <tr>
                <td>2/-</td>
                <td><input type="number" id="two" value="0"/></td>
                <td>1/-</td>
                <td><input type="number" id="one" value="0"/></td>
                <td>Cents</td>
                <td><input type="number" id="cnts" value="0"/></td>
            </tr>
			<tr>
				<td>Mutilated</td>
				<td><input type="number" id="muti" value='0'/></td>
			</tr>
			<tr>
                <td><input type="submit" id="cshbalsub" value="Update"/> <input type="submit" id="clear" value="Reload"/></td>
            </tr>
        </table>
        </form>
        </div>
<?php }

function osau(){?>
    <div>
        <h2 style="color:blue;">OPEN SYSTEM FOR ALL USERS</h2>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table style="margin-left:400px;">
			<tr>
				<td>Password</td>
				<td><input type="text" id="osauinpass"/></td>
			</tr>
			<tr>
				<td><input type="submit" id="osausubconf" value="Open Finacle System for All Users"/> <input type="submit" id="clear" value="Clear"/></td>
            </tr>
        </table>
        </form>
        </div>
<?php }

function cngla(){?>
    <div>
        <h2 style="color:blue;">CREATE A NEW GENERAL LEDGER ACCOUNT</h2>
    <form autocomplete="off" method="post" onsubmit="return false">
        <table style="margin-left:400px;">
            <tr>
                <td>Name</td>
                <td><input type="text" id="autbgl"/></td>
            </tr>
            <tr>
                <td><input type="submit" id="autbsub" value="Submit"/> <input type="submit" id="clear" value="Clear"/></td>
            </tr>
        </table>
        </form>
        </div>
<?php }


$_SESSION['option']();
script();

?>
