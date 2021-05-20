<?php
session_start();

function lgin(){
$user = ($_POST['user']);
$pass = ($_POST['pass']);

	if(empty($_COOKIE['accesstknon']) && empty($_COOKIE['accesstkntw'])){
		
$connect = mysqli_connect('localhost','root','','finacle');
$query_chk_process = "SELECT `res` FROM `system` WHERE `tget`='Status'";
$query_chk = mysqli_query($connect,$query_chk_process);
$sta = mysqli_fetch_assoc($query_chk);
$dec = $sta['res'];

	
	if ($user == 1001 || $dec == 'Open'){
 
		$query_login_process = "SELECT `id` FROM `users` WHERE `userid`='$user' AND `password`='$pass'";
		
if($query_run = mysqli_query($connect,$query_login_process)){
                $query_num_rows = mysqli_num_rows($query_run);
                if($query_num_rows == 1){
                    
                    $lgcountfind = "SELECT `status`,`lgstatus`,`sol` FROM `users` WHERE `userid`='$user'";
                    $sta = mysqli_query($connect,$lgcountfind);
                    $status = mysqli_fetch_assoc($sta);
                    
                    if($status['status'] != 'Inactive'){
                        if($status['lgstatus'] != 1){
                    $lgcount = "UPDATE `users` SET `lgcount`='0',`lgstatus`='1' WHERE `userid`='$user'";
                    mysqli_query($connect,$lgcount);
                    $data['user'] = $user;
                    $data['sol'] = $status['sol'];
                            
                    function tcreate(){
                            $i = array('+','A','@','^','B',8,'C','#','D',5,'E','$',4,'F','G',9,'-','H','I','J','_','!',1,'%','K',2,'L','&',3,'M','N',0,'O',6,'*','P',7,'Q','R','(','S',')','/','U','V','W','+','X','Y','Z');
                    
                            $a= 0;
                            while($a < 16){
                            $num[$a] = $i[rand(0,49)];
                            $a++;
                            }
                    $serial = $num[1].$num[2].$num[3].$num[4].$num[5].$num[6].$num[7].$num[8].$num[9].$num[10].$num[11].$num[12].$num[13].$num[14].$num[15];
                        return $serial;
                    }
                    
                    $tokenusr = tcreate();
                    $tusrsl = tcreate();
                            
                    while($tokenusr == $tusrsl){
                        $tokenusr = tcreate();
                        $tusrsl = tcreate();
                    }
                    function getexe($tokenusr,$tusrsl,$connect){
                    $getex = "SELECT `userid` FROM `users` WHERE `accesstoken`='$tokenusr' AND `accesstokensl`='$tusrsl'";
                    $get =  mysqli_query($connect,$getex);
                        if(mysqli_num_rows($get) != null) {
                            return true;
                        }
                    }
                            $usususr = getexe($tokenusr,$tusrsl,$connect);
                            while($usususr == true){
                                $tokenusr = tcreate();
                                $tusrsl = tcreate();
                                $usususr = getexe($tokenusr,$tusrsl,$connect);
                            }
                               $uptdet = "UPDATE `users` SET `accesstoken`='$tokenusr',`accesstokensl`='$tusrsl' WHERE `userid`='$user'";
                            mysqli_query($connect,$uptdet);
                            setcookie('accesstknon',$tokenusr);
							setcookie('accesstkntw',$tusrsl);
							$_SESSION['option']="home";
							$_SESSION['secoption']="home";
                            $data['msg'] = 0; 
                            }else{
                            $data['msg'] = 2;
                        }
                    }else{
                        $data['msg'] = 1;
                        $data['status'] = 1;
                    }
                }else if($query_num_rows == 0){
                    $lgcountfind = "SELECT `status` FROM `users` WHERE `userid`='$user'";
                    $sta = mysqli_query($connect,$lgcountfind);
                    $status = mysqli_fetch_assoc($sta);
                    
                    if($status['status'] == 'Active'){
                    $lgcountfind = "SELECT `lgcount` FROM `users` WHERE `userid`='$user'";
                    $cou = mysqli_query($connect,$lgcountfind);
                    $count = mysqli_fetch_assoc($cou);
                    $num = $count['lgcount'];
                    $num = $num + 1;
                    $data['msg'] = 1;
                        
                    if($num == 4){
                    $lgcount = "UPDATE `users` SET `lgcount`='$num',`status`='Inactive' WHERE `userid`='$user'";
                    mysqli_query($connect,$lgcount);
                    }else{
                    $lgcount = "UPDATE `users` SET `lgcount`='$num' WHERE `userid`='$user'";
                    mysqli_query($connect,$lgcount);
                    }}else if($status['status'] == 'Inactive'){
                        $data['msg'] = 1;
                        $data['status'] = 1;
                    }else{
                        $data['msg'] = 1;
                    }
}}
	
	
}else{
		$data['msg'] = 1001;
	}
}else{
	$data['msg'] = 101;
}
echo json_encode($data);
}

function lgout(){
    $token = $_COOKIE['accesstknon'];
    $sol = $_COOKIE['accesstkntw'];
    $connect = mysqli_connect('localhost','root','','finacle');
    $access = "SELECT `userid` FROM `users` WHERE `accesstoken`='$token' AND `accesstokensl`='$sol'";
    $run = mysqli_query($connect,$access);
    $output = mysqli_fetch_assoc($run);
    $user = $output['userid'];
    $lgstatus = "UPDATE `users` SET `lgstatus`='0', `accesstoken`='', `accesstokensl`='' WHERE `userid`='$user'";
    mysqli_query($connect,$lgstatus);
	setcookie('accesstknon','',time()-3600);
	setcookie('accesstkntw','',time()-3600);
	unset($_SESSION['option']);
    $data['msg'] = 1;
    echo json_encode($data);
}

function getcoo(){
	$minpast = $_POST['minpast'];
	$accone = $_COOKIE['accesstknon'];
	$acctwo = $_COOKIE['accesstkntw'];
	
	$connect = mysqli_connect('localhost','root','','finacle');
	
    $access = "SELECT `userid`, `msg` FROM `users` WHERE `accesstoken`='$accone' AND `accesstokensl`='$acctwo'";
    $run = mysqli_query($connect,$access);
    $output = mysqli_fetch_assoc($run);
    $user = $output['userid'];
	$msg = $output['msg'];
	
	if($user == null & $msg == null){
		$data['msg'] = 1;
	}else if($user != null & $msg != null & $msg != 0){
		if($msg == 4){
			$query = "UPDATE `users` SET `msg`='0', `lgstatus`='0', `accesstoken`='', `accesstokensl`='' WHERE `userid`='$user'";
    		mysqli_query($connect,$query);
			setcookie('accesstknon','',time()-3600);
			setcookie('accesstkntw','',time()-3600);
			unset($_SESSION['option']);
			$data['msg'] =4;
		}else if($msg == 3){
			$query = "UPDATE `users` SET `msg`='0' WHERE `userid`='$user'";
    		mysqli_query($connect,$query);
			$data['msg'] = 3;
		}else if($msg == 2){
			$time = time();
			$time_style = date('Y-m-d',$time);
			$query = "SELECT `subject`, `frmuser`, `status` FROM `msgview` WHERE `user`='$user' AND `date`='$time_style'";
    		$runqu = mysqli_query($connect,$query);
    		$outputqu = mysqli_fetch_assoc($runqu);
    		$data['subject'] = $outputqu['subject'];
			$data['frmuser'] = $outputqu['frmuser'];
			$query = "UPDATE `users` SET `msg`='0' WHERE `userid`='$user'";
    		mysqli_query($connect,$query);
			$data['msg'] = 2;
			
		}else if($msg == 1){
			$query = "SELECT `overfrm` FROM `users` WHERE `userid`='$user'";
    		$runqu = mysqli_query($connect,$query);
    		$outputqu = mysqli_fetch_assoc($runqu);
			$data['frmuser'] = $outputqu['overfrm'];
			$query = "UPDATE `users` SET `msg`='0', `overfrm`='0' WHERE `userid`='$user'";
    		mysqli_query($connect,$query);
			$data['msg'] = 7;
			
		}else{
			$senter = $msg;
			
			$query = "SELECT `dracno`, `dracname`, `amount`, `debitref`, `cracno`, `cracname`, `creditref`, `reason` FROM `override` WHERE `user`='$senter'";
    		$runqu = mysqli_query($connect,$query);
    		$outputqu = mysqli_fetch_assoc($runqu);
    		$data['dracno'] = $outputqu['dracno'];
			$data['dracname'] = $outputqu['dracname'];
			$data['cracname'] = $outputqu['cracname'];
			$data['amount'] = $outputqu['amount'];
			$data['debitref'] = $outputqu['debitref'];
			$data['cracno'] = $outputqu['cracno'];
			$data['creditref'] = $outputqu['creditref'];
			$data['reason'] = $outputqu['reason'];
			$data['senter'] = $senter;
			$query = "UPDATE `users` SET `msg`='0' WHERE `userid`='$user'";
    		mysqli_query($connect,$query);
			
			$data['msg'] = 6;
		}
	}else{}
	
	if($minpast > 12 & $minpast < 10.2){
		$query = "UPDATE `users` SET `lgstatus`='0', `accesstoken`='', `accesstokensl`='' WHERE `userid`='$user'";
    		mysqli_query($connect,$query);
			setcookie('accesstknon','',time()-3600);
			setcookie('accesstkntw','',time()-3600);
			unset($_SESSION['option']);
			$data['msg'] =5;
	}else{}
	
    echo json_encode($data);
}

function decover(){
	$accone = $_COOKIE['accesstknon'];
	$acctwo = $_COOKIE['accesstkntw'];
	
	$connect = mysqli_connect('localhost','root','','finacle');
	
    $access = "SELECT `userid`, `overfrm` FROM `users` WHERE `accesstoken`='$accone' AND `accesstokensl`='$acctwo'";
    $run = mysqli_query($connect,$access);
    $output = mysqli_fetch_assoc($run);
    $user = $output['userid'];
	$frm = $output['overfrm'];
	
	$query = "UPDATE `users` SET `msg`='1', `overfrm`='$user' WHERE `userid`='$frm'";
    mysqli_query($connect,$query);
	$query = "UPDATE `users` SET `msg`='0', `overfrm`='0' WHERE `userid`='$user'";
    mysqli_query($connect,$query);
	$data['msg'] = 1;
	echo json_encode($data);
}

