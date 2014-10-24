<?php  
namespace Concrete\Package\MailChimp\Block\MailChimp;

require("vendor/autoload.php");

use Concrete\Core\Block\BlockController;
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
        $this->set('listsTotal', $this->getMcListsTotal());
    }

    public function getMcApiKey()
    {
        //we hardcode this
        $key = '#your-API-key#';

        return $key;
    }

    public function getMcListToSubscribe()
    {
        //we hardcode this
        $listId = '#your-list-ID#';

        return $listId;
    }

    public function getMcListsTotal()
    {
        $MailChimp = new MailChimp($this->getMcApiKey());
        $lists = $MailChimp->call('lists/list');
        $listsTotal = $lists['total'];

        return $listsTotal;
    }

    public function action_mc_subscribe()
    {
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
    }
}
