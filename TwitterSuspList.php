<?php

	//�Z�b�V�����J�n
	session_start();

	//OK�t���O
	$okFlg=true;
	
	//���̃y�[�W�����݂��邩�H
	$nextFlg=true;
	
	//�O�̃y�[�W�����݂��邩�H
	$frontFlg=true;

	include("./conf/variableSetting.php");
	
	
	//���[�U�F��API
	$usrAuthAPI="http://chocola.moe.hm/Java/".$aplName."/Diary/Owner";
	
	//���O�C���ł��Ă��Ȃ��ꍇ�́A���O�C���y�[�W�փ��_�C���N�g

	if (!isset($_SESSION['nm'])||!isset($_SESSION['pw'])){
		header("Location: http://".$hostName.".moe.hm/".$test."site/diary_archive/admin/login.php");
	}

	//���O�C����񐳏퐫�`�F�b�N

	$usrAuthXml=simplexml_load_file($usrAuthAPI."?n=".htmlspecialchars($_SESSION['nm'],ENT_QUOTES));

	if ((string)$usrAuthXml->RESPONSE[0]->CODE=="OK"){
		if ((string)$usrAuthXml->RESPONSE[0]->PASSWORD!=$_SESSION['pw']){
			header("Location: http://".$hostName.".moe.hm/".$test."site/diary_archive/admin/login.php");
		}//�p�X���[�h����v���Ȃ��ꍇ
	}
	else {
		header("Location: http://".$hostName.".moe.hm/".$test."site/diary_archive/admin/login.php");
	}

	//�p�����[�^�ݒ�
	$key=(isset($_GET['key']))?$_GET['key']:1;

	/********************API�₢���킹********************/
	//API
	$batchAPI="http://".$apiHostName."/Java/".$aplName."/Twitter/isSuspendedFriend?";
	
	//�N�G��������쐬
	$keyReal=100*($key-1);
	$batchQuery="num=".$keyReal;
	
	//�₢���킹
	$batchXml=simplexml_load_file($batchAPI.$batchQuery);
	$batchObj=$batchXml->RESPONSE[0];
	if ($batchObj->CODE=="OK"){
		$key_f=100*($key-2);
		$batchQuery_f="num=".$key_f;
		$batchXml_f=simplexml_load_file($batchAPI.$batchQuery_f);
		$batchXml_fObj=$batchXml_f->RESPONSE[0];
		if ($batchXml_fObj->CODE!="OK"){
			$frontFlg=false;
		}
		
		$key_n=100*$key;
		$batchQuery_n="num=".$key_n;
		$batchXml_n=simplexml_load_file($batchAPI.$batchQuery_n);
		$batchXml_nObj=$batchXml_n->RESPONSE[0];
		if ($batchXml_nObj->CODE!="OK"){
			$nextFlg=false;
		}
		
	}//�����key�̏ꍇ
	else {
		$okFlg=false;
	}//���N�G�X�g���s(0���܂��̓G���[����)

	/********************API�₢���킹********************/

