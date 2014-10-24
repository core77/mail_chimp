<?php
namespace Concrete\Package\MailChimp;

use BlockType;
use Package;

class Controller extends Package
{ 
    protected $pkgHandle = 'mail_chimp';
    protected $appVersionRequired = '5.7.0.4';
    protected $pkgVersion = '0.1';

    public function getPackageName() {
        return t("MailChimp");
    }
    
    public function getPackageDescription() {
        return t("Subscribe a list at MailChimp.com");
    }

    public function install() {
        $pkg = parent::install();
        $this->installBlocks($pkg);
    }

    private function installBlocks($pkg) {
        
        if (!BlockType::getByHandle('mail_chimp')) {
            BlockType::installBlockTypeFromPackage('mail_chimp', $pkg);
        }
    }
}
