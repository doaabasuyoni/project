<?php

class Memcached
{
    const OPT_COMPRESSION = -1001;
    const OPT_SERIALIZER = -1003;
    const SERIALIZER_PHP = 1;
    const SERIALIZER_IGBINARY = 2;
    const SERIALIZER_JSON = 3;
    const OPT_PREFIX_KEY = -1002;
    const OPT_HASH = 2;   
    const HASH_DEFAULT = 0;
    const HASH_MD5 = 1;
    const HASH_CRC = 2;
    const HASH_FNV1_64 = 3;
    const HASH_FNV1A_64 = 4;
    const HASH_FNV1_32 = 5;
    const HASH_FNV1A_32 = 6;
    const HASH_HSIEH = 7;
    const HASH_MURMUR = 8;
    const OPT_DISTRIBUTION = 9;    
    const DISTRIBUTION_MODULA = 0;
    const DISTRIBUTION_CONSISTENT = 1;
    const OPT_LIBKETAMA_COMPATIBLE = 16;   
    const OPT_BUFFER_WRITES = 10;         
    const OPT_BINARY_PROTOCOL = 18;      
    const OPT_NO_BLOCK = 0;               
    const OPT_TCP_NODELAY = 1;             
    const OPT_SOCKET_SEND_SIZE = 4;         
    const OPT_SOCKET_RECV_SIZE = 5;         
    const OPT_CONNECT_TIMEOUT = 14;         
    const OPT_RETRY_TIMEOUT = 15;          
    const OPT_SEND_TIMEOUT = 19;            
    const OPT_RECV_TIMEOUT = 20;            
    const OPT_POLL_TIMEOUT = 8;           
    const OPT_CACHE_LOOKUPS = 6;           
    const OPT_SERVER_FAILURE_LIMIT = 21;    
    const HAVE_IGBINARY = 1;
    const HAVE_JSON = 1;
    const GET_PRESERVE_ORDER = 1;
    const RES_SUCCESS = 0;                 
    const RES_FAILURE = 1;                  
    const RES_HOST_LOOKUP_FAILURE = 2;     
    const RES_UNKNOWN_READ_FAILURE = 7;     
    const RES_PROTOCOL_ERROR = 8;          
    const RES_CLIENT_ERROR = 9;            
    const RES_SERVER_ERROR = 10;           
    const RES_WRITE_FAILURE = 5;            
    const RES_DATA_EXISTS = 12;             
    const RES_NOTSTORED = 14;               
    const RES_NOTFOUND = 16;                
    const RES_PARTIAL_READ = 18;           
    const RES_SOME_ERRORS = 19;            
    const RES_NO_SERVERS = 20;              
    const RES_END = 21;                     
    const RES_ERRNO = 26;                  
    const RES_BUFFERED = 32;                
    const RES_TIMEOUT = 31;                 
    const RES_BAD_KEY_PROVIDED = 33;        
    const RES_CONNECTION_SOCKET_CREATE_FAILURE = 11;    
    const RES_PAYLOAD_FAILURE = -1001;
    protected $option = array(
        Memcached::OPT_COMPRESSION  => true,
        Memcached::OPT_SERIALIZER   => Memcached::SERIALIZER_PHP,
        Memcached::OPT_PREFIX_KEY   => '',
        Memcached::OPT_HASH         => Memcached::HASH_DEFAULT,
        Memcached::OPT_DISTRIBUTION => Memcached::DISTRIBUTION_MODULA,
        Memcached::OPT_LIBKETAMA_COMPATIBLE => false,
        Memcached::OPT_BUFFER_WRITES    => false,
        Memcached::OPT_BINARY_PROTOCOL  => false,
        Memcached::OPT_NO_BLOCK     => false,
        Memcached::OPT_TCP_NODELAY  => false,
        Memcached::OPT_SOCKET_SEND_SIZE => 32767,
        Memcached::OPT_SOCKET_RECV_SIZE => 65535,
        Memcached::OPT_CONNECT_TIMEOUT  => 1000,
        Memcached::OPT_RETRY_TIMEOUT    => 0,
        Memcached::OPT_SEND_TIMEOUT     => 0,
        Memcached::OPT_RECV_TIMEOUT     => 0,
        Memcached::OPT_POLL_TIMEOUT     => 1000,
        Memcached::OPT_CACHE_LOOKUPS    => false,
        Memcached::OPT_SERVER_FAILURE_LIMIT => 0,
    );
    protected $resultCode = 0;
    protected $resultMessage = '';
    protected $server = array();
    protected $socket = null;
    protected $mem = array();
   function addServer($host, $port = 11211, $weight = 0)
    {
        $key = $this->getServerKey($host, $port, $weight);
        if (isset($this->server[$key])) {
            // Dup
            $this->resultCode = Memcached::RES_FAILURE;
            $this->resultMessage = 'Server duplicate.';
            return false;

        } else {
            $this->server[$key] = array(
                'host'  => $host,
                'port'  => $port,
                'weight'    => $weight,
            );

            $this->connect();
            return true;
        }
    }
  
