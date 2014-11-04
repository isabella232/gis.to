<?php

// namespace App\Controller;

// use Silex\Application;
// use Symfony\Component\HttpFoundation\Request;
// use App\Component\Form;

class FeedbackController
{
    public function index()
	{
        $subjects = Core::$sql->dict('id', '*', DB . 'feedback_subject');

	    $html = '';
		$errors = array();

		$is_posted = request_int('is_posted');

		$jump_to = 'feedback_name';

		if ($is_posted) {
			if (! count($errors) && ! request_str('email')) {
		        $errors []= s('Пожалуйста, укажите адрес электронной почты.');
		        $jump_to = 'feedback_email';
		    }

		    if (! count($errors) && request_str('email') && ! filter_var(request_str('email'), FILTER_VALIDATE_EMAIL)) {
		    	$errors []= s('Пожалуйста, укажите корректный адрес электронной почты. Например: john@gmail.com');
		    	$jump_to = 'feedback_email';
		   	}

		    if (! count($errors) && ! request_str('message')) {
		        $errors []= s('Пожалуйста, укажите текст сообщения.');
		        $jump_to = 'feedback_message';
		    }

			if (! count($errors)) {

				core::$sql->insert(array(
					'name' => Core::$sql->s(request_str('name')),
					'email' => Core::$sql->s(request_str('email')),
                    'subject_id' => Core::$sql->s(request_str('subject_id')),
					'message' => Core::$sql->s(request_str('message')),
					'insert_stamp' => Core::$sql->i(Core::$time['current_time']),
                    'insert_ip_addr' => Core::$sql->s($_SERVER['REMOTE_ADDR']),
				), DB . 'feedback');

				$data = array(
					'{name}' => request_str('name'),
					'{email}' => request_str('email'),
					'{subject}' => $subjects[request_int('subject_id')]['title'],
					'{message}' => request_str('message'),
				);

				$message = str_replace(array_keys($data), array_values($data),
'Имя: {name}
Адрес электронной почты: {email}

Тема: {subject}

{message}


' . $_SERVER['REMOTE_ADDR'] . ' ' . date('r'));

				require_once(ROOT . '/src/App/Component/lib.mail.php');

				foreach (Core::$config['feedback_notification_emails'] as $email) {
					mail_send(request_str('name'), request_str('email'), $email,
						'skoroproverka.info - ' . $subjects[request_int('subject_id')]['title'], $message, false);
				}

				return go('/feedback/ok/');
			}
		}

		$html .= '<div class="row"><div class="col-md-8"><h2>'.s('Обратная связь').'</h2>';

		if (count($errors)) {
			$html .= '<div class="alert alert-danger"><p>' . escape($errors[0]) . '</p></div>';
		}

		$form = new Form('feedback', false, 'post');

		$html .= '<div class="well">'
			. $form->start()
			. $form->addVariable('is_posted', 1)
			. $form->addString('name', s('Имя'), $is_posted ? request_str('name') : '')
			. $form->addString('email', s('Адрес электронной почты'), $is_posted ? request_str('email') : '', array('is_required' => true))
			. $form->addSelect('subject_id', s('Тема'), $is_posted ? request_int('subject_id') : 1, array('data' => $subjects))
			. $form->addText('message', s('Сообщение'), $is_posted ? request_str('message') : '', array('is_required' => true, 'style' => 'height:200px'))
			. $form->submit(s('Отправить'))
			. '</div>';

		$html .= '<script> $(document).ready(function() { $("#' . $jump_to . '").focus(); }); </script>';

		$html .= '</div></div>';

        $counters = file_get_contents(dirname(__FILE__) . '/../../../config/counters.htm');

        return include(dirname(__FILE__) . '/../View/Common.php');
	}

	function ok() {
		$html = '';

		$html .= '<div class="row" style="margin-bottom:200px"><div class="col-md-8"><h2>'.s('Спасибо за письмо').'</h2>';

		$html .= '<p>'.s('Мы обязательно ответим в течение дня.').'</p>
			<p><a href="/">' . s('Перейти на главную') . '</a></p>
			</div></div>';

        $counters = file_get_contents(dirname(__FILE__) . '/../../../config/counters.htm');

        return include(dirname(__FILE__) . '/../View/Common.php');
	}
}
