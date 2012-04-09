<?php

/**
 * @author Martin Grulich
 * @copyright 2008 
 * @version 2.0 
 */

    class ts2{
        var $ts2_server;
        var $ts2_tcpqueryport;
        var $ts2_udpport;
        var $ts2_loginname;
        var $ts2_loginpassword;
        var $ts2_connection;
        var $ts2_error;

        function ts2($server = "none", $tcpqueryport = "none", $loginname = "none", $loginpassword = "none"){
            if($server != "none"){
                $this->ts2_server = $server;
            }
            if($tcpqueryport != "none"){
                $this->ts2_tcpqueryport = $tcpqueryport;
            }
            if($loginname != "none"){
                $this->ts2_loginname = $loginname;
            }
            if($loginpassword != "none"){
                $this->ts2_loginpassword = $loginpassword;
            }
        }

        /**
          * info_translateFlag: Translates given flags to arrays
          *
          * @param      integer	$vFlag	The given flag
          * @param		integer $fType	The type of the flag (1 - Player-Channel-Flag, 2 - Player-Server-Flag, 3 - Player-Player-Flag, 4 - Channel-Channel-Flag)
          * @param		boolean $oStr	Output as a string, if not as an array
          * @return     array array flags, false at failure
          */	
	function ts2_translateFlag($vFlag, $fType = 1, $oStr = false) {
		if ($fType != 1 && $fType != 2 && $fType != 3 && $fType != 4 && $fType != 5) return false;
		$decode = array();
		$decode[1] = array("CA", "O", "V", "AO", "AV");							//1 - See getPlayers() [11]
		$decode[2] = array("SA", "AR", "R", "", "ST");							//2 - See getPlayers() [12]
		$decode[3] = array("CC", "VR", "NW", "AW", "MM", "SM", "RC");			//3 - See getPlayers() [13]
		$decode[4] = array("U", "M", "P", "S", "D");							//4 - See getChannels() [7]
		$decode[5] = array("UU", "RU", "UC", "RC");								//5 - Internal for KickIdler
		$uDec = $decode[$fType];
		$cFlags = array();
		$cnt = 0;
		while ($vFlag > 0) {
			$nKey = $uDec[$cnt];
			$nVal = ($vFlag & 1 == 1) ? true : false;
			$cFlags[$nKey] = $nVal;
			$vFlag >>= 1;
			$cnt++;
		}
		foreach ($decode[$fType] as $val) {
			if (!isset($cFlags[$val]))
				$cFlags[$val] = false;
		}
		
		if (!$oStr)
			return $cFlags;
		
		$rFlag = array();
		if ($fType == 4 && !$cFlags["U"])
			$rFlag[] = "R";

		foreach ($cFlags as $key => $val) {
			if ($val)
				$rFlag[] = $key;
		}

        if($fType == 2){
            if(count($rFlag) == 0){
    		    $rFlag[] = "U";
                return implode(" ", $rFlag);
            } else {
                return implode(" ", $rFlag);
            }
        } else {
            return implode(" ", $rFlag);
        }
	}

        /**
         * @description check Server is available
         */
        function ts2_available(){
            $icmp_package = "\x08\x00\x19\x2f\x00\x00\x00\x00\x70\x69\x6e\x67";
            $socket = socket_create(AF_INET, SOCK_RAW, 1); 
            socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 1, "usec" => 0));
            socket_connect($socket, $this->ts2_server, null);
            socket_send($socket, $icmp_package, strlen($icmp_package), 0);
            if(@socket_read($socket, 255)) {
                socket_close($socket);
                return true;
            } else {
                $this->ts2_error = 'No reply from Server, maybe the Server is offline.';
                return false;
            }
        }

        /**
         * @description connect to TS2-Server
         */
        function ts2_connect(){
            $this->ts2_connection = @fsockopen($this->ts2_server, $this->ts2_tcpqueryport, &$errno, &$errstr, 2);
            if($this->ts2_connection){
                if (fgets($this->ts2_connection) == "[TS]\r\n"){
                    return true;
                } else {
                    return false;
                }
            } else {
                $this->ts2_error = 'No reply from Server, Teampspeak is offline or maybe Teamspeak is not running on it.';
                return false;
            }
        }

        /**
         * @description select virtual TS2-Server
         */
        function ts2_select_vserver($udpport = "none"){
            if($udpport != "none"){
                $this->ts2_udpport = $udpport;
                fputs($this->ts2_connection, "SEL ".$this->ts2_udpport."\r\n");
                if (fgets($this->ts2_connection) == "OK\r\n"){
                    return true;
                } else {
                    $this->ts2_error = 'Could not select vServer, invalid vServer-ID.';
                    return false;
                }
            } else {
                $this->ts2_error = 'Could not select vServer, no UDPPort given.';
                return false;
            }
        }

        /**
         * @description returns all channel of virtual TS2-Server
         */
        function ts2_get_channellist($udpport = "none"){
            if($udpport != "none"){
                $this->ts2_udpport = $udpport;
            }
            fputs($this->ts2_connection, "CL\r\n");
            $ts2_data = fgets($this->ts2_connection);
	        $all_channel = false;
            for($i=0; $all_channel != true; $i ++){
                $ts2_data = fgets($this->ts2_connection);
                if($ts2_data == "OK\r\n"){
				    $all_channel = true;
				    continue;
				}

                $data_cl = explode("	", $ts2_data);

                if($data_cl[2] == "-1"){
                    $ts2_channel[$i]["id"] = $data_cl[0];
                    $ts2_channel[$i]["codec"] = $data_cl[1];
                    $ts2_channel[$i]["parent"] = $data_cl[2];
                    $ts2_channel[$i]["order"] = $data_cl[3];
                    $ts2_channel[$i]["maxusers"] = $data_cl[4];
                    $ts2_channel[$i]["name"] = htmlentities(substr($data_cl[5], 1, -1));
                    $ts2_channel[$i]["flags"] = $data_cl[6];
                    $ts2_channel[$i]["password"] = $data_cl[7];
                    $ts2_channel[$i]["topic"] = htmlentities(substr($data_cl[8], 1, -1));
                }
            }

            foreach ($ts2_channel as $key => $row) {
                $name[$key]  = $row['name'];
                $order[$key] = $row['order'];
            }

            if(count($ts2_channel) > 1){
                array_multisort($order, SORT_ASC, $name, SORT_ASC, $ts2_channel);
            }
            

            if ($ts2_data == "OK\r\n"){
                return $ts2_channel;
            } else {
                $this->ts2_error = 'Could not select vServer, invalid vServer-ID.';
                return false;
            }
        }

        /**
         * @description returns all subchannel of Channel-ID
         */
        function ts2_get_subchannellist($parent_channel, $udpport = "none"){
            if($udpport != "none"){
                $this->ts2_udpport = $udpport;
            }
            fputs($this->ts2_connection, "CL $this->ts2_udpport\r\n");
            $ts2_data = fgets($this->ts2_connection);
	        $all_subchannel = false;
	        $i = 0;
            while(!$all_subchannel){
                $ts2_data = fgets($this->ts2_connection);
                if($ts2_data == "OK\r\n"){
				    $all_subchannel = true;
				    continue;
				}

                $data_cl = explode("	", $ts2_data);

                if($data_cl[2] == $parent_channel){
                    $ts2_subchannel[$i]["id"] = $data_cl[0];
                    $ts2_subchannel[$i]["codec"] = $data_cl[1];
                    $ts2_subchannel[$i]["parent"] = $data_cl[2];
                    $ts2_subchannel[$i]["order"] = $data_cl[3];
                    $ts2_subchannel[$i]["maxusers"] = $data_cl[4];
                    $ts2_subchannel[$i]["name"] = htmlentities(substr($data_cl[5], 1, -1));
                    $ts2_subchannel[$i]["flags"] = $data_cl[6];
                    $ts2_subchannel[$i]["password"] = $data_cl[7];
                    $ts2_subchannel[$i]["topic"] = htmlentities(substr($data_cl[8], 1, -1));
                    $ts2_subchannel[$i]["lastentry"] = false;

                    $i ++;
                }
            }

            foreach ($ts2_subchannel as $key => $row) {
                $name[$key]  = $row['name'];
                $order[$key] = $row['order'];
            }

            if(count($ts2_subchannel) > 1){
                array_multisort($order, SORT_ASC, $name, SORT_ASC, $ts2_subchannel);
            }

            if(count($ts2_subchannel) >= 1){
                $ts2_subchannel[($i -1)]["lastentry"] = true;
            }

            if ($ts2_data == "OK\r\n"){
                return $ts2_subchannel;
            } else {
                $this->ts2_error = 'Could not select vServer, invalid vServer-ID.';
                return false;
            }
        }

        /**
         * @param channel
         * @param udpport 
         * @description returns all infos about vServer
         */
        function ts2_get_activeuser($channel = "none", $udpport = "none"){
            if($udpport != "none"){
                $this->ts2_udpport = $udpport;
            }
            if($channel == "none"){
                $this->ts2_error = 'No Channel-ID given.';
                return false;
            }
            fputs($this->ts2_connection, "PL $this->udpport\r\n");
            $ts2_data = fgets($this->ts2_connection);
	        $all_user = false;
	        $i = 0;
            while(!$all_user){
                $ts2_data = fgets($this->ts2_connection);
                if($ts2_data == "OK\r\n"){
				    $all_user = true;
				    continue;
				}

                $data_cl = explode("	", $ts2_data);

                if($data_cl[1] == $channel){
                    $ts2_user[$i]["player_id"] = $data_cl[0];
                    $ts2_user[$i]["channel_id"] = $data_cl[1];
                    $ts2_user[$i]["packets_send"] = $data_cl[2];
                    $ts2_user[$i]["bytes_send"] = $data_cl[3];
                    $ts2_user[$i]["packets_received"] = $data_cl[4];
                    $ts2_user[$i]["bytes_received"] = $data_cl[5];
                    $ts2_user[$i]["packets_lost"] = $data_cl[6];
                    $ts2_user[$i]["ping"] = $data_cl[7];
                    $ts2_user[$i]["logintime"] = $data_cl[8];
                    $ts2_user[$i]["idletime"] = $data_cl[9];
                    $ts2_user[$i]["channel_privs"] = $data_cl[10];
                    $ts2_user[$i]["player_privs"] = $data_cl[11];
                    $ts2_user[$i]["player_flags"] = $data_cl[12];
                    $ts2_user[$i]["ip"] = substr($data_cl[13], 1, -1);
                    $ts2_user[$i]["nick"] = htmlentities(substr($data_cl[14], 1, -1));
                    $ts2_user[$i]["nick_sort"] = strtolower(substr($data_cl[14], 1, -1));
                    $ts2_user[$i]["loginname"] = htmlentities(substr($data_cl[15], 1, -1));
                    $ts2_user[$i]["lastentry"] = false;
                    $i ++;
                }
            }

            foreach ($ts2_user as $key => $row) {
                $p_privs[$key] = $row['player_privs'];
                $p_nick[$key] = $row['nick_sort'];
                $c_privs[$key]  = $row['channel_privs'];
                $p_flags[$key] = $row['player_flags'];
            }

            if(count($ts2_user) > 1){
                array_multisort($p_privs, SORT_DESC, SORT_NUMERIC, $c_privs, SORT_DESC, SORT_NUMERIC, $p_nick, SORT_ASC, SORT_STRING, $ts2_user);
            }

            if(count($ts2_user) >= 1){
                $ts2_user[($i -1)]["lastentry"] = true;
            }

            if ($ts2_data == "OK\r\n"){
                return $ts2_user;
            } else {
                $this->ts2_error = 'Could not select vServer, invalid vServer-ID.';
                return false;
            }
        }

        /**
         * @param udpport
         * @description returns all infos about vServer
         */
        function ts2_get_serverinfo($udpport = "none"){
            if($udpport != "none"){
                $this->ts2_udpport = $udpport;
            }
            fputs($this->ts2_connection, "SI $this->ts2_udpport\r\n");
	        $all_info = false;
            while($all_info != true){
                $ts2_data = fgets($this->ts2_connection);
                if($ts2_data == "OK\r\n"){
				    $all_info = true;
				    continue;
				}

                $data_cl = explode("=", $ts2_data);

                $key = $data_cl[0];
                $value = htmlentities($data_cl[1]);

                $ts2_info[$key] = $value;
            }

            if ($ts2_data == "OK\r\n"){
                return $ts2_info;
            } else {
                $this->ts2_error = 'Could not select vServer, invalid vServer-ID.';
                return false;
            }
        }

        /**
         * @description returns last ts2-Error
         */
        function ts2_close(){
            if(fclose($this->ts2_connection)){
                return true;
            } else {
                $this->ts2_error = 'Could not close Server-Connection.';
                return false;
            }
        }

        /**
         * @description returns last ts2-Error
         */
        function ts2_error(){
            return $this->ts2_error;
        }
    }

?>