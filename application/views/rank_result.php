<section id="content">
<!--
        <?php
        if ($flags)
        {
            echo '<section id="flags"><header>FLAGGED</header><ul>';
            foreach ($flags as $school)
            {
                echo sprintf('<li>%s</li>', $school);
            }
            echo "</ul></section>";
	}

	        /**
			*          * @var string $from_address
			*                   * @var string $from_name
			*                            * @var string $reply_to Reply-to address
			*                                     * @var string $url URL of the front page of the live application
			*                                              */
	        $from_address = "michael@robo-crc.ca";
	        $from_name = "CRC Robotics Judging";
		$reply_to = "michael@robo-crc.ca";
		$url = "http://robotics.no-ip.ca";

	            $this->load->helper('email');
	            $this->load->library('email');
		    $this->load->library('session');
	            $this->lang->load('strings', 'english');
	            $this->load->model('announce_model');

        ?>
-->
    <section id="results">
        <?php
            $this->table->set_caption(lang('result-table-caption') . " " . $component);
            $this->table->set_heading( array(
//                lang('result-table-school-rank'),
//                lang('result-table-school-id'),
                lang('result-table-school-name'),
                lang('result-table-school-score'),
                "Link",
            ));

            // A bit of a hack, don't judge me.
            $i = 31;
	    $j = 1;

            foreach ($schools as $id => $score)
	    {
		    if (isset($score->result_key)) {
		    $result_link = sprintf('<a href="/results/team_report?c=%s&s=%s&p=%s&r=%s&k=%s">Results</a>', $component, $id, isset($score->score) ? $i : 0, $j, $score->result_key);
		    $result_url = sprintf('http://robotics.no-ip.ca/results/team_report?c=%s&s=%s&p=%s&r=%s&k=%s', $component, $id, isset($score->score) ? $i : 0, $j, $score->result_key);

		    $pattern = 'To: %s<br\>subject=CRC %s Scoring<br/>Hi %s ! Here is the scoring for your %s submission: %s \n\n Thank you!';
		    $email = sprintf($pattern, $score->contact_email, $component, $score->contact_name, $component, $result_url);
/*
		    // HACK OMG YOU SHOULD HATE YOURSELF FOR THIS
		    $this->email->clear();

                    $this->email->from($from_address, $from_name);
                    $this->email->reply_to($reply_to, $from_name);
                    $this->email->to($score->contact_email);
                    $this->email->subject("CRC Robotics Judging for " . $component);

		    $message = "Hi " . $score->contact_name . " !\n";
		    $message .= "Here is the judgue's score card for your CRC Actimania 2015 " . $component . " submission: \n";
		    $message .= $result_url . "\n\n";
		    $message .= "On behalf of the entire CRC community, thank you for participating, and we hope to see you again in 2016 !";
		    $message .= "\n\n Michael Sanford";
		    $this->email->message($message);

		    //$this->email->send();

		    echo $this->email->print_debugger();
 */
                $this->table->add_row($score->name, $score->score, $result_link);
                //$this->table->add_row($score->name, $score->score, $result_link, $score->contact_name, $score->contact_email, $email);
		    $i--;$j++;
		    }
            }

            echo $this->table->generate();
        ?>
    </section>
</section>
