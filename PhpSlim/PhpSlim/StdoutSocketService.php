<?php declare(strict_types=1);

class PhpSlim_StdoutSocketService extends PhpSlim_Socket {

    private $input = null;
    private $output = null;

    public function __construct() {}

    public function init() {
        $this->log("Init");
        $this->input = fopen('php://stdin', 'r');
        $this->output = fopen('php://stdout', 'w');
    }

    public function close() {
        fclose($this->input);
        fclose($this->output);
    }

    public function read($len) {
        $input = fread($this->input, $len);
        $this->log("Read: $input");
        return $input;
    }

    public function write($data, $len = null) {
        if (is_null($len)) {
            $len = strlen($data);
        }
        $this->log("Write: $data");
        $result = fwrite($this->output, $data, $len);
		fflush($this->output);
		return $result;
    }

    public function hasReadableData() {
        return !feof($this->input);
    }

}