<?php
/*
	Custom extension of SFacebook made for PicPlay based on extra needs like an extended access_token

*/


Yii::import("ext.yii-facebook-opengraph.SFacebook");
Yii::import("ext.yii-facebook-opengraph.PPBaseFacebook");


class PPFacebook extends SFacebook
{

    public $_facebook;

    /**
     * @throws CException if the Facebook PHP SDK cannot be loaded
     * @return instance of Facebook PHP SDK class
     */
    protected function _getFacebook()
    {
        if (is_null($this->_facebook)) {
            if ($this->appId && $this->secret) {
                $this->_facebook = new PPBaseFacebook(
                    array(
                        'appId' => $this->appId,
                        'secret' => $this->secret,
                        'fileUpload' => $this->fileUpload
                    ));
            } else {
                if (!$this->appId)
                    throw new CException('Facebook application ID not specified.');
                elseif (!$this->secret)
                    throw new CException('Facebook application secret not specified.');
            }
        }
        if(!is_object($this->_facebook)) {
            throw new CException('Facebook API could not be initialized.');
        }
        return $this->_facebook;
    }


    /**
     * Sets a OAuth access token.
     *
     * @return void
     */
    public function setAccessToken($accessToken){
        return $this->_getFacebook()->setAccessToken($accessToken);
    }


    /**
     * Gets a OAuth access token.
     *
     * @return String the access token
     */
    public function getExtendedAccessToken(){
        return $this->_getFacebook()->getExtendedAccessToken();
    }


}

