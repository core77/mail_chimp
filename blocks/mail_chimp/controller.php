<?php  
namespace Concrete\Package\MailChimp\Block\MailChimp;

require("vendor/autoload.php");

use Concrete\Core\Block\BlockController;
use Concrete\Core\Validation\CSRF\Token;
use Concrete\Core\Form\Service\Validation;
use Drewm\MailChimp;

class Controller extends BlockController
{
    protected $btTable = 'btMailChimp';
    protected $btInterfaceWidth = "400";
    protected $btInterfaceHeight = "400";

    public function getBlockTypeName()
    {
        return t("MailChimp");
    }

    public function getBlockTypeDescription()
    {
        return t("Subscribe a list at MailChimp.com");
    }

    public function view()
    {
        $this->set('token', $this->getToken());
        //we don't use this
        //$this->set('listsTotal', $this->getMcListsTotal()); 
    }

    public function getToken() {
        $token = id(new Token)->generate('mail_chimp');

        return $token;
    }

    public function getMcApiKey()
    {
        //we hardcode this
        $key = '';

        return $key;
    }

    public function getMcListToSubscribe()
    {
        //we hardcode this
        $listId = '';

        return $listId;
    }

    // public function getMcListsTotal()
    // {
    //     $MailChimp = new MailChimp($this->getMcApiKey());
    //     $lists = $MailChimp->call('lists/list');
    //     $listsTotal = $lists['total'];

    //     return $listsTotal;
    // }

    public function action_mc_subscribe()
    {
        $valid = id(new Token)->validate('mail_chimp', $this->post('token'));
        if ($valid) {

            $val = new Validation;
            $val->setData($this->post());
            $val->addRequiredEmail('email', 'Please enter a valid email adress.');
            if ($val->test()) {
                    
                    $email = $this->post('email');

                    $MailChimp = new MailChimp($this->getMcApiKey());
                    $result = $MailChimp->call('lists/subscribe', array(
                            'id'                => $this->getMcListToSubscribe(),
                            'email'             => array('email'=>$email),
                            'merge_vars'        => array('FNAME'=>'', 'LNAME'=>''),
                            'double_optin'      => true,
                            'update_existing'   => true,
                            'replace_interests' => false,
                            'send_welcome'      => false,
                        ));

                    if ($result) {
                        $this->set('subscribed', true);
                    }

                    unset($result);

            } else {
                $errorArray = $val->getError()->getList(); 
                $this->set('errorArray', $errorArray); // send array to view
            }

        } else {
                die("Access Denied.");
        }

    }
}