function optionselect(){
    $newopt = $_POST['newopt'];
    $token = $_COOKIE['accesstknon'];
    $sol = $_COOKIE['accesstkntw'];
    $connect = mysqli_connect('localhost','root','','finacle');
    $access = "SELECT `userid` FROM `users` WHERE `accesstoken`='$token' AND `accesstokensl`='$sol'";
    $run = mysqli_query($connect,$access);
    $output = mysqli_fetch_assoc($run);
    $user = $output['userid'];
    
    $fwork = "SELECT `tworkclass` FROM `users` WHERE `userid`='$user'";
    $fworkclass = mysqli_query($connect,$fwork);
    $workclass = mysqli_fetch_assoc($fworkclass);
    $twc = $workclass['tworkclass'];
    
	$wcls = array(10=>array('HACLI','NTELLER','CP','MANDATE','HOME','UP','STPR','GENREP','CIFI','INQV'),
				  25=>array('HACLI','NTELLER','TELLER','CP','MANDATE','HOME','UP','STPR','GENREP','CIFI','HOLD','INQV','OPT','CLST','CSHBAL'),
				  50=>array('HACLI','TELLER','NTELLER','CP','MANDATE','HOME','UP','OREG','STPR','GENREP','NAO','NAC','CIFI','HOLD','INQV','OPT','CLST','CSHBAL'),
				  75=>array('HACLI','TELLER','NTELLER','CP','MANDATE','HOME','HCRN','UP','OREG','GENREP','NAO','NAC','CIFI','HOLD','INQV','OPT','CLST','CSHBAL'),
				  100=>array('HACLI','TELLER','NTELLER','CP','MANDATE','HOME','HCRN','UP','OREG','GENREP','NAO','NAC','CIFI','HOLD','INQV','OPT','CLST','CSHBAL'),
				  125=>array('HACLI','AUTF','NTELLER','CP','MANDATE','HOME','OREG','GENREP','NAM','NAC','CIFI','HOLD','INQV'),
				  150=>array('HACLI','AUTF','','CP','MANDATE','HOME','CTSM','OREG','GENREP','NAM','NAC','CIFI','HOLD','INQV'),
				  175=>array('HACLI','AUTF','','CP','MANDATE','HOME','CTSM','GENREP','NAM','NAC','CIFI','HOLD','INQV'),
				  200=>array('HACLI','AUTF','','CP','MANDATE','HOME','CTSM','GENREP','NAM','NAC','CIFI','HOLD','INQV'),
				  250=>array('HACLI','TELLER','NTELLER','CP','MANDATE','HOME','AUTF','CNBR','CTSM','NUC','UM','DER','HCRN','UUP','OREG','GENREP','NAO','NAM','NAC','CNGLA','CIFI','OSAU','UIDM','HOLD','INQV','OPT','CLST','CSHBAL'));
	
	$run = 0;
	$limit = count($wcls[$twc]);
	$exc = $limit -1;
	while($run < $limit){
		if($wcls[$twc][$run] == $newopt and $wcls[$twc][$run] !=''){
			$run = 10000;
			$_SESSION['option'] = $newopt;
            $data['msg']=1;
		}else if($run == $exc){
			$data['msg']=0;
		}
		$run = $run +1;
	}
	echo json_encode($data);
}

