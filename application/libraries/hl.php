<?php

function status($address)
{
    $fp = fsockopen('udp://'.$address);

    if($fp) 
    {
            stream_set_timeout($fp, 1);
        
            fwrite($fp,"\xFF\xFF\xFF\xFFTSource Engine Query\x00\r"); 
            $temp = fread($fp, 5); 
            $status = socket_get_status($fp); 
            if($status['unread_bytes']>0) 
            {
                    $temp = fread($fp, $status['unread_bytes']);
                    $array = array(); 
                    $pos = 0; 
                    while($pos !== false) 
                    { 
                            $pos2 = strpos($temp, "\0", $pos+1); 
                            $array[] = substr($temp, $pos+1, $pos2-$pos)."\n"; 
                            $pos = $pos2;
                    }
                    $server['status'] = 'online';
                    if(trim($array[2]) == 'cstrike') 
                    {
                            $server['players'] 		= ord($array[5][0]); 
                            $server['maxplayers']   = ord($array[5][1]); 
                            $server['name']   		= trim($array[0]); 
                            $server['map']    		= trim($array[1]);
                            $server['type']			= trim($array[3]);
                    } 
                    else 
                    {
                            $server['players'] 		= ord($array[5][0]); 
                            $server['maxplayers']   = ord($array[5][1]); 
                            $server['name']   		= trim($array[1]); 
                            $server['map']    		= trim($array[2]);
                            $server['type']			= trim($array[3]);
                    } 
            }
            else
            {
                    $server['status'] = 'offline';
                    $server['players']    = '0';
                    $server['maxplayers']    = '0';
                    $server['name']    = '---';
                    $server['map']    = '---';
            }
    }
    return $server;
}

function status2($address)
{
    $fp = fsockopen('udp://'.$address);
    stream_set_timeout($fp, 1); 

    if($fp) 
    { 
            fwrite($fp,"\xFF\xFF\xFF\xFFTSource Engine Query\x00\r"); 
            $temp = fread($fp, 5); 
            $status = socket_get_status($fp); 
            if($status['unread_bytes']>0) 
            {
                    $temp = fread($fp, $status['unread_bytes']);
                    $array = array(); 
                    $pos = 0; 
                    while($pos !== false) 
                    { 
                            $pos2 = strpos($temp, "\0", $pos+1); 
                            $array[] = substr($temp, $pos+1, $pos2-$pos)."\n"; 
                            $pos = $pos2;
                    }
                    $server['status'] = 'online';
                    if(trim($array[2]) == 'cstrike') 
                    {
                            $server['players'] 		= ord($array[5][0]); 
                            $server['maxplayers']   = ord($array[5][1]); 
                            $server['name']   		= trim($array[0]); 
                            $server['map']    		= trim($array[1]);
                            $server['type']			= trim($array[3]);
                    } 
                    else 
                    {
                            $server['players'] 		= ord($array[5][0]); 
                            $server['maxplayers']   = ord($array[5][1]); 
                            $server['name']   		= trim($array[1]); 
                            $server['map']    		= trim($array[2]);
                            $server['type']			= trim($array[3]);
                    } 
            }
            else
            {
                    $server['status'] = 'offline';
                    $server['players']    = '0';
                    $server['maxplayers']    = '0';
                    $server['name']    = '---';
                    $server['map']    = '---';
            }
    }
    return $array;
}

function info($address, $request) // request = players, settings
{
    $fp = @fsockopen('udp://'.$address);
    if (!$fp) return false;
    stream_set_timeout($fp, 1);
    stream_set_blocking($fp, true);  
    if (($request == "settings" || $request == "players")) {
      $challenge_code = "\xFF\xFF\xFF\xFF\x55\xFF\xFF\xFF\xFF"; 
      fwrite($fp, $challenge_code);
      $buffer = fread($fp, 4096);
      if (!trim($buffer)) { fclose($fp); return FALSE; }
      $challenge_code = substr($buffer, 5, 4);
    }
    if ($request == "players") $challenge = "\xFF\xFF\xFF\xFF\x55".$challenge_code;
    if ($request == "settings") $challenge = "\xFF\xFF\xFF\xFF\x56".$challenge_code;
    fwrite($fp, $challenge);
    $buffer = fread($fp, 4096);
    if (!$buffer) { fclose($fp); return FALSE; }     
    if ($request == "settings")
    {
    $second_packet = fread($fp, 4096);
    if (strlen($second_packet) > 0)
    {
      $reverse_check = dechex(ord($buffer[8]));      
      if ($reverse_check[0] == "1")
      {
        $tmp = $buffer;                 
        $buffer = $second_packet;
        $second_packet = $tmp;
      }
      $buffer = substr($buffer, 13);         
      $second_packet = substr($second_packet, 9);   
      $buffer = trim($buffer.$second_packet);
    }
    else	$buffer = trim(substr($buffer, 4));
    }
    else	$buffer = trim(substr($buffer, 4)); 
    fclose($fp);
    if (!trim($buffer)) return FALSE;
		
    if ($request == "players")
    {
    $player_number = 0;
    $position = 2;
    do {
      $player_number++;
      $player[$player_number]['name']='';                                  
      $null = ord($buffer[$position]);
      $position ++;                                             
      while($buffer[$position] != "\x00" && $position < 4000)
      {
        $player[$player_number]['name'] .= $buffer[$position];  
        $position ++;
      }
      $player[$player_number]['score'] = (ord($buffer[$position + 1]))
      + (ord($buffer[$position + 2]) * 256)
      + (ord($buffer[$position + 3]) * 65536)
      + (ord($buffer[$position + 4]) * 16777216);
      if ($player[$player_number]['score'] > 2147483648) $player[$player_number]['score'] -= 4294967296;
      $time = substr($buffer, $position + 5, 4);               
      if (strlen($time) < 4) return FALSE;              
      list(,$time) = unpack("f", $time);                
      $position += 9;
    }
    while ($position < strlen($buffer));                   
    return $player;
    }

    if ($request == "settings")
    {
      $tmp     = substr($buffer, 2); 
      $rawdata = explode("\x00", $tmp);
      for($i=1; $i<count($rawdata); $i=$i+2)
      {
        $rawdata[$i] = strtolower($rawdata[$i]);  
        $setting[$rawdata[$i]] = $rawdata[$i+1];  
        $setting['value'] = strtolower($rawdata[$i]);
        $setting['key'] = $rawdata[$i+1];  
      }
      return $setting; 
    }
}
