<?php 
// Assuming you installed from Composer:
require "vendor/autoload.php";
use PHPHtmlParser\Dom;

$dom = new Dom;
$dom->load('
<HTML>
<style type="text/css">
    <!-- .small {
        FONT-FAMILY: Arial, Helvetica, sans-serif;
        FONT-SIZE: 3pt;
        FONT-STYLE: normal
    }

    .aktif {
        COLOR: blue;
        FONT-SIZE: 9pt;
        FONT-FAMILY: Arial, Helvetica, sans-serif;
        FONT-STYLE: normal
    }

    A:active {
        COLOR: yellow;
    }

    A:hover {
        COLOR: yellow;
    }

    A:link {
        TEXT-DECORATION: none
    }

    A:visited {
        text-decoration: none;
    }

    -->
</style>
<script>
    var timerID = null;
    var timerRunning = false;
    var months = new Array(13);
    months[1] = "Jan";
    months[2] = "Feb";
    months[3] = "Mar";
    months[4] = "Apr";
    months[5] = "May";
    months[6] = "Jun";
    months[7] = "Jul";
    months[8] = "Aug";
    months[9] = "Sep";
    months[10] = "Oct";
    months[11] = "Nov";
    months[12] = "Dec";
    function stopclock() {
        if (timerRunning)
            clearTimeout(timerID);
        timerRunning = false;
    }
    function startclock() {
        xnow = new Date(/\'Jul 01, 2018 21:00:12/\');
        stopclock();
        showtime();
    }
    function showtime() {
        xnow.setSeconds(xnow.getSeconds() + 1);
        var lmonth = (((xnow.getMonth() + 1) < 10) ? "0" : "") + (xnow.getMonth() + 1);
        var date = ((xnow.getDate() < 10) ? "0" : "") + xnow.getDate();
        var year = xnow.getYear();
        if (year < 2000) year = year + 1900
        var hour = ((xnow.getHours() < 10) ? "0" : "") + xnow.getHours();
        var min = ((xnow.getMinutes() < 10) ? "0" : "") + xnow.getMinutes();
        var sec = ((xnow.getSeconds() < 10) ? "0" : "") + xnow.getSeconds();
        document.DateTime.document.write("<font face=verdana size=1 color=#000000>Tanggal : " + "&nbsp;" + months[xnow.getMonth() + 1] + "&nbsp;" + year + "           Jam : " + hour + ":" + min + ":" + sec + "</font>");
        timerID = setTimeout("showtime()", 900);
        timerRunning = true;
    }
    var ms = 0;
    function fncSetTimer() {
        ms = 0;
        then = new Date();
        then.setTime(then.getTime() - ms);
    }
    function fncTimer() {
        setTimeout("fncTimer();", 10000);
        ynow = new Date();
        ms = ynow.getTime() - then.getTime();
        if (ms >= 300000) {
            fncSetTimer();
            fncLogoff();
        }
        window.status = parseInt(ms / 1000) + " seconds idle";
    }
    function fncLogoff() {
        document.iBankForm.action = "sessionexpired.htm";
        document.iBankForm.submit();
    }
</script>

<body alink="white" link="white" vlink="white" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" bgcolor="#ffffff"
    onload="startclock();fncSetTimer();fncTimer();">
    <layer id="DateTime" left="25" top="12"></layer>
    <table border="0" cellpadding="0" cellspacing="0" width="590">
        <tr height="20" bgcolor="#e7d300">
            <td bgcolor="#e7d300" width="393">
                <font face="Verdana" size="2" color="#0000bb">&nbsp;
                </font>
            </td>
            <td width="25" bgcolor="#4a55b5">
                <img src="https://ibank.klikbca.com/images/latar1b.jpg;bca7548e41af5f81936">
            </td>
            <td width="100" bgcolor="#4a55b5" align="center" class="aktif"></td>
        </tr>
        <tr bgcolor="#4A55B5" height="2">
            <td colspan="3"></td>
        </tr>
    </table>

    <table border="0" cellpadding="1" cellspacing="0" width="590">
        <tr height="20">
            <td colspan="3" bgcolor="#8486de">
                <font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular" color="white">&nbsp;INFORMASI REKENING - MUTASI REKENING</font>
            </td>
        </tr>
        <tr>
            <td bgcolor="#FFFFFF" colspan=3></td>
        </tr>
        <tr>
            <td bgcolor="#FFFFFF" colspan=3></td>
        </tr>
    </table>

    <table border="0" cellpadding="0" cellspacing="0" width="590">
        <tr>
            <td colspan="2" align="center">
                <table border="0" width="90%" cellpadding="0" cellspacing="0" bordercolor="#f0f0f0">
                    <tr>
                        <td colspan="3">
                            <hr>
                        </td>
                    </tr>
                    <tr bgcolor="#e0e0e0">
                        <td width="35%">
                            <font face="Verdana" size="1" color="#0000bb">Nomor Rekening</font>
                        </td>
                        <td width="10">
                            <font face="Verdana" size="1" color="#0000bb"> : </font>
                        </td>
                        <td>
                            <font face="Verdana" size="1" color="#0000bb">6805081281</font>
                        </td>
                    </tr>
                    <tr bgcolor="#f0f0f0">
                        <td width="35%">
                            <font face="Verdana" size="1" color="#0000bb">Nama</font>
                        </td>
                        <td width="10">
                            <font face="Verdana" size="1" color="#0000bb"> : </font>
                        </td>
                        <td>
                            <font face="Verdana" size="1" color="#0000bb">MICHAEL TOBBY SEMB</font>
                        </td>
                    </tr>
                    <tr bgcolor="#e0e0e0">
                        <td width="35%">
                            <font face="Verdana" size="1" color="#0000bb">Periode</font>
                        </td>
                        <td width="10">
                            <font face="Verdana" size="1" color="#0000bb"> : </font>
                        </td>
                        <td>
                            <font face="Verdana" size="1" color="#0000bb">24/06/2018 - 02/07/2018</font>
                        </td>
                    </tr>
                    <tr bgcolor="#f0f0f0">
                        <td width="35%">
                            <font face="Verdana" size="1" color="#0000bb">Mata Uang</font>
                        </td>
                        <td width="10">
                            <font face="Verdana" size="1" color="#0000bb"> : </font>
                        </td>
                        <td>
                            <font face="Verdana" size="1" color="#0000bb">IDR</font>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <hr>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table border="1" width="100%" cellpadding="0" cellspacing="0" bordercolor="#ffffff">
                    <tr>
                        <td width="30" bgcolor="e0e0e0">
                            <div align="left">
                                <font face="Verdana" size="1" color="#0000bb">
                                    <b>Tgl.</b>
                                </font>
                            </div>
                        </td>
                        <td width="130" bgcolor="e0e0e0">
                            <div align="left">
                                <font face="Verdana" size="1" color="#0000bb">
                                    <b>Keterangan</b>
                                </font>
                            </div>
                        </td>
                        <td width="30" bgcolor="e0e0e0">
                            <div align="center">
                                <font face="Verdana" size="1" color="#0000bb">
                                    <b>Cab.</b>
                                </font>
                            </div>
                        </td>
                        <td width="" bgcolor="e0e0e0" colspan="2">
                            <div align="right">
                                <font face="Verdana" size="1" color="#0000bb">
                                    <b>Mutasi</b>
                                </font>
                            </div>
                        </td>
                        <td width="" bgcolor="e0e0e0">
                            <div align="right">
                                <font face="Verdana" size="1" color="#0000bb">
                                    <b>Saldo</b>
                                </font>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="30" bgcolor="#e0e0e0">
                            <div align="left">
                                <font face="verdana" size="1" color="#0000bb">
                                    25/06</font>
                            </div>
                        </td>
                        <td width="130" bgcolor="#e0e0e0">
                            <div align="left">
                                <font face="verdana" size="1" color="#0000bb">
                                    TRSF E-BANKING CR
                                    <br>06/25 95031
                                    <br>BEER GARDEN NICKY
                                    <br>NICKY AGUSTIN KAST
                                    <br>
                                </font>
                            </div>
                        </td>
                        <td width="30" bgcolor="#e0e0e0">
                            <div align="center">
                                <font face="verdana" size="1" color="#0000bb">
                                    0000</font>
                            </div>
                        </td>
                        <td width="" bgcolor="#e0e0e0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    327,000.00</font>
                            </div>
                        </td>
                        <td width="10" bgcolor="#e0e0e0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    CR</font>
                            </div>
                        </td>
                        <td width="" bgcolor="#e0e0e0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    22,176,471.14</font>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="30" bgcolor="#f0f0f0">
                            <div align="left">
                                <font face="verdana" size="1" color="#0000bb">
                                    25/06</font>
                            </div>
                        </td>
                        <td width="130" bgcolor="#f0f0f0">
                            <div align="left">
                                <font face="verdana" size="1" color="#0000bb">
                                    TRSF E-BANKING CR
                                    <br>2506/FTSCY/WS95051
                                    <br> 19500000.00
                                    <br>Payroll Juni 2018
                                    <br>CHANDHARWEALTH MAN
                                    <br>
                                </font>
                            </div>
                        </td>
                        <td width="30" bgcolor="#f0f0f0">
                            <div align="center">
                                <font face="verdana" size="1" color="#0000bb">
                                    0000</font>
                            </div>
                        </td>
                        <td width="" bgcolor="#f0f0f0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    19,500,000.00</font>
                            </div>
                        </td>
                        <td width="10" bgcolor="#f0f0f0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    CR</font>
                            </div>
                        </td>
                        <td width="" bgcolor="#f0f0f0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    41,676,471.14</font>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="30" bgcolor="#e0e0e0">
                            <div align="left">
                                <font face="verdana" size="1" color="#0000bb">
                                    27/06</font>
                            </div>
                        </td>
                        <td width="130" bgcolor="#e0e0e0">
                            <div align="left">
                                <font face="verdana" size="1" color="#0000bb">
                                    TRSF E-BANKING DB
                                    <br>06/27 95031
                                    <br>1806271216
                                    <br>REKSA DANA SUCORIN
                                    <br>
                                </font>
                            </div>
                        </td>
                        <td width="30" bgcolor="#e0e0e0">
                            <div align="center">
                                <font face="verdana" size="1" color="#0000bb">
                                    0000</font>
                            </div>
                        </td>
                        <td width="" bgcolor="#e0e0e0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    100,000.00</font>
                            </div>
                        </td>
                        <td width="10" bgcolor="#e0e0e0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    DB</font>
                            </div>
                        </td>
                        <td width="" bgcolor="#e0e0e0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    41,576,471.14</font>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="30" bgcolor="#f0f0f0">
                            <div align="left">
                                <font face="verdana" size="1" color="#0000bb">
                                    27/06</font>
                            </div>
                        </td>
                        <td width="130" bgcolor="#f0f0f0">
                            <div align="left">
                                <font face="verdana" size="1" color="#0000bb">
                                    TRSF E-BANKING CR
                                    <br>27/06 WSID:183K1
                                    <br>SILVIA ANDRIYANI
                                    <br>
                                </font>
                            </div>
                        </td>
                        <td width="30" bgcolor="#f0f0f0">
                            <div align="center">
                                <font face="verdana" size="1" color="#0000bb">
                                    0000</font>
                            </div>
                        </td>
                        <td width="" bgcolor="#f0f0f0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    454,100.00</font>
                            </div>
                        </td>
                        <td width="10" bgcolor="#f0f0f0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    CR</font>
                            </div>
                        </td>
                        <td width="" bgcolor="#f0f0f0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    42,030,571.14</font>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="30" bgcolor="#e0e0e0">
                            <div align="left">
                                <font face="verdana" size="1" color="#0000bb">
                                    29/06</font>
                            </div>
                        </td>
                        <td width="130" bgcolor="#e0e0e0">
                            <div align="left">
                                <font face="verdana" size="1" color="#0000bb">
                                    TRSF E-BANKING DB
                                    <br>06/29 95031
                                    <br>BURGER KING
                                    <br>JAMALULLAIL
                                    <br>
                                </font>
                            </div>
                        </td>
                        <td width="30" bgcolor="#e0e0e0">
                            <div align="center">
                                <font face="verdana" size="1" color="#0000bb">
                                    0000</font>
                            </div>
                        </td>
                        <td width="" bgcolor="#e0e0e0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    66,000.00</font>
                            </div>
                        </td>
                        <td width="10" bgcolor="#e0e0e0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    DB</font>
                            </div>
                        </td>
                        <td width="" bgcolor="#e0e0e0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    41,964,571.14</font>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="30" bgcolor="#f0f0f0">
                            <div align="left">
                                <font face="verdana" size="1" color="#0000bb">
                                    29/06</font>
                            </div>
                        </td>
                        <td width="130" bgcolor="#f0f0f0">
                            <div align="left">
                                <font face="verdana" size="1" color="#0000bb">
                                    TRSF E-BANKING DB
                                    <br>06/29 95031
                                    <br>JAYA PUB
                                    <br>JANESA MARK VICTOR
                                    <br>
                                </font>
                            </div>
                        </td>
                        <td width="30" bgcolor="#f0f0f0">
                            <div align="center">
                                <font face="verdana" size="1" color="#0000bb">
                                    0000</font>
                            </div>
                        </td>
                        <td width="" bgcolor="#f0f0f0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    282,000.00</font>
                            </div>
                        </td>
                        <td width="10" bgcolor="#f0f0f0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    DB</font>
                            </div>
                        </td>
                        <td width="" bgcolor="#f0f0f0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    41,682,571.14</font>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="30" bgcolor="#e0e0e0">
                            <div align="left">
                                <font face="verdana" size="1" color="#0000bb">
                                    29/06</font>
                            </div>
                        </td>
                        <td width="130" bgcolor="#e0e0e0">
                            <div align="left">
                                <font face="verdana" size="1" color="#0000bb">
                                    TRSF E-BANKING DB
                                    <br>06/29 95031
                                    <br>BURGER
                                    <br>LULU HASNA
                                    <br>
                                </font>
                            </div>
                        </td>
                        <td width="30" bgcolor="#e0e0e0">
                            <div align="center">
                                <font face="verdana" size="1" color="#0000bb">
                                    0000</font>
                            </div>
                        </td>
                        <td width="" bgcolor="#e0e0e0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    70,000.00</font>
                            </div>
                        </td>
                        <td width="10" bgcolor="#e0e0e0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    DB</font>
                            </div>
                        </td>
                        <td width="" bgcolor="#e0e0e0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    41,612,571.14</font>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="30" bgcolor="#f0f0f0">
                            <div align="left">
                                <font face="verdana" size="1" color="#0000bb">
                                    30/06</font>
                            </div>
                        </td>
                        <td width="130" bgcolor="#f0f0f0">
                            <div align="left">
                                <font face="verdana" size="1" color="#0000bb">
                                    BUNGA
                                    <br>
                                </font>
                            </div>
                        </td>
                        <td width="30" bgcolor="#f0f0f0">
                            <div align="center">
                                <font face="verdana" size="1" color="#0000bb">
                                    0000</font>
                            </div>
                        </td>
                        <td width="" bgcolor="#f0f0f0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    9,553.35</font>
                            </div>
                        </td>
                        <td width="10" bgcolor="#f0f0f0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    CR</font>
                            </div>
                        </td>
                        <td width="" bgcolor="#f0f0f0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    41,622,124.49</font>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="30" bgcolor="#e0e0e0">
                            <div align="left">
                                <font face="verdana" size="1" color="#0000bb">
                                    30/06</font>
                            </div>
                        </td>
                        <td width="130" bgcolor="#e0e0e0">
                            <div align="left">
                                <font face="verdana" size="1" color="#0000bb">
                                    PAJAK BUNGA
                                    <br>
                                </font>
                            </div>
                        </td>
                        <td width="30" bgcolor="#e0e0e0">
                            <div align="center">
                                <font face="verdana" size="1" color="#0000bb">
                                    0000</font>
                            </div>
                        </td>
                        <td width="" bgcolor="#e0e0e0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    1,910.67</font>
                            </div>
                        </td>
                        <td width="10" bgcolor="#e0e0e0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    DB</font>
                            </div>
                        </td>
                        <td width="" bgcolor="#e0e0e0">
                            <div align="right">
                                <font face="verdana" size="1" color="#0000bb">
                                    41,620,213.82</font>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table border="0" width="70%" cellpadding="0" cellspacing="0" bordercolor="#ffffff">
                    <tr>
                        <td colspan="3">
                            <hr>
                        </td>
                    </tr>
                    <tr bgcolor="#e0e0e0">
                        <td width="35%">
                            <font face="Verdana" size="1" color="#0000bb">Saldo Awal</font>
                        </td>
                        <td width="10">
                            <font face="Verdana" size="1" color="#0000bb"> : </font>
                        </td>
                        <td align="right">
                            <font face="Verdana" size="1" color="#0000bb">21,849,471.14</font>
                        </td>
                    </tr>
                    <tr bgcolor="#f0f0f0">
                        <td width="35%">
                            <font face="Verdana" size="1" color="#0000bb">Mutasi Kredit</font>
                        </td>
                        <td width="10">
                            <font face="Verdana" size="1" color="#0000bb"> : </font>
                        </td>
                        <td align="right">
                            <font face="Verdana" size="1" color="#0000bb">20,290,653.35</font>
                        </td>
                    </tr>
                    <tr bgcolor="#e0e0e0">
                        <td width="35%">
                            <font face="Verdana" size="1" color="#0000bb">Mutasi Debet</font>
                        </td>
                        <td width="10">
                            <font face="Verdana" size="1" color="#0000bb"> : </font>
                        </td>
                        <td align="right">
                            <font face="Verdana" size="1" color="#0000bb">519,910.67</font>
                        </td>
                    </tr>
                    <tr bgcolor="#f0f0f0">
                        <td width="35%">
                            <font face="Verdana" size="1" color="#0000bb">Saldo Akhir</font>
                        </td>
                        <td width="10">
                            <font face="Verdana" size="1" color="#0000bb"> : </font>
                        </td>
                        <td align="right">
                            <font face="Verdana" size="1" color="#0000bb">41,620,213.82</font>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <hr>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        </td>
        <form name="iBankForm" method="POST" action="/accountstmt.do">
        </form>

    </table>
    <table border="0" cellpadding="0" cellspacing="0" width="590" bordercolor="#ffffff">
        <tr height="25">
            <td valign="top">
                <span align="left">
                    <font size="1" face="Verdana" color="#f00000">
                        <b> </b>
                    </font>
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <hr color="#8486ce">
            </td>
        </tr>
    </table>
    <script language="javascript">
        function fncDoubleOut() {
            alert(/\'Transaksi Anda sedang di proses. Terima kasih/\');
            return false;
        }
    </script>
</body>

</html>
');

$table = $dom->find('table',3);
$tr = $table->find('tr')[1];        //TABLE 3 TR 2
$td = $tr->find('td table');        //TABLE 3 TR 2 TD 1 TABLE 1
$tr_list = $td->find('tr');  //TABLE 3 TR 2 TD 1 TABLE 1 TR 2


$i=0;
foreach($tr_list as $tr){
    if($i==0) {
        $i++;
        continue;
    }

    echo "#".$i."--------------------------\n";

    $tds = $tr->find('td');
    foreach($tds as $td){
        $val = $td->find('div font')->innerHtml;
        echo $val . "\n";
    }
    
    $i++;
}

// echo "\ntr_list: ".count($tr_list)."\n";
//echo $final_table->innerHTML();
?>