function nontelpost(){
	$dr = $_POST['ntellerdebitacno'];
	$cr = $_POST['ntellercreditacno'];
	$am = $_POST['ntelleramo'];
	$drr = $_POST['ntellerdebitrem'];
	$crr = $_POST['ntellercreditrem'];
	
	$connect = mysqli_connect('localhost','root','','finacle');
	
	$token = $_COOKIE['accesstknon'];
    $sol = $_COOKIE['accesstkntw'];
	
    $access = "SELECT `userid`, `tmsol`, `tworkclass` FROM `users` WHERE `accesstoken`='$token' AND `accesstokensl`='$sol'";
    $run = mysqli_query($connect,$access);
    $output = mysqli_fetch_assoc($run);
    $enterer = $output['userid'];
	$sol = $output['tmsol'];
	$twc = $output['tworkclass'];
	
	$time = time();
	$time_style = date('Y-m-d',$time);
	
	$query_tmst	=	"SELECT `tfr` FROM `branches` WHERE `sol`='$sol'";
	$query_chk = mysqli_query($connect,$query_tmst);
	$sta = mysqli_fetch_assoc($query_chk);
	$probres = $sta['tfr'];
	$drentryst = "";
	$crentryst = "";
	$data['msg'] = "";
	if($probres == 'Open'){
	
	 if($dr > 100000099 & $dr < 1000000000){
			 $query_bal_chk = "SELECT `sol`, `balance`, `type` FROM `glaccounts` WHERE `accountno`='$dr'";
			 $run = mysqli_query($connect,$query_bal_chk);
		     $output = mysqli_fetch_assoc($run);
		 	 $drcc = $output['sol'];
			 $drbal = $output['balance'];
			 $drst = $output['type'];
			 
			if($drst == 0){
				 $query_tran = "SELECT MAX(tranid) AS tranid FROM `transactions` WHERE `date`='$time_style'";
				 $run = mysqli_query($connect,$query_tran);
				 $output = mysqli_fetch_assoc($run);
		 		 $tranid = $output['tranid'];
				 if($tranid == null){
					 $tranid = 1000;
				 }else{
					 $tranid = $tranid + rand(1,4);
				 }
				 
				 $drnewbal = $drbal - $am;
				 $query_entry_dr = "INSERT INTO `transactions` (sol,tranid,accountno,cc,date,credit,debit,amount,balance,remark,chqno,chqrem,entry,enterby,verifiedby,overby) VALUES ('$sol','$tranid','$dr','$drcc','$time_style','0.00','$am','$am','$drnewbal','$drr','','','$cr','$enterer','','NA')";
				 $query_balup_dr = "UPDATE `glaccounts` SET `balance`='$drnewbal' WHERE `accountno`='$dr'";
				 $drentryst = 'Y';
			 }else{
				$data['msg']=7;
			}
		 
    }else if($dr > 800000000000 & $dr < 1000000000000){
         $query_own_chk = "SELECT `cif` FROM `saaccounts` WHERE `accountno`='$dr'";
		 $run = mysqli_query($connect,$query_own_chk);
		 $output = mysqli_fetch_assoc($run);
		 $chkres = $output['cif'];
		 $query_own_chkk = "SELECT `nic` FROM `cifdetails` WHERE `cif`='$chkres'";
		 $run = mysqli_query($connect,$query_own_chkk);
		 $output = mysqli_fetch_assoc($run);
		 $chkress = $output['nic'];
		 $query_own_chkkk = "SELECT `userid` FROM `users` WHERE `nic`='$chkress'";
		 $run = mysqli_query($connect,$query_own_chkkk);
		 $output = mysqli_fetch_assoc($run);
		 $chkresss = $output['userid'];
		 
		 if($chkresss == $enterer){
			 $data['msg']=1;
		 }else{
			 $query_bal_chk = "SELECT `sol`, `balance`, `hold`, `status` FROM `saaccounts` WHERE `accountno`='$dr'";
			 $run = mysqli_query($connect,$query_bal_chk);
		     $output = mysqli_fetch_assoc($run);
		 	 $drcc = $output['sol'];
			 $drbal = $output['balance'];
			 $drho = $output['hold'];
			 $drst = $output['status'];
			 $drnetbal = $drbal - $drho;
			 
			if(($drst == 'Active' | $drst == 'CFreeze') & ($drnetbal  > $am | $drnetbal == $am)){
				 $query_tran = "SELECT MAX(tranid) AS tranid FROM `transactions` WHERE `date`='$time_style'";
				 $run = mysqli_query($connect,$query_tran);
				 $output = mysqli_fetch_assoc($run);
		 		 $tranid = $output['tranid'];
				 if($tranid == null){
					 $tranid = 1000;
				 }else{
					 $tranid = $tranid + rand(1,4);
				 }
				 
				 $drnewbal = $drbal - $am;
				 $query_entry_dr = "INSERT INTO `transactions` (sol,tranid,accountno,cc,date,credit,debit,amount,balance,remark,chqno,chqrem,entry,enterby,verifiedby,overby) VALUES ('$sol','$tranid','$dr','$drcc','$time_style','0.00','$am','$am','$drnewbal','$drr','','','$cr','$enterer','','NA')";
				 $query_balup_dr = "UPDATE `saaccounts` SET `balance`='$drnewbal' WHERE `accountno`='$dr'";
				 $drentryst = 'Y';
			 }else if(($drst == 'Active' | $drst == 'CFreeze') & ($drbal  > $am | $drbal == $am)){
				 $data['msg']=2;
			 }else if(($drst == 'Active' | $drst == 'CFreeze') & ($drbal < $am)){
				$data['msg']=30;
			}else{
				$data['status']=$drst;
				$data['msg']=4;
			}
		 }
    }else if($dr >100000000000 & $dr <300000000000){
		 $query_own_chk = "SELECT `cif` FROM `caaccounts` WHERE `accountno`='$dr'";
		 $run = mysqli_query($connect,$query_own_chk);
		 $output = mysqli_fetch_assoc($run);
		 $chkres = $output['cif'];
		 $query_own_chkk = "SELECT `nic` FROM `cifdetails` WHERE `cif`='$chkres'";
		 $run = mysqli_query($connect,$query_own_chkk);
		 $output = mysqli_fetch_assoc($run);
		 $chkress = $output['nic'];
		 $query_own_chkkk = "SELECT `userid` FROM `users` WHERE `nic`='$chkress'";
		 $run = mysqli_query($connect,$query_own_chkkk);
		 $output = mysqli_fetch_assoc($run);
		 $chkresss = $output['userid'];
		 
		 if($chkresss == $enterer){
			 $data['msg']=1;
		 }else{
			 $query_bal_chk = "SELECT `sol`, `balance`, `hold`, `status` FROM `caaccounts` WHERE `accountno`='$dr'";
			 $run = mysqli_query($connect,$query_bal_chk);
		     $output = mysqli_fetch_assoc($run);
		 	 $drcc = $output['sol'];
			 $drbal = $output['balance'];
			 $drho = $output['hold'];
			 $drst = $output['status'];
			 $drnetbal = $drbal - $drho;
			 
			if(($drst == 'Active' | $drst == 'CFreeze') & ($drnetbal  > $am | $drnetbal == $am)){
				 $query_tran = "SELECT MAX(tranid) AS tranid FROM `transactions` WHERE `date`='$time_style'";
				 $run = mysqli_query($connect,$query_tran);
				 $output = mysqli_fetch_assoc($run);
		 		 $tranid = $output['tranid'];
				 if($tranid == null){
					 $tranid = 1000;
				 }else{
					 $tranid = $tranid + rand(1,4);
				 }
				 
				 $drnewbal = $drbal - $am;
				 $query_entry_dr = "INSERT INTO `transactions` (sol,tranid,accountno,cc,date,credit,debit,amount,balance,remark,chqno,chqrem,entry,enterby,verifiedby,overby) VALUES ('$sol','$tranid','$dr','$drcc','$time_style','0.00','$am','$am','$drnewbal','$drr','','','$cr','$enterer','','NA')";
				 $query_balup_dr = "UPDATE `caaccounts` SET `balance`='$drnewbal' WHERE `accountno`='$dr'";
				 $drentryst = 'Y';
			 }else if(($drst == 'Active' | $drst == 'CFreeze') & ($drbal  > $am | $drbal == $am)){
				 $data['msg']=3;
			 }else if(($drst == 'Active' | $drst == 'CFreeze') & ($drbal < $am)){
				$data['msg']=3;
			}else{
				$data['status']=$drst;
				$data['msg']=4;
			}
		 }
    }else if($dr >300000000000 & $dr <600000000000){
		$data['msg'] = 50;
	}else if($dr >600000000000 & $dr <700000000000){
		$data['msg'] = 50;
	}else if($dr >700000000000 & $dr <800000000000){
		$data['msg'] = 50;
	}else{
        $data['msg'] = 50;
    }
	
	if($cr > 100000099 & $cr < 1000000000 & $data['msg'] == ""){
       $query_bal_chk = "SELECT `sol`, `balance`, `type` FROM `glaccounts` WHERE `accountno`='$cr'";
			 $run = mysqli_query($connect,$query_bal_chk);
		     $output = mysqli_fetch_assoc($run);
		 	 $crcc = $output['sol'];
			 $crbal = $output['balance'];
			 $crst = $output['type'];
			 
			if($drst == 0){
				 $crnewbal = $crbal + $am;
				 $query_entry_cr = "INSERT INTO `transactions` (sol,tranid,accountno,cc,date,credit,debit,amount,balance,remark,chqno,chqrem,entry,enterby,verifiedby,overby) VALUES ('$sol','$tranid','$cr','$crcc','$time_style','$am','0.00','$am','$crnewbal','$crr','','','$dr','$enterer','','NA')";
				 $query_balup_cr = "UPDATE `glaccounts` SET `balance`='$crnewbal' WHERE `accountno`='$cr'";
				 $crentryst = 'Y';
			 }else{
				$data['msg']=7;
			}
    }else if(($cr > 800000000000 & $cr < 1000000000000) & $data['msg'] == ""){
         $query_own_chk = "SELECT `cif` FROM `saaccounts` WHERE `accountno`='$cr'";
		 $run = mysqli_query($connect,$query_own_chk);
		 $output = mysqli_fetch_assoc($run);
		 $chkres = $output['cif'];
		 $query_own_chkk = "SELECT `nic` FROM `cifdetails` WHERE `cif`='$chkres'";
		 $run = mysqli_query($connect,$query_own_chkk);
		 $output = mysqli_fetch_assoc($run);
		 $chkress = $output['nic'];
		 $query_own_chkkk = "SELECT `userid` FROM `users` WHERE `nic`='$chkress'";
		 $run = mysqli_query($connect,$query_own_chkkk);
		 $output = mysqli_fetch_assoc($run);
		 $chkresss = $output['userid'];
		 
		 if($chkresss == $enterer){
			 $data['msg']=5;
		 }else{
			 $query_bal_chk = "SELECT `sol`, `balance`, `hold`, `status` FROM `saaccounts` WHERE `accountno`='$cr'";
			 $run = mysqli_query($connect,$query_bal_chk);
		     $output = mysqli_fetch_assoc($run);
		 	 $crcc = $output['sol'];
			 $crbal = $output['balance'];
			 $crho = $output['hold'];
			 $crst = $output['status'];
			 $crnetbal = $crbal - $crho;
			  
			 if($crst == 'Active' | $crst =='DFreeze'){
				 $crnewbal = $crbal + $am;
				 $query_entry_cr = "INSERT INTO `transactions` (sol,tranid,accountno,cc,date,credit,debit,amount,balance,remark,chqno,chqrem,entry,enterby,verifiedby,overby) VALUES ('$sol','$tranid','$cr','$crcc','$time_style','$am','0.00','$am','$crnewbal','$crr','','','$dr','$enterer','','NA')";
				 $query_balup_cr = "UPDATE `saaccounts` SET `balance`='$crnewbal' WHERE `accountno`='$cr'";
				 $crentryst = 'Y';
			 }else{
				 $data['status']=$crst;
				 $data['msg']=6;
			 }
		 }
    }else if($cr >100000000000 & $cr <300000000000 & $data['msg'] == ""){
       $query_own_chk = "SELECT `cif` FROM `caaccounts` WHERE `accountno`='$cr'";
		 $run = mysqli_query($connect,$query_own_chk);
		 $output = mysqli_fetch_assoc($run);
		 $chkres = $output['cif'];
		 $query_own_chkk = "SELECT `nic` FROM `cifdetails` WHERE `cif`='$chkres'";
		 $run = mysqli_query($connect,$query_own_chkk);
		 $output = mysqli_fetch_assoc($run);
		 $chkress = $output['nic'];
		 $query_own_chkkk = "SELECT `userid` FROM `users` WHERE `nic`='$chkress'";
		 $run = mysqli_query($connect,$query_own_chkkk);
		 $output = mysqli_fetch_assoc($run);
		 $chkresss = $output['userid'];
		 
		 if($chkresss == $enterer){
			 $data['msg']=5;
		 }else{
			 $query_bal_chk = "SELECT `sol`, `balance`, `hold`, `status` FROM `caaccounts` WHERE `accountno`='$cr'";
			 $run = mysqli_query($connect,$query_bal_chk);
		     $output = mysqli_fetch_assoc($run);
		 	 $crcc = $output['sol'];
			 $crbal = $output['balance'];
			 $crho = $output['hold'];
			 $crst = $output['status'];
			 $crnetbal = $crbal - $crho;
			  
			 if($crst == 'Active' | $crst =='DFreeze'){
				 $crnewbal = $crbal + $am;
				 $query_entry_cr = "INSERT INTO `transactions` (sol,tranid,accountno,cc,date,credit,debit,amount,balance,remark,chqno,chqrem,entry,enterby,verifiedby,overby) VALUES ('$sol','$tranid','$cr','$crcc','$time_style','$am','0.00','$am','$crnewbal','$crr','','','$dr','$enterer','','NA')";
				 $query_balup_cr = "UPDATE `caaccounts` SET `balance`='$crnewbal' WHERE `accountno`='$cr'";
				 $crentryst = 'Y';
			 }else{
				 $data['status']=$crst;
				 $data['msg']=6;
			 }
		 }
    }else if($cr >300000000000 & $cr <600000000000){
		$data['msg'] = 5;
	}else if($cr >600000000000 & $cr <700000000000){
		$data['msg'] = 50;
	}else if($cr >700000000000 & $cr <800000000000){
		$data['msg'] = 5;
	}else{}
    
	if($drentryst == 'Y' && $crentryst == 'Y'){
		mysqli_query($connect,$query_entry_dr);
		mysqli_query($connect,$query_balup_dr);
		mysqli_query($connect,$query_entry_cr);
		mysqli_query($connect,$query_balup_cr);
		$data['msg'] = 'Y';
		$data['tranid'] = $tranid;
	}else{}
	}else{
		$data['msg'] = 100;
	}
    echo json_encode($data);
}

function acfetch(){
    $accnum = $_POST['accnum'];
    $connect = mysqli_connect('localhost','root','','finacle');
    
    if($accnum > 100000099 & $accnum < 1000000000){
        $query_fetch_process = "SELECT `name`, `closeflg` FROM `glaccounts` WHERE `accountno`='$accnum'";
        $process = mysqli_query($connect,$query_fetch_process);
        $fetch = mysqli_fetch_assoc($process);
        $offacname = $fetch['name'];
        $cflg = $fetch['closeflg'];
        
        if($offacname == null){
            $data['msg'] = 5;
        }else if($cflg == 'Y'){
			$data['accname'] = $offacname;
            $data['msg'] = 3;
		}else{
            $data['msg'] = 1;
            $data['accname'] = $offacname;
        }
    }else if($accnum > 800000000000 & $accnum < 1000000000000){
       $query_fetch_process = "SELECT `cif`, `closeflg` FROM `saaccounts` WHERE `accountno`='$accnum'";
        $process = mysqli_query($connect,$query_fetch_process);
        $fetch = mysqli_fetch_assoc($process);
        $cif = $fetch['cif'];
        $cflg = $fetch['closeflg'];
        
        $query_fetchn_process = "SELECT `initialname` FROM `cifdetails` WHERE `cif`='$cif'";
            $processn = mysqli_query($connect,$query_fetchn_process);
            $fetchn = mysqli_fetch_assoc($processn);
        
        if($cflg == "N"){
            $data['accname'] = $fetchn['initialname'];
            $data['msg'] = 1;
        }else if($cflg == "Y"){
            $data['accname'] = $fetchn['initialname'];
            $data['msg'] = 3;
        }else{
            $data['msg'] = 5;
        }
    }else if($accnum >100000000000 & $accnum <300000000000){
       $query_fetch_process = "SELECT `cif`, `closeflg` FROM `caaccounts` WHERE `accountno`='$accnum'";
        $process = mysqli_query($connect,$query_fetch_process);
        $fetch = mysqli_fetch_assoc($process);
        $cif = $fetch['cif'];
        $cflg = $fetch['closeflg'];
        
        $query_fetchn_process = "SELECT `initialname` FROM `cifdetails` WHERE `cif`='$cif'";
            $processn = mysqli_query($connect,$query_fetchn_process);
            $fetchn = mysqli_fetch_assoc($processn);
        
        if($cflg == "N"){
            $data['accname'] = $fetchn['initialname'];
            $data['msg'] = 1;
        }else if($cflg == "Y"){
            $data['accname'] = $fetchn['initialname'];
            $data['msg'] = 3;
        }else{
            $data['msg'] = 5;
        }
    }else if($accnum >300000000000 & $accnum <600000000000){
		$data['msg'] = 5;
	}else if($accnum >600000000000 & $accnum <700000000000){
		$data['msg'] = 5;
	}else if($accnum >700000000000 & $accnum <800000000000){
		$data['msg'] = 5;
	}else{
        $data['msg'] = 5;
    }
    echo json_encode($data);
}

