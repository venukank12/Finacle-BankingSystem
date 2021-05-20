$(function(){
    function timerunner(){
        setInterval(function(){
            var tim = new Date();
            $("#clock").text(tim);
			var flgout = sessionStorage.getItem('lasttimestamp');
			contacting(flgout);
        },300);
    }
    
    function contacting(flgout){
		var currenttime = new Date();
        var pasttime = new Date(flgout);
        var minpast = ((currenttime.getTime() - pasttime.getTime())/1000);
		
        var routine = "getcoo";
    $.ajax({
            url:"functions.php",
            method:"POST",
            data:{routine:routine,minpast:minpast},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 1){
                    alert('Error, You Have Threw Out From Finacle Core Banking System!!');
                    window.location.replace('index.php');
					window.location.replace('index.php');
					window.location.replace('index.php');
					sessionStorage.removeItem('lasttimestamp');
                }else if(data.msg == 6){
					alert('You Have Received Override!!');
					$("#mainsysscrdisp").toggle();
					$("#usrmsgviewscr").toggle();
					$("#overdrno").text(data.dracno);
					$("#overcrno").text(data.cracno);
					$("#overdrname").text(data.dracname);
					$("#overcrname").text(data.cracname);
					$("#overamount").text(data.amount);
					$("#overdrrem").text(data.debitref);
					$("#overcrrem").text(data.creditref);
					$("#overres").text(data.reason);
					$("#frmusr").text(data.senter);
                }else if(data.msg == 3){
					alert('Finacle Core Banking System will be Closed Automatically For Day End within 10 Minutes!!!');
				}else if(data.msg == 4){
					alert('You Have Automaticaly Loged Out Sucessfully For Day End!!');
					window.location.replace('index.php');
					window.location.replace('index.php');
					window.location.replace('index.php');
					sessionStorage.removeItem('lasttimestamp');
				}else if(data.msg == 5){
					sessionStorage.removeItem('lasttimestamp');
					alert('Time Out, You Have Sucessfully Logged Out!!');
					window.location.replace('index.php');
					window.location.replace('index.php');
					window.location.replace('index.php');
				}else if(data.msg == 2){
					alert('SUBJECT : '+data.subject+'    FROM USER : '+data.frmuser);
				}else if(data.msg == 7){
					alert('Your Override has been Declined by '+data.frmuser);
				}else{}
            }
    });
    }
    
   
     timerunner();
});

function acfetch(){
           var accnum = $("#accnum").val();
           var routine = "acfetch";
    $.ajax({
            url:"functions.php",
            method:"POST",
            data:{routine:routine,accnum:accnum},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 1){
                    $("#accname").text(data.accname);
                }else if(data.msg == 2){
                    $("#accname").text(data.accname);
                    alert('Account Has Been Closed!!!');
                }else{
                    alert('You Entered Invalid Account!!!');
                    $("#accname").text('');
                }
            } 
    });
	return;
}

 $(document).mousemove(function(){
        var timestamp = new Date();
        var runok = sessionStorage.getItem('lasttimestamp');
        if(runok != null){
        sessionStorage.setItem('lasttimestamp',timestamp);
        }else{}
    });

$("#lgsubmit").click(function(){
    var user = $("#lguser").val();
    var pass = $("#lgpass").val();
	
    if(user != '' & pass != ''){
        var routine = "lgin";
        $.ajax({
            url:"functions.php",
            method:"POST",
            data:{user:user,pass:pass,routine:routine},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 0 & data.user == user & data.sol != null){
                    alert("Welcome To Rapple Core Banking System");
					alert("You are Entering into LIVE System!!!");
                    $("#mainsysscr").empty();
					$("#mainsysscr").append("<p style='font-size: 50PX; margin:0px;' align='center'>RAPPLE CORE BANKING SOLUTIONS</p><p style='font-size: 20px; margin:10px; color:Red;' align='center' id='clock'></p>");
                $("#mainsysscr").append("<table align='center' style='font-size: 20PX;'><tr><td>MENU :<input style='text-transform: uppercase' type='text' id='menu'/><input type='submit' id='go' value='GO!'/></td><td style='width:250px;'></td><td>SOL :<lable id='sol'></lable> USER :<lable id='user'></lable></td><td><input type='submit' value='LOG OUT' id='logout'/></td></tr></table>");
                $("#mainsysscr").append('<script type="text/javascript" src="script.js"></script><iframe id="mainsysscrdisp" width="100%" height="75%" src="fincoreoptscrview.php"/><table id="usrmsgviewscr" style="margin-left:400px; margin-top:100px;" hidden="hidden"><tr><td>Type</td><td>Debit</td><td>Type</td><td>Credit</td></tr><tr><td>Account No</td><td><lable id="overdrno"></lable></td><td>Account No</td><td><lable id="overcrno"></lable></td></tr><tr><td>Name</td><td><lable id="overdrname"></lable></td><td>Name</td><td><lable id="overcrname"></lable></td></tr><tr><td>Amount</td><td><lable id="overamount"></lable></td></tr><tr><td>Remarks</td><td><lable id="overdrrem"></lable></td><td>Remarks</td><td><lable id="overcrrem"/></td></tr><tr><td>Reason</td><td><lable id="overres"></lable></td></tr><tr><td>User</td><td><lable id="frmusr"></lable></td><tr><td>Password</td><td><input type="text" id="overpasscon"/></td></tr></tr><tr><td><input type="submit" id="acceover" value="Review"/> <input type="submit" id="rejover" value="Declined"/></td></tr></table><script type="text/javascript" src="code.js"></script>');
               	$("#user").text(data.user);
                $("#sol").text(data.sol);	
				var timestamp = new Date();
    			sessionStorage.setItem('lasttimestamp',timestamp);
                }else if(data.msg == 1 && data.status == 1){
                    alert('Your User Blocked Please Active!');
                }else if(data.msg == 1){
                    alert('Please Give Correct User and Password!');
                }else if(data.msg == 2){
                    alert('You already Logged In Rapple!');     
                }else if(data.msg == 101){
					alert('Another User Logged In Or Properly Not Logged Out!!');
				}else if(data.msg == 1001){
					alert('Finacle Core banking System Closed for Day End and Has Not Open Yet');
				}
            }
        });
    }else{
        alert("Please Give Both User and Password!");
    }
    
    
});

