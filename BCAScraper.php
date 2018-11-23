<?php
/*
Author      : FUNDtastic.co.id
*/
use PHPHtmlParser\Dom;
define('URL_LOGIN', 'https://ibank.klikbca.com/authentication.do');
define('URL_SALDO', 'https://ibank.klikbca.com/balanceinquiry.do');
// define('URL_MUTASI_INDEX', 'https://ibank.klikbca.com/accountstmt.do?value(actions)=acct_stmt');
// define('URL_MUTASI_VIEW', 'https://ibank.klikbca.com/accountstmt.do?value(actions)=acctstmtview');
// define('URL_MUTASI_DOWNLOAD', 'https://ibank.klikbca.com/stmtdownload.do?value(actions)=account_statement');
// define('URL_HISTORY', 'https://ibank.klikbca.com/history.do');
define('URL_ACCOUNT_STATEMENT', 'https://ibank.klikbca.com/accountstmt.do?value(actions)=acctstmtview'); //POST
define('URL_LOGOUT', 'https://ibank.klikbca.com/authentication.do?value(actions)=logout'); //POST
define('REMOTE_ADDR', '::1');
define('USER_AGENT', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36');
class BCAScraper {
    var $ch = false;
    var $ip = '';
    var $last_html = '';
    var $logged_in = false;
    var $password = '';
    var $username = '';
    // var $start_date = '24';
    // var $end_date = ;
    var $startDt = '';
    var $startMt = '';
    var $startYr = '';
    var $endDt = '';
    var $endMt = '';
    var $endYr = '';
    function BCAScraper() {
        //$this->ip = $_SERVER['REMOTE_ADDR'];
        $this->ip = REMOTE_ADDR;
        $this->logged_in = false;
    }
    function cek_saldo() {
        if ($this->logged_in == false) {
            trigger_error('LOGIN FIRST', E_USER_WARNING);
            return false;
        }
        $res = $this->my_curl_get(URL_SALDO);
        $this->last_html = $res['response'];
        // echo "\n========== CEK-SALDO START ==========\n";
        // echo $this->last_html;
        // echo "========== CEK-SALDO END ==========\n";
        //preg_match_all('/color=\"\#0000bb\"\>([ ]+)?([0-9\,]+)/i', $res['response'], $match);
        //echo '<pre>';print_r($match);echo '</pre>';
        return true;
    }
    function get_mutasi($start_date, $end_date) {
        $start_from = date_parse($start_date);
        $end_at = date_parse($end_date);
        //On ibank website: Informasi Rekening -> Mutasi Rekening
        if ($this->logged_in == false) {
            trigger_error('LOGIN FIRST', E_USER_WARNING);
            return false;
        }
        $data = array(
            'value(D1)' => '0',
            'value(r1)' => '1',
            'value(startDt)' => $start_from['day'],
            'value(startMt)' => $start_from['month'],
            'value(startYr)' => $start_from['year'],
            'value(endDt)' => $end_at['day'],
            'value(endMt)' => $end_at['month'],
            'value(endYr)' => $end_at['year'],
            'value(fDt)' => '',
            'value(tDt)' => '',
            'value(submit1)' => 'Lihat Mutasi Rekening'
        );
        $data = http_build_query($data);
        $res = $this->my_curl_post(URL_ACCOUNT_STATEMENT, $data);
        $this->last_html = $res['response'];
        // echo "\n========== MUTASI START ==========\n";
        // echo $this->last_html;
        // echo "========== MUTASI END ==========\n";
        //TODO: Check if the header status code on response header is not 200.
        //On error return FALSE and set last_html as html error from ibank.
        $this->logged_in = true;
        return true;
    }
    function get_mutasi_month($month) {
        //$months = date_parse($month);
        //On ibank website: Informasi Rekening -> Mutasi Rekening
        if ($this->logged_in == false) {
            trigger_error('LOGIN FIRST', E_USER_WARNING);
            return false;
        }
        $data = array(
            'value(D1)' => '0',
            'value(r1)' => '2',
            //'value(startDt)' => $months['day'],
            'value(x)' => $month,
            //'value(startYr)' => $months['year'],
            'value(fDt)' => '',
            'value(tDt)' => '',
            'value(submit1)' => 'Lihat Mutasi Rekening'
        );
        $data = http_build_query($data);
        $res = $this->my_curl_post(URL_ACCOUNT_STATEMENT, $data);
        $this->last_html = $res['response'];
        // echo "\n========== MUTASI START ==========\n";
        // echo $this->last_html;
        // echo "========== MUTASI END ==========\n";
        //TODO: Check if the header status code on response header is not 200.
        //On error return FALSE and set last_html as html error from ibank.
        $this->logged_in = true;
        return true;
    }
    function login() {
        $this->logged_in = false;
        $data = array(
            'value(actions)' => 'login',
            'value(user_id)' => $this->username,
            'value(user_ip)' => $this->ip,
            'value(pswd)' => $this->password,
            'value(Submit)' => 'LOGIN'
        );
        $data = http_build_query($data);
        $res = $this->my_curl_post(URL_LOGIN, $data);
        $this->last_html = $res['response'];
        // echo "\n========== LOGIN START ==========\n";
        // echo $this->last_html;
        // echo "========== LOGIN END ==========\n";
        if (preg_match('/value\(user_id\)/i', $res['response'])) {
            trigger_error('CAN NOT LOGIN TO KLIKBCA', E_USER_WARNING);
            return false;
        }
        $this->logged_in = true;
        return true;
    }
    function logout() {
        $this->logged_in = false;
        $data = array();
        $data = http_build_query($data);
        $res = $this->my_curl_post(URL_LOGOUT, $data);
        $this->last_html = $res['response'];
        // echo "\n========== LOGOUT START ==========\n";
        // echo $this->last_html;
        // echo "========== LOGOUT END ==========\n";
        // if (preg_match('/value\(user_id\)/i', $res['response'])) {
        //     trigger_error('CAN NOT LOGIN TO KLIKBCA', E_USER_WARNING);
        //     return false;
        // }
        $this->logged_in = true;
        return true;
    }
    function my_curl_close() {
        if ($this->ch != false) {
            curl_close($this->ch);
        }
    }
    function my_curl_get($url, $ref = '') {
        if ($this->ch == false) {
            $this->my_curl_open();
        }
        $ssl = false;
        if (preg_match('/^https/i', $url)) {
            $ssl = true;
        }
        if ($ssl) {
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        }
        if ($ref == '') {
            $ref = $url;
        }
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_REFERER, $ref);
        $res = curl_exec($this->ch);
        $info = curl_getinfo($this->ch);
        return array(
            'response' => trim($res),
            'info' => $info
        );
    }
    function my_curl_open() {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_MAXREDIRS, 2);
        curl_setopt($this->ch, CURLOPT_COOKIEFILE, dirname(__FILE__).'/curl-cookie.txt');
        curl_setopt($this->ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/curl-cookie.txt');
        //curl_setopt($this->ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($this->ch, CURLOPT_USERAGENT, USER_AGENT);
    }
    function my_curl_post($url, $post_data, $ref = '') {
        if ($this->ch == false) {
            $this->my_curl_open();
        }
        $ssl = false;
        if (preg_match('/^https/i', $url)) {
            $ssl = true;
        }
        if ($ssl) {
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        }
        if ($ref == '') {
            $ref = $url;
        }
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_REFERER, $ref);
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post_data);
        $res = curl_exec($this->ch);
        $info = curl_getinfo($this->ch);
        return array(
            'response' => trim($res),
            'info' => $info
        );
    }


    function dom_parse($html_response, $id, $prev_month){
        $date = date('Y-m-d H:i:s', time());
        $update_updated_at_query = "UPDATE bank_accounts SET updated_at='".$date."' WHERE id=".$id;
        $dom = new Dom;
        $dom->load($html_response);
        $table = $dom->find('table',3);
        $tr = $table->find('tr')[1];        //TABLE 3 TR 2
        $td = $tr->find('td table');        //TABLE 3 TR 2 TD 1 TABLE 1
        $tr_list = $td->find('tr');  //TABLE 3 TR 2 TD 1 TABLE 1 TR 2

        $array_data=[];
        $transaction_dates=[];
        $transaction_descriptions=[];
        $transaction_branchs=[];
        $transaction_amounts=[];
        $transaction_types=[];
        $transaction_balances=[];
        if(count($tr_list) < 2){
            pg_query($update_updated_at_query);
            echo "\nWARNING: on user:".$id." no bank_statement.</br>";
            $this->logout();
            //continue;
        } else {

            $i=0;
            foreach($tr_list as $tr) {
                if ($i == 0) {
                    $i++;
                    continue;
                }

                echo "</br>#" . $i . "--------------------------\n</br>";

                $tds = $tr->find('td');
                $j = 0;

                $transaction_date = "";
                $transaction_description = "";
                $transaction_branch = "";
                $transaction_amount = "";
                $transaction_type = "";
                $transaction_balance = "";

                foreach ($tds as $td) {
                    $val = $td->find('div font')->innerHtml;
                    if ($j == 0) {
                        $val = str_replace(" ", "", $val);
                        //$transaction_date = DateTime::createFromFormat('d/m', $val)->format('Y-m-d H:i:s');
                        $current_month = date("n", strtotime($date));
                        $year = date("Y", strtotime($date));
                        if($prev_month == 2 && $current_month == 1){
                            //$current_month = 11;
                            $year = $year - 1;
                            $transaction_dates = DateTime::createFromFormat('d/m'.'Y', $val.$year)->format('Y-m-d H:i:s');
                        }
                        if ($prev_month == 1 && $current_month == 1) {
                            //$current_month = 12;
                            $year = $year - 1;
                            $transaction_dates = DateTime::createFromFormat('d/m'.'Y', $val.$year)->format('Y-m-d H:i:s');
                        }
                        $transaction_date = DateTime::createFromFormat('d/m', $val)->format('Y-m-d H:i:s');
                    }
                    if ($j == 1) {
                        $val = str_replace("'", "", $val);
                        $transaction_description = addslashes ($val);
                    }
                    if ($j == 2) {
                        $transaction_branch = $val;
                    }
                    if ($j == 3) {
                        $transaction_amount = str_replace(',', '', $val);
                    }
                    if ($j == 4) {
                        $val = str_replace(' ', '', $val);
                        $type = ($val == 'CR' ? 'credit' : 'debit');
                        $transaction_type = $type;
                    }
                    if ($j == 5) {
                        $transaction_balance = str_replace(',', '', $val);
                    }
                    $j++;

                }
                $str = $transaction_description . $transaction_branch . $transaction_amount . $transaction_type . $transaction_balance;
                $str_md5 = md5($str);
                $array_data[] = $str_md5;
                $transaction_dates[]=$transaction_date;
                $transaction_descriptions[]=$transaction_description;
                $transaction_branchs[]=$transaction_branch;
                $transaction_amounts[]=$transaction_amount;
                $transaction_types[]=$transaction_type;
                $transaction_balances[]=$transaction_balance;

                $i++;
                //          }
            }
        }
        return $array = array( 'array_data' => $array_data,
            'transaction_dates' => $transaction_dates,
            'transaction_descriptions' => $transaction_descriptions,
            'transaction_branchs' => $transaction_branchs,
            'transaction_amounts' => $transaction_amounts,
            'transaction_types' => $transaction_types,
            'transaction_balances' => $transaction_balances );
    }
    function insert($array,$id, $USER_ID){
        $date = date('Y-m-d H:i:s', time());
        $update_updated_at_query = "UPDATE bank_accounts SET updated_at='".$date."' WHERE id=$id";
        $arrlength = count($array['array_data']);
        $value_db='';
        $sql = "INSERT INTO bank_statements (user_id, created_at, bank_code_name, transaction_type, transaction_description, transaction_date, transaction_branch, transaction_amount, transaction_balance, cs) VALUES";
        for($x = 0; $x < $arrlength ; $x++) {
            $array_data = $array['array_data'][$x];
            $transaction_dates = $array['transaction_dates'][$x];
            $transaction_descriptions = $array['transaction_descriptions'][$x];
            $transaction_branchs = $array['transaction_branchs'][$x];
            $transaction_amounts = $array['transaction_amounts'][$x];
            $transaction_types = $array['transaction_types'][$x];
            $transaction_balances = $array['transaction_balances'][$x];
            $value_db .= "($USER_ID, '$transaction_dates', 'bca', '$transaction_types', '$transaction_descriptions', '$transaction_dates', '$transaction_branchs', '$transaction_amounts', '$transaction_balances', '$array_data'),";
        }
        if($value_db != null) {
            if (substr($value_db, -1) == ',') {
                $value_db_str = substr($value_db, 0, -1);
            }
            pg_query($sql . $value_db_str);
        }
        pg_query($update_updated_at_query);
    }
    function insertForToday($array,$id,$USER_ID, $checksum){
        $date = date('Y-m-d H:i:s', time());
        $update_updated_at_query = "UPDATE bank_accounts SET updated_at='".$date."' WHERE id=$id";
        $arrlength = count($array['array_data']);

        $value_db='';
        $sql = "INSERT INTO bank_statements (user_id, created_at, bank_code_name, transaction_type, transaction_description, transaction_date, transaction_branch, transaction_amount, transaction_balance, cs) VALUES";
        for($x = 0; $x < $arrlength ; $x++) {
            if($checksum == $array['array_data'][$x]){
                $y=$x+1;
                for ($i=$y; $i<$arrlength; $i++){
                    if($checksum != $array['array_data'][$i]) {
                        $array_data = $array['array_data'][$i];
                        $transaction_dates = $array['transaction_dates'][$i];
                        $transaction_descriptions = $array['transaction_descriptions'][$i];
                        $transaction_branchs = $array['transaction_branchs'][$i];
                        $transaction_amounts = $array['transaction_amounts'][$i];
                        $transaction_types = $array['transaction_types'][$i];
                        $transaction_balances = $array['transaction_balances'][$i];
                        $value_db .= "($USER_ID, '$transaction_dates', 'bca', '$transaction_types', '$transaction_descriptions', '$transaction_dates', '$transaction_branchs', '$transaction_amounts', '$transaction_balances', '$array_data'),";
                    }
                }
                //die();
            }
            else if($checksum==null){
                $array_data = $array['array_data'][$x];
                $transaction_dates = $array['transaction_dates'][$x];
                $transaction_descriptions = $array['transaction_descriptions'][$x];
                $transaction_branchs = $array['transaction_branchs'][$x];
                $transaction_amounts = $array['transaction_amounts'][$x];
                $transaction_types = $array['transaction_types'][$x];
                $transaction_balances = $array['transaction_balances'][$x];
                $value_db .= "($USER_ID, '$transaction_dates', 'bca', '$transaction_types', '$transaction_descriptions', '$transaction_dates', '$transaction_branchs', '$transaction_amounts', '$transaction_balances', '$array_data'),";
            }
        }
        if($value_db != null) {
            if (substr($value_db, -1) == ',') {
                $value_db_str = substr($value_db, 0, -1);
            }
            pg_query($sql . $value_db_str);
        }
        pg_query($update_updated_at_query);
    }
} ?>