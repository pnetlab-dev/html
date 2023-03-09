<?php

/**
 * 
 * @author LIN 
 * @author NEJIBTECH
 * @copyright pnetlab.com
 * @link https://www.pnetlab.com/
 * 
 */

class device_veos extends device_qemu
{

    function __construct($node)
    {
        parent::__construct($node);
    }

    public function createEthernets($quantity)
    {
        $ethernets = [];
        $a = 0;
        $b = 1;
        $c = 1;
        $d = 1;
        $e = 1;
        $f = 1;
        $j = 1;
        $k = 1;
        $l = 1;
        $m = 1;
        

        for ($i = 0; $i < $quantity; $i++) {

            if (!isset($this->ethernets[$i])) {
                if($i == 0 && $this->first_nic != ''){
                    $flags = '  -device '.$this->first_nic.',netdev=net' . $i . ',mac=' . incMac($this->createFirstMac(), $i);
                } 
                else if ($i <= 27 )
                {
                    $flags = ' -device %NICDRIVER%,netdev=net' . $i . ',mac=' . incMac($this->createFirstMac(), $i);
                }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////pci_bridge1
                    else if  ($i == 28 )                     
                    {
                    $flags = '-device i82801b11-bridge,id=dmi_pci_bridge -device pci-bridge,id=pci_bridge1,bus=dmi_pci_bridge,chassis_nr=0x1,addr=0x1,shpc=off ' . ' -device %NICDRIVER%,netdev=net'. $i.',mac=' . incMac($this->createFirstMac(), $i) . ',bus=pci_bridge1,addr=0x' . sprintf("%02x\n",$a) ;
                    } 
                else if  ($i <= 59 )                     
                     do {
                    $flags = ' -device %NICDRIVER%,netdev=net' . $i.',mac=' . incMac($this->createFirstMac(), $i) . ',bus=pci_bridge1,addr=0x' . sprintf("%02x\n",$b);
                    $b++;
                     } while ($b <= 0) ;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////pci_bridge2
                 else if  ($i == 60 )                    
                      {
                    $flags = ' -device pci-bridge,id=pci_bridge2,bus=dmi_pci_bridge,chassis_nr=0x1,addr=0x2,shpc=off ' . '  -device %NICDRIVER%,netdev=net' . $i.',mac=' . incMac($this->createFirstMac(), $i) . ',bus=pci_bridge2,addr=0x' . sprintf("%02x\n",$a)   ;
                     }
 
                else if  ($i <= 91 )                    
                     do {
                    $flags = '  -device %NICDRIVER%,netdev=net' . $i.',mac=' . incMac($this->createFirstMac(), $i) . ',bus=pci_bridge2,addr=0x' . sprintf("%02x\n",$c);
                    $c++; 
                     } while ($c <= 0) ;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////pci_bridge3
                else if  ($i == 92 ) 
                     {
                    $flags = ' -device pci-bridge,id=pci_bridge3,bus=dmi_pci_bridge,chassis_nr=0x1,addr=0x3,shpc=off ' . ' -device %NICDRIVER%,netdev=net' . $i.',mac=' . incMac($this->createFirstMac(), $i) . ',bus=pci_bridge3,addr=0x' . sprintf("%02x\n",$a)  ;
                     } 
              else if  ($i <= 123 ) 
                     do {
                    $flags = '-device %NICDRIVER%,netdev=net' . $i.',mac=' . incMac($this->createFirstMac(), $i) . ',bus=pci_bridge3,addr=0x' . sprintf("%02x\n",$d) ;  
                    $d++;
                     } while ($d <= 0) ;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////pci_bridge4
                else if  ($i == 124 ) 
                     {
                    $flags = ' -device pci-bridge,id=pci_bridge4,bus=dmi_pci_bridge,chassis_nr=0x1,addr=0x4,shpc=off ' . ' -device %NICDRIVER%,netdev=net' . $i.',mac=' . incMac($this->createFirstMac(), $i) . ',bus=pci_bridge4,addr=0x' . sprintf("%02x\n",$a)  ;
                     } 
                else if  ($i <= 155 ) 
                     do {
                    $flags = '-device %NICDRIVER%,netdev=net' . $i.',mac=' . incMac($this->createFirstMac(), $i) . ',bus=pci_bridge4,addr=0x' . sprintf("%02x\n",$e) ;   
                    $e++;
                     } while ($e <= 0) ;        
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////pci_bridge5
                else if  ($i == 156 ) 
                     {
                    $flags = ' -device pci-bridge,id=pci_bridge5,bus=dmi_pci_bridge,chassis_nr=0x1,addr=0x5,shpc=off ' . ' -device %NICDRIVER%,netdev=net' . $i.',mac=' . incMac($this->createFirstMac(), $i) . ',bus=pci_bridge5,addr=0x' . sprintf("%02x\n",$a)  ;
                     } 
                else if  ($i <= 187 ) 
                     do {
                    $flags = '-device %NICDRIVER%,netdev=net' . $i.',mac=' . incMac($this->createFirstMac(), $i) . ',bus=pci_bridge5,addr=0x' . sprintf("%02x\n",$f) ;  
                    $f++;
                     } while ($f <= 0) ;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////pci_bridge6
                else if  ($i == 188 ) 
                     {
                    $flags = ' -device pci-bridge,id=pci_bridge6,bus=dmi_pci_bridge,chassis_nr=0x1,addr=0x6,shpc=off ' . ' -device %NICDRIVER%,netdev=net' . $i.',mac=' . incMac($this->createFirstMac(), $i) . ',bus=pci_bridge6,addr=0x' . sprintf("%02x\n",$a)  ;
                     } 
                else if  ($i <= 219 ) 
                     do {
                    $flags = '-device %NICDRIVER%,netdev=net' . $i.',mac=' . incMac($this->createFirstMac(), $i) . ',bus=pci_bridge6,addr=0x' . sprintf("%02x\n",$j) ;   
                    $j++;
                     } while ($j <= 0) ;        
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////pci_bridge7
                else if  ($i == 220 ) 
                     {
                    $flags = ' -device pci-bridge,id=pci_bridge7,bus=dmi_pci_bridge,chassis_nr=0x1,addr=0x7,shpc=off ' . ' -device %NICDRIVER%,netdev=net' . $i.',mac=' . incMac($this->createFirstMac(), $i) . ',bus=pci_bridge7,addr=0x' . sprintf("%02x\n",$a)  ;
                     } 
                else if  ($i <= 251 ) 
                     do {
                    $flags = '-device %NICDRIVER%,netdev=net' . $i.',mac=' . incMac($this->createFirstMac(), $i) . ',bus=pci_bridge7,addr=0x' . sprintf("%02x\n",$k) ;  
                    $k++;
                     } while ($k <= 0) ;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////pci_bridge8
                else if  ($i == 252 ) 
                     {
                    $flags = ' -device pci-bridge,id=pci_bridge8,bus=dmi_pci_bridge,chassis_nr=0x1,addr=0x8,shpc=off ' . ' -device %NICDRIVER%,netdev=net' . $i.',mac=' . incMac($this->createFirstMac(), $i) . ',bus=pci_bridge8,addr=0x' . sprintf("%02x\n",$a)  ;
                     } 
                else if  ($i <= 283 ) 
                     do {
                    $flags = '-device %NICDRIVER%,netdev=net' . $i.',mac=' . incMac($this->createFirstMac(), $i) . ',bus=pci_bridge8,addr=0x' . sprintf("%02x\n",$l) ;  
                    $l++;
                     } while ($l <= 0) ;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////pci_bridge9
                else if  ($i == 284 ) 
                     {
                    $flags = ' -device pci-bridge,id=pci_bridge9,bus=dmi_pci_bridge,chassis_nr=0x1,addr=0x9,shpc=off ' . ' -device %NICDRIVER%,netdev=net' . $i.',mac=' . incMac($this->createFirstMac(), $i) . ',bus=pci_bridge9,addr=0x' . sprintf("%02x\n",$a)  ;
                     } 
                else if  ($i <= 315 ) 
                     do {
                    $flags = '-device %NICDRIVER%,netdev=net' . $i.',mac=' . incMac($this->createFirstMac(), $i) . ',bus=pci_bridge9,addr=0x' . sprintf("%02x\n",$m) ;  
                    $m++;
                     } while ($m <= 0) ;
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $flags .= ' -netdev tap,id=net' . $i . ',ifname=vunl' . $this->getSession() . '_' . $i . ',script=no';
                
                if ($i == 0) {
                    $n = 'Mgmt1';           // Interface name
                } else {
                    $n = 'Eth' . $i;          // Interface name
                }

                try {
                    $ethernets[$i] = new Interfc( $this, array('name' => $n, 'type' => 'ethernet', 'flag' => $flags), $i);
                } catch (Exception $e) {
                    error_log(date('M d H:i:s ') . 'ERROR: ' . $GLOBALS['messages'][40020]);
                    error_log(date('M d H:i:s ') . (string) $e);
                    return false;
                }
             
            }else {
                $ethernets[$i] = $this->ethernets[$i];
            }
            // Setting CMD flags (virtual device and map to TAP device)
        }
        $this->ethernets = $ethernets;
        return $this->ethernets; 
 }


    public function prepare()
    {
        $result = parent::prepare();
        if ($result != 0) return $result;

        if (is_file($this->getRunningPath() . '/startup-config') && !is_file($this->getRunningPath() . '/.configured')) {
            $diskcmd = '/opt/unetlab/scripts/veos_diskmod.sh ' . $this->getRunningPath();
            exec($diskcmd, $o, $rc);
        }

        return 0;
    }
}