$("#logout").click(function(){
	sessionStorage.removeItem('lasttimestamp');
    var routine = "lgout";
        $.ajax({
            url:"functions.php",
            method:"POST",
            data:{routine:routine},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 1){
                    alert('You Successfuly Logout From Finacle Core Banking System');   
                    window.location.replace('index.php');
					window.location.replace('index.php');
					window.location.replace('index.php');
                   }else{
					alert('Something went wrong while logout from Finacle Core Banking System');   
				   }
            }
        });
});

$("#go").click(function(){
    var newopt = $('#menu').val();
    var newopt = newopt.toUpperCase();
    var routine = "optionselect";
        $.ajax({
            url:"functions.php",
            method:"POST",
            data:{newopt:newopt,routine:routine},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 1){
                    alert('You Successfuly Redirect to the required function');
					$("#mainsysscrdisp").attr('src','');
					$("#mainsysscrdisp").attr('src','fincoreoptscrview.php');
					$('#menu').val('');
                }else{
                    alert('Invalid Option OR You Are Not Authorize');
                }
            }
        });
});

$("#rejover").click(function(){
			$("#overdrno").text('');
			$("#overcrno").text('');
			$("#overdrname").text('');
			$("#overcrname").text('');
			$("#overamount").text('');
			$("#overdrrem").text('');
			$("#overcrrem").text('');
			$("#overres").text('');
			$("#frmusr").text('');
			$("#usrmsgviewscr").toggle();
			$("#mainsysscrdisp").toggle();
	
	var routine = "decover";
        $.ajax({
            url:"functions.php",
            method:"POST",
            data:{routine:routine},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 1){
                    alert('You Have Declined the Override!!');
                }else{}
            }
        });

});

$("#accnum").change(function(){acfetch();});

$("#mainsysscr").on('click','#hacligo',function(){
    var ok = $("#accname").text();
    if(ok != ""){
    var routine = "fetchac";
    var acnum = $("#accnum").val();
    var daf = $("#fdate").val();
    var dat = $("#tdate").val();
    var amf = $("#famount").val();
    var amt = $("#tamount").val();
    $.ajax({
            url:"functions.php",
            method:"POST",
            data:{routine:routine,acnum:acnum,daf:daf,dat:dat,amf:amf,amt:amt},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 1){
                $("#nam").text(ok);
                $("#status").text(data.state);
                $("#odate").text(data.opendate);
                $("#cdate").text(data.closedate);
                $("#scheme").text(data.scheme);
                $("#hold").text(data.hold);
                $("#pod").text(data.pod);
                $("#dbl").text(data.dbl);
                $("#nic").text(data.nic);
                    
                    
                if(data.efb == 0 ){
                    $("#efb").attr('style','color:red;');
                   }else if(data.efb < 0){
                       $("#efb").attr('style','color:red;');
                    }else{
                        $("#efb").attr('style','color:darkgreen;');
                    }
                    
                    $("#acstat").append('<tr><td><b>Date</b></td><td style="width:100px;"></td><td><b>Deposit</b></td><td style="width:100px;"></td><td><b>Withdrawal</b></td><td style="width:100px;"></td><td><b>Balance</b></td><td style="width:100px;"></td><td><b>Remarks</b></td></tr>');
                    var a =1;
                    while(a < data.max){
                        $("#acstat").append("<tr><td><b><lable><a style='CURSOR: hand' onclick='window.open(`view.php?"+data.tran[a]+"`,`newwindow`,`width=500,height=500`);'>"+data.date[a]+"</a></lable></b></td><td style='width:100px;'></td><td><b><lable>"+data.credit[a]+"</lable></b></td><td style='width:100px;'></td><td><b><lable>"+data.debit[a]+"</lable></b></td><td style='width:100px;'></td><td><b><lable>"+data.balance[a]+"</lable></b></td><td style='width:100px;'></td><td><b><lable>"+data.remark[a]+"</lable></b></td></tr>");
                    a=a+1;
                    }
                $("#opbal").text(data.opbaln);
                $("#clb").text(data.clb);
                $("#efb").text(data.efb);
                $("#cmmtb").toggle();
                $("#acdet").toggle();
                $("#acstat").toggle();
                $("#butt").toggle();
                }else if(data.msg == 2){
                    alert("Date From Should not be grater than Date To!!!");
                }else if(data.msg == 3){
                        $("#nam").text(ok);
                        $("#opbal").text(data.opbaln);
                        $("#status").text(data.state);
                        $("#odate").text(data.opendate);
                        $("#cdate").text(data.closedate);
                        $("#scheme").text(data.scheme);
                        $("#hold").text(data.hold);
                        $("#pod").text(data.pod);
                        $("#dbl").text(data.dbl);
                        $("#nic").text(data.nic);
                    
                if(data.efb == 0){
                    $("#efb").attr('style','color:red;');
                   }else{
                       $("#efb").attr('style','color:darkgreen;');
                    }
                        $("#obal").text(data.obal);
                        $("#clb").text(data.clb);
                        $("#efb").text(data.efb);
                        $("#cmmtb").toggle();
                        $("#acdet").toggle();
                        $("#acstat").toggle();
                        $("#butt").toggle();
                        $("#acstat").append('<b>No Statement Details Found for The Request</b>');
                    }else{
                        alert("From Date Can't be Less Than Open Date!!!");
                    }
            } 
    }); }else{
        alert('You Entered Invalid Account or Account Creation Not Verified Yet!!!');
    }
    
    
});

