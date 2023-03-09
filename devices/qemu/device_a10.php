<?php

/**
 * 
 * @author LIN 
 * @copyright pnetlab.com
 * @link https://www.pnetlab.com/
 * 
 */

class device_a10 extends device_qemu
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
                    $n = 'Mgmt Port reserved for http console';

                    try {
                        $ethernets[$quantity + 1] = new Interfc( $this, array('name' => $n, 'type' => 'ethernet',), $quantity + 1);
                    } catch (Exception $e) {
                        error_log(date('M d H:i:s ') . 'ERROR: ' . $GLOBALS['messages'][40020]);
                        error_log(date('M d H:i:s ') . (string) $e);
                        return 40020;
                    }
                     $first  ++;
                }
                ///////////////
                 if ($this->console == 'https' || $this->console_2nd == 'https' )
                {
                    $n = 'Mgmt Port reserved for https console';

                    try {
                        $ethernets[$quantity + 2] = new Interfc( $this, array('name' => $n, 'type' => 'ethernet', ), $quantity + 2);
                    } catch (Exception $e) {
                        error_log(date('M d H:i:s ') . 'ERROR: ' . $GLOBALS['messages'][40020]);
                        error_log(date('M d H:i:s ') . (string) $e);
                        return 40020;
                    }
                     $first  ++;
                }
                /////////////
                 if ($this->console == 'ssh' || $this->console_2nd == 'ssh' )
                {

                   $n = 'Mgmt Port reserved for ssh console';
                   try {
                        $ethernets[$quantity + 3] = new Interfc( $this, array('name' => $n, 'type' => 'ethernet',), $quantity + 3);
                    } catch (Exception $e) {
                        error_log(date('M d H:i:s ') . 'ERROR: ' . $GLOBALS['messages'][40020]);
                        error_log(date('M d H:i:s ') . (string) $e);
                        return 40020;
                    } 
                     $first  ++;
                }
        /*FOR CUSTOM COSNOLES */

        for ($i = 0; $i < $quantity; $i++) {

            if ($i == 0) {
                // First virtual NIC must be e1000
                $flag = ' -device e1000,netdev=net' . $i . ',mac=' . incMac($this->createFirstMac(), $i);
                $flag .= ' -netdev tap,id=net' . $i . ',ifname=vunl' . $this->getSession() . '_' . $i . ',script=no';
            } else {
                $flag = ' -device %NICDRIVER%,netdev=net' . $i . ',mac=' . incMac($this->createFirstMac(), $i);
                $flag .= ' -netdev tap,id=net' . $i . ',ifname=vunl' . $this->getSession() . '_' . $i . ',script=no';
            }

            if (!isset($this->ethernets[$i])) {

                if ($first > 0) {
                    
                      $n = 'E' . $i + $first; 
                }
                else {
                        if ($i == 0) {
                            $n = 'Mgmt';            // Interface name
                        } else {
                            $n = 'E' . $i;            // Interface name
                        }

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
}