function fetchac(){
    $acnum = $_POST['acnum'];
    $daf   = $_POST['daf'];
    $dat   = $_POST['dat'];
    $amf   = $_POST['amf'];
    $amt   = $_POST['amt'];
    
    $connect = mysqli_connect('localhost','root','','finacle');
    $time = time();
    
    if(isset($acnum)&isset($daf)&isset($dat)&isset($amf)&isset($amt)){
        if($acnum > 800000000000 & $acnum < 1000000000000){
            
            $df = strtotime($daf);
            $dt = strtotime($dat);
            
            if((($df < $dt) || ($df == $dt)) & ($dt == $time || $dt < $time)){
                $query_details = "SELECT `cif`, `scheme`, `balance`, `hold`, `state`, `opendate`, `closedate` FROM `saaccounts` WHERE `accountno`='$acnum'";
            $qfetch = mysqli_query($connect,$query_details);
            $det = mysqli_fetch_assoc($qfetch);
                $data['scheme'] = $det['scheme'];
                $data['state'] = $det['state'];
                $data['pod'] = "0.00";
                $data['dbl'] = "0.00";
                $data['opendate'] = $det['opendate'];
                
                $check_date = strtotime($det['opendate']);
                
                if($df == $check_date || $df > $check_date || empty($daf)){
                if($det['closedate'] == 0000-00-00){
                    $data['closedate'] = "N";
                }else{
                    $data['closedate'] = $det['closedate'];
                }
                $data['hold'] = number_format($det['hold'],2);
                $cif = $det['cif'];
                $efb = number_format(($det['balance']-$det['hold']),2);
                $data['clb'] = number_format($det['balance'],2).' Cr';
            if($efb < 0 || $efb == 0){
                $data['efb'] = "0.00 Cr";
            }else{
                $data['efb'] = $efb.' Cr';
            }
                
                    if($df != $check_date & !empty($df)){
                $dafr = date('Y-m-d',strtotime($daf.'-1 day'));
                        $query_get_con = "SELECT `accountno` FROM `acfulldetails` WHERE `accountno`='$acnum'";
                        $get_con = mysqli_query($connect,$query_get_con);
                        $con = mysqli_fetch_assoc($get_con);
                        
                        if($con['accountno'] != null){
                $tran = "";
                while($check_date != strtotime($dafr) & $tran == "" ){
                    $openbl = "SELECT MAX(tran) AS tran FROM `acfulldetails` WHERE `accountno`='$acnum' AND `date`='$dafr'";
                    $opbl_run = mysqli_query($connect,$openbl);
                    $fet_opbl = mysqli_fetch_assoc($opbl_run);
                    if($fet_opbl['tran'] != null){
                        $tran = $fet_opbl['tran'];
                    }else{}
                    $dafr = date('Y-m-d',strtotime($dafr.'-1 day'));
                }
                    $dafr = date('Y-m-d',strtotime($dafr.'+1 day'));
                    $openbal_qur = "SELECT `balance` FROM `acfulldetails` WHERE `tran`='$tran' AND `date`='$dafr' AND `accountno`='$acnum'";
                $bal_ru = mysqli_query($connect,$openbal_qur);
                $o = mysqli_fetch_assoc($bal_ru);
                $data['opbaln'] = number_format($o['balance'],2).' Cr';
                 }else{
                            $data['opbaln'] = "0.00 Cr";
                        } 
                }else{
                    $data['opbaln'] = "0.00 Cr";
                    }
                    
                
                
                $query_nic = "SELECT `nic` FROM `cifdetails` WHERE `cif`='$cif'";
                $fe = mysqli_query($connect,$query_nic);
                $nic = mysqli_fetch_assoc($fe);
                $data['nic'] = $nic['nic'];
                
                if($amf == "" & $amt == ""){
                    $query_statement = "SELECT `date`,`tran`,`credit`,`debit`,`balance`,`remark` FROM `acfulldetails` WHERE `accountno`='$acnum' AND (`date` BETWEEN '$daf' AND '$dat') AND `amount` BETWEEN '0' AND '999999999'";
                }else if($amf != "" & $amt ==""){
                    $query_statement = "SELECT `date`,`tran`,`credit`,`debit`,`balance`,`remark` FROM `acfulldetails` WHERE `accountno`='$acnum' AND (`date` BETWEEN '$daf' AND '$dat') AND `amount` BETWEEN '$amf' AND '999999999'";
                }else if($amf == "" & $amt != ""){
                    $query_statement = "SELECT `date`,`tran`,`credit`,`debit`,`balance`,`remark` FROM `acfulldetails` WHERE `accountno`='$acnum' AND (`date` BETWEEN '$daf' AND '$dat') AND `amount` BETWEEN '0' AND '$amt'";
                }else{
                    $query_statement = "SELECT `date`,`tran`,`credit`,`debit`,`balance`,`remark` FROM `acfulldetails` WHERE `accountno`='$acnum' AND (`date` BETWEEN '$daf' AND '$dat') AND `amount` BETWEEN '$amf' AND '$amt'";
                }
                
                $run_statement = mysqli_query($connect,$query_statement);
                $rows = mysqli_num_rows($run_statement);
                
                if($rows > 0){
                    $i =1;
                    while($state = mysqli_fetch_assoc($run_statement)){
                        
                        if(number_format($state['credit'],2) == "0.00"){$state['credit'] = "";}else{$state['credit'] =number_format($state['credit'],2);}
                        if(number_format($state['debit'],2) == "0.00"){$state['debit'] = "";}else{$state['debit']=number_format($state['debit'],2);}
                        $data['tran'][$i] = $state['tran'];
                        $data['date'][$i] = $state['date'];
                        $data['credit'][$i] = $state['credit'];
                        $data['debit'][$i] = $state['debit'];
                        $data['balance'][$i] = number_format($state['balance'],2);
                        $data['remark'][$i] = $state['remark'];
                        $i++;
                    }
                    $data['max'] = $i;
                    $data['msg'] = 1;
                }else{
                $data['msg'] =3;    
                }}else{
                    $data['msg']=5;
                }
            }else{
                $data['msg'] =2;
            }
            
        }else if($acnum >1000000000 & $acnum <2000000000){
        
        }else if($acnum >2000000000 & $acnum <3000000000){
            
        }else if($acnum > 100000 & $acnum < 999999){
            $df = strtotime($daf);
            $dt = strtotime($dat);
            
            if((($df < $dt) || ($df == $dt)) & ($dt == $time || $dt < $time)){
                $query_details = "SELECT `name`, `balance`, `opendate` FROM `officeaccounts` WHERE `accountno`='$acnum'";
            $qfetch = mysqli_query($connect,$query_details);
            $det = mysqli_fetch_assoc($qfetch);
                $data['opendate'] = $det['opendate'];
                $data['state'] = "Active";
                $data['scheme'] = "Office";
                $data['pod'] = "N";
                $data['dbl'] = "N";
                $data['nic'] = "N";
                    
                $check_date = strtotime($det['opendate']);
                
                if($df == $check_date || $df > $check_date || empty($daf)){
                $data['closedate'] = "N";
                $data['hold'] = "N";
        
                $data['efb'] = number_format($det['balance'],2).' Dr';
                $data['clb'] = number_format($det['balance'],2).' Dr';
                
                    if($df != $check_date & !empty($df)){
                $dafr = date('Y-m-d',strtotime($daf.'-1 day'));
                        $query_get_con = "SELECT `accountno` FROM `acfulldetails` WHERE `accountno`='$acnum'";
                        $get_con = mysqli_query($connect,$query_get_con);
                        $con = mysqli_fetch_assoc($get_con);
                        if($con['accountno'] != null){
                 $tran =  "";
                while($check_date !=strtotime($dafr) & $tran == ""){
                    $openbl = "SELECT MAX(tran) AS tran FROM `acfulldetails` WHERE `accountno`='$acnum' AND `date`='$dafr'";
                    $opbl_run = mysqli_query($connect,$openbl);
                    $fet_opbl = mysqli_fetch_assoc($opbl_run);
                    if($fet_opbl['tran'] != null){
                        $tran = $fet_opbl['tran'];
                    }else{}
                    $dafr = date('Y-m-d',strtotime($dafr.'-1 day'));
                }
                    $dafr = date('Y-m-d',strtotime($dafr.'+1 day'));
                    $openbal_qur = "SELECT `balance` FROM `acfulldetails` WHERE `tran`='$tran' AND `date`='$dafr' AND `accountno`='$acnum'";
                $bal_ru = mysqli_query($connect,$openbal_qur);
                $o = mysqli_fetch_assoc($bal_ru);
                $data['opbaln'] = number_format($o['balance'],2).' Dr';
                    }else{
                            $data['opbaln'] = "0.00 Dr";
                        }
                }else{
                    $data['opbaln'] = "0.00 Dr";
                    }
                
                if($amf == "" & $amt == ""){
                    $query_statement = "SELECT `date`,`tran`,`credit`,`debit`,`balance`,`remark` FROM `acfulldetails` WHERE `accountno`='$acnum' AND (`date` BETWEEN '$daf' AND '$dat') AND `amount` BETWEEN '0' AND '999999999'";
                }else if($amf != "" & $amt ==""){
                    $query_statement = "SELECT `date`,`tran`,`credit`,`debit`,`balance`,`remark` FROM `acfulldetails` WHERE `accountno`='$acnum' AND (`date` BETWEEN '$daf' AND '$dat') AND `amount` BETWEEN '$amf' AND '999999999'";
                }else if($amf == "" & $amt != ""){
                    $query_statement = "SELECT `date`,`tran`,`credit`,`debit`,`balance`,`remark` FROM `acfulldetails` WHERE `accountno`='$acnum' AND (`date` BETWEEN '$daf' AND '$dat') AND `amount` BETWEEN '0' AND '$amt'";
                }else{
                    $query_statement = "SELECT `date`,`tran`,`credit`,`debit`,`balance`,`remark` FROM `acfulldetails` WHERE `accountno`='$acnum' AND (`date` BETWEEN '$daf' AND '$dat') AND `amount` BETWEEN '$amf' AND '$amt'";
                }
                
                $run_statement = mysqli_query($connect,$query_statement);
                $rows = mysqli_num_rows($run_statement);
                if($rows > 0){
                    $i =1;
                    while($state = mysqli_fetch_assoc($run_statement)){
                        
                        if(number_format($state['credit'],2) == "0.00"){$state['credit'] = "";}else{$state['credit'] =number_format($state['credit'],2);}
                        if(number_format($state['debit'],2) == "0.00"){$state['debit'] = "";}else{$state['debit']=number_format($state['debit'],2);}
                        $data['tran'][$i] = $state['tran'];
                        $data['date'][$i] = $state['date'];
                        $data['credit'][$i] = $state['credit'];
                        $data['debit'][$i] = $state['debit'];
                        $data['balance'][$i] = number_format($state['balance'],2);
                        $data['remark'][$i] = $state['remark'];
                        $i++;
                    }
                    $data['max'] = $i;
                    $data['msg'] = 1;
                }else{
                $data['msg'] =3;    
                }}else{
                    $data['msg']=5;
                }
            }else{
                $data['msg'] =2;
            }
        }
    }
    echo json_encode($data);
}