$("#nontellerok").click(function(){
    var ntellerdebitacno = $('#ntellerdebitacno').val();
	var	ntellercreditacno = $('#ntellercreditacno').val();
	var	ntelleramo = $('#ntelleramo').val();
	var ntellerdebitrem = $('#ntellerdebitrem').val();
	var	ntellercreditrem = $('#ntellercreditrem').val();

	if(ntellerdebitacno != '' & ntellercreditacno != '' & ntelleramo != '' & ntellerdebitrem != '' & ntellercreditrem != ''){
	    var routine = "nontelpost";
        $.ajax({
            url:"functions.php",
            method:"POST",
            data:{routine:routine,ntellerdebitacno:ntellerdebitacno,ntellercreditacno:ntellercreditacno,ntelleramo:ntelleramo,ntellerdebitrem:ntellerdebitrem,ntellercreditrem:ntellercreditrem},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 'Y'){
                    alert('Tran Id : '+data.tranid+' Sucessfully Posted');
					$(location).attr('href','fincoreoptscrview.php');
                }else if(data.msg == 1){
					alert('Debit Account Detected as Own Account');
					$(location).attr('href','fincoreoptscrview.php');
				}else if(data.msg == 2){
					alert('Insufficent Funds Hold in Force');
					$(location).attr('href','fincoreoptscrview.php');
				}else if(data.msg == 3){
					alert('Insufficent Funds in Account');
					$('#nontellautscr').toggle();
				}else if(data.msg == 30){
					alert('Insufficent Funds in Account');
					$(location).attr('href','fincoreoptscrview.php');
				}else if(data.msg == 4){
					if(data.status == 'Freeze'){
					   alert('Debit Account is in Total Freezed Status');
						$(location).attr('href','fincoreoptscrview.php');
					}else if(data.status == 'Dormant'){
					   alert('Debit Account is in Dormant Status');
						$(location).attr('href','fincoreoptscrview.php');
					}else if(data.status == 'DFreeze'){
					   alert('Debit Account is Freezed for Debit');
						$(location).attr('href','fincoreoptscrview.php');
					}else{
					   alert('Debit Account Has been Closed');
					   $(location).attr('href','fincoreoptscrview.php');
					}
				}else if(data.msg == 5){
					alert('Credit Account Detected as Own Account');
					$(location).attr('href','fincoreoptscrview.php');
				}else if(data.msg == 6){
					if(data.status == 'Freeze'){
					   alert('Credit Account is in Total Freezed Status');
						$(location).attr('href','fincoreoptscrview.php');
					}else if(data.status == 'Dormant'){
					   alert('Credit Account is in Dormant Status');
						
					}else if(data.status == 'CFreeze'){
					   alert('Credit Account is Freezed for Credit');
						$(location).attr('href','fincoreoptscrview.php');
					}else{
					   alert('Credit Account Has been Closed');
					   $(location).attr('href','fincoreoptscrview.php');
					}
				}else if(data.msg == 7){
					alert('Manual Trnsactions are Restricted');
					$(location).attr('href','fincoreoptscrview.php');
				}else if(data.msg == 100){
					alert('Branch Transaction have Not Open Yet');
					$(location).attr('href','fincoreoptscrview.php');
				}else{
					alert('Bra');
				}
            }
        });
	   }else{
	    alert('Please fill All required Data!!');
	   }    
});

$("#ntellerdebitacno").change(function(){
           var accnum = $("#ntellerdebitacno").val();
           var routine = "acfetch";
    $.ajax({
            url:"functions.php",
            method:"POST",
            data:{routine:routine,accnum:accnum},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 1){
                    $("#ntellerdebitacname").text(data.accname);
                }else if(data.msg == 2){
                    $("#ntellerdebitacname").text(data.accname);
                    alert('Account Has Been Closed!!!');
					$("#ntellerdebitacno").val('');
                }else{
                    alert('You Entered Invalid Account!!!');
                    $("#ntellerdebitacno").val('');
                }
            } 
    });
});

$("#ntellercreditacno").change(function(){
           var accnum = $("#ntellercreditacno").val();
           var routine = "acfetch";
    $.ajax({
            url:"functions.php",
            method:"POST",
            data:{routine:routine,accnum:accnum},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 1){
                    $("#ntellercreditacname").text(data.accname);
                }else if(data.msg == 2){
                    $("#ntellercreditacname").text(data.accname);
                    alert('Account Has Been Closed!!!');
					$("#ntellercreditacno").val('');
                }else{
                    alert('You Entered Invalid Account!!!');
                    $("#ntellercreditacno").val('');
                }
            } 
    });
});

