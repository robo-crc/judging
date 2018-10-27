<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Announce extends CI_Controller
{

    /**
     * @var string $from_address
     * @var string $from_name
     * @var string $reply_to Reply-to address
     * @var string $url URL of the front page of the live application
     */
    private $from_address = "NOREPLY@robo-crc.ca";
    private $from_name = "PERSON\nCRC Robotics (Co-Ordinator Emeritus)\nJudges Liaison";
    private $reply_to = "NOREPLY@robo-crc.ca";
    private $url = "http://robotics.no-ip.ca";

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('email');
        $this->load->library('email');
        $this->load->library('session');
        $this->lang->load('strings', 'english');
        $this->load->model('announce_model');
        $this->load->model('main_model');

        // Enable profiling during development
        if ($this->session->userdata('judge_id') == 0 || $this->session->userdata('judge_id') == 1) {
            $this->output->enable_profiler(TRUE);
        }
    }

    /**
     *
     */
    public function index()
    {
        redirect('welcome');
    }

    public function result($component = null)
    {
        // Only root can announce.
        if ($this->session->userdata('judge_id') != 0 || $this->session->userdata('judge_id') != 1) {
            header('HTTP/1.0 403 Forbidden');
        }

        $data = $this->main_model->get_overall($component);
        $judges = $this->announce_model->get_judges();
        $i = $j = 0;
        die("Scores already sent.");
        foreach ($data as $id => $score) {
            if (isset($score->score)) {
                //$result_link = sprintf('<a href="/results/team_report?c=%s&s=%s&p=%s&r=%s&k=%s">Results</a>', $component, $id, isset($score->score) ? $i : 0, $j, $score->result_key);
                $result_url = sprintf('http://robotics.no-ip.ca/results/team_report?c=%s&s=%s&p=%s&r=%s&k=%s', $component, $id, isset($score->score) ? $i : 0, $j, $score->result_key);
                $pattern = 'To: %s<br\>subject=CRC %s Scoring<br/>Hi %s ! Here is the scoring for your %s submission: %s \n\n Thank you!';
                $email = sprintf($pattern, $score->contact_email, $component, $score->contact_name, $component, $result_url);

                $this->email->clear();

                $this->email->from($this->from_address, $this->from_address);
                $this->email->reply_to($this->reply_to, $this->from_name);
                $this->email->to($score->contact_email);
                $this->email->subject("CRC Robotics Judging for " . $component);
                $message = "Hi " . $score->contact_name . " !\n";
                $message .= "Here is the judge's score card for your CRC Converto 2018 " . $component . " submission: \n";
                $message .= $result_url . "\n\n";
                $message .= "On behalf of the entire CRC community, thank you for participating, and we hope to see you again in 2017 !";
                $message .= "\n\nMake sure you use that EXACT link; it is unique and contains a code for each team.";
                $message .= "\n\n --JUDGE LIASON--";

                $this->email->message($message);
                echo "<pre>";
                var_dump($this->email);

                //$this->email->send();

                echo $this->email->print_debugger();
            } else {
                echo "ID " . $id . " SKIPPED FOR HAVING NO SCORE";
            }
        }

    }

    /**
     *  Sends emails to judges with their PIN and the URL of the judging app.
     */
    public function hello()
    {
        // Authenticate the user
        if (!$this->session->userdata('validated')) {
            redirect('login');
        }

        // Only root can announce.
        if ($this->session->userdata('judge_id') != 0 || $this->session->userdata('judge_id') != 1) {
            header('HTTP/1.0 403 Forbidden');
        }

        $judges = $this->announce_model->get_judges();

        foreach ($judges as $judge) {
            $this->email->clear();

            $this->email->from($this->from_address, $this->from_name);
            $this->email->reply_to($this->reply_to, $this->from_name);
            $this->email->to($judge['email']);
            $this->email->subject("CRC Robotics Judging: Converto 2018!");

            $message = 'Hello ' . $judge['firstname'] . ",\n";
            $message .= "We are reaching out to you because you have been a judge for the Robotique CRC Robotics competition's web/video submissions in previous years.\n";

            $message .= "As we indicated last year, we have kept you on our list and hope very much that you will be able to contrinute your talent and experiecne for the CRC's Converto 2018 competiton!\n\n";

            $message .= "Judging begins the morning of January 19 and must be completed by February 1. We will send instructions (exactly the same as previous years) by January 15th.\n\n";

            $message .= "If circumstances have changed and you are no longer able, we understand. Please reply to this email and ask to be removed from the list.\n\n";

            $message .= "If you have any questions, simply reply to this email and I will do my best to help.\n";
            $message .= "(A real person monitors this email address.)\n\n";

            $message .= "Finally, happy holidays from all of us at Robotique CRC Robotics!\n\n";

            $message .= "Sincerely,\n";
            $message .= $this->from_name;

            $this->email->message($message);

            echo "<pre>";
            var_dump($message);
            echo "</pre>";

            //$this->email->send();

            echo $this->email->print_debugger();
        }
    }


    /**
     *  Sends emails to judges with their PIN and the URL of the judging app.
     */
    public function judges()
    {
        // Authenticate the user
        if (!$this->session->userdata('validated')) {
            redirect('login');
        }

        // Only root can announce.
        if ($this->session->userdata('judge_id') != 0 || $this->session->userdata('judge_id') != 1) {
            header('HTTP/1.0 403 Forbidden');
        }

        $judges = $this->announce_model->get_judges();

        foreach ($judges as $judge) {
            $this->email->clear();

            $this->email->from($this->from_address, $this->from_name);
            $this->email->reply_to($this->reply_to, $this->from_name);
            $this->email->to($judge['email']);
            $this->email->subject("CRC Robotics Judging: Converto 2018!");

            $message = 'Hello ' . $judge['firstname'] . ",\n";
            $message .= "Thank you for being agreeing to judge this year's CRC Robotics web sites and videos!\n";
            $message .= "As indicated last year, we have kept you on our list and hope you will be able to contrinute your talent and experiecne for the CRC Robotics Converto 2018 competiton!";

            $message .= "If circumstances have changed and you are no longer able, we understand. But know that this year we have fewer submissions, so judging will be quicker.";
            $message .= "Before judging, please consult the rule book so that you may understand specifically \n";
            $message .= "what we have asked of the students. It is available in English and French here:\n http://www.robo-crc.ca/\n\n";
            $message .= "(Nothing has changed from last year.) \n";

            $message .= "You can familiarize yourself with the judging tool with our screencast, here http://www.youtube.com/watch?v=B1o5f-Z2hOU \n\n";

            $message .= "Video judges: the intro sequence doesn't count toward the total time limit for the video.\n\n";

            $message .= 'You may connect to the site at ' . $this->url . ' with this email address and your PIN: ' . $judge['pin'] . "\n\n";

            $message .= "The submissions *begin to arrive February 2* and you will have until February 14 to complete your judging. Please remember that *only the final ordering counts!*\n\n";

            $message .= "If you have any questions, simply reply to this email and I will do my best to help.\n";
            $message .= "(A real person monitors this email address.)\n\n";

            $message .= "Also please let me know if you no longer wish to be a judge this year and in future years, and we will remove you from the judges list.\n\n";

            $message .= "Sincerely,\n";
            $message .= $this->from_name;

            $this->email->message($message);

            //var_dump($message);

            //$this->email->send();

            echo $this->email->print_debugger();
        }
    }

    public function instructions()
    {
        // Authenticate the user
        if (!$this->session->userdata('validated')) {
            redirect('login');
        }

        // Only root can announce.
        if ($this->session->userdata('judge_id') != 0 || $this->session->userdata('judge_id') != 1) {
            header('HTTP/1.0 403 Forbidden');
        }

        $judges = $this->announce_model->get_judges();

        foreach ($judges as $judge) {
            $this->email->clear();

            $this->email->from($this->from_address, $this->from_name);
            $this->email->reply_to($this->reply_to, $this->from_name);
            $this->email->to($judge['email']);
            $this->email->subject("CRC Robotics Judging Instructions & Tips");

            $message = 'Hello ' . $judge['firstname'] . ",\n\n";
            $message .= "We value greatly your input and contribution, and thank you for your interest in judging this year's competition,\n";
            $message .= "CRC Robotics Converto 2018 !\n\n";

            $message .= "REMINDERS:\n";
            $message .= "- The deadline is February 1st (the competition starts soon after):\n";
            $message .= "- For a tutorial on how the judging system works: http://www.youtube.com/watch?v=B1o5f-Z2hOU \n\n";
            $message .= "- The individual judging forms you fill out, including comments, are visible\n";
            $message .= "  to students. They appreciate constructive feedback, so please don't be shy!\n\n";
            $message .= "- Check out the rule book's sections that you are judging: \n\n";
            $message .= "  In English here:\nhttp://robo-crc.ca/wp-content/uploads/2017/11/2018_Converto_EN_KickoffRelease.pdf\n\n";
            $message .= "  En français nhttp://robo-crc.ca/wp-content/uploads/2017/11/2018_Converto_FR_KickoffRelease.pdf\n\n";

            $message .= "Video judges: the intro sequence doesn't count toward the total time limit for the video.\n\n";
            $message .= "Note also that some teams use the YouTube Closed Captioing (the [CC] button) for translation, which is acceptable. Please remember to check if there are subtitles before failing them for lacking bilingual content.\n\n";

            $message .= "You may connect to the site at \n" . $this->url . " with this email address \n and your PIN: " . $judge['pin'] . "\n\n";

            $message .= "If you have any questions, or if you have recevied this message in error, please write to me at NOREPLY@robo-crc.ca and I will do my best to help.\n\n";
            $message .= "(A real person monitors this email address.)\n\n";
            $message .= "Sincerely,\n--JUDGE LIASON--\nNOREPLY@robo-crc.ca";

            $this->email->message($message);
            //$this->email->send();

            echo $this->email->print_debugger();
        }
    }

    public function reminder()
    {
        // Authenticate the user
        if (!$this->session->userdata('validated')) {
            redirect('login');
        }

        // Only root can announce.
        if ($this->session->userdata('judge_id') != 0 || $this->session->userdata('judge_id') != 1) {
            header('HTTP/1.0 403 Forbidden');
        }

        $judges = $this->announce_model->get_judges();

        foreach ($judges as $judge) {
            $this->email->clear();

            $this->email->from($this->from_address, $this->from_name);
            $this->email->reply_to($this->reply_to, $this->from_name);
            $this->email->to($judge['email']);
            $this->email->subject("CRC Robotics Judging Reminder");

            $message = 'Hello ' . $judge['firstname'] . ",\n\n";
            $message .= "You are receiving this email because you are a judge for CRC Robotics Converto 2018\n";
            $message .= "robotics competition.\n\n";

            $message .= "This is a friendly reminder that we need your individual entries AND overall rankings in the next two days\n";
            $message .= "so that we can compile results in time for the competition.\n\n";

            $message .= "If you have already completed your individual and overall rankings, please accept our sincere thanks\n";
            $message .= "and disregard this message.\n\n";

            $message .= "We value your contribution greatly.\n\n";

            $message .= "REMINDERS:\n";
            $message .= "- For a tutorial on how the judging system works: http://www.youtube.com/watch?v=B1o5f-Z2hOU \n\n";
            $message .= "- The individual judging forms you fill out, including comments, are visible\n";
            $message .= "  to students. They appreciate constructive feedback, so please don't be shy!\n\n";
            $message .= "- Check out the rule book's sections that you are judging: \n\n";
            $message .= "  In English and French here:\n http://www.robo-crc.ca/en/update-to-the-rulebook/\n\n";

            $message .= "Video judges: the intro sequence doesn't count toward the total time limit for the video.\n\n";

            $message .= "You may connect to the site at \n" . $this->url . " with this email address \n and your PIN: " . $judge['pin'] . "\n\n";

            $message .= "If you have any questions, simply reply to this email and I will do my best to help.\n\n";
            $message .= "(A real person monitors this email address.)\n\n";
            $message .= "Sincerely,\n--JUDGE LIASON--\nNOREPLY@robo-crc.ca";

            $this->email->message($message);

            //$this->email->send();

            echo $this->email->print_debugger();
        }
    }

    public function thanks()
    {
        // Authenticate the user
        if (!$this->session->userdata('validated')) {
            redirect('login');
        }

        // Only root can announce.
        if ($this->session->userdata('judge_id') != 0 || $this->session->userdata('judge_id') != 1) {
            header('HTTP/1.0 403 Forbidden');
        }

        $judges = $this->announce_model->get_judges();

        foreach ($judges as $judge) {
            $this->email->clear();

            $this->email->from($this->from_address, $this->from_name);
            $this->email->reply_to($this->reply_to, $this->from_name);
            $this->email->to($judge['email']);
            $this->email->subject("Thank you from the CRC !");

            $message = 'Hello ' . $judge['firstname'] . ",\n\n";

            $message .= "You are receiving this email because you are a judge for CRC Robotics Converto 2018\n";
            $message .= "robotics competition.\n\n";

            $message .= "On behalf of all the CRC Committee Organizers and competing teams, we would like to";
            $message .= "extend a heartfelt thank you for contributing your time and effort to making this experience";
            $message .= "enjoyable and worthwhile for the competitors. Your valuable feedback will help them improve";
            $message .= "their entries for next year.\n\n";

            $message .= "By default, We will keep you on file for next year. If you would rather we not retain your";
            $message .= "information, simply reply to this email and let me know, and I'll remove you.\n\n";
            $message .= "(A real person monitors this email address.)\n\n";

            $message .= "Sincerely,\n--JUDGE LIASON--\nNOREPLY@robo-crc.ca";

            $this->email->message($message);

            //$this->email->send();

            echo $this->email->print_debugger();
        }
    }
}
