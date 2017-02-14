<?php

namespace common\repositories;

use yii\base\Exception;
use common\models\ContactUsMessages;
use common\models\User;
use InvalidArgumentException;
use RuntimeException;

/**
 * Class ContactUsRepository
 *
 * @package common\repositories
 */
class ContactUsRepository
{
    /**
    * Create a new contact-us repository instance.
    * @param ContactUsMessages,User Models
    */
    public function __construct(ContactUsMessages $contact_us_messages,User $user)
    {
        $this->contact_us_messages = $contact_us_messages;
        $this->user = $user;
    }

    /**
    * @param params Request post
    * Store a newly created resource in storage.
    */
    public function createNewSupportMessage($request){
        if(null != $request){
            $this->contact_us_messages->receiver_id = $this->getAdminId()->id;
            $this->contact_us_messages->sender_id = \Yii::$app->user->id;
            $this->contact_us_messages->email = $request['email'];
            $this->contact_us_messages->subject = $request['subject'];
            $this->contact_us_messages->message = $request['message'];
            return $this->contact_us_messages->save();
        }
        throw new RuntimeException("Message does not created");

    }

    /**
    * @return admin id
    */
    private function getAdminId(){
        $authManager = \Yii::$app->authManager;

        return User::find()
            ->where(['in', 'id', $authManager->getUserIdsByRole('admin')])
            ->one();
    }

    /**
    * @return all contact form submissions from storage.
    */
    public function showMessages(){
        return $this->contact_us_messages->find()->where(['parent_id'=>null])->all();
    }

    /**
    * @return contact form specific message from storage.
    */
    public function showMessageById($id){
        return $this->contact_us_messages->find()
            ->where(['id'=>$id])
            ->orWhere(['parent_id' => $id])
            ->all();
    }

    /**
    * Reply new message and show converstations
    * @return contact form specific message from storage
    */
    public function showMessageByIdForReply($id){
        return $this->contact_us_messages->find()->where(['id'=>$id])->one();
    }

    /**
    * delete checked messages from storage.
    * @return new resourses from storage.
    */
    public function deleteChecked($data){
        $ids = [];
        foreach ($data as $item) {
            if($item['bool'] === true){
                array_push($ids, $item['id']);
            }
        }
        return \Yii::$app->db->createCommand()
        ->delete('contact_us_messages', array('in', 'id', $ids))
        ->execute();
    }

    /**
    * Send Reply Email,use admin-dashboard email template
    * @return boolean
    */
    public function SendReplyEmail($email_data,$message){
        $data['id'] = $email_data['id'];
        $data['receiver_id'] = $email_data['receiver_id'];
        $data['sender_id'] = $email_data['sender_id'];
        $data['email'] = $email_data['email'];
        $data['subject'] = $email_data['subject'];
        $data['message'] = $message;
        try {
            $subject = $email_data['subject'];
           \Yii::$app->mailer->compose('admin-dashboard-html',[
                'content' => $data,
            ])
           ->setFrom(\Yii::$app->config->get('App.ContactEmail'))
           ->setTo($data['email'])
           ->setSubject($subject)
           ->send();
           return $this->createNewReplySupportMessage($data);
        } catch (RuntimeException $e) {
            return $e->getMessage();
        }
    }

    /**
    * Create a new Support Message data with Parent
    * @return boolean
    */
    private function createNewReplySupportMessage($data){
        if(null != $data){
            $this->contact_us_messages->receiver_id = $data['receiver_id'];
            $this->contact_us_messages->parent_id = $data['id'];
            $this->contact_us_messages->sender_id = $data['sender_id'];
            $this->contact_us_messages->email = $data['email'];
            $this->contact_us_messages->subject = $data['subject'];
            $this->contact_us_messages->message = $data['message'];
            return $this->contact_us_messages->save();
        }
        throw new RuntimeException("Message does not created");
    }

    /**
    * Compose new Email,use admin-dashboard email template
    * @return boolean
    */
    public function sendEmail($email_data){
        $data['id'] = null;
        $data['receiver_id'] = $this->user->find()->where(['email'=> $email_data['to']])->one()->id;
        $data['sender_id'] = $this->getAdminId()->id;
        $data['email'] = $email_data['to'];
        $data['subject'] = $email_data['subject'];
        $data['message'] = $email_data['message'];
        try {
            $subject = $email_data['subject'];
           \Yii::$app->mailer->compose('compose-html',[
                'content' => $data,
            ])
           ->setFrom(\Yii::$app->config->get('App.ContactEmail'))
           ->setTo($data['email'])
           ->setSubject($subject)
           ->send();
           $this->createNewReplySupportMessage($data);
           return "Mail has been Successfuly Sended";
        } catch (RuntimeException $e) {
            return "Sorry error Occured";
        }
    }
}