function cifcreation(){
    $cusdoc = $_POST['cusdoc'];
    $cusuid = $_POST['cusuid'];
    $cudtitle = $_POST['custitle'];
    $cusfname = $_POST['cusfname'];
    $cusininame = $_POST['cusininame'];
    $cusgen = $_POST['cusgen'];
    $cusdob = $_POST['cusdob'];
    $cuspadd = $_POST['cuspadd'];
    $cusphone = $_POST['cusphone'];
    $cusemail = $_POST['cusemail'];
    $cusocc = $_POST['cusocc'];
    $cifcrelang = $_POST['cifcrelang'];
	$acctype = $_POST['acctype'];
	$accone = $_COOKIE['accesstknon'];
	$acctwo = $_COOKIE['accesstkntw'];
	
	$connect = mysqli_connect('localhost','root','','finacle');
	
    $access = "SELECT `userid`, `tmsol` FROM `users` WHERE `accesstoken`='$accone' AND `accesstokensl`='$acctwo'";
    $run = mysqli_query($connect,$access);
    $output = mysqli_fetch_assoc($run);
    $user = $output['userid'];
	$tmsol = $output['tmsol'];
    
    $query_ciffetch = "SELECT MAX(cif) AS cif FROM `cifdetails`";
    $run = mysqli_query($connect,$query_ciffetch);
    $cifno = mysqli_fetch_assoc($run);
                $cif = $cifno['cif'];
                if($cif != null){
                	$cif = $cif + 1;
                }else{
                    $cif = 100000;
                }
	
    
    $query_fetch = "SELECT `cif`, `initialname` FROM `cifdetails` WHERE `nic`='$cusuid'";
    $runchk = mysqli_query($connect,$query_fetch);
    $cifnochk = mysqli_fetch_assoc($runchk);
                    $cifchk = $cifnochk['cif'];
					$cini = $cifnochk['initialname'];
	
                if($cifchk != null){
                    $qu_up = "UPDATE `users` SET `lastcif`='$cifchk' WHERE `userid`='$user'";
					mysqli_query($connect,$qu_up);
                }else{
        $query_cre = "INSERT INTO `cifdetails` (cif,sol,doc,nic,title,fullname,initialname,gender,dob,paddress,phoneno,email,occupation,lang,enterby) VALUES ('$cif','$tmsol','$cusdoc','$cusuid','$cudtitle','$cusfname','$cusininame','$cusgen','$cusdob','$cuspadd','$cusphone','$cusemail','$cusocc','$cifcrelang','$user')";
		mysqli_query($connect,$query_cre);
		$qu_up = "UPDATE `users` SET `lastcif`='$cif' WHERE `userid`='$user'";
		mysqli_query($connect,$qu_up);
    }
	
	$qu_up = "SELECT `cif` FROM `relmain` WHERE `user`='$user' AND `status`='Process'";
		$lciff = mysqli_query($connect,$qu_up);
        $rows = mysqli_num_rows($lciff);
                if($rows > 0){
                    $i =1;
                    while($ress = mysqli_fetch_assoc($lciff)){
                        $prob[$i] = $ress['cif'];
                        $i++;
						$m = $i;
                    } 
					
					$b = 1;
	$r = 1;
	while($r == 1 & $b < $m){
		if($prob[$b] == $cifchk){
			$excesting = 'y';
			$r = 2;
		}else{
			$excesting = 'n';
		}
		$b++;
	
	}
                }else{ 
					$excesting = '';
					$sole = 'yu';
                }
	
	
    
    if($acctype == "No"){
		
	
		if($excesting == 'n' & $cifchk != null){
			$qu_rel = "INSERT INTO `relmain` (user,cif,initialname,status) VALUES ('$user','$cifchk','$cini','Process')";
			mysqli_query($connect,$qu_rel);
			$data['msg'] = 1;
		}else if($excesting == 'y'){
			$data['cif'] = $cifchk;
			$data['msg'] = 4;
		}else if($excesting == 'n' & $cifchk == null){
			$qu_rel = "INSERT INTO `relmain` (user,cif,initialname,status) VALUES ('$user','$cif','$cusininame','Process')";
			mysqli_query($connect,$qu_rel);
			$data['cif'] = $cif;
			$data['msg'] = 1;
		}else{
			$data['msg'] = 1;
		}
		
	}else{
		
		if(($excesting == '' or $excesting == 'n') & $cifchk != null){
			$qu_rel = "INSERT INTO `relmain` (user,cif,initialname,status) VALUES ('$user','$cifchk','$cini','Process')";
			mysqli_query($connect,$qu_rel);
			$data['cif'] = $cifchk;
			$data['msg'] = 2;
		}else if($cifchk == null){
			$qu_rel = "INSERT INTO `relmain` (user,cif,initialname,status) VALUES ('$user','$cif','$cusininame','Process')";
			mysqli_query($connect,$qu_rel);
			$data['cif'] = $cif;
			$data['msg'] = 3;
		}else{
			$data['cif'] = $cifchk;
			$data['msg'] = 4;
		}
		
    }
    echo json_encode($data);
}

function mandatecancel(){
	$accone = $_COOKIE['accesstknon'];
	$acctwo = $_COOKIE['accesstkntw'];
	
	$connect = mysqli_connect('localhost','root','','finacle');
	
    $access = "SELECT `userid` FROM `users` WHERE `accesstoken`='$accone' AND `accesstokensl`='$acctwo'";
    $run = mysqli_query($connect,$access);
    $output = mysqli_fetch_assoc($run);
    $user = $output['userid'];
	
	$qu_getall = "SELECT `id` FROM `relmain` WHERE `user`='$user' AND `status`='Process'";
    $resrun = mysqli_query($connect,$qu_getall);
               $rows = mysqli_num_rows($resrun);
               
                if($rows != null){
                    $i =1;
                    while($res = mysqli_fetch_assoc($resrun)){
						$id = $res['id'];
                        $qu_pen_del = "DELETE FROM `relmain` WHERE `id`='$id'";
						mysqli_query($connect,$qu_pen_del);
                        $i++;
                    }
				}else{   
                }
	
	$qu_lcif = "UPDATE `users` SET `lastcif`='0' WHERE `userid`='$user'";
	mysqli_query($connect,$qu_lcif);
	$data['msg']=1;
	echo json_encode($data);
}

function accautcre(){
	$accone = $_COOKIE['accesstknon'];
	$acctwo = $_COOKIE['accesstkntw'];
	
	$connect = mysqli_connect('localhost','root','','finacle');
	
    $access = "SELECT `userid`, `tmsol`, `lastcif` FROM `users` WHERE `accesstoken`='$accone' AND `accesstokensl`='$acctwo'";
    $run = mysqli_query($connect,$access);
    $output = mysqli_fetch_assoc($run);
    $user = $output['userid'];
	$tmsol = $output['tmsol'];
    $lcif = $output['lastcif'];
	
	$qu_getall = "SELECT `cif`, `initialname` FROM `relmain` WHERE `user`='$user' AND `status`='Process'";
    $resrun = mysqli_query($connect,$qu_getall);
               $rows = mysqli_num_rows($resrun);
               
                if($rows > 0){
                    $i =1;
                    while($res = mysqli_fetch_assoc($resrun)){
                        $data['cif'][$i] = $res['cif'];
                        $data['initialname'][$i] = $res['initialname'];
                        $i++;
                    }
                    $data['max'] = $i;
					$data['msg'] =1;
				}else{
				$qu_sow = "SELECT `initialname` FROM `cifdetails` WHERE `cif`='$lcif'";
    			$qu_sop = mysqli_query($connect,$qu_sow);
				$output = mysqli_fetch_assoc($qu_sop);
				$data['initialname'] = $output['initialname'];
				$data['cif'] = $lcif;
                $data['msg'] = 2;    
                }
	echo json_encode($data);
}

