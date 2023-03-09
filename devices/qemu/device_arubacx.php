<?php

/**
 * 
 * @author LIN 
 * @copyright pnetlab.com
 * @link https://www.pnetlab.com/
 * 
 */

class device_arubacx extends device_qemu
{

    function __construct($node)
    {
        parent::__construct($node);
    }

    public function createEthernets($quantity)
    {
        $a = 0;
        $b = 1;


        for ($i = 0; $i < $quantity; $i++) {

            if (!isset($this->ethernets[$i])) {
                if($i == 0 && $this->first_nic != ''){
                    $flags = ' -device  '.$this->first_nic.',addr=' . ((int) ($i / 4) + 3) . '.' . ($i % 4) . ',multifunction=on,netdev=net' . $i . ',mac=' . incMac($this->createFirstMac(), $i);
                }else{
                    $flags = ' -device  %NICDRIVER%,addr=' . ((int) ($i / 4) + 3) . '.' . ($i % 4) . ',multifunction=on,netdev=net' . $i . ',mac=' . incMac($this->createFirstMac(), $i);
                }

                $flags .= ' -netdev tap,id=net' . $i . ',ifname=vunl' . $this->getSession() . '_' . $i . ',script=no';
                if ($i == 0) {
                    $n = 'mgmt';         // Interface name
                } else {
                    $n = '1/1/'. $i;   // Interface name
                }
                try {
                 $ethernets[$i] = new Interfc( $this, array('name' => $n, 'type' => 'ethernet', 'flag' => $flags), $i);
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