    protected function connect()
    {
        $rs = false;

        foreach ((array)$this->server as $svr) {
            $error = 0;
            $errstr = '';
            $rs = @fsockopen($svr['host'], $svr['port'], $error, $errstr);

            if ($rs) {
                $this->socket = $rs;

            } else {
                $key = $this->getServerKey(
                    $svr['host'],
                    $svr['port'],
                    $svr['weight']
                );
                $s = "Connect to $key error:" . PHP_EOL .
                    "    [$error] $errstr";
                error_log($s);
            }
        }

        if (is_null($this->socket)) {
            $this->resultCode = Memcached::RES_FAILURE;
            $this->resultMessage = 'No server avaliable.';
            return false;

        } else {
            $this->resultCode = Memcached::RES_SUCCESS;
            $this->resultMessage = '';
            return true;
        }
    }

    public function delete($key)
    {
        $keyString = $this->getKey($key);
        $this->writeSocket("delete $keyString");

        $s = $this->readSocket();
        if ('DELETED' == $s) {
            $this->resultCode = Memcached::RES_SUCCESS;
            $this->resultMessage = '';
            return true;

        } else {
            $this->resultCode = Memcached::RES_NOTFOUND;
            $this->resultMessage = 'Delete fail, key not exists.';
            return false;
        }
    }

    public function get($key, $cache_cb = null, $cas_token = null)
    {
        $keyString = $this->getKey($key);
        $this->writeSocket("get $keyString");

        $s = $this->readSocket();

        if (is_null($s) || 'VALUE' != substr($s, 0, 5)) {
            $this->resultCode = Memcached::RES_FAILURE;
            $this->resultMessage = 'Get fail.';
            return false;

        } else {
            $s_result = '';
            $s = $this->readSocket();
            while ('END' != $s) {
                $s_result .= $s;
                $s = $this->readSocket();
            }
            $this->resultCode = Memcached::RES_SUCCESS;
            $this->resultMessage = '';

            return unserialize($s_result);
        }
    }
    public function getKey($key)
    {
        return addslashes($this->option[Memcached::OPT_PREFIX_KEY]) . $key;
    }
    public function getResultCode()
    {
        return $this->resultCode;
    }
    public function getResultMessage()
    {
        return $this->resultMessage;
    }
    protected function getServerKey($host, $port = 11211, $weight = 0)
    {
        return "$host:$port:$weight";
    }

    protected function readSocket()
    {
        if (is_null($this->socket)) {
            return null;
        }

        return trim(fgets($this->socket));
    }
    public function set($key, $val, $expt = 0)
    {
        $valueString = serialize($val);
        $keyString = $this->getKey($key);

        $this->writeSocket(
            "set $keyString 0 $expt " . strlen($valueString)
        );
        $s = $this->writeSocket($valueString, true);

        if ('STORED' == $s) {
            $this->mem[$keyString]=$valueString;
            $this->resultCode = Memcached::RES_SUCCESS;
            $this->resultMessage = '';
            return true;


        } else {
            
            $this->resultCode = Memcached::RES_FAILURE;
            $this->resultMessage = 'Set fail.';
            return false;
        }
    }
    protected function writeSocket($cmd, $result = false)
    {
        if (is_null($this->socket)) {
            return false;
        }

        fwrite($this->socket, $cmd . "\r\n");

        if (true == $result) {
            return $this->readSocket();
        }

        return true;
    }
    protected function clear(){

  foreach($this->mem as $keyString){
    $this->delete($keyString);
        
  }
    
}   

}
