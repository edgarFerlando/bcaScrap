<?php
date_default_timezone_set('Asia/Jakarta');
require "vendor/autoload.php";
require_once('BCAScraper.php');
use PHPHtmlParser\Dom;
while(1){//Looping forever
    $USERNAME = "";
    $PASSWORD = "";
    $conn="";
    $conn = pg_connect("host=localhost port=5432 dbname=mylife user=postgres password=085sandycm");
    //TODO - Get 1 ibank account with the latest late updated_at from bank_accounts table;
    /*========*/
    $sql = "SELECT * FROM bank_accounts WHERE bank_code='bca' AND status NOT LIKE 'failed' ORDER BY updated_at ASC LIMIT 1";
    $result = pg_query($conn, $sql);
    if(!$result) {
        echo pg_last_error($db);
        continue;
    }
    while($row = pg_fetch_array($result)){
        echo $row['id'].", ".$row['ibank_uid'].", ".$row['ibank_pin'];
        $USER_ID = $row['user_id'];
        $USERNAME = $row['ibank_uid'];
        $PASSWORD = $row['ibank_pin'];
        $UPDATED_AT = $row['updated_at'];
        $IS_FIRST_TIME = $row['is_first_time'];
        $STATUS = $row['status'];
        $date = date('Y-m-d H:i:s', time());
        //TODO: check if ($now - $row['updated_at']) < 1 minutes: continue;
        $date_now = strtotime($date);
        $from_time = strtotime($UPDATED_AT);
        $difference_minute=round(abs($date_now - $from_time) / 60,2);//. " minute";

        if($difference_minute>1){
            //TODO - Get Last CS from database
            $query = "SELECT * FROM bank_statements WHERE user_id = $USER_ID ORDER BY id DESC LIMIT 1";
            $exec_db = pg_query($query);
            $myrow = pg_fetch_assoc($exec_db);
            $checksum = $myrow["cs"];
            //TODO - Query Update status
            $query_update_status_failed = "UPDATE bank_accounts SET status='failed' WHERE id=".$row['id'];
            $query_update_status_connected = "UPDATE bank_accounts SET status='connected' WHERE id=".$row['id'];
            /*Initiate update statement*/
            $update_updated_at_query = "UPDATE bank_accounts SET updated_at='".$date."' WHERE id=".$row['id'];
            $klikbca = new BCAScraper();
            $klikbca->username = $USERNAME;
            $klikbca->password = $PASSWORD;
            $res = $klikbca->login();
            if (!$res) {
                //TODO: Send email warning or Alert to Slack
                echo "\n================\ERROR on LOGIN.================\n";
                //echo $klikbca->last_html;
                pg_query($conn, $query_update_status_failed);
                pg_query($conn, $update_updated_at_query);
                $klikbca->logout();
                continue;
            }
            $today = date('Y-m-d', time());
            $monthStart = date('Y-m-01', time());
            if($IS_FIRST_TIME==null) {
                //TODO:Get Data 2 Month ago
                $res = $klikbca->get_mutasi_month(2);
                $html_response = $klikbca->last_html;
                $array = $klikbca->dom_parse($html_response, $row['id'], 2);
                $return = $klikbca->insert($array,$row['id'], $USER_ID);
                //TODO:Get Data 1 Month ago
                $res = $klikbca->get_mutasi_month(1);
                $html_response = $klikbca->last_html;
                $array = $klikbca->dom_parse($html_response, $row['id'], 1);
                $return = $klikbca->insert($array, $row['id'], $USER_ID);


                //TODO:Get Data 1 Month - today
                $res = $klikbca->get_mutasi($monthStart, $today);
                $html_response = $klikbca->last_html;
                $array = $klikbca->dom_parse($html_response, $row['id'], 0);
                $return = $klikbca->insert($array, $row['id'], $USER_ID);
                $update_isfirsttime_query = "UPDATE bank_accounts SET is_first_time='0' WHERE id=".$row['id'];
                pg_query($conn, $update_isfirsttime_query);
                pg_query($conn, $query_update_status_connected);
            }else{
                $res = $klikbca->get_mutasi($today,$today);
                $html_response = $klikbca->last_html;
                $array = $klikbca->dom_parse($html_response, $row['id'], 0);
                $return = $klikbca->insertForToday($array,$row['id'], $USER_ID, $checksum);
            }

            if (!$res) {
                //TODO: Send email warning or Alert to Slack
                echo "\n================\ERROR on GETTING ACCOUNT STATEMENTS.================\n";
                //echo $klikbca->last_html;
                pg_query($conn, $update_updated_at_query);
                $logouts=$klikbca->logout();
                continue;
            }
        }
        else{
            echo " Selisih dibawah 1 menit - ".$difference_minute."\n";
            continue;
        }
        pg_query($conn, $update_updated_at_query);
        $logouts=$klikbca->logout();
    }

    //exit;
}