function ciffetch(){
$id = $_POST['id'];
    
    $connect = mysqli_connect('localhost','root','','finacle');
    $query_fetch = "SELECT `cif`, `doc`, `title`, `fullname`, `initialname`, `dob`, `gender`, `lang`, `phoneno`, `email`, `paddress`, `occupation` FROM `cifdetails` WHERE `nic`='$id'";
    $run = mysqli_query($connect,$query_fetch);
    $rows = mysqli_num_rows($run);
                if($rows == 1){
                    $data['exist'] = 1;
                    $fetch = mysqli_fetch_assoc($run);
                    $data['cusdoc'] = $fetch['doc'];
                    $data['cif'] = $fetch['cif'];
                    $data['custitle'] = $fetch['title'];
                    $data['cusfname'] = $fetch['fullname'];
                    $data['cusininame'] = $fetch['initialname'];
                    $data['cusgen'] = $fetch['gender'];
                    $data['cusdob'] = $fetch['dob'];
                    $data['cusphone'] = $fetch['phoneno'];
                    $data['cusemail'] = $fetch['email'];
                    $data['cuspadd'] = $fetch['paddress'];
					$data['cusocc'] = $fetch['occupation'];
					$data['cifcrelang'] = $fetch['lang'];
                    $data['id'] = $id;
                }else{
                    $data['exist'] = 0;
                }
    echo json_encode($data);
}

function tellerchk(){
	$connect = mysqli_connect('localhost','root','','finacle');
	
	$token = $_COOKIE['accesstknon'];
    $sol = $_COOKIE['accesstkntw'];
	
    $access = "SELECT `userid`, `tmsol`, `tworkclass` FROM `users` WHERE `accesstoken`='$token' AND `accesstokensl`='$sol'";
    $run = mysqli_query($connect,$access);
    $output = mysqli_fetch_assoc($run);
    $enterer = $output['userid'];
	$sol = $output['tmsol'];
	$twc = $output['tworkclass'];
	
	$time = time();
	$time_style = date('Y-m-d',$time);
	
	$query_tmst	=	"SELECT `cash` FROM `branches` WHERE `sol`='$sol'";
	$query_chk = mysqli_query($connect,$query_tmst);
	$sta = mysqli_fetch_assoc($query_chk);
	$probres = $sta['cash'];
	
	if($probres == "Open"){
		$quryff = "SELECT `status`, `opm` FROM `tellerac` WHERE `acno`='$enterer'";
		$query_chka = mysqli_query($connect,$quryff);
		$staa = mysqli_fetch_assoc($query_chka);
		$proba = $staa['status'];
		$probb = $staa['opm'];
		
		if($proba == "Active" & $probb == "Open"){
			
		}else if($proba == "Active" & $probb == "Close"){
			$data['msg']=2;
		}else{
			$data['msg']=3;
		}
	}else{
		$data['msg']=1;
	}
    echo json_encode($data);
}

function acccrefinal(){
	$relcd = $_POST['relcd'];
	$cif = $_POST['cif'];
	$schm = $_POST['schm'];
	$subcate = $_POST['subcate'];
	$accone = $_COOKIE['accesstknon'];
	$acctwo = $_COOKIE['accesstkntw'];
	
	$connect = mysqli_connect('localhost','root','','finacle');
	
    $access = "SELECT `userid`, `tmsol`, `lastcif` FROM `users` WHERE `accesstoken`='$accone' AND `accesstokensl`='$acctwo'";
    $run = mysqli_query($connect,$access);
    $output = mysqli_fetch_assoc($run);
    $user = $output['userid'];
	$tmsol = $output['tmsol'];
	$lcif = $output['lastcif'];
    
	$time = time();
	$time_style = date('Y-m-d',$time);
	
	if($relcd != null & $cif == $lcif){

	if($schm == "SA00" | $schm == "SA10" | $schm == "SA20" |$schm == "SA30"){
		
		$query_ciffetch = "SELECT MAX(accountno) AS no FROM `saaccounts`";
    	$run = mysqli_query($connect,$query_ciffetch);
    	$cifno = mysqli_fetch_assoc($run);
                $no = $cifno['no'];
                if($no != null){
                	$no = $no + rand(1,3);
                }else{
                    $no = 800000000001;
                }
		if($schm == "SA00"){
			$query = "INSERT INTO `saaccounts` (cif,sol,accountno,balance,hold,scheme,intstatus,avgbal,intdue,intrate,chrgtype,wht,opm,status,closeflg,opendate,closedate,enterby) VALUES ('$cif','$tmsol','$no','0','0','$schm','1','0','0','3.5','$schm','Y','SOW','Active','N','$time_style','0000-00-00','$user')";
			mysqli_query($connect,$query);
			$data['acno']=$no;
			$data['msg']=1;			
		}else if($schm == "SA10" & $subcate == "SA11"){
			$query = "INSERT INTO `saaccounts` (cif,sol,accountno,balance,hold,scheme,intstatus,avgbal,intdue,intrate,chrgtype,wht,opm,status,closeflg,opendate,closedate,enterby) VALUES ('$cif','$tmsol','$no','0','0','$subcate','1','0','0','3.5','$subcate','Y','SOW','Active','N','$time_style','0000-00-00','$user')";
			mysqli_query($connect,$query);
			$data['acno']=$no;
			$data['msg']=1;
		}else if($schm == "SA10" & $subcate == "SA12"){
			$query = "INSERT INTO `saaccounts` (cif,sol,accountno,balance,hold,scheme,intstatus,avgbal,intdue,intrate,chrgtype,wht,opm,status,closeflg,opendate,closedate,enterby) VALUES ('$cif','$tmsol','$no','0','0','$subcate','1','0','0','5.0','$subcate','Y','SOW','Active','N','$time_style','0000-00-00','$user')";
			mysqli_query($connect,$query);
			$data['acno']=$no;
			$data['msg']=1;
		}else if($schm == "SA10" & $subcate == "SA13"){
			$query = "INSERT INTO `saaccounts` (cif,sol,accountno,balance,hold,scheme,intstatus,avgbal,intdue,intrate,chrgtype,wht,opm,status,closeflg,opendate,closedate,enterby) VALUES ('$cif','$tmsol','$no','0','0','$subcate','1','0','0','5.0','$subcate','Y','SOW','Active','N','$time_style','0000-00-00','$user')";
			mysqli_query($connect,$query);
			$data['acno']=$no;
			$data['msg']=1;
		}else if($schm == "SA10" & $subcate == "SA16"){
			$query = "INSERT INTO `saaccounts` (cif,sol,accountno,balance,hold,scheme,intstatus,avgbal,intdue,intrate,chrgtype,wht,opm,status,closeflg,opendate,closedate,enterby) VALUES ('$cif','$tmsol','$no','0','0','$subcate','1','0','0','3.5','$subcate','Y','SOW','Active','N','$time_style','0000-00-00','$user')";
			mysqli_query($connect,$query);
			$data['acno']=$no;
			$data['msg']=1;
		}else if($schm == "SA10" & $subcate == "SA17"){
			$query = "INSERT INTO `saaccounts` (cif,sol,accountno,balance,hold,scheme,intstatus,avgbal,intdue,intrate,chrgtype,wht,opm,status,closeflg,opendate,closedate,enterby) VALUES ('$cif','$tmsol','$no','0','0','$subcate','1','0','0','4.5','$subcate','Y','SOW','Active','N','$time_style','0000-00-00','$user')";
			mysqli_query($connect,$query);
			$data['acno']=$no;
			$data['msg']=1;
		}
		
		
	}else if($schm == 'CA00'){
		$data['msg']=1;
	}else if($schm == 'CA10'){
		$data['msg']=1;
	}else if($schm == 'CA20'){
		$data['msg']=1;
	}else if($schm == 'CA30'){
		$data['msg']=1;
	}else if($schm == 'FD00'){
		$data['msg']=1;
	}
		
		
	}else{
		
	}
    echo json_encode($data);
}

function bropen(){
    $nbrname = $_POST['brname'];
    $connect = mysqli_connect('localhost','root','','finacle');
    
    $chk_ex = "SELECT `branch` FROM `branches` WHERE `branch`='$nbrname'";
    $chk_ex_run = mysqli_query($connect,$chk_ex);
    $chk = mysqli_fetch_assoc($chk_ex_run);
    
    if($chk['branch'] == null){
        
    $query = "SELECT MAX(sol) AS sol FROM `branches`";
    $query_run = mysqli_query($connect,$query);
    $quert_fetch = mysqli_fetch_assoc($query_run);
            
    if($quert_fetch['sol'] != null){
        $lastsol = $quert_fetch['sol'];
        $nbrsol = $lastsol + 1;
    }else{
        $nbrsol = 100;
    }
    
    $open_query = "INSERT INTO `branches` (branch,sol,cash,tfr) VALUES ('$nbrname','$nbrsol','Close','Close')";
    mysqli_query($connect,$open_query);
    
    $time = time();
    $time_style = date('Y-m-d',$time);
    
    $officeacc = array('Vault','Drop Safe','Sudry Income','Sundry Losses','Int Payable','Chrg Income','Int Income','Teller 1','Teller 2','Teller 3');
    $officeaccno = array(10,12,1020,1030,801030,801010,801020,75,76,77);
    
    $i= 0;
    while($i < 10){
        $accnum = 9000000000 + ($nbrsol*1000000) + $officeaccno[$i];
        $accnam = $officeacc[$i];
        $query_opofac = "INSERT INTO `officeaccounts` (sol,name,accountno,balance,opendate) VALUES ('$nbrsol','$accnam','$accnum','0','$time_style')";
        mysqli_query($connect,$query_opofac);
        
        $i++;
    }
    
    $data['brname'] = $nbrname;
    $data['sol'] = $nbrsol;
    $data['msg'] = 1;
    }else{
        $data['msg'] = 0;
    }
    echo json_encode($data);
}