$("#cifopen").click(function(){
    var cusdoc = $("#cusdoc").val();
    var cusuid = $("#cusuid").val();
    var custitle = $("#custitle").val();
    var cusfname = $("#cusfname").val();
    var cusininame = $("#cusininame").val();
    var cusgen = $("#cusgen").val();
	var cusdob = $("#cusdob").val();
    var cusphone = $("#cusphone").val();
    var cuspadd = $("#cuspadd").val();
    var cusocc = $("#cusocc").val();
    var cusemail = $("#cusemail").val();
	var acctype = $("#acctype").val();
    var cifcrelang = $("#cifcrelang").val();
	
    if(cusdoc != "" & cusuid != "" & cusfname != "" & cusininame != "" & cusdob != "" & cusphone != "" & cuspadd != "" & cusemail != "" & cusocc != "" & cifcrelang !=''){
        if(cusdoc != "Select" & custitle != "Select" & cusgen != "Select" & acctype != "Select"){
			
                       var routine = "cifcreation";
                        $.ajax({
                            url:"functions.php",
                            method:"POST",
                            data:{routine:routine,cusdoc:cusdoc,cusuid:cusuid,custitle:custitle,cusfname:cusfname,cusininame:cusininame,cusgen:cusgen,cusdob:cusdob,cusphone:cusphone,cusemail:cusemail,cuspadd:cuspadd,cusocc:cusocc,cifcrelang:cifcrelang,acctype:acctype},
                            dataType:"JSON",
                            success:function(data)
                        {
                            if(data.msg ==1){
                                var routine = "accautcre";
                              
                            $.ajax({
                                    url:"functions.php",
                                    method:"POST",
                                    data:{routine:routine},
                                    dataType:"JSON",
                                    success:function(data)
                                    {
                                        if(data.msg == 1){
											$("#cifcrescr").toggle();
											$("#acopscr").toggle();
											$("#acopbutscr").toggle();
											var a =1;
                    						while(a < data.max){
											$("#acopscr").append('<tr><td>CIF</td><td><input type="number" disabled="disabled" readonly="readonly" id="cif'+a+'" value="'+data.cif[a]+'"/></td><td>Name</td><td><input type="text" disabled="disabled" readonly="readonly" value="'+data.initialname[a]+'"/></td><td><input type="text" id="relcd'+a+'" placeholder="Relation Code"/></td></tr>');
                    						a=a+1;
											}
                                    	}else{
											$("#cifcrescr").toggle();
											$("#acopscr").toggle();
											$("#acopbutscr").toggle();
											$("#acopscr").append('<tr><td>CIF</td><td><input type="number" disabled="disabled" readonly="readonly" value="'+data.cif+'" id="cif"/></td><td>Name</td><td><input type="text" disabled="disabled" readonly="readonly" value="'+data.initialname+'"/></td><td><input type="text" id="relcd" value="SOW" disabled="disabled" readonly="readonly"/></td></tr>');
										}
                                    }
                                });  
                       
                        	}else if(data.msg ==2){
                             alert('CIF '+data.cif+' Selected Successfuly');
                            $(location).attr('href','fincoreoptscrview.php');
                            }else if(data.msg ==3){
							 alert('CIF '+data.cif+' Created Successfuly');
                            $(location).attr('href','fincoreoptscrview.php');
							}else if(data.msg ==4){
							 alert('CIF '+data.cif+' Already in Process!!');
                            $(location).attr('href','fincoreoptscrview.php');
							}else{
								alert('Something Wrong');
							}
                        }
                            });
			
    }else {
            $("#mandatemsg").empty();
            $("#mandatemsg").text("Please Select The option details");
           }
    }else{
		$("#mandatemsg").empty();
        $("#mandatemsg").text("Please Fill All The Mandatory details");
    }
    
});

$("#schm").change(function(){
	$("#subtr").remove();
	var scrtype = $("#schm").val();
	if(scrtype == 'SA10'){
		$("#autoacsubscr").empty();
		$("#autoacsubscr").append('<tr id="subtr"><td>Category</td><td><select id="subcate"><option value="Select">Select</option><option value="SA11">SA11-Normal</option><option value="SA12">SA12-Anagi</option><option value="SA13">SA13-Divisaru</option><option value="SA14">SA14-Arunalu</option><option value="SA15">SA15-Isuru</option><option value="SA16">SA16-Super Saver</option><option value="SA17">SA17-Dot Com</option></select></td></tr>');
	}else if(scrtype == 'SA20'){
		$("#autoacsubscr").empty();	 
	}else if(scrtype == 'SA30'){
		$("#autoacsubscr").empty();
	}else if(scrtype == 'CA10'){
		$("#autoacsubscr").empty();	 
	}else if(scrtype == 'CA20'){
		$("#autoacsubscr").empty();	 
	}else if(scrtype == 'CA30'){
		$("#autoacsubscr").empty();	
		$("#autoacsubscr").append('<tr id="subtr"><td>Charges</td><td><input type="text" disabled="disabled" readonly="readonly" value="No Any Charges"/></td></tr>');
	}else if(scrtype == 'FD00'){
		$("#autoacsubscr").empty();	 
		$("#autoacsubscr").append('<tr id="subtr"><td>Amount</td><td><input type="number" id="fdamount"/></td><td>Period</td><td><select id="fdperiod"><option value="Select">Select</option><option value="1">1 Month</option><option value="No">No</option></select></td></tr>');
	}else if(scrtype == 'FD10'){
		$("#autoacsubscr").empty();	 
	}else if(scrtype == 'FD20'){
		$("#autoacsubscr").empty();
		$("#autoacsubscr").append('<tr id="subtr"><td>Amount</td><td><input type="number" id="fdamount"/></td><td>Period</td><td><select id="fdperiod"><option value="Select">Select</option><option value="1">Over 60 - Monthly Interest</option><option value="2">Over 60 - Maturity Interest</option><option value="3">55 - 60 - Monthly Interest</option><option value="4">55 - 60 - Maturity Interest</option><option value="5">60 - 70 - Monthly Interest</option><option value="6">60 - 70 - Maturity Interest</option></select></td></tr>');
	}else if(scrtype == 'FD30'){
		$("#autoacsubscr").empty();	 
		$("#autoacsubscr").append('<tr id="subtr"><td>Amount</td><td><input type="number" id="fdamount"/></td><td>Period</td><td><select id="fdperiod"><option value="Select">Select</option><option value="7">1 Month Maturity Interest</option><option value="8">1 Month Renewal</option><option value="9">2 Month Maturity Interest</option><option value="10">2 Month Renewal</option><option value="11">3 Month Maturity Interest</option><option value="12">3 Month Renewal</option></select></td></tr>');
	}else{$("#autoacsubscr").empty();}
});

