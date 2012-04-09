<?php

/**
 * @author Martin Grulich
 * @copyright 2008 
 */

    $time = gettimeofday();
    $starttime = $time["usec"];

/*
    channel privileges:
    CA:     1
    O:      2
    V:      4
    AO:     8
    AV:     16
    -------------------
    player privileges:
    SA:                     1
    Allow_Registration:     2
    Registered:             4
    Internal Use:           8
    Stickey:                16
    --------------------------
    player flags:
    Channel Commander:      1
    Voice Request:          2
    Doesnt Accept Whispers: 4
    Away:                   8
    Microphone Muted:       16
    Sound Muted:            32
    Recording:              64
*/

    $ts2_server = $_GET['server'];
    $ts2_tcpport = $_GET['tcp'];
    $ts2_udpport = $_GET['udp'];
    $ts2_loginname = $_GET['loginname'];
    $ts2_password = $_GET['password'];
    $ts2_ssa = $_GET['ssa'];

    include_once("../classes/ts2.class.php");
    include_once("../includes/style.inc.php");
    include_once("../includes/time.inc.php");
    include_once("../includes/math.inc.php");

    $TS2 = new ts2($ts2_server, $ts2_tcpport);

    $TS2->ts2_connect() or die('ERROR[TS2]: '.$TS2->ts2_error());

    $TS2->ts2_select_vserver($ts2_udpport) or die('ERROR[TS2]: '.$TS2->ts2_error());

    $channellist = $TS2->ts2_get_channellist();
    if($channellist == false){
         die('ERROR[TS2]: '.$TS2->ts2_error());
    }

    $serverinfo = $TS2->ts2_get_serverinfo();

    $serverinfo['traffic'] = ($serverinfo['server_bytessend'] + $serverinfo['server_bytesreceived']);

    echo '<div id="user_info_server" class="info">
              Server: '.$serverinfo['server_name'].'<br />
              Betriebssystem: '.$serverinfo['server_platform'].'<br />
              Laufzeit: '.tellSeconds($serverinfo['server_uptime']).'<br />
              Traffic: '.byte_calculation($serverinfo['traffic']).'<br />
              <br />
              Benutzer: <b>'.$serverinfo['server_currentusers'].'</b>/ <b>'.$serverinfo['server_maxusers'].'</b><br />
          </div>'."\n";

    echo '<div class="line" onmouseover="showInfo(\'server\');" onmouseout="hideInfo();">
              <div id="start"><img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_tree_start.gif" alt="ts_start" /></div>
              <div class="title_highlight">'.$serverinfo['server_name'].'</div>
          </div>'."\n";
    echo '<div class="line" onclick="connectTS(\''.$ts2_server.':'.$ts2_udpport.'\');">
              <img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_tree_cross.gif" alt="ts_cross" />
              <div id="Connect"></div>
          </div>'."\n";
    echo '<div class="line">
              <img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_tree_line.gif" alt="ts_line" />
          </div>'."\n";

    foreach($channellist as $channel){
        echo '<div class="line">
                  <img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_tree_cross.gif" alt="ts_cross" />';
        if($channel['password']){
            echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_tree_channel_password.gif" alt="ts_channel_password" />';
        } else {
            echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_tree_channel.gif" alt="ts_channel" />';
        }
        echo '    <div class="title">&nbsp;'.$channel['name'].' ('.$TS2->ts2_translateFlag($channel['flags'], 4, true).')</div>
              </div>'."\n";

        $subchannellist = $TS2->ts2_get_subchannellist($channel['id']);
        $channel_user = $TS2->ts2_get_activeuser($channel['id']);
        foreach($subchannellist as $subchannel){
            echo '<div class="line">
                      <img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_tree_line.gif" alt="ts_line" />';
            if($subchannel['lastentry']){
                if(count($channel_user) >= 1){
                    echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_tree_cross.gif" alt="ts_cross" />';
                } else {
                    echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_tree_end.gif" alt="ts_end" />';
                }
            } else {
                echo '
                      <img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_tree_cross.gif" alt="ts_cross" />';
            }
            echo '    <img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_tree_channel.gif" alt="ts_channel" />
                      <div class="title">&nbsp;'.$subchannel['name'].'</div>
                  </div>'."\n";
            $subchannel_user = $TS2->ts2_get_activeuser($subchannel['id']);
            foreach($subchannel_user as $user){
                $user['traffic'] = ($user['bytes_send'] + $user['bytes_received']);
                echo '<div id="user_info_'.$user['player_id'].'" class="info">
                          Benutzername: '.$user['nick'].'<br />
                          Ping: <b>'.$user['ping'].'</b> ms<br />
                          Packet-Lost: <b>0,'.$user['packets_lost'].'</b> %<br />
                          Traffic:  '.byte_calculation($user['traffic']).'<br />';
                if(tellSeconds($user['idletime']) != ""){
                    echo '    unt&auml;tig seit: '.tellSeconds($user['idletime']).'<br />';
                } else {
                    echo '    Status: <span style="color: #00ff00;">Spricht gerade</span><br />';
                }
                echo '    eingeloggt seit: '.tellSeconds($user['logintime']).'
                      </div>'."\n";
                echo '<div class="line" onmouseover="showInfo('.$user['player_id'].');" onmouseout="hideInfo();">
                          <img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_tree_line.gif" alt="ts_line" />';
                if($subchannel['lastentry']){
                    if(count($channel_user) >= 1){
                        echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_tree_line.gif" alt="ts_line" />';
                    } else {
                        echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_tree_hidden.gif" alt="ts_hidden" />';
                    }
                } else {
                    echo '
                          <img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_tree_line.gif" alt="ts_line" />';
                }
                if($user['lastentry']){
                    echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_tree_end.gif" alt="ts_end" />';
                } else {
                    echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_tree_cross.gif" alt="ts_cross" />';
                }
                if(strstr($TS2->ts2_translateFlag($user['player_flags'], 3, true), "AW")){
                    echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_player_away.gif" alt="ts_player_away" />';
                } elseif(strstr($TS2->ts2_translateFlag($user['player_flags'], 3, true), "MM")){
                    echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_player_micmute.gif" alt="ts_player_micrmute" />';
                } elseif(strstr($TS2->ts2_translateFlag($user['player_flags'], 3, true), "SM")){
                    echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_player_soundmuted.gif" alt="ts_player_soundmute" />';
                } elseif(strstr($TS2->ts2_translateFlag($user['player_flags'], 3, true), "CC")){
                    if($user['idletime'] == 0){
                        echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_player_channelcommander_speak.gif" alt="ts_player_speak" />';
                    } else {
                        echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_player_channelcommander.gif" alt="ts_player_speak" />';
                    }
                } else {
                    if($user['idletime'] == 0){
                        echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_player_speak.gif" alt="ts_player_speak" />';
                    } else {
                        echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_player.gif" alt="ts_player" />';
                    }
                }
                
                echo '    <div class="title">&nbsp;'.$user['nick'].' (<div class="player_privs" id="player_privs_'.$user['player_id'].'">'.$TS2->ts2_translateFlag($user['player_privs'], 2, true).'</div>)</div>
                      </div>'."\n";
            }
        }

        foreach($channel_user as $user){
            $user['traffic'] = ($user['bytes_send'] + $user['bytes_received']);
            echo '<div id="user_info_'.$user['player_id'].'" class="info">
                      Benutzername: '.$user['nick'].'<br />
                      Ping: <b>'.$user['ping'].'</b> ms<br />
                      Packet-Lost: <b>0,'.$user['packets_lost'].'</b> %<br />
                      Traffic:  '.byte_calculation($user['traffic']).'<br />';
            if(tellSeconds($user['idletime']) != ""){
                echo '    unt&auml;tig seit: '.tellSeconds($user['idletime']).'<br />';
            } else {
                echo '    Status: <span style="color: #00ff00;">Spricht gerade</span><br />';
            }
            echo '    eingeloggt seit: '.tellSeconds($user['logintime']).'
                  </div>'."\n";
            echo '<div class="line" onmouseover="showInfo('.$user['player_id'].');" onmouseout="hideInfo();">
                      <img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_tree_line.gif" alt="ts_line" />';
            if($user['lastentry']){
                echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_tree_end.gif" alt="ts_end" />';
            } else {
                echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_tree_cross.gif" alt="ts_cross" />';
            }
            if(strstr($TS2->ts2_translateFlag($user['player_flags'], 3, true), "AW")){
                echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_player_away.gif" alt="ts_player_away" />';
            } elseif(strstr($TS2->ts2_translateFlag($user['player_flags'], 3, true), "MM")){
                echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_player_micmute.gif" alt="ts_player_micrmute" />';
            } elseif(strstr($TS2->ts2_translateFlag($user['player_flags'], 3, true), "SM")){
                echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_player_soundmuted.gif" alt="ts_player_soundmute" />';
            } elseif(strstr($TS2->ts2_translateFlag($user['player_flags'], 3, true), "CC")){
                if($user['idletime'] == 0){
                    echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_player_channelcommander_speak.gif" alt="ts_player_speak" />';
                } else {
                    echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_player_channelcommander.gif" alt="ts_player_speak" />';
                }
            } else {
                if($user['idletime'] == 0){
                    echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_player_speak.gif" alt="ts_player_speak" />';
                } else {
                    echo '<img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_player.gif" alt="ts_player" />';
                }
            }
            echo '    <div class="title">&nbsp;'.$user['nick'].'(<div class="player_privs" id="player_privs_'.$user['player_id'].'">'.$TS2->ts2_translateFlag($user['player_privs'], 2, true).'</div>)</div>
                  </div>'."\n";
        }
    }

    $TS2->ts2_close();

    $time=gettimeofday();
        $stoptime=$time["usec"];
        $alltime=round(($stoptime-$starttime)/1000,0);
        if($alltime<1) {
            $alltime = "< 1";
    }

    echo '<div id="user_info_info" class="info">
              TSMonitor-Version: 02.00.01<br />
              Inhalt aktualisiert in: <b>'.$alltime.'</b> ms<br />
              <br />
              &copy; 2008 by hackXnet
          </div>'."\n";
    echo '<div class="line" onmouseover="showInfo(\'info\');" onmouseout="hideInfo();" onclick="location.href=\'http://hackx.net\'">
              <img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts_tree_end.gif" alt="ts_end" />
              <img class="icon" src="styles/'.$STYLESHEET.'/images/icons/ts2_monitor.gif" alt="ts_monitor" />
          </div>'."\n";
?>