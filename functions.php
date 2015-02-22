<?php
	function get_comments($file_id) {
		include 'database.php';

		$result = mysqli_query($connect, "SELECT * FROM `comments` WHERE `file_id`='$file_id' AND `is_child`=FALSE ORDER BY `date` DESC");
		$row_cnt = mysqli_num_rows($result);

		echo '<h1>Comments ('.$row_cnt.')</h1>';
		echo '<div class="comment">';
			new_comment();
		echo '</div>';

		foreach($result as $item) {
			$date = new dateTime($item['date']);
			$date = date_format($date, 'M j, Y | H:i:s');
			$auth = $item['author'];
			$par_code = $item['com_code'];

			$chi_result = mysqli_query($connect, "SELECT * FROM `comments` WHERE `par_code`='$par_code' AND `is_child`=TRUE");
			$chi_cnt = mysqli_num_rows($chi_result);

			echo '<div class="comment" name="'.$item['com_code'].'">'
					.'<span class="author">'.$auth.'</span><br />'
					.$item['comment'].'<br />'
					.'<span class="date">Posted: '.$date.'</span><br />';

					if($chi_cnt == 0) {
						echo '<span class="replies">No replies</span>'
							.'<span class="replies">&emsp;Reply</span>';
					} else {
						echo '<span class="replies">[+] '.$chi_cnt.' replies</span>'
							.'<span class="replies"&emsp;Reply</span>';
							add_comment($item['author'], $item['com_code']);
						echo '<div name="children" id="children">';
						foreach($chi_result as $com) {
							$chi_date = new dateTime($com['date']);
							$chi_date = date_format($chi_date, 'M j, Y | H:i:s');

							echo '<div class="child" name="'.$com['com_code'].'">'
									.'<span class="author">'.$com['author'].'</span><br />'
									.$com['comment'].'<br />'
									.'<span class="date">Posted: '.$chi_date.'</span><br />'
								.'</div>';
						}
						echo '</div>';
					}
				echo '</div>';
		}
		mysqli_close($connect);
	}

	function add_comment($reply, $code) {
		echo '<form action="reply.php" method="post" enctpye="" name="new_comment">'
				.'<input type="hidden" name="par_code" value="'.$code.'" />'
				.'<textarea class="text_cmt" name="text_cmt" placeholder="Reply to '.$reply.'"></textarea><br />'
				.'<input type="submit" value="Reply" />'
			.'</form>';
	}

	function new_comment() {
		echo '<form action="new.php" method="post" enctpye="" name="new_comment">'
				.'<textarea class="text_cmt" name="text_cmt" placeholder="Post a new comment"></textarea><br />'
				.'<input type="submit" value="Post" />'
			.'</form>';
	}

	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$characterLength = strlen($characters);
		$randomString = '';

		for($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $characterLength - 1)];
		}
		return $randomString;
	}
	function checkString($com_code) {
		include 'database.php';

		$rand = generateRandomString();
		$result = mysqli_query($connect, "SELECT * FROM `comments` WHERE `com_code`='$com_code'");
		$row_cnt = mysqli_num_rows($result);

		if($row_cnt != 0) {
			return $rand;
		} else {
			checkString($rand);
		}
	}
?>