$("#autoacsubscr").on('change','#subcate',function(){
			$("#subsa14").remove();
			$("#subsa15").remove();
			$("#trsa15").remove();
			$("#trsa14").remove();
			var subval = $("#subcate").val();	
			if(subval == 'SA14' | subval == 'SA15'){
				$("#autoacsubscr").append('<tr id="subsa14"><td>Title Modifier</td><td><input type="text" id="mintitle"/></td><td>Transfer Order</td><td><select id="trorder"><option value="Select">Select</option><option value="Yes">Yes</option><option value="No">No</option></select></td></tr>');
			}else{
				$("#trsa15").remove();
				$("#trsa14").remove();
			}
	
			if(subval == 'SA15'){
				$("#subsa15").remove();
				$("#autoacsubscr").append('<tr id="subsa15"><td>Deposit Amount</td><td><input type="number" id="mdamount"/></td><td>Period</td><td><input type="number" id="mdperiod"/></td></tr>');
				
			}else{
				$("#trsa15").remove();
				$("#trsa14").remove();	
			}
		});

$("#autoacsubscr").on('change','#trorder',function(){
	var trnor = $("#trorder").val();
	var subval = $("#subcate").val();
	if(trnor == 'Yes' & subval == 'SA14'){
	   $("#autoacsubscr").append('<tr id="trsa14"><td>Dr Account</td><td><input type="number" id="trorderdracc"/></td><td>Frequency</td><td><input type="text" disabled="disabled" value="Monthly" readonly="readonly"/></td><td><input type="number" placeholder="Due" id="trorderdue"/></td><td><input type="number" placeholder="Amount" id="mdamount"/></td></tr>');
	}else if(trnor == 'Yes' & subval == 'SA15'){
		$("#autoacsubscr").append('<tr id="trsa15"><td>Dr Account</td><td><input type="number" id="trorderdracc"/></td><td>Frequency</td><td><input type="text" disabled="disabled" value="Monthly" readonly="readonly"/></td><td><input type="number" placeholder="Due" id="trorderdue"/></td></tr>');	 
	}else{
		$("#trsa15").remove();
		$("#trsa14").remove();
	}
});

$("#accopenok").click(function(){
	var relcd = $("#relcd").val();
	var cif = $("#cif").val();
	var schm = $("#schm").val();
	
	if(relcd == "SOW" & cif != ""){
		if(schm == "Select"){
		   alert("Select the Account Scheme Type");
		}else if(schm == "SA10"){
			var subcate = $("#subcate").val();
			if(subcate == "Select"){
			   alert("Select the Account Category");
			}else if(subcate == "SA14" | subcate == "SA15"){
			   alert("Minor Account Should Related with Guardians or Parent CIF");
			}else{
				var routine = "acccrefinal";
    $.ajax({
            url:"functions.php",
            method:"POST",
            data:{routine:routine,relcd:relcd,cif:cif,schm:schm,subcate:subcate},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 1){
                    alert('Account '+data.acno+' Opened Succesfully');
					$(location).attr('href','fincoreoptscrview.php');
                }else{
                    alert('Somthing Wrong');
					$(location).attr('href','fincoreoptscrview.php');
                }
            } 
    });
			}
		}else if(schm == "SA00" | schm == "SA20" | schm == "SA30" | schm == "CA00" | schm == "CA10" | schm == "CA20" | schm == "CA30"){
			var routine = "acccrefinal";
    $.ajax({
            url:"functions.php",
            method:"POST",
            data:{routine:routine,relcd:relcd,cif:cif,schm:schm},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 1){
                    alert('Account '+data.acno+' Opened Succesfully');
					$(location).attr('href','fincoreoptscrview.php');
                }else{
                   alert('Somthing Wrong');
				   $(location).attr('href','fincoreoptscrview.php');
                }
            }
    });
		}
	}else{
		
	}
	
});

$("#cusuid").change(function(){
    var id = $("#cusuid").val();
	var cusdoc =$("#cusdoc").val();
    var routine = "ciffetch";
	if(cusdoc != 'Select'){
    $.ajax({
            url:"functions.php",
            method:"POST",
            data:{routine:routine,id:id},
            dataType:"JSON",
            success:function(data)
            {
                if(data.exist == 1){
                    alert('Customer Already have CIF '+data.cif);
					$("#cifopen").val('Select');
					$("#cusdoc").val(data.cusdoc).attr('disabled','disabled');
                    $("#custitle").val(data.custitle).attr('disabled','disabled');
                    $("#cusfname").val(data.cusfname).attr('disabled','disabled');
                    $("#cusininame").val(data.cusininame).attr('disabled','disabled');
                    $("#cusgen").val(data.cusgen).attr('disabled','disabled');
                    $("#cusdob").val(data.cusdob).attr('disabled','disabled');
                     $("#cusphone").val(data.cusphone).attr('disabled','disabled');
                    $("#cusemail").val(data.cusemail).attr('disabled','disabled');
                    $("#cuspadd").text(data.cuspadd).attr('disabled','disabled');                    
                    $("#cusocc").val(data.cusocc).attr('disabled','disabled');                  					
					$("#cifcrelang").val(data.cifcrelang).attr('disabled','disabled');
                    $("#cusuid").attr('disabled','disabled');
                    $('#ciforacc').attr('disabled','disabled');
                    $('#ciffun').attr('disabled','disabled');
                }else{
                    alert('No records found');
                }
            } 
    });}else{
		alert('Select The Document Type');
}
});

$("#clear").click(function(){
	$(location).attr('href','fincoreoptscrview.php');
});

$("#cancelacc").click(function(){
	var routine = "mandatecancel";
    $.ajax({
            url:"functions.php",
            method:"POST",
            data:{routine:routine},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 1){
                    alert('Account Openings Process Canceled');
					$(location).attr('href','fincoreoptscrview.php');
                }else{
                    alert('Cancelation Failed');
                }
            } 
    });
});

$("#telleramactu").change(function(){
	$("#tellmainscr").toggle();
	$("#denocal").toggle();
});

