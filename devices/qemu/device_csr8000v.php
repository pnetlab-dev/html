<?php

/**
 * 
 * @author LIN 
 * @copyright pnetlab.com
 * @link https://www.pnetlab.com/
 * 
 */

class device_csr8000v extends device_qemu
{

    function __construct($node)
    {
        parent::__construct($node);
    }

    public function createEthernets($quantity)
    {
        $ethernets = [];
 $first = 0 ;
                 /*FOR CUSTOM COSNOLES */
        if ($this->console == 'http' || $this->console_2nd == 'http' )
                {
                    $n = 'Mgmt http';
                    try {
                        $ethernets[$quantity + $first] = new Interfc( $this, array('name' => $n, 'type' => 'ethernet',), $quantity + $first);
                    } catch (Exception $e) {
                        error_log(date('M d H:i:s ') . 'ERROR: ' . $GLOBALS['messages'][40020]);
                        error_log(date('M d H:i:s ') . (string) $e);
                        return 40020;
                    } 
                    $first  ++;
                }
        if ($this->console == 'https' || $this->console_2nd == 'https' )
                {
                    $n = 'Mgmt https';

                    try {
                        $ethernets[$quantity + $first] = new Interfc( $this, array('name' => $n, 'type' => 'ethernet', ), $quantity + $first);
                    } catch (Exception $e) {
                        error_log(date('M d H:i:s ') . 'ERROR: ' . $GLOBALS['messages'][40020]);
                        error_log(date('M d H:i:s ') . (string) $e);
                        return 40020;
                    } $first  ++;
                }
                /////////////
        if ($this->console == 'ssh' || $this->console_2nd == 'ssh' )
                {
                   $n = 'Mgmt ssh';
                   try {
                        $ethernets[$quantity + $first] = new Interfc( $this, array('name' => $n, 'type' => 'ethernet',), $quantity + $first);
                   }
                     catch (Exception $e) {
                        error_log(date('M d H:i:s ') . 'ERROR: ' . $GLOBALS['messages'][40020]);
                        error_log(date('M d H:i:s ') . (string) $e);
                        return 40020;
                    } $first  ++;
                }
                //////////////
        if ($this->console == 'rdp' || $this->console_2nd == 'rdp' )
                {
                    $n = 'Mgmt rdp';
                    try {
                        $ethernets[$quantity + $first] = new Interfc( $this, array('name' => $n, 'type' => 'ethernet',), $quantity + $first);
                    } catch (Exception $e) {
                        error_log(date('M d H:i:s ') . 'ERROR: ' . $GLOBALS['messages'][40020]);
                        error_log(date('M d H:i:s ') . (string) $e);
                        return 40020;
                    } $first  ++;
             }
                //////////////
        if ($this->console == 'rdp-tls' || $this->console_2nd == 'rdp-tls' )
                {
                    $n = 'Mgmt rdp-tls';
                    try {
                        $ethernets[$quantity+ $first] = new Interfc( $this, array('name' => $n, 'type' => 'ethernet',), $quantity + $first);
                    } catch (Exception $e) {
                        error_log(date('M d H:i:s ') . 'ERROR: ' . $GLOBALS['messages'][40020]);
                        error_log(date('M d H:i:s ') . (string) $e);
                        return 40020;
                    }  $first  ++;
         }
        /*FOR CUSTOM COSNOLES */
      
        for ($i = 0; $i < $quantity; $i++) {

            if (!isset($this->ethernets[$i])) {

                if($i == 0 && $this->first_nic != ''){
                    $flag = ' -device '.$this->first_nic.',netdev=net' . $i . ',mac=' . incMac($this->createFirstMac(), $i);
                }else{
                    $flag = ' -device %NICDRIVER%,netdev=net' . $i . ',mac=' . incMac($this->createFirstMac(), $i);
                }
                $flag .= ' -netdev tap,id=net' . $i . ',ifname=vunl' . $this->getSession() . '_' . $i . ',script=no';
                if ($first > 0) {         
                                        $n = 'Gi' . ($i + 1 + $first);         // Interface name
     
                }
                else {
                $n = 'Gi' . ($i + 1);         // Interface name

                }

                try {
                    $ethernets[$i] = new Interfc( $this, array('name' => $n, 'type' => 'ethernet', 'flag' => $flag), $i);
                } catch (Exception $e) {
                    error_log(date('M d H:i:s ') . 'ERROR: ' . $GLOBALS['messages'][40020]);
                    error_log(date('M d H:i:s ') . (string) $e);
                    return false;
                }
            } else {
                $ethernets[$i] = $this->ethernets[$i];
            }
            // Setting CMD flags (virtual device and map to TAP device)

        }

        $this->ethernets = $ethernets;
        return $this->ethernets;
    }



    public function customFlag($flag)
    {
        if(is_file($this->getRunningPath() . '/config.iso') && !is_file($this->getRunningPath() . '/.configured') && $this->config != 0) {
            $flag .= ' -cdrom config.iso';
        }
        return $flag;
    }


    public function prepare()
    {
        $result = parent::prepare();
        if ($result != 0) return $result;

        if (is_file($this->getRunningPath() . '/startup-config') && !is_file($this->getRunningPath() . '/.configured')) {
            copy($this->getRunningPath() . '/startup-config',  $this->getRunningPath() . '/iosxe_config.txt');
            $isocmd = 'mkisofs -o ' . $this->getRunningPath() . '/config.iso -l --iso-level 2 ' . $this->getRunningPath() . '/iosxe_config.txt';
            exec($isocmd, $o, $rc);
        }

        return 0;
    }
}
