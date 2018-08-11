<?php
					// Get the file settings into an array.
					$lines =  file('../../../configuration/country_lang_deployed.ini');
					$lines2 = file('../../../configuration/country_lang_planned.ini');
					// Loop through our array
					echo '<option  style="background-color:orange;" value="">Deployed:</option>';
					foreach ($lines as $line_num => $line)
					{
						if($line_num % 2 == 0)
						{
							$word =  $line;
							$pos = strpos($word, '[');
							$pos1 = strrpos($word, ']');
							$word = substr($word, $pos+1, $pos1-$pos-1);
							echo '<option value="'.$word.'">';
						}
						else
						{
							$word =  $line;
							$pos = strpos($word, '"');
							$pos1 = strrpos($word, '"');
							$word = substr($word, $pos+1, $pos1-$pos-1);
							echo $word.'</option>';
						}
					}
					echo '<option  style="background-color:orange;" value="">Planned:</option>';
					// Loop through our array
					foreach ($lines2 as $line_num => $line)
					{
						if($line_num % 2 == 0)
						{
							$word =  $line;
							$pos = strpos($word, '[');
							$pos1 = strrpos($word, ']');
							$word = substr($word, $pos+1, $pos1-$pos-1);
							echo '<option value="'.$word.'">';
						}
						else
						{
							$word =  $line;
							$pos = strpos($word, '"');
							$pos1 = strrpos($word, '"');
							$word = substr($word, $pos+1, $pos1-$pos-1);
							echo $word.'</option>';
						}
					}
			  ?>