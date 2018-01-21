<?php
fileLoader::load('exceptions/mzzCurlException');

class mzzCurl
{
    protected $ch = null;
    protected $closed = false;

    protected $url = null;
    protected $options = array();

    protected $stdOptions = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    );

    public function __construct($url = null)
    {
        if (!function_exists('curl_init')) {
			throw new mzzRuntimeException('Curl extension doesn\'t installed');
		}

        $this->ch = curl_init($url);
        $this->url = $url;

        foreach ($this->stdOptions as $name => $value) {
            $this->setOpt($name, $value);
        }
    }

    public function setOpt($name, $value)
    {
        $this->options[$name] = $value;
        curl_setopt($this->ch, $name, $value);
    }

    public function setOpts(Array $options)
    {
        foreach ($options as $name => $value) {
            $this->setOpt($name, $value);
        }
    }

    public function exec()
    {
        $verb = curl_exec($this->ch);
        if (curl_error($this->ch) !== '') {
            throw new mzzCurlException(curl_error($this->ch), curl_errno($this->ch));
        }

        return $verb;
    }

    public function post($post)
    {
        $this->setOpt(CURLOPT_POST, true);
        $this->setOpt(CURLOPT_POSTFIELDS, $post);
    }

    public function getInfo($info = null)
    {
        return ($info) ? curl_getinfo($this->ch, $info) : curl_getinfo($this->ch);
    }

    public function &getHandler()
    {
        return $this->ch;
    }

    public function close()
    {
        $this->closed = true;
        curl_close($this->ch);
    }

    public function __destruct()
    {
        if (!$this->closed) {
            $this->close();
        }
    }
}
?>