function optf(){
	$connect = mysqli_connect('localhost','root','','finacle');
	
	$token = $_COOKIE['accesstknon'];
    $sol = $_COOKIE['accesstkntw'];
	
    $access = "SELECT `userid`, `tmsol`, `tworkclass` FROM `users` WHERE `accesstoken`='$token' AND `accesstokensl`='$sol'";
    $run = mysqli_query($connect,$access);
    $output = mysqli_fetch_assoc($run);
    $enterer = $output['userid'];

	$query_tmst	=	"SELECT `status`, `opm` FROM `tellerac` WHERE `acno`='$enterer'";
	$query_chk = mysqli_query($connect,$query_tmst);
	$sta = mysqli_fetch_assoc($query_chk);
	$res = $sta['opm'];
	$restw = $sta['status'];
	
	if($res == "Close" & $restw == "Active"){
		$qury = "UPDATE `tellerac` SET `opm`='Open' WHERE `acno`='$enterer'";
		mysqli_query($connect,$qury);
		$data['msg']=1;
	}else if($restw == "Active" & $res == "Open"){
		$data['msg']=2;
	}else{
		$data['msg']=3;
	}
	echo json_encode($data);
}

function cshbalf(){
	$connect = mysqli_connect('localhost','root','','finacle');
	
	$token = $_COOKIE['accesstknon'];
    $sol = $_COOKIE['accesstkntw'];
	
    $access = "SELECT `userid`, `tmsol`, `tworkclass` FROM `users` WHERE `accesstoken`='$token' AND `accesstokensl`='$sol'";
    $run = mysqli_query($connect,$access);
    $output = mysqli_fetch_assoc($run);
    $enterer = $output['userid'];

	$query_tmst	=	"SELECT `status`, `balance`, `5000`, `2000`, `1000`, `500`, `100`, `50`, `20`, `10`, `5`, `2`, `1`, `cents`, `muti`, `total` FROM `tellerac` WHERE `acno`='$enterer'";
	$query_chk = mysqli_query($connect,$query_tmst);
	$sta = mysqli_fetch_assoc($query_chk);
	$res = $sta['status'];
	
	if($res == "Inactive"){
		$data['msg']=2;
	}else{
		$data['balance']=$sta['balance'];
		$data['ft']=$sta['5000'];
		$data['tt']=$sta['2000'];
		$data['ot']=$sta['1000'];
		$data['fh']=$sta['500'];
		$data['oh']=$sta['100'];
		$data['f']=$sta['50'];
		$data['t']=$sta['20'];
		$data['ten']=$sta['10'];
		$data['five']=$sta['5'];
		$data['two']=$sta['2'];
		$data['one']=$sta['1'];
		$data['cents']=$sta['cents'];
		$data['muti']=$sta['muti'];
		$data['total']=$sta['total'];
		$data['dif']=$sta['total']-$sta['balance'];
		$data['msg']=1;
	}
		echo json_encode($data);
}

function cshbalup(){
	    $a = $_POST['a']; 
		$b = $_POST['b'];
		$c = $_POST['c'];
		$d = $_POST['d'];
		$e = $_POST['e'];
		$f = $_POST['f'];
		$g = $_POST['g'];
		$h = $_POST['h'];
		$i = $_POST['i'];
		$j = $_POST['j'];
		$k = $_POST['k'];
		$l = $_POST['l'];
		$muti = $_POST['muti'];
		$total = $_POST['total'];
			
	$connect = mysqli_connect('localhost','root','','finacle');
	
	$token = $_COOKIE['accesstknon'];
    $sol = $_COOKIE['accesstkntw'];
	
    $access = "SELECT `userid`, `tmsol`, `tworkclass` FROM `users` WHERE `accesstoken`='$token' AND `accesstokensl`='$sol'";
    $run = mysqli_query($connect,$access);
    $output = mysqli_fetch_assoc($run);
    $enterer = $output['userid'];
	
	$qury = "UPDATE `tellerac` SET `5000`='$a', `2000`='$b', `1000`='$c', `500`='$d', `100`='$e', `50`='$f', `20`='$g', `10`='$h', `5`='$i', `2`='$j', `1`='$k', `cents`='$l', `muti`='$muti', `total`='$total' WHERE `acno`='$enterer'";
	mysqli_query($connect,$qury);
	$data['msg']=1;
	echo json_encode($data);
}

