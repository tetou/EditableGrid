<?php

	//セッション開始
	session_start();

	//OKフラグ
	$okFlg=true;
	
	//次のページが存在するか？
	$nextFlg=true;
	
	//前のページが存在するか？
	$frontFlg=true;

	include("./conf/variableSetting.php");
	
	
	//ユーザ認証API
	$usrAuthAPI="http://chocola.moe.hm/Java/".$aplName."/Diary/Owner";
	
	//ログインできていない場合は、ログインページへリダイレクト

	if (!isset($_SESSION['nm'])||!isset($_SESSION['pw'])){
		header("Location: http://".$hostName.".moe.hm/".$test."site/diary_archive/admin/login.php");
	}

	//ログイン情報正常性チェック

	$usrAuthXml=simplexml_load_file($usrAuthAPI."?n=".htmlspecialchars($_SESSION['nm'],ENT_QUOTES));

	if ((string)$usrAuthXml->RESPONSE[0]->CODE=="OK"){
		if ((string)$usrAuthXml->RESPONSE[0]->PASSWORD!=$_SESSION['pw']){
			header("Location: http://".$hostName.".moe.hm/".$test."site/diary_archive/admin/login.php");
		}//パスワードが一致しない場合
	}
	else {
		header("Location: http://".$hostName.".moe.hm/".$test."site/diary_archive/admin/login.php");
	}

	//パラメータ設定
	$key=(isset($_GET['key']))?$_GET['key']:1;

	/********************API問い合わせ********************/
	//API
	$batchAPI="http://".$apiHostName."/Java/".$aplName."/Twitter/isSuspendedFriend?";
	
	//クエリ文字列作成
	$keyReal=10*($key-1);
	$batchQuery="num=".$keyReal;
	
	//問い合わせ
	$batchXml=simplexml_load_file($batchAPI.$batchQuery);
	$batchObj=$batchXml->RESPONSE[0];
	if ($batchObj->CODE=="OK"){
		$key_f=10*($key-2);
		$batchQuery_f="num=".$key_f;
		$batchXml_f=simplexml_load_file($batchAPI.$batchQuery_f);
		$batchXml_fObj=$batchXml_f->RESPONSE[0];
		if ($batchXml_fObj->CODE!="OK"){
			$frontFlg=false;
		}
		
		$key_n=10*$key;
		$batchQuery_n="num=".$key_n;
		$batchXml_n=simplexml_load_file($batchAPI.$batchQuery_n);
		$batchXml_nObj=$batchXml_n->RESPONSE[0];
		if ($batchXml_nObj->CODE!="OK"){
			$nextFlg=false;
		}
		
	}//正常なkeyの場合
	else {
		$okFlg=false;
	}//リクエスト失敗(0件またはエラー発生)

	/********************API問い合わせ********************/

