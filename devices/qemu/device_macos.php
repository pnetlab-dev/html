<?php

/**
 * 
 * @author LIN 
 * @author NEJIBTECH 
 * @copyright pnetlab.com
 * @link https://www.pnetlab.com/
 * 
 */

class device_macos extends device_qemu
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
                $n = 'e' . $i;                // Interface name
                
                if($i == 0 && $this->first_nic != ''){
                    $flags = ' -device '.$this->first_nic.',netdev=net' . $i . ',mac=' . incMac($this->createFirstMac(), $i);
                }else{
                    $flags = ' -device %NICDRIVER%,netdev=net' . $i . ',mac=' . incMac($this->createFirstMac(), $i);
                }

                $flags .= ' -netdev tap,id=net' . $i . ',ifname=vunl' . $this->getSession() . '_' . $i . ',script=no';

                try {
                    $ethernets[$i] = new Interfc( $this, array('name' => $n, 'type' => 'ethernet', 'flag' => $flags), $i);
                } catch (Exception $e) {
                    error_log(date('M d H:i:s ') . 'ERROR: ' . $GLOBALS['messages'][40020]);
                    error_log(date('M d H:i:s ') . (string) $e);
                    return false;
                }
            }
        }
        if (file_exists('/opt/unetlab/scripts/OVMF_CODE.fd')) {
                copy('/opt/unetlab/scripts/OVMF_CODE.fd', $this->getRunningPath() . '/OVMF_CODE.fd');
            }
        if (file_exists('/opt/unetlab/scripts/OVMF_VARS-1024x768.fd')) {
                copy('/opt/unetlab/scripts/OVMF_VARS-1024x768.fd', $this->getRunningPath() . '/OVMF_VARS-1024x768.fd');
            }
        if (file_exists('/opt/unetlab/scripts/ESP.qcow2')) {
                copy('/opt/unetlab/scripts/ESP.qcow2', $this->getRunningPath() . '/ESP.qcow2');
            }
        $this->ethernets = $ethernets;
        return $this->ethernets;
    }
}
