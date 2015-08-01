<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    public $Sensor_Err;
    public $Sensor_Stream;
    private $Sensor_Msg_Len;
    private $Sensor_Queue; // an internal queue of sensor messages read final
    private $Sensor_Exec; // record of the command used

    // enable the sensor access executable
    function __construct($SensorCommand, $MsgLen){
        parent::__construct();
        // flush the error message stream
        $this->Sensor_Err = '';

        /**
         * Record the output message size of the sensor access executable
         * NOTE - This assumes every message received has the exact same size
         * If that is not the case, record both the maximum and minimum sizes
         * for the messages
         */
        $this->Sensor_Msg_Len = $MsgLen;

        $this->Sensor_Exec = $SensorCommand;
    }

    /**
     * @param $MsgCount
     *
     * read one or more sensor messages. It retrieves a requested set of points and handles the full access
     * cycle via the executable. The executable, in effect handles both the sensor interface and raw data
     * translation details. In turn, the Sensor class can be used to expose the formatted sensor data to
     * a network request and optionally to perform additional processing.
     *
     * @return Array of the requested number of sensor messages
     */
    function Extract($MsgCount){
        // flush the internal sensor message queue
        $this->Sensor_Queue = '';

        // flush the error message stream
        $this->Sensor_Err = '';

        // provide the reuested number of sensor data messages to the command
        $cmd = $this->Sensor_Exec . ' ' . $MsgCount;

        // enable the command executable and its message output stream
        $this->Sensor_Stream = popen($cmd, "r");

        // if the command failed to be enabled ...
        if ($this->Sensor_Stream == false) {
            // return the error message
            $this->Sensor_Err .= "1." . $this->Sensor_Exec . " could not be enabled.";
            $this->Sensor_Err .= " Check first the file mode for this executable.";

            return $this->Sensor_Queue;
        }

        // read the number of messages requested
        $nxt = fread($this->Sensor_Stream, $MsgCount * $this->Sensor_Msg_Len);

        if ($nxt == false) {
            // record the message count at the time of t he error
            $this->Sensor_Err .= "\nFailed to read  sensor stream from " . $this->Sensor_Exec;
        } else {
            // store the received message
            $this->Sensor_Queue = $nxt;

            // close the command executable stream
            if (fclose($this->Sensor_Stream) == false) {
                $this->Sensor_Err .= "\nFailed to close the sensor stream from " . $this->Sensor_Exec;
            }
        }

        return $this->Sensor_Queue;

    }
}