$("#denocalok").click(function(){
	var a = parseFloat($("#ft").val(),10);
	var b = parseFloat($("#tt").val(),10);
	var c = parseFloat($("#ot").val(),10);
	var d = parseFloat($("#fh").val(),10);
	var e = parseFloat($("#oh").val(),10);
	var f = parseFloat($("#f").val(),10);
	var g = parseFloat($("#t").val(),10);
	var h = parseFloat($("#ten").val(),10);
	var i = parseFloat($("#five").val(),10);
	var j = parseFloat($("#two").val(),10);
	var k = parseFloat($("#one").val(),10);
	var l = parseFloat($("#cnts").val(),10);
	
	var total = (a * 5000)+(b*2000)+(c*1000)+(d*500)+(e*100)+(f*50)+(g*20)+(h*10)+(i*5)+(j*2)+k+(l/100);
	$("#telleram").val(total);
	$("#tellmainscr").toggle();
	$("#denocal").toggle();
});

$("#ft").change(function(){
	var a = parseFloat($("#ft").val(),10);
	var b = parseFloat($("#tt").val(),10);
	var c = parseFloat($("#ot").val(),10);
	var d = parseFloat($("#fh").val(),10);
	var e = parseFloat($("#oh").val(),10);
	var f = parseFloat($("#f").val(),10);
	var g = parseFloat($("#t").val(),10);
	var h = parseFloat($("#ten").val(),10);
	var i = parseFloat($("#five").val(),10);
	var j = parseFloat($("#two").val(),10);
	var k = parseFloat($("#one").val(),10);
	var l = parseFloat($("#cnts").val(),10);
	
	var total = (a * 5000)+(b*2000)+(c*1000)+(d*500)+(e*100)+(f*50)+(g*20)+(h*10)+(i*5)+(j*2)+k+(l/100);
	$("#denocaltotv").val(total);
});

$("#tt").change(function(){
	var a = parseFloat($("#ft").val(),10);
	var b = parseFloat($("#tt").val(),10);
	var c = parseFloat($("#ot").val(),10);
	var d = parseFloat($("#fh").val(),10);
	var e = parseFloat($("#oh").val(),10);
	var f = parseFloat($("#f").val(),10);
	var g = parseFloat($("#t").val(),10);
	var h = parseFloat($("#ten").val(),10);
	var i = parseFloat($("#five").val(),10);
	var j = parseFloat($("#two").val(),10);
	var k = parseFloat($("#one").val(),10);
	var l = parseFloat($("#cnts").val(),10);
	
	var total = (a * 5000)+(b*2000)+(c*1000)+(d*500)+(e*100)+(f*50)+(g*20)+(h*10)+(i*5)+(j*2)+k+(l/100);
	$("#denocaltotv").val(total);
});

$("#ot").change(function(){
	var a = parseFloat($("#ft").val(),10);
	var b = parseFloat($("#tt").val(),10);
	var c = parseFloat($("#ot").val(),10);
	var d = parseFloat($("#fh").val(),10);
	var e = parseFloat($("#oh").val(),10);
	var f = parseFloat($("#f").val(),10);
	var g = parseFloat($("#t").val(),10);
	var h = parseFloat($("#ten").val(),10);
	var i = parseFloat($("#five").val(),10);
	var j = parseFloat($("#two").val(),10);
	var k = parseFloat($("#one").val(),10);
	var l = parseFloat($("#cnts").val(),10);
	
	var total = (a * 5000)+(b*2000)+(c*1000)+(d*500)+(e*100)+(f*50)+(g*20)+(h*10)+(i*5)+(j*2)+k+(l/100);
	$("#denocaltotv").val(total);
});

$("#fh").change(function(){
	var a = parseFloat($("#ft").val(),10);
	var b = parseFloat($("#tt").val(),10);
	var c = parseFloat($("#ot").val(),10);
	var d = parseFloat($("#fh").val(),10);
	var e = parseFloat($("#oh").val(),10);
	var f = parseFloat($("#f").val(),10);
	var g = parseFloat($("#t").val(),10);
	var h = parseFloat($("#ten").val(),10);
	var i = parseFloat($("#five").val(),10);
	var j = parseFloat($("#two").val(),10);
	var k = parseFloat($("#one").val(),10);
	var l = parseFloat($("#cnts").val(),10);
	
	var total = (a * 5000)+(b*2000)+(c*1000)+(d*500)+(e*100)+(f*50)+(g*20)+(h*10)+(i*5)+(j*2)+k+(l/100);
	$("#denocaltotv").val(total);
});

$("#oh").change(function(){
	var a = parseFloat($("#ft").val(),10);
	var b = parseFloat($("#tt").val(),10);
	var c = parseFloat($("#ot").val(),10);
	var d = parseFloat($("#fh").val(),10);
	var e = parseFloat($("#oh").val(),10);
	var f = parseFloat($("#f").val(),10);
	var g = parseFloat($("#t").val(),10);
	var h = parseFloat($("#ten").val(),10);
	var i = parseFloat($("#five").val(),10);
	var j = parseFloat($("#two").val(),10);
	var k = parseFloat($("#one").val(),10);
	var l = parseFloat($("#cnts").val(),10);
	
	var total = (a * 5000)+(b*2000)+(c*1000)+(d*500)+(e*100)+(f*50)+(g*20)+(h*10)+(i*5)+(j*2)+k+(l/100);
	$("#denocaltotv").val(total);
});

$("#f").change(function(){
	var a = parseFloat($("#ft").val(),10);
	var b = parseFloat($("#tt").val(),10);
	var c = parseFloat($("#ot").val(),10);
	var d = parseFloat($("#fh").val(),10);
	var e = parseFloat($("#oh").val(),10);
	var f = parseFloat($("#f").val(),10);
	var g = parseFloat($("#t").val(),10);
	var h = parseFloat($("#ten").val(),10);
	var i = parseFloat($("#five").val(),10);
	var j = parseFloat($("#two").val(),10);
	var k = parseFloat($("#one").val(),10);
	var l = parseFloat($("#cnts").val(),10);
	
	var total = (a * 5000)+(b*2000)+(c*1000)+(d*500)+(e*100)+(f*50)+(g*20)+(h*10)+(i*5)+(j*2)+k+(l/100);
	$("#denocaltotv").val(total);
});