?>
<html lang="ja">
    <head>
           <meta http-equiv="content-type" content="text/html;charset=Shift_JIS" />
           <meta http-equiv="content-style-type" content="text/css" />
	   	   <meta http-equiv="content-script-type" content="text/javascript" />
           <meta http-equiv="pragma" content="no-cache" />
           <meta name="author" content="Salad@Kani-Salad" />
           <meta name="description" content="サラダの日記" />
           <meta name="keywords" content="BROCCOLI,digicharat,galaxyangel,broccoli,Koge-Donbo,2008" />
           <meta name="generator" content="Notepad,TeraPad" />
           <meta name="reply-to" content="americachachacha@yahoo.co.jp" />
           <title>TwitterBot(サスペンドフォロワー検索)</title>
           <link rel="stylesheet" type="text/css" href="../diary1.css" />
	   	   <link rel="SHORTCUT ICON" href="http://www.geocities.jp/chocola_blancmanche10/favicon.ico" />
           <link rev="made" href="mailto:americachachacha@yahoo.co.jp" />       
    </head>
    <script type="text/javascript" src="./conf/editablegrid.js"></script>
    <script type="text/javascript" src="./conf/editablegrid_charts.js"></script>
    <script type="text/javascript" src="./conf/editablegrid_editors.js"></script>
    <script type="text/javascript" src="./conf/editablegrid_renderers.js"></script>
    <script type="text/javascript" src="./conf/editablegrid_utils.js"></script>
    <script type="text/javascript" src="./conf/editablegrid_validators.js"></script>
    <script type="text/javascript">
    	<!--
    		window.onload=function(){
				editableGrid = new EditableGrid("DemoGrid",{
					modelChanged: function(rowIdx, colIdx, oldValue, newValue, row){
						_$("message").innerHTML="rowIdx="+rowIdx+",colIdx="+colIdx+",oldValue="+oldValue+",newValue="+newValue+",row="+row;
					}
				}); 

				// we build and load the metadata in Javascript
				editableGrid.load(
					{ metadata: [
						{ name: "id", datatype: "integer", editable: false },
						{ name: "username", datatype: "string", editable: true },
						{ name: "lastymd", datatype: "string", editable: true },
						{ name: "reflectflg", datatype: "string", editable: true }
						//If you do not want to affect a cell by EditableGrid, then you should comment out the corresponding JSON object from the source.
						//{ name: "letuscheck", datatype: "string", editable: false }
					]}
				);

				// then we attach to the HTML table and render it
				editableGrid.attachToHTMLTable('htmlgrid');
				editableGrid.renderGrid();
    		}
    	//-->
    </script>
    <body>

       <!--All Rights Reserved By Salad's Di Gi Charat Fan Page-->
       <div></div>
       <div align="left">
             <!--サイト開設4周年記念バナー追加@20070804-->
             <a href="../" target="_self"><img src="../dejiko_rahu8_banner.png" border="2" alt="4th&nbsp;Anniversary" title="4th&nbsp;Anniversary" onmouseover="javascript:this.style.borderColor='pink';" onmouseout="javascript:this.style.borderColor='skyblue';" /></a>
             <!--サイト開設4周年記念バナー追加@20070804-->

             <!--｢サラダの日記＠Yahoo!ブログ｣バナー追加@20070421-->
             <a href="http://blogs.yahoo.co.jp/chocola_blancmanche10" target="_blank"><img src="../banner_Yahooblog.png" border="2" alt="サラダの日記＠Yahoo!ブログ" title="サラダの日記＠Yahoo!ブログ" onmouseover="javascript:this.style.borderColor='pink';" onmouseout="javascript:this.style.borderColor='skyblue';" /></a>
             <!--｢サラダの日記＠Yahoo!ブログ｣バナー追加@20070421-->

       </div>
       <div align="center">
         <strong title="サラダの日記＠Yahoo!ブログ">
             TwitterBot(サスペンドフォロワー検索)
         </strong>
       </div>
       <div class="d30"></div>
       <div align="center">
         <strong>
         	<tt>
			　<a href="./" title="&gt;&gt;&gt;トップへ" target="_self">&gt;&gt;&gt;トップへ</a>
			　&nbsp;&nbsp;
			　&nbsp;&nbsp;
			　<a href="logout.php" title="&gt;&gt;&gt;ログアウト" target="_self">&gt;&gt;&gt;ログアウト</a>
         	</tt>
         </strong>
       </div>
       <center>
             <img src="http://www.geocities.co.jp/pictures/icons/lines/string_tape_line.gif" alt="image" />
       </center>
       <div style="height:50px;"></div>
       <table border="0" cellpadding="0" cellspacing="0" summary="日記本文" lang="ja" width="100%">
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
       					if ($frontFlg&&$okFlg){
       						echo "<strong><a href=\"TwitterSuspList.php?key=".($key-1)."\" title=\"前のページへ&lt;&lt;&lt;\">前のページへ&lt;&lt;&lt;</a></strong>";
       					}
       				?>
       			</td>
       			<td width="400" align="center">
       				<?php
       					if ($key>0){
       						echo "<strong><a href=\"TwitterSuspList.php\" title=\"最初のページへ戻る\">最初のページへ戻る</a></strong>";
       					}
       				?>
       			</td>
       			<td width="400" align="right">
       				<?php
       					if ($nextFlg&&$okFlg){
       						echo "<strong><a href=\"TwitterSuspList.php?key=".($key+1)."\" title=\"&gt;&gt;&gt;次のページへ\">&gt;&gt;&gt;次のページへ</a></strong>";
       					}
       				?>
       			</td>
       		</tr>
       </table>
       <table id="htmlgrid" border="1" cellpadding="5" cellspacing="0" width="1200" style="border-style:solid;border-width:2px;border-color:#666666;background-color:#eeeeee;">
       		<tr>
       			<td style="background-color:#666666;color:white;">ID</td>
       			<td style="background-color:#666666;color:white;">ユーザ名</td>
       			<td style="background-color:#666666;color:white;">最終チェック日</td>
       			<td style="background-color:#666666;color:white;">反映済フラグ</td>
       			<td style="background-color:#666666;color:white;">このユーザの状況を確認する</td>
       		</tr>
       <?php

			
			if ($okFlg){
				for ($i=0;$batchObj->ITEM[$i];$i++){
					print("<tr id=\"R".($i+1)."\">");
					print("<td>".$batchObj->ITEM[$i]->ID."</td>");
					print("<td>".$batchObj->ITEM[$i]->USER."</td>");
					print("<td>".$batchObj->ITEM[$i]->CHKDATE."</td>");
					print("<td>".$batchObj->ITEM[$i]->REFLECTFLG."</td>");
					print("<td><a href=\"TwitterSuspListDetail.php?user=".$batchObj->ITEM[$i]->USER."&id=".$batchObj->ITEM[$i]->ID."\" target=\"_self\">確認</a></td>");
					print("</tr>");
				}
			}//Send API OK
			else {
				print("<tr><td colspan=\"7\" align=\"center\"><strong style=\"color:red;\">例外が発生しました。(原因：".(string)$batchObj->EXCEPTION.")</strong></td></tr>");
			}//例外発生時

       ?>
       </table>
       <!-- When models change, we will display logs in this space. -->
       <div id="message"></div>
    </body>
</html>