?>
<html lang="ja">
    <head>
           <meta http-equiv="content-type" content="text/html;charset=Shift_JIS" />
           <meta http-equiv="content-style-type" content="text/css" />
	   	   <meta http-equiv="content-script-type" content="text/javascript" />
           <meta http-equiv="pragma" content="no-cache" />
           <meta name="author" content="Salad@Kani-Salad" />
           <meta name="description" content="�T���_�̓��L" />
           <meta name="keywords" content="BROCCOLI,digicharat,galaxyangel,broccoli,Koge-Donbo,2008" />
           <meta name="generator" content="Notepad,TeraPad" />
           <meta name="reply-to" content="americachachacha@yahoo.co.jp" />
           <title>TwitterBot(�T�X�y���h�t�H�����[����)</title>
           <link rel="stylesheet" type="text/css" href="../diary1.css" />
           <link rel="stylesheet" type="text/css" href="conf/themes/base/jquery.ui.all.css" />
	   	   <link rel="SHORTCUT ICON" href="http://www.geocities.jp/chocola_blancmanche10/favicon.ico" />
           <link rev="made" href="mailto:americachachacha@yahoo.co.jp" />
           <style type="text/css">
				.floatingHeader {
				    position: fixed;
				    top: 0;
				    visibility: hidden;
				}
				
				table#htmlgrid td.hover {
					background:#cffbfb;
				}
				table#htmlgrid td.hover:hover {
					background:#84f4f4;
				}
           </style>
		    <script type="text/javascript" src="./conf/jquery-1.7.1.js"></script>
		    <script type="text/javascript" src="./conf/jquery-ui.min.js"></script>
		    <script type="text/javascript" src="./conf/editablegrid.js"></script>
		    <script type="text/javascript" src="./conf/editablegrid_charts.js"></script>
		    <script type="text/javascript" src="./conf/editablegrid_editors.js"></script>
		    <script type="text/javascript" src="./conf/editablegrid_renderers.js"></script>
		    <script type="text/javascript" src="./conf/editablegrid_utils.js"></script>
		    <script type="text/javascript" src="./conf/editablegrid_validators.js"></script>
		    <script type="text/javascript" src="./conf/jquery.persistentheaders.js"></script>
		    <script type="text/javascript">
		    	<!--
		    	
		    		var selectedRows = new Array();
		    		
		    		window.onload=function(){
		    			
						editableGrid = new EditableGrid("DemoGrid",{
							modelChanged: function(rowIdx, colIdx, oldValue, newValue, row){
								_$("message").innerHTML="rowIdx="+rowIdx+",colIdx="+colIdx+",oldValue="+oldValue+",newValue="+newValue+",row="+row;
								$("#R"+(rowIdx+1)+" td:nth-child("+(colIdx+1)+")").css({backgroundColor:"lightgreen"});
								$("#R"+(rowIdx+1)+" td:nth-child("+(colIdx+1)+")").unbind("mouseover");
								$("#R"+(rowIdx+1)+" td:nth-child("+(colIdx+1)+")").unbind("mouseout");
							}
						}); 

						// we build and load the metadata in Javascript
						editableGrid.load(
							{ metadata: [
								{ name: "id", datatype: "html", editable: false },
								{ name: "username", datatype: "html", editable: true },
								{ name: "lastymd", datatype: "html", editable: true },
								{ name: "reflectflg", datatype: "html", editable: true }
								//If you do not want to affect a cell by EditableGrid, then you should comment out the corresponding JSON object from the source.
								//{ name: "letuscheck", datatype: "string", editable: false }
							]}
						);

						// then we attach to the HTML table and render it
						editableGrid.attachToHTMLTable('htmlgrid');
						editableGrid.renderGrid();
						
		    			//persistentHeader settings
		    			$('#htmlgrid').persistentHeaders();
						
						//Here is a code to change the color of the cell on which one puts the mouse cursor.
						<?php
							$j=0;
							for ($i=0;isset($batchObj->ITEM[$i]);$i++,$j++){}
						?>
						var objectNum = <?php echo $j; ?>;
						for (i=1;i<=objectNum;i++){
							/*
							$("#R"+i+" td").mouseover(function(){
								$(this).css({backgroundColor:"#cccccc"});
							});
							$("#R"+i+" td").mouseout(function(){
								$(this).css({backgroundColor:"#eeeeee"});
							});
							*/
						}
						
						//Here is a code to insert the next element <tr> to the table "htmlgrid".
						$("#insertarow").click(function(){
							//Insert the new row #R+objectNum below the row #R+(objectNum-1)
							if (/^[A-Z][0-9]{5}$/.test($.trim($("#insertarow_id").val()))){
								objectNum++;
								$("<tr id='R"+objectNum+"'><td>"+$.trim($("#insertarow_id").val())+"</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>").insertAfter($("#R"+(objectNum-1)));
								$("#insertarow_id").val("");
							}
							else {$("#insertarow_id").val("");return;}
							
							/*
							$("#R"+objectNum+" td").mouseover(function(){
								$(this).css({backgroundColor:"#cccccc"});
							});
							$("#R"+objectNum+" td").mouseout(function(){
								$(this).css({backgroundColor:"#eeeeee"});
							});
							*/
							editableGrid = new EditableGrid("DemoGrid",{
								modelChanged: function(rowIdx, colIdx, oldValue, newValue, row){
									_$("message").innerHTML="rowIdx="+rowIdx+",colIdx="+colIdx+",oldValue="+oldValue+",newValue="+newValue+",row="+row;
									$("#R"+(rowIdx+1)+" td:nth-child("+(colIdx+1)+")").css({backgroundColor:"lightgreen"});
									$("#R"+(rowIdx+1)+" td:nth-child("+(colIdx+1)+")").unbind("mouseover");
									$("#R"+(rowIdx+1)+" td:nth-child("+(colIdx+1)+")").unbind("mouseout");
								}
							});
							editableGrid.load(
								{ metadata: [
									{ name: "id", datatype: "string", editable: false },
									{ name: "username", datatype: "string", editable: true },
									{ name: "lastymd", datatype: "string", editable: true },
									{ name: "reflectflg", datatype: "string", editable: true }
									//If you do not want to affect a cell by EditableGrid, then you should comment out the corresponding JSON object from the source.
								]}
							);
							editableGrid.attachToHTMLTable('htmlgrid');
							editableGrid.renderGrid();
							
							selectRow(objectNum);
						});
						
						selectRow(objectNum);
						
						//Resizing Settings
						$('#htmlgrid_1').resizable();
		    		}
		    		
		    		//Here is a code to fix the row which will be operated in some way.
		    		function selectRow(num){
						for (i=1;i<=num;i++){
							$("#htmlgrid tr#R"+i+" td:first").click(function(i){
								if ($.inArray($(this).get()[0].firstChild.nodeValue+i,selectedRows)==-1){
									selectedRows.push($(this).get()[0].firstChild.nodeValue+i);
								}// If selectedRows does not have $(this).get()[0].firstChild.nodeValue+i as an element, then we push it to selectedRows.
								else {
									selectedRows.splice($.inArray($(this).get()[0].firstChild.nodeValue+i,selectedRows),1);
								}// If selectedRows has $(this).get()[0].firstChild.nodeValue+i, then we remove it from selectedRows.
								parent = $(this).parent();
								k = parent.get()[0].getElementsByTagName("td").length;
								for (j=0;j<k;j++){
									if (parent.get()[0].getElementsByTagName("td")[j].style.backgroundColor!="yellow"){
										parent.get()[0].getElementsByTagName("td")[j].style.backgroundColor = "yellow";
										parent.children().unbind("mouseover");//Getting rid of the mouseover event from <td> elements of each row.
										parent.children().unbind("mouseout");//Getting rid of the mouseout event from <td> elements of each row.
									}
									else {
										parent.get()[0].getElementsByTagName("td")[j].style.backgroundColor = "#eeeeee";
										/*
										parent.children().mouseover(function(){
											$(this).css({backgroundColor:"#cccccc"});
										});
										parent.children().mouseout(function(){
											$(this).css({backgroundColor:"#eeeeee"});
										});
										*/
									}
								}

							});
						}
		    		}


		    	//-->
		    </script>
    </head>

    <body>

       <!--All Rights Reserved By Salad's Di Gi Charat Fan Page-->
       <div></div>
       <div align="left">
             <!--�T�C�g�J��4���N�L�O�o�i�[�ǉ�@20070804-->
             <a href="../" target="_self"><img src="../dejiko_rahu8_banner.png" border="2" alt="4th&nbsp;Anniversary" title="4th&nbsp;Anniversary" onmouseover="javascript:this.style.borderColor='pink';" onmouseout="javascript:this.style.borderColor='skyblue';" /></a>
             <!--�T�C�g�J��4���N�L�O�o�i�[�ǉ�@20070804-->

             <!--��T���_�̓��L��Yahoo!�u���O��o�i�[�ǉ�@20070421-->
             <a href="http://blogs.yahoo.co.jp/chocola_blancmanche10" target="_blank"><img src="../banner_Yahooblog.png" border="2" alt="�T���_�̓��L��Yahoo!�u���O" title="�T���_�̓��L��Yahoo!�u���O" onmouseover="javascript:this.style.borderColor='pink';" onmouseout="javascript:this.style.borderColor='skyblue';" /></a>
             <!--��T���_�̓��L��Yahoo!�u���O��o�i�[�ǉ�@20070421-->

       </div>
       <div align="center">
         <strong title="�T���_�̓��L��Yahoo!�u���O">
             TwitterBot(�T�X�y���h�t�H�����[����)
         </strong>
       </div>
       <div class="d30"></div>
       <div align="center">
         <strong>
         	<tt>
			�@<a href="./" title="&gt;&gt;&gt;�g�b�v��" target="_self">&gt;&gt;&gt;�g�b�v��</a>
			�@&nbsp;&nbsp;
			�@&nbsp;&nbsp;
			�@<a href="logout.php" title="&gt;&gt;&gt;���O�A�E�g" target="_self">&gt;&gt;&gt;���O�A�E�g</a>
         	</tt>
         </strong>
       </div>
       <center>
             <img src="http://www.geocities.co.jp/pictures/icons/lines/string_tape_line.gif" alt="image" />
       </center>
       <div style="height:50px;"></div>
       <table border="0" cellpadding="0" cellspacing="0" summary="���L�{��" lang="ja" width="100%">
             <tbody>
				<tr>
					<td align="center">
					</td>
				</tr>
             </tbody>
       </table>
       <div style="height:25px;"></div>
       <table border="0" cellpadding="5" cellspacing="0" width="1200">
       		<tr>
       			<td width="400" align="left">
       				<?php
       				/*
       					if ($frontFlg&&$okFlg){
       						echo "<strong><a href=\"TwitterSuspList.php?key=".($key-1)."\" title=\"�O�̃y�[�W��&lt;&lt;&lt;\">�O�̃y�[�W��&lt;&lt;&lt;</a></strong>";
       					}
       				*/
       				?>
       			</td>
       			<td width="400" align="center">
       				<?php
       				/*
       					if ($key>0){
       						echo "<strong><a href=\"TwitterSuspList.php\" title=\"�ŏ��̃y�[�W�֖߂�\">�ŏ��̃y�[�W�֖߂�</a></strong>";
       					}
       				*/
       				?>
       			</td>
       			<td width="400" align="right">
       				<?php
       				/*
       					if ($nextFlg&&$okFlg){
       						echo "<strong><a href=\"TwitterSuspList.php?key=".($key+1)."\" title=\"&gt;&gt;&gt;���̃y�[�W��\">&gt;&gt;&gt;���̃y�[�W��</a></strong>";
       					}
       				*/
       				?>
       			</td>
       		</tr>
       </table>
       <table id="htmlgrid" border="1" cellpadding="5" cellspacing="0" width="1200" style="border-style:solid;border-width:2px;border-color:#666666;background-color:#eeeeee;" class="persist-area">
       		<thead>
	       		<tr class="persist-header">
	       			<th style="background-color:#666666;color:white;" id="htmlgrid_1" class="ui-resizable">ID&nbsp;&nbsp;<div class="ui-resizable-handle ui-resizable-e" style=""></div></th>
	       			<th style="background-color:#666666;color:white;">���[�U��</th>
	       			<th style="background-color:#666666;color:white;">�ŏI�`�F�b�N��</th>
	       			<th style="background-color:#666666;color:white;">���f�σt���O</th>
	       			<th style="background-color:#666666;color:white;">���̃��[�U�̏󋵂��m�F����</th>
	       		</tr>
       		</thead>
       		<tbody>
       <?php

			
			if ($okFlg){
				for ($i=0;isset($batchObj->ITEM[$i]);$i++){
					print("<tr id=\"R".($i+1)."\">");
					print("<td>".$batchObj->ITEM[$i]->ID."</td>");
					print("<td>".$batchObj->ITEM[$i]->USER."</td>");
					print("<td>".$batchObj->ITEM[$i]->CHKDATE."</td>");
					print("<td>".$batchObj->ITEM[$i]->REFLECTFLG."</td>");
					print("<td><a href=\"TwitterSuspListDetail.php?user=".$batchObj->ITEM[$i]->USER."&id=".$batchObj->ITEM[$i]->ID."\" target=\"_self\">�m�F</a></td>");
					print("</tr>");
				}
			}//Send API OK
			else {
				print("<tr><td colspan=\"7\" align=\"center\"><strong style=\"color:red;\">��O���������܂����B(�����F".(string)$batchObj->EXCEPTION.")</strong></td></tr>");
			}//��O������

       ?>
       		</tbody>
       </table>
       <table border="0" width="1200">
       		<tr>
       			<td align="right">
       				<strong>�VID:</strong><input type="text" size="20" id="insertarow_id" />
       				<button style="background-color:blue;color:white;padding:3px;font-weight:bold;width:100px;" id="insertarow">�{</button>
       			</td>
       		</tr>
       </table>
       <!-- When models change, we will display logs in this space. -->
       <div id="message"></div>
    </body>
</html>