function tellerpost(){
	$fun = $_POST['fun'];
	$acno = $_POST['acno'];
	$tram = $_POST['tram'];
	$am = $_POST['am'];
	$chqno = $_POST['chqno'];
	
	$connect = mysqli_connect('localhost','root','','finacle');
	
	$token = $_COOKIE['accesstknon'];
    $sol = $_COOKIE['accesstkntw'];
	
    $access = "SELECT `userid`, `tmsol` FROM `users` WHERE `accesstoken`='$token' AND `accesstokensl`='$sol'";
    $run = mysqli_query($connect,$access);
    $output = mysqli_fetch_assoc($run);
    $enterer = $output['userid'];
	$sol = $output['tmsol'];
	
	$time = time();
	$time_style = date('Y-m-d',$time);
	
	$query_tran = "SELECT MAX(tranid) AS tranid FROM `transactions` WHERE `date`='$time_style'";
				 $run = mysqli_query($connect,$query_tran);
				 $output = mysqli_fetch_assoc($run);
		 		 $tranid = $output['tranid'];
				 if($tranid == null){
					 $tranid = 1000;
				 }else{
					 $tranid = $tranid + rand(1,4);
				 }
	
	if($fun == 'deposit'){
		if($acno > 100000099 & $acno < 1000000000){
       $query_bal_chk = "SELECT `sol`, `balance`, `type` FROM `glaccounts` WHERE `accountno`='$acno'";
			 $run = mysqli_query($connect,$query_bal_chk);
		     $output = mysqli_fetch_assoc($run);
		 	 $acnocc = $output['sol'];
			 $acnobal = $output['balance'];
			 $acnost = $output['type'];
			 
			if($acnost == 0){
				 $acnonewbal = $acnobal + $tram;
				 $query_entry_cr = "INSERT INTO `transactions` (sol,tranid,accountno,cc,date,credit,debit,amount,balance,remark,chqno,chqrem,entry,enterby,verifiedby,overby) VALUES ('$sol','$tranid','$acno','$acnocc','$time_style','$tram','0.00','$tram','$acnonewbal','Cash Deposit','','','$enterer','$enterer','','NA')";
				 $query_balup_cr = "UPDATE `glaccounts` SET `balance`='$acnonewbal' WHERE `accountno`='$acno'";
				 $crentryst = 'Y';
			 }else{
				$crentryst = 'N';
				$data['msg']=1;
			}
    }else if(($acno > 800000000000 & $acno < 1000000000000)){
         $query_own_chk = "SELECT `cif` FROM `saaccounts` WHERE `accountno`='$acno'";
		 $run = mysqli_query($connect,$query_own_chk);
		 $output = mysqli_fetch_assoc($run);
		 $chkres = $output['cif'];
		 $query_own_chkk = "SELECT `nic` FROM `cifdetails` WHERE `cif`='$chkres'";
		 $run = mysqli_query($connect,$query_own_chkk);
		 $output = mysqli_fetch_assoc($run);
		 $chkress = $output['nic'];
		 $query_own_chkkk = "SELECT `userid` FROM `users` WHERE `nic`='$chkress'";
		 $run = mysqli_query($connect,$query_own_chkkk);
		 $output = mysqli_fetch_assoc($run);
		 $chkresss = $output['userid'];
		 
		 if($chkresss == $enterer){
			 $crentryst = 'N';
			 $data['msg']=2;
		 }else{
			 $query_bal_chk = "SELECT `sol`, `balance`, `hold`, `status` FROM `saaccounts` WHERE `accountno`='$acno'";
			 $run = mysqli_query($connect,$query_bal_chk);
		     $output = mysqli_fetch_assoc($run);
		 	 $acnocc = $output['sol'];
			 $acnobal = $output['balance'];
			 $acnost = $output['status'];
			  
			 if($acnost == 'Active' | $acnost =='DFreeze'){
				 $acnonewbal = $acnobal + $tram;
				 $query_entry_cr = "INSERT INTO `transactions` (sol,tranid,accountno,cc,date,credit,debit,amount,balance,remark,chqno,chqrem,entry,enterby,verifiedby,overby) VALUES ('$sol','$tranid','$acno','$acnocc','$time_style','$tram','0.00','$tram','$acnonewbal','Cash Deposit','','','$enterer','$enterer','','NA')";
				 $query_balup_cr = "UPDATE `saaccounts` SET `balance`='$acnonewbal' WHERE `accountno`='$acno'";
				 $crentryst = 'Y';
			 }else{
				 $data['status']=$acnost;
				 $crentryst = 'N';
				 $data['msg']=3;
			 }
		 }
    }else if($acno >100000000000 & $acno <300000000000){
       $query_own_chk = "SELECT `cif` FROM `caaccounts` WHERE `accountno`='$acno'";
		 $run = mysqli_query($connect,$query_own_chk);
		 $output = mysqli_fetch_assoc($run);
		 $chkres = $output['cif'];
		 $query_own_chkk = "SELECT `nic` FROM `cifdetails` WHERE `cif`='$chkres'";
		 $run = mysqli_query($connect,$query_own_chkk);
		 $output = mysqli_fetch_assoc($run);
		 $chkress = $output['nic'];
		 $query_own_chkkk = "SELECT `userid` FROM `users` WHERE `nic`='$chkress'";
		 $run = mysqli_query($connect,$query_own_chkkk);
		 $output = mysqli_fetch_assoc($run);
		 $chkresss = $output['userid'];
		 
		 if($chkresss == $enterer){
			 $crentryst = 'N';
			 $data['msg']=2;
		 }else{
			 $query_bal_chk = "SELECT `sol`, `balance`, `hold`, `status` FROM `caaccounts` WHERE `accountno`='$acno'";
			 $run = mysqli_query($connect,$query_bal_chk);
		     $output = mysqli_fetch_assoc($run);
		 	 $acnocc = $output['sol'];
			 $acnobal = $output['balance'];
			 $acnost = $output['status'];
			  
			 if($acnost == 'Active' | $acnost =='DFreeze'){
				 $acnonewbal = $acnobal + $tram;
				 $query_entry_cr = "INSERT INTO `transactions` (sol,tranid,accountno,cc,date,credit,debit,amount,balance,remark,chqno,chqrem,entry,enterby,verifiedby,overby) VALUES ('$sol','$tranid','$acno','$acnocc','$time_style','$tram','0.00','$tram','$acnonewbal','Cash Deposit','','','$enterer','$enterer','','NA')";
				 $query_balup_cr = "UPDATE `caaccounts` SET `balance`='$acnonewbal' WHERE `accountno`='$acno'";
				 $crentryst = 'Y';
			 }else{
				 $crentryst = 'N';
				 $data['status']=$acnost;
				 $data['msg']=3;
			 }
		 }
    }else if($acno >300000000000 & $acno <600000000000){
		$data['msg'] = 50;
	}else if($acno >600000000000 & $acno <700000000000){
		$data['msg'] = 50;
	}else if($acno >700000000000 & $acno <800000000000){
		$data['msg'] = 50;
	}else{}
					
		if($crentryst == 'Y'){
		$query_tmst	=	"SELECT `balance` FROM `tellerac` WHERE `acno`='$enterer'";
		$query_chk = mysqli_query($connect,$query_tmst);
		$sta = mysqli_fetch_assoc($query_chk);
		$tacbal = $sta['balance'];
		
		$newtacbal = $tacbal + $tram;
		$query_entry_dr = "INSERT INTO `transactions` (sol,tranid,accountno,cc,date,credit,debit,amount,balance,remark,chqno,chqrem,entry,enterby,verifiedby,overby) VALUES ('$sol','$tranid','$enterer','$sol','$time_style','0.00','$tram','$tram','$newtacbal','Cash Deposit','','','$acno','$enterer','','NA')";
		
		$query_balup_dr = "UPDATE `tellerac` SET `balance`='$newtacbal' WHERE `acno`='$enterer'";
			
		mysqli_query($connect,$query_entry_dr);
		mysqli_query($connect,$query_balup_dr);
		mysqli_query($connect,$query_entry_cr);
		mysqli_query($connect,$query_balup_cr);
		$data['msg'] = 'Y';
		$data['tranid'] = $tranid;
	}else{}
		
	}else if($fun == 'withdraw'){
		if($acno > 100000099 & $acno < 1000000000){
			 $query_bal_chk = "SELECT `sol`, `balance`, `type` FROM `glaccounts` WHERE `accountno`='$acno'";
			 $run = mysqli_query($connect,$query_bal_chk);
		     $output = mysqli_fetch_assoc($run);
		 	 $acnocc = $output['sol'];
			 $acnobal = $output['balance'];
			 $acnost = $output['type'];
			 
			if($acnost == 0){			 
				 $acnonewbal = $acnobal - $tram;
				 $query_entry_dr = "INSERT INTO `transactions` (sol,tranid,accountno,cc,date,credit,debit,amount,balance,remark,chqno,chqrem,entry,enterby,verifiedby,overby) VALUES ('$sol','$tranid','$acno','$acnocc','$time_style','0.00','$tram','$tram','$acnonewbal','Cash Withdrawal','','','$enterer','$enterer','','NA')";
				 $query_balup_dr = "UPDATE `glaccounts` SET `balance`='$acnonewbal' WHERE `accountno`='$acno'";
				 $drentryst = 'Y';
			 }else{
				$drentryst = 'N';
				$data['msg']=1;
			}
		 
    }else if($acno > 800000000000 & $acno < 1000000000000){
         $query_own_chk = "SELECT `cif` FROM `saaccounts` WHERE `accountno`='$acno'";
		 $run = mysqli_query($connect,$query_own_chk);
		 $output = mysqli_fetch_assoc($run);
		 $chkres = $output['cif'];
		 $query_own_chkk = "SELECT `nic` FROM `cifdetails` WHERE `cif`='$chkres'";
		 $run = mysqli_query($connect,$query_own_chkk);
		 $output = mysqli_fetch_assoc($run);
		 $chkress = $output['nic'];
		 $query_own_chkkk = "SELECT `userid` FROM `users` WHERE `nic`='$chkress'";
		 $run = mysqli_query($connect,$query_own_chkkk);
		 $output = mysqli_fetch_assoc($run);
		 $chkresss = $output['userid'];
		 
		 if($chkresss == $enterer){
			 $drentryst = 'N';
			 $data['msg']=2;
		 }else{
			 $query_bal_chk = "SELECT `sol`, `balance`, `hold`, `status` FROM `saaccounts` WHERE `accountno`='$acno'";
			 $run = mysqli_query($connect,$query_bal_chk);
		     $output = mysqli_fetch_assoc($run);
		 	 $acnocc = $output['sol'];
			 $acnobal = $output['balance'];
			 $acnoho = $output['hold'];
			 $acnost = $output['status'];
			 $acnonetbal = $acnobal - $acnoho;
			 
			if(($acnost == 'Active' | $acnost == 'CFreeze') & ($acnonetbal  > $tram | $acnonetbal == $tram)){
				 $acnonewbal = $acnobal - $tram;
				 $query_entry_dr = "INSERT INTO `transactions` (sol,tranid,accountno,cc,date,credit,debit,amount,balance,remark,chqno,chqrem,entry,enterby,verifiedby,overby) VALUES ('$sol','$tranid','$acno','$acnocc','$time_style','0.00','$tram','$tram','$acnonewbal','Cash Withdrawal','','','$enterer','$enterer','','NA')";
				 $query_balup_dr = "UPDATE `saaccounts` SET `balance`='$acnonewbal' WHERE `accountno`='$acno'";
				 $drentryst = 'Y';
			 }else if(($acnost == 'Active' | $acnost == 'CFreeze') & ($acnobal  > $tram | $acnobal == $tram)){
				 $drentryst = 'N';
				 $data['msg']=11;
			 }else if(($acnost == 'Active' | $acnost == 'CFreeze') & ($acnobal < $tram)){
				$drentryst = 'N';
				$data['msg']=30;
			}else{
				$drentryst = 'N';
				$data['status']=$acnost;
				$data['msg']=4;
			}
		 }
    }else if($acno >100000000000 & $acno <300000000000){
		 $query_own_chk = "SELECT `cif` FROM `caaccounts` WHERE `accountno`='$acno'";
		 $run = mysqli_query($connect,$query_own_chk);
		 $output = mysqli_fetch_assoc($run);
		 $chkres = $output['cif'];
		 $query_own_chkk = "SELECT `nic` FROM `cifdetails` WHERE `cif`='$chkres'";
		 $run = mysqli_query($connect,$query_own_chkk);
		 $output = mysqli_fetch_assoc($run);
		 $chkress = $output['nic'];
		 $query_own_chkkk = "SELECT `userid` FROM `users` WHERE `nic`='$chkress'";
		 $run = mysqli_query($connect,$query_own_chkkk);
		 $output = mysqli_fetch_assoc($run);
		 $chkresss = $output['userid'];
		 
		 if($chkresss == $enterer){
			 $crentryst = 'N';
			 $data['msg']=2;
		 }else{
			 $query_bal_chk = "SELECT `sol`, `balance`, `hold`, `status` FROM `caaccounts` WHERE `accountno`='$acno'";
			 $run = mysqli_query($connect,$query_bal_chk);
		     $output = mysqli_fetch_assoc($run);
		 	 $acnocc = $output['sol'];
			 $acnobal = $output['balance'];
			 $acnoho = $output['hold'];
			 $acnost = $output['status'];
			 $acnonetbal = $acnobal - $acnoho;
			 
			if(($acnost == 'Active' | $acnost == 'CFreeze') & ($acnonetbal  > $tram | $acnonetbal == $tram)){
				 $acnonewbal = $acnobal - $tram;
				 $query_entry_dr = "INSERT INTO `transactions` (sol,tranid,accountno,cc,date,credit,debit,amount,balance,remark,chqno,chqrem,entry,enterby,verifiedby,overby) VALUES ('$sol','$tranid','$acno','$acnocc','$time_style','0.00','$tram','$tram','$acnonewbal','Cash Withdrawal','','','$enterer','$enterer','','NA')";
				 $query_balup_dr = "UPDATE `caaccounts` SET `balance`='$acnonewbal' WHERE `accountno`='$acno'";
				 $drentryst = 'Y';
			 }else if(($acnost == 'Active' | $acnost == 'CFreeze') & ($acnobal  > $tram | $acnobal == $tram)){
				$drentryst = 'N';
				 $data['msg']=30;
			 }else if(($acnost == 'Active' | $acnost == 'CFreeze') & ($acnobal < $tram)){
				$drentryst = 'N';
				$data['msg']=30;
			}else{
				$drentryst = 'N';
				$data['status']=$acnost;
				$data['msg']=4;
			}
		 }
    }else if($dr >300000000000 & $dr <600000000000){
		$data['msg'] = 50;
	}else if($dr >600000000000 & $dr <700000000000){
		$data['msg'] = 50;
	}else if($dr >700000000000 & $dr <800000000000){
		$data['msg'] = 50;
	}else{}
		if($drentryst == 'Y'){
		$query_tmst	=	"SELECT `balance` FROM `tellerac` WHERE `acno`='$enterer'";
		$query_chk = mysqli_query($connect,$query_tmst);
		$sta = mysqli_fetch_assoc($query_chk);
		$tacbal = $sta['balance'];
		
		$newtacbal = $tacbal -$tram;
		$query_entry_cr = "INSERT INTO `transactions` (sol,tranid,accountno,cc,date,credit,debit,amount,balance,remark,chqno,chqrem,entry,enterby,verifiedby,overby) VALUES ('$sol','$tranid','$enterer','$sol','$time_style','$tram','0.00','$tram','$newtacbal','Cash Withdrawal','','','$acno','$enterer','','NA')";
		
		$query_balup_cr = "UPDATE `tellerac` SET `balance`='$newtacbal' WHERE `acno`='$enterer'";
			
		mysqli_query($connect,$query_entry_dr);
		mysqli_query($connect,$query_balup_dr);
		mysqli_query($connect,$query_entry_cr);
		mysqli_query($connect,$query_balup_cr);
		$data['msg'] = 'Y';
		$data['tranid'] = $tranid;
	}else{}
	}else{}
	
	echo json_encode($data);
}

$_POST['routine']();

?>