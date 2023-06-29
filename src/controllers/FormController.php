<?php

namespace leon\craftsimpleform\controllers;
use c10d\crafthcaptcha\CraftHcaptcha;
use Craft;
use craft\mail\Message;
use craft\web\Controller;
use yii\base\InvalidConfigException;

class FormController extends Controller
{
    protected array|bool|int $allowAnonymous = true;

    /**
     * @throws InvalidConfigException
     */
    public function actionContactForm()
    {
        $data = Craft::$app->getRequest()->getBodyParams();
        if (!isset($data)) return;



        $recipient = "0xc0ffee@scribble-workspace.de"; // *change this in Production * Haupt Form E-Mail //


        $subject = "[SimpleForm] E-Mail Test";
        /* HoneyPot */
        if(!empty($data['real-email']) | !empty($data['real-telephone'])) {
            $response['message'] = "Honeypot Triggered!";
            $response['success'] = false;
            return $this->asJson($response);
        }
        // check if hCaptcha is set and verify
        if (!CraftHcaptcha::$plugin->hcaptcha->verify($data['h-captcha-response'])) {
            $response['success'] = false;
            $response['message'] = "Captcha Solving failed!";
            return $this->asJson($response);
        }


        if (!isset($data["datenschutz"]))  {
            $response['success'] = false;
            $response['message'] = "Datenschutz nicht zugestimmt!";
            return $this->asJson($response);
        }

            $result = "";
            foreach ($data as $key => $value) {
                $excludedKeys = ['CRAFT_CSRF_TOKEN', 'betreff', 'real-email', 'real-telephone', 'g-recaptcha-response', 'h-captcha-response', 'tiktok', 'datenschutz'];
                if (!in_array($key, $excludedKeys) && !empty($value)) {
                    $key = str_replace("_", " ", $key);
                    $result .= '<p><strong>' . ucfirst($key) . '</strong>: ' . $value . '</p>';
                }
            }
            $result .= "<b>Datenschutz akzeptiert</b>";

            if ($this->sendMail($result, $subject, $recipient)) {
                $response['success'] = true;
            } else {
                $response['success'] = false;
                $response['error'] = "Mail didn't send.";
            }

            return $this->asJson($response);
        }

    /**
     * @param string $html
     * @param string $subject
     * @param array|string|\craft\elements\User $recipient
     * @param array $files
     *
     * @return bool
     * @throws InvalidConfigException
     */
    private function sendMail(string $content, string $subject, $recipient, $replyTo = false): bool
    {
        $mailer = Craft::$app->getMailer();
        $email = new Message();
        $email->setTo($recipient);
        $email->setSubject($subject);
        $email->setHtmlBody($content);
        if ($replyTo != false) {
            $email->setReplyTo($replyTo);
        }

        return $mailer->send($email);
    }
}