$("#t").change(function(){
	var a = parseFloat($("#ft").val(),10);
	var b = parseFloat($("#tt").val(),10);
	var c = parseFloat($("#ot").val(),10);
	var d = parseFloat($("#fh").val(),10);
	var e = parseFloat($("#oh").val(),10);
	var f = parseFloat($("#f").val(),10);
	var g = parseFloat($("#t").val(),10);
	var h = parseFloat($("#ten").val(),10);
	var i = parseFloat($("#five").val(),10);
	var j = parseFloat($("#two").val(),10);
	var k = parseFloat($("#one").val(),10);
	var l = parseFloat($("#cnts").val(),10);
	
	var total = (a * 5000)+(b*2000)+(c*1000)+(d*500)+(e*100)+(f*50)+(g*20)+(h*10)+(i*5)+(j*2)+k+(l/100);
	$("#denocaltotv").val(total);
});

$("#ten").change(function(){
	var a = parseFloat($("#ft").val(),10);
	var b = parseFloat($("#tt").val(),10);
	var c = parseFloat($("#ot").val(),10);
	var d = parseFloat($("#fh").val(),10);
	var e = parseFloat($("#oh").val(),10);
	var f = parseFloat($("#f").val(),10);
	var g = parseFloat($("#t").val(),10);
	var h = parseFloat($("#ten").val(),10);
	var i = parseFloat($("#five").val(),10);
	var j = parseFloat($("#two").val(),10);
	var k = parseFloat($("#one").val(),10);
	var l = parseFloat($("#cnts").val(),10);
	
	var total = (a * 5000)+(b*2000)+(c*1000)+(d*500)+(e*100)+(f*50)+(g*20)+(h*10)+(i*5)+(j*2)+k+(l/100);
	$("#denocaltotv").val(total);
});

$("#five").change(function(){
	var a = parseFloat($("#ft").val(),10);
	var b = parseFloat($("#tt").val(),10);
	var c = parseFloat($("#ot").val(),10);
	var d = parseFloat($("#fh").val(),10);
	var e = parseFloat($("#oh").val(),10);
	var f = parseFloat($("#f").val(),10);
	var g = parseFloat($("#t").val(),10);
	var h = parseFloat($("#ten").val(),10);
	var i = parseFloat($("#five").val(),10);
	var j = parseFloat($("#two").val(),10);
	var k = parseFloat($("#one").val(),10);
	var l = parseFloat($("#cnts").val(),10);
	
	var total = (a * 5000)+(b*2000)+(c*1000)+(d*500)+(e*100)+(f*50)+(g*20)+(h*10)+(i*5)+(j*2)+k+(l/100);
	$("#denocaltotv").val(total);
});

$("#two").change(function(){
	var a = parseFloat($("#ft").val(),10);
	var b = parseFloat($("#tt").val(),10);
	var c = parseFloat($("#ot").val(),10);
	var d = parseFloat($("#fh").val(),10);
	var e = parseFloat($("#oh").val(),10);
	var f = parseFloat($("#f").val(),10);
	var g = parseFloat($("#t").val(),10);
	var h = parseFloat($("#ten").val(),10);
	var i = parseFloat($("#five").val(),10);
	var j = parseFloat($("#two").val(),10);
	var k = parseFloat($("#one").val(),10);
	var l = parseFloat($("#cnts").val(),10);
	
	var total = (a * 5000)+(b*2000)+(c*1000)+(d*500)+(e*100)+(f*50)+(g*20)+(h*10)+(i*5)+(j*2)+k+(l/100);
	$("#denocaltotv").val(total);
});

$("#one").change(function(){
	var a = parseFloat($("#ft").val(),10);
	var b = parseFloat($("#tt").val(),10);
	var c = parseFloat($("#ot").val(),10);
	var d = parseFloat($("#fh").val(),10);
	var e = parseFloat($("#oh").val(),10);
	var f = parseFloat($("#f").val(),10);
	var g = parseFloat($("#t").val(),10);
	var h = parseFloat($("#ten").val(),10);
	var i = parseFloat($("#five").val(),10);
	var j = parseFloat($("#two").val(),10);
	var k = parseFloat($("#one").val(),10);
	var l = parseFloat($("#cnts").val(),10);
	
	var total = (a * 5000)+(b*2000)+(c*1000)+(d*500)+(e*100)+(f*50)+(g*20)+(h*10)+(i*5)+(j*2)+k+(l/100);
	$("#denocaltotv").val(total);
});

$("#cnts").change(function(){
	var a = parseFloat($("#ft").val(),10);
	var b = parseFloat($("#tt").val(),10);
	var c = parseFloat($("#ot").val(),10);
	var d = parseFloat($("#fh").val(),10);
	var e = parseFloat($("#oh").val(),10);
	var f = parseFloat($("#f").val(),10);
	var g = parseFloat($("#t").val(),10);
	var h = parseFloat($("#ten").val(),10);
	var i = parseFloat($("#five").val(),10);
	var j = parseFloat($("#two").val(),10);
	var k = parseFloat($("#one").val(),10);
	var l = parseFloat($("#cnts").val(),10);
	
	var total = (a * 5000)+(b*2000)+(c*1000)+(d*500)+(e*100)+(f*50)+(g*20)+(h*10)+(i*5)+(j*2)+k+(l/100);
	$("#denocaltotv").val(total);
});

