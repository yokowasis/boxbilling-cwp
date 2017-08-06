<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

class Server_Manager_Cwp extends Server_Manager
{
    public static function getForm()
    {
        return array(
            'label'     =>  'Centos Web Panel',
        );
    }

    public function getLoginUrl()
    {
        $host     = $this->_config['host'];
        return 'http://'.$host.':2030';
    }

    public function getResellerLoginUrl()
    {
        $host     = $this->_config['host'];
        return 'http://'.$host.':2030';
    }

    public function testConnection()
    {
        return TRUE;
    }

    public function synchronizeAccount(Server_Account $a)
    {
        $this->getLog()->info('Synchronizing account with server '.$a->getUsername());
        return $a;
    }

    public function createAccount(Server_Account $a)
    {
        if($a->getReseller()) {
            $this->getLog()->info('Creating reseller hosting account');
        } else {
            $this->getLog()->info('Creating shared hosting account');
            $a->setPassword('yoko');
            $host = $this->_config['host'];
            $ch = curl_init();
            $url = 'http://'.$host.':2030/api/?key='.$this->_config['password'].'&api=account_new&domain='.$a->getDomain().'&username='.$a->getUsername().'&password='.$a->getPassword().'&package=1&email=client@email.com&inode=10000&nofile=100&nproc=25';
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
            return $url.'-------'.$ch;
        }
    }

    public function suspendAccount(Server_Account $a)
    {
        if($a->getReseller()) {
            $this->getLog()->info('Suspending reseller hosting account');
        } else {
            $this->getLog()->info('Suspending shared hosting account');
        }
    }

    public function unsuspendAccount(Server_Account $a)
    {
        if($a->getReseller()) {
            $this->getLog()->info('Unsuspending reseller hosting account');
        } else {
            $this->getLog()->info('Unsuspending shared hosting account');
        }
    }

    public function cancelAccount(Server_Account $a)
    {
        if($a->getReseller()) {
            $this->getLog()->info('Canceling reseller hosting account');
        } else {
            $this->getLog()->info('Canceling shared hosting account');
        }
    }

    public function changeAccountPackage(Server_Account $a, Server_Package $p)
    {
        if($a->getReseller()) {
            $this->getLog()->info('Updating reseller hosting account');
        } else {
            $this->getLog()->info('Updating shared hosting account');
        }

        $p->getName();
        $p->getQuota();
        $p->getBandwidth();
        $p->getMaxSubdomains();
        $p->getMaxParkedDomains();
        $p->getMaxDomains();
        $p->getMaxFtp();
        $p->getMaxSql();
        $p->getMaxPop();

        $p->getCustomValue('param_name');
    }

    public function changeAccountUsername(Server_Account $a, $new)
    {
        if($a->getReseller()) {
            $this->getLog()->info('Changing reseller hosting account username');
        } else {
            $this->getLog()->info('Changing shared hosting account username');
        }
    }

    public function changeAccountDomain(Server_Account $a, $new)
    {
        if($a->getReseller()) {
            $this->getLog()->info('Changing reseller hosting account domain');
        } else {
            $this->getLog()->info('Changing shared hosting account domain');
        }
    }

    public function changeAccountPassword(Server_Account $a, $new)
    {
        if($a->getReseller()) {
            $this->getLog()->info('Changing reseller hosting account password');
        } else {
            $this->getLog()->info('Changing shared hosting account password');
        }
    }

    public function changeAccountIp(Server_Account $a, $new)
    {
        if($a->getReseller()) {
            $this->getLog()->info('Changing reseller hosting account ip');
        } else {
            $this->getLog()->info('Changing shared hosting account ip');
        }
    }
}
