<?php
namespace App\Helpers;

class Stopwatch 
{
    protected $prev_end_time = 0;

    public function __construct()
    {
        $this->start_time = microtime(true);
        $style="
         <style>
         table.blueTable {
            border: 1px solid #1C6EA4;
            background-color: #EEEEEE;
            width: 60%;
            margin:0 auto;
            text-align: left;
            border-collapse: collapse;
          }
          table.blueTable td, table.blueTable th {
            border: 1px solid #AAAAAA;
            padding: 3px 2px;
          }
          table.blueTable tbody td {
            font-size: 13px;
          }
          table.blueTable tr:nth-child(even) {
            background: #D0E4F5;
          }
          table.blueTable thead {
            background: #1C6EA4;
            background: -moz-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
            background: -webkit-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
            background: linear-gradient(to bottom, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
            border-bottom: 2px solid #444444;
          }
          table.blueTable thead th {
            font-size: 15px;
            font-weight: bold;
            color: #FFFFFF;
            border-left: 2px solid #D0E4F5;
          }
          table.blueTable thead th:first-child {
            border-left: none;
          }
          
          table.blueTable tfoot {
            font-size: 14px;
            font-weight: bold;
            color: #FFFFFF;
            background: #D0E4F5;
            background: -moz-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
            background: -webkit-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
            background: linear-gradient(to bottom, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
            border-top: 2px solid #444444;
          }
          table.blueTable tfoot td {
            font-size: 14px;
          }
          table.blueTable tfoot .links {
            text-align: right;
          }
          table.blueTable tfoot .links a{
            display: inline-block;
            background: #1C6EA4;
            color: #FFFFFF;
            padding: 2px 8px;
            border-radius: 5px;
          }
        </style>";
        echo $style;
        echo '<table class="blueTable">';
        echo "<tr><th>📝Description</th><th>⌚Total Time</th> <th>📈 Delta</th>";
    }

    public function log($message)
    {
        $end_time = microtime(true) - $this->start_time;
        $delta = $end_time - $this->prev_end_time;
        $delta = number_format($delta,5);
        echo "<tr><td>".$message."</td><td>".$end_time."</td><td>".$delta."</td></tr>";
        $this->prev_end_time = $end_time;
    }

    public function stop()
    {   
        echo "</table>";
        die();
    }
}
