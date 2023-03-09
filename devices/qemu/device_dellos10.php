<?php

/**
 * 
 * @author LIN 
 * @copyright pnetlab.com
 * @link https://www.pnetlab.com/
 * 
 */

class device_dellos10 extends device_qemu
{

    function __construct($node)
    {
        parent::__construct($node);
    }

     public function createEthernets($quantity)
    {

        $ethernets = [];
        
        for ($i = 0; $i < $quantity; $i++) {
            if (!isset($this->ethernets[$i])) {

                 if($i == 0 && $this->first_nic != ''){
                    $flag = ' -device  '.$this->first_nic.',addr=' . ((int) ($i / 4) + 3) . '.' . ($i % 4) . ',multifunction=on,netdev=net' . $i . ',mac=' . incMac($this->createFirstMac(), $i);
                }else{
                    $flag = ' -device  %NICDRIVER%,addr=' . ((int) ($i / 4) + 3) . '.' . ($i % 4) . ',multifunction=on,netdev=net' . $i . ',mac=' . incMac($this->createFirstMac(), $i);
                }

                $flag .= ' -netdev tap,id=net' . $i . ',ifname=vunl' . $this->getSession() . '_' . $i . ',script=no';
               if ($i == 0) {
                    $n = 'Mgmt 1/1/1';           // Interface name
                } else {
                    $n = 'Eth 1/1/' . $i;          // Interface name
                }

                try {
                   $ethernets[$i] = new Interfc( $this, array('name' => $n, 'type' => 'ethernet', 'flag' => $flag), $i);
                } catch (Exception $e) {
                    error_log(date('M d H:i:s ') . 'ERROR: ' . $GLOBALS['messages'][40020]);
                    error_log(date('M d H:i:s ') . (string) $e);
                    return 40020;
                }
            } else {
                $ethernets[$i] = $this->ethernets[$i];
            }
        }

        $this->ethernets = $ethernets;
        return $this->ethernets;
    }
}