$("#tellerfun").change(function(){
	var routine = "tellerchk";
    $.ajax({
            url:"functions.php",
            method:"POST",
            data:{routine:routine},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 1){
                    alert('Cash Operations for the Branch Not Open Yet');
					$(location).attr('href','fincoreoptscrview.php');
                }else if(data.msg == 2){
                    alert('Please Open the Till first');
					$(location).attr('href','fincoreoptscrview.php');
                }else if(data.msg == 3){
                    alert('Teller Not Assaigned for Cash Operations');
					$(location).attr('href','fincoreoptscrview.php');
                }else{}
            } 
    });
});

$("#optsubok").click(function(){
	var routine = "optf";
    $.ajax({
            url:"functions.php",
            method:"POST",
            data:{routine:routine},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 1){
                    alert('Till Opened Successfully');
					$(location).attr('href','fincoreoptscrview.php');
                }else if(data.msg == 2){
					alert('Already Till Opened');
					$(location).attr('href','fincoreoptscrview.php');
				}else if(data.msg == 3){
					alert('You are Not Asaigned for Cash Transactions');
					$(location).attr('href','fincoreoptscrview.php');
				}else{}
            } 
    });
});

$("#cshbalvok").click(function(){
	var routine = "cshbalf";
    $.ajax({
            url:"functions.php",
            method:"POST",
            data:{routine:routine},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 1){
                    $("#cshbaldeev").toggle();
                    $("#deev").toggle();
					$("#syscshbal").val(data.balance);
					$("#denocaltotv").val(data.total);
					$("#cshexsh").val(data.dif);
					$("#ft").val(data.ft);
					$("#tt").val(data.tt);
					$("#ot").val(data.ot);
					$("#fh").val(data.fh);
					$("#oh").val(data.oh);
					$("#f").val(data.f);
					$("#t").val(data.t);
					$("#ten").val(data.ten);
					$("#five").val(data.five);
					$("#two").val(data.two);
					$("#one").val(data.one);
					$("#cnts").val(data.cents);
					$("#muti").val(data.muti);
                }else if(data.msg == 2){
					alert('You are Not Asaigned for Cash Transactions');
					$(location).attr('href','fincoreoptscrview.php');
				}else{}
            } 
    });
});

$("#telleraccno").change(function(){
	var accnum = $("#telleraccno").val();
           var routine = "acfetch";
    $.ajax({
            url:"functions.php",
            method:"POST",
            data:{routine:routine,accnum:accnum},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 1){
                    $("#accname").text(data.accname);
                }else if(data.msg == 2){
                    $("#accname").text(data.accname);
                    alert('Account Has Been Closed!!!');
					$(location).attr('href','fincoreoptscrview.php');
                }else{
                    alert('You Entered Invalid Account!!!');
                    $(location).attr('href','fincoreoptscrview.php');
                }
            } 
    });
});

$("#cshbalsub").click(function(){
	var a = parseFloat($("#ft").val(),10);
	var b = parseFloat($("#tt").val(),10);
	var c = parseFloat($("#ot").val(),10);
	var d = parseFloat($("#fh").val(),10);
	var e = parseFloat($("#oh").val(),10);
	var f = parseFloat($("#f").val(),10);
	var g = parseFloat($("#t").val(),10);
	var h = parseFloat($("#ten").val(),10);
	var i = parseFloat($("#five").val(),10);
	var j = parseFloat($("#two").val(),10);
	var k = parseFloat($("#one").val(),10);
	var l = parseFloat($("#cnts").val(),10);
	var muti = parseFloat($("#muti").val(),10);
	
	var total = (a * 5000)+(b*2000)+(c*1000)+(d*500)+(e*100)+(f*50)+(g*20)+(h*10)+(i*5)+(j*2)+k+(l/100);
           var routine = "cshbalup";
    $.ajax({
            url:"functions.php",
            method:"POST",
            data:{routine:routine,a:a,b:b,c:c,d:d,e:e,f:f,g:g,h:h,i:i,j:j,k:k,l:l,total:total,muti:muti},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 1){
                    alert('Successfully Updated');
					$(location).attr('href','fincoreoptscrview.php');
                }else{}
            } 
	});
});

$("#tellerok").click(function(){
	var fun = $("#tellerfun").val();
	var acno = $("#telleraccno").val();
	var tram = $("#telleramactu").val();
	var am = $("#telleram").val();
	var chqno = $("#chqno").val();
	
	if(fun != 'Select'){
		if(fun == 'deposit' | fun == 'withdraw'){
			if(acno != '' & tram != '' & ((tram < am) | (tram == am))){
			   var routine = "tellerpost";
    $.ajax({
            url:"functions.php",
            method:"POST",
            data:{routine:routine,fun:fun,acno:acno,tram:tram,am:am,chqno:chqno},
            dataType:"JSON",
            success:function(data)
            {
                if(data.msg == 'Y'){
                    alert('Tran Id : '+data.tranid+' Sucessfully Posted');
					$(location).attr('href','fincoreoptscrview.php');
                }else if(data.msg == 1){
					alert('Manual Transactions are Restricted');
					$(location).attr('href','fincoreoptscrview.php');
				}else if(data.msg == 2){
					alert('Account Detected as Own Account');
					$(location).attr('href','fincoreoptscrview.php');
				}else if(data.msg == 3){
					if(data.status == 'Freeze'){
					   alert('Account is in Total Freezed Status');
						$(location).attr('href','fincoreoptscrview.php');
					}else if(data.status == 'Dormant'){
					   alert('Account is in Dormant Status');
						
					}else if(data.status == 'CFreeze'){
					   alert('Account is Freezed for Credit');
						$(location).attr('href','fincoreoptscrview.php');
					}else{
					   alert('Account Has been Closed');
					   $(location).attr('href','fincoreoptscrview.php');
					}
				}else{
					alert('Bra');
				}
            } 
    });
			 }else if(tram > am){
			   alert('Insufficent Physical funds for Transaction');
			 }else{
				 alert('Please fill all the Details');
			 }
		}else{
			
		}
	}else{
		alert('Select Function Type');
	}
});