<?PHP
    namespace Segs;

    class Passwords
    {
        public function __construct()
        {
            die('Tools');

        }

        public static function password_is_vulnerable($pw, $score = FALSE)
        {
            $CRACKLIB = "/path/to/cracklib-check";
            $PWSCORE  = "/path/to/pwscore";

            // prevent UTF-8 characters being stripped by escapeshellarg
            setlocale(LC_ALL, 'en_US.utf-8');

            $out = [];
            $ret = NULL;
            $command = "echo " . escapeshellarg($pw) . " | {$CRACKLIB}";
            exec($command, $out, $ret);
            if(($ret == 0) && preg_match("/: ([^:]+)$/", $out[0], $regs))
            {
                list(, $msg) = $regs;
                switch($msg)
                {
                    case "OK":
                    if($score)
                    {
                        $command = "echo " . escapeshellarg($pw) . " | {$PWSCORE}";
                        exec($command, $out, $ret);
                        if(($ret == 0) && is_numeric($out[1]))
                        {
                            return (int) $out[1]; // return score
                        }
                        else
                        {
                            return FALSE; // probably OK, but may be too short, or a palindrome
                        }
                    }
                    else
                    {
                        return FALSE; // OK
                    }
                    break;
                    default:
                        $msg = str_replace("dictionary word", "common word, name or pattern", $msg);
                        return $msg; // not OK - return cracklib message
                }
            }
            return FALSE; // possibly OK
        }

    }