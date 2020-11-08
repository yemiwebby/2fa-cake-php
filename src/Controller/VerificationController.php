<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\TwilioSMSVerificationService;
use Cake\Http\Cookie\Cookie;
use Cake\I18n\Time;

/**
 * Verification Controller
 *
 */
class VerificationController extends AppController
{

    public function index()
    {
        $this->request->allowMethod(['get', 'post']);

        $phoneNumber = $this
            ->Authentication
            ->getIdentity()
            ->getOriginalData()
            ->getPhoneNumber();

        $verificationService = new TwilioSMSVerificationService($phoneNumber);

        $requestMethod = $this->request->getMethod();

        if ($requestMethod === 'GET') {
            $verificationService->sendVerificationToken();
            $this->Flash->success(__('Please provide the token sent by SMS'));
        }

        if ($requestMethod === 'POST') {
            $token = $this->request->getData('token');
            if ($verificationService->isValidToken($token)) {
                $cookie = new Cookie('2-fa-passed', '1', new Time('+ 30 minutes'));
                $this->response = $this->response->withCookie($cookie);
                return $this->redirect(['controller' => 'Users', 'action' => 'index']);
            }
            $this->Flash->error(__('Invalid Token Provided. Please, try again.'));
        }
    }
}
