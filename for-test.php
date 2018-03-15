<?php
//chdir(__FILE__);
require_once 'app/Mage.php';

umask(0);
Mage::app();

$txt = 'eJzFVMuOozoQ/RZk2iLcjYFkutkZ83AggSQ8DHhxfwCHREonYL7+OnTPIqMZaXSVVi9KxqbqnFNlV+0Dd9DW3sY/nG5b+fZcGxTmhNx9+TzzjbdbTMdza7MrsKsroOZwP3smh7KN0g8r5FIWRgGrxj1jKZy5Iy5An52xvYQ7wxu3C2/2LerVBKiQvD7Atu+gTk0Rh3lUIVHkBUFYEoOrVaMVPHSsZD7Z5wYhZTjM8dsCvT/N5rskpU4jqVPWxTRZ7RQXpu4VDPO/sG1yofTD2J9tTNf5KQ7PJjY8mQbe6iPX/Izr6senD4yDeNwtvCGmpvzEKbUHHHLS1/mwU7G6ozvbPrvxPjdbh12ww6btMbvh4g1uomyfi5wcLJaWFis3s17vefkr+9BPLryOJlX3Qq1drHJU3xVvkncgyY0bxFJvCLbNAWrrHIFA6VC6dbmasM1RW2eWqpkF5GqBbfQ19/QV/eGbiw17rH0cimsrl/ccnsq3/5q5sdHq9hTXueBHcVU9dUqsxzeTyO78ovz8Oj/zAvYFjRaarXwlIeoNCtwQpHxefXh2fXjquD3e2mN0Adalx1QsuOpXXuh6HCCYOLpoe/YDSySzshtSAznZ1FpZgVaZevOZr/aL+x68+kau4l2jrceplvpFqzP00hCRWAjuC2/cKf1sLQZe3PvElXEQbhKqX7CdmHid4cQhUqstE/TiX63x+qbw3NgHY1qCa+YvZRZU17RMnWS63LbWT98OFsx7xLHnGbicZ06T/sRRvRs6aVDJTILXrXSjlzU53+NzGiF++LUO0aRHruBUoE/9fVoeVukUL5U5nxhp22QoDlmnqT5hVLz/isOPM8671iQSK+WJZeEPPfo8D8B076t0/P08cM2t83g+5464CZwDLGshwdG9z5v/wym/gXP6Bk70DZx/mO9/zbnxF2///AffbZrh';
$txt = 'eJztVtuOozgQ/RZkt0XYhwGSzDQPK3FJIIZAh5sBP+wPYAjadCDw9VvQt+3eGWm16tG87EPJBtt1qspVx3XaGYN0sAInPvfH8f5zZQCdk2qcss8TR77vqXfrKp1dkZ5fkacM87/PxAAJwH6Sq4bH9u6O5bcTYyFZsF0uUBt1pr4hD7J1O66sZW9abCfkiZEXManammBPEXSfuLkq0iS1VXO0ZQ6j5OUkrlnGHPuUyLad7Yfl/DFVHz9Nlru0M+y5I/ZYTT1/+wBYpmdc0bCs7asyEWA/oc4it/CQnOm+U0zZGsOdtX3yNenMIv/6vIfQHb09rKyBesr4rCeT3umxz/iQDA9wFq/x+thGPW8TpVqzi7lm07GJejO9J4EbnRKR2LHGwkxjWbDYa32e/yBP9tsXXrgTxD2FsabgI8xzXvqPaLR7Ltsa5BCpyphIh0RFO7AD7MbjdjJ1rlZFpEHMNDRuV6au/px7+hn14SirgL2PPd2LazVuZh8+Fe/0c3gjkIrqTItE8EZcoabOvvY+Z/yx7u5gn1MkHU9Jm3ruStJh72jbkIPCLG0V9nxzSGc45Fxz/dZXjXtB2qU1PbHiUK88xZjuVOKvsaha9tUcNXF3sDvUsPqY7cdwirWPoz9dAt/DF1P3FfMQmb4OXLROtsjL2zK1DLqzvh1HI78rbQFzYq4pCeP3+OjgQ1254x0zOuQ82zDth3DcAAa5Rqv6Gq5CFbD6o2aPUqEpCDglZdY/sXW2WXinDJ/wHQT1C7pmSdFsi7v4BOcTz1V5/DEW7oRdQ3BPqL6mklNqtWEWb8MJqeGO3EJ50RFWZaTSPaslqBXmicePeniz6HmUSn801/7ka5r5ZA9eOAFNc22Ft+9zgqEc1+//L76rXEHrmGSFGFFjzJzzXzDHX4A5/QJM9Rdg/oDj/zVm4DSiCfZWXarYZe5FBs5VqVAJzaAm9Jd3nv3Jy7qlTtXQH+/tOdS/P1qNL9uW7xqHhCUmbdwVdnxMnf1sO9QO7nEZt0F5CRwiOi4ThRfagA/1+fVM6wsOgnTlIhWRMNtIAE63nInrV3zgiQZkkt76EfmFA6gzvz+RwM7y9i98dJfaE8yhB3BV6u1JXrMdY36W5sYD9ZIeapiYjQFrxgriNjqk9uH9Ufib/nOYzpxW+zNHwd2Iah2fg2y2S9RSkT/NS/XZN6XBxXaFPdGbwhB3npjwITzP/iHPmHuD5R6ovHCp75Tv/weOH776P78fEG+p5ILKA6FCQBwpeeNSSz7KSs0L3plgW+DgLFN5HudJlOabNkitL9ShZ6wzGZddfyyeeauIH8OMTtEu/zh2sH/usWSw70obMVFv20M8IaeSDjf5wq0zH0E8Ye1V3xVsbejho332uYL48lIZ5rhxZyDIuwngNUEPvgCb1xQ4EHoE6C8hh1vofVoGa3C/xbadewcJzue60eADVlCTX+nuJiPZ6k+r57HWFLNxW8DaQs6PdP96byTV2ZZ6fIQ+4qk3dF/eHNvmntaZsh1XxVaYjvXbSbYzXibqjIvG5TuCNYWDnuzFn+wV+xzKtgJ+tuZKQ7SZ7ysRSAwyrClzr8aLyigd+uU7+WqEDPaJl3wnf9M/9FW2uT/qZDzJ9EJ/mAtzPgqDF7eJl295+H9+QH7MsYHW5Q8o0VlO0+b3vwAaMxvq';

//echo "<pre>";
//print_r(soft_decode($txt));

$key = file_get_contents('licensekey.php');

$sss = soft_encode($key);

echo $sss;


function soft_decode($txt) {
    $from = array( '!', '@', '#', '$', '%', '^', '&', '*', '(', ')' );
    $to = array( 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j' );
    $txt = base64_decode( $txt );
    $txt = gzuncompress( $txt );
    $txt = str_replace( $from, $to, $txt );
    $txt = base64_decode( $txt );
    return $txt;
}

function soft_encode($txt) {
    $from = array( 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j' );
    $to = array( '!', '@', '#', '$', '%', '^', '&', '*', '(', ')' );
    $txt = base64_encode( $txt );
    $txt = str_replace( $from, $to, $txt );
    $txt = gzcompress( $txt );
    $txt = base64_encode( $txt );
    return $txt;
}
